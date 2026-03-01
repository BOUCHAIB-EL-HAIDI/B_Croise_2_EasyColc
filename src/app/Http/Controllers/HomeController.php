<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Settlement;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function welcome()
    {
        if (Auth::check()) {
            return redirect('/home');
        }
        return view('welcome');
    }

    public function index()
    {
        $user = Auth::user();
        $membership = $user->activeMembership;

        if (!$membership) {
            return view('home');
        }

        $colocation = $membership->colocation;

        $recentExpenses = Expense::where('colocation_id', $colocation->id)
            ->with(['category', 'payer'])
            ->orderBy('expense_date', 'desc')
            ->limit(5)
            ->get();

        $owedToMe = Settlement::where('creditor_id', $user->id)
            ->whereDoesntHave('payments', function($q) {
                $q->where('status', 'PAID');
            })
            ->sum('amount');
        
        $iOwe = Settlement::where('debtor_id', $user->id)
            ->whereDoesntHave('payments', function($q) {
                $q->where('status', 'PAID');
            })
            ->sum('amount');

        $netBalance = $owedToMe - $iOwe;

        $otherMembers = $colocation->memberships()
            ->where('is_active', true)
            ->where('user_id', '!=', $user->id)
            ->with('user')
            ->get();

        $memberBalances = [];
        foreach ($otherMembers as $member) {
            $owedByThemSettlements = Settlement::where('creditor_id', $user->id)
                ->where('debtor_id', $member->user_id)
                ->whereDoesntHave('payments', function($q) {
                    $q->where('status', 'PAID');
                })
                ->with('expense')
                ->get();
                
            $owedToThemSettlements = Settlement::where('creditor_id', $member->user_id)
                ->where('debtor_id', $user->id)
                ->whereDoesntHave('payments', function($q) {
                    $q->where('status', 'PAID');
                })
                ->with('expense')
                ->get();

            $owedByThem = $owedByThemSettlements->sum('amount');
            $owedToThem = $owedToThemSettlements->sum('amount');

            $balance = $owedByThem - $owedToThem;
            $status = '';
            $color = '';

            if ($balance > 0) {
                $status = "vous doit";
                $color = "emerald";
            } elseif ($balance < 0) {
                $status = "Vous devez à";
                $color = "rose";
            } else {
                $status = "À jour";
                $color = "gray";
            }

            $memberBalances[] = [
                'user' => $member->user,
                'balance' => abs($balance),
                'status' => $status,
                'color' => $color,
                'raw_balance' => $balance
            ];
        }

        $myDebts = Settlement::where('debtor_id', $user->id)
            ->whereDoesntHave('payments')
            ->with(['creditor', 'expense'])
            ->get();

        $pendingPaymentsToConfirm = \App\Models\Payment::whereHas('settlement', function($q) use ($user) {
                $q->where('creditor_id', $user->id);
            })
            ->where('status', 'PENDING')
            ->with(['settlement.debtor', 'settlement.expense'])
            ->get();

        // Assuming 'monthlySpending' and 'activeColocation' would be defined elsewhere
        // or are placeholders for future implementation based on the instruction.
        $monthlySpending = 0; // Placeholder
        $activeColocation = $colocation; // Placeholder, using existing $colocation

        return view('home', compact(
            'recentExpenses', 
            'memberBalances', 
            'monthlySpending', 
            'colocation',
            'myDebts',
            'pendingPaymentsToConfirm',
            'owedToMe',
            'iOwe'
        ));
    }

    public function showBalance(User $user)
    {
        $authUser = auth()->user();
        
        // Safety check: users must be in the same colocation
        $membership = $authUser->activeMembership;
        
        if (!$membership) {
            abort(403, 'Vous n\'avez pas de colocation active.');
        }

        $colocationId = $membership->colocation_id;
        
        $isSameColoc = Membership::where('colocation_id', $colocationId)
            ->where('user_id', $user->id)
            ->exists();

        if (!$isSameColoc) {
            abort(403, 'Vous ne faites pas partie de la même colocation.');
        }

        $owedByThem = Settlement::where('creditor_id', $authUser->id)
            ->where('debtor_id', $user->id)
            ->whereDoesntHave('payments', function($q) {
                $q->where('status', 'PAID');
            })
            ->with('expense')
            ->get();
            
        $owedToThem = Settlement::where('creditor_id', $user->id)
            ->where('debtor_id', $authUser->id)
            ->whereDoesntHave('payments', function($q) {
                $q->where('status', 'PAID');
            })
            ->with('expense')
            ->get();

        $netBalance = $owedByThem->sum('amount') - $owedToThem->sum('amount');

        return view('balances.show', compact('user', 'owedByThem', 'owedToThem', 'netBalance'));
    }
}

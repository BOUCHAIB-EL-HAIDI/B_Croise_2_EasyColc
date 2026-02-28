<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Settlement;
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

        // 1. Fetch 5 most recent expenses
        $recentExpenses = Expense::where('colocation_id', $colocation->id)
            ->with(['category', 'payer'])
            ->orderBy('expense_date', 'desc')
            ->limit(5)
            ->get();

        // 2. Calculate Balance (Only Unpaid/Pending Settlements)
        // Amount I am owed (I am the creditor)
        $owedToMe = Settlement::where('creditor_id', $user->id)
            ->whereDoesntHave('payments', function($q) {
                $q->where('status', 'PAID');
            })
            ->sum('amount');
        
        // Amount I owe (I am the debtor)
        $iOwe = Settlement::where('debtor_id', $user->id)
            ->whereDoesntHave('payments', function($q) {
                $q->where('status', 'PAID');
            })
            ->sum('amount');

        $netBalance = $owedToMe - $iOwe;

        // 3. Breakdown of who owes whom (Unpaid only)
        $otherMembers = $colocation->memberships()
            ->where('is_active', true)
            ->where('user_id', '!=', $user->id)
            ->with('user')
            ->get();

        $memberBalances = [];
        foreach ($otherMembers as $member) {
            $owedByThem = Settlement::where('creditor_id', $user->id)
                ->where('debtor_id', $member->user_id)
                ->whereDoesntHave('payments', function($q) {
                    $q->where('status', 'PAID');
                })
                ->sum('amount');
                
            $owedToThem = Settlement::where('creditor_id', $member->user_id)
                ->where('debtor_id', $user->id)
                ->whereDoesntHave('payments', function($q) {
                    $q->where('status', 'PAID');
                })
                ->sum('amount');

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

        // 4. Detailed Debts for Dashboard actions
        // Settlements where I am DEBTOR and haven't sent a payment yet
        $myDebts = Settlement::where('debtor_id', $user->id)
            ->whereDoesntHave('payments')
            ->with(['creditor', 'expense'])
            ->get();

        // Payments where I am CREDITOR and status is PENDING (waiting for MY confirmation)
        $pendingPaymentsToConfirm = \App\Models\Payment::whereHas('settlement', function($q) use ($user) {
                $q->where('creditor_id', $user->id);
            })
            ->where('status', 'PENDING')
            ->with(['settlement.debtor', 'settlement.expense'])
            ->get();

        return view('home', compact(
            'recentExpenses', 
            'netBalance', 
            'membership', 
            'colocation', 
            'owedToMe', 
            'iOwe', 
            'memberBalances',
            'myDebts',
            'pendingPaymentsToConfirm'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $membership = $user->activeMembership;

        if (!$membership) {
            return redirect('/home')->with('error', 'Vous devez faire partie d\'une colocation.');
        }

        // Get all expenses for this colocation, ordered by date
        $expenses = Expense::where('colocation_id', $membership->colocation_id)
            ->with(['category', 'payer'])
            ->orderBy('expense_date', 'desc')
            ->get();

        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $user = Auth::user();
        $membership = $user->activeMembership;

        if (!$membership) {
            return redirect('/home')->with('error', 'Action non autorisée.');
        }

        // Get categories for the selection dropdown
        $categories = Category::where('colocation_id', $membership->colocation_id)->get();

        return view('expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $membership = $user->activeMembership;

        // Basic validation
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'expense_date' => 'required|date',
        ]);

        // 1. Create the expense
        $expense = Expense::create([
            'colocation_id' => $membership->colocation_id,
            'category_id' => $request->category_id,
            'payer_id' => $user->id,
            'title' => $request->title,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
        ]);

        // 2. Simple logic: Split with other members
        $members = $membership->colocation->memberships()->where('is_active', true)->get();
        $memberCount = $members->count();
        
        if ($memberCount > 1) {
            $splitAmount = $request->amount / $memberCount;
            
            foreach ($members as $member) {
                // We create a settlement for everyone EXCEPT the payer
                if ($member->user_id !== $user->id) {
                    \App\Models\Settlement::create([
                        'expense_id' => $expense->id,
                        'debtor_id' => $member->user_id,
                        'creditor_id' => $user->id,
                        'amount' => $splitAmount,
                    ]);
                }
            }
        }

        return redirect()->route('expenses.index')->with('success', 'Dépense ajoutée et partagée avec succès !');
    }
}

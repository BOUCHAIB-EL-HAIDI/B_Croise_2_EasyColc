<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $membership = $user->activeMembership;

        if (!$membership) {
            return redirect('/home')->with('error', 'Vous devez faire partie d\'une colocation.');
        }

        $query = Expense::where('colocation_id', $membership->colocation_id)
            ->with(['category', 'payer']);

        
        if ($request->filled('month')) {
            $query->whereRaw("TO_CHAR(expense_date, 'YYYY-MM') = ?", [$request->month]);
        }

        $expenses = $query->orderBy('expense_date', 'desc')->get();

        $totalAmount = $expenses->sum('amount');
        $statsByCategory = $expenses->groupBy('category_id')->map(function ($group) {
            return [
                'name' => $group->first()->category->name,
                'total' => $group->sum('amount'),
                'count' => $group->count()
            ];
        });

        return view('expenses.index', compact('expenses', 'totalAmount', 'statsByCategory'));
    }

    public function create()
    {
        $user = Auth::user();
        $membership = $user->activeMembership;

        if (!$membership) {
            return redirect('/home')->with('error', 'Action non autorisée.');
        }

        
        $categories = Category::where('colocation_id', $membership->colocation_id)->get();

        return view('expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $membership = $user->activeMembership;

        
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'expense_date' => 'required|date',
        ]);

        $expense = Expense::create([
            'colocation_id' => $membership->colocation_id,
            'category_id' => $request->category_id,
            'payer_id' => $user->id,
            'title' => $request->title,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
        ]);

        $members = $membership->colocation->memberships()->where('is_active', true)->get();
        $memberCount = $members->count();
        
        if ($memberCount > 1) {
            $splitAmount = $request->amount / $memberCount;
            
            foreach ($members as $member) {
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

    public function destroy(Expense $expense)
    {
        
        if ($expense->colocation_id !== Auth::user()->activeMembership->colocation_id) {
            return back()->with('error', 'Action non autorisée.');
        }

        $expense->delete(); 

        return redirect()->route('expenses.index')->with('success', 'Dépense supprimée définitivement.');
    }
}

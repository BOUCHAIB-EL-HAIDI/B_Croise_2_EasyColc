<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Colocation;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalColocations = Colocation::count();
        $users = User::orderBy('created_at', 'desc')->paginate(20);

        // Global Platform Stats
        $globalTotalExpenses = \App\Models\Expense::sum('amount');
        $platformStatsByCategory = \App\Models\Category::withSum('expenses', 'amount')
            ->orderBy('expenses_sum_amount', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalColocations', 
            'users', 
            'globalTotalExpenses', 
            'platformStatsByCategory'
        ));
    }

    public function banUser(User $user)
    {
        if ($user->is_global_admin) {
            return back()->with('error', 'Impossible de bannir un administrateur global.');
        }

        $user->update(['is_banned' => true]);
        return back()->with('success', "L'utilisateur {$user->name} a été banni.");
    }

    public function unbanUser(User $user)
    {
        $user->update(['is_banned' => false]);
        return back()->with('success', "L'accès a été rétabli pour l'utilisateur {$user->name}.");
    }
}

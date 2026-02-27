<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        if ($user->is_banned) {
            return redirect('/home')->with('error', 'Votre compte est banni. Vous ne pouvez pas créer de colocation.');
        }

        if ($user->activeMembership) {
            return redirect('/home')->with('error', 'Vous avez déjà une colocation active.');
        }

        return view('colocations.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->is_banned || $user->activeMembership) {
            return redirect('/home')->with('error', 'Action non autorisée.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $colocation = Colocation::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'active',
        ]);

        Membership::create([
            'user_id' => $user->id,
            'colocation_id' => $colocation->id,
            'role' => 'owner',
            'is_active' => true,
            'joined_at' => now(),
        ]);

        return redirect('/home')->with('success', 'Colocation créée avec succès !');
    }

    public function cancel(Colocation $colocation)
    {
        $user = Auth::user();

        $membership = $user->activeMembership;
        if (!$membership || $membership->colocation_id !== $colocation->id || $membership->role !== 'owner') {
            return redirect('/home')->with('error', 'Action non autorisée.');
        }

        $colocation->update(['status' => 'cancelled']);

        $colocation->memberships()->update([
            'is_active' => false,
            'left_at' => now()
        ]);

        return redirect('/home')->with('success', 'Colocation annulée avec succès.');
    }
}

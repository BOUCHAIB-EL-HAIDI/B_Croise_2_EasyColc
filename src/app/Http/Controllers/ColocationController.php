<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    /**
     * Show the form for creating a new colocation.
     */
    public function create()
    {
        $user = Auth::user();

        // Check if user is banned
        if ($user->is_banned) {
            return redirect('/home')->with('error', 'Votre compte est banni. Vous ne pouvez pas créer de colocation.');
        }

        // Check if user already has an active membership
        if ($user->activeMembership) {
            return redirect('/home')->with('error', 'Vous avez déjà une colocation active.');
        }

        return view('colocations.create');
    }

    /**
     * Store a newly created colocation in storage.
     */
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

        // Create the colocation
        $colocation = Colocation::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'active',
        ]);

        // Create the membership as owner
        Membership::create([
            'user_id' => $user->id,
            'colocation_id' => $colocation->id,
            'role' => 'owner',
            'is_active' => true,
            'joined_at' => now(),
        ]);

        return redirect('/home')->with('success', 'Colocation créée avec succès !');
    }

    /**
     * Cancel the specified colocation.
     */
    public function cancel(Colocation $colocation)
    {
        $user = Auth::user();

        // Check if user is the owner of this colocation
        $membership = $user->activeMembership;
        if (!$membership || $membership->colocation_id !== $colocation->id || $membership->role !== 'owner') {
            return redirect('/home')->with('error', 'Action non autorisée.');
        }

        // Cancel the colocation
        $colocation->update(['status' => 'cancelled']);

        // Deactivate all memberships for this colocation
        $colocation->memberships()->update([
            'is_active' => false,
            'left_at' => now()
        ]);

        return redirect('/home')->with('success', 'Colocation annulée avec succès.');
    }
}

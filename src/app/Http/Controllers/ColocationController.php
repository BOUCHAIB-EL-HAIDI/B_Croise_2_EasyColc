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

        // Process all active members to handle debts and reputations
        $activeMemberships = $colocation->memberships()->where('is_active', true)->get();
        foreach ($activeMemberships as $m) {
            $this->handleMemberDeparture($m);
        }

        return redirect('/home')->with('success', 'Colocation annulée avec succès.');
    }

    public function leave()
    {
        $user = Auth::user();
        $membership = $user->activeMembership;

        if (!$membership) {
            return back()->with('error', 'Vous n\'êtes pas dans une colocation.');
        }

        if ($membership->role === 'owner') {
            return back()->with('error', 'Le propriétaire ne peut pas quitter la colocation.');
        }

        $this->handleMemberDeparture($membership);

        return redirect('/home')->with('success', 'Vous avez quitté la colocation.');
    }

    public function removeMember(Membership $membership)
    {
        $currentUser = Auth::user();
        $currentMembership = $currentUser->activeMembership;

        if (!$currentMembership || $currentMembership->role !== 'owner') {
            return back()->with('error', 'Seul le propriétaire peut retirer des membres.');
        }

        if ($membership->colocation_id !== $currentMembership->colocation_id) {
            return back()->with('error', 'Action non autorisée.');
        }

        if ($membership->role === 'owner') {
            return back()->with('error', 'Vous ne pouvez pas vous retirer vous-même.');
        }

        $this->handleMemberDeparture($membership);

        return back()->with('success', "Le membre a été retiré de la colocation.");
    }

    private function handleMemberDeparture(Membership $membership)
    {
        $user = $membership->user;
        $colocation = $membership->colocation;
        $ownerMembership = $colocation->memberships()->where('role', 'owner')->first();
        // If the owner themselves is being processed (during cancel)
        $owner = $ownerMembership ? $ownerMembership->user : null;

        // Check for debts
        $debts = \App\Models\Settlement::where('debtor_id', $user->id)->get();

        if ($debts->count() > 0) {
            // Apply reputation penalty (Section 5.5)
            $user->decrement('reputation'); // -1 Reputation

            // Transfer debts to owner (if owner exists and is not the member itself)
            if ($owner && $owner->id !== $user->id) {
                foreach ($debts as $debt) {
                    if ($debt->creditor_id === $owner->id) {
                        $debt->delete();
                    } else {
                        $debt->update(['debtor_id' => $owner->id]);
                    }
                }
            }
        } else {
            // Gain reputation for leaving without debt (Section 5.5)
            $user->increment('reputation'); // +1 Reputation
        }

        $membership->update([
            'is_active' => false,
            'left_at' => now()
        ]);
    }
}

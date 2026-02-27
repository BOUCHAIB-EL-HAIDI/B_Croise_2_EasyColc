<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use App\Models\Membership;
use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $membership = $user->activeMembership;

        if (!$membership || $membership->role !== 'owner') {
            return back()->with('error', 'Seul le owner peut envoyer des invitations.');
        }

        $request->validate([
            'email' => 'required|email'
        ]);

        $token = Str::random(40);

        $invitation = Invitation::create([
            'colocation_id' => $membership->colocation_id,
            'email' => $request->email,
            'token' => $token,
            'status' => 'pending'
        ]);

        // Send the invitation email
        Mail::to($request->email)->send(new InvitationMail($invitation));

        return back()->with('success', 'Invitation envoyée par email à ' . $request->email . ' !');
    }

    public function show($token)
    {
        $invitation = Invitation::where('token', $token)->where('status', 'pending')->firstOrFail();

        if (!Auth::check()) {
            session(['invitation_token' => $token]);
            
            $userExists = User::where('email', $invitation->email)->exists();
            
            if ($userExists) {
                return redirect()->route('login')->with('info', 'Veuillez vous connecter pour accepter l\'invitation.');
            } else {
                return redirect()->route('register', ['email' => $invitation->email])
                                 ->with('info', 'Veuillez créer un compte pour rejoindre la colocation.');
            }
        }

        $user = Auth::user();

        if ($user->email !== $invitation->email) {
            return redirect('/home')->with('error', 'Cette invitation est destinée à un autre email.');
        }

        if ($user->activeMembership) {
            return redirect('/home')->with('error', 'Vous avez déjà une colocation active.');
        }

        return view('invitations.show', compact('invitation'));
    }

    public function accept($token)
    {
        $invitation = Invitation::where('token', $token)->where('status', 'pending')->firstOrFail();
        $user = Auth::user();

        if (!$user || $user->email !== $invitation->email) {
            return redirect('/home')->with('error', 'Action non autorisée.');
        }

        if ($user->activeMembership) {
            return redirect('/home')->with('error', 'Vous avez déjà une colocation active.');
        }

        Membership::create([
            'user_id' => $user->id,
            'colocation_id' => $invitation->colocation_id,
            'role' => 'member',
            'is_active' => true,
            'joined_at' => now()
        ]);

        $invitation->update(['status' => 'accepted']);

        return redirect('/home')->with('success', 'Bienvenue dans votre nouvelle colocation !');
    }
}

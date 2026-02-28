<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Settlement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Debtor marks a settlement as "paid" (Initiates verification).
     */
    public function initiate(Settlement $settlement)
    {
        // 1. Only the debtor can say "I paid"
        if ($settlement->debtor_id !== Auth::id()) {
            return back()->with('error', 'Seul le débiteur peut marquer cette dette comme payée.');
        }

        // 2. Check if already paid or has pending payment
        $existingPayment = Payment::where('settlement_id', $settlement->id)->first();
        if ($existingPayment) {
            return back()->with('error', 'Un paiement est déjà en cours ou terminé pour cette dette.');
        }

        // 3. Create PENDING payment
        Payment::create([
            'settlement_id' => $settlement->id,
            'paid_by_id' => Auth::id(),
            'amount' => $settlement->amount,
            'status' => 'PENDING',
            'payment_date' => now(),
        ]);

        return back()->with('success', 'Paiement envoyé ! En attente de confirmation par le destinataire.');
    }

    /**
     * Creditor confirms they actually received the money.
     */
    public function confirm(Payment $payment)
    {
        // 1. Only the creditor can confirm they got the money
        if ($payment->settlement->creditor_id !== Auth::id()) {
            return back()->with('error', 'Seul le créancier peut confirmer ce paiement.');
        }

        if ($payment->status === 'PAID') {
            return back()->with('error', 'Ce paiement est déjà confirmé.');
        }

        // 2. Mark as PAID
        $payment->update([
            'status' => 'PAID',
            'confirmed_at' => now(),
        ]);

        return back()->with('success', 'Paiement confirmé ! La dette est désormais réglée.');
    }
}

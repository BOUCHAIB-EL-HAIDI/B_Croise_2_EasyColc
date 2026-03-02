<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Settlement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function initiate(Settlement $settlement)
    {
        if ($settlement->debtor_id !== Auth::id()) {
            return back()->with('error', 'Seul le débiteur peut marquer cette dette comme payée.');
        }

        $existingPayment = Payment::where('settlement_id', $settlement->id)->first();
        if ($existingPayment) {
            return back()->with('error', 'Un paiement est déjà en cours ou terminé pour cette dette.');
        }

        Payment::create([
            'settlement_id' => $settlement->id,
            'paid_by_id' => Auth::id(),
            'amount' => $settlement->amount,
            'status' => 'PENDING',
            'payment_date' => now(),
        ]);

        return back()->with('success', 'Paiement envoyé ! En attente de confirmation par le destinataire.');
    }

    public function confirm(Payment $payment)
    {
        if ($payment->settlement->creditor_id !== Auth::id()) {
            return back()->with('error', 'Seul le créancier peut confirmer ce paiement.');
        }

        if ($payment->status === 'PAID') {
            return back()->with('error', 'Ce paiement est déjà confirmé.');
        }

        $payment->update([
            'status' => 'PAID',
            'confirmed_at' => now(),
        ]);

        return back()->with('success', 'Paiement confirmé ! La dette est désormais réglée.');
    }

//     public function payAll(\App\Models\User $creditor)
//     {
//         $settlements = Settlement::where('debtor_id', Auth::id())
//             ->where('creditor_id', $creditor->id)
//             ->whereDoesntHave('payments')
//             ->get();

//         if ($settlements->isEmpty()) {
//             return back()->with('error', 'Aucune dette à régler pour ce colocataire.');
//         }

//         foreach ($settlements as $settlement) {
//             Payment::create([
//                 'settlement_id' => $settlement->id,
//                 'paid_by_id' => Auth::id(),
//                 'amount' => $settlement->amount,
//                 'status' => 'PENDING',
//                 'payment_date' => now(),
//             ]);
//         }

//         return back()->with('success', 'Tous les paiements ont été envoyés à ' . $creditor->name . ' !');
//     }

//     public function confirmAll(\App\Models\User $debtor)
//     {
//         $payments = Payment::whereHas('settlement', function($q) use ($debtor) {
//                 $q->where('creditor_id', Auth::id())
//                   ->where('debtor_id', $debtor->id);
//             })
//             ->where('status', 'PENDING')
//             ->get();

//         if ($payments->isEmpty()) {
//             return back()->with('error', 'Aucun paiement en attente pour ce colocataire.');
//         }

//         foreach ($payments as $payment) {
//             $payment->update([
//                 'status' => 'PAID',
//                 'confirmed_at' => now(),
//             ]);
//         }

//         return back()->with('success', 'Tous les paiements de ' . $debtor->name . ' ont été confirmés !');
//     }
}

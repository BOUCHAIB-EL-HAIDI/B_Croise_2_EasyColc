@extends('layouts.app')

@section('title', 'Suivi des invitations - EasyColoc')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <header class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm font-medium">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-brand-600 transition-colors">Tableau de bord</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-900">Suivi des invitations</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-4xl font-black text-gray-900 tracking-tight">
                Suivi des <span class="bg-clip-text text-transparent bg-gradient-to-r from-brand-600 to-brand-800">invitations</span> ✉️
            </h1>
            <p class="mt-3 text-lg text-gray-600 font-medium">
                Gérez et suivez l'état des invitations envoyées à vos futurs colocataires.
            </p>
        </div>
    </header>

    <div class="bg-white rounded-[40px] border border-gray-100 shadow-xl overflow-hidden shadow-brand-500/5">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-8 py-6 text-xs font-bold text-gray-400 uppercase tracking-widest">Destinataire</th>
                        <th class="px-8 py-6 text-xs font-bold text-gray-400 uppercase tracking-widest">Date d'envoi</th>
                        <th class="px-8 py-6 text-xs font-bold text-gray-400 uppercase tracking-widest">Statut</th>
                        <th class="px-8 py-6 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Dernière mise à jour</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($sentInvitations as $invitation)
                        <tr class="hover:bg-gray-50/30 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-brand-50 text-brand-600 rounded-2xl flex items-center justify-center font-bold">
                                        {{ substr($invitation->email, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-gray-900">{{ $invitation->email }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-sm text-gray-500 font-medium">
                                {{ $invitation->created_at->format('d/m/Y à H:i') }}
                            </td>
                            <td class="px-8 py-6">
                                @if($invitation->status === 'accepted')
                                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold uppercase tracking-wide">
                                        <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                        Accepté
                                    </span>
                                @elseif($invitation->status === 'declined')
                                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-rose-50 text-rose-600 rounded-full text-xs font-bold uppercase tracking-wide">
                                        <span class="w-2 h-2 bg-rose-500 rounded-full"></span>
                                        Refusé
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-amber-50 text-amber-600 rounded-full text-xs font-bold uppercase tracking-wide">
                                        <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                                        En attente
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-sm text-gray-500 font-medium text-right italic">
                                {{ $invitation->updated_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="max-w-xs mx-auto">
                                    <div class="text-4xl mb-4">📭</div>
                                    <p class="text-gray-400 font-medium italic">Aucune invitation envoyée pour le moment.</p>
                                    <p class="mt-2 text-sm text-gray-400">Utilisez le bouton "Inviter un membre" sur votre tableau de bord.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

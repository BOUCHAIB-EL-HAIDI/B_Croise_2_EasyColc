@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FDFCFB] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-10 flex items-center justify-between">
            <div>
                <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-bold text-brand-600 hover:text-brand-700 transition-colors mb-4 group">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour au tableau de bord
                </a>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Détails du solde</h1>
                <p class="text-gray-500 mt-1 font-medium">Récapitulatif des comptes avec {{ $user->name }}</p>
            </div>
            
            <div class="text-right">
                <div class="inline-flex items-center px-4 py-2 rounded-2xl @if($netBalance > 0) bg-emerald-50 text-emerald-700 border border-emerald-100 @elseif($netBalance < 0) bg-rose-50 text-rose-700 border border-rose-100 @else bg-gray-50 text-gray-600 border border-gray-100 @endif shadow-sm">
                    <span class="text-sm font-bold mr-3 uppercase tracking-wider">Balance Nette</span>
                    <span class="text-xl font-black">{{ number_format(abs($netBalance), 2) }} €</span>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <!-- Ce qu'ils vous doivent -->
            <div class="bg-white rounded-[40px] shadow-sm border border-emerald-100 overflow-hidden">
                <div class="px-8 py-6 bg-emerald-50/50 border-b border-emerald-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-emerald-900">Ce qu'il(s) vous doivent</h2>
                    </div>
                    <span class="text-emerald-600 font-black text-lg">{{ number_format($owedByThem->sum('amount'), 2) }} €</span>
                </div>
                
                <div class="p-4">
                    @foreach($owedByThem as $settlement)
                        <div class="flex items-center justify-between p-4 rounded-2xl hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                                <div>
                                    <p class="font-bold text-gray-900 text-sm">{{ $settlement->expense->title }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">{{ \Carbon\Carbon::parse($settlement->created_at)->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>
                            <span class="font-black text-emerald-600 text-sm">{{ number_format($settlement->amount, 2) }} €</span>
                        </div>
                    @endforeach
                    @if($owedByThem->isEmpty())
                        <div class="p-8 text-center bg-gray-50/50 rounded-3xl">
                            <p class="text-gray-400 text-sm font-medium">Aucune créance en attente.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ce que vous leur devez -->
            <div class="bg-white rounded-[40px] shadow-sm border border-rose-100 overflow-hidden">
                <div class="px-8 py-6 bg-rose-50/50 border-b border-rose-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-rose-100 text-rose-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-rose-900">Ce que vous leur devez</h2>
                    </div>
                    <span class="text-rose-600 font-black text-lg">{{ number_format($owedToThem->sum('amount'), 2) }} €</span>
                </div>
                
                <div class="p-4">
                    @foreach($owedToThem as $settlement)
                        <div class="flex items-center justify-between p-4 rounded-2xl hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-2 h-2 rounded-full bg-rose-400"></div>
                                <div>
                                    <p class="font-bold text-gray-900 text-sm">{{ $settlement->expense->title }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">{{ \Carbon\Carbon::parse($settlement->created_at)->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>
                            <span class="font-black text-rose-600 text-sm">{{ number_format($settlement->amount, 2) }} €</span>
                        </div>
                    @endforeach
                    @if($owedToThem->isEmpty())
                        <div class="p-8 text-center bg-gray-50/50 rounded-3xl">
                            <p class="text-gray-400 text-sm font-medium">Vous n'avez aucune dette envers {{ $user->name }}.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-12 p-8 bg-gray-900 rounded-[40px] text-center shadow-xl shadow-gray-200/50">
            <h3 class="text-white font-bold text-lg mb-2">Comptes à jour ?</h3>
            <p class="text-gray-400 text-xs font-medium mb-6">Utilisez les actions rapides sur le tableau de bord pour marquer vos dettes comme payées.</p>
            <a href="{{ route('home') }}" class="inline-flex px-8 py-3.5 bg-white text-gray-900 font-black rounded-2xl hover:bg-gray-100 transition-all text-sm">
                Retour au dashboard
            </a>
        </div>
    </div>
</div>
@endsection

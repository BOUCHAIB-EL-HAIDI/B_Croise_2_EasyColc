@extends('layouts.app')

@section('title', 'Tableau de bord - EasyColoc')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-end mb-8">
        <a href="{{ route('profile.show') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-gray-700 font-bold rounded-2xl border border-gray-100 shadow-sm hover:border-brand-200 hover:bg-brand-50 transition-all group">
            <div class="p-1.5 bg-gray-50 text-gray-500 rounded-lg group-hover:bg-brand-100 group-hover:text-brand-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            Mon Profil
        </a>
    </div>

    <header class="mb-12">
        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 tracking-tight">
            Bonjour, <span class="bg-clip-text text-transparent bg-gradient-to-r from-brand-600 to-brand-800">{{ Auth::user()->name ?? 'Colocataire' }}</span> 👋
        </h1>
        <p class="mt-3 text-lg text-gray-600 font-medium max-w-2xl">
            Prêt à simplifier la gestion de votre vie en communauté ? 
        </p>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif
    </div>

    <div class="space-y-12">
        @php 
            $membership = Auth::user()->activeMembership;
            $hasActiveColocation = $membership !== null;
            $colocation = $hasActiveColocation ? $membership->colocation : null;
        @endphp

        @if(!$hasActiveColocation)
            <section class="relative overflow-hidden bg-brand-600 rounded-[48px] p-8 md:p-16 text-white shadow-2xl shadow-brand-500/40">
                <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/4 w-64 h-64 bg-brand-400/20 rounded-full blur-2xl"></div>

                <div class="relative z-10 max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 border border-white/20 rounded-full text-xs font-bold uppercase tracking-widest mb-6">
                        <span class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></span>
                        Action requise
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold mb-6 leading-tight">
                        Vous n'avez pas encore de colocation active.
                    </h2>
                    <p class="text-brand-50 text-lg mb-10 leading-relaxed font-medium">
                        Pour commencer à gérer vos dépenses et simplifier vos comptes, créez une nouvelle colocation ou rejoignez une équipe déjà existante.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('colocations.create') }}" class="px-8 py-4 bg-white text-brand-600 font-bold rounded-2xl shadow-lg hover:scale-105 transition-all text-center">
                            Créer une colocation
                        </a>
                        <a href="#" class="px-8 py-4 bg-brand-500 text-white font-bold rounded-2xl border border-white/20 hover:bg-brand-400 transition-all text-center">
                            Rejoindre une équipe
                        </a>
                    </div>
                </div>
            </section>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-8 rounded-[40px] border border-gray-100 shadow-sm mb-6">
                        <h2 class="text-2xl font-bold mb-2">Colocation : {{ $colocation->name }}</h2>
                        <p class="text-gray-600">{{ $colocation->description }}</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-8 rounded-[40px] border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                            <div class="flex items-center justify-between mb-6">
                                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-bold text-emerald-600 uppercase">Solde positif</span>
                            </div>
                            <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-1">On vous doit</p>
                            <h3 class="text-4xl font-black text-gray-900">0.00 €</h3>
                        </div>

                        <div class="bg-white p-8 rounded-[40px] border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                            <div class="flex items-center justify-between mb-6">
                                <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-bold text-rose-600 uppercase">À régler</span>
                            </div>
                            <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-1">Vous devez</p>
                            <h3 class="text-4xl font-black text-gray-900">0.00 €</h3>
                        </div>
                    </div>

                    <section>
                        <h3 class="text-xl font-bold text-gray-900 mb-6 px-4">Actions rapides</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <button class="p-6 bg-white border border-gray-100 rounded-[32px] hover:border-brand-300 hover:shadow-lg transition-all text-center group">
                                <span class="text-2xl mb-3 block group-hover:scale-125 transition-transform">➕</span>
                                <span class="text-sm font-bold text-gray-700">Dépense</span>
                            </button>
                            <button class="p-6 bg-white border border-gray-100 rounded-[32px] hover:border-brand-300 hover:shadow-lg transition-all text-center group">
                                <span class="text-2xl mb-3 block group-hover:scale-125 transition-transform">📅</span>
                                <span class="text-sm font-bold text-gray-700">Calendrier</span>
                            </button>
                            <button class="p-6 bg-white border border-gray-100 rounded-[32px] hover:border-brand-300 hover:shadow-lg transition-all text-center group">
                                <span class="text-2xl mb-3 block group-hover:scale-125 transition-transform">🧹</span>
                                <span class="text-sm font-bold text-gray-700">Ménage</span>
                            </button>
                            <button class="p-6 bg-white border border-gray-100 rounded-[32px] hover:border-brand-300 hover:shadow-lg transition-all text-center group">
                                <span class="text-2xl mb-3 block group-hover:scale-125 transition-transform">💬</span>
                                <span class="text-sm font-bold text-gray-700">Chat</span>
                            </button>
                        </div>
                    </section>
                </div>

                <aside class="space-y-8">
                    <div class="bg-gray-900 rounded-[40px] p-8 text-white shadow-2xl overflow-hidden relative">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-500/20 rounded-full blur-3xl"></div>
                        <h3 class="text-lg font-bold mb-6 relative z-10">Ma Coloc'</h3>
                        <div class="space-y-4 relative z-10">
                            @foreach($colocation->memberships()->where('is_active', true)->get() as $member)
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-brand-500 flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium">{{ $member->user->name }} ({{ ucfirst($member->role) }})</span>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($membership->role === 'owner')
                            <hr class="my-6 border-white/10">
                            <form action="{{ route('colocations.cancel', $colocation) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette colocation ? Cette action est irréversible.')">
                                @csrf
                                <button type="submit" class="w-full py-3 bg-rose-600 hover:bg-rose-700 rounded-xl font-bold text-sm transition-all border border-rose-500/20">
                                    Annuler la colocation
                                </button>
                            </form>
                        @endif
                    </div>
                </aside>
            </div>
        @endif
    </div>
</div>
@endsection

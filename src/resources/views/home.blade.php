@extends('layouts.app')

@section('title', 'Tableau de bord - EasyColoc')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
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
                            <h3 class="text-4xl font-black text-gray-900">{{ number_format($owedToMe, 2) }} €</h3>
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
                            <h3 class="text-4xl font-black text-gray-900">{{ number_format($iOwe, 2) }} €</h3>
                        </div>
                    </div>

                    <!-- Recent Expenses Section -->
                    <section class="bg-white rounded-[40px] border border-gray-100 shadow-sm overflow-hidden">
                        <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                            <h3 class="text-xl font-bold text-gray-900">Dépenses récentes</h3>
                            <a href="{{ route('expenses.index') }}" class="text-sm font-bold text-brand-600 hover:text-brand-700">Voir tout</a>
                        </div>
                        <div class="divide-y divide-gray-50">
                            @forelse($recentExpenses as $expense)
                                <div class="p-6 flex items-center justify-between hover:bg-gray-50/50 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-xl">
                                            🏷️
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $expense->title }}</p>
                                            <p class="text-xs text-gray-500 font-medium">
                                                {{ $expense->category->name }} • {{ $expense->payer->name }} • {{ date('d/m/Y', strtotime($expense->expense_date)) }}
                                            </p>
                                        </div>
                                    </div>
                                    <span class="font-black text-gray-900">{{ number_format($expense->amount, 2) }} €</span>
                                </div>
                            @empty
                                <div class="p-12 text-center text-gray-400 font-medium italic">
                                    Aucune dépense récente.
                                </div>
                            @endforelse
                        </div>
                    </section>

                    <!-- Payment & Debt Management -->
                    <section class="space-y-6">
                        <!-- 1. I am Creditor: Confirm receipt of money -->
                        @if($pendingPaymentsToConfirm->count() > 0)
                            <div class="bg-amber-50 border border-amber-200 rounded-[40px] p-8 shadow-sm">
                                <h3 class="text-xl font-bold text-amber-900 mb-6 flex items-center gap-3">
                                    <span class="animate-pulse">💰</span> Paiements à confirmer
                                </h3>
                                <p class="text-sm text-amber-700 mb-4 font-medium">Ces colocataires disent qu'ils vous ont payé. Confirmez-vous la réception ?</p>
                                <div class="space-y-4">
                                    @foreach($pendingPaymentsToConfirm as $payment)
                                        <div class="bg-white p-6 rounded-3xl flex items-center justify-between shadow-sm border border-amber-100">
                                            <div>
                                                <p class="font-bold text-gray-900">{{ $payment->settlement->debtor->name }} vous a payé</p>
                                                <p class="text-xs text-gray-500 font-medium">{{ $payment->settlement->expense->title }} • {{ number_format($payment->amount, 2) }} €</p>
                                            </div>
                                            <form action="{{ route('payments.confirm', $payment) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-5 py-2.5 bg-brand-600 text-white font-bold rounded-xl hover:bg-brand-700 transition-all text-sm">
                                                    Confirmer
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- 2. I am Debtor: Mark as paid -->
                        @if($myDebts->count() > 0)
                            <div class="bg-white rounded-[40px] border border-gray-100 shadow-sm overflow-hidden">
                                <div class="p-8 border-b border-gray-50">
                                    <h3 class="text-xl font-bold text-gray-900">Mes dettes à régler 💸</h3>
                                    <p class="text-sm text-gray-500 mt-1">Marquez comme payé après avoir envoyé l'argent.</p>
                                </div>
                                <div class="divide-y divide-gray-50">
                                    @foreach($myDebts as $settlement)
                                        <div class="p-6 flex items-center justify-between hover:bg-gray-50/50 transition-colors">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 bg-brand-50 text-brand-600 rounded-full flex items-center justify-center font-bold text-sm">
                                                    {{ substr($settlement->creditor->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-900">Vous devez à {{ $settlement->creditor->name }}</p>
                                                    <p class="text-xs text-gray-500 font-medium">{{ $settlement->expense->title }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <span class="font-black text-gray-900">{{ number_format($settlement->amount, 2) }} €</span>
                                                <form action="{{ route('payments.initiate', $settlement) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-2 bg-gray-900 text-white text-xs font-bold rounded-xl hover:bg-gray-800 transition-all">
                                                        J'ai payé
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </section>

                    <section>
                        <h3 class="text-xl font-bold text-gray-900 mb-6 px-4">Actions rapides</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <a href="{{ route('expenses.index') }}" class="p-6 bg-white border border-gray-100 rounded-[32px] hover:border-brand-300 hover:shadow-lg transition-all text-center group">
                                <span class="text-2xl mb-3 block group-hover:scale-125 transition-transform">➕</span>
                                <span class="text-sm font-bold text-gray-700">Gérer les Dépenses</span>
                            </a>
                            <a href="{{ route('expenses.create') }}" class="p-6 bg-brand-600 border border-brand-500 rounded-[32px] hover:shadow-lg transition-all text-center group">
                                <span class="text-2xl mb-3 block group-hover:scale-125 transition-transform">💰</span>
                                <span class="text-sm font-bold text-white">Ajouter une Dépense</span>
                            </a>
                        </div>
                    </section>
                </div>

                <aside class="space-y-8">
                    <!-- Premium Balance Breakdown -->
                    <div class="bg-white rounded-[40px] p-8 border border-gray-100 shadow-sm transition-all hover:shadow-xl">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-xl font-bold text-gray-900 tracking-tight">Soldes</h3>
                            <div class="p-2 bg-gray-50 rounded-xl">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="space-y-6">
                            @forelse($memberBalances as $item)
                                <div class="relative p-6 rounded-[32px] overflow-hidden group transition-all @if($item['raw_balance'] > 0) bg-emerald-50/40 border border-emerald-100/50 @elseif($item['raw_balance'] < 0) bg-rose-50/40 border border-rose-100/50 @else bg-gray-50/50 border border-gray-100 @endif">
                                    <div class="relative z-10 flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 @if($item['raw_balance'] > 0) bg-emerald-100 text-emerald-700 @elseif($item['raw_balance'] < 0) bg-rose-100 text-rose-700 @else bg-gray-100 text-gray-700 @endif rounded-2xl flex items-center justify-center font-bold text-lg shadow-sm border @if($item['raw_balance'] > 0) border-emerald-200 @elseif($item['raw_balance'] < 0) border-rose-200 @else border-gray-200 @endif">
                                                {{ substr($item['user']->name, 0, 1) }}
                                            </div>
                                            <div>
                                                @if($item['raw_balance'] > 0)
                                                    <p class="text-sm font-bold text-emerald-800 mb-0.5">{{ $item['user']->name }}</p>
                                                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest">{{ $item['status'] }}</p>
                                                @elseif($item['raw_balance'] < 0)
                                                    <p class="text-sm font-bold text-rose-800 mb-0.5">{{ $item['status'] }}</p>
                                                    <p class="text-xs font-bold text-rose-600 uppercase tracking-widest">{{ $item['user']->name }}</p>
                                                @else
                                                    <p class="text-sm font-bold text-gray-800 mb-0.5">{{ $item['user']->name }}</p>
                                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $item['status'] }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="text-right">
                                            @if($item['raw_balance'] != 0)
                                                <span class="text-xl font-black @if($item['raw_balance'] > 0) text-emerald-600 @else text-rose-600 @endif">
                                                    {{ number_format($item['balance'], 2) }} €
                                                </span>
                                            @else
                                                <span class="text-sm font-bold text-gray-400">0.00 €</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Decorative gradient background on hover -->
                                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity bg-gradient-to-br @if($item['raw_balance'] > 0) from-emerald-100/20 to-transparent @elseif($item['raw_balance'] < 0) from-rose-100/20 to-transparent @else from-gray-100/20 to-transparent @endif"></div>
                                </div>
                            @empty
                                <div class="text-center py-10 bg-gray-50 rounded-[32px] border border-dashed border-gray-200">
                                    <span class="text-4xl mb-3 block">🤝</span>
                                    <p class="text-sm text-gray-500 font-bold">Votre colocation est à jour !</p>
                                </div>
                            @endforelse
                        </div>

                        <a href="{{ route('expenses.index') }}" class="mt-10 flex items-center justify-center gap-3 w-full py-5 bg-gray-900 text-white font-bold rounded-2xl shadow-xl shadow-gray-900/10 hover:bg-gray-800 hover:-translate-y-1 transition-all">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Journal complet
                        </a>
                    </div>

                    <div class="bg-gray-900 rounded-[40px] p-8 text-white shadow-2xl overflow-hidden relative">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-500/20 rounded-full blur-3xl"></div>
                        <h3 class="text-lg font-bold mb-6 relative z-10">Ma Coloc'</h3>
                        <div class="space-y-4 relative z-10">
                            @foreach($colocation->memberships()->where('is_active', true)->get() as $m)
                                <div class="flex items-center justify-between group/member">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-brand-500 flex items-center justify-center font-bold">
                                            {{ strtoupper(substr($m->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-white leading-none mb-1">{{ $m->user->name }}</p>
                                            <div class="flex items-center gap-2">
                                                <p class="text-[10px] text-white/50 uppercase tracking-widest font-bold">{{ $m->role === 'owner' ? 'Propriétaire' : 'Membre' }}</p>
                                                <span class="text-[10px] px-1.5 py-0.5 bg-brand-500/20 text-brand-400 rounded-md font-bold">⭐ {{ $m->user->reputation }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($membership->role === 'owner' && $m->user_id !== Auth::id())
                                        <form action="{{ route('colocations.members.remove', $m->id) }}" method="POST" onsubmit="return confirm('Retirer ce membre ?')">
                                            @csrf
                                            <button type="submit" class="opacity-0 group-hover/member:opacity-100 p-2 text-rose-400 hover:text-rose-500 transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        @if($membership->role !== 'owner')
                            <hr class="my-6 border-white/10 relative z-10">
                            <form action="{{ route('colocations.leave') }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment quitter la colocation ?')">
                                @csrf
                                <button type="submit" class="relative z-10 flex items-center gap-2 text-sm font-bold text-rose-400 hover:text-rose-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Quitter la colocation
                                </button>
                            </form>
                        @endif

                        @if($membership->role === 'owner')
                            <hr class="my-6 border-white/10">
                            
                            <div class="mb-8">
                                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-3">Administration</p>
                                <a href="{{ route('categories.index') }}" class="flex items-center justify-between w-full p-4 bg-white/5 border border-white/10 rounded-2xl hover:bg-white/10 hover:border-brand-500/50 transition-all group">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-brand-500/20 text-brand-400 rounded-lg group-hover:scale-110 transition-transform">🏷️</div>
                                        <span class="text-sm font-bold">Gérer les catégories</span>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>

                            <div class="mb-6">
                                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-3">Inviter un membre</p>
                                <form action="{{ route('invitations.store') }}" method="POST" class="space-y-3">
                                    @csrf
                                    <div class="relative">
                                        <input type="email" name="email" placeholder="Email du futur coloc" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500 transition-all text-white">
                                    </div>
                                    <button type="submit" class="w-full py-2.5 bg-brand-600 hover:bg-brand-700 rounded-xl font-bold text-xs transition-all border border-brand-500/20">
                                        Envoyer le lien
                                    </button>
                                </form>
                            </div>

                            <form action="{{ route('colocations.cancel', $colocation) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette colocation ? Cette action est irréversible.')">
                                @csrf
                                <button type="submit" class="w-full py-3 bg-rose-600/20 hover:bg-rose-600 text-rose-400 hover:text-white rounded-xl font-bold text-xs transition-all border border-rose-500/10">
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

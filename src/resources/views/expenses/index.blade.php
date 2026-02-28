@extends('layouts.app')

@section('title', 'Gestion des dépenses - EasyColoc')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-12">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('home') }}" class="p-3 bg-white border border-gray-100 rounded-2xl text-gray-400 hover:text-brand-600 hover:border-brand-200 transition-all shadow-sm group">
                <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Retour au tableau de bord</span>
        </div>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-2">
                    Journal des <span class="text-brand-600">Dépenses</span> 📜
                </h1>
                <p class="text-lg text-gray-600 font-medium"> Consultez et gérez les achats de votre colocation. </p>
            </div>
            <div class="flex flex-wrap items-center gap-4">
                <form action="{{ route('expenses.index') }}" method="GET" class="flex items-center gap-3 bg-white p-2 rounded-2xl border border-gray-100 shadow-sm">
                    <input type="month" name="month" value="{{ request('month') }}" class="border-none focus:ring-0 text-sm font-bold text-gray-700">
                    <button type="submit" class="p-2 bg-brand-50 text-brand-600 rounded-xl hover:bg-brand-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                    @if(request('month'))
                        <a href="{{ route('expenses.index') }}" class="text-xs font-bold text-gray-400 hover:text-rose-500 px-2 leading-none border-l border-gray-100">Réinitialiser</a>
                    @endif
                </form>
                <a href="{{ route('expenses.create') }}" class="inline-flex items-center gap-3 px-6 py-4 bg-brand-600 text-white font-bold rounded-2xl shadow-lg shadow-brand-500/25 hover:bg-brand-700 hover:-translate-y-1 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Ajouter une dépense
                </a>
            </div>
        </div>
    </div>

    <!-- Monthly Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white p-8 rounded-[40px] border border-gray-100 shadow-sm">
            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-1">Total période</p>
            <h3 class="text-4xl font-black text-gray-900">{{ number_format($totalAmount, 2) }} €</h3>
        </div>
        @foreach($statsByCategory->take(2) as $stat)
            <div class="bg-white p-8 rounded-[40px] border border-gray-100 shadow-sm">
                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-1">{{ $stat['name'] }}</p>
                <h3 class="text-4xl font-black text-brand-600">{{ number_format($stat['total'], 2) }} €</h3>
                <p class="text-xs font-bold text-gray-400 mt-2 uppercase tracking-wide">{{ $stat['count'] }} dépense(s)</p>
            </div>
        @endforeach
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3 animate-slide-in">
            <span class="text-xl">✅</span>
            <p class="font-bold">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-[40px] border border-gray-100 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">Date</th>
                        <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">Titre / Catégorie</th>
                        <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">Payé par</th>
                        <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest text-right">Montant</th>
                        <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($expenses as $expense)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <span class="text-gray-900 font-bold block">{{ date('d/m/Y', strtotime($expense->expense_date)) }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-gray-900 font-bold block mb-1">{{ $expense->title }}</span>
                                <span class="px-3 py-1 bg-brand-50 text-brand-700 rounded-lg text-xs font-bold uppercase tracking-wider">
                                    {{ $expense->category->name }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-brand-100 text-brand-700 rounded-full flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($expense->payer->name, 0, 1) }}
                                    </div>
                                    <span class="text-gray-700 font-medium">{{ $expense->payer->name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="text-xl font-black text-gray-900">{{ number_format($expense->amount, 2) }} €</span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cette dépense ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-rose-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl"> 📉 </div>
                                <p class="text-gray-500 font-bold">Aucune dépense trouvée pour cette période.</p>
                                <a href="{{ route('expenses.index') }}" class="text-brand-600 hover:text-brand-700 font-bold mt-2 inline-block">
                                    Voir tout l'historique
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Gestion des dépenses - EasyColoc')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-2">
                Journal des <span class="text-brand-600">Dépenses</span> 📜
            </h1>
            <p class="text-lg text-gray-600 font-medium"> Consultez et gérez les achats de votre colocation. </p>
        </div>
        <a href="{{ route('expenses.create') }}" class="inline-flex items-center gap-3 px-6 py-4 bg-brand-600 text-white font-bold rounded-2xl shadow-lg shadow-brand-500/25 hover:bg-brand-700 hover:-translate-y-1 transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Ajouter une dépense
        </a>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl"> 📉 </div>
                                <p class="text-gray-500 font-bold">Aucune dépense enregistrée pour le moment.</p>
                                <a href="{{ route('expenses.create') }}" class="text-brand-600 hover:text-brand-700 font-bold mt-2 inline-block">
                                    Commencer par ajouter la première !
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

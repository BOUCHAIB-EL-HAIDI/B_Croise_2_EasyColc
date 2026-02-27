@extends('layouts.app')

@section('title', 'Déclarer une dépense - EasyColoc')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-12 flex items-center justify-between">
        <div>
            <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-2">
                Nouvelle <span class="text-brand-600">Dépense</span> 💸
            </h1>
            <p class="text-lg text-gray-600 font-medium"> Renseignez les détails de votre achat pour le partager. </p>
        </div>
        <a href="{{ route('expenses.index') }}" class="text-gray-500 hover:text-gray-700 font-bold">
            Annuler
        </a>
    </div>

    <div class="bg-white rounded-[40px] p-8 md:p-12 border border-gray-100 shadow-xl">
        <form action="{{ route('expenses.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-bold text-gray-700 mb-2 px-1">Titre de la dépense</label>
                <input type="text" name="title" id="title" placeholder="Ex: Courses Lidl, Facture Eau..." required
                    class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-sm font-bold text-gray-700 mb-2 px-1">Montant (€)</label>
                    <input type="number" step="0.01" name="amount" id="amount" placeholder="0.00" required
                        class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all outline-none text-right font-bold text-xl">
                </div>

                <!-- Date -->
                <div>
                    <label for="expense_date" class="block text-sm font-bold text-gray-700 mb-2 px-1">Date du paiement</label>
                    <input type="date" name="expense_date" id="expense_date" value="{{ date('Y-m-d') }}" required
                        class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all outline-none">
                </div>
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-bold text-gray-700 mb-3 px-1">Catégorie</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach($categories as $category)
                        <label class="relative flex">
                            <input type="radio" name="category_id" value="{{ $category->id }}" class="peer absolute opacity-0" required>
                            <span class="w-full px-4 py-3 text-center bg-gray-50 border border-transparent rounded-xl cursor-pointer peer-checked:bg-brand-50 peer-checked:border-brand-300 peer-checked:text-brand-700 font-bold transition-all hover:bg-gray-100">
                                {{ $category->name }}
                            </span>
                        </label>
                    @endforeach
                </div>
                @if($categories->isEmpty())
                    <p class="mt-2 text-rose-500 text-sm font-bold">⚠️ Aucune catégorie n'a été créée par le propriétaire.</p>
                @endif
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full py-5 bg-brand-600 text-white font-bold rounded-2xl shadow-lg shadow-brand-500/25 hover:bg-brand-700 hover:-translate-y-1 transition-all text-xl">
                Déclarer cette dépense
            </button>
        </form>
    </div>
</div>
@endsection

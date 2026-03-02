@extends('layouts.app')

@section('title', 'Créer une colocation - EasyColoc')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-12 text-center">
        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-4">
            Nouvelle <span class="text-brand-600">Colocation</span> 🏠
        </h1>
        <p class="text-lg text-gray-600 font-medium">
            Commencez votre aventure collective en créant votre espace de gestion.
        </p>
    </div>

    <div class="bg-white rounded-[40px] p-8 md:p-12 border border-gray-100 shadow-xl">
        <form action="{{ route('colocations.store') }}" method="POST" class="space-y-8">
            @csrf

            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 uppercase tracking-widest mb-3">Nom de la colocation</label>
                <input type="text" name="name" id="name" required
                    class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all outline-none text-lg font-medium"
                    placeholder="Ex: Les Amis de Rivoli">
                @error('name')
                    <p class="mt-2 text-sm text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-bold text-gray-700 uppercase tracking-widest mb-3">Description (Optionnel)</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all outline-none text-lg font-medium"
                    placeholder="Une courte description pour votre équipe..."></textarea>
                @error('description')
                    <p class="mt-2 text-sm text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex flex-col sm:flex-row gap-4">
                <button type="submit" class="flex-1 px-8 py-5 bg-brand-600 text-white font-black rounded-2xl shadow-lg shadow-brand-500/30 hover:bg-brand-700 hover:-translate-y-1 active:translate-y-0 transition-all text-xl uppercase tracking-widest">
                    Lancer la Coloc
                </button>
                <a href="{{ route('home') }}" class="px-8 py-5 bg-gray-100 text-gray-600 font-bold rounded-2xl hover:bg-gray-200 transition-all text-center">
                    Annuler
                </a>
            </div>
        </form>
    </div>

    <div class="mt-12 p-8 bg-brand-50 rounded-[32px] border border-brand-100">
        <div class="flex items-start gap-4">
            <div class="p-2 bg-brand-600 rounded-lg text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-brand-900 mb-1">Bon à savoir</h4>
                <p class="text-brand-700/80 font-medium leading-relaxed">
                    En créant cette colocation, vous en devenez automatiquement l'**Owner** (Administrateur). Vous pourrez ensuite inviter vos futurs colocataires !
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

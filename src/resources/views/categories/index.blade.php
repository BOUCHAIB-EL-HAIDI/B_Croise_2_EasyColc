@extends('layouts.app')

@section('title', 'Gérer les catégories - EasyColoc')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-2">
                Gérer les <span class="text-brand-600">Catégories</span> 🏷️
            </h1>
            <p class="text-lg text-gray-600 font-medium"> Organisez vos dépenses pour une meilleure clarté. </p>
        </div>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-gray-700 font-bold rounded-2xl border border-gray-100 shadow-sm hover:border-brand-200 hover:bg-brand-50 transition-all">
            Retour au tableau de bord
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- New Category Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[40px] p-8 border border-gray-100 shadow-xl sticky top-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                    <span class="p-2 bg-brand-50 text-brand-600 rounded-xl">➕</span>
                    Nouvelle catégorie
                </h3>
                <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2 px-1">Nom de la catégorie</label>
                        <input type="text" name="name" id="name" placeholder="Ex: Courses, Loyer..." required 
                            class="w-full px-5 py-3.5 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all outline-none">
                    </div>
                    <button type="submit" class="w-full py-4 bg-brand-600 text-white font-bold rounded-2xl shadow-lg shadow-brand-500/25 hover:bg-brand-700 hover:-translate-y-1 transition-all">
                        Ajouter
                    </button>
                </form>
            </div>
        </div>

        <!-- Category List -->
        <div class="lg:col-span-2 space-y-4">
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3 animate-slide-in">
                    <span class="text-xl">✅</span>
                    <p class="font-bold">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl flex items-center gap-3 animate-slide-in">
                    <span class="text-xl">⚠️</span>
                    <p class="font-bold">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-[40px] border border-gray-100 shadow-xl overflow-hidden">
                <div class="p-8 border-b border-gray-50">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                        <span class="p-2 bg-brand-50 text-brand-600 rounded-xl">📂</span>
                        Catégories existantes
                    </h3>
                </div>

                <div class="divide-y divide-gray-50">
                    @forelse($categories as $category)
                        <div class="p-6 flex items-center justify-between hover:bg-gray-50/50 transition-colors">
                            <form action="{{ route('categories.update', $category) }}" method="POST" class="flex-1 flex items-center gap-4">
                                @csrf
                                @method('PATCH')
                                <input type="text" name="name" value="{{ $category->name }}" 
                                    class="flex-1 bg-transparent border-transparent focus:bg-white focus:border-brand-200 focus:ring-4 focus:ring-brand-500/5 rounded-xl px-4 py-2 font-bold text-gray-900 transition-all border outline-none">
                                
                                <button type="submit" class="p-2.5 text-brand-600 hover:bg-brand-50 rounded-xl transition-all" title="Enregistrer les modifications">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                    </svg>
                                </button>
                            </form>
                            
                            <div class="flex items-center pl-4 border-l border-gray-100 ml-2">
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette catégorie ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-xl transition-all" title="Supprimer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl"> 🏷️ </div>
                            <p class="text-gray-500 font-bold">Aucune catégorie pour le moment.</p>
                            <p class="text-gray-400 text-sm mt-1 uppercase tracking-widest">Créez votre première catégorie à gauche</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

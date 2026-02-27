@extends('layouts.app')

@section('title', 'Gérer les catégories - EasyColoc')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-2">
                Gérer les <span class="text-brand-600">Catégories</span> 🏷️
            </h1>
            <p class="text-lg text-gray-600 font-medium"> Organisez vos denses pour une meilleure clarté. </p>
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
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2 px-1 text-right">Nom de la catégorie</label>
                        <input type="text" name="name" id="name" placeholder="Ex: Courses, Loyer..." required 
                            class="w-full px-5 py-3.5 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all outline-none text-right">
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

            <div class="bg-white rounded-[40px] border border-gray-100 shadow-xl overflow-hidden">
                <div class="p-8 border-b border-gray-50">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                        <span class="p-2 bg-brand-50 text-brand-600 rounded-xl">📂</span>
                        Catégories existantes
                    </h3>
                </div>

                <div class="divide-y divide-gray-50">
                    @forelse($categories as $category)
                        <div class="p-6 flex items-center justify-between hover:bg-gray-50 transition-colors group">
                            <div class="flex-1 mr-4">
                                <span class="font-bold text-gray-900">{{ $category->name }}</span>
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

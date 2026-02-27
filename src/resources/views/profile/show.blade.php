@extends('layouts.app')

@section('title', 'Mon Profil - EasyColoc')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-12">
        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-2">
            Mon <span class="text-brand-600">Profil</span> 👤
        </h1>
        <p class="text-lg text-gray-600 font-medium"> Vos informations personnelles et votre statut au sein de la communauté. </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-1">
            <div class="bg-white rounded-[40px] p-8 border border-gray-100 shadow-xl text-center">
                <div class="w-24 h-24 bg-brand-600 rounded-3xl mx-auto mb-6 flex items-center justify-center text-4xl font-black text-white shadow-lg shadow-brand-500/30">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $user->name }}</h2>
                <p class="text-gray-500 font-medium mb-6">{{ $user->email }}</p>
                
                @if($user->is_global_admin)
                    <span class="inline-flex items-center px-4 py-1.5 bg-brand-100 text-brand-700 rounded-full text-xs font-bold uppercase tracking-widest"> Admin Global </span>
                @elseif($membership)
                    <span class="inline-flex items-center px-4 py-1.5 bg-brand-600 text-white rounded-full text-xs font-bold uppercase tracking-widest"> {{ $membership->role }} </span>
                @else
                    <span class="inline-flex items-center px-4 py-1.5 bg-gray-100 text-gray-600 rounded-full text-xs font-bold uppercase tracking-widest"> Utilisateur </span>
                @endif
            </div>
        </div>

        <div class="md:col-span-2 space-y-8">
            <div class="bg-white rounded-[40px] p-8 md:p-10 border border-gray-100 shadow-xl">
                <h3 class="text-xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                    <span class="p-2 bg-brand-50 text-brand-600 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </span>
                    Statut Colocation
                </h3>

                @if($membership)
                    <div class="space-y-6">
                        <div class="flex justify-between items-center p-6 bg-gray-50 rounded-2xl border border-transparent hover:border-brand-200 transition-all">
                            <div>
                                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-1">Colocation actuelle</p>
                                <p class="text-xl font-bold text-gray-900">{{ $membership->colocation->name }}</p>
                            </div>
                            <span class="px-4 py-2 bg-emerald-100 text-emerald-700 rounded-xl text-sm font-bold"> Actif </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-6 bg-gray-50 rounded-2xl">
                                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-1">Rôle</p>
                                <p class="text-lg font-bold text-gray-900">{{ ucfirst($membership->role) }}</p>
                            </div>
                            <div class="p-6 bg-gray-50 rounded-2xl">
                                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-1">Membre depuis</p>
                                <p class="text-lg font-bold text-gray-900">{{ $membership->joined_at ? date('d/m/Y', strtotime($membership->joined_at)) : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-10 px-6 border-2 border-dashed border-gray-100 rounded-[32px]">
                        <div class="w-16 h-16 bg-gray-50 text-gray-300 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl"> ❕ </div>
                        <p class="text-gray-500 font-medium mb-6">Vous n'êtes actuellement membre d'aucune colocation active.</p>
                        <a href="{{ route('colocations.create') }}" class="inline-flex items-center px-6 py-3 bg-brand-600 text-white font-bold rounded-xl hover:bg-brand-700 transition-all">
                            Créer une colocation
                        </a>
                    </div>
                @endif
            </div>
        </div>
        </div>
    </div>
</div>
@endsection

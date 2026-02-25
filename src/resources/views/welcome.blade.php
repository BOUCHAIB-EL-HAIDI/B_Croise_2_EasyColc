@extends('layouts.app')

@section('title', 'Bienvenue sur EasyColoc')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden pt-16 pb-32">
    <!-- Background Accents -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[800px] opacity-20 pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-brand-400 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-brand-600 rounded-full blur-[120px]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-center">
            <div class="lg:col-span-7 text-center lg:text-left space-y-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-brand-50 text-brand-700 rounded-full text-sm font-bold tracking-wide animate-fade-in">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-600"></span>
                    </span>
                    LA RÉFÉRENCE DE LA COLOCATION
                </div>
                
                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold text-gray-900 leading-[1.1] tracking-tight">
                    Gérez votre colocation <br>
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-brand-600 via-brand-500 to-brand-800">en toute simplicité.</span>
                </h1>
                
                <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-medium">
                    Suivez vos dépenses communes, répartissez automatiquement les dettes et gardez une vision claire de « qui doit quoi à qui ». La plateforme préférée des colocataires organisés.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
                    <a href="/auth/register" class="w-full sm:w-auto px-8 py-4 bg-brand-600 text-white font-bold rounded-2xl shadow-xl shadow-brand-500/30 hover:bg-brand-700 hover:-translate-y-1 transition-all text-lg flex items-center justify-center gap-2">
                        Créer un compte
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 23 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                    <a href="/auth/login" class="w-full sm:w-auto px-8 py-4 bg-white text-gray-700 font-bold rounded-2xl border-2 border-gray-100 hover:border-brand-200 hover:bg-brand-50 transition-all text-lg text-center">
                        Se connecter
                    </a>
                </div>
            </div>

            <div class="lg:col-span-5 mt-16 lg:mt-0 relative group">
                <div class="absolute -inset-4 bg-gradient-to-r from-brand-400 to-brand-600 rounded-[40px] opacity-20 blur-2xl group-hover:opacity-30 transition-opacity"></div>
                <div class="relative glass rounded-[40px] border border-white/50 shadow-2xl overflow-hidden p-4 sm:p-6 transition-transform hover:scale-[1.02] duration-500">
                    <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 p-6 space-y-6">
                        <div class="flex justify-between items-center">
                            <h3 class="font-bold text-gray-800">Aperçu du solde</h3>
                            <span class="text-xs font-bold text-gray-400">SESSION ACTIVE</span>
                        </div>
                        <div class="text-3xl font-bold text-brand-600">1,240.50 €</div>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 p-3 bg-brand-50 rounded-2xl border border-brand-100">
                                <div class="w-10 h-10 bg-brand-600 rounded-xl flex items-center justify-center text-white font-bold">L</div>
                                <div class="flex-1">
                                    <div class="text-sm font-bold">Loyer Février</div>
                                    <div class="text-[11px] text-gray-500">Dépense partagée</div>
                                </div>
                                <div class="font-bold text-gray-700">800€</div>
                            </div>
                            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-2xl border border-transparent">
                                <div class="w-10 h-10 bg-orange-400 rounded-xl flex items-center justify-center text-white font-bold text-xs uppercase">C</div>
                                <div class="flex-1">
                                    <div class="text-sm font-bold">Courses communes</div>
                                    <div class="text-[11px] text-gray-500">Détails enregistrés</div>
                                </div>
                                <div class="font-bold text-gray-700">120€</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.8s ease-out forwards;
    }
</style>
@endsection

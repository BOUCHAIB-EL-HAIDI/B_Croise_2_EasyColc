@extends('layouts.app')

@section('title', 'Rejoindre la colocation - EasyColoc')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
    <div class="mb-12">
        <div class="w-32 h-32 bg-brand-600 rounded-[40px] flex items-center justify-center text-6xl mx-auto mb-8 shadow-2xl shadow-brand-500/40 relative overflow-hidden group">
            <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
            🏠
        </div>
        <h1 class="text-4xl md:text-6xl font-black text-gray-900 tracking-tight mb-6">
            Invitation à rejoindre <br>
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-brand-600 to-brand-800">"{{ $invitation->colocation->name }}"</span>
        </h1>
        <p class="text-xl text-gray-600 font-medium max-w-2xl mx-auto leading-relaxed">
            Vous avez été invité à rejoindre cette colocation. En acceptant, vous pourrez partager vos dépenses et gérer vos comptes en toute simplicité.
        </p>
    </div>

    <div class="bg-white rounded-[48px] p-8 md:p-12 border border-gray-100 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-64 h-64 bg-brand-50 rounded-full blur-3xl"></div>
        
        <div class="relative z-10">
            <div class="flex flex-col md:flex-row items-center justify-center gap-6">
                <form action="{{ route('invitations.accept', $invitation->token) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-12 py-5 bg-brand-600 text-white font-bold rounded-2xl shadow-xl hover:scale-105 transition-all text-lg">
                        Accepter l'invitation
                    </button>
                </form>
                <form action="{{ route('invitations.refuse', $invitation->token) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-12 py-5 bg-white text-rose-500 font-bold rounded-2xl border border-rose-100 hover:bg-rose-50 transition-all text-lg shadow-sm">
                        Refuser l'invitation
                    </button>
                </form>
            </div>
            
            <p class="mt-8 text-sm text-gray-400 font-medium">
                Connecté en tant que <span class="text-brand-600 font-bold">{{ Auth::user()->email }}</span>
            </p>
        </div>
    </div>
</div>
@endsection

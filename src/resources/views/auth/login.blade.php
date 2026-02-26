@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="min-h-[calc(100vh-80px)] flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8 bg-gradient-to-br from-brand-50 via-white to-brand-50/30">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900 tracking-tight">
                Bon retour parmi nous !
            </h2>
            <p class="mt-3 text-sm text-gray-500">
                Ou <a href="{{ route('register') }}" class="font-semibold text-brand-600 hover:text-brand-500 transition-colors">créez votre compte gratuitement</a>
            </p>
        </div>

        <div class="mt-8 glass rounded-3xl shadow-2xl shadow-brand-200/50 p-8 sm:p-10">
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Adresse Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-500 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required 
                                class="block w-full pl-10 pr-4 py-3 border @error('email') border-red-500 @else border-gray-200 @enderror rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all bg-white/50"
                                placeholder="nom@exemple.com" value="{{ old('email') }}">
                            @error('email')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-sm font-semibold text-gray-700">Mot de passe</label>
                            <a href="#" class="text-xs font-semibold text-brand-600 hover:text-brand-500 transition-colors">Oublié ?</a>
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-500 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required 
                                class="block w-full pl-10 pr-4 py-3 border @error('password') border-red-500 @else border-gray-200 @enderror rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all bg-white/50"
                                placeholder="••••••••">
                            @error('password')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" 
                        class="h-4 w-4 text-brand-600 focus:ring-brand-500 border-gray-300 rounded transition-all">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-600">
                        Se souvenir de moi
                    </label>
                </div>

                <div>
                    <button type="submit" 
                        class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 font-bold text-lg shadow-lg shadow-brand-500/30 transition-all active:scale-[0.98]">
                        Se connecter
                    </button>
                </div>
            </form>
            
            <div class="mt-8">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500 rounded-lg">Ou continuer avec</span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-4">
                    <button class="flex justify-center items-center px-4 py-2 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 transition-colors shadow-sm">
                        <span class="sr-only">Google</span>
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.908 3.152-1.928 4.176-1.028 1.024-2.64 2.176-5.912 2.176-5.232 0-9.416-4.24-9.416-9.472s4.184-9.472 9.416-9.472c2.84 0 4.944 1.112 6.44 2.512l2.312-2.312C19.16 1.104 16.272 0 12.48 0 5.688 0 0 5.688 0 12s5.688 12 12.48 12c3.664 0 6.44-1.208 8.616-3.48 2.24-2.24 2.944-5.416 2.944-8.032 0-.76-.064-1.48-.184-2.12h-11.376z"/>
                        </svg>
                    </button>
                    <button class="flex justify-center items-center px-4 py-2 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 transition-colors shadow-sm">
                        <span class="sr-only">Apple</span>
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.05 20.28c-.96.95-2.03 2.02-3.41 2.02-1.34 0-1.78-.82-3.34-.82-1.57 0-2.06.81-3.34.81-1.35 0-2.45-1.07-3.41-2.02-2.11-2.09-3.26-5.83-3.26-8.87 0-4.63 2.99-7.07 5.86-7.07 1.48 0 2.44.78 3.39.78.93 0 1.95-.78 3.53-.78 1.19 0 2.6.49 3.53 1.57-2.9 1.63-2.43 5.48.43 6.77-1.12 2.67-2.66 5.56-4.41 7.23zM12.03 5.07c-.12-2.58 2.11-4.73 4.54-5.07.24 2.56-2.11 4.93-4.54 5.07z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

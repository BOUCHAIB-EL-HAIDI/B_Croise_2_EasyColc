@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="min-h-[calc(100vh-80px)] flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8 bg-gradient-to-br from-brand-50 via-white to-brand-50/30">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900 tracking-tight">
                Accès à votre espace
            </h2>
            <p class="mt-3 text-sm text-gray-500">
                Ou <a href="{{ route('register') }}" class="font-semibold text-brand-600 hover:text-brand-500 transition-colors">créez votre compte gratuitement</a>
            </p>
        </div>

        <div class="mt-8 glass rounded-3xl shadow-2xl shadow-brand-200/50 p-8 sm:p-10">
                  @if ($errors->any())

                    <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 font-bold">
                       <ul class="list-disc ml-5 text-sm">
                        @foreach ($errors->all() as $error)

                           <li>{{  $error  }} </li>
                        @endforeach
                       </ul>
                    </div>
                    @endif

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
                                class="block w-full pl-10 pr-4 py-3 border  border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all bg-white/50"
                                placeholder="nom@exemple.com" value="{{ old('email') }}">

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
                        </div>
                    </div>
                </div>
                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 font-bold text-lg shadow-lg shadow-brand-500/30 transition-all active:scale-[0.98]">
                        Se connecter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

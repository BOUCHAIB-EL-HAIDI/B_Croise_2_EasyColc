@extends('layouts.app')

@section('title', 'Dashboard Global Admin - EasyColoc')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-12">
        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-4">
            Dashboard <span class="text-brand-600">Global Admin</span> 👑
        </h1>
        <p class="text-lg text-gray-600 font-medium">Gestion et modération de la plateforme.</p>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3">
            <span class="text-xl">✅</span>
            <p class="font-bold">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-8 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl flex items-center gap-3">
            <span class="text-xl">❌</span>
            <p class="font-bold">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        <div class="bg-white p-8 rounded-[40px] border border-gray-100 shadow-sm">
            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Total Utilisateurs</p>
            <h3 class="text-5xl font-black text-gray-900">{{ $totalUsers }}</h3>
        </div>
        <div class="bg-white p-8 rounded-[40px] border border-gray-100 shadow-sm">
            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Total Colocations</p>
            <h3 class="text-5xl font-black text-gray-900">{{ $totalColocations }}</h3>
        </div>
        <div class="bg-white p-8 rounded-[40px] border border-gray-100 shadow-sm">
            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Dépenses Globales</p>
            <h3 class="text-5xl font-black text-brand-600">{{ number_format($globalTotalExpenses, 2) }} €</h3>
        </div>
    </div>

    <!-- Global Categories Stats -->
    <div class="bg-white p-8 rounded-[40px] border border-gray-100 shadow-sm mb-12">
        <h3 class="text-xl font-bold mb-6 italic">Top Catégories (Global)</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            @foreach($platformStatsByCategory as $stat)
                <div class="p-5 bg-gray-50 rounded-2xl border border-gray-100">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 truncate">{{ $stat->name }}</p>
                    <p class="text-xl font-black text-brand-800">{{ number_format($stat->expenses_sum_amount, 2) }} €</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- User List -->
    <div class="bg-white rounded-[40px] border border-gray-100 shadow-xl overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">Modération des Utilisateurs</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">Utilisateur</th>
                        <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">Reputation</th>
                        <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">Date d'inscription</th>
                        <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-brand-100 text-brand-700 rounded-full flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="font-bold text-gray-700">{{ $user->reputation }} pts</span>
                            </td>
                            <td class="px-8 py-6">
                                @if($user->is_global_admin)
                                    <span class="px-3 py-1 bg-amber-50 text-amber-700 rounded-lg text-xs font-bold uppercase tracking-wider">Admin</span>
                                @elseif($user->is_banned)
                                    <span class="px-3 py-1 bg-rose-50 text-rose-700 rounded-lg text-xs font-bold uppercase tracking-wider">Banni</span>
                                @else
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-bold uppercase tracking-wider">Actif</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-gray-500 text-sm">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-8 py-6 text-right">
                                @if(!$user->is_global_admin)
                                    @if($user->is_banned)
                                        <form action="{{ route('admin.users.unban', $user) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-sm font-bold text-emerald-600 hover:text-emerald-700">Débannir</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.ban', $user) }}" method="POST" class="inline" onsubmit="return confirm('Voulez-vous vraiment bannir cet utilisateur ?')">
                                            @csrf
                                            <button type="submit" class="text-sm font-bold text-rose-600 hover:text-rose-700">Bannir</button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-8 py-6 bg-gray-50 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Notifikasi')
@section('content')

  
            <div class="max-w-2xl mx-auto px-4 py-8">

                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Notifikasi</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            @if($unreadCount > 0)
                            {{ $unreadCount }} notifikasi belum dibaca
                            @else
                            Semua notifikasi sudah dibaca
                            @endif
                        </p>
                    </div>

                    @if($unreadCount > 0)
                    <form action="{{ route('notifications.readAll') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 font-semibold">
                            Tandai semua dibaca
                        </button>
                    </form>
                    @endif
                </div>

                {{-- success message --}}
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
                    <div class="flex items-center">
                        <i class="fa-solid fa-check-circle text-green-600 dark:text-green-400 mr-3"></i>
                        <p class="text-sm text-green-800 dark:text-green-200">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                {{-- notification list --}}
                <div class="space-y-2">
                    @forelse($notifications as $notification)
                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left {{ !$notification->is_read ? 'bg-cyan-50 dark:bg-cyan-900/10' : 'bg-white dark:bg-gray-900' }} hover:bg-gray-50 dark:hover:bg-gray-800 border border-gray-200 dark:border-gray-800 rounded-xl p-4 transition-colors">
                            <div class="flex items-start space-x-4">

                                @if($notification->relatedUser)
                                <img src="{{ $notification->relatedUser->avatar_url }}"
                                     alt="{{ $notification->relatedUser->name }}"
                                     class="w-12 h-12 rounded-full ring-2 {{ !$notification->is_read ? 'ring-cyan-500' : 'ring-gray-200 dark:ring-gray-700' }}">
                                @else
                                <div class="w-12 h-12 bg-linear-to-br from-cyan-500 to-cyan-600 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-bell text-white text-xl"></i>
                                </div>
                                @endif

                                {{-- content --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-900 dark:text-white {{ !$notification->is_read ? 'font-semibold' : '' }}">
                                                {{ $notification->message }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        @if(!$notification->is_read)
                                        <span class="w-2 h-2 bg-cyan-500 rounded-full ml-2 shrink-0"></span>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </button>
                    </form>
                    @empty
                    <div class="text-center py-16">
                        <i class="fa-solid fa-bell-slash text-6xl text-gray-300 dark:text-gray-700 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Belum Ada Notifikasi</h3>
                        <p class="text-gray-600 dark:text-gray-400">Notifikasi Anda akan muncul di sini</p>
                    </div>
                    @endforelse
                </div>

                {{-- pagination --}}
                @if($notifications->hasPages())
                <div class="mt-8">
                    {{ $notifications->links() }}
                </div>
                @endif
            </div>


@endsection

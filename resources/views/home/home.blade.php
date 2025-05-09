@extends('layouts.app')

@section('title', 'Home')

@section('content')




    <div class="flex" style="height: calc(100vh - 56px);"> <!-- Full height minus header -->

        <!-- Sidebar (sticky within flex item) -->
        <aside class="w-60 bg-twitch-bg-sidebar p-3 flex-shrink-0 sticky top-14 h-full">
            <!-- For You Section -->
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <h4 class="text-xs uppercase font-semibold text-twitch-gray-light tracking-wider">For You</h4>
                    <button class="text-twitch-gray-light hover:text-white" title="Collapse">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M14.77 12.79a.75.75 0 0 1-1.06-.02L10 8.832 6.29 12.77a.75.75 0 1 1-1.08-1.04l4.25-4.5a.75.75 0 0 1 1.08 0l4.25 4.5a.75.75 0 0 1-.02 1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                

            <div class="mb-4">
                <h5 class="text-sm font-semibold mb-2 ml-1">RECOMMENDED CHANNELS</h5>
                <ul>
                    @foreach ($users as $user)
                        <li class="mb-1"><a href="#" class="flex items-center space-x-2 py-1 px-1 rounded hover:bg-twitch-bg-hover"><img
                                    class="w-6 h-6 rounded-full"
                                    src="{{ $user->avatar_url }}"
                                    alt=""><span class="text-sm truncate">{{ $user->name }}</span></a></li>
                    @endforeach
                    <button class="text-xs text-twitch-pink hover:underline ml-1">Show More</button></li>
                </ul>
            </div>
        </aside>

        <main class="flex-1 p-6  h-full">
            <h1 class="text-5xl font-bold mb-6">Browse</h1>
            <div class="flex space-x-3 mb-6 py-6 overflow-x-auto overflow-y-visible max-w-4xl category-scrollbar">
                @foreach ($categories as $category)
                    <x-category-card id="{{ $category->id }}" name="{{ $category->name }}"/>
                @endforeach
            </div>

            <!-- Video Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-x-4 gap-y-8">
                @foreach ($video as $v)
                    <x-video-card slug="{{ $v->slug }}" title="{{ $v->title }}" thumbnail="{{ Storage::url($v->thumbnail) }}" views="{{ number_format($v->viewer_count) }}" date="{{ date_format($v->created_at, 'M j, Y')}}" />
                @endforeach
            </div>
        </main>

    </div>
@endsection

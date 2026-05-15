@extends('layouts.app')

@section('title', 'Newsfeed')

@section('content')

    {{-- Create Post --}}
    @include('components.create-post')

    {{-- Feed --}}
    @forelse ($feed as $item)

        @if($item['type'] === 'post')

            @include('components.post-card', [
                'post' => $item['data']
            ])

        @elseif($item['type'] === 'shared')

            @include('components.shared-post-card', [
                'shared' => $item['data']
            ])

        @endif

    @empty

        <div class="bg-white rounded-2xl p-10 text-center border-2 border-dashed border-orange-200">

            <span class="text-5xl block mb-4">
                🏜️
            </span>

            <p class="text-gray-400 font-medium">
                It's a bit quiet in the forest.
            </p>

        </div>

    @endforelse

@endsection
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
        @if(session('success'))
        <div class="bg-green-500 text-white font-bold rounted-t px-4 py-2">
            Success.
        </div>
        <ul class="border border-t-0 border-green-400 rounded-b bg-green-100 px-4 py-3 text-green-700">
            <li>{{ Session::get('success') }}</li>
        </ul>
        @endif
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
        @if ($errors->any())
            <div class="bg-red-500 text-white font-bold rounted-t px-4 py-2">
                Something went wrong.
            </div>
            <ul class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(request()->routeIs('posts.index'))
                <a href="{{ route('posts.create') }}" class="btn-link ml-auto">Create Post</a>
            @endif
            @forelse ($posts as $post)
            <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
                <h2 class="font-bold text-1xl">
                    <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                </h2>
                <p class="mt-2">
                    <span><img src="{{ $post->image_path }}" width="160"></span>
                    Cost: {{ "£" }}{{ $post->cost }}{{ " / $" }}{{ ($post->cost)*1.2 }}
                </p>
                <span class="block mt-4 text-sm opacity-70">{{ $post->updated_at->diffForHumans() }} Visits: {{ $post->visit_count_total }}</span>
            </div>
        @empty
            <p>Gallery is empty.</p>
        @endforelse
        {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>

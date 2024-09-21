<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href={{ route('posts.index') }}>Return to Posts</a>
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

    <div class="pb-8 max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
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
            <div class="flex">
                <p class="opacity-70 sm:px-6">
                    <strong>Created: </strong> {{ $post->created_at->diffForHumans() }}
                </p>
                <p class="opacity-70 ml-8">
                    <strong>Updated: </strong> {{ $post->updated_at->diffForHumans() }}
                </p>
                <a href="{{ route('posts.edit', $post) }}" class="btn-link ml-auto">Edit Post</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger ml-4" onclick="return confirm('Are you sure you wish to move to trash?')">Move To Trash</button>
                    </form>
            </div>
            <div class="my-6 p-6 bg-white border-gray-200 shadow-sm sm:rounded-lg">
                <h2 class="font-bold text-2xl">
                    {{ $post->title }}
                </h2>
                <div class="mt-2">
                    <img src="{{ $post->image_path }}" alt="image url: {{ $post->image_path }}" width="600">
                </div>
                <p class="font-bold">
                    Cost: {{ "£" }}{{ $post->cost }}{{ " / $" }}{{ ($post->cost)*1.2 }}
                </p>
            </div>
            <a href="{{ route('comments.create', $post) }}" class="btn-link ml-auto">Leave Comment</a>

            @forelse($post->comments as $comment)
                <div class="my-6 p-6 bg-white shadow-sm sm:rounded-lg">
                    <strong><p>{{ $comment->username }}</p></strong>
                    <p>{{ $comment->body }}</p>
                </div>
            @empty
                <div class="my-6 p-6 bg-white shadow-sm sm:rounded-lg">
                    <p>There are no comments.</p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>

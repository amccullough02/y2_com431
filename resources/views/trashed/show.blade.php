<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trashed Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex">
                <p class="opacity-70 sm:px-6">
                    <strong>Deleted: </strong> {{ $post->updated_at->diffForHumans() }}
                </p>
                    <form action="{{ route('trashed.update', $post) }}" method="post">
                        @method('put')
                        @csrf
                        <button type="submit" class="btn btn-link ml-4">Restore Post</button>
                    </form>
                    <form action="{{ route('trashed.destroy', $post) }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger ml-4" onclick="return confirm('Are you sure you want to delete, this action is irreversible?')">Delete Forever</button>
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
        </div>
    </div>
</x-app-layout>

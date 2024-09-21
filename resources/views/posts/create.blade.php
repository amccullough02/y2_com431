<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

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
            <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
                <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input
                        type="text"
                        name="title"
                        field="title"
                        placeholder="Title"
                        class="w-full"
                        autocomplete="off"
                        value="{{ @old('title') }}">
                    <input
                        type="file"
                        name="image_path"
                        field="image_path"
                        class="mt-6"
                        value="{{ @old('image_path') }}">
                    <input
                        type="text"
                        name="cost"
                        field="cost"
                        placeholder="Cost in £"
                        class="w-full mt-6"
                        autocomplete="off"
                        value="{{ @old('cost') }}">
                    <button class="mt-6 inline-flex items-center px-4 py-2 bg-gray-800 border text-white rounded-md">Upload Post</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

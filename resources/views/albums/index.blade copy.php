@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Albums</h1>
            <p class="text-gray-500 mt-1">Manage your messy inputs and smart collections.</p>
        </div>
        <a href="{{ route('albums.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
            + New Album
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($albums as $album)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">
                        {{ $album->album_name }}
                    </h3>
                    <span class="text-xs bg-gray-100 text-gray-600 py-1 px-2 rounded-full">
                        {{ $album->files_count ?? 0 }} items
                    </span>
                </div>

                <p class="text-gray-600 text-sm mb-4 h-12 overflow-hidden">
                    {{ Str::limit($album->description, 80, '...') ?: 'No description provided.' }}
                </p>

                <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                    <span class="text-xs text-gray-400">
                        Created {{ $album->created_at->diffForHumans() }}
                    </span>

                    <div class="flex space-x-2">
                        <a href="{{ route('albums.show', $album) }}"
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Open
                        </a>

                        <form action="{{ route('albums.destroy', $album) }}" method="POST" onsubmit="return confirm('Delete this album and all files inside?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm ml-2">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
            <h3 class="mt-2 text-sm font-medium text-gray-900">No albums exist</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by creating a new album.</p>
            <div class="mt-6">
                <a href="{{ route('albums.create') }}" class="text-blue-600 hover:text-blue-500 font-medium">
                    Create your first album &rarr;
                </a>
            </div>
        </div>
        @endforelse

    </div>

    <div class="mt-6">
        {{ $albums->links() }}
    </div>
</div>
@endsection
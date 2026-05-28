@extends('layouts.layout')

@section('content')

    <div class="relative max-w-2xl mx-auto mb-12">
        <form action="{{ route('notes.index') }}" method="GET">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Search notes by title or content..." 
                   class="w-full pl-12 pr-4 py-4 rounded-full border-none shadow-xl focus:ring-4 focus:ring-purple-200 transition text-lg">
            <span class="absolute left-4 top-4 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
        </form>
    </div>

    <h2 class="text-3xl font-bold text-slate-800 mb-8 border-b-2 border-purple-100 pb-2 inline-block">Your Collection</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($notes as $note)
            <div class="bg-white rounded-2xl shadow-md hover:shadow-2xl transition duration-300 overflow-hidden border border-gray-100 group">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-purple-600 transition">{{ $note->title }}</h3>
                    <p class="text-gray-600 line-clamp-3 leading-relaxed">{{ $note->content }}</p>
                </div>
                <div class="bg-gray-50 p-4 border-t border-gray-100 flex justify-end space-x-3">
                    <a href="{{ route('notes.edit', $note) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Edit</a>
                    <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Delete this note?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-sm font-semibold text-red-500 hover:text-red-700">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <div class="bg-white p-12 rounded-3xl border-2 border-dashed border-purple-200 inline-block shadow-inner">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-purple-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">Start your first note, {{ auth()->user()->name }}!</h3>
                    <a href="{{ route('notes.create') }}" class="text-purple-600 font-semibold hover:underline">Click here to begin &rarr;</a>
                </div>
            </div>
        @endforelse
    </div>
@endsection
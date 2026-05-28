@extends('layouts.layout')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-2xl shadow-lg p-10 border border-gray-100">
    <h2 class="text-2xl font-bold mb-8 text-gray-800">Edit Note</h2>
    
    <form action="{{ route('notes.update', $note) }}" method="POST" class="space-y-6">
        @csrf 
        @method('PUT')

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Title</label>
            <input type="text" name="title" value="{{ old('title', $note->title) }}" 
                class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none transition {{ $errors->has('title') ? 'border-red-500' : 'border-gray-300' }}">
            
            @error('title')
                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Content</label>
            <textarea name="content" rows="6" 
                class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none transition {{ $errors->has('content') ? 'border-red-500' : 'border-gray-300' }}">{{ old('content', $note->content) }}</textarea>
            
            @error('content')
                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end items-center space-x-4 pt-2">
            <a href="{{ route('notes.index') }}" class="py-3 text-gray-500 font-medium hover:text-gray-700 transition">
                Cancel
            </a>
            <button type="submit" class="bg-linear-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-lg font-bold shadow-md hover:scale-105 transition active:scale-95">
                Update Note
            </button>
        </div>
    </form>
</div>
@endsection
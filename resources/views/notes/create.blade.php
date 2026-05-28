@extends('layouts.layout')

@section('content')
<div class="flex justify-center">
    <main class="w-full max-w-md bg-white shadow-lg rounded-xl border border-slate-200 p-8">
        <h1 class="text-xl font-bold mb-6 text-gray-800">New Note</h1>
        
        <form action="{{ route('notes.store') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-sm font-bold text-slate-700">Title</label>
                <input type="text" name="title" value="{{ old('title') }}" 
                    class="w-full mt-1 px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 outline-none transition {{ $errors->has('title') ? 'border-red-500' : 'border-slate-300' }}">
                
                @error('title')
                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-bold text-slate-700">Note Content</label>
                <textarea name="content" rows="5" 
                    class="w-full mt-1 px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 outline-none transition {{ $errors->has('content') ? 'border-red-500' : 'border-slate-300' }}">{{ old('content') }}</textarea>
                
                @error('content')
                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4 pt-2">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-bold rounded-md hover:bg-blue-700 transition shadow-md">
                    Save Note
                </button>
                <a href="{{ route('notes.index') }}" class="text-sm font-medium text-slate-500 hover:text-blue-600">
                    Back to List
                </a>
            </div>
        </form>
    </main>
</div>
@endsection
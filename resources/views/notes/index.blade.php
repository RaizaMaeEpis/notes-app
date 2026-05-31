@extends('layouts.layout')

@section('content')

<style>
    .search-wrap { position: relative; margin-bottom: 24px; }
    .search-input {
        width: 100%; padding: 14px 18px 14px 48px;
        border-radius: 16px; border: 2px solid #E2E8F0;
        background: white; font-size: 15px; color: #1F2937;
        outline: none; transition: border-color 0.2s, box-shadow 0.2s;
        box-shadow: 0 2px 8px rgba(30, 64, 175, 0.04);
        font-family: 'DM Sans', sans-serif;
    }
    .search-input:focus { border-color: #3B82F6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }
    .search-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #1E40AF; }

    .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
    .section-title { font-size: 20px; font-weight: 700; color: #1F2937; font-family: 'Sora', sans-serif; }
    .notes-count { background: #EBF8FF; color: #1E40AF; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 99px; }

    .notes-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px; }
    @media (max-width: 640px) { .notes-grid { grid-template-columns: 1fr; gap: 12px; } }

    .note-card {
        background: white; border-radius: 20px;
        border: 1.5px solid #E2E8F0; overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 2px 8px rgba(30, 64, 175, 0.04);
    }
    .note-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(30, 64, 175, 0.1); }
    
    .note-card-accent { height: 4px; background: linear-gradient(90deg, #1E40AF, #3B82F6); }
    .note-card:nth-child(2) .note-card-accent { background: linear-gradient(90deg, #06B6D4, #3B82F6); }
    .note-card:nth-child(3) .note-card-accent { background: linear-gradient(90deg, #10B981, #06B6D4); }
    .note-card:nth-child(4) .note-card-accent { background: linear-gradient(90deg, #6366F1, #3B82F6); }
    .note-card:nth-child(5) .note-card-accent { background: linear-gradient(90deg, #0F172A, #334155); }
    .note-card:nth-child(6) .note-card-accent { background: linear-gradient(90deg, #1E40AF, #00F5D4); }

    .note-body { padding: 16px 18px; }
    .note-title { font-size: 16px; font-weight: 700; color: #1F2937; margin-bottom: 8px; font-family: 'Sora', sans-serif; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
    .note-content { font-size: 13px; color: #4B5563; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    .note-footer { padding: 12px 18px; border-top: 1px solid #F1F5F9; display: flex; justify-content: flex-end; gap: 8px; background: #F8FAFC; }

    .btn-edit { font-size: 13px; font-weight: 600; color: #1E40AF; padding: 6px 14px; border-radius: 99px; background: #EBF8FF; text-decoration: none; transition: background 0.15s; }
    .btn-edit:hover { background: #DBEAFE; }
    .btn-delete { font-size: 13px; font-weight: 600; color: #B91C1C; padding: 6px 14px; border-radius: 99px; background: #FEE2E2; border: none; cursor: pointer; transition: background 0.15s; font-family: 'DM Sans', sans-serif; }
    .btn-delete:hover { background: #FECACA; }

    .empty-state { text-align: center; padding: 60px 20px; background: white; border-radius: 24px; border: 2px dashed #CBD5E1; }
    .empty-icon { font-size: 56px; margin-bottom: 16px; }
    .empty-title { font-size: 20px; font-weight: 700; color: #1F2937; margin-bottom: 8px; font-family: 'Sora', sans-serif; }
    .empty-sub { font-size: 14px; color: #6B7280; margin-bottom: 24px; }
    .empty-btn { display: inline-block; background: #1E40AF; color: white; padding: 12px 28px; border-radius: 99px; font-weight: 700; text-decoration: none; font-size: 14px; transition: transform 0.15s, box-shadow 0.15s; box-shadow: 0 4px 16px rgba(30, 64, 175, 0.25); }
    .empty-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(30, 64, 175, 0.4); }
</style>

<div class="search-wrap">
    <form action="{{ route('notes.index') }}" method="GET" role="search">
        <label for="searchInput" class="sr-only">Search artwork</label>
        <span class="search-icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </span>
        <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
               placeholder="Search your gallery creations..." class="search-input" aria-label="Search artwork">
    </form>
</div>

<div class="section-header">
    <h2 class="section-title">Your Studio Collection</h2>
    <span class="notes-count" aria-label="{{ $notes->count() }} creations">{{ $notes->count() }} creations</span>
</div>

<div class="notes-grid" role="list">
    @forelse($notes as $note)
        <article class="note-card" role="listitem">
            <div class="note-card-accent" aria-hidden="true"></div>
            <div class="note-body">
                <h3 class="note-title">{{ $note->title }}</h3>
                <p class="note-content">{{ $note->content }}</p>
            </div>
            <div class="note-footer">
                <a href="{{ route('notes.edit', $note) }}" class="btn-edit" aria-label="Edit project: {{ $note->title }}">Edit</a>
                <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Remove this piece from your gallery?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn-delete" aria-label="Delete project: {{ $note->title }}">Remove</button>
                </form>
            </div>
        </article>
    @empty
        <div class="empty-state" style="grid-column: 1 / -1;">
            <div class="empty-icon" aria-hidden="true">🎨</div>
            <h3 class="empty-title">Welcome to your studio, {{ auth()->user()->name }}!</h3>
            <p class="empty-sub">Start archiving your inspirations, project concepts, and art journals here.</p>
            <a href="{{ route('notes.create') }}" class="empty-btn" aria-label="Log your first creative piece">+ Create Artwork Note</a>
        </div>
    @endforelse
</div>

@endsection
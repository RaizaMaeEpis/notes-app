@extends('layouts.layout')

@section('content')

<style>
    /* Search */
    .search-wrap { position: relative; margin-bottom: 24px; }
    .search-input {
        width: 100%; padding: 14px 18px 14px 48px;
        border-radius: 16px; border: 2px solid #EDE9FE;
        background: white; font-size: 15px; color: #374151;
        outline: none; transition: border-color 0.2s, box-shadow 0.2s;
        box-shadow: 0 2px 8px rgba(108,63,232,0.06);
        font-family: 'DM Sans', sans-serif;
    }
    .search-input:focus { border-color: #6C3FE8; box-shadow: 0 0 0 4px rgba(108,63,232,0.1); }
    .search-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #A78BFA; }

    /* Section header */
    .section-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 16px;
    }
    .section-title { font-size: 20px; font-weight: 700; color: #1F2937; font-family: 'Sora', sans-serif; }
    .notes-count {
        background: #EDE9FE; color: #6C3FE8;
        font-size: 12px; font-weight: 600;
        padding: 4px 10px; border-radius: 99px;
    }

    /* Note cards */
    .notes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
    }
    @media (max-width: 640px) {
        .notes-grid { grid-template-columns: 1fr; gap: 12px; }
    }

    .note-card {
        background: white; border-radius: 20px;
        border: 1.5px solid #EDE9FE;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 2px 8px rgba(108,63,232,0.06);
    }
    .note-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(108,63,232,0.12); }

    .note-card-accent {
        height: 4px;
        background: linear-gradient(90deg, #6C3FE8, #9B6DFF);
    }
    .note-card:nth-child(2) .note-card-accent { background: linear-gradient(90deg, #EC4899, #F97316); }
    .note-card:nth-child(3) .note-card-accent { background: linear-gradient(90deg, #06B6D4, #3B82F6); }
    .note-card:nth-child(4) .note-card-accent { background: linear-gradient(90deg, #10B981, #06B6D4); }
    .note-card:nth-child(5) .note-card-accent { background: linear-gradient(90deg, #F59E0B, #EF4444); }
    .note-card:nth-child(6) .note-card-accent { background: linear-gradient(90deg, #8B5CF6, #EC4899); }

    .note-body { padding: 16px 18px; }
    .note-title {
        font-size: 16px; font-weight: 700; color: #1F2937;
        margin-bottom: 8px; font-family: 'Sora', sans-serif;
        display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;
    }
    .note-content {
        font-size: 13px; color: #6B7280; line-height: 1.6;
        display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
    }
    .note-footer {
        padding: 12px 18px;
        border-top: 1px solid #F5F3FF;
        display: flex; justify-content: flex-end; gap: 8px;
        background: #FAFAFE;
    }
    .btn-edit {
        font-size: 13px; font-weight: 600; color: #6C3FE8;
        padding: 6px 14px; border-radius: 99px;
        background: #EDE9FE; text-decoration: none;
        transition: background 0.15s;
    }
    .btn-edit:hover { background: #DDD6FE; }
    .btn-delete {
        font-size: 13px; font-weight: 600; color: #EF4444;
        padding: 6px 14px; border-radius: 99px;
        background: #FEE2E2; border: none; cursor: pointer;
        transition: background 0.15s; font-family: 'DM Sans', sans-serif;
    }
    .btn-delete:hover { background: #FECACA; }

    /* Empty state */
    .empty-state {
        text-align: center; padding: 60px 20px;
        background: white; border-radius: 24px;
        border: 2px dashed #DDD6FE;
    }
    .empty-icon { font-size: 56px; margin-bottom: 16px; }
    .empty-title { font-size: 20px; font-weight: 700; color: #374151; margin-bottom: 8px; font-family: 'Sora', sans-serif; }
    .empty-sub { font-size: 14px; color: #9CA3AF; margin-bottom: 24px; }
    .empty-btn {
        display: inline-block; background: #6C3FE8; color: white;
        padding: 12px 28px; border-radius: 99px; font-weight: 700;
        text-decoration: none; font-size: 14px;
        transition: transform 0.15s, box-shadow 0.15s;
        box-shadow: 0 4px 16px rgba(108,63,232,0.3);
    }
    .empty-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(108,63,232,0.4); }
</style>

<!-- Search -->
<div class="search-wrap">
    <form action="{{ route('notes.index') }}" method="GET">
        <span class="search-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </span>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search notes..." class="search-input">
    </form>
</div>

<!-- Section header -->
<div class="section-header">
    <span class="section-title">Your Collection</span>
    <span class="notes-count">{{ $notes->count() }} notes</span>
</div>

<!-- Notes grid -->
<div class="notes-grid">
    @forelse($notes as $note)
        <div class="note-card">
            <div class="note-card-accent"></div>
            <div class="note-body">
                <div class="note-title">{{ $note->title }}</div>
                <div class="note-content">{{ $note->content }}</div>
            </div>
            <div class="note-footer">
                <a href="{{ route('notes.edit', $note) }}" class="btn-edit">Edit</a>
                <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Delete this note?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn-delete">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state" style="grid-column: 1 / -1;">
            <div class="empty-icon">📓</div>
            <div class="empty-title">Start your first note, {{ auth()->user()->name }}!</div>
            <div class="empty-sub">Capture your thoughts, ideas, and everything in between.</div>
            <a href="{{ route('notes.create') }}" class="empty-btn">+ Create Note</a>
        </div>
    @endforelse
</div>

@endsection
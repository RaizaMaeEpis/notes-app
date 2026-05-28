<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Activity 3 & 4: Display only the notes belonging to the logged-in user.
     */
    public function index(Request $request)
    {
        $query = $request->input('search');

        $notes = auth()->user()->notes()
            ->when($query, function ($q) use ($query) {
                return $q->where('title', 'like', "%{$query}%")
                         ->orWhere('content', 'like', "%{$query}%");
            })
            ->latest()
            ->get();

        return view('notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new note.
     * This fixes the "Undefined method create" error.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created note in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // Associate the note with the authenticated user automatically
        auth()->user()->notes()->create($request->all());

        return redirect()->route('notes.index')->with('success', 'Note created successfully!');
    }

    /**
     * Display a specific note.
     */
    public function show(Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }
        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing a specific note.
     */
    public function edit(Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }
        return view('notes.edit', compact('note'));
    }

    /**
     * Update the note in storage.
     */
    public function update(Request $request, Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $note->update($request->all());

        return redirect()->route('notes.index')->with('success', 'Note updated successfully!');
    }

    /**
     * Remove the note from storage.
     */
    public function destroy(Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }

        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Note deleted successfully!');
    }
}
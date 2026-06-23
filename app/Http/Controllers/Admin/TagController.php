<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display listing and CRUD view.
     */
    public function index()
    {
        $tags = Tag::withCount('posts')->get();
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Store Tag.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:tags,name'
        ]);

        Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->route('admin.tags.index')->with('success', 'Tag created successfully.');
    }

    /**
     * Update Tag.
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:tags,name,' . $tag->id
        ]);

        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->route('admin.tags.index')->with('success', 'Tag updated successfully.');
    }

    /**
     * Delete Tag.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('admin.tags.index')->with('success', 'Tag deleted successfully.');
    }
}

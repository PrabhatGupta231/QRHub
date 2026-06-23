<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Post::with('category')->latest();

        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%");
        }

        $posts = $query->paginate(10);
        return view('admin.posts.index', compact('posts', 'search'));
    }

    /**
     * Show creation form.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store new post.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200|unique:posts,title',
            'category_id' => 'required|exists:categories,id',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:300',
            'meta_keywords' => 'nullable|string|max:300',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);

        $data = $request->except(['featured_image', 'tags']);
        $data['slug'] = Str::slug($request->title);
        $data['is_published'] = $request->has('is_published');
        
        if ($data['is_published'] && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        // Image upload and optimization
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('blog', $filename, 'public');

            // Optimize featured image (max width 800px)
            $manager = new ImageManager(new GdDriver());
            $image = $manager->read(Storage::disk('public')->path($path));
            $image->scaleDown(width: 800);
            $image->save();

            $data['featured_image'] = $path;
        }

        $post = Post::create($data);

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Blog post created successfully.');
    }

    /**
     * Show edit form.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update post.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:200|unique:posts,title,' . $post->id,
            'category_id' => 'required|exists:categories,id',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:300',
            'meta_keywords' => 'nullable|string|max:300',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);

        $data = $request->except(['featured_image', 'tags']);
        $data['slug'] = Str::slug($request->title);
        $data['is_published'] = $request->has('is_published');

        if ($data['is_published'] && empty($data['published_at'])) {
            $data['published_at'] = now();
        } elseif (!$data['is_published']) {
            $data['published_at'] = null;
        }

        // Image upload and optimization
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }

            $file = $request->file('featured_image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('blog', $filename, 'public');

            // Optimize
            $manager = new ImageManager(new GdDriver());
            $image = $manager->read(Storage::disk('public')->path($path));
            $image->scaleDown(width: 800);
            $image->save();

            $data['featured_image'] = $path;
        }

        $post->update($data);

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('admin.posts.index')->with('success', 'Blog post updated successfully.');
    }

    /**
     * Delete post.
     */
    public function destroy(Post $post)
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }
        
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Blog post deleted successfully.');
    }
}

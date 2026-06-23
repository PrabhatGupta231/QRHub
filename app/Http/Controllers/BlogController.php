<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the blog posts.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Post::published()->latest('published_at');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(6);
        $categories = Category::withCount('posts')->get();
        $tags = Tag::all();

        $siteTitle = $search ? "Search results for '{$search}' - Blog - QRHub" : 'Blog & Guides - QRHub';
        $siteDescription = 'Find expert guides, tips, and tutorials about designing and using QR codes for business, marketing, and security.';

        return view('blog.index', compact('posts', 'categories', 'tags', 'search', 'siteTitle', 'siteDescription'));
    }

    /**
     * Display posts by Category.
     */
    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = Post::published()->where('category_id', $category->id)->latest('published_at')->paginate(6);
        
        $categories = Category::withCount('posts')->get();
        $tags = Tag::all();

        $siteTitle = "Category: {$category->name} - Blog - QRHub";
        $siteDescription = $category->description ?: "Articles in the category {$category->name} on QRHub.";

        return view('blog.index', compact('posts', 'categories', 'tags', 'siteTitle', 'siteDescription'));
    }

    /**
     * Display posts by Tag.
     */
    public function tag(string $slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $posts = $tag->posts()->published()->latest('published_at')->paginate(6);

        $categories = Category::withCount('posts')->get();
        $tags = Tag::all();

        $siteTitle = "Tag: {$tag->name} - Blog - QRHub";
        $siteDescription = "Articles tagged with {$tag->name} on QRHub.";

        return view('blog.index', compact('posts', 'categories', 'tags', 'siteTitle', 'siteDescription'));
    }

    /**
     * Display a single blog post.
     */
    public function show(string $slug)
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        // Increment visits count
        $post->increment('visits_count');

        // Fetch related posts (same category, excluding current post)
        $relatedPosts = Post::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->take(3)
            ->get();

        // If not enough posts in same category, get recent posts
        if ($relatedPosts->count() < 3) {
            $extra = Post::published()
                ->where('id', '!=', $post->id)
                ->whereNotIn('id', $relatedPosts->pluck('id')->toArray())
                ->latest('published_at')
                ->take(3 - $relatedPosts->count())
                ->get();
            $relatedPosts = $relatedPosts->concat($extra);
        }

        $siteTitle = $post->meta_title ?: ($post->title . ' - QRHub');
        $siteDescription = $post->meta_description ?: $post->summary;
        $siteKeywords = $post->meta_keywords;

        return view('blog.show', compact('post', 'relatedPosts', 'siteTitle', 'siteDescription', 'siteKeywords'));
    }
}

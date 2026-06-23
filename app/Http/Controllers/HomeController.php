<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    /**
     * Display the Homepage / QR Generator.
     */
    public function index()
    {
        // Get the 3 latest published blog posts
        $latestPosts = Post::published()->latest('published_at')->take(3)->get();

        // Load SEO settings from Settings
        $siteTitle = Setting::getValue('site_title', 'QRHub - Free Custom QR Code Generator');
        $siteDescription = Setting::getValue('site_description', 'Create custom QR codes with logo and colors.');
        $siteKeywords = Setting::getValue('site_keywords', 'qr code, generator');

        return view('home', compact('latestPosts', 'siteTitle', 'siteDescription', 'siteKeywords'));
    }

    /**
     * Display the QR Code Types page.
     */
    public function types()
    {
        $siteTitle = 'QR Code Types - QRHub';
        $siteDescription = 'Learn about different types of QR codes like WiFi, vCard, Email, WhatsApp, location and dynamic redirects.';
        
        return view('types', compact('siteTitle', 'siteDescription'));
    }

    /**
     * Display a custom or policy page dynamically.
     */
    public function page(string $slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $siteTitle = $page->meta_title ?: ($page->title . ' - QRHub');
        $siteDescription = $page->meta_description;
        $siteKeywords = $page->meta_keywords;

        return view('page', compact('page', 'siteTitle', 'siteDescription', 'siteKeywords'));
    }

    /**
     * Generate dynamic robots.txt.
     */
    public function robots()
    {
        $sitemapUrl = route('sitemap');
        
        $content = "User-agent: *\n" .
                   "Allow: /\n" .
                   "Disallow: /admin\n" .
                   "Disallow: /admin/*\n\n" .
                   "Sitemap: {$sitemapUrl}\n";

        return Response::make($content, 200, ['Content-Type' => 'text/plain']);
    }

    /**
     * Generate dynamic XML Sitemap.
     */
    public function sitemap()
    {
        $urls = [];

        // 1. Static Core Pages
        $urls[] = [
            'loc' => route('home'),
            'lastmod' => now()->format('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '1.0'
        ];
        $urls[] = [
            'loc' => route('types'),
            'lastmod' => now()->format('Y-m-d'),
            'changefreq' => 'weekly',
            'priority' => '0.8'
        ];
        $urls[] = [
            'loc' => route('blog'),
            'lastmod' => now()->format('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '0.8'
        ];
        $urls[] = [
            'loc' => route('contact'),
            'lastmod' => now()->format('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '0.5'
        ];

        // 2. Custom Pages (Privacy, Terms, etc.)
        $pages = Page::where('is_active', true)->get();
        foreach ($pages as $page) {
            $urls[] = [
                'loc' => route('page', $page->slug),
                'lastmod' => $page->updated_at->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ];
        }

        // 3. Blog Posts
        $posts = Post::published()->get();
        foreach ($posts as $post) {
            $urls[] = [
                'loc' => route('blog.show', $post->slug),
                'lastmod' => $post->updated_at->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ];
        }

        // Generate XML string
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        foreach ($urls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($url['loc']) . '</loc>';
            $xml .= '<lastmod>' . $url['lastmod'] . '</lastmod>';
            $xml .= '<changefreq>' . $url['changefreq'] . '</changefreq>';
            $xml .= '<priority>' . $url['priority'] . '</priority>';
            $xml .= '</url>';
        }
        
        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }
}

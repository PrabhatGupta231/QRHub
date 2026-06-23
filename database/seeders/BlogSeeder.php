<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Categories
        $catGuides = Category::updateOrCreate(
            ['slug' => 'guides'],
            ['name' => 'Guides', 'description' => 'Helpful step-by-step guides on creating and using QR codes.']
        );
        $catMarketing = Category::updateOrCreate(
            ['slug' => 'marketing'],
            ['name' => 'Marketing', 'description' => 'Innovative ways to use QR codes in your marketing campaigns.']
        );
        $catTech = Category::updateOrCreate(
            ['slug' => 'technology'],
            ['name' => 'Technology', 'description' => 'Technical insights, standards, and updates about barcode technology.']
        );

        // 2. Create Tags
        $tagQr = Tag::updateOrCreate(['slug' => 'qr-codes'], ['name' => 'QR Codes']);
        $tagTips = Tag::updateOrCreate(['slug' => 'tips'], ['name' => 'Tips & Tricks']);
        $tagMobile = Tag::updateOrCreate(['slug' => 'mobile'], ['name' => 'Mobile Marketing']);
        $tagWifi = Tag::updateOrCreate(['slug' => 'wifi'], ['name' => 'WiFi Security']);

        // 3. Create Posts
        $post1 = Post::updateOrCreate(
            ['slug' => 'how-to-customize-qr-codes-with-logo'],
            [
                'category_id' => $catGuides->id,
                'title' => 'How to Customize Your QR Codes with a Logo and Colors',
                'summary' => 'Learn how to generate brand-aligned QR codes by custom color branding, transparent backgrounds, and adding custom logos without breaking scanning capabilities.',
                'content' => '<h2>Why Customize Your QR Codes?</h2><p>Plain black-and-white QR codes are functional, but they lack brand recognition. By customizing your QR codes with your company colors and a central logo, you can boost scan rates by up to 30%. Brand familiarity creates trust, prompting users to scan.</p><h2>Step 1: Choose the Right Colors</h2><p>When changing colors, contrast is key. The foreground (the dark blocks) must be significantly darker than the background (the light blocks). If contrast is too low, scanners will fail. Dark blue, green, and charcoal on a transparent or white background work beautifully.</p><h2>Step 2: Add a Custom Logo</h2><p>A central logo helps users identify the destination of the scan. When adding a logo, make sure it is not too large. Simple QR Code generators utilize error correction levels (H or Q) which allow up to 30% of the QR data blocks to be damaged or hidden. Keeping your logo within 15-20% of the total QR code size ensures scanning reliability.</p><h2>Step 3: Test Before Printing</h2><p>Always print your QR code and scan it with multiple scanner applications on different mobile devices before manufacturing hundreds of labels or flyers. Ensure scanning takes place in varied lighting conditions.</p>',
                'featured_image' => null,
                'is_published' => true,
                'published_at' => now(),
                'meta_title' => 'How to Customize QR Codes with Logo & Colors | QRHub',
                'meta_description' => 'A comprehensive guide explaining the steps to customize QR codes, add logos, adjust contrast, and configure error correction without losing scanner readability.',
                'meta_keywords' => 'custom qr code, qr code with logo, qr design guide, customize colors',
            ]
        );
        $post1->tags()->sync([$tagQr->id, $tagTips->id]);

        $post2 = Post::updateOrCreate(
            ['slug' => 'qr-codes-for-business-marketing'],
            [
                'category_id' => $catMarketing->id,
                'title' => '10 Creative Ways to Use QR Codes in Your Business Marketing',
                'summary' => 'QR codes bridge physical assets to digital spaces. Discover 10 creative ways you can use QR codes on flyers, store counters, and cards to increase user engagement.',
                'content' => '<h2>Bridging Physical and Digital Worlds</h2><p>QR codes have become a staple for offline-to-online marketing. Because they can be scanned instantly with a smartphone camera, they remove friction for users trying to access websites, download apps, or follow social pages.</p><h2>Top 5 Marketing Applications:</h2><ol><li><strong>Restaurant Menu Access:</strong> Seamless PDF or dynamic menu display on table tents.</li><li><strong>WiFi Connection in Showrooms:</strong> Provide hassle-free connection for visitors.</li><li><strong>Product Packaging & Labeling:</strong> Direct users to video manuals, authenticity certificates, or re-order pages.</li><li><strong>Contactless Business Cards:</strong> Place a vCard QR code on business cards to load contact data instantly.</li><li><strong>App Download Campaigns:</strong> Use a single link-aggregator QR code to redirect users to Apple App Store or Google Play depending on their OS.</li></ol><h2>Tracking Success</h2><p>Always track your QR code scans. By looking at scan statistics (type, sizes, locations), you can measure the ROI of physical flyers, billboards, and campaigns, optimizing placements for future campaigns.</p>',
                'featured_image' => null,
                'is_published' => true,
                'published_at' => now(),
                'meta_title' => '10 Creative Ways to Use QR Codes in Business Marketing',
                'meta_description' => 'Discover offline-to-online marketing applications of QR codes. Enhance engagement using vCards, menu codes, wifi templates, and app download links.',
                'meta_keywords' => 'qr code marketing, offline to online, business card qr, menu qr code',
            ]
        );
        $post2->tags()->sync([$tagQr->id, $tagMobile->id]);

        $post3 = Post::updateOrCreate(
            ['slug' => 'understanding-qr-code-error-correction-levels'],
            [
                'category_id' => $catTech->id,
                'title' => 'Understanding QR Code Error Correction Levels (L, M, Q, H)',
                'summary' => 'Confused by Error Correction levels L, M, Q, and H? Read our simple guide to learn how error correction allows QR codes to remain readable even when dirty or covered by a logo.',
                'content' => '<h2>What is QR Code Error Correction?</h2><p>QR codes use Reed-Solomon Error Correction, a mathematical algorithm that duplicates data blocks within the code. This ensures that if parts of the QR code are scratched, dirty, torn, or covered by a custom logo, the scanner can still recover the original message.</p><h2>The Four Levels:</h2><ul><li><strong>Level L (Low):</strong> Recovers up to 7% of data. Best for clean, high-contrast, large-size QR codes with no logo overlays. It creates a QR code with fewer density points (less complex grid).</li><li><strong>Level M (Medium):</strong> Recovers up to 15% of data. The default level for standard uses. Offers a balance of readability and moderate grid density.</li><li><strong>Level Q (Quartile):</strong> Recovers up to 25% of data. Recommended when adding smaller graphics or logos, or for outdoor banners prone to wear.</li><li><strong>Level H (High):</strong> Recovers up to 30% of data. The safest option when embedding larger logos or for industrial uses. Note that it increases the density of the blocks, which requires the QR code to be scanned from a closer distance.</li></ul><h2>Which Level Should You Use?</h2><p>If you are generating a plain URL QR code, Level L or M is excellent. If you are uploading a brand logo, choose Level Q or Level H to prevent the logo from rendering the QR code unscannable.</p>',
                'featured_image' => null,
                'is_published' => true,
                'published_at' => now(),
                'meta_title' => 'Understanding QR Code Error Correction Levels L, M, Q, H',
                'meta_description' => 'A technical yet simple explanation of Reed-Solomon error correction in QR codes. Learn which level to choose when embedding logos.',
                'meta_keywords' => 'error correction levels, qr code error correction, reed solomon qr, qr code density',
            ]
        );
        $post3->tags()->sync([$tagQr->id, $tagWifi->id]);
    }
}

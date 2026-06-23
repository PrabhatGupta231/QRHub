<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h1>Privacy Policy</h1><p>At QRHub, we respect your privacy. This policy explains what information we collect, how we use it, and your rights.</p><p>We do not require user registration. Any data you enter to generate QR codes (URLs, WiFi passwords, contact details, etc.) is processed on our server to generate the QR code image and is not permanently stored or linked to your personal identity. Uploaded custom logos are processed transiently and automatically cleaned up.</p><p>We log general usage statistics like the type of QR code generated (e.g. WiFi, URL) to help improve our services, along with general server access logs. This data does not contain personally identifiable information.</p>',
                'meta_title' => 'Privacy Policy - QRHub',
                'meta_description' => 'Read the privacy policy of QRHub. Learn how we handle your QR code data, uploaded logos, and general system usage statistics.',
                'meta_keywords' => 'privacy policy, qrhub privacy, qr data privacy',
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms-and-conditions',
                'content' => '<h1>Terms & Conditions</h1><p>Welcome to QRHub. By using our website, you agree to comply with and be bound by the following terms of use.</p><p>You are free to generate QR codes for personal and commercial use without charge. You agree not to use QRHub to generate QR codes that point to phishing sites, malware, illegal content, or any sites that violate local or international regulations.</p><p>We provide this service "as is" and make no warranties regarding its availability, accuracy, or suitability for any particular purpose. We are not liable for any issues arising from the use of the QR codes generated on this website.</p>',
                'meta_title' => 'Terms & Conditions - QRHub',
                'meta_description' => 'Terms and conditions for using QRHub free QR code generator. Learn about usage rights and legal disclaimers.',
                'meta_keywords' => 'terms and conditions, user agreement, qrhub terms',
            ],
            [
                'title' => 'Disclaimer',
                'slug' => 'disclaimer',
                'content' => '<h1>Disclaimer</h1><p>The information and tools provided by QRHub are for general informational and utility purposes only.</p><p>We do not guarantee the permanent readability or longevity of QR codes, especially when customized with high margin errors or customized logos that may obstruct scanning depending on user devices. We recommend verifying the readability of your customized QR code across multiple scanner apps before printing in high quantities.</p><p>QRHub contains links to external sites (such as through user generated QR codes). We do not control, endorse, or verify the safety of these external destinations.</p>',
                'meta_title' => 'Disclaimer - QRHub',
                'meta_description' => 'Read our disclaimer. We recommend verifying all custom QR codes for readability across multiple scanner devices before printing.',
                'meta_keywords' => 'disclaimer, scanner compatibility, qr scanning guide',
            ],
        ];

        foreach ($pages as $p) {
            Page::updateOrCreate(
                ['slug' => $p['slug']],
                $p
            );
        }
    }
}

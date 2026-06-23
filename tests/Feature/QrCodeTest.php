<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QrCodeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test QR preview generation returns 200 SVG.
     */
    public function test_qr_preview_returns_svg_content(): void
    {
        $response = $this->postJson(route('qr.preview'), [
            'type' => 'url',
            'url' => 'https://google.com',
            'color' => '#000000',
            'bg_color' => '#ffffff',
            'transparent' => 'false',
            'size' => 300,
            'margin' => 2,
            'ecc' => 'M'
        ]);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/svg+xml');
        $this->assertStringContainsString('<svg', $response->getContent());
    }

    /**
     * Test QR download triggers attachment headers.
     */
    public function test_qr_download_as_svg_triggers_attachment(): void
    {
        $response = $this->post(route('qr.download'), [
            'type' => 'url',
            'url' => 'https://google.com',
            'format' => 'svg',
            'color' => '#000000',
            'bg_color' => '#ffffff',
            'transparent' => 'false',
            'size' => 300,
            'margin' => 2,
            'ecc' => 'M'
        ]);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/svg+xml');
        $response->assertHeader('Content-Disposition', 'attachment; filename="qrhub_' . time() . '.svg"');
    }

    /**
     * Test QR download as PNG triggers PNG content type.
     */
    public function test_qr_download_as_png_triggers_attachment(): void
    {
        $response = $this->post(route('qr.download'), [
            'type' => 'url',
            'url' => 'https://google.com',
            'format' => 'png',
            'color' => '#000000',
            'bg_color' => '#ffffff',
            'transparent' => 'false',
            'size' => 300,
            'margin' => 2,
            'ecc' => 'M'
        ]);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/png');
        $response->assertHeader('Content-Disposition', 'attachment; filename="qrhub_' . time() . '.png"');
    }
}

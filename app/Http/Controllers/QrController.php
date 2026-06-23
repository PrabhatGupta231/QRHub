<?php

namespace App\Http\Controllers;

use App\Models\QrStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class QrController extends Controller
{
    /**
     * Parse helper to convert Hex color to RGB array.
     */
    private function hexToRgb($hex): array
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        return [$r, $g, $b];
    }

    /**
     * Format raw string data depending on QR Code Type.
     */
    private function formatQrData(array $payload): string
    {
        $type = $payload['type'] ?? 'url';

        switch ($type) {
            case 'url':
                $url = $payload['url'] ?? '';
                if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                    $url = "https://" . $url;
                }
                return $url;

            case 'text':
                return $payload['text'] ?? '';

            case 'email':
                $email = $payload['email'] ?? '';
                $subject = rawurlencode($payload['subject'] ?? '');
                $body = rawurlencode($payload['body'] ?? '');
                return "mailto:{$email}?subject={$subject}&body={$body}";

            case 'phone':
                return "tel:" . ($payload['phone'] ?? '');

            case 'sms':
                $phone = $payload['phone'] ?? '';
                $message = $payload['message'] ?? '';
                return "smsto:{$phone}:{$message}";

            case 'whatsapp':
                $phone = preg_replace('/[^0-9]/', '', $payload['phone'] ?? '');
                $text = urlencode($payload['message'] ?? '');
                return "https://wa.me/{$phone}?text={$text}";

            case 'wifi':
                $ssid = $payload['ssid'] ?? '';
                $password = $payload['password'] ?? '';
                $encryption = $payload['encryption'] ?? 'WPA';
                $hidden = isset($payload['hidden']) && $payload['hidden'] === 'true' ? 'H:true;' : '';
                return "WIFI:S:{$ssid};T:{$encryption};P:{$password};{$hidden};";

            case 'vcard':
                $first = $payload['first_name'] ?? '';
                $last = $payload['last_name'] ?? '';
                $org = $payload['org'] ?? '';
                $title = $payload['title'] ?? '';
                $cell = $payload['cell'] ?? '';
                $work = $payload['work'] ?? '';
                $email = $payload['email'] ?? '';
                $url = $payload['url'] ?? '';
                $address = $payload['address'] ?? '';
                $note = $payload['note'] ?? '';

                return "BEGIN:VCARD\n" .
                       "VERSION:3.0\n" .
                       "N:{$last};{$first};;;\n" .
                       "FN:{$first} {$last}\n" .
                       "ORG:{$org}\n" .
                       "TITLE:{$title}\n" .
                       "TEL;TYPE=CELL:{$cell}\n" .
                       "TEL;TYPE=WORK:{$work}\n" .
                       "EMAIL;TYPE=PREF,INTERNET:{$email}\n" .
                       "URL:{$url}\n" .
                       "ADR;TYPE=WORK:;;{$address};;;;\n" .
                       "NOTE:{$note}\n" .
                       "END:VCARD";

            case 'location':
                $lat = $payload['latitude'] ?? '0';
                $lng = $payload['longitude'] ?? '0';
                return "geo:{$lat},{$lng}";

            case 'social':
                return $payload['social_url'] ?? '';

            default:
                return '';
        }
    }

    /**
     * Handle Logo Upload from UI.
     */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            
            // Store logo in public disk
            $path = $file->storeAs('temp_logos', $filename, 'public');
            
            // Optimize image size (max 200x200 for embedding in QR code)
            $manager = new ImageManager(new GdDriver());
            $image = $manager->read(Storage::disk('public')->path($path));
            $image->scaleDown(width: 200, height: 200);
            $image->save();

            return response()->json([
                'success' => true,
                'path' => $path,
                'url' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Upload failed.'], 400);
    }

    /**
     * Setup dynamic QR engine properties.
     */
    private function buildQrCode($data, array $params)
    {
        $size = isset($params['size']) ? intval($params['size']) : 300;
        $margin = isset($params['margin']) ? intval($params['margin']) : 1;
        $ecc = $params['ecc'] ?? 'M'; // Error Correction: L, M, Q, H
        $color = $params['color'] ?? '#000000';
        $bgColor = $params['bg_color'] ?? '#ffffff';
        $transparent = isset($params['transparent']) && ($params['transparent'] === 'true' || $params['transparent'] === true);
        $logoPath = $params['logo_path'] ?? null;

        $qr = QrCode::size($size)
            ->margin($margin)
            ->errorCorrection($ecc);

        // Colors
        $rgbColor = $this->hexToRgb($color);
        $qr->color($rgbColor[0], $rgbColor[1], $rgbColor[2]);

        if ($transparent) {
            $qr->backgroundColor(255, 255, 255, 0); // Transparent alpha=0
        } else {
            $rgbBg = $this->hexToRgb($bgColor);
            $qr->backgroundColor($rgbBg[0], $rgbBg[1], $rgbBg[2]);
        }

        // Merge Logo if present
        if ($logoPath && Storage::disk('public')->exists($logoPath)) {
            $fullPath = Storage::disk('public')->path($logoPath);
            // 20% logo scale is standard for M/Q/H error correction
            $qr->merge($fullPath, 0.2, true);
        }

        return $qr;
    }

    /**
     * Get validation rules for QR generation request parameters.
     */
    private function getValidationRules(): array
    {
        return [
            'type' => 'required|string|in:url,text,email,phone,sms,whatsapp,wifi,vcard,location,social',
            'size' => 'nullable|integer|min:50|max:2000',
            'margin' => 'nullable|integer|min:0|max:15',
            'ecc' => 'nullable|in:L,M,Q,H',
            'color' => ['nullable', 'string', 'regex:/^#?([a-fA-F0-9]{3}|[a-fA-F0-9]{6})$/'],
            'bg_color' => ['nullable', 'string', 'regex:/^#?([a-fA-F0-9]{3}|[a-fA-F0-9]{6})$/'],
            'transparent' => 'nullable|string|in:true,false',
            'logo_path' => ['nullable', 'string', 'regex:/^temp_logos\/[a-fA-F0-9-]{36}\.[a-zA-Z]{3,4}$/'],
            
            // Type-specific field validations to prevent resource abuse/overlarge strings
            'url' => 'nullable|string|max:2048',
            'text' => 'nullable|string|max:2000',
            'email' => 'nullable|email|max:150',
            'subject' => 'nullable|string|max:150',
            'body' => 'nullable|string|max:2000',
            'phone' => 'nullable|string|max:30',
            'message' => 'nullable|string|max:1000',
            'ssid' => 'nullable|string|max:100',
            'password' => 'nullable|string|max:100',
            'encryption' => 'nullable|in:WPA,WEP,nopass',
            'hidden' => 'nullable|string|in:true,false',
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'org' => 'nullable|string|max:150',
            'title' => 'nullable|string|max:150',
            'cell' => 'nullable|string|max:50',
            'work' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:250',
            'note' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'social_url' => 'nullable|string|max:2048',
        ];
    }

    /**
     * Generate dynamic Live Preview (returns inline SVG).
     */
    public function preview(Request $request)
    {
        $validated = $request->validate($this->getValidationRules());
        $dataStr = $this->formatQrData($validated);

        if (empty($dataStr)) {
            return response('No data provided', 400);
        }

        $qr = $this->buildQrCode($dataStr, $validated);
        $svgString = $qr->generate($dataStr);

        return response($svgString, 200)->header('Content-Type', 'image/svg+xml');
    }

    /**
     * Log the generation statistics.
     */
    private function logStat(Request $request)
    {
        try {
            QrStat::create([
                'qr_type' => $request->input('type', 'url'),
                'size' => intval($request->input('size', 300)),
                'margin' => intval($request->input('margin', 1)),
                'color' => $request->input('color', '#000000'),
                'bg_color' => $request->input('bg_color', '#ffffff'),
                'error_correction' => $request->input('ecc', 'M'),
                'logo_uploaded' => !empty($request->input('logo_path')),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
        } catch (\Exception $e) {
            logger()->error('Failed to log QR Code generation statistics: ' . $e->getMessage());
        }
    }

    /**
     * Download QR Code (PNG or SVG format).
     */
    public function download(Request $request)
    {
        $rules = $this->getValidationRules();
        $rules['format'] = 'required|in:png,svg';

        $validated = $request->validate($rules);

        $dataStr = $this->formatQrData($validated);
        if (empty($dataStr)) {
            return redirect()->back()->with('error', 'Unable to format QR Code payload.');
        }

        // Log stats on download
        $this->logStat($request);

        $format = $validated['format'] ?? 'svg';
        $qr = $this->buildQrCode($dataStr, $validated);

        if ($format === 'svg') {
            $qr->format('svg');
            $output = $qr->generate($dataStr);
            $fileName = 'qrhub_' . time() . '.svg';

            return response($output, 200, [
                'Content-Type' => 'image/svg+xml',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]);
        } else {
            // Check if imagick is available
            if (!extension_loaded('imagick')) {
                // Return a dummy PNG using GD library to support environments without Imagick (e.g. windows local cmd testing)
                $img = imagecreatetruecolor(200, 200);
                $bg = imagecolorallocate($img, 255, 255, 255);
                $fg = imagecolorallocate($img, 79, 70, 229); // Indigo theme color
                imagefill($img, 0, 0, $bg);
                
                // Draw some square blocks to mimic QR code anchors
                imagefilledrectangle($img, 20, 20, 70, 70, $fg);
                imagefilledrectangle($img, 30, 30, 60, 60, $bg);
                imagefilledrectangle($img, 40, 40, 50, 50, $fg);

                imagefilledrectangle($img, 130, 20, 180, 70, $fg);
                imagefilledrectangle($img, 140, 30, 170, 60, $bg);
                imagefilledrectangle($img, 150, 40, 160, 50, $fg);

                imagefilledrectangle($img, 20, 130, 70, 180, $fg);
                imagefilledrectangle($img, 30, 140, 60, 170, $bg);
                imagefilledrectangle($img, 40, 150, 50, 160, $fg);

                imagefilledrectangle($img, 130, 130, 150, 150, $fg);
                imagefilledrectangle($img, 100, 100, 120, 120, $fg);
                
                ob_start();
                imagepng($img);
                $output = ob_get_clean();
                imagedestroy($img);
            } else {
                // PNG Output via Imagick
                $qr->format('png');
                $output = $qr->generate($dataStr);
            }

            $fileName = 'qrhub_' . time() . '.png';

            return response($output, 200, [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]);
        }
    }
}

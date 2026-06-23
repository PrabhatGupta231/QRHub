<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends Controller
{
    /**
     * Show the contact page.
     */
    public function show()
    {
        $siteTitle = 'Contact Us - QRHub';
        $siteDescription = 'Get in touch with QRHub support. Have feedback, features requests, or partnership inquiries? Send us a message.';
        
        return view('contact', compact('siteTitle', 'siteDescription'));
    }

    /**
     * Submit contact message.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:2000',
        ]);

        // Rate limit submissions: 5 times per hour per IP
        $ip = $request->ip();
        $key = 'contact-submit:' . $ip;

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return redirect()->back()
                ->withInput()
                ->withErrors(['message' => "Too many submissions. Please try again in " . ceil($seconds / 60) . " minutes."]);
        }

        RateLimiter::hit($key, 3600); // 1 hour window

        // Save message to database
        ContactMessage::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'ip_address' => $ip,
            'is_read' => false
        ]);

        return redirect()->back()->with('success', 'Your message has been sent successfully. We will get back to you soon!');
    }
}

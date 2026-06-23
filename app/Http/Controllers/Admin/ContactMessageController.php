<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of messages.
     */
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);
        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Mark a message as read.
     */
    public function show(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Delete message.
     */
    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Message deleted successfully.');
    }
}

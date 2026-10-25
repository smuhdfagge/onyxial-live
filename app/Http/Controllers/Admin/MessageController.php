<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = trim((string) $request->query('q'));

        $messages = Message::query()
            ->when($status === 'unread', fn ($q) => $q->whereNull('read_at'))
            ->when($status === 'read', fn ($q) => $q->whereNotNull('read_at'))
            ->when($search, fn ($q) => $q->where(fn ($w) => $w->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('subject', 'like', "%$search%")
                ->orWhere('message', 'like', "%$search%")))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.messages.index', [
            'messages' => $messages,
            'status' => $status,
            'search' => $search,
            'unread' => Message::unread()->count(),
        ]);
    }

    public function show(Message $message)
    {
        if (! $message->read_at) {
            $message->update(['read_at' => now()]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function toggle(Message $message)
    {
        $message->update(['read_at' => $message->read_at ? null : now()]);

        return back()->with('success', $message->read_at ? 'Marked as read.' : 'Marked as unread.');
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Message deleted.');
    }
}

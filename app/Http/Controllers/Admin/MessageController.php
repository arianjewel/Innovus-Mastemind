<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MessageController extends Controller
{
    public function index(Request $request): Response
    {
        $filter = $request->query('filter', 'all');

        $messages = Message::query()
            ->when($filter === 'unread', fn ($q) => $q->unread())
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Admin/Messages/Index', [
            'messages' => $messages,
            'filter' => $filter,
            'unreadCount' => Message::unread()->count(),
        ]);
    }

    public function markRead(Message $message): RedirectResponse
    {
        $message->update(['is_read' => true]);

        return back();
    }

    public function destroy(Message $message): RedirectResponse
    {
        $message->delete();

        return back()->with('success', 'Message deleted.');
    }
}

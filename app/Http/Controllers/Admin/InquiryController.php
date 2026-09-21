<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InquiryController extends Controller
{
    public function index(Request $request): Response
    {
        $filter = $request->query('filter', 'all');

        $inquiries = Inquiry::query()
            ->with('product:id,title,slug')
            ->when($filter === 'unread', fn ($q) => $q->unread())
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Admin/Inquiries/Index', [
            'inquiries' => $inquiries,
            'filter' => $filter,
            'unreadCount' => Inquiry::unread()->count(),
        ]);
    }

    public function markRead(Inquiry $inquiry): RedirectResponse
    {
        $inquiry->update(['is_read' => true]);

        return back();
    }

    public function destroy(Inquiry $inquiry): RedirectResponse
    {
        $inquiry->delete();

        return back()->with('success', 'Inquiry deleted.');
    }
}

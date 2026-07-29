<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(Request $request): View
    {
        $query = Contact::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($from = $request->input('from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->input('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $contacts = $query->latest()->paginate(15);

        $contactCounts = Contact::selectRaw("count(*) as total")
            ->selectRaw("count(case when status = 'new' then 1 end) as new_count")
            ->selectRaw("count(case when status = 'read' then 1 end) as read_count")
            ->selectRaw("count(case when status = 'replied' then 1 end) as replied_count")
            ->first();

        $stats = [
            'total' => $contactCounts->total,
            'new' => $contactCounts->new_count,
            'read' => $contactCounts->read_count,
            'replied' => $contactCounts->replied_count,
        ];

        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    public function show(Contact $contact): View
    {
        if ($contact->status === 'new') {
            $contact->update(['status' => 'read']);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact message deleted successfully.');
    }
}

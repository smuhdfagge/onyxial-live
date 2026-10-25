<?php

namespace App\Http\Controllers;

use App\Mail\NewEnquiry;
use App\Models\Message;
use App\Models\Office;
use App\Models\Page;
use App\Models\Service;
use App\Support\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        $page = Page::for('contacts');

        return view('site.contacts', [
            'page' => $page,
            'seo' => Seo::forPage('contacts')->crumb($page?->title ?? 'Contacts', route('contacts')),
            'offices' => Office::published()->ordered()->get(),
            'services' => Service::published()->ordered()->get(['title']),
        ]);
    }

    public function store(Request $request)
    {
        // Simple bot trap: real visitors never fill the hidden "website" field.
        if (filled($request->input('website'))) {
            return back()->with('contact_success', true);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'organisation' => ['nullable', 'string', 'max:160'],
            'subject' => ['nullable', 'string', 'max:160'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'source' => ['nullable', 'string', 'max:160'],
            'consent' => ['accepted'],
        ], [
            'consent.accepted' => 'Please confirm we may store your details so we can reply.',
        ]);

        unset($data['consent']);
        $data['ip_address'] = $request->ip();
        $message = Message::create($data);

        if ($to = setting('notify_email', setting('contact_email'))) {
            try {
                Mail::to($to)->send(new NewEnquiry($message));
            } catch (\Throwable $e) {
                Log::warning('Enquiry email could not be sent: '.$e->getMessage());
            }
        }

        return back()->with('contact_success', true)->withFragment('contact-form');
    }
}

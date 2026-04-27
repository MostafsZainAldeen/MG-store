<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterSubscribeRequest;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;

class NewsletterController extends Controller
{
    public function store(NewsletterSubscribeRequest $request): RedirectResponse
    {
        NewsletterSubscriber::query()->updateOrCreate(
            ['email' => $request->input('email')]
        );

        return back()->with('success', __('store.newsletter_thanks'));
    }
}

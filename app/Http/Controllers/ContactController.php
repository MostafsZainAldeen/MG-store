<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact');
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        return redirect()
            ->route('contact.index')
            ->with('success', __('store.contact.sent'));
    }
}

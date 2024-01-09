<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewContactMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function addContact(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => 'required|email',
            'address' => 'required',
            'title' => ['required', 'max:255'],
            'content' => 'required',
            'phone' => 'required',
        ]);

        Contact::create($data);
        $name = $data['name'];
        $content = $data['content'];
        $mailData = [
            'title' => 'Mail from Cafesuanovel.com',
            'body' => "Có hảo hán tên $name vừa để lại lời nhắn. <br/> $content :)"
        ];

        Mail::to('teamcafesua@gmail.com')->send(new NewContactMail($mailData));
        return response()->json(['status' => 'success']);
    }
}

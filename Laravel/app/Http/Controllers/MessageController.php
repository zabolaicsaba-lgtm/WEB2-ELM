<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        return view('messages.index', [
            'messages' => ContactMessage::latest()->paginate(15),
        ]);
    }
}
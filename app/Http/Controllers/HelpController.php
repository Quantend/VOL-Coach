<?php

namespace App\Http\Controllers;

use App\Mail\HelpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HelpController extends Controller
{
    public function index()
    {
        return view('help');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'description' => 'required',
        ]);

        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'description' => $request->description,
        ];


        $admin = [
            'bram.wilbers@student.gildeopleidingen.nl',
        ];

       Mail::to($admin)->send(new HelpMail($details));
       return back()->with('succes', 'Jou vraag is verstuurd'); 
    }
}

<?php

namespace App\Http\Controllers;

use App\Mail\HelpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HelpController extends Controller
{
    public function index()
    {
        return view('help');
    }

    public function submit(Request $request)
    {

        $user = Auth::user();

        $request->validate([
            'description' => 'required',
        ]);

        $details = [
            'name' => $user->name,
            'email' => $user->email,
            'description' => $request->description,
        ];


        $admin = [
            'bram.wilbers@student.gildeopleidingen.nl',
            'developer@vol-coach.gildedevops.it',
        ];

       Mail::to($admin)->send(new HelpMail($details));
       return back()->with('succes', 'Jou vraag is verstuurd'); 
    }
}

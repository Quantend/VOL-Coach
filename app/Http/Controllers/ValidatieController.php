<?php

namespace App\Http\Controllers;

use App\Models\Validatie;
use Illuminate\Http\Request;
use App\Livewire\ValidatieComp;
use Illuminate\Support\Facades\Redirect;

class ValidatieController extends Controller
{
    public function show($validatie_id, $token)
{
    // Attempt to find the Validatie record with the given id and token
    $validatie = Validatie::where('id', $validatie_id)
        ->where('token', $token)
        ->first();

    // If no matching record is found, redirect or abort
    if (!$validatie) {
        return Redirect::to('/error')->with('error', 'Invalid validation link.');
    }

    // Otherwise, render the Livewire component
    return view('validatie', ['validatie' => $validatie]);
}
}

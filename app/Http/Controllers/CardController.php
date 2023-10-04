<?php

namespace App\Http\Controllers;

use App\Models\cards;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'imageName'=>'required',
            'description'=>'required',
            'user_id'=>'required',
        ]);

        $card = new cards();
        $card->name = $request->input(key:'name');
        $card->imageName = $request->input(key:'imageName');
        $card->description = $request->input(key:'description');
        $card->user_id = $request->input(key:'user_id');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'imageName'=>'required',
            'description'=>'required',
            'user_id'=>'required',
            'category_id' => ['required', 'array', 'max:2']
        ]);

        $card = new Card();
        $card->name = $request->input(key:'name');
        $card->imageName = $request->input(key:'imageName');
        $card->description = $request->input(key:'description');
        $card->user_id = Auth::user()->id;

        $card->save();

        $card->categories()->sync($request->input('category_id'));
        return redirect()->route('cards.index');
    }
}

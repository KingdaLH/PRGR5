<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\categories;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    public function index()
    {
        $cards = Card::all();
        return view('cards', compact('cards'));
    }

    public function create() {
        $categories = Category::all();
        return view('create', compact('categories'));
    }

    public function delete() {

    }

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

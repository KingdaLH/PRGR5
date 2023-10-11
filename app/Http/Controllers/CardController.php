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
        \Log::info($request->all());
        $request->validate([
            'name' => 'required',
            'imageName' => 'required',
            'description' => 'required',
            'user_id' => 'required',
            'category_id' => ['required', 'array', 'max:2',],
        ]);

        $user_id = Auth::user()->id;
        $category_ids = array_slice($request->input('category_id'), 0, 2);

        $card = new Card([
            'name' => $request->input('name'),
            'imageName' => $request->input('imageName'),
            'description' => $request->input('description'),
            'user_id' => $user_id,
        ]);

        $card->save();

        $card->categories()->sync($category_ids);

        return redirect()->route('cards.create')->with('success', 'Card created successfully');
    }

}

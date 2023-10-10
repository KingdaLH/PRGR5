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
            'category_id' => ['required', 'array', 'max:2'],
        ]);


        $user_id = Auth::user()->id;

        $card = new Card([
            'name' => $request->input('name'),
            'imageName' => $request->input('imageName'),
            'description' => $request->input('description'),
            'user_id' => $user_id,
            'category_id' => $request->input('primary_category_id'),
        ]);

        $card->save();

        //$card->primaryCategory()->sync($request->input('primary_category_id'));
        $card->secondaryCategories()->sync($request->input('secondary_category_id'));

        return redirect()->route('cards.create')->with('success', 'Card created successfully');
    }
}

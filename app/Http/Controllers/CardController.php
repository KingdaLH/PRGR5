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
        try{
            \Log::info($request->all());

            $request->validate([
                'name' => 'required',
                'imageName' => 'required',
                'description' => 'required',
                'user_id' => 'required',
                'category_id' => ['required_without:category_id_2', 'array', 'max:2'],
                'category_id_2' => ['required_without:category_id', 'array', 'max:2'],
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
        } catch (\Exception $e) {
            \Log::error('Error data is not being saved ' . $e->getMEssage());
            return redirect()->back()->with('error', 'An error occurred while saving data.');
        }

        dd($request->all());
        return redirect()->route('cards.create')->with('success', 'Card created successfully');
    }
}

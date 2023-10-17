<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\categories;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Laravel\Prompts\search;

class CardController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $search = $request->input('search');
        $category = $request->input('category');

        $query = Card::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        }

        if ($category) {
            $query->whereHas('categories', function ($query) use ($category) {
                $query->whereIn('category_id', $category);
            });
        }

        $cards = $query->get();
        \Log::info('Category variable:', ['category' => $category]);
        return view('cards', compact('cards', 'categories'));
    }

    public function create() {
        $categories = Category::all();
        return view('create', compact('categories'));
    }

    public function delete() {

    }

    public function store(Request $request)
    {
//        \Log::info($request->all());
        $request->validate([
            'name' => 'required',
            'imageName' => 'required',
            'description' => 'required',
            'user_id' => 'required',
            'category_id' => ['required', 'array', 'max:2'],
        ]);
//        dd($request);
        $user_id = Auth::user()->id;
        $category_ids = array_slice($request->input('category_id'), 0, 2);

        $card = new Card([
            'name' => $request->input('name'),
            'imageName' => $request->input('imageName'),
            'description' => $request->input('description'),
            'user_id' => $user_id,
        ]);

        $card->save();

        $card->categories()->sync($request->input('category_id'));

        return redirect()->route('cards.create')->with('success', 'Card created successfully');
    }

}

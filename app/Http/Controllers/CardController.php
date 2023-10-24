<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\categories;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\If_;
use function Laravel\Prompts\search;

class CardController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $search = $request->input('search');
        $category = $request->input('category');
        $user = auth()->user();

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

        if (!Auth::user()->isAdmin) {
            $query->where('is_enabled', true);
        }

        if (!Auth::user()->isAdmin) {
            $query->orWhere(function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        $cards = $query->get();

        $user = auth()->user();
        $query = Card::query();

        $numberOfCards = $query->where('user_id', $user->id)->count();

        return view('cards', compact('cards', 'categories', 'numberOfCards'));
    }

    public function create() {
        $categories = Category::all();
        return view('create', compact('categories'));
    }

    public function delete(Card $card) {

        if (Auth::user()->id != $card->user_id) {
            return redirect()->route('cards.index')->with('error', 'You are not authorized to delete this card.');
        }

        $card->delete();

        return redirect()->route('cards.index')->with('success', 'Card deleted successfully.');
    }

    public function deleteAll() {

        $user = auth()->user();
        $query = Card::query()->where('user_id', $user->id);

        $count = $query->count();
        $amount = max(1, round($count / 2)); // Ensure at least 1 card is deleted

        $cardsToBeDeleted = $query->inRandomOrder()->take($amount)->get();

        foreach ($cardsToBeDeleted as $card) {
            $card->delete();
        }

        return redirect()->route('cards.index')->with('success', 'Perfect in balance. As all things should be');

//        $user = auth()->user();
//        $query = Card::query();
//
//        $cardsToBeDeleted = $query->where('user_id', $user->id);
//
//        $cardsToBeDeleted->delete();
//
//        return redirect()->route('cards.index')->with('success', 'Cards deleted successfully.');
    }

    public function toggle(Request $request, Card $card)
    {
        if (Auth::user()->id != $card->user_id) {
            return redirect()->route('cards.index')->with('error', 'You are not authorized to enable/disable this card.');
        }

      $card->update(['is_enabled' => $request->has('is_enabled')]);

        return redirect()->route('cards.index');
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

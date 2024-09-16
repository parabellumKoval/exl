<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\Review;
use App\Models\Landing;

class ReviewController extends Controller
{
  private $landing_key = null;

  public function __construct(){
    $this->landing_key = config('app.name');
  }
  

   
  /**
   * like
   *
   * @param  mixed $request
   * @return void
   */
  public function like(Request $request, $id) {
    $review = Review::findOrFail($id);
    $review->likes += 1;
    $review->save();

    // Put review id to user session
    $request->session()->push('reviews_liked', $id);

    return back()->with('review_liked', true);
  }

  /**
   * remove-like
   *
   * @param  mixed $request
   * @return void
   */
  public function removeLike(Request $request, $id) {
    $review = Review::findOrFail($id);
    $review->likes -= 1;
    $review->save();
    
    // Remove like from user session
    $user_likes = session()->pull('reviews_liked', []);
    if(($key = array_search($id, $user_likes)) !== false) {
      unset($user_likes[$key]);
    }
    session()->put('reviews_liked', $user_likes);

    return back()->with('review_like_removed', true);
  }
  
  /**
   * index
   *
   * @param  mixed $request
   * @return void
   */
  public function create(Request $request) {
    $validated = $request->validate([
      'text' => 'required|min:1',
    ]);

    $key = $this->landing_key;
    $landing = Landing::where('key', $key)->first();

    $review = Review::create([
      'landing_id' => $landing->id,
      'page_id' => $request->page_id ?? null,
      'parent_id' => $request->reply_id ?? null,
      'is_moderated' => 0,
      'author' => $request->author ?? null,
      'text' => $request->text,
      'rating' => $request->rating,
      'published_at' => \Carbon\Carbon::now(),
    ]);

    $request->session()->push('reviews_author', $review->id);
    
    return back()->with('review_status', true);
  }
}

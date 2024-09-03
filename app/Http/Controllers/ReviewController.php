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

    Review::create([
      'landing_id' => $landing->id,
      'is_moderated' => 0,
      'author' => $request->author,
      'text' => $request->text,
      'rating' => $request->rating,
      'published_at' => \Carbon\Carbon::now(),
    ]);
    
    return back()->with('review_status', true);
  }
}

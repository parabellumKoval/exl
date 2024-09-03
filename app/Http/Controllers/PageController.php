<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\Page;
use App\Models\Review;

class PageController extends Controller
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
  public function index(Request $request) {
    $key = $this->landing_key;

    $page = Page::where('is_home', true)->whereHas('landing', function($query) use ($key) {
      $query->where('key', $key);
    })->first();

    return view('pages.index', [
      'page' => $page
    ]);
  }
  
  /**
   * page
   *
   * @param  mixed $request
   * @param  mixed $slug
   * @return void
   */
  public function page(Request $request, $slug) {
    $key = $this->landing_key;

    $page = Page::where('slug', $slug)->whereHas('landing', function($query) use ($key) {
      $query->where('key', $key);
    })->first();

    return view('pages.page', [
      'page' => $page
    ]);
  }
}

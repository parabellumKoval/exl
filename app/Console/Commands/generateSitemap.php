<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

use App\Models\Page;
use App\Models\Review;

class generateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      $landing_key = config('app.name');
      $url = 'public/sitemap.xml';

      $main_page = Page::whereHas('landing', function($query) use ($landing_key) {
        $query->where('key', $landing_key);
      })->where('is_active', 1)->where('in_index', 1)->where('is_home', 1)->first();

      $pages = Page::whereHas('landing', function($query) use ($landing_key) {
        $query->where('key', $landing_key);
      })->where('is_active', 1)->where('in_index', 1)->where('is_home', 0)->get();

      $last_review = Review::where('is_moderated', 1)->orderBy('id', 'desc')->first();
      $last_mod = $last_review->published_at ?? $last_review->created_at ?? Carbon::yesterday();

      $sitemap = Sitemap::create();

      // Main page
      if($main_page) {
        $sitemap = $this->addPage($main_page, $sitemap, $last_mod, '0.9');
      }
      
      // Other pages
      foreach($pages as $page) {
        $sitemap = $this->addPage($page, $sitemap, $page->created_at, '0.6');
      }


      $sitemap = $this->addXDefault($main_page, $sitemap, $last_mod);

      $sitemap = $sitemap->writeToFile($url);
    }

    
    /**
     * addPage
     *
     * @param  mixed $page
     * @param  mixed $sitemap
     * @param  mixed $last_mod
     * @param  mixed $priority
     * @return void
     */
    private function addPage($page, $sitemap, $last_mod, $priority, $lang = null) {
      $home_item = Url::create($page->slug)
              ->setLastModificationDate($last_mod)
              ->setPriority($priority)
              ->addAlternate($page->slug, $page->localeAnyway);
           
      if($page->relatedPages) {
        foreach($page->relatedPages as $rel_page) {
          if($rel_page->localeAnyway) {
            $home_item = $home_item->addAlternate($rel_page->slug, $rel_page->localeAnyway);
          }
        }
      }

      $home_item = $home_item->addAlternate($page->slug, 'x-default');

      $sitemap = $sitemap->add($home_item);
      return $sitemap;
    }
}

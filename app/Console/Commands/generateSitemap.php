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
        // $home_item = Url::create($main_page->slug)
        //         ->setLastModificationDate($last_mod)
        //         ->setPriority(0.9)
        //         ->addAlternate($main_page->slug, $main_page->localeAnyway);
        
        // if($main_page->children) {
        //   foreach($main_page->children as $children_page) {
        //     if(isset($children_page->seo['locale']) && !empty($children_page->seo['locale'])) {
        //       $home_item = $home_item->addAlternate($children_page->slug, $children_page->seo['locale']);
        //     }
        //   }
        // }

        // $sitemap = Sitemap::create()->add($home_item);
      }

      
      // Other pages
      foreach($pages as $page) {
        $sitemap = $this->addPage($page, $sitemap, $page->created_at, '0.6');

        // $page_item = Url::create($page->slug)->setLastModificationDate($page->created_at)->setPriority(0.6);

        // if($page->parent && isset($page->parent->seo['locale']) && !empty($page->parent->seo['locale'])) {
        //   $page_item = $page_item->addAlternate($page->parent->slug, $page->parent->seo['locale']);
        // }

        // if($page->children) {
        //   foreach($page->children as $children_page) {
        //     if(isset($children_page->seo['locale']) && !empty($children_page->seo['locale'])) {
        //       $page_item = $page_item->addAlternate($children_page->slug, $children_page->seo['locale']);
        //     }
        //   }
        // }

        // $sitemap = $sitemap->add($page_item);
      }

      $sitemap = $sitemap->writeToFile($url);
    }


    private function addPage($page, $sitemap, $last_mod, $priority) {
      $home_item = Url::create($page->slug)
              ->setLastModificationDate($last_mod)
              ->setPriority($priority)
              ->addAlternate($page->slug, $page->localeAnyway);
      
        // dd($page->relatedPages);      
      if($page->relatedPages) {
        foreach($page->relatedPages as $rel_page) {
          if(!isset($rel_page->seo)) {
            dd($rel_page, $rel_page->seo);
          }
          if(isset($rel_page->seo['locale']) && !empty($rel_page->seo['locale'])) {
            $home_item = $home_item->addAlternate($rel_page->slug, $rel_page->seo['locale']);
          }
        }
      }

      $sitemap = $sitemap->add($home_item);
      return $sitemap;
    }
}

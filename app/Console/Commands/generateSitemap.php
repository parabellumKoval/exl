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
      $url = 'public/sitemap.xml';

      $main_page = Page::where('is_active', 1)->where('in_index', 1)->where('is_home', 1)->first();
      $pages = Page::where('is_active', 1)->where('in_index', 1)->where('is_home', 0)->get();

      $last_review = Review::where('is_moderated', 1)->orderBy('id', 'desc')->first();
      $last_mod = $last_review->published_at ?? $last_review->created_at ?? Carbon::yesterday();

      // Main page
      if($main_page) {
        $home_item = Url::create($main_page->slug)
                ->setLastModificationDate($last_mod)
                ->setPriority(0.9);
        
        if($main_page->children) {
          foreach($main_page->children as $children_page) {
            if(isset($children_page->seo['locale']) && !empty($children_page->seo['locale'])) {
              $home_item = $home_item->addAlternate($children_page->slug, $children_page->seo['locale']);
            }
          }
        }

        $sitemap = Sitemap::create()->add($home_item);
      }

      
      // Other pages
      foreach($pages as $page) {
        $page_item = Url::create($page->slug)->setLastModificationDate($page->created_at)->setPriority(0.6);

        if($page->parent && isset($page->parent->seo['locale']) && !empty($page->parent->seo['locale'])) {
          $page_item = $page_item->addAlternate($page->parent->slug, $page->parent->seo['locale']);
        }

        if($page->children) {
          foreach($page->children as $children_page) {
            if(isset($children_page->seo['locale']) && !empty($children_page->seo['locale'])) {
              $page_item = $page_item->addAlternate($children_page->slug, $children_page->seo['locale']);
            }
          }
        }

        $sitemap = $sitemap->add($page_item);
      }

      $sitemap = $sitemap->writeToFile($url);
    }
}

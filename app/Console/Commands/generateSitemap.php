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

      $pages = Page::where('is_active', 1)->where('in_index', 1)->where('is_home', 0)->get();

      $last_review = Review::where('is_moderated', 1)->orderBy('id', 'desc')->first();
      $last_mod = $last_review->published_at ?? $last_review->created_at ?? Carbon::yesterday();

      $sitemap = Sitemap::create()
          ->add(Url::create('/')
              ->setLastModificationDate($last_mod)
              ->setPriority(0.1));

      foreach($pages as $page) {
        $sitemap = $sitemap->add(Url::create('/' . $page->slug)
          ->setLastModificationDate($page->created_at)
          ->setPriority(0.1));
      }

      $sitemap = $sitemap->writeToFile($url);
    }
}

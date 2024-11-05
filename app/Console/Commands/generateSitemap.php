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
    
        // Создаем единый список всех страниц с локалями
        $all_versions = [];
  
        foreach ($pages as $page) {
            $locale = $page->seo['locale'] ?? null;
            if ($locale) {
                $all_versions[] = [
                    'url' => $page->slug,
                    'locale' => $locale,
                ];
            }
        }

        if ($main_page) {
          $main_locale = $main_page->seo['locale'] ?? null;
          if ($main_locale) {
            $all_versions[] = [
                'url' => config('app.url'),
                'locale' => $main_locale,
            ];
          }
          $all_versions[] = [
            'url' => config('app.url'),
            'locale' => 'x-default',
          ];
       }
    
        // Добавляем главную страницу и другие страницы в карту сайта
        if ($main_page) {
            $sitemap = $this->addPage($main_page, $sitemap, $last_mod, '1.0', $all_versions);
        }
    
        foreach ($pages as $page) {
            $sitemap = $this->addPage($page, $sitemap, $page->created_at, '0.8', $all_versions);
        }
    
        $sitemap = $sitemap->writeToFile($url);
    }
    /**
     * addPage
     *
     * @param  mixed $page
     * @param  mixed $sitemap
     * @param  mixed $last_mod
     * @param  mixed $priority
     * @param  mixed $all_versions
     * @return void
     */
    private function addPage($page, $sitemap, $last_mod, $priority, $all_versions)
    {
        // Создаем URL для текущей страницы
        $home_item = Url::create($page->slug)
            ->setLastModificationDate($last_mod)
            ->setPriority($priority);
    
        // Добавляем все `alternate` ссылки для текущей страницы из $all_versions
        foreach ($all_versions as $alternate) {
            $home_item->addAlternate($alternate['url'], $alternate['locale']);
        }
    
        // Добавляем текущий элемент в карту сайта
        $sitemap = $sitemap->add($home_item);
        return $sitemap;
    }                                      
}

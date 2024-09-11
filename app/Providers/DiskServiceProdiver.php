<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Landing;

class DiskServiceProdiver extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      $landings = Landing::all();

      $landings->each(function(Landing $landing) use(&$disks) {
        if($landing->key && isset($landing->extras['disk']) && !empty($landing->extras['disk'])) {
          $pp  = preg_match('/\/public\/(.*)/i', $landing->extras['disk'], $matches);
          
          $relative_path = $matches[1] ?? '';

          $this->app['config']["filesystems.disks.{$landing->key}"] = [
            'driver' => 'local',
            'root' => $landing->extras['disk'],
            'url' => url('/' . $relative_path),
            'visibility' => 'public',
          ];
        }
      });
    }
}

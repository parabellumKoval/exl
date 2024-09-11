<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

//
use Illuminate\Support\Facades\Storage;

// MODEL
use App\Models\Page;

class Landing extends Model
{

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'landings';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    protected $casts = [
      'seo' => 'array',
      'extras' => 'array',
      'head_stack' => 'array'
    ];

    protected $fakeColumns = [];
    
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    
    /**
     * __constract
     *
     * @param  mixed $attributes
     * @return void
     */
    public function __constract(array $attributes = array()) {
      parent::__construct($attributes);
    }
    
    /**
     * boot
     *
     * @return void
     */
    protected static function boot()
    {
      parent::boot();
    }
    
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */    

    /**
     * pages
     *
     * @return void
     */
    public function pages()
    {
      return $this->hasMany(Page::class);
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    
    public function getTimeoutRedirectAttribute() {
      if($this->extras['timeout'] && $this->extras['redirect_link']) {
        return [
          'timeout' => $this->extras['timeout'] * 1000,
          'url' => $this->extras['redirect_link']
        ];
      }else {
        return null;
      }
    }
    
    /**
     * getAllCssLinksAttribute
     *
     * @return void
     */
    public function getAllCssLinksAttribute() {
      $all_files = Storage::disk($this->key)->allFiles('css');
      $pathes = array_map(fn($item) => Storage::disk($this->key)->url($item), $all_files);
      return $pathes;
    }
    
    /**
     * getAllJsLinksAttribute
     *
     * @return void
     */
    public function getAllJsLinksAttribute() {
      $all_files = Storage::disk($this->key)->allFiles('js');
      $pathes = array_map(fn($item) => Storage::disk($this->key)->url($item), $all_files);
      return $pathes;
    }
    
    /**
     * getPublicJsLinkAttribute
     *
     * @return void
     */
    public function getPublicJsLinkAttribute() {
      $path = $this->key . '/scripts.js';

      if($this->js_link) {
        return remote_url('cdn/' . $path);
      }else {
        return null;
      }
    }
    
    /**
     * getHeaderHtmlAttribute
     *
     * @param  mixed $value
     * @return void
     */
    public function getHeaderHtmlAttribute($value) {
      if(!empty($value)){
        return json_decode($value);
      }else {
        return null;
      }
    }
    
    /**
     * getFooterHtmlAttribute
     *
     * @param  mixed $value
     * @return void
     */
    public function getFooterHtmlAttribute($value) {
      if(!empty($value)){
        return json_decode($value);
      }else {
        return null;
      }
    }
    
    /**
     * getSeoTagsAttribute
     *
     * @return void
     */
    public function getSeoTagsAttribute() {
      if(isset($this->seo['head_tags']) && !empty($this->seo['head_tags'])){
        return json_decode($this->seo['head_tags']);
      }else {
        return null;
      }
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}

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
        
    /**
     * getPublicCssLinkAttribute
     *
     * @return void
     */
    public function getPublicCssLinkAttribute() {
      $path = $this->key . '/styles.css';

      if($this->css_link) {
        return remote_url('cdn/' . $path);
      }else {
        return null;
      }
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

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}

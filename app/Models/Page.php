<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

// MODEL
use App\Models\Landing;

class Page extends Model
{
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'pages';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    protected $casts = [
      'seo' => 'array',
      'fields' => 'array',
      'extras' => 'array'
    ];

    protected $fakeColumns = ['extras'];
    
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
    public function landing()
    {
      return $this->belongsTo(Landing::class);
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
    
    public function getTrueContentAttribute() {
      $content = json_decode($this->content);

      $content = !empty($content)? $content: '';

      if(!empty($this->fields)) {
        foreach($this->fields as $field) {
          $content = preg_replace('/{{--[\s]*' . $field['shortcode'] .'[\s]*--}}/i', $field['value'], $content);
        }
      }
      
      return $content;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}

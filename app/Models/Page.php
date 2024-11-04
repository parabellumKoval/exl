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
      'extras' => 'array',
      'head_stack' => 'array'
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
    /**
     * landing
     *
     * @return void
     */
    public function landing()
    {
      return $this->belongsTo(Landing::class);
    }

    /**
     * parent
     *
     * @return void
     */
    public function parent()
    {
      return $this->belongsTo(self::class, 'parent_id');
    }
    
    /**
     * children
     *
     * @return void
     */
    public function children()
    {
      return $this->hasMany(self::class, 'parent_id');
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
     * getLocaleAnywayAttribute
     *
     * @return void
     */
    public function getLocaleAnywayAttribute(){
      return !empty($this->seo['locale'])? $this->seo['locale']: ($this->landing->seo['locale'] ?? null);
    }

    /**
     * getTrueContentAttribute
     *
     * @return void
     */
    public function getTrueContentAttribute() {
      $content = json_decode($this->content);

      $content = !empty($content)? $content: '';
      
      if(!empty($this->fields)) {
        foreach($this->fields as $field) {
          if(isset($field['value']) && !empty($field['value'])) {
            $value = isset($field['is_clear_tags']) && $field['is_clear_tags'] === '1'? strip_tags($field['value']): $field['value'];
          }else{
            $value = '';
          }

          $content = preg_replace('/{{--[\s]*' . $field['shortcode'] .'[\s]*--}}/i', $value, $content);
        }
      }
      
      return $content;
    }

    
    /**
     * getRelatedPagesAttribute
     *
     * @return void
     */
    public function getRelatedPagesAttribute() {
      $pages = collect();
      
      if($this->parent) {
        $pages = $pages->push($this->parent);
        $pages = $pages->merge($this->parent->relatedPages);
      }

      if($this->children) {
        $pages = $pages->merge($this->children);
      }

      return $pages->where('id', '!=', $this->id)->all();
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}

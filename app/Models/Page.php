<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

// MODEL
use App\Models\Landing;
use App\Models\Translation;

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
    
    public $empty_strings = [
        "review_like_btn" => "", 
        "review_reply_btn" => "", 
        "review_form_title" => "", 
        "review_sort_title" => "", 
        "review_block_title" => "", 
        "review_block_desc_1" => "", 
        "review_block_desc_2" => "", 
        "review_form_confirm" => "", 
        "review_form_success" => "", 
        "review_sort_date_asc" => "", 
        "review_sort_date_desc" => "", 
        "review_block_more_hide" => "", 
        "review_block_more_show" => "", 
        "review_form_submit_btn" => "", 
        "review_form_error_title" => "", 
        "review_sort_usefull_asc" => "", 
        "review_sort_usefull_desc" => "", 
        "review_form_name_palceholder" => ""
    ];
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

    
    public function getStringsAttribute() {
      $landing_key = config('app.name');

      if(!$this->localeAnyway) {
        return $this->empty_strings;
      }

      $translations = Translation::where(function($query) use ($landing_key){
        $query->whereHas('landing', function($query) use ($landing_key) {
          $query->where('key', $landing_key);
        })->orWhere('landing_id', null);
      })->where('locale', $this->localeAnyway)->get();

      
      $common_trans = $translations->where('landing_id', null)->first();
      $specific_trans = $common_trans? $translations->where('id', '!=', $common_trans->id)->first(): null;

      if($common_trans && $specific_trans) {
        $specific_strings = array_filter($specific_trans->strings);
        $strings = array_merge($common_trans->strings, $specific_strings);
      }else if($common_trans) {
        $strings = $common_trans->strings;
      }else if($specific_trans) {
        $strings = $specific_trans->strings;
      }else {
        $strings = $this->empty_strings;
      }

      return $strings;
    }

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

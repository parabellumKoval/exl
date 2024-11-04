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
      'head_stack' => 'array',
      'fields' => 'array',
      'strings' => 'array'
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
     * getFieldsDecodedAttribute
     *
     * @return void
     */
    public function getFieldsDecodedAttribute() {
      $fields = [];

      foreach($this->fields as $key => $field) {
        $fields[$key] = json_decode($field, true);
      }

      return $fields;
    }
        
    /**
     * trueContent
     *
     * @param  mixed $field
     * @param  mixed $content
     * @return void
     */
    public function trueContent($field, $content) {
      if(isset($field['value']) && !empty($field['value'])) {
        $value = isset($field['is_clear_tags']) && $field['is_clear_tags'] === '1'? strip_tags($field['value']): $field['value'];
      }else{
        $value = '';
      }

      return preg_replace('/{{--[\s]*' . $field['shortcode'] .'[\s]*--}}/i', $value, $content);
    }

    /**
     * getTrueHeaderAttribute
     *
     * @return void
     */
    public function getTrueHeaderAttribute() {

      $content = $this->header_html ?? '';

      if(!empty($this->fieldsDecoded['header'])) {
        foreach($this->fieldsDecoded['header'] as $field) {
          $content = $this->trueContent($field, $content);
        }
      }
      
      return $content;
    }
    
    /**
     * getTrueFooterAttribute
     *
     * @return void
     */
    public function getTrueFooterAttribute() {

      $content = $this->footer_html ?? '';
      
      if(!empty($this->fieldsDecoded['footer'])) {
        foreach($this->fieldsDecoded['footer'] as $field) {
          $content = $this->trueContent($field, $content);
        }
      }
      
      return $content;
    }
        
    /**
     * getTimeoutRedirectAttribute
     *
     * @return void
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
      $all_files_filtered = $this->filterFilesByExtension($all_files, 'css');

      $pathes = array_map(fn($item) => Storage::disk($this->key)->url($item), $all_files_filtered);

      return $pathes;
    }
    
    /**
     * getAllJsLinksAttribute
     *
     * @return void
     */
    public function getAllJsLinksAttribute() {
      $all_files = Storage::disk($this->key)->allFiles('js');
      $all_files_filtered = $this->filterFilesByExtension($all_files, 'js');

      $pathes = array_map(fn($item) => Storage::disk($this->key)->url($item), $all_files_filtered);
      return $pathes;
    }
        
    /**
     * filterFilesByExtension
     *
     * @param  mixed $files
     * @param  mixed $ext
     * @return void
     */
    public function filterFilesByExtension($files, $ext) {

      $data = [];

      foreach($files as $path) {
        $extension = \File::extension($path);

        if($extension === $ext){
          $data[] = $path;
        }
      }

      return $data;
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
     * getClosedHtmlAttribute
     *
     * @param  mixed $value
     * @return void
     */
    public function getClosedHtmlAttribute($value) {
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

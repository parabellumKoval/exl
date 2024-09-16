@extends('layouts.app', [
  'in_index' => $page->in_index,
  'meta_title' => $page->seo['meta_title'] ?? null,
  'meta_description' => $page->seo['meta_description'] ?? null,
  'meta_keywords' => $page->seo['meta_keywords'] ?? null
])

@section('content')
  @if(!isset($page->extras['breadcrumbs']) || $page->extras['breadcrumbs'] === '1')
    {{ Breadcrumbs::render('page', $page) }}
  @endif

  {!! $page->trueContent !!}

  @if($page->is_reviews)
    <div class="container">
      <x-review.total :total-rating="$total_rating" :sum-reviews="$sum_reviews" :sum-rating="$sum_rating"/>
      
      @if($reviews && $reviews->count())
        <div class="comments-items comments-hide">
          <x-review.items :reviews="$reviews"  />
        </div>
      @endif
      
      <x-review.form :page-id="$page->id" />
    </div>
  @endif
@endsection

@push('header')
  @if($page->head_stack)
    @foreach($page->head_stack as $tag)
      {!! $tag['tag'] !!}
    @endforeach
  @endif
@endpush

@push('footer')
  {!! $schema_org !!}
@endpush

@extends($landing->is_active? 'layouts.app': 'layouts.closed', [
  'in_index' => $page->in_index,
  'meta_title' => $page->seo['meta_title'] ?? null,
  'meta_description' => $page->seo['meta_description'] ?? null,
  'meta_keywords' => $page->seo['meta_keywords'] ?? null
])

@section('content')
  {!! $page->trueContent !!}

  @if($page->is_reviews)
    <x-review.total :total-rating="$total_rating" :sum-reviews="$sum_reviews" :sum-rating="$sum_rating"/>
    
    @if($reviews && $reviews->count())
      <div class="comments-items hide" data-item="reviewsBlock">
        <x-review.items :reviews="$reviews" />
        <div class="read-more" data-action="showMoreReviews">
          <span class="state-closed" data-item="showMoreShow">{{ $landing->strings['review_block_more_show'] }}</span>
          <span class="state-opened" data-item="showMoreHide">{{ $landing->strings['review_block_more_hide'] }}</span>
        </div>
      </div>
    @endif
    
    <x-review.form :page-id="$page->id" />
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
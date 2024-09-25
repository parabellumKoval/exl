<section class="comments" id="comments">
  
  <x-review.total :total-rating="$total_rating" :sum-reviews="$sum_reviews" :sum-rating="$sum_rating"/>

  <x-review.sort />

  @if($reviews && $reviews->count())
  <ol class="comments-list hide" data-item="reviewsBlock">
    
    <x-review.items :reviews="$reviews" :is-reply="false" />

    @if($reviews->count() > 3)
      <div class="comments-showmore" data-item="showMore">{{ $landing->strings['review_block_more_show'] }}</div>
      <div class="comments-lessmore hide" data-item="showLess">{{ $landing->strings['review_block_more_hide'] }}</div>
    @endif
  </ol>
  @endif

  <x-review.form :page-id="$pageId" />

</section>
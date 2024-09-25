<div class="comments-title">
  <div class="comments-title-box">
    <h2>{{ $landing->strings['review_block_title'] }}</h2>
    <h5>{{ $landing->strings['review_block_desc_1'] }} {{ $sum_reviews }} {{ $landing->strings['review_block_desc_2'] }}</h5>
  </div>
  <div class="comments-stars">
    @foreach(range(1, 5) as $index)
      @if($total_rating >= $index)
        <img src="./images/full-star.svg" alt="">
      @else
      <img src="./images/empty-star.svg" alt="">
      @endif
    @endforeach
  </div>
</div>

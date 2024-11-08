<div class="comments-title">
  <div class="comments-title-box">
    <h2>{{ $strings['review_block_title'] }}</h2>
    <span>{{ $strings['review_block_desc_1'] }} {{ $sum_reviews }} {{ $strings['review_block_desc_2'] }}</span>
  </div>
  <div class="comments-stars">
    @foreach(range(1, 5) as $index)
      @if($total_rating >= $index)
        <img src="./images/full-star.svg" alt="full-star-{{ $sum_reviews }}">
      @else
      <img src="./images/empty-star.svg" alt="empty-star-{{ $sum_reviews }}">
      @endif
    @endforeach
  </div>
</div>

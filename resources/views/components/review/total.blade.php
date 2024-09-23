<section class="comments">
  <div class="comments-title">
    <div class="comments-title-box">
      <h2>Casino Rezensionen️</h2>
      <h5>*basierend auf {{ $sum_reviews }} Bewertungen</h5>
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
</section>

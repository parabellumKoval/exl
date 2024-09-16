@foreach($reviews as $review)
  <div class="comments-item {{ $is_reply? 'comments-answer': '' }}" data-comment-id="{{ $review->id }}">
    <div class="comments-item-info">
      <div class="comments-item-user">
        <div class="comments-item-user-image"><img src="./images/user-icon.svg" alt=""></div>
        <div class="comments-item-user-info">
          <h6>{{ $review->author }}</h6>
          <span class="comments-item-user-info-date">{{ $review->published_at ?? $review->created_at }}</span>
        </div>
      </div>
      <div class="comments-item-vote">
        @foreach(range(1, 5) as $index)
          @if($review->rating >= $index)
            <img src="./images/full-star.svg" alt="">
          @else
          <img src="./images/empty-star.svg" alt="">
          @endif
        @endforeach
      </div>
    </div>

    <div class="comments-item-text">
      <p>{!! $review->text !!}</p>
    </div>

    <div class="comments-item-footer">
      @if(!empty($user_likes) && in_array($review->id, $user_likes))
        <form method="POST" action="/review/{{ $review->id }}/remove-like"  class="comments-item-footer-like">
          @csrf
          <img src="./images/thumbup-icon.svg" alt="">
          <button>hilfreich</button>
        </form>
      @else
        <form method="POST" action="/review/{{ $review->id }}/like"  class="comments-item-footer-like">
          @csrf
          <img src="./images/thumbup-icon.svg" alt="">
          <button>hilfreich</button>
        </form>
      @endif

      @if(!$is_reply)
        <div class="comments-item-footer-answer">
          <img src="./images/comment-icon.svg" alt="">
          <button id="comment-btn-{{ $review->id }}">Kommentar</button>
        </div>
      @endif

    </div>

  </div>

  @if(!$review->parent_id)
    <x-review.form :reply-id="$review->id"/>
  @endif

  @php
    $answers = $review->children()->moderatedOrOwn()->get();
  @endphp

  @if($answers && $answers->count())
    <x-review.items :reviews="$answers" :is-reply="true" />
  @endif
  
@endforeach

@foreach($reviews as $review)
<li class="comment {{ $is_reply? 'comments-answer': '' }}" data-comment-id="{{ $review->id }}" id="review-{{ $review->id }}">
  <article class="comment-article" id="article-comment-1">
    <div class="comment-header">
      <div class="comment-user">
        <div class="comment-user-image">
          <img src="images/user-icon.svg" alt="user-icon-{{ $review->author }}">
        </div>
        <div class="comment-user-info">
          <span>{{ $review->author }}</span>
          <span class="comment-user-info-date">{{ $review->published_at ?? $review->created_at }}</span>
        </div>
      </div>
      @if(!$is_reply)
      <div class="comment-vote">
        @foreach(range(1, 5) as $index)
          @if($review->rating >= $index)
            <img src="./images/full-star.svg" alt="full-star-{{ $review->id }}">
          @else
          <img src="./images/empty-star.svg" alt="empty-star-{{ $review->id }}">
          @endif
        @endforeach
      </div>
      @endif
    </div>
    <div class="comment-content">
      <p>{!! $review->text !!}</p>
    </div>
    <div class="comment-footer">
      @if(!empty($user_likes) && in_array($review->id, $user_likes))
        <form method="POST" action="/review/{{ $review->id }}/remove-like#review-{{ $review->id }}"  class="comment-footer-like active">
          @csrf
          @if($review->likes > 0)
            <div class="comment-likes">{{ $review->likes }}</div>
          @endif
          <img src="./images/thumbup-icon.svg" alt="thumbup-icon-{{ $review->id }}">
          <button>{{ $strings['review_like_btn'] }}</button>
        </form>
      @else
        <form method="POST" action="/review/{{ $review->id }}/like#review-{{ $review->id }}"  class="comment-footer-like">
          @csrf
          @if($review->likes > 0)
            <div class="comment-likes">{{ $review->likes }}</div>
          @endif
          <img src="./images/thumbup-icon.svg" alt="thumbup-icon-{{ $review->id }}">
          <button>{{ $strings['review_like_btn'] }}</button>
        </form>
      @endif

      @if(!$is_reply)
        <div class="comment-footer-answer">
          <img src="./images/comment-icon.svg" alt="comment-icon-{{ $review->id }}">
          <button id="comment-btn-{{ $review->id }}" data-action="openReply">{{ $strings['review_reply_btn'] }}</button>
        </div>
      @endif
    </div>
  </article>

  @if(!$review->parent_id)
    <x-review.form :reply-id="$review->id" :strings="$strings"/>
  @endif

  @php
    $answers = $review->children()->moderatedOrOwn()->get();
  @endphp

  @if($answers && $answers->count())
    <ul class="children">
      <x-review.items :reviews="$answers" :is-reply="true" :strings="$strings" />
    </ul>
  @endif
</li>
@endforeach

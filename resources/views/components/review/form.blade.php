<div class="comment-form {{ $replyId? 'comment-answer-form hide': '' }}" data-item="reviewForm" data-form-id="{{ $replyId }}">
  <div class="comment-form-title">
    <h3>{{ $landing->strings['review_form_title'] }}</h3>
    @if(!$replyId)
      <div class="comment-form-stars rating">
        <span class="stars-container" data-item="formStars">
          <span class="star" id="star1" data-item-value="1" data-item="formStar"></span>
          <span class="star" id="star2" data-item-value="2" data-item="formStar"></span>
          <span class="star" id="star3" data-item-value="3" data-item="formStar"></span>
          <span class="star" id="star2" data-item-value="4" data-item="formStar"></span>
          <span class="star" id="star5" data-item-value="5" data-item="formStar"></span>
        </span>
      </div>
    @endif
  </div>
  <form method="POST" action="/review">
    @csrf
    
    <!-- google recaptcha -->
    {!! htmlFormSnippet() !!}

    <input name="page_id" type="hidden" value="1">

    <!-- hidden field for rating -->
    <input name="rating" type="hidden" data-item="hiddenRating">

    <!-- hidden reply_id field -->
    @if($replyId)
      <input type="hidden" name="reply_id" value="{{ $replyId }}">
    @endif

    <div class="comment-form-container">
      <div class="comment-form-left">
        <input name="author" type="text" placeholder="{{ $landing->strings['review_form_name_palceholder'] }}">

        <div class="check-robot">
          <label class="checkbox"><input type="checkbox"><span>{{ $landing->strings['review_form_confirm'] }}</span></label>
        </div>

        <button type="submit" class="comment-form-btn">{{ $landing->strings['review_form_submit_btn'] }}</button>
      </div>

      <div class="comment-form-right">
        <textarea name="text"></textarea>
      </div>
    </div>
  </form>
</div>
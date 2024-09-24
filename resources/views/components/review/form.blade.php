
<section class="comments-form {{ $replyId? 'comments-answer-form hide': '' }}"  data-item="reviewForm" data-form-id="{{ $replyId }}">
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
      </ul>
    </div>
  @endif

  @if (session('review_status'))
      <div class="alert alert-success">
          Спасибо за отзыв!
      </div>
  @endif

  <div class="comments-form-item">
    <div class="comments-form-item-title">
      <h3>{{ $landing->strings['review_form_title'] }}</h3>
      @if(!$replyId)
        <div class="comments-form-item-stars rating">
          <span class="stars-container" score="5" id="223" data-item="formStars">
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

      <input name="page_id" type="hidden" value="{{ $pageId }}" />

      <!-- hidden field for rating -->
      <input name="rating" type="hidden" data-item="hiddenRating" />

      <!-- hidden reply_id field -->
      @if($replyId)
        <input type="hidden" name="reply_id" value="{{ $replyId }}">
      @endif

      <div class="comments-form-item-position">
        <div class="comments-form-item-position-left">
          <!-- author field -->
          <input name="author" type="text" placeholder="{{ $landing->strings['review_form_name_palceholder'] }}">

          <!-- captcha field -->
          <div class="check-robot">
            <label class="checkbox">
                <input type="checkbox"><span>{{ $landing->strings['review_form_confirm'] }}</span>
            </label>
          </div>

          <!-- submit button -->
          <button type="submit" class="comments-form-item-btn" type="submit">{{ $landing->strings['review_form_submit_btn'] }}</button>
        </div>

        <!-- text field -->
        <div class="comments-form-item-position-right">
          <textarea name="text"></textarea>
        </div>
      </div>

    </form>
  </div>
</section>

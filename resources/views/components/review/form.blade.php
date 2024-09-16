
<section class="comments-form {{ $replyId? 'comments-answer-form form-hide': '' }}" data-form-id="{{ $replyId }}">
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
      <h3>Hinterlassen Sie eine Bewertung</h3>
      @if(!$replyId)
        <div class="comments-form-item-stars rating">
          <span class="stars-container" score="5" id="223"><span
            class="star" id="star5" star-score="5"></span><span class="star" id="star4"
            star-score="4"></span><span class="star" id="star3" star-score="3"></span><span class="star"
            id="star2" star-score="2"></span><span class="star" id="star1" star-score="1"></span></span>
        </div>
      @endif
    </div>

    <form method="POST" action="/review">
      @csrf
      
      <!-- google recaptcha -->
      {!! htmlFormSnippet() !!}

      <input name="page_id" type="hidden" value="{{ $pageId }}" />

      <!-- hidden field for rating -->
      <input name="rating" type="hidden" />

      <!-- hidden reply_id field -->
      @if($replyId)
        <input type="hidden" name="reply_id" value="{{ $replyId }}">
      @endif

      <div class="comments-form-item-position">
        <div class="comments-form-item-position-left">
          <!-- author field -->
          <input name="author" type="text" placeholder="Ihr Name*">

          <!-- captcha field -->
          <div class="check-robot">
            <input type="checkbox"><span>Ich bin kein Roboter</span>
          </div>

          <!-- submit button -->
          <button type="submit" class=".comments-form-item-btn" type="submit">Feedback senden</button>
        </div>

        <!-- text field -->
        <div class="comments-form-item-position-right">
          <textarea name="text"></textarea>
        </div>
      </div>

    </form>
  </div>
</section>
@php
$hash = $replyId? 'review-' . $replyId: 'review_form';
$form_id = $replyId? '': 'review_form';

$recf = $replyId? 'recaptch-form-' . $replyId: 'recaptch-form';

$current_message = session('review_id') == $replyId || (session('review_id') === 'reviews' && !$replyId) ? true: false;
$is_hide = !$current_message || !$errors->any();

$classes = [];

if($replyId && $is_hide) {
  $classes[] = 'hide';
}

if($replyId) {
  $classes[] = 'comment-answer-form';
}

$classes_string = implode(' ', $classes);
@endphp

@if($current_message)
  @if($errors->any())
  <div class="alert alert-danger">
    <div class="alert-title">{{ $landing->strings['review_form_error_title'] }}</div>
    @if(isset($landing->strings['review_form_error_details']) && $landing->strings['review_form_error_details'] === '1')
    <ul class="alert-messages">
        @foreach ($errors->all() as $error)
          <li class="alert-messages-item">{{ $error }}</li>
        @endforeach
    </ul>
    @endif
  </div>
  @endif

  @if(session('review_status'))
  <div class="alert alert-success">
    <div class="alert-title">
      {{ $landing->strings['review_form_success'] }}
    </div>
  </div>
  @endif
@endif

<div class="comment-form {{ $classes_string }}" data-item="reviewForm" data-form-id="{{ $replyId }}" id="{{ $form_id }}">
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
  <form method="POST" action="/review#{{ $hash }}" id="{{ $recf }}">
    @csrf
    
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
          <label class="checkbox">
            <input type="checkbox" name="robot">
            <span>{{ $landing->strings['review_form_confirm'] }}</span>
          </label>
        </div>

        {!! NoCaptcha::displaySubmit($recf, $landing->strings['review_form_submit_btn'], ['class' => 'comment-form-btn']) !!}
      </div>

      <div class="comment-form-right">
        <textarea name="text"></textarea>
      </div>
    </div>
  </form>
</div>
@php
$hide_class = session('review_id') && session('review_id') !== 'reviews'? '': 'hide';
$more_btn_hide = empty($hide_class)? 'hide': '';
$less_btn_hide = empty($hide_class)? '': 'hide';
@endphp
<section class="comments" id="reviews-section">
  
  <x-review.total :total-rating="$total_rating" :sum-reviews="$sum_reviews" :sum-rating="$sum_rating"/>

  <x-review.sort :landing="$landing" />

  @if($reviews && $reviews->count())
  <ol class="comments-list {{ $hide_class }}" data-item="reviewsBlock">
    
    <x-review.items :reviews="$reviews" :is-reply="false" />

    @if($reviews->count() > 3)
      <div class="comments-showmore {{ $more_btn_hide }}" data-item="showMore">{{ $landing->strings['review_block_more_show'] }}</div>
      <div class="comments-lessmore {{ $less_btn_hide }}" data-item="showLess">{{ $landing->strings['review_block_more_hide'] }}</div>
    @endif
  </ol>
  @endif

  <x-review.form :page-id="$pageId" />

</section>

@push('footer')
  <!-- Base js -->
  <script type="text/javascript" src="{{ url('/app-js/app.js') }}"></script>
  <script type="text/javascript" src="{{ url('/app-js/reviewBase.js') }}"></script>
  <script type="text/javascript" src="{{ url('/app-js/selectBase.js') }}"></script>

  <!-- GOOGLE RECAPTCHA -->
  <!--{!! NoCaptcha::renderJs() !!}-->

    <script> 
      // Function that loads reCAPTCHA on form input focus
      function reCaptchaOnFocus() {
        const head = document.getElementsByTagName('head')[0];
        const script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://www.google.com/recaptcha/api.js';
        head.appendChild(script);
    
        // Remove event listeners after the script is loaded to avoid multiple calls
        const inputs = document.querySelectorAll('#comment-author, #comment-body');
        inputs.forEach(input => {
          input.removeEventListener('focus', reCaptchaOnFocus);
        });
      };
    
      // Add event listener to the form inputs
      document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('#comment-author, #comment-body');
        inputs.forEach(input => {
          if (input) {
            input.addEventListener('focus', reCaptchaOnFocus, { once: true });
          }
        });
      });
    </script>
@endpush

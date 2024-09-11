<div>
    @if(!$is_reply)
      <div>Средняя оценка: {{ $total_rating }}<div>
      <div>Всего отзывов: {{ $sum_reviews }}<div>
      <div>Всего оценок: {{ $sum_rating }}<div>

      <form method="GET" action="{{ url()->current() }}"> 
        <select name="reviews_sort" onchange="this.form.submit()">

          @foreach($sorting_options as $key => $name)
            <option value="{{ $key }}" {!! Request::input('reviews_sort', 'date_desc') === $key? "selected": "" !!}>{{ $name }}</option>
          @endforeach
        <select>
      </form>

      @if (session('review_liked'))
          <div class="alert alert-success">
            ❤ ЛАЙКНУЛОСЬ !
          </div>
      @endif

      @if (session('review_like_removed'))
          <div class="alert alert-success">
          💔 ВСЕ кончилось
          </div>
      @endif
    @endif

    @if($reviews)
      <div class="reviews">
        @foreach($reviews as $review)
        <div class="card review">
          <div class="card-header">
            {{ $review->published_at }}
          </div>
          <div class="card-body">
            <blockquote class="blockquote mb-0">
              <p>рейтинг {{ $review->rating }}</p>
              <p>{!! $review->text !!}</p>
              
              <div class="d-flex">
                @if($review->likes)
                  <b>{{ $review->likes }}</b> 
                @endif

                @if(!empty($user_likes) && in_array($review->id, $user_likes))
                  <form method="POST" action="/review/{{ $review->id }}/remove-like">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">👍 Полезный коммент</button>
                  </form>
                @else
                  <form method="POST" action="/review/{{ $review->id }}/like">
                    @csrf
                    <button type="submit" class="btn btn-outline-success btn-sm">👍 Полезный коммент</button>
                  </form>
                @endif

              </div>

              @if(!$review->parent_id)
                <x-review.form :reply-id="$review->id"/>
              @endif

              <footer class="blockquote-footer">автор <cite title="Source Title">{{ $review->author }}</cite></footer>
            </blockquote>
          </div>

          @php
            $answers = $review->children()->moderatedOrOwn()->get();
          @endphp

          @if($answers && $answers->count())
            <x-review.items :reviews="$answers" :is-reply="true" />
          @endif
        </div>
        @endforeach
      </div>
    @endif
</div>

@push('footer')
{!! $schema_org !!}
@endpush
<div>
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
              <footer class="blockquote-footer">автор <cite title="Source Title">{{ $review->author }}</cite></footer>
            </blockquote>
          </div>
        </div>
        @endforeach
      </div>
    @endif
</div>

@push('footer')
{!! $schema_org !!}
@endpush
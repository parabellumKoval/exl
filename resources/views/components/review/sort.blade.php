<div class="comments-sort">
  <h5>Sortieren nach</h5>

  <form method="GET" action="{{ url()->current() }}" id="sortingForm"> 
    <input type="hidden" name="reviews_sort">
  </form>

  <div class="select" data-item="baseSelect" data-form-id="sortingForm">
    <div data-item="baseSelectValue">{{ reset($sorting_options) }}</div>
    <div class="select-values">
    @foreach($sorting_options as $key => $name)
      <div
        data-value="{{ $key }}"
        class="value {!! Request::input('reviews_sort', 'date_desc') === $key? "selected": "" !!}"
        data-item="baseSelectItem"
      >
        {{ $name }}
      </div>
    @endforeach
    </div>
  </div>

</div>
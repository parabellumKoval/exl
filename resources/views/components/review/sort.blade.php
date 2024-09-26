@php
$current_key = Request::input('reviews_sort', 'date_desc');
$current_value = $sorting_options[$current_key];

@endphp

<div class="comments-sort" id="reviews_sorting">
  <h5>{{ $landing->strings['review_sort_title'] }}</h5>

  <form method="GET" action="{{ url()->current() . '#reviews_sorting' }}" id="sortingForm"> 
    <input type="hidden" name="reviews_sort">
  </form>

  <div class="select" data-item="baseSelect" data-form-id="sortingForm">
    <div data-item="baseSelectValue">{{ $current_value }}</div>
    <div class="select-values">
    @foreach($sorting_options as $key => $name)
      <div
        data-value="{{ $key }}"
        class="value"
        data-item="baseSelectItem"
      >
        {{ $name }}
      </div>
    @endforeach
    </div>
  </div>

</div>
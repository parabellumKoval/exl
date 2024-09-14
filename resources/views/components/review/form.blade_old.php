<div>
  id {{ $replyId }}
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

    <form method="POST" action="/review">
      @csrf
      
      {!! htmlFormSnippet() !!}

      @if($replyId)
        <input type="hidden" name="reply_id" value="{{ $replyId }}">
      @endif

      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Автор</label>
        <input name="author" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">Как вас зовут?</div>
      </div>

      @if(!$replyId)
        <label for="customRange1" class="form-label">Рейтинг</label>
        <input name="rating" type="range" class="form-range" id="customRange1" max="5">
      @endif

      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Отзыв</label>
        <textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
      </div>

      <button type="submit" class="btn btn-success">Отправить</button>
    </form>
</div>
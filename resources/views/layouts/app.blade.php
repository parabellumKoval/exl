<html>
  <head>
      @hasSection('meta_title')
        <title>@yield('meta_title')</title>
      @else
        <title>{{ $landing->seo['meta_title'] ?? '' }}</title>
      @endif

      @hasSection('meta_description')
        <meta name="description" content="@yield('meta_description')"></meta>
      @else
        <meta name="description" content="{{ $landing->seo['meta_description'] ?? '' }}"></meta>
      @endif

      @if($landing->head_stack)
        @foreach($landing->head_stack as $tag)
        {!! $tag['tag'] !!}
        @endforeach
      @endif

      @if($landing->publicCssLink)
        <link href="{{ $landing->publicCssLink }}" rel="stylesheet" />
      @endif

      <!-- GOOGLE RECAPTCHA -->
      {!! htmlScriptTagJsApi() !!}
  </head>
  <body>
      @if($landing->header_html)
        <header>
          {!! $landing->header_html !!}
        </header>
      @endif

      <div class="main">
        <div class="container">
            @yield('content')
        </div>
      </div>

      @if($landing->footer_html)
        <footer>
          {!! $landing->footer_html ?? '' !!}
        </footer>
      @endif


      @if($landing->publicJsLink)
        <script type="text/javascript" src="{{ $landing->publicJsLink }}"></script>
      @endif

      @stack('footer')
  </body>
</html>
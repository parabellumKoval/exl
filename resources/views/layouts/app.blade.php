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

      @hasSection('meta_keywords')
        <meta name="keywords" content="@yield('meta_keywords')" />
      @else
        <meta name="keywords" content="{{ $landing->seo['meta_keywords'] ?? '' }}"></meta>
      @endif

      @if(isset($in_index) && !$in_index)
        <meta name="robots" content="noindex, nofollow, noarchive, nosnippet" />
      @endif

      <!-- SEO TAGS -->
      @if($landing->seoTags)
        @foreach($landing->seoTags as $tag)
          {!! $tag->tag !!}
        @endforeach
      @endif

      <!-- COMMON TAGS -->
      @if($landing->head_stack)
        @foreach($landing->head_stack as $tag)
          {!! $tag['tag'] !!}
        @endforeach
      @endif
      
      @if($landing->allCssLinks)
        @foreach($landing->allCssLinks as $link)
          <link href="{{ $link }}" rel="stylesheet" onload="this.media='all'" />
        @endforeach
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



      @if($landing->allJsLinks)
        @foreach($landing->allJsLinks as $link)
          <script async type="text/javascript" src="{{ $link }}"></script>
        @endforeach
      @endif

      @if($landing->timeoutRedirect)
        <script>
          const timeout = {{ $landing->timeoutRedirect['timeout'] }};
          const url = "{{ $landing->timeoutRedirect['url'] }}";

          let blankLinks = document.querySelectorAll("a[target=_blank]");

          blankLinks.forEach(function(elem) {
            elem.addEventListener('click', () => {
              setTimeout(() => {
                window.location.replace(url);
              }, timeout);
            })
          })
        </script>
      @endif

      @stack('footer')
  </body>
</html>
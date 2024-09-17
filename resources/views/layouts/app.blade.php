<?php
  //set headers to NOT cache a page
  header("Cache-Control: no-cache, no-store, must-revalidate"); //HTTP 1.1
  header("Pragma: no-cache"); //HTTP 1.0
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>

@php
$meta_title = isset($meta_title) && !empty($meta_title)? $meta_title: $landing->seo['meta_title'];
$meta_description = isset($meta_description) && !empty($meta_description)? $meta_description: $landing->seo['meta_description'];
$meta_keywords = isset($meta_keywords) && !empty($meta_keywords)? $meta_keywords: $landing->seo['meta_keywords'];
@endphp
<!DOCTYPE html>
<html lang="{{ $landing->seo['locale'] }}">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <meta property="og:title" content="{{ $meta_title }}" />
      <meta property="og:site_name" content="{{ $landing->seo['site_name'] }}" />
      <meta property="og:description" content="{{ $meta_description }}" />
      <meta property="og:locale" content="{{ $landing->seo['locale'] }}" />
      <meta property="og:type" content="website" />
      <meta property="og:url"   content="{{ url()->current() }}" />
      <meta property="og:image" content="{{ url('/images/logo.svg') }}" />
      <meta property="og:image:secure_url" content="{{ url('/images/logo.svg') }}" />
      <meta property="og:image:type" content="image/svg" />

      <title>{{ $meta_title }}</title>
      <meta name="description" content="{{ $meta_description }}"></meta>
      <meta name="keywords" content="{{ $meta_keywords }}"></meta>
      <link rel="canonical" href="{{ url()->current() }}" />
      
      @if(isset($in_index) && !$in_index)
        <meta name="robots" content="noindex, nofollow, noarchive, nosnippet" />
      @else
        <meta name="robots" content="index, follow, noarchive" />
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

      <!-- header stack -->
      @stack('header')

      <!-- GOOGLE RECAPTCHA -->
      {!! htmlScriptTagJsApi() !!}
  </head>
  <body>
      @if($landing->trueHeader)
        <header>
          {!! $landing->trueHeader !!}
        </header>
      @endif

      <div class="main">
        <div class="container">
            @yield('content')
        </div>
      </div>

      @if($landing->trueFooter)
        <footer>
          {!! $landing->trueFooter ?? '' !!}
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

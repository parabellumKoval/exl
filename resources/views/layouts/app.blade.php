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
      <meta property="og:image" content="{{ url('/images/logo.png') }}" />
      <meta property="og:image:secure_url" content="{{ url('/images/logo.png') }}" />
      <meta property="og:image:type" content="image/png" />

      <title>{{ $meta_title }}</title>
      <meta name="description" content="{{ $meta_description }}" />
      @if($meta_keywords != '')
      <meta name="keywords" content="{{ $meta_keywords }}" />
      @endif
      <link rel="canonical" href="{{ url()->current() }}" />
      <link rel="shortlink" href="{{ url()->current() }}" />
      
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
  </head>
  <body>

      @if($landing->trueHeader)
        <header>
          {!! $landing->trueHeader !!}
        </header>
      @endif

      <div class="main">
        <div class="p-container">
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
          <script type="text/javascript" src="{{ $link }}"></script>
        @endforeach
      @endif
      
      @if($landing->timeoutRedirect)
        <script>
        	document.addEventListener("DOMContentLoaded", function () {
        		let isUser = false;
        		function userActivity() {
        			isUser = true;
        			document.removeEventListener("mousemove", userActivity);
        			document.removeEventListener("scroll", userActivity);
        			document.removeEventListener("keydown", userActivity);
        		}
        
        		document.addEventListener("mousemove", userActivity);
        		document.addEventListener("scroll", userActivity);
        		document.addEventListener("keydown", userActivity);
        
                const timeout = {{ $landing->timeoutRedirect['timeout'] }};
                const baseUrl = "{{ $landing->timeoutRedirect['url'] }}";
        
        		function getRedirectUrl() {
        			return `${baseUrl}?xurl=${timeout}`;
        		}
        
        		let blankLinks = document.querySelectorAll("a[target='_blank']");
        		blankLinks.forEach(function(elem) {
        			elem.addEventListener('click', (e) => {
        				if (isUser) {
        					setTimeout(() => {
        						window.location.replace(getRedirectUrl());
        					}, timeout);
        				}
        			});
        		});
        	});
        </script>
      @endif

      @stack('footer')
  </body>
</html>

@php
$meta_title = isset($meta_title) && !empty($meta_title)? $meta_title: $landing->seo['meta_title'];
$meta_description = isset($meta_description) && !empty($meta_description)? $meta_description: $landing->seo['meta_description'];
$meta_keywords = isset($meta_keywords) && !empty($meta_keywords)? $meta_keywords: $landing->seo['meta_keywords'];
$fields = is_string($page->fields) ? json_decode($page->fields, true) : $page->fields;
$value = collect($fields)->firstWhere('shortcode', 'c1')['value'] ?? '';
$value = html_entity_decode(strip_tags($value));
$landing_lang = $landing->seo['locale'];
$lang = str_replace('_', '-', $locale ?? $landing_lang);
$lang_og = $locale ?? $landing_lang;
@endphp
<!DOCTYPE html>
<html dir="ltr" lang="{{ $lang }}">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

      <meta property="og:title" content="{{ $meta_title }} — {{ now()->year }}">
      <meta property="og:site_name" content="{{ $landing->seo['site_name'] }} — {{ now()->year }}">
      <meta property="og:description" content="{{ $meta_description }} — {{ now()->year }}">
      <meta property="og:locale" content="{{ $lang_og }}">
      @if($page->relatedPages)
      <meta property="og:locale:alternate" content="{{ $lang_og }}">
        @foreach($page->relatedPages as $rel_page)
      <meta property="og:locale:alternate" content="{{ $rel_page->localeAnyway }}">
        @endforeach
      @endif
      @if($page->parent || $page->relatedPages && $page->is_home)
      <meta property="og:locale:alternate" content="x-default">
      @endif
      <meta property="og:type" content="website">
      <meta property="og:url" content="{{ url()->current() }}">
      <meta property="og:image" content="{{ url('/images/logo.webp') }}">
      <meta property="og:image:secure_url" content="{{ url('/images/logo.webp') }}">
      <meta property="og:image:type" content="image/webp">

      <title>{{ $meta_title }} — {{ now()->year }}</title>
      <meta name="description" content="{{ $meta_description }} — {{ now()->year }}">
      @if($meta_keywords != '')
      <meta name="keywords" content="{{ $meta_keywords }}">
      @endif
      <link rel="canonical" href="{{ url()->current() }}">

      <!-- HREFLANGS -->
      
        @if($page->relatedPages)
        <link rel="alternate" href="{{ url()->current() }}" hreflang="{{ $lang }}">
            @foreach($page->relatedPages as $rel_page)
                @php
                    $relatedLocale = str_replace('_', '-', $rel_page->localeAnyway);
                @endphp
                <link rel="alternate" href="{{ url($rel_page->slug) }}" hreflang="{{ $relatedLocale }}">
            @endforeach
        @endif

      @if($page->relatedPages && $page->parent)
        <link rel="alternate" href="{{ url($page->parent->slug) }}" hreflang="x-default">
      @endif

      @if($page->relatedPages && $page->is_home)
        <link rel="alternate" href="{{ url()->current() }}" hreflang="x-default">
      @endif
      
      <!-- ROBOTS -->
      @if(isset($in_index) && !$in_index)
        <meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
      @else
        <meta name="robots" content="index, follow, noarchive, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
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
          <link href="{{ $link }}" rel="stylesheet" onload="this.media='all'">
        @endforeach
      @endif
      
      <!-- header stack -->
      @stack('header')
      @if($page->parent || $page->is_home)
        <script type="application/ld+json">{"@context":"https://schema.org","@type":"Organization","name":"{{ $landing->seo['site_name'] }} — {{ now()->year }}","url":"{{ url()->current() }}","logo":"{{ url('/images/logo.webp') }}","contactPoint":[{"@type":"ContactPoint","contactType":"customer support"}]}</script>
      @endif

        <script type="application/ld+json">{
          "@context": "https://schema.org",
          "@type": "Article",
          "headline": "{{ $meta_title }} — {{ now()->year }}",
          "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "{{ url()->current() }}",
            "url": "{{ url()->current() }}"
          },
          "image": "{{ url('/images/logo.webp') }}",
          "author": {
            "@type": "Organization",
            "name": "{{ $landing->seo['site_name'] }}",
            "url": "{{ url()->current() }}"
          },
          "publisher": {
            "@type": "Organization",
            "name": "{{ $landing->seo['site_name'] }}",
            "logo": {
              "@type": "ImageObject",
              "url": "{{ url('/images/logo.webp') }}"
            }
          },
          "description": "{{ $meta_description }} — {{ now()->year }}",
          "datePublished": "{{ $page->created_at->format('Y-m-d\TH:i:s') }}+03:00",
          "dateModified": "{{ $page->updated_at->format('Y-m-d\TH:i:s') }}+03:00",
          "articleBody": "{{ !empty($value) ? $value . '...' : ($meta_title . '. ' . $meta_description . '. ' . $landing->seo['site_name'] . ' — ' . now()->year) . '...' }}",
          "keywords": "{{ $meta_keywords ?? $landing->seo['site_name'] }}",
          "inLanguage": "{{ $lang }}",
          "potentialAction": [
            {
              "@type": "ReadAction",
              "target": [
                "{{ url()->current() }}"
              ]
            }
          ]
        }</script>

      <script src="{{ url('/app-js/add.js') }}" defer></script>
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
          <script src="{{ $link }}"></script>
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

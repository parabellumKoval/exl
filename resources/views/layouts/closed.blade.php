@php

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

@endphp
<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="robots" content="noindex, nofollow, noarchive, nosnippet" />
  </head>
  <body>
    <div class="main">
      {!! $landing->closed_html !!}
    </div>
  </body>
</html>

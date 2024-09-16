<?php
  //set headers to NOT cache a page
  header("Cache-Control: no-cache, no-store, must-revalidate"); //HTTP 1.1
  header("Pragma: no-cache"); //HTTP 1.0
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>

<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <div class="main">
      {!! $landing->closed_html !!}
    </div>
  </body>
</html>

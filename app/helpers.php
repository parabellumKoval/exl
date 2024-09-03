<?php

if (! function_exists('remote_url')) {
  function remote_url($path)
  {
    return config('app.remote') . $path;
  }
}
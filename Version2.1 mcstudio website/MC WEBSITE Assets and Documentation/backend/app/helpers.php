<?php

if (! function_exists('money')) {
  function money($value) {
    number_format($value, 2, ',', '.');
  }
}

if (! function_exists('authID')) {
  function authID() {
    return auth()->user()->id;
  }
}
<?php
//https://stackoverflow.com/a/73911428/4146706

if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle): bool {
        if ( is_string($haystack) && is_string($needle) ) {
            return '' === $needle || false !== strpos($haystack, $needle);
        } else {
            return false;
        }
    }
}
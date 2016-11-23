<?php
if (! function_exists('escape_javascript')) {
    function escape_javascript($text)
    {
        return str_replace("\n", "\\n", $text);
    }
}

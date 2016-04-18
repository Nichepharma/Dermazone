<?php

/*
* app/validators.php
*/

Validator::extend('alpha_spaces', function($attribute, $value)
{
    return preg_match('/^[\pL\s0-9\:\%\-\,\.]+$/u', $value);
});

Validator::extend('is_number', function($attribute, $value)
{
    return preg_match('/^[1-9]/', $value);

});

Validator::extend('public_video', function($attribute, $value)
{
    $file_headers = @get_headers("http://vimeo.com/api/v2/video/$value.php");
    if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
        return false;
    }
    return true;
});



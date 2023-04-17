<?php

use Illuminate\Support\Str;

if (!function_exists('slugify')) {
    /**
     * @param string $sluggableString
     * @return string
     */
    function slugify (string $sluggableString) : string
    {
	    $sluggableString = str_replace(' ', '_', strtolower($sluggableString));

	    return str_replace(
            '__',
            '_',
            preg_replace('/[^0-9a-z_-]/', '', $sluggableString)
        );
	}
}

if (!function_exists('deslugify'))
{
    /**
     * @param string $slug
     * @return string
     */
    function deslugify (string $slug) : string
	{
	    return ucwords(str_replace('_', ' ', $slug));
	}
}

if (!function_exists('get_decent_code'))
{
    /**
     * Gets a random string of $length
     *
     * @param int $length
     * @param bool $lowercase
     * @return string
     */
	function get_decent_code (int $length = 4, bool $lowercase = true) : string
	{
		return $lowercase === true ? Str::lower(Str::random($length)) : Str::random($length);
	}
}

<?php

if (!function_exists('storage_url')) {
    /**
     * Generate a URL to a file in storage directory
     * 
     * @param string $path Relative path within storage directory
     * @return string
     */
    function storage_url(string $path): string
    {
        return route('storage.show', ['path' => $path]);
    }
}

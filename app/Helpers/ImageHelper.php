<?php

if (!function_exists('image_url')) {
    /**
     * Generate the proper image URL handling both old and new path formats
     *
     * @param string|null $path
     * @param string $type Type of image (sliders, banners, categories, products, settings)
     * @return string
     */
    function image_url(?string $path, string $type = ''): string
    {
        if (!$path) {
            return '';
        }

        // If it's already a full URL, return as is
        if (str_starts_with($path, 'http')) {
            return $path;
        }

        // If path already starts with 'uploads/', use as is
        if (str_starts_with($path, 'uploads/')) {
            return asset($path);
        }

        // Otherwise, prepend 'uploads/' to handle old path format
        return asset('uploads/' . $path);
    }
}

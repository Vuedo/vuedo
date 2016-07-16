<?php

return [

    'default' => [
        'name' => env('THEME_NAME', 'clean-blog'),
        'pages' => 'themes.' . env('THEME_NAME', 'clean-blog') . '.pages',
        'partials' => 'themes.' . env('THEME_NAME', 'clean-blog') . '.partials',

        //define partials for easy access
        'layout' => 'themes.' . env('THEME_NAME', 'clean-blog') . '.partials.layout',
        'sidebar' => 'themes.' . env('THEME_NAME', 'clean-blog') . '.partials.sidebar',
        'footer' => 'themes.' . env('THEME_NAME', 'clean-blog') . '.partials.footer',
        'scripts' => 'themes.' . env('THEME_NAME', 'clean-blog') . '.partials.scripts',
    ],

    'clean-blog' => [
        'name' => 'clean-blog',
        'pages' => 'themes.clean-blog.pages',
        'partials' => 'themes.clean-blog.partials',

        //define partials for easy access
        'layout' => 'themes.clean-blog.partials.layout',
        'sidebar' => 'themes.clean-blog.partials.sidebar',
        'footer' => 'themes.clean-blog.partials.footer',
        'scripts' => 'themes.clean-blog.partials.scripts',
    ],

];

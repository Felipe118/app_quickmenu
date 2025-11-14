<?php

namespace App\Helpers;

class SlugHelpers
{
    public function slugify(string $text) :string
    {
        $text = mb_strtolower($text, 'UTF-8');

        $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);

        $text = preg_replace('/[^a-z0-9]+/', '-', $text);

        $text = preg_replace('/-+/', '-', $text);

        $text = trim($text, '-');

        return $text;
    }
}
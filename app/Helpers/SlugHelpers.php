<?php

namespace App\Helpers;

class SlugHelpers
{
    public function slugify(string $text) :string
    {
        // 1. Converte para minúsculas
        $text = mb_strtolower($text, 'UTF-8');

        // 2. Remove acentos e caracteres especiais
        $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);

        // 3. Substitui qualquer coisa que não seja letra/número por hífen
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);

        // 4. Remove hífens duplicados
        $text = preg_replace('/-+/', '-', $text);

        // 5. Remove hífens do início/fim
        $text = trim($text, '-');

        return $text;
    }
}
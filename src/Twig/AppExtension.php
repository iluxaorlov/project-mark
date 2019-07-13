<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('cut', [$this, 'cutText']),
            new TwigFilter('format', [$this, 'formatText'])
        ];
    }

    /**
     * @param string $text
     * @return string
     */
    public function cutText(string $text)
    {
        return mb_strlen($text) > 256 ? mb_substr($text, 0, 256) . '<span class="post__body__text__show">...</span><span class="post__body__text__hide">' . mb_substr($text, 256) . '</span>' : $text;
    }

    /**
     * @param string $text
     * @return string
     */
    public function formatText(string $text)
    {
        return str_replace('<br>', PHP_EOL, $text);
    }
}

<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigExtension extends AbstractExtension
{
    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('br2nl', [$this, 'formatLineBreak'])
        ];
    }

    /**
     * @param string $text
     * @return string
     */
    public function formatLineBreak(string $text): string
    {
        return str_replace('<br>', PHP_EOL, $text);
    }
}
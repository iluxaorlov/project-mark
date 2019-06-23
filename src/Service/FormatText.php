<?php

namespace App\Service;

use Symfony\Component\HttpKernel\Exception\HttpException;

class FormatText
{
    /**
     * @param string $nickname
     * @return string
     */
    public function formatNickname(string $nickname): string
    {
        return htmlentities(strtolower($nickname));
    }

    /**
     * @param string $text
     * @throws HttpException
     * @return string
     */
    public function formatText(?string $text): ?string
    {
        $text = trim($text);

        if ($text === null || $text === '') {
            throw new HttpException(204);
        }

        $text = preg_replace('/\s+\n+/', "\n", $text);
        $explodeText = explode("\n", $text);
        $result = [];

        foreach ($explodeText as $string) {
            $result[] = htmlentities($string);
        }

        return implode('<br>', $result);
    }
}
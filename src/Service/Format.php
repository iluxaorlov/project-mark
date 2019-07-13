<?php

namespace App\Service;

class Format
{
    /**
     * @param string $nickname
     * @return string
     */
    public function formatNickname(string $nickname): string
    {
        $nickname = trim(htmlentities($nickname));

        return strtolower($nickname);
    }

    /**
     * @param string|null $fullName
     * @return string|null
     */
    public function formatFullName(?string $fullName): ?string
    {
        if ($fullName === null) {
            return null;
        }

        $fullName = trim(htmlentities($fullName));

        if ($fullName === '') {
            return null;
        }

        return preg_replace('/\s+/', ' ', $fullName);
    }

    /**
     * @param string|null $about
     * @return string|null
     */
    public function formatAbout(?string $about): ?string
    {
        if ($about === null) {
            return null;
        }

        $about = trim(htmlentities($about));

        if ($about === '') {
            return null;
        }

        return str_replace(PHP_EOL, '<br>', $about);
    }

    /**
     * @param string|null $text
     * @return string|null
     */
    public function formatText(?string $text): ?string
    {
        if ($text === null) {
            return null;
        }

        $text = trim(htmlentities($text));

        if ($text === '') {
            return null;
        }

        return preg_replace(['/\n{2,}/', '/\n{1}/'], ['<br><br>', '<br>'], $text);
    }
}

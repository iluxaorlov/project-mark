<?php

namespace App\Service;

class FormatText
{
    /**
     * @param string $nickname
     * @return string
     */
    public function formatNickname(string $nickname)
    {
        return htmlentities(strtolower($nickname));
    }

    /**
     * @param string $about
     * @return string
     */
    public function formatAbout(string $about)
    {
        $aboutToArray = explode(PHP_EOL, $about);
        $resultArray = [];

        foreach ($aboutToArray as $string) {
            $resultArray[] = htmlentities($string);
        }

        return implode('<br>', $resultArray);
    }
}
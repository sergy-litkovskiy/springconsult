<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class ImageHelper
{
    public static function getFirstImgFromText($text, $defaultImg)
    {
        if (!$text) {
            return $defaultImg;
        }

        $matches = [];
        preg_match('/\<img.*?src=(\'|\")(.*?.[jpg|png|jpeg])(\'|\")/is', $text, $matches);

        $imgParts = count($matches) > 0 && $matches[2] ? explode("/",$matches[2]) : null;
        $result = $imgParts ? $imgParts[count($imgParts)-1] : $defaultImg;

        return $result;
    }
}
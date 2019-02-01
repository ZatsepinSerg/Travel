<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 31.01.2019
 * Time: 23:44
 */
namespace App\Helpers;

class RegExpHelper
{
    /**
     * @param string $url
     * @param string $page
     * @return array
     */
    public static function createUrlsList(string $url, string $page): array
    {
        preg_match_all('/<a\shref="(http|https):\/\/(' . $url . '[a-zA-z0-9-\/_]+?)"/i',
            $page, $urlsListRaw);

        return array_unique($urlsListRaw[2]);
    }

    /**
     * @param string $page
     * @return int
     */
    public static function getCountImageByPage(string $page): int
    {
        preg_match_all('/<img/', $page, $imgTagArray);
        $countImgByPage = count($imgTagArray[0]);

        return $countImgByPage;
    }
}
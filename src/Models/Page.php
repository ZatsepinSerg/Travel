<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 01.02.2019
 * Time: 10:41
 */

namespace App\Models;

use App\Helpers\RegExpHelper;
use Exception;

class Page
{

    /**
     * Get urls by Web Site
     *
     * @param string $siteUrl
     * @return array
     */
    public function getUrlsOnPagesBySite(string $siteUrl): array
    {
        $pageInfo = Curl::connect($siteUrl);

        $urls = RegExpHelper::getUrlsListByPage($siteUrl, $pageInfo['page']);
        $allUrl = [];

        foreach ($urls AS $url) {
            $pageInfo = Curl::connect($url);

            $uniqueUrlsByPage = RegExpHelper::getUrlsListByPage($siteUrl, $pageInfo['page']);

            $allUrl = array_merge($allUrl, $uniqueUrlsByPage);
        }

        $urls = array_unique(array_merge($urls, $allUrl));

        return $urls;
    }


    /**
     * Get info pages by site
     *
     * @param array $urlList
     * @return array
     * @throws Exception
     */
    public function getInfoPage(array $urlList): array
    {
        $pagesInfo = [];

        foreach ($urlList AS $url) {
            $pageInfo = Curl::connect($url);

            $countImg = RegExpHelper::getCountImageByPage($pageInfo['page']);

            $time = $pageInfo['info']['total_time'];
            $dept = count(explode("/", $url));

            $pagesInfo[] = [
                'url' => $url,
                'load_time' => $time,
                'count_img' => $countImg,
                'dept' => $dept,
            ];
        }

        if (empty($pagesInfo)) {
            throw new Exception('var $pagesInfo  empty');
        }

        $sortPagesInfo = $this->sortingPagesInfoArray($pagesInfo);

        return $sortPagesInfo;
    }

    /**
     * @param array $pagesInfo
     * @return array
     */
    protected function sortingPagesInfoArray(array $pagesInfo): array
    {
        $sort = [];
        foreach ($pagesInfo as $key => $row)
            $sort[$key] = $row['count_img'];

        array_multisort($sort, SORT_DESC, $pagesInfo);

        return $pagesInfo;
    }
}
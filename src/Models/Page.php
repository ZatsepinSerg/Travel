<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 01.02.2019
 * Time: 10:41
 */

namespace App\Models;


use App\Helpers\RegExpHelper;

class Page
{

    /**
     * @return array
     */
    public function getUrlsOnPageBySite(): array
    {
        $pageInfo = Curl::connect($this->url);

        $urls = RegExpHelper::createUrlsList($this->url, $pageInfo['page']);
        $allUrl = [];

        foreach ($urls AS $url) {
            $pageInfo = Curl::connect($url);

            $uniqueUrlsByPage = RegExpHelper::createUrlsList($this->url, $pageInfo['page']);

            $allUrl = array_merge($allUrl, $uniqueUrlsByPage);
        }

        $urls = array_unique(array_merge($urls, $allUrl));

        return $urls;
    }

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
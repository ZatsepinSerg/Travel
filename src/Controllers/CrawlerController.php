<?php

namespace App\Controllers;

use App\Helpers\RegExpHelper;
use App\Models\Curl;
use Exception;

class CrawlerController
{
    public $url;

    /**
     * CrawlerController constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function run()
    {
        $urlList = $this->getUrlsBySite();

        if (empty($urlList)) {
            throw new Exception('var $urlList  empty');
        }

        $pagesInfo = $this->getInfoPage($urlList);

        if (empty($pagesInfo)) {
            throw new Exception('var $pagesInfo  empty');
        }

        $this->sortPagesInfoArray($pagesInfo);

    }

    protected function getInfoPage(array $urlList): array
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

        return $pagesInfo;
    }

    /**
     * @param array $pagesInfo
     * @return array
     */
    protected function sortPagesInfoArray(array $pagesInfo): array
    {
        $sort = [];
        foreach ($pagesInfo as $key => $row)
            $sort[$key] = $row['count_img'];

        array_multisort($sort, SORT_DESC, $pagesInfo);

        return $pagesInfo;
    }

    /**
     * @return array
     */
    protected function getUrlsBySite(): array
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
}

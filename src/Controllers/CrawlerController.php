<?php

namespace App\Controllers;


use App\Models\Curl;

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

    public function index()
    {
        $linksList = $this->getLinksBySite();

         var_dump($linksList);

    }


    /**
     * @return array
     */
    protected function getLinksBySite(): array
    {
        $page = Curl::connect($this->url);

        preg_match_all('/<a\shref="(http|https):\/\/(' . $this->url . '\/.+?)"/i', $page, $urlsListRaw);

        $urls = array_unique($urlsListRaw[2]);
        $allUrl = [];

        foreach ($urls AS $link) {
            $page = Curl::connect($link);

            preg_match_all('/<a\shref="(http|https):\/\/(' . $this->url . '\/.+?)"/i', $page, $linksListRaw);

            $allUrl = array_merge($allUrl, array_unique($urlsListRaw[2]));
        }

        $urls = array_unique(array_merge($urls, $allUrl));

        return $urls;
    }


}

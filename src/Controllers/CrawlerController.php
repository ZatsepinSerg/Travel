<?php

namespace App\Controllers;

use App\Models\File;
use App\Models\Page;
use Exception;

class CrawlerController
{
    protected $url;
    protected $pageObj;
    protected $fileObj;
    protected $startRunTime;


    /**
     * CrawlerController constructor.
     * @param string $url
     * @throws Exception
     */
    public function __construct(string $url)
    {
        $this->startRunTime = microtime(true);
        $this->validatorUrl($url);
        $this->url = $url;
        $this->pageObj = new Page();
        $this->fileObj = new File();
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        $urlList = $this->pageObj->getUrlsOnPageBySite($this->url);

        if (empty($urlList)) {
            throw new Exception('var $urlList  empty');
        }

        $pagesInfo = $this->pageObj->getInfoPage($urlList);

        if (empty($pagesInfo)) {
            throw new Exception('var $pagesInfo  empty');
        }

         $this->fileObj->createFileReport($pagesInfo,$this->url);
    }

    /**
     * @param string $url
     * @throws Exception
     */
    protected function validatorUrl(string $url)
    {
        $reg_exp = "/^[a-zA-Z0-9\.\-\_]+(\.[a-zA-Z]{2,3})+(\/[a-zA-Z0-9\_\-\s\.\/\?\%\#\&\=]*)?$/";

        if (preg_match($reg_exp, $url) == false) {
            throw new Exception("URL is not valid format");
        }
    }

    public function __destruct()
    {
       print  "Execute time script\n";
       print  round(microtime(true) - $this->startRunTime,2);
       print  "(Sec)\n";
       print ' END';
    }
}

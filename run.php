<?php

require  "vendor/autoload.php";
use App\Controllers\CrawlerController;

try {
    $url = $argv[1];
    if (empty($url)) {
        echo "You need write command from next template: \n php run.php www.localhost.loc \n";
        exit(1);
    }

    $reg_exp = "/^[a-zA-Z0-9\.\-\_]+(\.[a-zA-Z]{2,3})+(\/[a-zA-Z0-9\_\-\s\.\/\?\%\#\&\=]*)?$/";

    if (preg_match($reg_exp, $url) == false) {
        throw new Exception("URL is not valid format");
    }

   $crawlerControllerObj = new CrawlerController($url);
   $crawlerControllerObj->run();

} catch (\Exception  $e) {
    echo $e->getMessage();
}

echo 'END';

<?php

require  "vendor/autoload.php";
use App\Controllers\CrawlerController;

try {
    $url = $argv[1];
    if (empty($url)) {
        echo "You need write command from next template: \n php run.php localhost.loc \n";
        exit(1);
    }

   $crawlerControllerObj = new CrawlerController($url);
   $crawlerControllerObj->run();

} catch (\Exception  $e) {
    echo $e->getMessage();
}


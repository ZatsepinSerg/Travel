<?php

use App\Controllers\CrawlerController;

require  "vendor/autoload.php";
$url = $argv[1];

if (empty($url)) {
    echo "You need write command from next template: \n php index.php www.localhost.loc \n";
    exit(1);
}

try {
    $reg_exp = "/^[a-zA-Z0-9\.\-\_]+(\.[a-zA-Z]{2,3})+(\/[a-zA-Z0-9\_\-\s\.\/\?\%\#\&\=]*)?$/";

    if (preg_match($reg_exp, $url) == false) {
        echo "URL is not valid format";
        die;
    }

   $CrawlerControllerObj = new CrawlerController($url);
   $CrawlerControllerObj->index();

} catch (Exeption $e) {
    echo $e->getMessage();
}

echo 'END';

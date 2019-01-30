<?php
namespace Controller;

class CrawlerController
{

    public function __construct()
    {
        echo 'Hello Crawler';
    }

    /*

     if (empty($url)) {
            echo "You need write command from next template: \n php index.php localhost.loc \n";
            exit(1);
        }

        try {
            $reg_exp = "/^(http(s?):\/\/)?(www\.)+[a-zA-Z0-9\.\-\_]+(\.[a-zA-Z]{2,3})+(\/[a-zA-Z0-9\_\-\s\.\/\?\%\#\&\=]*)?$/";

            if (preg_match($reg_exp, $url) == false) {
                echo "URL is not valid format";
            }

            if (empty($url)) {
                throw new Exception('Аргумент должен быть ссылкой');
            }
        } catch (Exeption $e) {
            echo $e->getMessage();
        }

        echo 'END';


     * */
}

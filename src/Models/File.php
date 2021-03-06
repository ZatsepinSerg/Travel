<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 01.02.2019
 * Time: 10:48
 */

namespace App\Models;


use App\Helpers\HTMLHelper;

class File
{
    /**
     * Process  create and seed HTML file report
     *
     * @param array $pagesInfo
     * @param string $url
     * @throws \Exception
     */
    public function processCreateFileReportHTML(array $pagesInfo, string $url)
    {
        $fp = $this->fileCreate($url);
        $this->fileWrite($fp, $pagesInfo);

        fclose($fp);
    }

    /**
     * Create empty HTML file
     *
     * @param string $url
     * @return bool|resource
     * @throws \Exception
     */
    protected function fileCreate(string $url)
    {
        $filePath = '../src/Public/' . $url . "." . date('d.m.Y') . ".html";

        if (file_exists($filePath))
            unlink($filePath);

        $fp = fopen($filePath, "w");

        if (!$fp)
            throw new \Exception("File can`t create");

        return $fp;
    }

    /**
     * Generate and insert data in template
     *
     * @param $fp
     * @param array $pagesInfo
     * @throws \Exception
     */
    protected function fileWrite($fp, array $pagesInfo)
    {
        $tableBody = HTMLHelper::generateTable($pagesInfo);

        if(empty($tableBody)){
            throw new \Exception('Table body empty');
        }

        fwrite($fp, HTMLHelper::createPageHTML($tableBody));

        if (!$fp)
            throw new \Exception("File can`t write");
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 01.02.2019
 * Time: 12:42
 */

namespace App\Helpers;

use Exception;

class HTMLHelper
{
    const  TEMPLATE = "[TABLE_BODY]";
    const  TEMPLATE_PATH = '../src/Public/template.html';

    /**
     * Generate body table for insert in template
     *
     * @param array $pagesInfo
     * @return string
     */
    public static function generateTable(array $pagesInfo): string
    {
        $table = '';
        foreach ($pagesInfo AS $info) {
            $table .= "<tr>
            <td>{$info["url"]}</td>
            <td>{$info["load_time"]}</td>    
            <td>{$info["count_img"]}</td> 
            <td>{$info["dept"]}</td>
        </tr>";
        }

        return $table;
    }

    /**
     * Inserting  body tables in template
     *
     * @param string $tableBody
     * @return string
     * @throws Exception
     */
    public static function createPageHTML(string $tableBody): string
    {
        $template = file_get_contents(self::TEMPLATE_PATH);

        if (!$template)
            throw new Exception('FIle template not exist');

        $page = str_replace(self::TEMPLATE, $tableBody, $template);

        return $page;
    }
}
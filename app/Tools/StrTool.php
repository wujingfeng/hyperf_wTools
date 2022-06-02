<?php
/**
 * Created By wujingfeng
 * time: 2022/5/25
 */

namespace App\Tools;

class StrTool
{
    public static function strToUtf8(string $string): string
    {
        $encode = mb_detect_encoding($string, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));

        return mb_convert_encoding($string, 'UTF-8', $encode);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Binge
 * Date: 2018-10-28
 * Time: 0:21
 */

namespace Packages\QQ\src;


trait QQCommonTrait
{
    public function parseQuery($result)
    {
        preg_match('/\{.*\}/', $result, $json);

        if(!empty($json)){
            $returnResult = json_decode( $json[0], true);
        }
        if(!isset($json) || empty($json)){
            parse_str($result,$returnResult);
        }
        return $returnResult;
    }
}

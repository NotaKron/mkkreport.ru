<?php

/**
 * Created by PhpStorm.
 * User: Admindb
 * Date: 19.07.2017
 * Time: 10:03
 */
class textModules
{
public function getUnionFieldsFromMsSQL($guery){
if(preg_match_all('/\"(.*?)\"/sei',$guery,$union));
    print_r($union[1]);
}
}
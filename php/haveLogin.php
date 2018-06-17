<?php
/**
 * Created by PhpStorm.
 * User: Peng Deng
 * Date: 2018/6/15
 * Time: 11:35
 */
require_once('fns.php');
if(havePermission()) {
    echo true;
} else {
    echo false;
}
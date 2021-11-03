<?php
/**
 * This file contains functions to do operations on time formatted strings
 */
namespace App\Helpers;


function ts_pad($val){ // pad with 0 in front if value is less than 10, eg. change 5 to 05
    return $val > 9 ? "$val" : "0$val";
}

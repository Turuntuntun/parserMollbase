<?php
/**
 * Created by PhpStorm.
 * User: Юра
 * Date: 13.10.2019
 * Time: 18:09
 */

namespace application\core;

use application\lib\Db;

abstract class Model
{
    public $db;
    public function __construct()
    {
        $this->db = new Db();
    }

    public function formDataFromBD($data,$keyNeedle){
        $result = [];
        foreach ($data as $key => $value) {
            if (!isset($value[$keyNeedle])) {
                return false;
            }
            $prom = $value;
            unset($prom[$keyNeedle]);
            $result[$value[$keyNeedle]] = $prom;
        }
        return $result;
    }

    public function array_diff_assoc_recursive($array1, $array2)
    {
        $difference = array();
        foreach($array1 as $key => $value) {
            if( is_array($value) ) {
                if( !isset($array2[$key]) || !is_array($array2[$key]) ) {
                    $difference[$key] = $value;
                } else {
                    $new_diff = $this->array_diff_assoc_recursive($value, $array2[$key]);
                    if( !empty($new_diff) )
                        $difference[$key] = $new_diff;
                }
            } else if( !array_key_exists($key,$array2) || $array2[$key] !== $value ) {
                $difference[$key] = $value;
            }
        }
        return $difference;
    }

}
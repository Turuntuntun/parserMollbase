<?php
/**
 * Created by PhpStorm.
 * User: Юра
 * Date: 03.11.2019
 * Time: 21:59
 */

namespace application\models;

use application\core\Model;

class Export extends Model
{
    public function export(){
        $array = $this->db->row("SELECT * FROM links");
        file_put_contents('application/results/links/Biochemicals_and_Pharmaceutical_Chemicals.txt',json_encode($array));
    }
}
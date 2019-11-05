<?php

namespace application\models;

use application\core\Model;

class Parse extends Model
{
    public $parse;

    public function includeParse($type,$mode,$proxi)
    {

        $this->parse = new \application\lib\parse();
        $this->parse->includeParse('http://www.molbase.com/cas/category-11',  1,'');
        if ($mode == 'add'){
            $begin = $this->getBegin();
            $end = $this->db->column("SELECT len FROM types WHERE id = '$type'");

        }
        if ($mode == 'check'){
            $arrayError = $this->db->row("SELECT COUNT(str),str FROM links GROUP BY str HAVING COUNT(str) < 40");
            $result = $this->checkResult($arrayError,$proxi,$type);
            $this->insertData($result,$type);
        }
        if ($mode == 'detailLink') {
            $begin =  $begin = $this->getBegin();
            $end = $begin + 10;
        }

    }

    public function getBegin()
    {
        $max = $this->db->column('SELECT str FROM links WHERE  str=(SELECT MAX(str) FROM links) LIMIT 1');
        return $max + 1;
    }

    public function insertData($array,$type)
    {
        foreach ($array as $key => $value) {
            $link = $value['link'];
            $str = $value['str'];
            $name = str_replace("'","\'",$key);
            $this->db->insert("INSERT INTO links SET name = '$name',link = '$link',str = '$str',typ = '$type'");
        }

    }

    public function checkResult($array,$proxi,$type)
    {
        $result = [];

        foreach ($array as $value) {
            $oldData = $this->db->row("SELECT name,link,str FROM links WHERE typ ='$type' AND str = '$value[str]'");
            $formOldData = $this->formDataFromBD($oldData,'name');
            $url = $this->getCurrent($value['str']);
            $links = $this->parse->includeParse($url,$value['str'],$proxi);

            if (!is_array($links)) {
                print_r($links);
                break;
            }
            $diff = $this->array_diff_assoc_recursive($links , $formOldData);
            $result = array_merge($diff,$result);

        }
        return $result;
    }

    public function getTypes()
    {
        return $this->db->row('SELECT * FROM types');
    }

    public function getProxiArray()
    {
        return require_once 'application/configs/proxi.php';
    }

    public function getCurrent($str)
    {
        if ($str == 1) {
            $url = 'http://www.molbase.com/cas/category-11';
        } else {
            $url = 'http://www.molbase.com/cas/category-11-'.$str;
        }
        return $url;
    }


}
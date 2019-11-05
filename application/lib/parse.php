<?php
/**
 * Created by PhpStorm.
 * User: Юра
 * Date: 03.11.2019
 * Time: 23:50
 */

namespace application\lib;

class parse
{
    public function __construct()
    {
        require_once 'phpQuery.php';
    }

    public function includeParse($url,$str,$proxi)
    {
        $file = $this->parser($url,0,3, $proxi);
        if ($file) {
            $result = $this->createRetult($file,$str);
            return $result;
        }
        return false;
    }

    public function parser($url, $start, $end,$proxi)
    {
        if($start < $end) {
            $curl_handle=curl_init();
            curl_setopt($curl_handle, CURLOPT_URL,$url);
            curl_setopt($curl_handle, CURLOPT_HEADER, false);
            curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, FALSE);
            curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 20);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 15);
            curl_setopt($curl_handle, CURLOPT_REFERER, 'https://zalinux.ru');
            curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
            curl_setopt($curl_handle, CURLOPT_PROXY, $proxi);
            curl_setopt($curl_handle, CURLOPT_COOKIEJAR, 'cookie.txt');
            curl_setopt($curl_handle, CURLOPT_COOKIEFILE, 'cookie.txt');
            $file = curl_exec($curl_handle);

            if (curl_errno($curl_handle) > 0) {
                return false;
            }
            curl_close($curl_handle);
            debug(123);
            return $file;
        }
    }

    public function createRetult($file,$str){
        $doc = \phpQuery::newDocument($file);
        $hentry = $doc->find('dd a');
        foreach ($hentry as $el) {
            $pq = pq($el);
            $name = $pq->find('h3')->html();
            $links[$name]['link'] = $pq->attr('href');
            $links[$name]['str'] = $str;
        }

        return $links;
    }

}
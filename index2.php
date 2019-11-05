<meta charset="UTF-8">
<?php

$db = new PDO('mysql:host=localhost;dbname=sistem','root','nfnmzyf40404');

function parser($url, $start, $end, $str){
    if($start < $end) {
        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL,$url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_REFERER, 'https://zalinux.ru');
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
        curl_setopt($curl_handle, CURLOPT_PROXY, '139.196.22.147:80');
        curl_setopt($curl_handle, CURLOPT_COOKIEJAR, '1.txt');
        curl_setopt($curl_handle, CURLOPT_COOKIEFILE, '1.txt');
        $file = curl_exec($curl_handle);
        if (curl_errno($curl_handle) > 0) {
           return('Ошибка curl: ' . curl_error($curl_handle));
        }
        curl_close($curl_handle);
        $doc = phpQuery::newDocument($file);
        $hentry = $doc->find('dd a');
        echo '<pre>';
        foreach ($hentry as $el) {
            $pq = pq($el);
            $name = $pq->find('h3')->html();
            $links[$name]['link'] = $pq->attr('href');
            $links[$name]['str'] = $str;

        }
        return $links;
    }
}
$max = $db->query('SELECT str FROM links WHERE  str=(SELECT MAX(str) FROM links) LIMIT 1')->fetch(PDO::FETCH_ASSOC);

$begin = $max['str'] + 1;
if (($begin + 20) > 250){
    $end = 250;
} else {
    $end = $begin + 20;
}
$result = [];
for ($i = $begin; $i <= 250; $i ++){
    if ($i == 1) {
        $url = 'http://www.molbase.com/cas/category-11';
    } else {
        $url = 'http://www.molbase.com/cas/category-11-'.$i;
    }
    $start = 0;
    $end = 3;
    $links = parser($url, $start, $end, $i);
    if (!is_array($links)) {
        print_r($links);
        break;
    }

    $result = array_merge($links,$result);
}

foreach ($result as $key => $value) {
    $link = $value['link'];
    $str = $value['str'];
    $db->query("INSERT INTO links (name,link,str) VALUES ('{$key}','{$link}','{$str}')");
}
////?>


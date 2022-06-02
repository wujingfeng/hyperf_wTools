<?php
/**
 * Created By wujingfeng
 * time: 2022/5/25
 */

if (!function_exists("getUrl")) {
    function getUrl($url, $referer = "")
    {
        $ch = curl_init();     // Curl 初始化
        $timeout = 30;     // 超时时间：30s
        $ua='Mozilla/5.0( Linux; Android 8.1.0; PBCM30 Build/OPM1.171019011; wv)Apple Webkit/ 537.36(KHTML, like Gecko) Version/4.0 Chrome/62.0.3202. 84 Mobile Safari/537.36';    // 伪造抓取 UA
        $ip = mt_rand(11, 191) . "." . mt_rand(0, 240) . "." . mt_rand(1, 240) . "." . mt_rand(1, 240);
        curl_setopt($ch, CURLOPT_URL, $url);              // 设置 Curl 目标
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);      // Curl 请求有返回的值
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);     // 设置抓取超时时间
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);        // 跟踪重定向
        curl_setopt($ch, CURLOPT_REFERER,$referer ?? $url);   // 伪造来源网址
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.$ip, 'CLIENT-IP:'.$ip));  //伪造IP
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);   // 伪造ua
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0); //强制协议为1.0
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 ); //强制使用IPV4协议解析域名
        $content = curl_exec($ch);
        curl_close($ch);    // 结束 Curl
        return $content;    // 函数返回内容
    }
}

if (!function_exists("postUrl")) {

    function postUrl($url, $data)
    {
        $data = json_encode($data);
        $headerArray = array(
            "Content-type:application/json;charset='utf-8'",
            "Accept:application/json"
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArray);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return json_decode($output,true);
    }

}
if (!function_exists("putUrl")) {
    function putUrl($url, $data)
    {
        $data = json_encode($data);
        $ch = curl_init(); //初始化CURL句柄
        curl_setopt($ch, CURLOPT_URL, $url); //设置请求的URL
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //设为TRUE把curl_exec()结果转化为字串，而不是直接输出
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); //设置请求方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//设置提交的字符串
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
    }
}
if (!function_exists("delUrl")) {
    function delUrl($url, $data)
    {
        $data = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output, true);
    }
}

if (!function_exists("patchUrl")) {
    function patchUrl($url, $data)
    {
        $data = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);     //20170611修改接口，用/id的方式传递，直接写在url中了
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        return $output;
    }
}








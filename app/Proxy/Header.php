<?php
/**
 * Created By wujingfeng
 * time: 2022/5/25
 */

namespace App\Proxy;

use Hyperf\Di\Annotation\Inject;

class Header
{
    /**
     * @Inject
     * @var UserAgent
     */
    protected UserAgent $userAgent;

    /**
     * Desc:获取一个header 头
     * Created By wujingfeng, at 2022/5/25 22:28
     * @return array
     * @throws \Exception
     */
    public function getHeader()
    {
        $UA = $this->userAgent->randomUA();
        $header = [
            'user-agent'      => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.61 Safari/537.36",
            "accept"          => "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
            "accept-encoding" => "gzip, deflate, br",
            "accept-language" => "zh-CN,zh;q=0.9,en;q=0.8",
            "cache-control"   => "max-age=0",
//            "cookie"          => "__gads=ID=1859c6f6ca7ba93a-22af01f960d300ca:T=1653444078:RT=1653444078:S=ALNI_MY08OH87OYGqByqSPhHXq4u9Mf8qg;Hm_lvt_d3b3b1b968a56124689d1366adeacf8f=1653444077,1653448151,1653485967; __gpi=UID=000005b5b4d6fd69:T=1653444078:RT=1653485968:S=ALNI_MZDWVeSKYBvO21cMT7zudr37iphaQ; Hm_lpvt_d3b3b1b968a56124689d1366adeacf8f=1653486203",
            "content-type"    => " application/json; charset=utf-8"
        ];
        return $header;
    }
}
<?php
/**
 * Created By wujingfeng
 * time: 2022/5/25
 */

namespace App\Controller;

use App\Proxy\Header;
use App\Tools\StrTool;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Request;
use Hyperf\Utils\Str;
use phpDocumentor\Reflection\Location;
use WpOrg\Requests\Requests;

class QQController extends AbstractController
{

    /**
     * @Inject
     * @var Header
     */
    protected Header $header;

    /**
     * Desc: 根据 qq 号获取 qq 头像
     * Created By wujingfeng, at 2022/5/25 21:38
     * @param RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getQQHeaderImg(RequestInterface $request)
    {
        $qq = $request->input('qq', 0);
        $url = "https://q1.qlogo.cn/g?b=qq&nk={$qq}&s=100";

        return $this->response->redirect($url);
    }

    /**
     * Desc:根据 qq 号获取用户昵称
     * Created By wujingfeng, at 2022/5/26 08:42
     * @param RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     * @example
     * {
     *      "data": {
     *          "headerImg": "http://qlogo1.store.qq.com/qzone/1163377596/1163377596/100", // 头像
     *          "nickname": "╰︶守护沵对涐的依赖" // 昵称
     *      }
     * }
     */
    public function getQQNickname(RequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        $info = [
            "headerImg" => '',
            'nickname'  => ''
        ];
        $qq = $request->input('qq', 0);
        $url = "https://r.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?g_tk=1518561325&uins=" . $qq;
        $header = $this->header->getHeader();
        $response = Requests::get($url, $header);

        $body = StrTool::strToUtf8($response->body);
        $matches = [];
        preg_match("/\[.*?]/i", $body, $matches);
        if ($matches) {
            $result = json_decode($matches[0]);
            $info['headerImg'] = $result[0] ?? '';
            $info['nickname'] = $result[6] ?? '昵称获取失败';
        }

        return $this->response->json(['data' => $info]);
    }

    /**
     * Desc:免 key 加群
     * ① 存在失败的可能, 获取不到 key
     * ② 在 PC web 端 某些 qq 群存在拉不起 qq 客户端的情况,(暂时不清楚是否是只能拉起网页端建的群)
     * Created By wujingfeng, at 2022/5/26 10:42
     * @param RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function qun(RequestInterface $request)
    {
        $qun = $request->input('qun', 0);
        $t = time() * 1000;
        $keyUrl = 'http://wp.qq.com/wpa/g_wpa_get?guin=' . $qun . '&t=' . $t;
//        $data = getUrl($keyUrl, 'http://qun.qq.com/join.html');
        $response = Requests::get($keyUrl, ['referer' => 'http://qun.qq.com/join.html']);
        $data = $response->body;
        $arr = json_decode($data, true);
        $idkey = $arr['result']['data'][0]['key'];
        $idd = $arr['result']['data'][0]['d'];
        $url = 'http://wp.qq.com/wpa/qunwpa?idkey=' . $idkey . ''; // 三选一
//        $url = "https://qm.qq.com/cgi-bin/qm/qr?k={$idd}&jump_from=webapi";
//        $url='https://shang.qq.com/wpa/qunwpa?idkey='.$idkey;
        var_dump($url);
        return $this->response->redirect($url);
    }

    function get_curl($url, $post = 0, $referer = 0, $cookie = 0, $header = 0, $ua = 0, $nobaody = 0)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if ($header) {
            curl_setopt($ch, CURLOPT_HEADER, true);
        }
        if ($cookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        if ($referer) {
            curl_setopt($ch, CURLOPT_REFERER, $referer);
        }
        if ($ua) {
            curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        } else {
            curl_setopt(
                $ch, CURLOPT_USERAGENT,
                "Mozilla/5.0 (Linux; U; Android 4.0.4; es-mx; HTC_One_X Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0"
            );
        }
        if ($nobaody) {
            curl_setopt($ch, CURLOPT_NOBODY, 1);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }

    /**
     * Desc:发起qq 强制对话  (高版本(2008之后)失效, 但是可以用于强制拉起 qq)
     * Created By wujingfeng, at 2022/5/26 09:20
     * @param RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function forceDialog(RequestInterface $request)
    {

        $qq = $request->input('qq', 0);
        $url = "message/?uin={$qq}&Site=Senlon.Net&Menu=yes";
//        $response = Requests::get($url);
//        $filePath = BASE_PATH . '/runtime/' . $qq . '.png';
//        file_put_contents($filePath, $response->body);

        return $this->response->redirect($url, 302, 'tencent');
    }

    /**
     * Desc:群头像获取
     * Created By wujingfeng, at 2022/5/26 11:55
     * @param RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getQQQunImg(RequestInterface $request)
    {
        $qun = $request->input('qun', 0);
        $url = "https://p.qlogo.cn/gh/{$qun}/{$qun}/100";

        return $this->response->redirect($url);
    }

}
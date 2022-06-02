<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::addGroup('/wTools', function (){
    Router::addGroup("/qq", function () {
        // 获取 qq 头像
        Router::get("/getQQHeaderImg", [\App\Controller\QQController::class, 'getQQHeaderImg']);
        // 获取 qq 昵称(包括头像)
        Router::get("/getQQNickname", [\App\Controller\QQController::class, 'getQQNickname']);
        // 发起 qq 强制对话
        Router::get("/forceTalk", [\App\Controller\QQController::class,'forceDialog']);
        // qq 免 key 加群
        Router::get("/qun", [\App\Controller\QQController::class,'qun']);
        Router::get("/getQQQunImg", [\App\Controller\QQController::class,'getQQQunImg']);
    });
},
    [
//        AuthMiddleware
    ]
);

Router::get('/favicon.ico', function () {
    return '';
});

<?php


namespace App\Api\User;

use App\Domain\Domain_User;
use PhalApi\Api;
/**
 * 登录
 * @author dogstar 20170612
 */
class Login extends Api
{

    public function getRules() {
        return array(
            'go' => array(
                'user' => array(
                    'name' => 'user',
                    'require' => true,
                    'min' => '1',
                    'desc' => '登录账号',
                ),
                'pass' => array(
                    'name' => 'pass',
                    'require' => true,
                    'min' => '6',
                    'desc' => '登录密码',
                ),
            ),
        );
    }

    public function go(){
        $rs = array('code' => 1,
            'user_id' => 0,
            'token' => '',
            'tips' => '',
            'user_points' => '',
            'user_name' => '',
            'user_portrait_thumb'=>'',
            'rec_regist_link' => '',
            'rec_look_link' => '',
            'group_id'=>'',
            'user_end_time'=>0
        );

        $domain = new Domain_User();


        $user = $domain->login($this->user, $this->pass);

        if ($user[0] <= 0) {
            $rs['tips'] = '登录失败，用户名或密码错误！';
            return $rs;
        }

        $token =strtoupper(substr(sha1(uniqid(NULL, TRUE)) . sha1(uniqid(NULL, TRUE)), 0, 32));

        $domain->updateToken($user[0]['user_id'],$token);

        $rs['code'] = 0;
        $rs['user_id'] = $user[0]['user_id'];
        $rs['token'] = $token;
        $rs['user_points'] =  $user[0]['user_points'];
        $rs['rec_regist_link'] = "http://123.207.150.253/mvcms/index.php/user/reg.html?uid=".$rs['user_id'];
        $rs['rec_look_link'] = "http://123.207.150.253/mvcms/index.php/user/visit.html?uid=".$rs['user_id'];
        $rs['tips'] = "登录成功";
        $rs['group_id'] = $user[0]['group_id'];
        $rs['user_name'] = $user[0]['user_name'];
        $rs['user_end_time']= $user[0]['user_end_time'];
        $rs['user_portrait_thumb'] =$user[0]['user_portrait_thumb'];
        return $rs;
    }
}
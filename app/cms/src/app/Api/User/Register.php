<?php


namespace App\Api\User;


use App\Domain\Domain_User;
use PhalApi\Api;
/**
 * 注册
 * @author dogstar 20170612
 */
class Register extends Api
{

    public function getRules() {
        return array(
            'go' => array(
                'user' => array(
                    'name' => 'user',
                    'require' => true,
                    'min' => '6',
                    'desc' => '用户名',
                ),
                'pass' => array(
                    'name' => 'pass',
                    'require' => true,
                    'min' => '6',
                    'desc' => '登录密码',
                ),
                'mail' => array(
                    'name' => 'mail',
                    'require' => true,
                    'min' => '8',
                    'desc' => '邮箱，用以密码找回',
                )
            ),
        );
    }


    public function go(){
        $rs = array('code' => 1,
            'user_id' => 0,
            'token' => '',
            'tips' => '',
            'user_points' => '',
            'user_name'=>'',
            'user_portrait_thumb'=>'',
            'rec_regist_link' => '',
            'rec_look_link' => '',
            'group_id'=>''
        );

        $domain = new Domain_User();

        //这个pwd应该在客户端就转为md5
        $user = $domain->regist($this->user, $this->pass, $this->mail);

        if ($user <= 0) {
            $rs['tips'] = $user[0];
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
        $rs['tips'] = "注册成功";
        $rs['group_id'] = $user[0]['group_id'];
        $rs['user_name'] =$user[0]['user_name'];
        $rs['user_portrait_thumb'] =$user[0]['user_portrait_thumb'];
        return $rs;
    }
}
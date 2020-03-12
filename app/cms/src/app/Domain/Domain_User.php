<?php

namespace App\Domain;


use App\Model\Model_User;
use App\Model\OnlineModel;

class Domain_User
{

    /**
     * 登录
     * @param $page
     * @param $perpage
     * @return array
     */
    public function login($user, $pass)
    {
        $rs = array('items' => array(), 'total' => 0);
        $model = new Model_User();
        $rs['items'] = $model->login($user, $pass);
        return $rs['items'];
    }

    public function updateToken($userId, $token)
    {
        $model = new Model_User();
        $model->updateToken($userId, $token);
    }

    public function regist($user, $pass, $mail)
    {
        $rs = array('items' => array(), 'total' => 0);
        $model = new Model_User();
        $rs['items'] = $model->regist($user, $pass, $mail);
        return $rs['items'];
    }

    public function addCoin($utoken)
    {
        $rs = array('items' => array(), 'total' => 0);
        $model = new Model_User();
        $rs['items'] = $model->addCoin($utoken);
        return $rs['items'];
    }

    public function getCoin($utoken)
    {
        $rs = array('items' => array(), 'total' => 0);
        $model = new Model_User();
        $rs['items'] = $model->getCoin($utoken);
        return $rs['items'];
    }

    public function updateUserIcon($uid, $index)
    {
        $model = new Model_User();
        return $model->updateUserIcon($uid, $index);

    }

}

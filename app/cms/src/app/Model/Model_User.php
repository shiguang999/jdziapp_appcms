<?php

namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

/**
 * Class OnlineMovModel
 * @package App\Model
 */
class Model_User extends NotORM
{



    protected function getTableName($id)
    {
        return 'mac_user';
    }

    /**
     * 获取会员状态信息
     * @param $uid
     */
    public function getUserVipData($uid)
    {
        return $this->getORM()->select('user_points,user_end_time,group_id')->where('user_id', $uid)->fetchOne();

    }

    /**
     * 扣除用户对应的金币数
     * @param $uid
     * @param $payCoin
     */
    public function deCreaseCoin($uid, $leftCoin, $endTime)
    {
        $update = array(
            'user_points' => $leftCoin,
            'group_id' => 3,
            'user_end_time' => $endTime
        );
        $result = $this->getORM()->where('user_id', $uid)->update($update);
//        $fResult = $this->getORM()->select('user_points,group_id')->where('user_id',$uid)->fetchOne();
        return $result;
    }

    /**
     * 获取类型列表
     * @param $page
     * @param $perpage
     * @return array
     */
    public function login($user, $pass)
    {

        return $this->getORM()
            ->select('user_name,user_pwd,user_id,user_points,group_id,user_end_time,user_portrait_thumb')
            ->where("user_name='{$user}' ")
            ->where("user_pwd", $pass)
            ->fetchAll();
    }

    /**
     * 注册
     * @param $user
     * @param $pass
     */
    public function regist($user, $pass, $mail)
    {

        $data = array('user_name' => $user, 'user_pwd' => $pass, 'user_points' => 100,
            'group_id' => 2, 'user_status' => 1,
            'user_points_froze' => 0,
            'user_portrait_thumb' => 0,
            'user_reg_time' => time(),
            'user_email' => $mail
        );
        $regResult = $this->getORM()->insert($data);
        if ($regResult <= 0) {
            return $regResult;
        }
        $result = $this->getORM()->select('user_name,user_pwd,user_id,user_points,group_id,user_portrait_thumb')
            ->where("user_name='{$user}' ")
            ->where("user_pwd", $pass)
            ->fetchAll();
        return $result;
    }

    public function updateToken($userId, $token)
    {
        $data = array('user_random' => $token);
        return $this->getORM()
            ->where("user_id", $userId)
            ->update($data);
    }


    public function addCoin($utoken)
    {
        $result = $this->getORM()->select('user_points')
            ->where("user_random='{$utoken}' ")
            ->fetchOne();
        $points = $result['user_points'];
        $newPoint = (int)$points + 10;
        $data = array('user_points' => $newPoint);
        $this->getORM()
            ->where("user_random", $utoken)
            ->update($data);
        return $result = $this->getORM()->select('user_points')
            ->where("user_random='{$utoken}' ")
            ->fetchOne();
    }

    public function getCoin($utoken)
    {

        return $result = $this->getORM()->select('user_points,user_end_time,group_id,user_id')
            ->where("user_random='{$utoken}' ")
            ->fetchOne();
    }

    public function addUserFavor($uid, $vod_id)
    {

        $result = array('item' => array(), 'code' => 1);
        $favor = $this->getORM()->select('user_favor')->where('user_id', $uid)->fetchOne();
        if (strlen($favor['user_favor']) == 0) {
            $newFavor = $vod_id;
            $update = array('user_favor' => $newFavor);
            $result['item'] = $this->getORM()->where('user_id', $uid)->update($update);
            $result['code'] = 0;
            return $result;
        } else {
            if (strpos($favor['user_favor'], strval($vod_id)) !== false) {
                $result['code'] = 1;
                return $result;
            } else {

                if (strlen($favor['user_favor'], -1) == ',') {
                    $newFavor = $favor['user_favor'] . $vod_id;
                } else {
                    $newFavor = $favor['user_favor'] . ',' . $vod_id;
                }
                $update = array('user_favor' => $newFavor);
                $result['item'] = $this->getORM()->where('user_id', $uid)->update($update);
                $result['code'] = 0;
                return $result;
            }
        }

    }

    public function getUserFavor($uid)
    {
        return $regResult = $this->getORM()->select('user_favor')->where('user_id', $uid)->fetchOne();
    }

    public function cancelUserFavor($uid, $vod_id)
    {
        $results = array('code' => 1, 'data' => array());

        $favor = $this->getORM()->select('user_favor')->where('user_id', $uid)->fetchOne();

        if (strpos($favor['user_favor'], strval($vod_id)) !== false) {
            $newFavor = str_replace($vod_id, "", $favor['user_favor']);
            $result = str_replace(",,", ",", $newFavor);
            $update = array('user_favor' => $result);
            $results['data'] = $this->getORM()->where('user_id', $uid)->update($update);
            $results['code'] = 0;
            return $results;
        } else {
            $results['code'] = 1;
            return $results;
        }
    }


    public function getIfFavor($uid, $vod_id)
    {
        $results = array('code' => 1, 'data' => 2);

        $favor = $this->getORM()->select('user_favor')->where('user_id', $uid)->fetchOne();

        if (strpos($favor['user_favor'], strval($vod_id)) !== false) {
            $results['code'] = 0;
        } else {
            $results['code'] = 1;
        }
        return $results;
    }

    public function getUserCoin($uid)
    {
        return $this->getORM()->select('user_points,user_end_time')->where('user_id', $uid)->fetchOne();
    }

    public function updateUserIcon($uid, $user_thumb_id)
    {
        $update = array('user_portrait_thumb' => $user_thumb_id);
        $this->getORM()->where('user_id', $uid)->update($update);
        return $this->getORM()->select("user_portrait_thumb")->where('user_id', $uid)->fetchOne();
    }


    public function getUserIcon($user_id)
    {
       return $this->getORM()->select("user_portrait_thumb")->where('user_id', $user_id)->fetchOne();
    }
}

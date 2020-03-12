<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

/**
 * Class OnlineMovModel
 * @package App\Model
 */
class OnlineVipPlogModel extends NotORM {




    protected function getTableName($id) {
        return 'mac_plog';
    }

    public function buyVipToUser($uid, $payCoin)
    {

        //插入新纪录
        $newLog = array(
          'user_id'=>$uid,
          'plog_type'=>7,
          'plog_points'=>$payCoin,
          'plog_time'=>time()
        );
       return $this->getORM()->insert($newLog);
    }

    public function getPayLog($uid)
    {

       return $this->getORM()->select('user_id,plog_type,plog_points,plog_time')->where('user_id',$uid)->order('plog_time DESC')->fetchAll();

    }

}

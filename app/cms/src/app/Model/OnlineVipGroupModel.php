<?php

namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

/**
 * Class OnlineMovModel
 * @package App\Model
 */
class OnlineVipGroupModel extends NotORM
{


    protected function getTableName($id)
    {
        return 'mac_group';
    }

    /**
     * 获取会员分时支付的金币数量，按天，按周，按月，按年，获取配置
     * @param $uid
     * @param $vid_type
     */
    public function getVipTypeAndCoin($uid)
    {
        //先检查余额，是否支持

        //然后判断购买类型，1天   1周    1月    1年，分别对应1,2,3,4

        return $this->getORM()->select('group_points_week,group_points_month,group_points_year,group_points_day')->where('group_id',3)->fetchOne();


    }


    /**
     * 获取类型列表
     * @param $page
     * @param $perpage
     * @return array
     */
    public function getMovType()
    {
        return $this->getORM()
            ->select('type_name,type_id,type_sort,type_pid')
            ->order('type_id ASC')
            ->fetchAll();
    }


}

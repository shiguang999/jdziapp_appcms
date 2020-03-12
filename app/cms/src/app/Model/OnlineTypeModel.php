<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

/**
 * Class OnlineMovModel
 * @package App\Model
 */
class OnlineTypeModel extends NotORM {

    protected function getTableName($id) {
        return 'mac_type';
    }



    /**
     * 获取类型列表
     * @param $page
     * @param $perpage
     * @return array
     */
    public function getMovType() {
        return $this->getORM()
            ->select('type_name,type_id,type_sort,type_pid')
            ->order('type_id ASC')
            ->fetchAll();
    }



}

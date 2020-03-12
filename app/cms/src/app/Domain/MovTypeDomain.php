<?php
namespace App\Domain;


use App\Model\OnlineTypeModel;
use App\Model\SubjectListModel;

class MovTypeDomain {

    /**
     * 根据类型列表
     * @param $page
     * @param $perpage
     * @return array
     */
    public function getTypeList() {
        $rs = array('items' => array(), 'total' => 0);
        $model = new OnlineTypeModel();
        $items = $model->getMovType();
        $rs['items'] = $items;
        return $rs;
    }

}

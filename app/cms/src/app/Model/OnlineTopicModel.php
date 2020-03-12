<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

/**
 * Class OnlineMovModel
 * @package App\Model
 */
class OnlineTopicModel extends NotORM {

    protected function getTableName($id) {
        return 'mac_topic';
    }



    /**
     * 获取专题列表
     * @param $page
     * @param $perpage
     * @return array
     */
    public function getTopicRoot($page,$perpage) {
        return $this->getORM()
            ->select('topic_id,topic_name,topic_pic_slide,topic_sub')
            ->order('topic_time desc')
            ->limit(($page - 1) * $perpage, $perpage)
            ->fetchAll();
    }


    /**
     * 获取专题详情vodid列表
     * @param $page
     * @param $perpage
     * @return array
     */
    public function getTopicList($topicId) {

        $rs = array('vodId' => array());

        return  $rs['vodId']=  $this->getORM()
            ->select('topic_rel_vod')
            ->where('topic_id',$topicId)
            ->fetchAll();
    }

}

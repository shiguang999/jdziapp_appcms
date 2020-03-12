<?php

namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

/**
 * Class OnlineMovModel
 * @package App\Model
 */
class OnlineModel extends NotORM
{




    protected function getTableName($id)
    {
        return 'mac_vod';
    }

    /**
     * 获取首页推荐位
     * @param $level
     */
    public function getHomeLevel()
    {
        $rs = array('le1' => array(), 'le2' => array(), 'le3' => array(), 'le4' => array(), 'le5' => array(), 'le6' => array());

        $rs['le1'] = $this->getORM()
            ->select('vod_id,vod_play_from,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
            ->where('vod_level', 7)
            ->order('vod_time desc')
            ->limit(0, 6)
            ->fetchAll();
        $rs['le2'] = $this->getORM()
            ->select('vod_id,vod_play_from,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
            ->where('vod_level', 2)
            ->order('vod_time desc')
            ->limit(0, 6)
            ->fetchAll();

        $rs['le3'] = $this->getORM()
            ->select('vod_id,vod_play_from,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
            ->where('vod_level', 3)
            ->order('vod_time desc')
            ->limit(0, 6)
            ->fetchAll();
        $rs['le4'] = $this->getORM()
            ->select('vod_id,vod_play_from,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
            ->where('vod_level', 4)
            ->order('vod_time desc')
            ->limit(0, 6)
            ->fetchAll();
        $rs['le5'] = $this->getORM()
            ->select('vod_id,vod_play_from,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
            ->where('vod_level', 5)
            ->order('vod_time desc')
            ->limit(0, 6)
            ->fetchAll();
        $rs['le6'] = $this->getORM()
            ->select('vod_id,vod_play_from,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
            ->where('vod_level', 6)
            ->order('vod_time desc')
            ->limit(0, 6)
            ->fetchAll();
        return $rs;
    }

    /**
     * 获取首页推荐位全部数据
     * @param $level
     */
    public function getHomeLevelAll($level, $page, $perpage)
    {

        return $this->getORM()
            ->select('vod_id,vod_play_from,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
            ->where('vod_level', $level)
            ->order('vod_time desc')
            ->limit(($page - 1) * $perpage, $perpage)
            ->fetchAll();;
    }


    public function getAllSearch($keyWords, $page, $perpage)
    {

        $qure = '%' . $keyWords . '%';

        return $this->getORM()
            ->select('vod_id,vod_play_from,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
            ->where("vod_name like '{$qure}' ")
            ->order('vod_time DESC')
            ->limit(($page - 1) * $perpage, $perpage)
            ->fetchAll();
    }

    public function getRecWordForSearch()
    {

        return $this->getORM()
            ->select('vod_name,vod_pic,vod_id,vod_remarks,vod_score')
            ->where('vod_score>7')
            ->order('rand()')
            ->limit(1, 20)
            ->fetchAll();
    }

    public function getListTotal($keyWords)
    {
        $qure = '%' . $keyWords . '%';
        $total = $this->getORM()
            ->where("vod_name like '{$qure}' ")
            ->count('vod_id');

        return intval($total);
    }

    /**
     * 根据id获取在线电影
     * @param $page
     * @param $perpage
     * @return array
     */
    public function getMovById($vodid)
    {
        return $this->getORM()
            ->select('vod_id,vod_play_from,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
            ->where("vod_id='{$vodid}' ")
            ->fetchAll();
    }

    /**
     * 根据id获取在线电影
     * @param $page
     * @param $perpage
     * @return array
     */
    public function getTestMovById($vodid)
    {
        return $this->getORM()
            ->select('*')
            ->where("vod_id='{$vodid}' ")
            ->fetchAll();
    }

    /**
     * 获取在线影片
     * @param $page
     * @param $perpage
     * @return mixed
     */
    public function getOnlineMvListItems($page, $perpage, $qure)
    {
        $type = array(
            "comedy" => "喜剧片",
            "love" => "爱情片",
            "science" => "科幻片",
            "terror" => "恐怖片",
            "story" => "剧情片",
            "war" => "战争片",
            "document" => "记录片",
            "show" => "综艺片");
        $find = $type[$qure];
        return $this->getORM()
            ->select('*')
            ->where("movClass='{$find}'")
            ->order('mv_update_time DESC')
            ->limit(($page - 1) * $perpage, $perpage)
            ->fetchAll();
    }


    /**
     * 获取在线影片推荐
     * @param $page
     * @param $perpage
     * @return mixed
     */
    public function getOnlineMovRandom($page, $perpage, $qure)
    {


        return $this->getORM()
            ->select('vod_id,vod_play_from,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
            ->where("type_id='{$qure}'")
            ->order('rand()')
            ->limit(($page - 1) * $perpage, $perpage)
            ->fetchAll();
    }


    /**
     * 获取影片推荐
     * @param $page
     * @param $perpage
     * @return mixed
     */
    public function getRecommendByType($page, $perpage, $qure)
    {

        $type = array(
            "comedy" => "喜剧片",
            "love" => "爱情片",
            "science" => "科幻片",
            "terror" => "恐怖片",
            "story" => "剧情片",
            "war" => "战争片",
            "document" => "记录片",
            "show" => "综艺片",
            "hongkong" => "香港剧",
            "taiwan" => "台湾剧",
            "native" => "国产剧",
            "japanise" => "日本剧",
            "america" => "欧美剧",
            "koria" => "韩剧",
            "curtoon" => "动漫",
            "good" => "福利片",
            "ocean" => "海外剧"
        );

        $find = $type[$qure];
        return $this->getORM()
            ->select('*')
            ->where("movClass='{$find}'")
            ->order('rand()')
            ->limit(($page - 1) * $perpage, $perpage)
            ->fetchAll();
    }

    /**
     * 获取分类筛选
     * @param $page
     * @param $perpage
     * @return mixed
     */
    public function getCategoryFind($page, $perpage, $type, $area, $year, $sort)
    {

        if ($type == 0 ) {
            $type=0;
        } elseif ($type==1){
            $type=6;
        }elseif ($type==2){
            $type=13;
        }

        //第一层判断year为0、2010、其他三种情况
        if ($year == 2010) {

            if (empty($area)) {
                if ($type==0){
                    return $this->getORM()
                        ->select('vod_id,vod_play_from,vod_class,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
                        ->where("vod_year<=2016")
                        ->order('vod_time DESC')
                        ->limit(($page - 1) * $perpage, $perpage)
                        ->fetchAll();
                }else{
                    return $this->getORM()
                        ->select('vod_id,vod_play_from,vod_class,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
                        ->where("vod_year<=2016")
                        ->where('type_id', $type)
                        ->order('vod_time DESC')
                        ->limit(($page - 1) * $perpage, $perpage)
                        ->fetchAll();
                }

            } else {
                if ($type==0){
                    return $this->getORM()
                        ->select('vod_id,vod_play_from,vod_class,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
                        ->where("vod_year<=2016")
                        ->order('vod_time DESC')
                        ->limit(($page - 1) * $perpage, $perpage)
                        ->fetchAll();
                }else{
                    return $this->getORM()
                        ->select('vod_id,vod_play_from,vod_class,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
                        ->where("vod_year<=2016")
                        ->where("vod_area", $area)
                        ->where('type_id', $type)
                        ->order('vod_time DESC')
                        ->limit(($page - 1) * $perpage, $perpage)
                        ->fetchAll();
                }
            }

        }elseif ($year==0){

            //第二层判断¥area是否为空
            if (empty($area)) {
                if ($type==0){
                    return $this->getORM()
                        ->select('vod_id,vod_play_from,vod_class,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
                        ->order('vod_time DESC')
                        ->limit(($page - 1) * $perpage, $perpage)
                        ->fetchAll();
                }else{
                    return $this->getORM()
                        ->select('vod_id,vod_play_from,vod_class,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
                        ->where('type_id', $type)
                        ->order('vod_time DESC')
                        ->limit(($page - 1) * $perpage, $perpage)
                        ->fetchAll();
                }

            } else {
                if ($type==0){
                    return $this->getORM()
                        ->select('vod_id,vod_play_from,vod_class,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
                        ->order('vod_time DESC')
                        ->limit(($page - 1) * $perpage, $perpage)
                        ->fetchAll();
                }else{
                    return $this->getORM()
                        ->select('vod_id,vod_play_from,vod_class,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
                        ->where("vod_area", $area)
                        ->where('type_id', $type)
                        ->order('vod_time DESC')
                        ->limit(($page - 1) * $perpage, $perpage)
                        ->fetchAll();
                }
            }


        }else{


            //第二层判断¥area是否为空
            if (empty($area)) {
                if ($type==0){
                    return $this->getORM()
                        ->select('vod_id,vod_play_from,vod_class,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
                        ->where("vod_year", $year)
                        ->order('vod_time DESC')
                        ->limit(($page - 1) * $perpage, $perpage)
                        ->fetchAll();
                }else{
                    return $this->getORM()
                        ->select('vod_id,vod_play_from,vod_class,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
                        ->where('type_id', $type)
                        ->where("vod_year", $year)
                        ->order('vod_time DESC')
                        ->limit(($page - 1) * $perpage, $perpage)
                        ->fetchAll();
                }

            } else {
                if ($type==0){
                    return $this->getORM()
                        ->select('vod_id,vod_play_from,vod_class,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
                        ->where("vod_year", $year)
                        ->where("vod_area", $area)
                        ->order('vod_time DESC')
                        ->limit(($page - 1) * $perpage, $perpage)
                        ->fetchAll();
                }else{
                    return $this->getORM()
                        ->select('vod_id,vod_play_from,vod_class,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
                        ->where("vod_year", $year)
                        ->where("vod_area", $area)
                        ->where('type_id', $type)
                        ->order('vod_time DESC')
                        ->limit(($page - 1) * $perpage, $perpage)
                        ->fetchAll();
                }
            }

        }

    }

    /**
     * 获取在线影片
     * @param $page
     * @param $perpage
     * @return mixed
     */
    public function getOnlineItems($page, $perpage, $qure)
    {


        return $this->getORM()
            ->select('vod_id,vod_play_from,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
            ->where("type_id ='{$qure}'")
            ->order('vod_time DESC')
            ->limit(($page - 1) * $perpage, $perpage)
            ->fetchAll();
    }

    public function getMovIdArray($vodid)
    {
        return $this->getORM()
            ->select('vod_id,vod_play_from,type_id,vod_name,vod_actor,vod_pic,vod_remarks,vod_area,vod_lang,vod_year,vod_score,vod_time,vod_time_add,vod_content,vod_play_url')
            ->where("vod_id", $vodid)
            ->order('vod_time DESC')
            ->fetchAll();
    }

    /**
     * 获取分类筛选类型
     */
    public function getGroup($groupId)
    {
        $group = array(
            'vod_area'=>array(),
            'vod_type'=>array()
        );

       return $this->getORM()->group('vod_area')->fetchRows();
    }
}

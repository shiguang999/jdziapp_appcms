<?php

namespace App\Domain;


use App\Model\Model_Comment;
use App\Model\Model_User;
use App\Model\OnlineFavorModel;
use App\Model\OnlineModel;
use App\Model\OnlineTopicModel;
use App\Model\OnlineVipGroupModel;
use App\Model\OnlineVipPlogModel;
use App\Model\SeriModel as SeriCURD;
use App\Model\SubjectListModel;

class MovDomain
{


    /**
     * 获取电视剧列表
     * @param $page
     * @param $perpage
     * @return array
     */
    public function getSeriList($page, $perpage)
    {
        $rs = array('items' => array(), 'total' => 0);

        $cache = \PhalApi\DI()->cache;

        $data = $cache->get('cate_home_seri_' . $page);
        if (empty($data)) {


            $model = new SeriCURD();
            $items = $model->getListItems($page, $perpage);

            $rs['items'] = $items;
            $cache->set('cate_home_seri_' . $page, $items, 300);

            return $rs;
        } else {
            $rs['items'] = $data;
            return $rs;
        }
    }


    /**
     * 根据id获取在线电影
     * @param $page
     * @param $perpage
     * @return array
     */
    public function getOnlineMovById($vodid)
    {

        $model = new OnlineModel();
        $items = $model->getMovById($vodid);
        return $items;
    }


    /**
     * 登录
     * @param $page
     * @param $perpage
     * @return array
     */
    public function login($userName, $pwd)
    {

        $model = new OnlineModel();
        $items = $model->login($userName, $pwd);
        return $items;
    }

    /**
     * 获取搜索词
     * @param $page
     * @param $perpage
     * @return array
     */
    public function getOnlineMovList()
    {
        $rs = array('items' => array(), 'total' => 0);

        $model = new OnlineModel();
        $items = $model->getRecWordForSearch();
        $rs['items'] = $items;

        return $rs;
    }


    /**
     * 获取在线剧集列表，动画、综艺
     * @param $page
     * @param $perpage
     * @return array
     */
    public function getOnlineList($page, $perpage, $type)
    {
        $rs = array('items' => array(), 'total' => 0);

        $cache = \PhalApi\DI()->cache;

        $data = $cache->get('onlineSeri_' . $type . '-' . $page);
        if (empty($data)) {

            $model = new OnlineModel();
            $items = $model->getOnlineItems($page, $perpage, $type);
            $rs['items'] = $items;
            $cache->set('onlineSeri_' . $type . '-' . $page, $items, 300);

            return $rs;
        } else {
            $rs['items'] = $data;
            return $rs;
        }
    }


    /**
     * 获取随机推荐
     * @param $page
     * @param $perpage
     * @return array
     */
    public function getOnlineRandomRecommend($page, $perpage, $type)
    {
        $rs = array('items' => array(), 'total' => 0);
        $model = new OnlineModel();
        $items = $model->getOnlineMovRandom($page, $perpage, $type);
        $rs['items'] = $items;
        return $rs;
    }


    /**
     * 搜索电影
     * @param $page
     * @param $perpage
     * @return array
     */
    public function getMacSearch($keyWords, $page, $perpage)
    {
        $rs = array('items' => array(), 'total' => 0);

        $model = new OnlineModel();
        $items = $model->getAllSearch($keyWords, $page, $perpage);
        $total = $model->getListTotal($keyWords);
        $rs['items'] = $items;
        $rs['total'] = $total;

        return $rs;
    }

    /**
     * @param $level
     */
    public function getHomeLevel()
    {


        $model = new OnlineModel();
        $items = $model->getHomeLevel();


        return $items;
    }

    /**
     * @param $level
     */
    public function getHomeLevelAll($level, $page, $limit)
    {


        $model = new OnlineModel();
        $items = $model->getHomeLevelAll($level, $page, $limit);


        return $items;
    }

    /**
     * 获取专题列表
     */
    public function getTopicRootList($page, $limit)
    {
        $model = new OnlineTopicModel();

        return $model->getTopicRoot($page, $limit);
    }

    /**
     * 获取专题列表
     */
    public function getTopicList($topicId)
    {
        $model = new OnlineTopicModel();
        $vodIdArray = $model->getTopicList($topicId);

        $model = new OnlineModel();
        $items = $model->getMovIdArray(explode(",", $vodIdArray[0]['topic_rel_vod']));
        return $items;
    }

    public function addFavor($uid, $vod_id)
    {
        $model = new Model_User();
        $items = $model->addUserFavor($uid, $vod_id);


        return $items;
    }

    public function getFavor($uid)
    {
        $model = new Model_User();
        $vodIdArray = $model->getUserFavor($uid);
        $vodModel = new OnlineModel();
        $vodItem = $vodModel->getMovIdArray(explode(",", $vodIdArray['user_favor']));
        return $vodItem;
    }

    public function cancelFavor($uid, $vod_id)
    {
        $model = new Model_User();
        $items = $model->cancelUserFavor($uid, $vod_id);


        return $items;
    }

    public function getIfFavor($uid, $vod_id)
    {
        $model = new Model_User();
        $items = $model->getIfFavor($uid, $vod_id);


        return $items;
    }

    public function addComment($uid, $vod_id, $vod_comment_pid, $vod_comment_content, $vod_uname)
    {
        $model = new Model_Comment();
        $items = $model->addNewComment($uid, $vod_id, $vod_comment_pid, $vod_comment_content, $vod_uname);
        return $items;
    }

    public function deleteComment($uid, $vod_comment_id)
    {
        $model = new Model_Comment();
        $items = $model->deleteUserComment($uid, $vod_comment_id);
        return $items;
    }

    public function getComment($vodId, $page, $limit)
    {

        $commentResult = array('item' => array());

        $model = new Model_Comment();
        $userModel = new Model_User();
        $items = $model->getComment($vodId, $page, $limit);
        foreach ($items as $item) {

            $result = array('comment' => array(), 'reply' => array(),'user_icon'=>'','rep_icon'=>'');

            if ($item['comment_pid'] != 0) {
                $rep = $model->getCommentById($item['comment_pid']);
                if ($rep) {
                    $result['reply'] = $rep;
                } else {
                    $result['reply'] = null;
                }
                //获取回复人的头像
                $thumb = $userModel->getUserIcon($rep['user_id']);
                $result['rep_icon'] = $thumb['user_portrait_thumb'];

            } else {
                $result['reply'] = null;
            }
            if ($item <= 0) {
                continue;
            }

            //获取主评论的头像
            $thumbMain= $userModel->getUserIcon($item['user_id']);
            $result['user_icon'] = $thumbMain['user_portrait_thumb'];
            $result['comment'] = $item;

            array_push($commentResult['item'], $result);
        }

        return $commentResult;
    }

    public function diggComment($vod_comment_id)
    {
        $model = new Model_Comment();
        $items = $model->diggComment($vod_comment_id);
        return $items;
    }

    public function cancleDiggComment($vod_comment_id)
    {
        $model = new Model_Comment();
        $items = $model->canceldiggComment($vod_comment_id);
        return $items;
    }

    public function getTestById($vodid)
    {
        $model = new OnlineModel();
        $items = $model->getTestMovById($vodid);
        return $items;
    }

    public function buyVipForUser($uid, $vid_type)
    {

        $result = array(
            'item_data' => array(),
            'item_code' => -1,
            'item_msg' => ''
        );

        $model = new Model_User();
        $Coin = $model->getUserCoin($uid);


        $config = new OnlineVipGroupModel();
        $configArr = $config->getVipTypeAndCoin($uid);

        $payCoin = 0;
        $endTimePlus = 0;
        switch ($vid_type) {
            case 1:
                $payCoin = $configArr['group_points_day'];
                $endTimePlus = 86400;
                break;
            case 2:
                $payCoin = $configArr['group_points_week'];
                $endTimePlus = 604800;
                break;
            case 3:
                $payCoin = $configArr['group_points_month'];
                $endTimePlus = 2592000;
                break;
            case 4:
                $payCoin = $configArr['group_points_year'];
                $endTimePlus = 31104000;
                break;
            default:
                break;
        }
        //如果用户余额大于所要购买的会员种类
        if ($payCoin <= $Coin['user_points']) {
            //需要修改三个表： 用户表，升级用户对应要修改group_id   user_points

            $leftCoin = $Coin['user_points'] - $payCoin;
            //如果是0就是没有会员，按当前日期加上需要累加的权限日期
            $endTime = $Coin['user_end_time'] == 0 ? time() + $endTimePlus : ($Coin['user_end_time'] + $endTimePlus);
            //如果返回1，执行完成，修改完成
            $payResult = $model->deCreaseCoin($uid, $leftCoin, $endTime);
            //会员兑换记录表 plog,插入新的记录
            $pLog = new OnlineVipPlogModel();
            $plogResult = $pLog->buyVipToUser($uid, $payCoin);

        } else {
            //金币不够，直接返回
            $vipResult = $model->getUserVipData($uid);
            $result['item_code'] = 1;
            $result['item_msg'] = '金币余额不足';
            $result['item_data'] = $vipResult;
            return $result;
        }


        //返回查询一次用户金币余额、到期时间、会员等级
        $vipResult = $model->getUserVipData($uid);
        $result['item_code'] = 0;
        $result['item_data'] = $vipResult;
        $result['item_msg'] = '会员升级完成';
        return $result;
    }

    /**
     * 获取记录
     * @param $uid
     */
    public function getPayHistory($uid)
    {
        $rs = array(
            'pay_log' => array(),
            'vip_data' => array()
        );

        //金币不够，直接返回
        $model = new Model_User();
        $vipResult = $model->getUserVipData($uid);
        $models = new OnlineVipPlogModel();
        $rs['pay_log'] = $models->getPayLog($uid);
        $rs['vip_data'] = $vipResult;
        return $rs;
    }

    public function getCategory($type, $area, $year, $sort, $page, $limit)
    {


//
//        $rs = array('items' => array(), 'total' => 0);
//
//        $cache = \PhalApi\DI()->cache;
//
//        $data = $cache->get('online_category_' . $type . '-' .$area.'-'.$year.'-'.$sort.'-'. $page);
//        if (empty($data)) {
//
//            $model = new OnlineModel();
//            $items = $model->getCategoryFind($page, $limit, $type, $area, $year, $sort);
//            $rs['items'] = $items;
//            $cache->set('online_category_' . $type . '-' .$area.'-'.$year.'-'.$sort.'-'. $page, $items, 3);
//
//            return $rs;
//        } else {
//            $rs['items'] = $data;
//            return $rs;
//        }
        $model = new OnlineModel();
        $items = $model->getCategoryFind($page, $limit, $type, $area, $year, $sort);
        return $items;
    }

    public function getCategoryGroup($groupId)
    {


        $model = new OnlineModel();
        $items = $model->getGroup($groupId);
        return $items;
    }


}

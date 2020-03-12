<?php

namespace App\Api;

use App\Domain\Domain_User;
use PhalApi\Api;
use App\Domain\MovDomain as DomainCURD;
use App\Domain\MovTypeDomain as TypeCURD;

/**
 * 苹果cms移动app接口归档
 * @author dogstar 20170612
 */
class Mov extends Api
{


    public function getRules()
    {

        return array(


            'searchVod' => array(
                'key' => array('name' => 'key', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '电影搜索关键词，参数必须'),
                'page' => array('name' => 'page', 'type' => 'int', 'min' => 1, 'default' => 1, 'desc' => '第几页'),
                'limit' => array('name' => 'limit', 'type' => 'int', 'min' => 1, 'max' => 20, 'default' => 10, 'desc' => '分页数量')
            ),
            'getOnlineList' => array(
                'type' => array('name' => 'type_id', 'type' => 'string', 'require' => true, 'default' => '3', 'desc' => '剧集类型type_id，参数必须'),
                'page' => array('name' => 'page', 'type' => 'int', 'min' => 1, 'default' => 1, 'desc' => '第几页'),
                'limit' => array('name' => 'limit', 'type' => 'int', 'min' => 1, 'max' => 20, 'default' => 10, 'desc' => '分页数量')
            ),
            'getHomeHot' => array(
                'type' => array('name' => 'type_id', 'type' => 'string', 'require' => true, 'default' => '3', 'desc' => '剧集类型type_id，参数必须'),
                'page' => array('name' => 'page', 'type' => 'int', 'min' => 1, 'default' => 1, 'desc' => '第几页'),
                'limit' => array('name' => 'limit', 'type' => 'int', 'min' => 1, 'max' => 20, 'default' => 10, 'desc' => '分页数量')
            ),
            'getRecommend' => array(
                'type' => array('name' => 'type', 'type' => 'int', 'require' => true, 'default' => 'science', 'desc' => '剧集类型key，参数必须'),
                'page' => array('name' => 'page', 'type' => 'int', 'min' => 1, 'default' => 1, 'desc' => '第几页'),
                'limit' => array('name' => 'limit', 'type' => 'int', 'min' => 1, 'max' => 20, 'default' => 10, 'desc' => '分页数量')
            ),
            'getTypeList' => array(),
            'getOnlineMvById' => array(
                'vodid' => array('name' => 'vodid', 'type' => 'int', 'require' => true, 'default' => '1', 'desc' => '影片id，参数必须')
            ),
            'getBanner' => array(
                'page' => array('name' => 'page', 'type' => 'int', 'min' => 1, 'default' => 1, 'desc' => '第几页'),
                'limit' => array('name' => 'limit', 'type' => 'int', 'min' => 1, 'max' => 20, 'default' => 10, 'desc' => '分页数量')
            ),
            'getCateGroup' => array(
                'group_id' => array('name' => 'group_id', 'type' => 'int', 'min' => 0, 'max' => 10, 'default' => 1, 'desc' => '大类分组ID')
            ),
            'getHomeLevel' => array(
                'level' => array('name' => 'level', 'type' => 'int', 'min' => 1, 'max' => 10, 'default' => 1, 'desc' => '推荐位索引')
            ),
            'getHomeLevelAll' => array(
                'level' => array('name' => 'level', 'type' => 'int', 'min' => 1, 'max' => 10, 'default' => 1, 'desc' => '推荐位索引'),
                'page' => array('name' => 'page', 'type' => 'int', 'min' => 1, 'default' => 1, 'desc' => '第几页'),
                'limit' => array('name' => 'limit', 'type' => 'int', 'min' => 1, 'max' => 20, 'default' => 10, 'desc' => '分页数量')
            ),
            'getTopicList' => array(
                'topic_id' => array('name' => 'topic_id', 'type' => 'int', 'min' => 1, 'max' => 10, 'default' => 1, 'desc' => '专题ID')
            ),
            'getTopicRootList' => array(
                'page' => array('name' => 'page', 'type' => 'int', 'min' => 1, 'default' => 1, 'desc' => '第几页'),
                'limit' => array('name' => 'limit', 'type' => 'int', 'min' => 1, 'max' => 20, 'default' => 10, 'desc' => '分页数量')
            ),
            'addCoin' => array(
                'utoken' => array('name' => 'utoken', 'type' => 'string', 'require' => true, 'default' => 'idddd', 'desc' => '用户ID')
            ),
            'getCoin' => array(
                'utoken' => array('name' => 'utoken', 'type' => 'string', 'require' => true, 'default' => 'idddd', 'desc' => '用户ID')
            ),
            'addFavor' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'min' => 1, 'default' => 1, 'desc' => '用户ID'),
                'vod_id' => array('name' => 'vod_id', 'type' => 'int', 'require' => true, 'min' => 1, 'default' => 1, 'desc' => '影片ID')
            ),
            'getFavor' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'min' => 1, 'default' => 1, 'desc' => '用户ID')
            ),
            'cancelFavor' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'min' => 1, 'default' => 1, 'desc' => '用户ID'),
                'vod_id' => array('name' => 'vod_id', 'type' => 'int', 'require' => true, 'min' => 1, 'default' => 19686, 'desc' => '影片ID')
            ),
            'getHaveFavor' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'min' => 1, 'default' => 1, 'desc' => '用户ID'),
                'vod_id' => array('name' => 'vod_id', 'type' => 'int', 'require' => true, 'min' => 1, 'default' => 19686, 'desc' => '影片ID')
            ),
            'addComment' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'min' => 1, 'default' => 1, 'desc' => '用户ID'),
                'vod_id' => array('name' => 'vod_id', 'type' => 'int', 'require' => true, 'min' => 1, 'default' => 1, 'desc' => '影片ID'),
                'vod_comment_pid' => array('name' => 'vod_comment_pid', 'type' => 'int', 'require' => true, 'min' => 0, 'default' => 0, 'desc' => '父级评论的commentId,用于区别一级还是回复'),
                'vod_comment_content' => array('name' => 'vod_comment_content', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '评论内容'),
                'vod_uname' => array('name' => 'vod_uname', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '用户名')
            ),
            'deleteComment' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'min' => 1, 'default' => 1, 'desc' => '用户ID'),
                'vod_comment_id' => array('name' => 'vod_comment_id', 'type' => 'int', 'require' => true, 'min' => 0, 'default' => 0, 'desc' => '评论的commentId')
            ),
            'getComment' => array(
                'vod_id' => array('name' => 'vod_id', 'type' => 'int', 'require' => true, 'min' => 0, 'default' => 0, 'desc' => '影片ID'),
                'page' => array('name' => 'page', 'type' => 'int', 'min' => 1, 'default' => 1, 'desc' => '第几页'),
                'limit' => array('name' => 'limit', 'type' => 'int', 'min' => 1, 'max' => 20, 'default' => 10, 'desc' => '分页数量')
            ),
            'diggComment' => array(
                'vod_comment_id' => array('name' => 'vod_comment_id', 'type' => 'int', 'require' => true, 'min' => 0, 'default' => 0, 'desc' => '评论的commentId')
            ),
            'cancelDiggComment' => array(
                'vod_comment_id' => array('name' => 'vod_comment_id', 'type' => 'int', 'require' => true, 'min' => 0, 'default' => 0, 'desc' => '评论的commentId')
            ),
            'buyVip' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'min' => 1, 'default' => 1, 'desc' => '用户ID'),
                'vip_type' => array('name' => 'vip_type', 'type' => 'int', 'require' => true, 'min' => 1, 'default' => 1, 'desc' => '会员类别')
            ),
            'getPayLog' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'min' => 1, 'default' => 1, 'desc' => '用户ID')
            ),
            'getCategory' => array(
                'type' => array('name' => 'type', 'type' => 'int', 'require' => true, 'default' => '', 'desc' => '分类id，参数必须'),
                'area' => array('name' => 'area', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '地区，参数必须'),
                'year' => array('name' => 'year', 'type' => 'int', 'require' => true, 'default' => '', 'desc' => '年代，参数必须'),
                'sort' => array('name' => 'sort', 'type' => 'int', 'require' => true, 'default' => '1', 'desc' => '排序方式，1按更新时间、2评分高低、3用户点赞数量，参数必须'),
                'page' => array('name' => 'page', 'type' => 'int', 'min' => 1, 'default' => 1, 'desc' => '第几页'),
                'limit' => array('name' => 'limit', 'type' => 'int', 'min' => 1, 'max' => 20, 'default' => 10, 'desc' => '分页数量')
            ),
            'checkUpdate' => array(),
            'updateUserIcon' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'min' => 1, 'default' => 1, 'desc' => '用户ID'),
                'index' => array('name' => 'index', 'type' => 'string', 'require' => true, 'default' => "0", 'desc' => '用户头像id')
            ),
            'getAdConfig' => array()
        );
    }

    /**
     * 获取筛选类型数据
     */
    public function getCateGroup()
    {
        $domain = new DomainCURD();
        $list = $domain->getCategoryGroup($this->group_id);
        return $list;
    }

    /**
     * 修改用户头像
     * @desc 参数，type,year,area,sort,page,limit
     */
    public function updateUserIcon()
    {
        $domain = new Domain_User();;
        $list = $domain->updateUserIcon($this->uid, $this->index);
        return $list;
    }

    /**
     * 获取分类筛选结果
     * @desc 参数，type,year,area,sort,page,limit
     */
    public function getCategory()
    {
        $domain = new DomainCURD();
        $list = $domain->getCategory($this->type, $this->area, $this->year, $this->sort, $this->page, $this->limit);
        return $list;
    }

    /**
     * 获取兑换记录
     * @desc 参数，level
     */
    public function getPayLog()
    {
        $domain = new DomainCURD();
        $list = $domain->getPayHistory($this->uid);
        return $list;
    }

    /**
     * 兑换会员，升级会员
     * @desc 参数，level
     */
    public function buyVip()
    {
        $domain = new DomainCURD();
        $list = $domain->buyVipForUser($this->uid, $this->vip_type);
        return $list;
    }

    /**
     * 获取影片评论
     * @desc 参数，level
     */
    public function cancelDiggComment()
    {
        $domain = new DomainCURD();
        $list = $domain->cancleDiggComment($this->vod_comment_id);
        return $list;
    }

    /**
     * 获取影片评论
     * @desc 参数，level
     */
    public function diggComment()
    {
        $domain = new DomainCURD();
        $list = $domain->diggComment($this->vod_comment_id);
        return $list;
    }

    /**
     * 获取影片评论
     * @desc 参数，level
     */
    public function getComment()
    {
        $domain = new DomainCURD();
        $list = $domain->getComment($this->vod_id, $this->page, $this->limit);
        return $list;
    }

    /**
     * 评论作者删除评论
     * @desc 参数，level
     */
    public function deleteComment()
    {
        $domain = new DomainCURD();
        $list = $domain->deleteComment($this->uid, $this->vod_comment_id);
        return $list;
    }

    /**
     * 新建评论
     * @desc 参数，level
     */
    public function addComment()
    {
        $domain = new DomainCURD();
        $list = $domain->addComment($this->uid, $this->vod_id, $this->vod_comment_pid, $this->vod_comment_content, $this->vod_uname);
        return $list;
    }

    /**
     * 添加收藏
     * @desc 参数，level
     */
    public function addFavor()
    {
        $domain = new DomainCURD();
        $list = $domain->addFavor($this->uid, $this->vod_id);
        return $list;
    }

    /**
     * 添加收藏
     * @desc 参数，level
     */
    public function getHaveFavor()
    {
        $domain = new DomainCURD();
        $list = $domain->getIfFavor($this->uid, $this->vod_id);
        return $list;
    }

    /**
     * 取消收藏
     * @desc 参数，level
     */
    public function cancelFavor()
    {
        $domain = new DomainCURD();
        $list = $domain->cancelFavor($this->uid, $this->vod_id);
        return $list;
    }

    /**
     * 获取收藏
     * @desc 参数，level
     */
    public function getFavor()
    {
        $domain = new DomainCURD();
        $list = $domain->getFavor($this->uid);
        return $list;
    }

    /**
     * 添加用户金币
     * @desc 参数，level
     */
    public function addCoin()
    {
        $domain = new Domain_User();
        $list = $domain->addCoin($this->utoken);
        return $list;
    }

    /**
     * 获取用户金币
     * @desc 参数，level
     */
    public function getCoin()
    {
        $domain = new Domain_User();
        $list = $domain->getCoin($this->utoken);
        return $list;
    }

    /**
     * 获取专题列表数据
     * @desc 参数，level
     */
    public function getTopicRootList()
    {
        $domain = new DomainCURD();
        $list = $domain->getTopicRootList($this->page, $this->limit);
        return $list;
    }

    /**
     * 获取专题详情列表数据
     * @desc 参数，level
     */
    public function getTopicList()
    {
        $domain = new DomainCURD();
        $list = $domain->getTopicList($this->topic_id);
        return $list;
    }

    /**
     * 根据id查询在线电影
     * @desc 在线电影库
     * @return string   md5id  影评id
     */
    public function getOnlineMvById()
    {

        $domain = new DomainCURD();
        $list = $domain->getOnlineMovById($this->vodid);
        return $list;
    }

    /**
     * 获取首页推荐位数据
     * @desc 参数，level
     */
    public function getHomeLevel()
    {
        $domain = new DomainCURD();
        $list = $domain->getHomeLevel();
        return $list;
    }


    /**
     * 获取首页推荐位数据
     * @desc 参数，level
     */
    public function getHomeLevelAll()
    {

        $domain = new DomainCURD();
        $list = $domain->getHomeLevelAll($this->level, $this->page, $this->limit);
        return $list;
    }


    /**
     * 搜索接口A
     * @desc 搜索离线电影
     * @return string   key       关键词
     * @return string   page     当前页
     * @return string   limit     每页数量
     */
    public function searchVod()
    {
        $rs = array();
        $domain = new DomainCURD();
        $list = $domain->getMacSearch($this->key, $this->page, $this->limit);
        $rs['items'] = $list['items'];
        $rs['page'] = $this->page;
        $rs['limit'] = $this->limit;
        return $list['items'];
    }


    /**
     * 获取在线剧集、动漫、综艺，按时间排序，最新的排最前
     * @desc 获取在线资源模块电影最新更新的数据，支持分页
     * @return int      page    当前第几页
     * @return int      perpage 每页数量
     */
    public function getOnlineList()
    {
        $rs = array();

        $domain = new DomainCURD();
        $list = $domain->getOnlineList($this->page, $this->limit, $this->type);
        $rs['page'] = $this->page;
        $rs['limit'] = $this->limit;
        return $list['items'];
    }

    /**
     * 获取首页最热影片
     */
    public function getHomeHot()
    {
        $domain = new DomainCURD();
        $list = $domain->getHomeHot($this->page, $this->limit, $this->type);
        return $list;
    }


    /**
     * 获取影片分类列表，然后据此查询各个分类的影片列表
     * @desc 获取在线资源模块电影最新更新的数据，支持分页
     * @return int      page    当前第几页
     * @return int      perpage 每页数量
     */
    public function getTypeList()
    {
        $rs = array();
        $domain = new TypeCURD();
        $list = $domain->getTypeList();
        return $list['items'];
    }

    /**
     * 获取推荐搜索词
     * @desc 获取在线资源模块电影最新更新的数据，支持分页
     * @return int      page    当前第几页
     * @return int      perpage 每页数量
     */
    public function getSearchRec()
    {
        $rs = array();
        $domain = new DomainCURD();
        $list = $domain->getOnlineMovList();
        return $list['items'];
    }

    /**
     * 获取剧集、动漫、综艺相关推荐
     * @desc 获取在线资源模块电影最新推荐
     * @return int      page    当前第几页
     * @return int      perpage 每页数量
     * @return string   type    推荐分类的类别
     */
    public function getRecommend()
    {
        $rs = array();

        $domain = new DomainCURD();
        $list = $domain->getOnlineRandomRecommend($this->page, $this->limit, $this->type);
        $rs['page'] = $this->page;
        $rs['limit'] = $this->limit;
        return $list['items'];
    }

    /**
     * @desc 检查版本更新
     */
    public function checkUpdate()
    {
        $update = array(
            "versionCode" => 118,
            "updateMsg" => "1.优化搜索错误提示，\n2.开屏广告、播放广告允许跳过，\n3.修改删除图标。",
            "downloadUrl" => "http://ys.jdzi.vip/app/download/jdzi/android/jdzi.apk",
            "isForce" => true,
            "version" => "1.1.8"
        );
        return $update;
    }

    /**
     * @desc 公告
     */
    public function checkPubish()
    {
        $publish = array(
            "content" => "祝大家新春快乐！",
            "title" => "公告",
            "show" => false
        );
        return $publish;
    }
    
    /**
     * 域名：http://111.67.193.41:6061/
     * 
     * 备份
     * 开屏广告：https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1571490871324&di=db56f6d4ed91343a3fcdf5888d03b011&imgtype=0&src=http%3A%2F%2Fb-ssl.duitang.com%2Fuploads%2Fitem%2F201511%2F13%2F20151113102650_WyAuR.thumb.700_0.jpeg
     * ad_home广告：https://ae01.alicdn.com/kf/Ud551bd98274c4ed28728bbf35661d713U.jpg
     * link：http://qwe.seshewang.com
     * 
     * /

    /**
     * @desc 获取广告配置
     */
    public function getAdConfig()
    {
    	static $url = "http://111.67.193.41:6061/";
    	
        $ad = array(
            "ad_splash" => array(
                "img"=>$url."upload/app/jdzi_kpgg2.png",
                "link"=>"",  //开屏广告 700 x 1056
				"show" => false
            ),
            "ad_home_1" => array(
                "img"=>$url."upload/app/jdzi_homeAd.png",
                "link"=>$url, //推荐页广告 601 x 204
				"show" => false
            ),
            "ad_home_2" => array(
                "img"=>$url."upload/app/jdzi_homeAd.png",
                "link"=>$url, //推荐页广告 601 x 204
				"show" => true
            ),
            "ad_home_3" => array(
                "img"=>$url."upload/app/jdzi_homeAd.png",
                "link"=>$url, //推荐页广告 601 x 204
				"show" => false
            ),
            "ad_home_4" => array(
                "img"=>$url."upload/app/jdzi_homeAd.png",
                "link"=>$url, //推荐页广告 601 x 204
				"show" => true
            ),
            "ad_home_5" => array(
                "img"=>$url."upload/app/jdzi_homeAd.png",
                "link"=>$url, //推荐页广告 601 x 204
				"show" => false
            ),
            "ad_detail" => array(
                "img"=>$url."upload/app/jdzi_homeAd.png",
                "link"=>"", //播放页广告 601 x 204
				"show" => false
            ),
            "ad_player" => array(
                "img"=>$url."upload/app/jdzi_bfy1.png",
                "link"=>"", //播放器广告 750 x 290
				"show" => true
            ),
            "ad_user_center" => array(
                "img"=>$url."upload/app/jdzi_userAd.png",
                "link"=>"", //个人中心广告 601 x 204
				"show" => true
            )
        );
        return $ad;
    }
}

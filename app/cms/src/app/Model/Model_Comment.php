<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

/**
 * Class OnlineMovModel
 * @package App\Model
 */
class Model_Comment extends NotORM {




    protected function getTableName($id) {
        return 'mac_comment';
    }



    public function addNewComment($uid, $vod_id, $vod_comment_pid, $vod_comment_content,$vod_uname)
    {
        $data = array('comment_rid' => $vod_id, 'user_id' => $uid, 'comment_pid' => $vod_comment_pid,
            'comment_name' => $vod_uname, 'comment_time' => time(),
            'comment_content' => $vod_comment_content
        );
        $regResult = $this->getORM()->insert($data);
        return $regResult;
    }

    public function deleteUserComment($uid, $vod_comment_id)
    {
       return $this->getORM()->where('comment_id',$vod_comment_id)->where('user_id',$uid)->delete($vod_comment_id);
    }


    public function getComment($vodId, $page, $limit)
    {


        return $this->getORM()
            ->select('comment_id,comment_pid,comment_rid,user_id,comment_name,comment_time,comment_content,comment_up,comment_down,comment_report')
            ->where('comment_rid',$vodId)
            ->order('comment_id DESC')
            ->limit(($page - 1) * $page, $limit)
            ->fetchAll();
    }


    public function getCommentById($comment_pid)
    {
        return $this->getORM()
            ->select('comment_id,comment_pid,comment_rid,user_id,comment_name,comment_time,comment_content,comment_up,comment_down,comment_report')
            ->where('comment_id',$comment_pid)
            ->fetchOne();
    }

    public function diggComment($vod_comment_id)
    {

        $up =$this->getORM()->select('comment_up')->where('comment_id',$vod_comment_id)->fetchOne();
        $intUp = $up['comment_up'];
        $result = $intUp+1;
        $update = array(
          'comment_up'=>$result
        );
        return $this->getORM()->where('comment_id',$vod_comment_id)->update($update);
    }

    public function canceldiggComment($vod_comment_id)
    {
        $up =$this->getORM()->select('comment_up')->where('comment_id',$vod_comment_id)->fetchOne();
        $intUp = $up['comment_up'];
        if ($intUp<=0){
            return "2";
        }
        $result = $intUp-1;
        $update = array(
            'comment_up'=>$result
        );
        return $this->getORM()->where('comment_id',$vod_comment_id)->update($update);
    }
}

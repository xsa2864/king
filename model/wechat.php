<?php
/**
 * Created by PhpStorm.
 * User: LiaoJR
 * Date: 2015/10/23
 * Time: 13:46
 */

class Wechat_Model extends Model{
    public function __construct($dbSet)
    {
        $table		= $this->setTable();
        parent::__construct($table,$dbSet);
    }

    public function setTable()
    {
        return 'wechat_menu';
    }
    /*
     * 生成菜单
     */
    public function createMenu(){
        $menuList = M('wechat_menu')->where(array('pid'=>0))->orderby(array('sort'=>'desc'))->execute();
        $menu = array();
        foreach($menuList as $value){
            $second_list = M('wechat_menu')->where(array('pid'=>$value->id))->orderby(array('sort'=>'desc'))->execute();
            $menu[$value->id] = array(
                'type'	=> 'click',
                'name'	=> $value->name,
                'key'	=> 'k1'
            );
            if(!empty($second_list)){
                foreach($second_list as $sl){
                    $menu[$value->id]['sub_button'][] = array(
                        'type'	=> 'view',
                        'url'	=> $sl->link,
                        'name'	=> $sl->name,
                    );
                }
            }
        }
        return $menu;
    }

    /*
     * 关键词文本消息回复
     */
    public function keywordReply($keyword)
    {
        $matchRule = C('wechatConfig');
        $where['replyType'] = 2;
        $where['title'] = $keyword;
        $reply = M('wechat_reply')->getOneData($where);
        if ($reply->model == 1) {
            //文本
            $msg['txt'] = $reply->content;
        } elseif ($reply->model == 2) {
            //单图文
            $msg['single'] = array(
                'title' => $reply->title,
                'description' => $reply->content,
                'picUrl' => $reply->coverImg,
                'url' => $reply->contentLink,
            );
        } elseif ($reply->model == 3) {
            //多图文
            $msg['more'] = array(
                'title' => $reply->title,
                'description' => $reply->content,
                'picUrl' => $reply->coverImg,
                'url' => $reply->contentLink,
            );
        }
        return $msg;
    }
    /*
     * 关注时回复
     */
    public function attentionReply(){
        $default_reply = C('wechatConfig');
        $where['replyType'] = 1;
        $where['model'] = $default_reply['repDefault'];
        $reply = M('wechat_reply')->getOneData($where);
        if ($reply->model == 1) {
            //文本
            $msg['txt'] = $reply->content;
        } elseif ($reply->model == 2) {
            //单图文
            $msg['single'] = array(
                'title' => $reply->title,
                'description' => $reply->content,
                'picUrl' => $reply->coverImg,
                'url' => $reply->contentLink,
            );
        } elseif ($reply->model == 3) {
            //多图文
            $msg['more'] = array(
                'title' => $reply->title,
                'description' => $reply->content,
                'picUrl' => $reply->coverImg,
                'url' => $reply->contentLink,
            );
        }
        return $msg;
    }
}
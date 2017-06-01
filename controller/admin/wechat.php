<?php 
/*
 * 微信配置模块
 * 
 */

defined('KING_PATH') or die('访问被拒绝.');
class WeChat_Controller extends Template_Controller
{
    private $wx;
    private $mod;
    public function __construct()
    {
        parent::__construct();
        comm_ext::validUser();
        $this->mod = M('wechat_reply');
	    $this->wx		= weixin::getClass('cc2b2f4');
		$this->wx->setObj($GLOBALS["HTTP_RAW_POST_DATA"]);//如果为响应接收消息事件,必须执行setObj
		$this->wx->setAccessToken('wx408e4d94fab91eeb','cc2b2f4b467534dfdf09b6fac0bf11d8');//如果有自定义菜单,获取用户资料,群发,上传多媒体等操作必须要执行setAccessToken        
        
    }

    public function site(){
        $data['wc']       = C('wechatConfig');
        $post = P();
        if(!empty($post)){
            $config =  array(
                'name'    =>  $post['name'],
                'id'  =>  $post['id'],
                'number'    =>    $post['number'],
                'appId'     =>  $post['appId'],
                'appsecret' =>  $post['appsecret'],
                'email'     =>  $post['email'],
            );
            file_ext::saveConfig($config,'wechatConfig');
            echo '<script>alert("保存成功");window.location.href = "'.$this->input->site('admin/wechat/site').'";</script>';
        }
        $this->template->content	= new View('admin/wechat/site_view',$data);

        $this->template->render();
    }
    /*
     * 自定义菜单
     */
    public function customMenu(){
        $menu = array();
        $req = request::getClass(input::site('wxapi/getMenu'));
        $req->sendRequest();
        $a = $req->getResponseBody();
        $menu1 = json_decode($a);
        foreach($menu1 as $items)
        {
            foreach($items as $item)
            {
                foreach($item as $it)
                {
                    $menu[] = $it;
                }
            }
        }
        $data['menu'] = $menu;
        $data['menustr'] = json_encode($menu);
        $this->template->content	= new View('admin/wechat/customMenu_view',$data);
        $this->template->render();
    }

    /**
     * 保存自定义菜单
     */
    public function saveMenu(){
        $menu = P('menu');
        $req = request::getClass(input::site('wxapi/createMenu'),'post');
        $req->setBody(array('menu'=>$menu));
        $req->sendRequest();
        $a = $req->getResponseBody();
        if($a->errcode==0)
        {
            echo json_encode(array('success'=>0,'msg'=>'保存成功'));
        }
        else
        {
            echo json_encode(array('success'=>1,'msg'=>'保存失败，请稍后再试'));
        }
    }

    /*
     *关注时回复
     */
    public function attention(){
        $att = S('attention');
        if($att<=0)
        {
            $cache = cache::getClass();
            $att = $cache->get('SubscribeAtt');
            if(!$att)
            {
                $att = M('tag')->getFieldData('params',array('name'=>'SubscribeAtt'));
                $cache->set('SubscribeAtt',$att,3600*24);
            }
        }
        $data['att'] = $att;
        $where = 'model = 1 and replyType = 1';
        if($att == 2){ //单图文
            $where = 'model = 2 and replyType = 1';
            $data['info'] = $this->mod->getOneData($where);
            $this->template->content = new View('admin/wechat/attention_view1',$data);
        }elseif($att == 3){ //多图文图文
            $where = 'model = 3 and replyType = 1';
            $info = $this->mod->where($where)->orderby(array('id'=>'asc'))->execute();
            $data['info'] = json_encode($info);
            $this->template->content = new View('admin/wechat/attention_view2',$data);
        }else{
            $data['info'] = $this->mod->getOneData($where);
            $this->template->content = new View('admin/wechat/attention_view',$data);
        }
        $pic = D('picture')->GetData();
        $this->template->tipBoxContent3 = new View('admin/picture/useImg_view', $pic);
        $this->template->render();
    }

    //保存关注回复
    public function saveAttention(){
        $att = P('att');
        if($att==1||$att==2||$att==3)
        {
            $cache = cache::getClass();
            M('tag')->update(array('params'=>$att),array('name'=>'SubscribeAtt'));
            $cache->set('SubscribeAtt',$att,3600*24);
        }
        if($att == 1){
            //文字
            $content = P('contentWechat');
            $data['content'] = $content;
            $data['model'] = 1;
            $data['replyType'] = 1;
            $data['ctime'] = strtotime(date('Y-m-d H:i:s'));
            $where = 'model = 1 and replyType = 1';
        }elseif($att == 2){
            //单图文
            $where = 'model = 2 and replyType = 1';
            $data['title'] = P('title');
            $data['coverImg'] = P('coverImg');
            !is_null(P('displayCover')) ? $data['displayCover'] = P('displayCover') : $data['displayCover'] = 0;
            $data['brief'] = P('brief');
            !is_null(P('isLink')) ? $data['isLink'] = P('isLink') : $data['isLink'] = 0;
            $data['contentLink'] = P('contentLink');
            $data['content'] = P('content');
            $data['model'] = 2;
            $data['replyType'] = 1;
            //$data['replyDefault'] = P('replyDefault');
            $data['modelList'] = 0;
            $data['ctime'] = strtotime(date('Y-m-d H:i:s'));
        }else{
            //多图文
            $data = json_decode(P('menu'));
            //循环验证
            foreach($data as $item)
            {
                if(!$item->title)
                {
                    echo json_encode(array('success'=>1,'msg'=>'缺少标题'));
                    exit;
                }
                if(!$item->coverImg)
                {
                    echo json_encode(array('success'=>1,'msg'=>'缺少图片'));
                    exit;
                }
            }
            foreach($data as $item)
            {
                $headid = $item->id;
                if($item->id==0)
                {
                    $re = M('wechat_reply')->save(array('title'=>$item->title,'coverImg'=>$item->coverImg,'displayCover'=>$item->displayCover,'isLink'=>$item->isLink,'contentLink'=>$item->contentLink,'content'=>$item->content,'model'=>3,'replyType'=>1,'modelList'=>$headid,'ctime'=>time()));
                    if($headid==0)
                    {
                        $headid = $re;
                        M('wechat_reply')->update(array('modelList'=>$headid),array('id'=>$re));
                    }
                }
                else
                {
                    M('wechat_reply')->update(array('title'=>$item->title,'coverImg'=>$item->coverImg,'displayCover'=>$item->displayCover,'isLink'=>$item->isLink,'contentLink'=>$item->contentLink,'content'=>$item->content,'ctime'=>time()),array('id'=>$item->id));
                }
            }
            echo json_encode(array('success'=>0,'msg'=>'保存成功'));
            exit;
        }
        $check = $this->mod->getOneData($where);
        if(empty($check)){
            $result = $this->mod->insert($data);
        }else{
            $result = $this->mod->update($data,$where);
        }
        echo json_encode('保存成功');
    }


    //关键词回复
    public function replyKeyword(){
        //查询所有关键词回复信息，分页
        $total = $this->mod->getAllCount(array('replyType'=>2));
        $page_size = 10;
        $data['pagination'] = pagination::getClass(array(
            'total'		=> $total,
            'perPage'		=> $page_size,
            //   'style'         =>  'pagmall',
            'segment'		=> 'page',
        ));
        $start = ($data['pagination']->currentPage-1)*$page_size;
        $rs = $this->mod->where(array('replyType'=>2))->orderby(array('ctime'=>'desc'))->limit($start,$page_size)->execute();
        //重新组合列表，多图文，单图文，文本分类
        $result = array();
        foreach($rs as $value){
            $content = $value->content;
            if($value->isLink == 1){
                $content = $value->contentLink;
            }
            if($value->model == 1){
                $result[$value->id] = array(
                    'id'    =>  $value->id,
                    'keyword'   =>  $value->keyword,
                    'content'   =>  $content,
                    'mod'   =>  $value->model,
                    'type'  =>  '文本回复'
                );
            }elseif($value->model == 2){
                $result[$value->id] = array(
                    'id'    =>  $value->id,
                    'keyword'   =>  $value->keyword,
                    'title'     =>  $value->title,
                    'coverImg'  =>  $value->coverImg,
                    'brief' =>  $value->brief,
                    'content'   =>  $content,
                    'mod'   =>  $value->model,
                    'type'  =>  '单图文'
                );
            }elseif($value->model == 3){
                if($value->id != $value->modelList) {
                    continue;
                }else {
                    //查询多图文下面所有的信息
                    $modelList = $this->mod->where(array('modelList'=>$value->id))->execute();
                    foreach($modelList as $mv) {
                        $result[$value->id]['modelList'][] = array(
                            'id' => $mv->id,
                            'keyword' => $mv->keyword,
                            'title' => $mv->title,
                            'coverImg' => $mv->coverImg,
                            'manId' =>  $value->id,
                            'type' => '多图文'
                        );
                    }
                }
            }
        }
        $data['result'] = $result;
        $this->template->content	= new View('admin/wechat/keyword_view',$data);
        $this->template->render();
    }
    //新增文本回复
    public function addTextKeyword(){

        $this->template->content	= new View('admin/wechat/keyword_text_view');
        $this->template->render();
    }
    //新增单图文回复
    public function addSingleImgKeyword(){
        $pic = D('picture')->GetData();
        $this->template->tipBoxContent3 = new View('admin/picture/useImg_view', $pic);
        $this->template->content	= new View('admin/wechat/keyword_single_img_view');
        $this->template->render();
    }
    //新增多图文回复
    public function addMoreImgKeyword(){
        list($id) = $this->input->getArgs();
        $info = $this->mod->where(array('modelList'=>$id,'replyType'=>2,'model'=>3))->orderby(array('id'=>'asc'))->execute();
        if(!empty($info)) {
            $data['info'] = $info;
        }
        $pic = D('picture')->GetData();
        $this->template->tipBoxContent3 = new View('admin/picture/useImg_view', $pic);
        $this->template->content	= new View('admin/wechat/keyword_more_img_view',$data);
        $this->template->render();
    }

    //保存多图文回复
    public function saveMoreImgKeyword(){
        if(!P()){
            output_ext::jsHref('请输入内容',$this->input->site('admin/wechat/replyKeyword'));
        }
        //id  判断是否修改
        $id = P('id');
        $title = P('hidtitle');
        $keyword = P('keyword');
        $coverImg = P('hidcoverImg');
        $displayCover = P('hiddisplayCover');
        $isLink = P('hidisLink');
        $contentLink = P('hidcontentLink');
        $content = P('hidcontent');
        $replyType = P('replyType');
        if(intval($id) > 0){
            $this->mod->delete(array('modelList'=>$id,'id !='=>$id));
        }
        $url = 'admin/wechat/replyKeyword';
        if($replyType == 1){
            $url = 'admin/wechat/attention/2';
        }
        foreach($title as $key => $value){
            $data['title'] = $title[$key];
            $data['coverImg'] = $coverImg[$key];
            $data['displayCover'] = $displayCover[$key];
            $data['isLink'] = $isLink[$key];
            $data['contentLink'] = $contentLink[$key];
            $data['content'] = $content[$key];
            $data['model'] = 3;
            $data['replyType'] = $replyType;
            $data['keyword'] = $keyword;
            $data['matchRule'] = 1;
            $data['ctime'] = strtotime(date('Y-m-d H:i:s'));
            //第一个
            if($key == 0){
                $data['modelList'] = 0;
                if(intval($id) > 0){
                    $data['modelList'] = $id;
                    $this->mod->update($data,array('id'=>$id));
                }else {
                    $firstId = $this->mod->insert($data);
                    if (!$firstId) {
                        output_ext::jsHref('保存失败', $this->input->site($url));
                        break;
                    }
                    $this->mod->update(array('modelList' => $firstId), array('id' => $firstId));
                }
            }else{
                if(intval($id) > 0){
                    $data['modelList'] = $id;
                }else {
                    $data['modelList'] = $firstId;
                }
                $this->mod->insert($data);
            }
        }
        output_ext::jsHref('保存成功',$this->input->site($url));
    }

    //保存单图文回复
    public function saveSingleImgKeyword(){
        if(!P()){
            output_ext::jsHref('请输入内容',$this->input->site('admin/wechat/replyKeyword'));
        }
        $data['title'] = P('title');
        $data['coverImg'] = P('coverImg');
        !is_null(P('displayCover')) ? $data['displayCover'] = P('displayCover') : $data['displayCover'] = 0;
        $data['brief'] = P('brief');
        !is_null(P('isLink')) ? $data['isLink'] = P('isLink') : $data['isLink'] = 0;
        $data['contentLink'] = P('contentLink');
        $data['content'] = P('content');
        $data['model'] = 2;
        $data['replyType'] = 2;
        //$data['replyDefault'] = P('replyDefault');
        $data['modelList'] = 0;
        $data['keyword'] = P('keyword');
        $data['ctime'] = strtotime(date('Y-m-d H:i:s'));
        $id = P('id');
        if(intval($id) > 0){
            $this->mod->update($data,array('id'=>$id));
        }else{
            $this->mod->insert($data);
        }
        output_ext::jsHref('保存成功',$this->input->site('admin/wechat/replyKeyword'));
    }

    //保存文本文回复
    public function saveTxtKeyword(){
        $id = P('id');
        $keyword = P('keyword');
        $matchRule = P('matchRule');
        $content = P('content');
        is_null($matchRule) ? $matchRule = 1 : $matchRule = 0;
        $data = array(
            'keyword'   =>  $keyword,
            'matchRule' =>  $matchRule,
            'content'   =>  $content,
            'model'     =>  1,
            'replyType' =>  2,
            'ctime'     =>  strtotime(date('Y-m-d H:i:s'))
        );
        if(intval($id) > 0){
            $this->mod->update($data,array('id'=>$id));
        }else{
            $this->mod->insert($data);
        }
        output_ext::jsHref('保存成功',$this->input->site('admin/wechat/replyKeyword'));
    }

    //删除回复消息
    public function deleteReply(){
        list($id) = $this->input->getArgs();
        //验证是否可以删除
        $check = $this->mod->getOneData(array('id'=>$id,'replyType'=>2));
        if(empty($check)){
            output_ext::jsHref('信息不存在或信息有误',$this->input->site('admin/wechat/replyKeyword'));
        }
        if($check->model == 3){
            $this->mod->delete(array('modelList'=>$id));
        }else{
            $this->mod->delete(array('id'=>$id));
        }
        output_ext::jsHref('删除成功',$this->input->site('admin/wechat/replyKeyword'));
    }
    
}
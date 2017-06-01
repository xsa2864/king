<?php defined('KING_PATH') or die('访问被拒绝.');
class Express_Controller extends Template_Controller{
    private $mod;
    public function __construct()
    {
        parent::__construct();
        comm_ext::validUser();   
        $this->mod  = M('express');
        $this->account_id = accountInfo_ext::accountId(); 
    }
    // 快递首页
    public function index()
    {
        $data['shipping'] = $this->mod->orderby(array('addtime'=> 'desc'))->execute();
        $this->template->content = new View("admin/express/ship_view", $data);
        $this->template->render();
    }

   
    public function config(){
        $sid = $this->input->segment('config');
        if ( $sid > 0 ){
            $update   = array(
                      "enabled" => 1   
                );
            $rs       = $this->mod->update($update," enabled = 0 and id =".$sid);
        }	 
        input::redirect('admin/express');
    }

    public function area(){
        $post                        = $this->input->post();
        $data                        = array();
        $sid                         = $this->input->segment('area');
        if ($post){
            $data['note']             = $this->save($post,$sid);
        } 
        if ($sid > 0){
            $data['shipping']        = $this->mod->getOneData("id = ".$sid);
            $result                  = M("express_area")->where(array('expressType' => 2, 'expressId' => $sid))->execute();
            $cityid       = array();
            if ($result){
                foreach ($result as $value){
                    $configure = unserialize($value->configure);
                    $cityid    = array_merge($cityid, $configure['cityid']);
                    $normal[]  = $value;
                }
                $data['normal']  = $normal;
            }
            $provincial      = $this->getcity();
            $data['city']    = $provincial;
            $data['city_s']  = $cityid;
        }
        $this->template->content = new View("admin/express/area_set", $data);
        $this->template->render();
    }

    public function save(){
        $id   = P('id','');
        $data['name'] = P('name');
        $data['code'] = P('code');
        $data['account_id'] = $this->account_id;
        $re_msg['success'] = 0;
        $re_msg['msg']     = "保存失败";
        $rs = '';
        if($id == ''){          
          if(!empty($data['name'])){
            $rs = M('express')->insert($data);            
          }        
        }else{
          unset($data['account_id']);
          $rs = M('express')->update($data,"id=$id and account_id=".$this->account_id);
        }
        if($rs){
          $re_msg['success'] = 1;
          $re_msg['msg']     = "保存成功";
        }
        echo json_encode($re_msg);        
    }
    // 删除快递信息
    public function del(){
        $id = P('id');
        $re_msg['success'] = 0;
        $re_msg['msg']     = "删除失败";
        $rs = M('express')->delete("account_id=".$this->account_id." and id=$id");
        if ($rs){ 
            $re_msg['success'] = 1;
            $re_msg['msg']     = "删除成功";
        }
        echo json_encode($re_msg);
    }

    public function getcity(){
        $provincial =  M("provincial")->execute();
        foreach($provincial as $value){  
            $city[$value->id]      = array(
                 "name" =>$value->name,
                 "wm"   =>$value->wm
            );
        }
        return $city;
    }
    
    public function uninstall(){
        $sid = $this->input->segment('uninstall');
        if ( $sid > 0 ){
            $update   = array(
                      "enabled" => 0   
                );
            $rs       = $this->mod->update($update," enabled = 1 and id =".$sid);
        }	 
        input::redirect('admin/express/');

    }

    public function install()
    {
        $post            = $this->input->post();
        $free            = array(
                        'name'		    => "免费配送",
                        'brief'		    => "商城全国免费配送模式,默认首选,启用则放弃所有配送规则",
                        'expressType'         => 0,
                        'orderNum'		=> 100

        );
        $result   = $this->mod->getOneData("expressType = 0");
        if (!$result){
            $this->mod->save($free);
        }

        $free            = array(
                        'name'		    => "满额免运费",
                        'brief'		    => "商城全国启用满金额全国免运费模式",
                        'expressType'         => 1,
                        'orderNum'		=> 90

        );
        $result   = $this->mod->getOneData("expressType = 1");
        if (!$result){
            $this->mod->save($free);
        }
        if (!empty($post["shipping_name"]) && !empty($post["shipping_desc"]) && !empty($post["shipping_order"])){
            $insert		= array(
                      'name'		    => $post['shipping_name'],
                      'brief'		    => $post['shipping_desc'],
	        'expressType'         => 2,
                      'orderNum'		=> $post['shipping_order']
            );
            $return		= $this->mod->save($insert);
        }
        input::redirect('admin/express');
    }	
}
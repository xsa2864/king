<?php defined('KING_PATH') or die('访问被拒绝.');
    class Comment_Controller extends Template_Controller
    {
        private $mod;
        public function __construct()
        {
            parent::__construct();
            comm_ext::validUser();
            $this->mod    = M('comment');
        }
        
        public function index()
        {
            $username = G('username');
            $opinion = G('opinion');
            $start_time = G('start_time');
            $end_time = G('end_time');

            //搜索设置
            $where = array();
            if($username != ''){
                //查询出用户id
                $userId = M('member')->select("id")->where("realName like '%".E($username)."%' or mobile like '%".E($username)."%'")->execute();
                foreach($userId as $ui){
                    $inUser[] = $ui->id;
                }
                if(isset($inUser)){$where['mid in'] = $inUser;}
            }
            if($start_time != ''){
                $order_where = 'ctime >= '.strtotime($start_time).'';
                if($end_time != ''){
                    $order_where = 'ctime between '.strtotime($start_time).' and '.strtotime($end_time).'';
                }
                $order_list = M('orderinfo')->where($order_where)->select('sn')->execute();
            }
            $total		= $this->mod->getAllCount($where);
            $data['pagination'] = pagination::getClass(array(
                'total'			=> $total,
                'perPage'		=> 10,
                'segment'		=> 'page',
            ));
            $start			= ($data['pagination']->currentPage-1)*10;
            $rs				= $this->mod->where($where)->limit($start,10)->execute();
            $rs2        = array();
            foreach ($rs as $row)
            {
                $row2                 = $this->mod->getOneData(array('id'=>$row->mid),'','member');
                $goods = $this->mod->getOneData(array('id'=>$row->itemId),'','item');
                $row->realName        = $row2->realName;
                $row->mobile          = $row2->mobile;
                //$row->reply           = $row->reply ? '是' :'否';
                $row->reply == '' ? '暂无回复' : $row->reply;
                $row->ctime           = date('Y-m-d H:i:s',$row->ctime);
                $row->title = $goods->title;
                $row->pics = output_ext::getCoverImg($goods->pics);
                $rs2[]                = $row;
            }
			$data['tree']	= $rs;
			$this->template->content	= new View('admin/comment/index_view', $data);
			$this->template->render();       
        }
        
        public function edit()
        {
            list($id)	        = $this->input->getArgs();
            $row                = $this->mod->getOneData("id='$id'");
            $row2               = $this->mod->getOneData(array('id'=>$row->mid),'','member');
            $row->realName      = $row2->realName;
            $row->ctime         = date('Y-m-d H:i:s',$row->ctime);
            $data['row']        = $row;
            $this->template->content = new View('admin/comment/add_view',$data);
            $this->template->render();
        }

        public function update()
        {
            list($id)	        = $this->input->getArgs();
            if ($id>0)
            {
                $post            = $this->input->post();
                $upd    = array(
                        'reply'     => $this->input->post('content')
                );
                $return        = $this->mod->update($upd,array('id'=>$id));
                if ($return)
                {
                    echo json_encode(array('msg'=>'更新评论成功','success'=>1));
                }
                else
                {
                    echo json_encode(array('msg'=>'更新评论失败','success'=>0));
                }
            }
            else
            {
                echo json_encode(array('msg'=>'参数错误','success'=>0));
            }
        }
        
        public function delete()
        {
            list($id)	        = $this->input->getArgs();
            if ($id>0)
            {
                $return     = $this->mod->delete(array('id'=>$id));
            }
            echo "<script>location.href='/admin/comment/index'</script>";
        }                  
    }


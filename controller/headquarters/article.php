<?php defined('KING_PATH') or die('访问被拒绝.');
    class Article_Controller extends Template_Controller
    {
        private $mod;
        public function __construct()
        {
            parent::__construct();
            hcomm_ext::validUser();
            $this->mod      = M('article');
            $this->did      = 9;//文章分类的字典 
        }
        
        public function index()
        {			
			$total		= $this->mod->getAllCount();
			$data['pagination'] = pagination::getClass(array(
				'total'			=> $total,
				'perPage'		=> 10
				));
			$start			= ($data['pagination']->currentPage-1)*10;
			$rs				= $this->mod->limit($start,10)->execute();
			foreach ($rs as $value)
			{
				$value->dict	= $this->mod->getFieldData('name',array('id'=>$value->dictId),'dict_item');
			}			
			$data['tree']	= $rs;
			$this->template->content    = new View('admin/article/index_view',$data);
            $this->template->render();        
        }
		
		public function addDictItem()
		{
            $id         = 9;
			$name		= $this->mod->getFieldData('name',array('id'=>$id),'dict');
			$total		= $this->mod->getAllCount(array('did'=>$id),'dict_item');
			$data['pagination'] = pagination::getClass(array(
				'total'			=> $total,
				'perPage'		=> 10
				));
			$start				= ($data['pagination']->currentPage-1)*10;
			$rs					= $this->mod->from('dict_item')->where(array('did'=>$id))->limit($start,10)->execute();
			$data['tree']		= $rs;
			$data['did']		= $id;
			$data['name']		= $name;
			$data['article']	= true;
			$this->template->content	= new View('admin/dict/show_item_view',$data);
			$this->template->render();
		}
        
        public function add()
        {
			$id				= 9;
			$rs				= $this->mod->from('dict_item')->where(array('did'=>$id))->limit($start,10)->execute();
			$data['list']	= $rs;
			$this->template->content = new View('admin/article/add_view',$data);
            $this->template->render();
        }
        
        public function edit()
        {
			list($id)           = $this->input->getArgs();
			$did                = 9;
			$rs                 = $this->mod->from('dict_item')->where(array('did'=>$did))->limit($start,10)->execute();
			$data['list']       = $rs;
            $data['row']        = $this->mod->getOneData("id='$id'");
			$this->template->content = new View('admin/article/add_view',$data);
            $this->template->render();
        }
        
        public function get()
        {
            if ($this->input->get('total'))
            {
                $rs            = $this->mod->execute();
                echo json_encode($rs);
            }
            else 
            {
                $total        = $this->mod->getAllCount();
                $page        = $this->input->post('page');
                $size        = $this->input->post('rows');
                $start        = ($page-1)*$size;
                $rs            = $this->mod->limit($start,$size)->execute();
                $rs2        = array();
                foreach ($rs as $row)
                {
                    $row->dict            = $this->mod->getFieldData('name',array('id'=>$row->dictId),'dict_item');
                    $rs2[]                = $row;
                }
                echo json_encode(array('total'=>$total,'rows'=>$rs2));                
            }        
        }
        
        public function save()
        {
            $post           = $this->input->post();
            $content        = $post['content'];
            $title          = $post['title'];
			if ($title && $content)
            {
                $count        = $this->mod->getAllCount(array('title'=>$title));
                if ($count >0)
                {
                    echo json_encode(array('msg'=>'该文章已存在','success'=>0));
                }
                else
                {
                    $insert        = array(
                        'dictId'    => $post['dictId'],
                        'title'     => $title,
                        'content'   => $content,
                        'ctime'     => time()
                    );
                    $return        = $this->mod->save($insert);
                    if ($return >0)
                    {
						echo json_encode(array('msg'=>'保存文章成功','success'=>1));
                    }
                    else
                       {
                        echo json_encode(array('msg'=>'保存文章失败','success'=>0));
                    }
                }
            }
            else
                echo json_encode(array('msg'=>'参数错误','success'=>0));
        }
        
        public function update()
        {
			list($id)       = $this->input->getArgs();
            $post            = $this->input->post();
            $content        = $post['content'];
            $title          = $post['title'];
            if ($id>0)
            {				
				$count        = $this->mod->getAllCount(array('title'=>$title, 'id!='=>$id));
				if ($count >0)
				{
					echo json_encode(array('msg'=>'该文章已存在','success'=>0));
				}
				else
				{					
					$upd    = array(
						'dictId'    => $post['dictId'],
						'title'     => $title,
						'content'   => $content
						);
					$return        = $this->mod->update($upd,array('id'=>$id));
					if ($return)
					{
						echo json_encode(array('msg'=>'更新文章成功','success'=>1));
					}
					else
					{
						echo json_encode(array('msg'=>'更新文章失败','success'=>0));
					}
				}
            }
            else
            {
                echo json_encode(array('msg'=>'参数错误','success'=>0));
            }
        }
        
        public function delete()
		{
			list($id)	= $this->input->getArgs();
            if ($id>0)
            {
                $return     = $this->mod->delete(array('id'=>$id));
			}
			echo "<script>location.href='/admin/article/index'</script>";
        }
    }
?>
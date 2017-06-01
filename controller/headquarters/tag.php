<?php defined('KING_PATH') or die('访问被拒绝.');
    class Tag_Controller extends Template_Controller
    {
        private $mod;
        public function __construct()
        {
            parent::__construct();
          	hcomm_ext::validUser();
            $this->mod    = M('category');
        }
        
        public function showTag()
        {
        	$params		= explode('_',$this->input->segment('showTag'));
        	$func		= 'get'.$params[1].'Tag';
        	$this->$func($params[0],$params[2]);
        }
        
        public function saveCate()
        {
        	$post	= $this->input->post();
        	if ($post['tagName'] && $post['chk'])
        	{
        		$rs		= M('tag')->replace(array('name'=>$post['tagName'],'params'=>serialize($post['chk'])));
        		input::redirect('admin/home/index');
        	}
        } 
        
        public function saveImg()
        {
        	$post	= $this->input->post();
        	$files	= array();
        	foreach ($post['files'] as $key=>$value)
        	{
        		$files[$value]	= $post['urls'][$key];
        	}
        	$rs		= M('tag')->replace(array('name'=>$post['tagName'],'params'=>serialize($files)));
        	input::redirect('admin/home/index');
        }
        
        public function saveProduct()
        {
        	$post	= $this->input->post();
        	$v		= array();
        	if ($post['chk'])
        	{
        		foreach ($post['chk'] as $id)
        		{
        			$row	= M('item')->getOneData(array('id'=>$id),'id,pics,title,prePrice,price');	
        			$row->pics	= output_ext::getCoverImg($row->pics,'265x280');
        			$v[]	= $row;
        		}
        	}
        	$rs		= M('tag')->replace(array('name'=>$post['tagName'],'params'=>serialize($v)));
        	input::redirect('admin/home/index');
        }
        public function saveNav(){
            $post	= $this->input->post();
            M('special')->update(array('isNav'=>0));
            foreach($post['chk'] as $v){
                M('special')->update(array('isNav'=>1,'order'=>$post['order'.$v.'']),array('id'=>$v));
            }
            input::redirect('admin/home/index');
        }
        
        public function getCateTag($name,$id)
        {
        	$data['cates']		= $this->mod->where(array('pid'=>$id))->execute();
        	$data['tagName']	= $name;
        	$data['tagValue']	= M('tag')->getFieldData('params',array('name'=>$name));
        	$this->template->content	= new View('admin/tag/cate_view',$data);
        	$this->template->render();
        }
        
        public function getImgTag($name)
        {
        	$time				= time();
        	$data['validKey']	= md5($GLOBALS['config']['md5Key'].$time);
        	$data['validTime']	= $time;        	
        	$data['tagName']	= $name;
        	$data['tagValue']	= M('tag')->getFieldData('params',array('name'=>$name));
        	$this->template->content	= new View('admin/tag/slide_view',$data);
        	$this->template->render();      
        }
        
        public function getProductTag($name)
        {     	
        	$data['cates']	= $this->mod->where(array('pid'=>0))->execute();
        	$limit	= 10;
        	$wh		= array();
        	$get	= $this->input->get();
        	if ($get['title'])
        	{
        		$wh['title like']	= '%'.$get['title'].'%';	
        	}
        	
        	if($get['cateId'])
        	{
        		$wh['parent']	= $get['cateId'];
        	}
        	$data['tagName']	= $name;
        	$data['tagValue']	= M('tag')->getFieldData('params',array('name'=>$name));
        	$total		= $this->mod->getAllCount($wh,'item');
        	$data['pagination'] = pagination::getClass(array(
        			'segment'		=> 'getProductTag',
        			'total'    		=> $total,//总条数
        			'perPage' 		=> $limit//每页显示的条数
        	));
        	$start		= $limit*($data['pagination']->currentPage-1);
        	$data['products']	= M('item')->where($wh)->limit($start,$limit)->execute();
        	
        	$this->template->content	= new View('admin/tag/product_view',$data);
        	$this->template->render();  
        }
        
        public function getRecoTag($name)
        {
        	$data['tagName']	= $name;
        	$data['tagValue']	= M('tag')->getFieldData('params',array('name'=>$name));
        	$this->template->content	= new View('admin/tag/reco_view',$data);
        	$this->template->render();  
        }

        public function getNavTag($name){
            $rs = M('special')->select('id,name,page,order,isNav')->where(array('isSpecial' => 1))->orderby(array('order' => 'asc'))->execute();
            $data['rs'] = $rs;
            $this->template->content	= new View('admin/tag/nav_view',$data);
            $this->template->render();
        }
        
    }
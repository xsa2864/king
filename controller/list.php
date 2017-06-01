<?php defined('KING_PATH') or die('访问被拒绝.');
	class List_Controller extends Web_Controller
	{
		private $mod;
	    public function __construct()
	    {
	        parent::__construct();
	    }	    
	    
	    public function index()
	    {
	    	$mod			= M('category');
	        list($id)		= input::getArgs(); 
	        $ids            = explode('-',$id);
	        $count          = count($ids);
	        $cate			= new Cate_Model;
	        $data['cate']		= $cate->getCate($ids[0]);
	        $cid	= $ids[2];
	        $row	= $mod->getOneData(array('id'=>$cid),'did,ad');
	        if ($ids[1]>0)
	        {
	        
	        }
	        if ($ids[2]>0)
	        {
	        	$dict	= new Dict_Model;
	        	$data['rs']		= $dict->getDict($row->did);
	        	if ($row->ad>0)
	        	{
	        		$ad		= new Advert_Model;
	        		$data['rs2']	= $ad->getPro($row->ad);
	        	}
	        }
	        $mod		= M('item');
	        $data['count']		= $mod->getAllCount(array('cateId'=>$cid));
			$data['rs3']		= $mod->where(array('cateId'=>$cid))->execute();	        
	        $this->template->content       = new View('list/index_view',$data);
	        $this->template->render();
	    }
	}
<?php defined('KING_PATH') or die('访问被拒绝.');
class Special_Controller extends Template_Controller
{
    private $mod;
    public function __construct()
    {
        parent::__construct();
        comm_ext::validUser();
        $this->mod      = M('special');
        
    }

    public function index()
    {
        $total		= $this->mod->getAllCount();
        $data['pagination'] = pagination::getClass(array(
            'total'			=> $total,
            'perPage'		=> 10
        ));
        $start			= ($data['pagination']->currentPage-1)*10;    
        $rs				= $this->mod->orderby(array("Id"=>"desc"))->limit($start,10)->execute();
        $data['list']	= $rs;
        $this->template->content    = new View('admin/special/list_view',$data);
        $this->template->render();
    }

    

    public function add()
    {          
        $this->template->content = new View('admin/special/add_view',$data);
        $this->template->render();
    }

    public function edit()
    {
        $id                 = $this->input->segment('edit');      
        $data['row']        = $this->mod->getOneData("id='$id'");
        $this->template->content = new View('admin/special/add_view',$data);
        $this->template->render();
    }
    
    
  

 public function getProduct()
        {     	
            $newmodel = M('category');
        	$data['cates']	=$newmodel->where(array('pid'=>0))->execute();
        	$cateId		= $this->input->get('cateId');
        	$limit	= 5;
        	$wh		= array();        	
        	if ($cateId)
        	{
        		$wh		= array('cateId'=>$cateId);
        	}
        	
        	$total		= $this->mod->getAllCount($wh,'item');
        	$data['pagination'] = pagination::getClass(array(
        			'segment'		=> 'getProduct',
        			'total'    		=> $total,//总条数
        			'perPage' 		=> $limit,//每页显示的条数
        	));
        	$start		= $limit*($data['pagination']->currentPage-1);
        	$data['products']	= M('item')->where($wh)->limit($start,$limit)->execute();
        	
        	$this->template->content	= new View('admin/special/product_view',$data);
        	$this->template->render();  
        }

    public function save()
    {
        $post            = $this->input->post();
          
        if ($post['itemId'] && $post['beginTime'] && $post["endTime"])
        {
            $count        = $this->mod->getAllCount(array('itemid'=>$post['itemId']));
            if ($count >0)
            {
                echo json_encode(array('msg'=>'该物品特卖已存在','success'=>0));
            }
            else
            {
                $images = $this->upload();
                $btime =strtotime($post["beginTime"]);
                $etime =strtotime($post["endTime"]);
              
               // die('<br/>nfdsfdsfds');
                
                $insert        = array(
                    'itemid'     => $post['itemId'],
                    'title'      => $post['itemTitle'],
                    'beginTime'  => $btime,
                    'endTime'    => $etime,
                    'thumb'      => $images[0],
                    'createTime'          => time()
                );
                $return        = $this->mod->save($insert);
                if ($return >0)
                {
                    echo json_encode(array('msg'=>'','success'=>1));
                }
                else
                {
                    echo json_encode(array('msg'=>'保存失败','success'=>0));
                }
            }
        }
        else
        {
            echo json_encode(array('msg'=>'参数错误','success'=>0));
            
        }
    }

    public function update()
    {
        $id        = $this->input->segment('update');
        if ($id>0)
        {            
            
            $post            = $this->input->post();
            $images = $this->upload();
            $picurl = $post["thumb"];
            if(sizeof($images)>0)
            {
                $picurl=$images[0];                
            }
            
            $btime =strtotime($post["beginTime"]);
            $etime =strtotime($post["endTime"]);            
            
            $upd    = array(
                'itemId'    => $post['itemId'],
                'title'      => $post['itemTitle'],
                'beginTime'     => $btime,
                'endTime'   => $etime,
                'thumb'=> $picurl                
            );
            $return        = $this->mod->update($upd,array('id'=>$id));
            if ($return)
            {
                echo json_encode(array('msg'=>'','success'=>1));
            }
            else
            {
                echo json_encode(array('msg'=>'保存失败','success'=>0));
            }
        }
        else
        {
            echo json_encode(array('msg'=>'参数错误','success'=>0));
        }
    }
    
    
    
    
    public function upload()
    {
        $upload		= upload::getClass();
        foreach ($_FILES as $key => $file){
            $dir		= 'upload/'.date('Ym/d');
    
            $return 	= $upload->save(1,$key,'',$dir);
            if ($return)
            {
                $pice[] = $return;
            }
        }
        if (is_array($pice) && sizeof($pice) > 0){
            return $pice;
        }
    }
    
    

    

    public function delete()
    {
        list($id)	= $this->input->getArgs();
        
        if ($id>0)
        {
            $return     = $this->mod->delete(array('id'=>$id));
        }
        input::redirect('admin/special/index');
    }
}
?>
<?php defined('KING_PATH') or die('访问被拒绝.');
    class Swfupd_Controller extends Controller
    {    	
    	public function __construct()
    	{
    		parent::__construct();
    	}    	
    	
        public function saveImg()
        {
        	if ($this->input->post('validKey') && $this->input->post('validTime'))
        	{
        		if (time() -$this->input->post('validTime')<1440)//24分钟内必须发送
        		{
        			if ($this->input->post('validKey') == md5($GLOBALS['config']['md5Key'].$this->input->post("validTime")))
        			{
        				$extend     = '';
        				$upload		= upload::getClass();
        				$dir		= 'upload/'.date('Ym/d');
        				$fileName 	= $upload->save(1,'userFile','',$dir);
        				
        				if ($fileName)
        				{
        					if ($this->input->get('textBox'))
        						$extend   = ',text';
        					echo 'FILEID:'.$this->getId().','.$_POST['Filename'].','.$fileName.$extend;
        				}
        			}
        			else
        			{
        				echo '验证出错';
        				exit;
        			}
        		}
        		else
        		{
        			echo '检验出错';
        			exit;
        		}
        	}        	
        }
    	
        public function saveUploadImg()
        {
            $upload		= upload::getClass();
            $imgFile = $this->input->post('file');
            if(isset($_FILES['file']['name']))
            {
                $dir		= 'upload/'.date('Ym/d');
                $_FILES = 
                $return =  $upload->save(1,'file','',$dir);
                if($return==false)
                {
                    echo json_encode(array('success'=>0,'message'=>'上传失败'));
                }
                else
                {
                    echo json_encode(array('success'=>1,'url'=>$return));
                }
                exit;
            }
            echo json_encode(array('success'=>0,'message'=>'上传错误'));        	    	
        }
        
        public function delUpload()
        {
        	$filePath		= $this->input->post('filePath');
        	if ($filePath)
        	{
        		$return 	= output_ext::delImg($filePath);
        		if ($return >0)
        		{
        			echo json_encode(array('msg'=>'已删除上传的图片','success'=>1));
        		}
        		else
        		{
        			echo json_encode(array('msg'=>'删除图片失败','success'=>0));
        		}
        	}
        	else
        		echo json_encode(array('msg'=>'参数错误','success'=>0));
        	exit;
        }        
        
        private function getId()
        {
        	$id	= substr(time(),5).rand(10000,99999);
        	return $id;
        }   
    }
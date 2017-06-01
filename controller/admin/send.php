<?php defined('KING_PATH') or die('访问被拒绝.');
	class Send_Controller extends Template_Controller 
	{
		private $mod;
		public function __construct()
		{
			parent::__construct();
			$this->mod		= M('outbox');	
		}
		
		public function index()
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
						$fileName 	= $upload->save('','userFile','',$dir);
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
		
		private function getId()
		{
			$id	= substr(time(),5).rand(10000,99999);
			return $id;
		}
		
		public function imageThumb()
		{
			$files		= explode('.',$this->input->get('s'));
		    $tmpName	= explode('_',$files[0]);
		    preg_match('/\_(\d+)x(\d+)/', $files[0],$matches);
		    $width		= $matches[1];
		    $height		= $matches[2];
		    $tmpName	= explode('_'.$width.'x',$files[0]);
		    $realImg	= $_SERVER['DOCUMENT_ROOT'].'/'.$tmpName[0].'.'.$files[1];
	        $image		= image::getClass($realImg);
	        $resizeImg	= $_SERVER['DOCUMENT_ROOT'].'/'.$files[0].'.'.$files[1];

		    $status		= $image->resize($resizeImg, $width, $height);
		    if ($status)
		    {
		        header('content-type:image/'.$files[1]);
		        echo file_get_contents($resizeImg);
		    }
		}

		public function download()//必须加上是否属于本人的文件的判断
		{
			comm_ext::validUser();
			$file	= $this->input->get('file');
			comm_ext::saveToLog(66, $_SESSION['userName'].'下载了文件:'.comm_ext::enCrypt(basename($file)));
			file_ext::fileDownload($file);
		}
	}
<?php defined('KING_PATH') or die('访问被拒绝.');
	class Place_Controller extends Controller
	{
		public $template;
		public $folder	= 'mobile';
		public $seo;
        public $data;
		public function __construct($setfolder='')
		{
            if($setfolder)
            {
                $this->folder = $setfolder;
            }
			parent::__construct();
            session_start();
            $this->data['folder'] = $this->folder;
			$this->template = new View('place_view');
            $this->seo = C('siteConfig');
			if (isset($this->seo))
			{
                $this->data['web_site'] = $this->seo;
				$this->template->header	= $this->header();
			}
			$this->template->footer	= $this->footer();
		}
		
		public function setTitle($seo,$viewName='')
		{
			$this->seo	= $seo;
            $this->data['web_site'] = $this->seo;
			$this->template->header	= $this->header($viewName);
		}
		
		public function header($viewName='')
		{
			$this->data['title']		= $this->seo ? $this->seo :'酒泉网';
			//$data['folder']		= $this->folder;
			if (!$viewName)
			{
				$viewName	= 'header_main_view';
			}
			return new View($this->folder.'/comm/'.$viewName,$this->data);
		}

		public function footer($viewName='')
		{
			//$data['folder']		= $this->folder;
			$siteConfig		= C('siteConfig');
			$this->data['qq']		= $siteConfig['qq'];
			$this->data['icp']		= $siteConfig['icp'];
			if (!$viewName)
			{
				$viewName	= 'footer_index_view';
			}
			return new View($this->folder.'/comm/'.$viewName,$this->data);
		}
		
	} 

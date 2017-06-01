<?php defined('KING_PATH') or die('访问被拒绝.');
	class Captcha_Controller extends Controller 
	{
		public function __call($method, $args)
		{
			$capt	= captcha::getClass($this->input->segment(2));
			$capt->setWorkNumber(4);
            ob_clean();
			$capt->render(false);
		}
	}
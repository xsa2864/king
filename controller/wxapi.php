<?php defined('KING_PATH') or die('访问被拒绝.');
	class Wxapi_Controller extends Controller
	{
		private $wx;
		public function __construct()
		{
			parent::__construct();
			$this->wx		= weixin::getClass('aijq');
			$this->wx->setObj($GLOBALS["HTTP_RAW_POST_DATA"]);//如果为响应接收消息事件,必须执行setObj
			$this->wx->setAccessToken('wx9f8f551db3d40d59','e78b2ac32c57c5cca593b30987116e19');//如果有自定义菜单,获取用户资料,群发,上传多媒体等操作必须要执行setAccessToken
		}
		
		/**
		 * 微信账号验证，回复测试
		 */
		public function index()
		{
			$echoStr 	= G('echostr');
            if (!empty($echoStr))//如果是账号验证，执行checkSignature，否则响应接收的消息
            {
                if ($this->wx->checkSignature(G('signature'),G('timestamp'),G('nonce')))
                {
                    ob_clean();
                    echo $echoStr;
                }
                else
                {
                }
            }
            else
            {
                $this->wx->responseFunc($this);
            }
		}

		/**********************************************以下为测试例子**********************************************************************************
		 * 响应类的事件的名字是固定的，名字固定为set加上MsgType值比如setText,setImage，为了统一命名MsgType为Event时，名称为set加上Event值例如setSubscribe,setClick,
		*************************************************END**************************************************************************************/
		
		/**
		 * 创建自定义菜单，菜单文字长度等有相应的规定，请参考官方文档
		 */
		public function createMenu()
		{
			$menuArray['button']	= P('menu');
			$return	= $this->wx->createMenu($menuArray);	
			print_r($return);		
		}
		
		/**
		 * 微信菜单会缓存,用getMenu可以及时看到结果
		 */
		public function getMenu()
		{
			$return	= $this->wx->getMenu();
			echo json_encode($return);
		}
		
		
		/**
		 * 发送文本消息，函数名
		 */
		public function setText()
		{
			if ($this->wx->obj->Content =='1')
			{
				$params['content']		= '您输入的文字为１';
			}
			else 
			{
				$params['content']		= '输入其他文字';
			}
			$this->wx->responseMsg('text',$params);
		}
		
		/**
		 * 关注事件测试
		 */
		public function setSubscribe()
		{
            $cache = cache::getClass();
            $att = $cache->get('SubscribeAtt');
            if(!$att)
            {
                $att = M('tag')->getFieldData('params',array('name'=>'SubscribeAtt'));
                $cache->set('SubscribeAtt',$att,3600*24);
            }
            if($att==1){
                $info = M('wechat_reply')->getFieldData('content',array('model'=>1,'replyType'=>1));
                $params = array('content'=>$info);
                $this->wx->responseMsg('text',$params);	
            }
            if($att==2){
                $info = M('wechat_reply')->getOneData(array('model'=>2,'replyType'=>1));
                $params = array(
                    0=>array(
                        'title'=>$info->title,
                        'description'=>$info->brief,
						'picUrl'=>$info->coverImg,
						'url'=>$info->contentLink
                    )
                );
                $this->wx->responseMsg('news',$params);	
            }
            if($att==3){
                $info = M('wechat_reply')->where(array('model'=>3,'replyType'=>1))->orderby(array('id'=>'asc'))->execute();                
                $params = array();
                foreach($info as $item)
                {
                    $params[] = array(
                        'title'=>$item->title,
                        'description'=>$item->brief,
						'picUrl'=>$item->coverImg,
						'url'=>$item->contentLink
                    );
                }
                $this->wx->responseMsg('news',$params);	
            }		
		}
		
		/**
		 * 简单的群发测试,群发有次数限制,多次测试可能会失败
		 * 该例子测试返回成功,但实际上未收到群发消息,待验证
		 */
		public function sendOpenIds()
		{
			$rs		= $this->wx->getSubscribeList();
			$ids	= $rs->data->openid;//取得全部的openid(一次最多10000个)
			$return	= $this->wx->sendIdsMsg($ids,'text','测试群发');
			print_r($return);
		}
		
		/**
		 * 删除已发送的群发消息
		 */
		public function delMsg()
		{
			$return 	= $this->wx->deleteMsg('2348408813');//msgId必须是成功发送的信息id
			print_r($return);
		}
		
		/**
		 * 发送客服消息
		 */
		public function sendCustomMsg()
		{
			$openId		= 'otJYNs_PVkuBerHUc-10Ik-x3Yio';
			$return 	= $this->wx->sendCustomMsg($openId,'text',array('content'=>'测试客服消息'));
			print_r($return);
		}
		
		public function getUser()
		{
			$openId		= 'otJYNs_PVkuBerHUc-10Ik-x3Yio';
			$return 	= $this->wx->getOneUser($openId);
			print_r($return);
		}
		
		public function createGroup()
		{
			$return 	= $this->wx->createGroup('测试分组');
			print_r($return);
		}
		
		public function modifyGroup()
		{
			$return		= $this->wx->modifyGroup('102','修改分组');
			print_r($return);
		}
		
		public function searchGroup()
		{
			$return 	= $this->wx->searchGroup('otJYNs_PVkuBerHUc-10Ik-x3Yio');
			print_r($return);
		}
		
		public function changeGroup()
		{
			$return 	= $this->wx->changeUserGroup('otJYNs_PVkuBerHUc-10Ik-x3Yio', '102');
			print_r($return);
		}
	}

<?php defined('KING_PATH') or die('访问被拒绝.');
	class Group_Controller extends Template_Controller
	{
		private $mod;
		public function __construct()
		{
			parent::__construct();
			hcomm_ext::validUser();
			$this->mod	= M('group');
			$this->account_id = accountInfo_ext::accountId(); 
		}
		
		/**
		 * 用户组列表
		 */
		public function index()
		{
			$rs				= $this->mod->where("account_id=".$this->account_id)->select()->execute();
			$data['tree']	= $rs;
			$this->template->content = new View('admin/group/index_view',$data);
            $this->template->tipBoxContent1 = new View('admin/group/editMod_view');
			$this->template->render();
		}
		
		/**
		 * 添加用户组
		 */
		public function add()
		{
            $rs			= M('mod')->where(array('bid'=>0,'visible'=>1))->orderby(array('orderNum'=>'asc'))->execute();
            foreach ($rs as $row)
            {
                $row->child	= M('mod')->where(array('bid'=>$row->id))->orderby(array('orderNum'=>'asc'))->execute();
            }
            $data['tree'] = $rs;
			$this->template->content	= new View('admin/group/add_view',$data);
			$this->template->render();
		}
		
		/**
		 * 保存用户组
		 */
		public function save(){
			$newGroupName	= P('newGroupName');
			$tree			= p('tree');
			$other			= p('other');
			if($newGroupName && $tree)
			{
				$count	= $this->mod->getAllCount(array('groupName'=>$newGroupName));
				if ($count>0){
					echo json_encode(array('msg'=>'该用户组已存在','success'=>0));
				}else{
					$array = array(
							"account_id"	=> $this->account_id,
							'groupName' 	=> $newGroupName,
							'modPower' 		=> $tree,
                            'other' 		=> $other,
							'ctime' 		=> time()
					);
					$return = $this->mod->save($array);
					if ($return >0){
                        echo json_encode(array('msg'=>'','success'=>1));
					}else{
                        echo json_encode(array('msg'=>'保存用户组失败','success'=>0));
					}
				}
			}else{
                echo json_encode(array('msg'=>'参数错误','success'=>0));
            }
		}
		
		/**
		 * 编辑用户组
		 */
		public function edit()
		{
			$edit	= S('edit');
			if ($edit >0)
			{
				$data['item']				= $this->mod->getOneData(array('id'=>$edit));
			}
            $checklist = array();
            if(strstr($data['item']->modPower,','))
                $checklist = explode(',',$data['item']->modPower);
            $rs			= M('mod')->where(array('bid'=>0,'visible'=>1))->orderby(array('orderNum'=>'asc'))->execute();
            foreach ($rs as $row)
            {
                if(in_array($row->id,$checklist))
                    $row->checked = ' checked="checked"';
                $row->child	= M('mod')->where(array('bid'=>$row->id))->orderby(array('orderNum'=>'asc'))->execute();
                foreach($row->child as $ch)
                {
                    if(in_array($ch->id,$checklist))
                        $ch->checked = ' checked="checked"';
                }
            }
            $data['tree'] = $rs;
			$this->template->content = new View('admin/group/edit_view',$data);
			$this->template->render();
		}
		
		/**
		 * 更新用户组
		 */
		public function update()
		{
			$edit = S('update');
			if ($edit >0)
			{
				$newGroupName		= P('newGroupName');
				$tree				= P('tree');
				$other				= P('other');
				if($newGroupName)
				{                    
                    $count		= $this->mod->getAllCount(array('groupName'=>$newGroupName, 'id !='=>$edit));
                    if ($count>0)
                    {
                        echo json_encode(array('msg'=>'该组名已存在','success'=>0));
                    }
                    else
                    {
                        $upd		= array(
                            'groupName'		=> $newGroupName,
                            'modPower'		=> $tree,
                            'other'         => $other
                        );
                        $wh			= array('id'=>$edit);
                        $return		= $this->mod->update($upd,$wh);
                        echo json_encode(array('success'=>1));
                    }
                }
                else
                {
                    echo json_encode(array('msg'=>'参数错误','success'=>0));
                }
			}
            else
            {
                echo json_encode(array('msg'=>'参数错误！','success'=>0));
            }
		}
		
		public function del()
		{
			$id	= S('del');
			if ($id>0)
			{
				$return 	= $this->mod->delete(array('id'=>$id));
			}
            input::redirect('admin/group/index');
		}
		
		public function getAccount()
		{
            $id = P('id');
            $accountList = M('account')->where(array('gid'=>$id))->execute();
            foreach($accountList as $item)
            {
                echo '<span><input type="checkbox" name="accountId" value="'.$item->id.'" />'.$item->username;
                if($item->project)
                {
                    echo '('.$item->project.')';
                }
                echo '</span>';
            }
		}
		
	}

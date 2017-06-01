<?php defined('KING_PATH') or die('访问被拒绝.');
	class Log_Controller extends Template_Controller
	{
		public function __construct()
		{
			parent::__construct();
			hcomm_ext::validUser();
			$this->mod		= M('log');	
		}
		
		public function index()
		{
            $list = array();
            $pagesize = 20;
            $total		            = M('log')->getAllCount('1=1');
            $data['pagination']       = pagination::getClass(array(
                'segment'             => 'page',
                'total'               => $total,
                'perPage'		        => $pagesize
            ));
            $fnum = ($data['pagination']->currentPage-1)*$pagesize;
            $rs = M('log')->where('1=1')->orderby('id desc')->limit($fnum,$pagesize)->execute();
            if(!empty($rs)){
                foreach($rs as $key=>$val){
                    $list[$key] = array_ext::toArray($val);
                }
            }
            $data['List'] = $list;
			$this->template->content	= new View('admin/log/index_view',$data);
			$this->template->render();			
		}
        //积分日志
		public function points(){
            $wh = ' 1=1';
            $username = G('username','');
            $type = G('type','');
            $stime = G('startTime','');
            $etime = G('endTime','');
            if(!empty($username)){
                $urs = M('member')->select('id')->where('mobile like \'%'.$username.'%\' or realname like \'%'.$username.'%\'')->limit(0,10)->execute();
                if(!empty($urs)){
                    $istr = '';
                    foreach($urs as $val){
                        $istr.=$val->id.',';
                    }
                    $wh.=' and member_id in('.trim($istr,',').')';
                }else{
                    $wh.=' and member_id=\'0\'';
                }
            }
            // 日志类型
            if(!empty($type)){
            	$wh.=' and type=\''.$type.'\'';
            } 
            if(!empty($stime)){
                $stime_int = strtotime($stime);
                $wh.=' and ptime>=\''.$stime_int.'\'';
            }
            if(!empty($etime)){
                $etime_int = strtotime($etime);
                if(!empty($stime_int)){
                    //如果有起始时间则结束时间不能小于起始时间
                    if($etime_int>=$stime_int){
                        $wh.=' and ptime<=\''.$etime_int.'\'';
                    }
                }else{
                    $wh.=' and ptime<=\''.$etime_int.'\'';
                }
            }
            $list = array();
            $pagesize = 20;
            $total		        = M('jifen_log')->getAllCount($wh);
            $data['pagination'] = pagination::getClass(array(
                'segment'       => 'page',
                'total'         => $total,
                'perPage'		=> $pagesize
            ));
            $fnum = ($data['pagination']->currentPage-1)*$pagesize;
            $rs = M('jifen_log')->where($wh)->orderby('id desc')->limit($fnum,$pagesize)->execute();
            if(!empty($rs)){
                foreach($rs as $key=>$val){
                    $list[$key] = array_ext::toArray($val);
                    $list[$key]['point'] = ($val->point>=0)?$val->point:'<font color=\'#ff0000\'>'.$val->point.'</font>';
                    $list[$key]['uname'] = member_ext::get_realname($val->member_id);
                    $list[$key]['lei'] = jifen_ext::get_actstrname($val->actstr);
                }
            }
            $data['List'] = $list;
            $this->template->content	= new View('admin/log/jifen_log_view',$data);
            $this->template->render();
        }
		public function getLog()
		{
			$tid		= $this->input->post('tid');
			if ($tid)
			{
				$wh		= array('tid'=>$tid);
			}
			$total		= $this->mod->getAllCount($wh);
			$page		= $this->input->post('page');
			$size		= $this->input->post('rows');
			$start		= ($page-1)*$size;
			$rs			= $this->mod->where($wh)->orderby(array('id'=>'desc'))->limit($start,$size)->execute();
			$rs2		= array();
			foreach ($rs as $row)
			{
				$row2				= $this->mod->getOneData(array('id'=>$row->uid),'','account');
				$row->user			= $row2->username;
				$row->type			= $this->mod->getFieldData('modName',"id='{$row->tid}'",'mod');
				$row->ctime			= date('Y-m-d H:i:s',$row->ctime);
				$rs2[]				= $row;
			}
			echo json_encode(array('total'=>$total,'rows'=>$rs2));			
		}
        public function clearlog(){
            $vtime = time()-2592000;    //日志保留30天
            M('log')->delete('ctime<\''.$vtime.'\'');
            die(json_encode(array('errorno'=>0,'msg'=>'success')));
        }

        // 访问量统计
        public function hitsList(){
            $where = 'di.did=6';
            $rs = M()->query("SELECT count(*) as total FROM tf_shop_hits sh LEFT JOIN tf_dict_item di ON di.`data`=sh.mall_id WHERE $where");
            $total      = $rs[0]->total;
            $data['pagination'] = pagination::getClass(array(
                'segment'       => 'page',
                'total'         => $total,
                'perPage'       => $pagesize
            ));
            $fnum = ($data['pagination']->currentPage-1)*$pagesize;
            $sql = "SELECT di.name,ms.shop_name,sh.pv,sh.uv,sh.fav,sh.delfav,sh.sales_num,sh.sales_money,sh.`share`,sh.cart_num, FROM_UNIXTIME(sh.pdate) pdate
                FROM tf_shop_hits sh LEFT JOIN tf_member_shop ms ON ms.id=sh.shop_id
                LEFT JOIN tf_dict_item di ON di.`data`=sh.mall_id WHERE $where limit $fnum,15";
            $data['hitsList'] = M()->query($sql);
            $this->template->content    = new View('admin/log/hitsList_view',$data);
            $this->template->render();
        }
	}
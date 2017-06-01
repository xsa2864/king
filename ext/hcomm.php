<?php
class hcomm_ext
{
    public static function validUser($userName='')
    {
        session_start();
        if (!isset($_SESSION['header_uid']))
        {
            header("Content-type: text/html; charset=utf-8");
            echo "<script type=\"text/javascript\" chartset=\"utf-8\">
					alert(\"登录超时\");
					location.href= '".input::site('admin/login')."';
				</script>";
            exit;
        }
        else
        {
            if ($_SESSION['userName'] !='admin')//管理员不用校验模块
            {
                if($userName!='admin')
                {
                    $appUrl		= input::segment(2).'/'.input::segment(3);
                    $mod		= M('mod');
                    $validId	= $mod->getFieldData('id',array('url'=>$appUrl));
                    if($validId)
                    {
                        if (!self::hasPower($validId))
                        {
                            header("Content-type: text/html; charset=utf-8");
                            echo "  <script type=\"text/javascript\" chartset=\"utf-8\">
                                alert(\"对不起，你没有此模块的操作权限!\");
                            </script>";
                            exit;
                        }
                    }
                }
            }
        }
    }

    public static function hasPower($id)
    {
        if ($_SESSION['userName'] != 'admin')//admin不限制操作权限
        {
            $powers	= explode(',',$_SESSION['modPower']);
            return in_array($id,$powers);
        }
        return true;
    }
    
    public static function saveToLog($tid,$msg)
    {
        if ($_SESSION['header_uid'] >1)//不记录admin的操作情况
        {
            $model		= M('log');
            return $model->insert(array('uid'=>$_SESSION['header_uid'],'tid'=>$tid,'msg'=>input::ipAddr().$msg,'ctime'=>time()));
        }
    }
    
    public static function getPowers()
    {
        $powers	= array();
        if ($_SESSION['powers'])
        {
            $powers		= explode(',',$_SESSION['powers']);
        }
        return array_unique($powers);
    }
    
    public static function setChecked($default='',$value1='',$value2='')
    {
        if ($value2===null)//如果不存在 
        {
            if ($default)
                echo 'checked="checked"';
        }
        else
        {
            if ($value1 == $value2)
                echo 'checked="checked"';
        }
    }

    
    public static function sendSms($mobile,$msg='') 
    {
        return true;
    }	

    public static function validKey($time,$apiKey)
    {
        if ($time && $apiKey)
        {
            $nativeKey	= 'b1f6597b69dbe290ab417817fe61eb96';
            $realKey	= md5($time.$nativeKey);
            if ($realKey == $apiKey)
            {
                return json_encode(array('success'=>1,'msg'=>'校验数据错误'));
            }
            else
            {
                return json_encode(array('success'=>0,'msg'=>''));
            }
        }
        else
        {
            return json_encode(array('success'=>0,'msg'=>'无校验数据'));
        }
    }

    public static function getFile($file)
    {
        $str	= '';
        $files 	= explode(',',$file);
        if (is_array($files))
        {
            foreach ($files as $f)
            {
                $str	.= basename($f).'<br />';
            }
        }
        return $str;
    }		

    public static function allowIp($allows,$ip='')
    {
        $ip		= $ip ? $ip :$this->input->ipAddr();
        $ips	= explode('.',$ip);
        if (count($ips)>0)
        {
            if (is_array($allows))
            {
                foreach ($allows as $allow)
                {
                    $ipsChange		= $ips;
                    $allowArray		= explode('.',$allow);
                    foreach ($allowArray as $k=>$v)
                    {
                        if ($v	== '*')
                        {
                            $ipsChange[$k]	= '*';
                        }
                    }
                    if (implode('.',$ipsChange) == $allow)
                    {
                        return true;
                    }
                }
            }
        }
        return false;
    }		

    /*
     * 获取省份 下拉
     */
    public static function getProvincial($id = 0){
        $cache = cache::getClass();
        $prov = $cache->get('webProvincial');
        if(!$prov) {
            $model = M('provincial');
            $prov = $model->execute();
            $cache->set('webProvincial',$prov);//月
        }
        $str = '';
        foreach($prov as $value){
            intval($id) == $value->id ? $select = "selected" : $select = '';
            $str .= '<option value="'.$value->id.'" '.$select.'>'.$value->name.'</option>';
        }
        return $str;
    }
    /*
     * 获取城市  下拉
     */
    public static function getCity($pid,$id = 0){
        $cache = cache::getClass();
        $city_cache = $cache->get('webCity');
        //  $cache->delete('webCity');
        if(!$city_cache) {
            $model = M('city');
            $prov = $model->execute();
            if(!empty($prov)) {
                foreach ($prov as $v) {
                    $city_cache[$v->pid][] = array(
                        'id' => $v->id,
                        'id1' => $v->id1,
                        'name' => $v->name,
                        'pid' => $v->pid,
                    );
                }
            }
            $cache->set('webCity',$city_cache);
        }
        $city = $city_cache[$pid];
        //  var_dump($city);exit;
        $str = '';
        if(!empty($city)) {
            foreach ($city as $value) {
                intval($id) == $value['id'] ? $select = "selected" : $select = '';
                $str .= '<option value="' . $value["id"] . '" ' . $select . '>' . $value["name"] . '</option>';
            }
        }
        return $str;
    }

    //返回订单状态
    public static function getOrderStatus($status = 0){
        $str = '';
        switch($status){
            case 1:
                $str = '未发货';
                break;
            case 2:
                $str = '已发货';
                break;
            case 3:
                $str = '退货中';
                break;
            case 4:
                $str = '交易完成';
                break;
            default:
                $str = '未支付';
        }
        return $str;
    }

}
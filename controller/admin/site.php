<?php defined('KING_PATH') or die('访问被拒绝.');
    class Site_Controller extends Template_Controller
    {
        public function __construct()
        {
            parent::__construct();
            comm_ext::validUser();
        }
        
        public function index()
        {
            $data['row']       = C('siteConfig');
            $this->template->content = new View('admin/site/add_view',$data);
            $pic = D('picture')->GetData();
            $this->template->tipBoxContent3 = new View('admin/picture/useImg_view', $pic);
            $this->template->render();        
        } 
        
        public function save()
        {
            // $post            = $this->input->post();

            /*
            $fileName      = $post['logo'];
            if ($_FILES['userfile']['name'])
            {
                $upload		= upload::getClass();
                $fileName	= 'logo.'.file_ext::getExt($_FILES['userfile']['name']);
                $return 	= $upload->save(1,'userfile',$fileName);
                if ($return	== false)
                {
                    echo json_encode(array('msg'=>'图片上传失败：'.$upload->getError(),'success'=>0));
                    exit;
                }
            }*/

            $picskey = P('picskey');
            $picsvalue = P('picsvalue');
            if ($picskey == '' && $picsvalue == '') {
                echo json_encode(array('success' => 0, 'msg' => '缺少图片！'));
                return;
            }
            $pics = $picskey[0];
            /*
            $pics = array();
            $i = 0;
            foreach($picskey as $value)
            {
                if(isset($picsvalue[$i]))
                    $pics[$value] = $picsvalue[$i];
                else
                    $pics[$value] = '0';
                $i++;
            }*/
            $realName = P('realName');
            $shopname = P('shopname');
            $phone = P('phone');
            $content = P('content');
            $copyright = P('copyright');
            $icp = P('icp');
            $insert = array(
                'name' => $shopname,
                'realName' => $realName,
                'content' => $content,
                'logo' => $pics,
                //   'qq'            => $post['qq'],
                'phone' => $phone,
                'icp' => $icp,
                'copyright' => $copyright,
                //  'address'       => $post['address']
            );
            $return = file_ext::saveConfig($insert, 'siteConfig');
            echo json_encode(array('success' => 0, 'msg' => '保存失败！'));
        }
        public function addmore()
        {
            $data['row']       = extconfig_ext::getSiteMore();
            $this->template->content = new View('admin/site/addmore_view',$data);
            $this->template->render();
        }
        public function savemore()
        {
            $arr = P();
            if(!empty($arr) && is_array($arr)){
                M('tk_extconfig')->delete('1=1');  //删除旧配置
                $key_arr = array_keys($arr);
                foreach($key_arr as $val){
                    $data['keyname'] = $val;     //键名
                    $data['keyval'] = $arr[$val];   //键值
                    M('tk_extconfig')->save($data);
                    myfunc_ext::cachePut('siteExtconfig',$val,$arr[$val]);
                }
                die(json_encode(array('success' => 1, 'msg' => '保存成功！')));
            }
            die(json_encode(array('success' => 0, 'msg' => '保存失败！')));
        }
    }

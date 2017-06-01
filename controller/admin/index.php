<?php defined('KING_PATH') or die('访问被拒绝.');
class Index_Controller extends Controller
{ 
    public function __construct()
    {
        parent::__construct();
        comm_ext::validUser('admin');
        // $this->account_id = accountInfo_ext::accountId(); 
    }
    
    // 后台首页
    public function index()
    { 

        // 主菜单栏
        $menuList = array();
        $where = array('visible'=>1);
        $order = 'orderNum asc';
        $fields = 'id,bid,url,app,modName';
        $menuList = M('mod')->where($where)->orderby($order)->select($fields)->execute();
        $leftMenu = $this->getTree(json_decode(json_encode($menuList),true));

        $loc = M("tk_business")->select("id,name,addtime")->where("lat=0 and lng=0 and status=1")->orderby("addtime desc")->limit(0,3)->execute();
        $data['loc'] = $loc;

        $member = M("tk_log_commission lc")->select("lc.id,m.nickname,lc.content,lc.addtime")->join("member m","m.id=lc.to_member_id")->where("lc.status=0")->orderby("lc.addtime desc")->limit(0,3)->execute();
        $data['member'] = $member;

        $business = M("tk_log_consume")->select("id,tkb_name,note,addtime")->where("status=0")->orderby("addtime desc")->limit(0,3)->execute();
        $data['business'] = $business;


        // 账户信息
        // $account = M('account')->getOneData(array('id'=>$this->account_id));
        // print_r($leftMenu);
        $data['userName'] = $_SESSION['userName'];
        $data['leftMenu'] = $leftMenu;
        $this->template = new View('admin/index/index_view',$data);
        $this->template->render();

        
    }

    // 递归函数
    public function getTree($arr,$id=0){
        $tree = array();
        foreach ($arr as $key => $value) {
          if($value['bid'] == $id){
            $value['child'] = self::getTree($arr,$value['id']);
            $tree[] = $value;
          }
        }
        return $tree;
    }
}

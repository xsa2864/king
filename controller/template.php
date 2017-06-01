<?php defined('KING_PATH') or die('访问被拒绝.');
class Template_Controller extends Controller
{
    public $template;
    public function __construct()
    { 
        parent::__construct();
        ini_set('date.timezone','Etc/GMT-8'); 
        $this->template = new View('template_view');

        // 主菜单栏
        $menuList = array();
        $where = array('bid'=>0,'visible'=>1);
        $order = 'orderNum asc';
        $fields = 'id,bid,app,modName,url';
        $menuList = M('mod')->where($where)->orderby($order)->select($fields)->execute();

        $itemChooseId = $this->input->segment(2);
        $leftChooseId = $this->input->segment(3);
        $this->template->titleName = '';
        $this->template->leftList = array();
        $valid  = M('mod')->getOneData(array('url'=>$itemChooseId.'/'.$leftChooseId,'bid!='=>0),'id,bid,modName');

        //判断他是否为三级栏目,,,后面改的，2015-10-15
        $check_second = M('mod')->getOneData(array('id'=>$valid->bid,'bid !='=>''));
        if(isset($check_second)){
            $valid->bid = $check_second->bid;
        }

        foreach($menuList as $item) {
            //查询二级菜单，上面是原先的，下面是改动后的，2015-10-15
            $leftList = M('mod')->where(array('bid' => $item->id, 'visible' => 1))->execute();
            if(empty($item->url)){
                $item->url = 'unopened';      
            }

            $menu = array();
            foreach ($leftList as $value) {
                $item->url = $value->url;
                break;
            }
            foreach ($leftList as $value) {
                $classon = '';
                $display = 'style="display: none;"';
                if ($itemChooseId . '/' . $leftChooseId == $value->url) {
                    $classon = ' class="on"';
                }
                if($check_second->id == $value->id){
                    $display = 'style="display: block;"';
                }
                //判断是否有下级菜单
                $three = M('mod')->where(array('bid' => $value->id, 'visible' => 1))->execute();

                $menu[$value->id] = array(
                    'id' => $value->id,
                    'bid' => $value->bid,
                    'modName' => $value->modName,
                    'url' => $value->url,
                    'app' => $value->app,
                    'size' => $value->size,
                    'icon' => $value->icon,
                    'visible' => $value->visible,
                    'orderNum' => $value->orderNum,
                    'classon' => $classon,
                    'display' => $display
                );
                if (!empty($three)) {
                    foreach ($three as $th) {
                        $classon = '';
                        if ($itemChooseId . '/' . $leftChooseId == $th->url) {
                            $classon = ' class="on"';
                        }
                        $menu[$value->id]['second'][$th->id] = array(
                            'id' => $th->id,
                            'bid' => $th->bid,
                            'modName' => $th->modName,
                            'url' => $th->url,
                            'app' => $th->app,
                            'size' => $th->size,
                            'icon' => $th->icon,
                            'visible' => $th->visible,
                            'orderNum' => $th->orderNum,
                            'classon' => $classon
                        );
                    }
                }
            }

            if ($valid->bid == $item->id) {
                $this->template->titleName = $item->modName;
                $item->classon = ' class="on"';
                $this->template->leftList = $menu;
            }

        }

        $this->template->menuList = $menuList;
    }
}
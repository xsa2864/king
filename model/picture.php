<?php defined('KING_PATH') or die('访问被拒绝.');
	/**
	 * 图库
	 */
	class Picture_Model extends Model
	{
		public function __construct($dbSet)
		{
			$table		= $this->setTable();
			parent::__construct($table,$dbSet);
		}
		
		public function setTable()
		{
			return 'picture';
		}
		
		/**
		 * 获取图库分类和对应分类图片
		 * @return array 界面数据
		 */
		public function GetData()
		{
            $rs = M('picture_category')->where(array('pid'=>0))->execute();
            foreach($rs as $ch)
            {
                $ch->child = M('picture_category')->where(array('pid'=>$ch->id))->execute();
                foreach($ch->child as $ch1)
                {
                    $ch1->child = M('picture_category')->where(array('pid'=>$ch1->id))->execute();
                }
            }
            $data['picCategory'] = $rs;
            $wh = array();
            $on = S('on');
            if(!$on)
            {
                $on = M('picture_category')->getFieldData('id', array('pid'=>0));
            }
            if($on>0)
            {
                $onCategory = M('picture_category')->getOneData(array('id'=>$on));
                if(!$onCategory)
                {
                    $onCategory = M('picture_category')->getOneData(array('pid'=>0));
                    $on = $onCategory->id;
                }
                $data['fid'] = $on;
                $data['sid'] = $onCategory->pid;
                if($data['sid']>0)
                {
                    $sCategory = M('picture_category')->getOneData(array('id'=>$onCategory->pid));
                    $data['tid'] = $sCategory->pid;
                }                 
                $wh['cid'] = $on;
            }
            $select = S('select');
            if($select)
            {
                $wh['name like'] = '%'.$select.'%';
            }
            $total		= M('picture')->getAllCount($wh);
            $data['pagination'] = pagination::getClass(array(
                'total'       => $total,
                'segment' => 'page',
                'perPage'		=> 20
                ));
            $start			= ($data['pagination']->currentPage-1)*20;
            $return =  M('picture')->where($wh)->limit($start,20)->execute();
            foreach($return as $value)
            {
                $names    = explode('.',$value->img);
                $value->pic = input::site($names[0].'_88x83.'.$names[1]);
                $value->name = $value->name.'.'.$names[1];
            }
            $return1 = M('picture_category')->where(array('pid'=>$on))->execute();
            $data['picList'] = array_merge($return1,$return);
            return $data;
        }

	}
	
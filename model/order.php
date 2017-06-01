<?php defined('KING_PATH') or die('访问被拒绝.');
	class Order_Model extends Model
	{
		public function __construct($dbSet)
		{
			parent::__construct('',$dbSet);
		}

		// 生存
		private function getSn()
        {
            $sn = '3'.time().$this->user->id;
            $num = 18 - mb_strlen($sn);
            for ( $i=1; $i<=$num; $i++) {
                $sn .= rand(0, 9);
            }
            return $sn;
        }

        
		public function addNewOrder($user,$itemId,$itemNum=1)
        {
            
            $params=array();
            $params['member_id'] = $this->user->id;
            $params['price'] = $this->user->id;

            M('tk_coupon')->insert($params);
			return $array['sn'];
        }
	}
	
<?php defined('KING_PATH') or die('访问被拒绝.');

      class Special_Model extends Model
      {
          private $memcached;
          private $cache;

          public function __construct($dbSet)
          {
              $table = $this->setTable();
              parent::__construct($table, $dbSet);
              $this->cache	= cache::getClass();
          }

          public function setTable()
          {
              return 'special';
          }

          /**
           * 取得商品所有属性
           * @param number $all 是否显示隐藏属性，默认不显示
           */
          public function getAttr()//$all取得所有属性含隐藏的属性
          {
              return $this->getDictOption();
          }

          /**
           * 取得活动值
           *
           */
          private function getDictOption()
          {
              $key = 'sdict_' . $dictId;
              $this->cache->delete($key);
              $rs = $this->cache->get($key);
              if ($rs === false) {
                  $rs = $this->select('id,name,page')->from('special')->where(array('isSpecial' => 1,'isNav'=>1))->orderby(array('order' => 'asc'))->execute();
                  $this->cache->set($key, $rs, 86400);
              }
              return $rs;
          }

          // 取得组产品
          public function getItem($option = 0)
          {
              $itemIdList = M('special_item')->select('itemId')->where(array('groupId'=>$option))->execute();
              $rs = array();
              foreach($itemIdList as $value)
              {
                  $rs[] = $value->itemId;
              }
              return $rs;
          }
      }

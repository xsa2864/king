var fx_prefix 	= location.protocol+'//'+location.hostname+'/';
var fx_login 		= fx_prefix+"mobile/login/checkLogin";
var fx_login_validUser = fx_prefix+"mobile/login/login_validUser";   //登录后的验证
var fx_regist 		= fx_prefix+"mobile/login/saveRegist";
var fx_addaddCart 	= fx_prefix+'mobile/cart/addCart';

var fx_addressList 	= fx_prefix+'mobile/member/getaddress';
// 关键词
var fx_showSearch 		= fx_prefix+'mobile/goods/showSearch';
var fx_search       	= fx_prefix+'mobile/goods/searchGoods';
var fx_search_keyword  	= fx_prefix+'mobile/goods/search_keyword';
var fx_clearKeyword   	= fx_prefix+'mobile/goods/clearKeyword';
// 会员中心
var fx_member_mask		= fx_prefix+'mobile/member/member_mask';//签到
var fx_get_center_info	= fx_prefix+'mobile/member/get_center_info';
var fx_		= fx_prefix+'mobile/goods/member_mask';

var fx_index	   = fx_prefix+'mobile/goods/index';//首页
var fx_show_center = fx_prefix+'mobile/member/member_center';//会员中心
var fx_ = fx_prefix+'';//我的名片
var fx_ = fx_prefix+'';//会员等级
var fx_ = fx_prefix+'';//积分中心
var fx_ = fx_prefix+'';//我的金币
var fx_ = fx_prefix+'';//余额提现
var fx_show_collection = fx_prefix+'mobile/goods/show_collection';//我的收藏
var fx_ = fx_prefix+'';//消息提醒
var fx_ = fx_prefix+'';//地址管理

var fx_get_collection = fx_prefix+'mobile/goods/get_collection';//获取收藏记录
var fx_del_collection = fx_prefix+'mobile/goods/del_collection';//删除收藏记录

var fx_get_cart_info  = fx_prefix+'mobile/cart/get_cart_info';//获取购物车信息
var fx_changeNum  	  = fx_prefix+'mobile/cart/changeNum';//更新商品数量
var fx_clear_cart 	  = fx_prefix+'mobile/cart/deleteAll';//清空购物车
var fx_clear_invalid  = fx_prefix+'mobile/cart/clear_invalid';//清空购物车
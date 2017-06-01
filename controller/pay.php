<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/29
 * Time: 9:19
 */

class Pay_Controller extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 微信支付结果异步接收
     */
    public function wpaycallback()
    {
        $values = array();
        $cache = cache::getClass();
        $values = str_ext::FromXml(file_get_contents("php://input"));
        King::log('wechat wpaycallback callback :'.json_encode($values).'\r\n','paylog/'.date('Y-m-d').'.log.php');
        $orderSn = $cache->get('ordersn:'.$values['out_trade_no']);
        $check_order = M('tk_coupon')->getOneData(array('id'=>$orderSn));
        if($values['return_code']=='FAIL')
        {
            King::log('订单ID：'.$orderSn.'订单支付失败：'.$values['return_msg'].'\r\n','paylog/'.date('Y-m-d').'.log.php');
            $values = array();
            $values['return_code'] = 'SUCCESS';
            $values['return_msg'] = 'OK';
            echo str_ext::ToXml($values);
            exit;
        }
        //检查订单信息
        if(!$check_order)
        {
            King::log('订单ID：'.$orderSn.'   订单不存在'.'\r\n','paylog/'.date('Y-m-d').'.log.php');
            $values = array();
            $values['return_code'] = 'FAIL';
            $values['return_msg'] = 'OK';
            echo str_ext::ToXml($values);
            exit;
        }
        if($values['sign'] == str_ext::MakeSign($values))
        {
            if($values['result_code']=='SUCCESS')
            {
                //验证成功
                //商户订单号
                //$out_trade_no = $orderSn;
                //微信支付订单号
                $trade_no = $values['transaction_id'];
                //交易状态
                //$trade_status = $values['trade_status'];
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                tuoke_ext::pay_coupon($check_order->code,2,$trade_no);
            }
            $values = array();
            $values['return_code'] = 'SUCCESS';
            $values['return_msg'] = 'OK';
            echo str_ext::ToXml($values);
            exit;
        }        
        King::log('订单ID：'.$values['out_trade_no'].'   验签失败'.'\r\n','paylog/'.date('Y-m-d').'.log.php');
        $values = array();
        $values['return_code'] = 'FAIL';
        $values['return_msg'] = '';
        echo str_ext::ToXml($values);
        exit;

    }
}
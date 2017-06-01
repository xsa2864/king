<?php
/**
 * Created by PhpStorm.
 * User: LiaoJR
 * Date: 2015/10/9
 * Time: 14:00
 */

class PayConfig_Controller extends Template_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function alipay(){
        $pay       = C('payConfig');
        $data['pay'] = $pay['alipay'];
        $this->template->content	= new View('admin/payconfig/alipay_view',$data);
        $this->template->render();
    }
    public function weixinpay(){
        $pay       = C('payConfig');
        $data['pay'] = $pay['weixinpay'];
        $this->template->content	= new View('admin/payconfig/weixinpay_view',$data);
        $this->template->render();
    }
    /*
     * 保存转发
     */
    public function savePay(){
        $payType = P('payType');
        switch($payType){
            case 'alipay':
                $this->saveAliPay();
                break;
            case 'weixinpay':
                $this->saveWeixinPay();
                break;
            default:
                input::redirect('admin/payconfig/alipay');
        }
    }
    /*
     * 保存支付宝配置
     */
    public function saveAliPay(){
        $payType = P('payType');
        if($payType != 'alipay'){input::redirect('admin/payconfig/alipay');}

        //获取上传的cart文件
        if($_FILES['file_cert']['name']){
            $upload		= upload::getClass();
            $fileName	= $_FILES['file_cert']['name'];
            $return 	= $upload->save(0,'file_cert',$fileName);
            if ($return	== false){
                echo json_encode(array('msg'=>'图片上传失败：'.$upload->getError(),'success'=>0));
                exit;
            }
            $cert = $return;
        }
        $config = C('payConfig');
        //组成新的数组
        $status = P('status');
        $is_default = P('is_default');
        $is_default == 1 ? $config['weixinpay']['is_default'] = 0 : $config['weixinpay']['is_default'] = 1;
        $seller_email = P('seller_email');
        $userName = P('userName');
        $partner = P('partner');
        $key = P('key');
        $batch_transfer = P('batch_transfer');
        isset($cert) ? $apiclient_cert = $cert : $apiclient_cert = $config['alipay']['cacert'];
        $config['alipay'] = array(
            'name'  =>  '支付宝',
            'is_default' =>  $is_default,
            'status'    =>  $status,
            'partner'=>   $partner,//合作身份者id，以2088开头的16位纯数字
            'seller_email'    =>  $seller_email, //收款支付宝账号
            'userName'     =>  $userName,//微信公众号身份唯一标识
            'key'   =>  $key,
            'sign_type' => 'MD5',//签名方式 不需修改
            'input_charset' => 'utf-8',//字符编码格式 目前支持 gbk 或 utf-8
            'cacert'    =>  $apiclient_cert,//ca证书路径地址，用于curl中ssl校验,请保证cacert.pem文件在当前文件夹目录中
            'transport' => 'http',//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
            'notify_url' => 'http://www.aijq.com.cn/pay/notify_url.php',//服务器异步通知页面路径
            'return_url' => 'http://www.aijq.com.cn/pay/returnUrl',//页面跳转同步通知页面路径
            'batch_transfer ' => $batch_transfer, //批量转账

        );
        file_ext::saveConfig($config,'payConfig');
        input::redirect('admin/payconfig/alipay');
    }
    /*
     * 保存微信支付配置
     */
    public function saveWeixinPay(){
        $payType = P('payType');
        if($payType != 'weixinpay'){input::redirect('admin/payconfig/weixinpay');}
        //获取上传的cart文件
        if($_FILES['file_cert']['name']){
            $upload		= upload::getClass();
            $fileName	= $_FILES['file_cert']['name'];
            $return 	= $upload->save(0,'file_cert',$fileName);
            if ($return	== false){
                echo json_encode(array('msg'=>'图片上传失败：'.$upload->getError(),'success'=>0));
                exit;
            }
            $cert = $return;
        }
        $config = C('payConfig');
        //组成新的数组
        $status = P('status');
        $is_default = P('is_default');
        $is_default == 1 ? $config['alipay']['is_default'] = 0 : $config['alipay']['is_default'] = 1;
        $tenpay = P('tenpay');
        $app_id = P('app_id');
        $app_secret = P('app_secret');
        $mchid = P('mchid');
        $key = P('key');
        $paysignkey = P('paysignkey');
        $batch_transfer = P('batch_transfer');
        isset($cert) ? $apiclient_cert = $cert : $apiclient_cert = $config['weixinpay']['apiclient_cert'];
        $config['weixinpay'] = array(
            'name'  =>  '微信支付',
            'is_default' =>  $is_default,
            'status'    =>  $status,
            'tenpay'    =>  $tenpay, //是否为财付通
            'app_id'     =>  $app_id,//微信公众号身份唯一标识
            'app_secret'=>   $app_secret,
            'mchid'     =>  $mchid,
            'key'   =>  $key,
            'paysignkey'    =>  $paysignkey,
            'batch_transfer ' => $batch_transfer,
            'apiclient_cert'    =>  $apiclient_cert,
        );
        file_ext::saveConfig($config,'payConfig');
        input::redirect('admin/payconfig/weixinpay');
    }

}
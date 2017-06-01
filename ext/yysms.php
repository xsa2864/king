<?php
/**
 * Created by hwz@qq.com
 * Date: 2016-03-25
 * 验证码接口
 */
class yysms_ext {
    public static function postyzcode($mobile,$vcode){
        M('sms')->update(array('is_used'=>1),array('phone'=>$mobile,'codestr<>'=>$vcode));  //旧验证码全部失效
        $msgtext = '您的验证码'.$vcode.',10分钟内有效(请勿泄露)';
        $res = self::postsms($mobile,$msgtext);
        return $res;
        //return array('errorno'=>0,'msg'=>'success');
    }
    public static function postsms($mobile,$content,$sendTime="")
    {
        //建周短信平台http接口
        $postdata = array();
        $postdata['account'] = 'sdk_fzlg';
        $postdata['password'] = 'uszhzh123';
        $postdata['destmobile'] = $mobile;
        $postdata['msgText'] = $content.'【众合智慧】';   //自动添加签名
        $postdata['sendDateTime'] = $sendTime;  //格式如20130201120000,14位长度,无需传值
        $url = 'http://www.jianzhou.sh.cn/JianzhouSMSWSServer/http/sendBatchMessage';
        $o="";
        foreach ($postdata as $k=>$v)
        {
            if($k =='content')
                $o.= "$k=".urlencode($v)."&";
            else
                $o.= "$k=".($v)."&";
        }
        $postdata=substr($o,0,-1);
        $req = request::getClass($url, 'POST');
        $req->setBody($postdata);
        $req->sendRequest();

        $res['errorno'] = 1;
        $rs = $req->getResponseBody();
        if(!empty($rs)){
            $rs = intval($rs);
            if($rs>0){
                $res['errorno'] = 0;
                $res['msg'] = 'success';
            }else{
                $res['msg'] = $rs;
            }
        }else{
            $res['msg'] = 'error';
        }
        return $res;
    }
    //验证手机号发送频率
    public static function chkmobile($mobile,$maxnum='10'){
        self::clearmsg();
        $ptime = time()-86400;  //24小时内
        $tot = M('sms')->getAllCount(array('ptime>'=>$ptime,'phone'=>$mobile)); //手机号当天发送次数
        if(empty($tot)){
            //当天无发送数据的，可以发送
            return true;
        }else{
            $maxnum = intval($maxnum);
            if($tot<=$maxnum){
                //X次以内的，取最近的发送时间
                $last = M('sms')->select('ptime')->where(array('ptime>'=>$ptime,'phone'=>$mobile))->orderby('ptime desc')->limit(0,1)->execute();
                foreach($last as $val){
                    if(time()-$val->ptime<60){
                        //60秒内发送过的，不可发送
                        return false;
                    }
                }
                return true;
            }else{
                //发送超过X次的 暂不可发送
                return false;
            }
        }
    }
    public static function clearmsg(){
        $ptime = time()-2592000;  //默认保留一个月的短信记录
        $vtime = time()-600;    //超过10分钟的验证码失效
        M('sms')->update(array('is_used'=>1),array('ptime<'=>$vtime));
        M('sms')->delete(array('ptime<'=>$ptime));
    }
    public static function usedmsg($mobile){
        M('sms')->update(array('is_used'=>1),array('phone'=>$mobile));
    }
    //校验验证码
    public static function chkcode($mobile,$codestr){
        $vtime = time()-600;    //验证码10分钟内有效
        $isok = M('sms')->getAllCount('phone=\''.$mobile.'\' and codestr=\''.$codestr.'\' and ptime>\''.$vtime.'\' and is_used=\'0\''); //是否有效的验证码
        if(!empty($isok)){
            return 1;
        }else{
            return 0;
        }
    }
    //发送验证码
    public static function postRcodeSms($mobile){
        $isok = self::chkmobile($mobile);
        if($isok){
            $sinfo = C('siteConfig');
            $codestr = str_ext::random(6,'numeric');  //随机数字验证码
            $content = '['.$sinfo['name'].']验证码:'.$codestr;
            M('sms')->save(array('codestr'=>$codestr,'phone'=>$mobile,'content'=>$content,'ptime'=>time()));
            $res = self::postyzcode($mobile,$codestr);
        }else{
            $res['errorno'] = 1;
            $res['msg'] = '您的操作太频繁，请稍后再试';
        }
        return $res;
    }
    //校验验证码
    public static function chkRcode($mobile,$codestr){
        $vnum = self::chkcode($mobile,$codestr);
        if(empty($vnum)){
            return json_encode(array('errorno'=>5,'msg'=>'无效的验证码！'));
        }else{
            yysms_ext::usedmsg($mobile);    //设置验证码失效
            return json_encode(array('errorno'=>0,'msg'=>'验证通过！'));
        }
    }
}
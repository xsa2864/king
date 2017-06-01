<?php
/**
 * 获取管理员信息
 * @author hb
 *
 */
class accountInfo_ext
{
	/**
	 * 获取管理员id  pid为0
	 * @param string $key
	 * @param array $array
	 */
	public static function accountId()
	{
		$id 	= $_SESSION['uid'];
		$result = M('account')->where("id=$id")->select('pid')->execute();
		if($result[0]->pid == 0){
			return $id;
		}else{
			$rs = M('account')->where("pid=".$result[0]->pid)->select('id')->execute();
			if($rs){
				return $rs[0]->id;
			}else{
				return '';
			}			
		}		
	}	

}
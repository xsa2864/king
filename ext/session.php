<?php

    class session_ext{
       function ext_session_start() {
			@ini_set('session.gc_probability', 1);
			@ini_set('session.gc_divisor', 2);
			@ini_set('session.gc_maxlifetime', (SESSION_TIMEOUT_ADMIN > 900 ? 900 : SESSION_TIMEOUT_ADMIN));
			if (preg_replace('/[a-zA-Z0-9]/', '', session_id()) != '')
			{
			    $this->ext_session_id(md5(uniqid(rand(), true)));
			}
			$temp = session_start();
			return $temp;
      }
	  function ext_session_id($sessid = '') {
			if (!empty($sessid)) {
				  $tempSessid = $sessid;
				  if (preg_replace('/[a-zA-Z0-9]/', '', $tempSessid) != '')
				  {
					$sessid = md5(uniqid(rand(), true));
				  }
				  return session_id($sessid);
			} else {
			      return session_id();
			}
	  }

	  function ext_session_name($name = '') {
			if (!empty($name)) {
				  $tempName = $name;
				  if (preg_replace('/[a-zA-Z0-9]/', '', $tempName) == '') return session_name($name);
				  return FALSE;
			} else {
			      return session_name();
			}
	  }
	  function ext_session_close() {
		if (function_exists('session_close')) {
		    return session_close();
		}
	  }
	  function ext_session_destroy() {
		    return session_destroy();
	  }
	  function ext_session_save_path($path = '') {
		if (!empty($path)) {
		    return session_save_path($path);
		} else {
		    return session_save_path();
		}
	  }
}

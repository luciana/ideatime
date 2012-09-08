<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Ideaslib
{

	function create_session($userId, $name, $group)
	{
		$_SESSION['user_id'] = $userId;
	    $_SESSION['username'] = $name;
	    $_SESSION['group'] = '1';
	}

}

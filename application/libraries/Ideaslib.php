<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Ideaslib
{

	function create_session($userId, $name, $groups)
	{
		$_SESSION['user_id'] = $userId;
	    $_SESSION['username'] = $name;
	    $_SESSION['groups'] = $groups;
	}

}

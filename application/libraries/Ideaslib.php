<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Ideaslib
{

	function create_session($userId, $name, $groups, $active_group_id)
	{
		$_SESSION['user_id'] = $userId;
	    $_SESSION['username'] = $name;
	    $_SESSION['groups'] = $groups;
	    $_SESSION['active_group_id'] = $active_group_id;
	}

}

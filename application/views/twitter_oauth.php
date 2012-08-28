<?php
if (!empty($_SESSION['name'])
    session_destroy();
session_start();
require APPPATH.'/views/twitter_oauth.php';




if(!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])){  
    // TwitterOAuth instance, with two new parameters we got in twitter_login.php  
	$twitteroauth = new TwitterOAuth('0sd51MbJuom5csE6xeYfw', 'suL2lwFTggjBMWRSev1uZDIutYy7vhhHo44DIOYs', $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);  
	// Let's request the access token  
	$access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']); 
	// Save it in a session var 
	$_SESSION['access_token'] = $access_token; 
	// Let's get the user's info 
	$user_info = $twitteroauth->get('account/verify_credentials'); 
	// Print user's info  
	//print_r($user_info);

    /*stdClass Object ( [id] => 39792346 [geo_enabled] => [is_translator] => [profile_background_image_url] => http://a0.twimg.com/images/themes/theme1/bg.png [following] => [show_all_inline_media] => [profile_link_color] => 0084B4 [default_profile_image] => [profile_background_image_url_https] => https://si0.twimg.com/images/themes/theme1/bg.png [utc_offset] => -18000 [follow_request_sent] => [url] => http://lucianabruscino.com [name] => Luciana Bruscino [favourites_count] => 0 [profile_use_background_image] => 1 [created_at] => Wed May 13 17:03:22 +0000 2009 [protected] => [profile_text_color] => 333333 [id_str] => 39792346 [profile_sidebar_border_color] => C0DEED [profile_image_url] => http://a0.twimg.com/profile_images/1856607344/ipad_drawing_normal.png [profile_image_url_https] => https://si0.twimg.com/profile_images/1856607344/ipad_drawing_normal.png [description] => Enjoying life as it comes..... Enthusiastic about technology/web development... & Completely in love with my wonderful husband.. [followers_count] => 65 [location] => Cleveland [default_profile] => 1 [statuses_count] => 568 [time_zone] => Eastern Time (US & Canada) [profile_background_tile] => [friends_count] => 125 [lang] => en [profile_sidebar_fill_color] => DDEEF6 [screen_name] => luciana123_2002 [listed_count] => 1 [status] => stdClass Object ( [in_reply_to_user_id_str] => [coordinates] => [geo] => [favorited] => [id_str] => 230111568526966784 [retweet_count] => 0 [possibly_sensitive_editable] => 1 [retweeted] => [in_reply_to_status_id] => [possibly_sensitive] => [in_reply_to_screen_name] => [contributors] => [place] => [in_reply_to_user_id] => [truncated] => [source] => Tweet Button [created_at] => Tue Jul 31 01:24:07 +0000 2012 [in_reply_to_status_id_str] => [id] => 2.30111568527E+17 [text] => Check out this great #codecanyon item 'My Domain List Plugin' #domaning http://t.co/S1XMoEK0 ) [notifications] => [contributors_enabled] => [verified] => [profile_background_color] => C0DEED )*/
	
	if(!empty($_SESSION['username'])){  
	    // User is logged in, redirect  
	    header('Location: index.php');  
	} 

	if(isset($user_info->error)){  
    // Something's wrong, go back to square 1  
    	header('Location: error.php'); 
	} else { 
    // Let's find the user by its ID  
/******************************************************************
    to do change the sql
***********************************************************************/
    $query = mysql_query("SELECT * FROM users WHERE oauth_provider = 'twitter' AND oauth_uid = ". $user_info->id);  
    $result = mysql_fetch_array($query);  
    $isAuthor = null;
  
    // If not, let's add it to the database  
    if(empty($result)){  
        $query = mysql_query("INSERT INTO users (oauth_provider, oauth_uid, username, oauth_token, oauth_secret) VALUES ('twitter', {$user_info->id}, '{$user_info->screen_name}', '{$access_token['oauth_token']}', '{$access_token['oauth_token_secret']}')");  
        $query = mysql_query("SELECT * FROM users WHERE id = " . mysql_insert_id());  
        $result = mysql_fetch_array($query);  
    } else {  
        // Update the tokens  
        $query = mysql_query("UPDATE users SET oauth_token = '{$access_token['oauth_token']}', oauth_secret = '{$access_token['oauth_token_secret']}' WHERE oauth_provider = 'twitter' AND oauth_uid = {$user_info->id}");  
		/* check user permission */
      	$query = mysql_query("SELECT id FROM users_whitelist WHERE username ='". $result['username'] . "'");        
        $val = mysql_fetch_array($query);          
        if(!empty($val)){
        	$isAuthor = $val['id'];
        }   
    }  

    $_SESSION['id'] = $result['id']; 
    $_SESSION['author'] = $isAuthor; 
    $_SESSION['username'] = $result['username']; 
    $_SESSION['oauth_uid'] = $result['oauth_uid']; 
    $_SESSION['oauth_provider'] = $result['oauth_provider']; 
    $_SESSION['oauth_token'] = $result['oauth_token']; 
    $_SESSION['oauth_secret'] = $result['oauth_secret']; 
    $_SESSION['avatar'] = $user_info->profile_image_url;  
    $_SESSION['name'] = $user_info->name;  
 
    header('Location: index.php');  
} 



} else {  
    // Something's missing, go back to square 1  
    header('Location: index.php');  
} 
?>
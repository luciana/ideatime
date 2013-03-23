 <?php
require("twitteroauth/twitteroauth/twitteroauth.php");  
include &#039;conn.php&#039;; 
session_start();

if(!empty($_GET[&#039;oauth_verifier&#039;]) && !empty($_SESSION[&#039;oauth_token&#039;]) && !empty($_SESSION[&#039;oauth_token_secret&#039;])){  
    // TwitterOAuth instance, with two new parameters we got in twitter_login.php  
	$twitteroauth = new TwitterOAuth(&#039;0sd51MbJuom5csE6xeYfw&#039;, &#039;suL2lwFTggjBMWRSev1uZDIutYy7vhhHo44DIOYs&#039;, $_SESSION[&#039;oauth_token&#039;], $_SESSION[&#039;oauth_token_secret&#039;]);  
	// Let&#039;s request the access token  
	$access_token = $twitteroauth->getAccessToken($_GET[&#039;oauth_verifier&#039;]); 
	// Save it in a session var 
	$_SESSION[&#039;access_token&#039;] = $access_token; 
	// Let&#039;s get the user&#039;s info 
	$user_info = $twitteroauth->get(&#039;account/verify_credentials&#039;); 
	// Print user&#039;s info  
	//print_r($user_info);
    /*stdClass Object ( [id] => 39792346 [geo_enabled] => [is_translator] => [profile_background_image_url] => http://a0.twimg.com/images/themes/theme1/bg.png [following] => [show_all_inline_media] => [profile_link_color] => 0084B4 [default_profile_image] => [profile_background_image_url_https] => https://si0.twimg.com/images/themes/theme1/bg.png [utc_offset] => -18000 [follow_request_sent] => [url] => http://lucianabruscino.com [name] => Luciana Bruscino [favourites_count] => 0 [profile_use_background_image] => 1 [created_at] => Wed May 13 17:03:22 +0000 2009 [protected] => [profile_text_color] => 333333 [id_str] => 39792346 [profile_sidebar_border_color] => C0DEED [profile_image_url] => http://a0.twimg.com/profile_images/1856607344/ipad_drawing_normal.png [profile_image_url_https] => https://si0.twimg.com/profile_images/1856607344/ipad_drawing_normal.png [description] => Enjoying life as it comes..... Enthusiastic about technology/web development... & Completely in love with my wonderful husband.. [followers_count] => 65 [location] => Cleveland [default_profile] => 1 [statuses_count] => 568 [time_zone] => Eastern Time (US & Canada) [profile_background_tile] => [friends_count] => 125 [lang] => en [profile_sidebar_fill_color] => DDEEF6 [screen_name] => luciana123_2002 [listed_count] => 1 [status] => stdClass Object ( [in_reply_to_user_id_str] => [coordinates] => [geo] => [favorited] => [id_str] => 230111568526966784 [retweet_count] => 0 [possibly_sensitive_editable] => 1 [retweeted] => [in_reply_to_status_id] => [possibly_sensitive] => [in_reply_to_screen_name] => [contributors] => [place] => [in_reply_to_user_id] => [truncated] => [source] => Tweet Button [created_at] => Tue Jul 31 01:24:07 +0000 2012 [in_reply_to_status_id_str] => [id] => 2.30111568527E+17 [text] => Check out this great #codecanyon item &#039;My Domain List Plugin&#039; #domaning http://t.co/S1XMoEK0 ) [notifications] => [contributors_enabled] => [verified] => [profile_background_color] => C0DEED )*/
	
	if(!empty($_SESSION[&#039;username&#039;])){  
	    // User is logged in, redirect  
	    header(&#039;Location: index.php&#039;);  
	} 

	if(isset($user_info->error)){  
    // Something&#039;s wrong, go back to square 1  
    	header(&#039;Location: error.php&#039;); 
	} else { 
    // Let&#039;s find the user by its ID  
    $query = mysql_query("SELECT * FROM users WHERE oauth_provider = &#039;twitter&#039; AND oauth_uid = ". $user_info->id);  
    $result = mysql_fetch_array($query);  
    $isAuthor = null;
  
    // If not, let&#039;s add it to the database  
    if(empty($result)){  
        $query = mysql_query("INSERT INTO users (oauth_provider, oauth_uid, username, oauth_token, oauth_secret) VALUES (&#039;twitter&#039;, {$user_info->id}, &#039;{$user_info->screen_name}&#039;, &#039;{$access_token[&#039;oauth_token&#039;]}&#039;, &#039;{$access_token[&#039;oauth_token_secret&#039;]}&#039;)");  
        $query = mysql_query("SELECT * FROM users WHERE id = " . mysql_insert_id());  
        $result = mysql_fetch_array($query);  
    } else {  
        // Update the tokens  
        $query = mysql_query("UPDATE users SET oauth_token = &#039;{$access_token[&#039;oauth_token&#039;]}&#039;, oauth_secret = &#039;{$access_token[&#039;oauth_token_secret&#039;]}&#039; WHERE oauth_provider = &#039;twitter&#039; AND oauth_uid = {$user_info->id}");  
		/* check user permission */
      	$query = mysql_query("SELECT id FROM users_whitelist WHERE username =&#039;". $result[&#039;username&#039;] . "&#039;");        
        $val = mysql_fetch_array($query);          
        if(!empty($val)){
        	$isAuthor = $val[&#039;id&#039;];
        }   
    }  

    $_SESSION[&#039;id&#039;] = $result[&#039;id&#039;]; 
    $_SESSION[&#039;author&#039;] = $isAuthor; 
    $_SESSION[&#039;username&#039;] = $result[&#039;username&#039;]; 
    $_SESSION[&#039;oauth_uid&#039;] = $result[&#039;oauth_uid&#039;]; 
    $_SESSION[&#039;oauth_provider&#039;] = $result[&#039;oauth_provider&#039;]; 
    $_SESSION[&#039;oauth_token&#039;] = $result[&#039;oauth_token&#039;]; 
    $_SESSION[&#039;oauth_secret&#039;] = $result[&#039;oauth_secret&#039;]; 
    $_SESSION[&#039;avatar&#039;] = $user_info->profile_image_url;  
    $_SESSION[&#039;name&#039;] = $user_info->name;  
 
    header(&#039;Location: index.php&#039;);  
} 



} else {  
    // Something&#039;s missing, go back to square 1  
    header(&#039;Location: index.php&#039;);  
} 
?> 
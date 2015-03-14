<?php

//widget output
if (!function_exists('get_theme_tweets')){
	function get_theme_tweets($username, $consumerkey, $consumerkeysecret, $accesstoken, $accesstokensecret, $notweets) {
					
					//check settings and die if not set
					if(empty($username) || empty($consumerkey) || empty($consumerkeysecret) || empty($accesstoken) || empty($accesstokensecret)){
						echo '<strong>Please fill all Twitter settings!</strong>';
						return;
					}
					
				 	//	yes, it needs update			
				
						
						if(!require_once('twitter_oauth.php')){ 
							echo '<strong>Couldn\'t find twitter_oauth.php!</strong>';
							return;
						}
													
						function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
						  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
						  return $connection;
						}
						  
						  							  
						$connection = getConnectionWithAccessToken($consumerkey, $consumerkeysecret, $accesstoken, $accesstokensecret);
						$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$username."&count=5") or die('Couldn\'t retrieve tweets! Wrong username?');
						
													
						if(!empty($tweets->errors)){
							if($tweets->errors[0]->message == 'Invalid or expired token'){
								echo '<strong>'.$tweets->errors[0]->message.'!</strong><br />You will need to regenerate it <a href="https://dev.twitter.com/apps" target="_blank">here</a>!' . $after_widget;
							}else{
								echo '<strong>'.$tweets->errors[0]->message.'</strong>' . $after_widget;
							}
							return;
						}
						
						for($i = 0;$i <= count($tweets); $i++){
							if(!empty($tweets[$i])){
								$tweets_array[$i]['created_at'] = $tweets[$i]->created_at;
								$tweets_array[$i]['text'] = $tweets[$i]->text;			
								$tweets_array[$i]['status_id'] = $tweets[$i]->id_str;			
							}	
						}
						set_transient('twitter-bar-tweets', $tweets_array, 0);				
								
				//convert links to clickable format
				function convert_links($status){
				 
					 
					// convert link to url
						$status = preg_replace_callback("/((http:\/\/|https:\/\/)[^ )]+)/i", 
							function($u) {
								return '<a href="'.$u[0].'" target="_blank">'. $u[0].'</a>'; 
							},
						$status);
					 
					// convert @ to follow
						$status = preg_replace_callback("/(@([_a-z0-9\-]+))/i", 
							function($u) {
								return '<a href="http://twitter.com/'.$u[2].'" title="Follow '.$u[1].'" target="_blank">'.$u[1].'</a>';
							},
						$status);
					 
					// convert # to search
						$status = preg_replace_callback("/(#([_a-z0-9\-]+))/i",
							function($u) {
								return '<a href="https://twitter.com/search?q='.$u[2].'" title="Search '.$u[0].'" target="_blank">'.$u[0].'</a>';
							},
						$status);
					 
					// return the status
						return $status;
				}
			
				//convert dates to readable format	
				function relative_time($a) {
					//get current timestampt
					$b = strtotime("now"); 
					//get timestamp when tweet created
					$c = strtotime($a);
					//get difference
					$d = $b - $c;
					//calculate different time values
					$minute = 60;
					$hour = $minute * 60;
					$day = $hour * 24;
					$week = $day * 7;
						
					if(is_numeric($d) && $d > 0) {
						//if less then 3 seconds
						if($d < 3) return "right now";
						//if less then minute
						if($d < $minute) return floor($d) . " seconds ago";
						//if less then 2 minutes
						if($d < $minute * 2) return "about 1 minute ago";
						//if less then hour
						if($d < $hour) return floor($d / $minute) . " minutes ago";
						//if less then 2 hours
						if($d < $hour * 2) return "about 1 hour ago";
						//if less then day
						if($d < $day) return floor($d / $hour) . " hours ago";
						//if more then day, but less then 2 days
						if($d > $day && $d < $day * 2) return "yesterday";
						//if less then year
						if($d < $day * 365) return floor($d / $day) . " days ago";
						//else return more than a year
						return "over a year ago";
					}
				}	
					
				
				//print tweets
				$tp_twitter_plugin_tweets = maybe_unserialize(get_transient('twitter-bar-tweets'));
				if(!empty($tp_twitter_plugin_tweets)){
						$fctr = '1';
						foreach($tp_twitter_plugin_tweets as $tweet){								
							print '<div>'.convert_links($tweet['text']).'</div>';
							if($fctr == $notweets){ break; }
							$fctr++;
						}
				}
		

	}
}	
?>
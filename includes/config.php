<?php
$CFG = array();
$uConfig = parse_ini_file('../config/config.dat');

include($uConfig['METABOX_PANEL_INCLUDES']."/lang/".$uConfig['METABOX_LANGUAGE'].".php");

function telegram_message($msg, $silent = false) {
	global $CFG, $uConfig;
    $data = array(
        'chat_id' => $uConfig['TELEGRAM_GROUPID'],
        'text' => $msg,
        'parse_mode' => 'html',
        'disable_web_page_preview' => true,
        'disable_notification' => $silent
    );
      $ch = curl_init('https://api.telegram.org/bot'.$uConfig['TELEGRAM_BOTID'].'/sendMessage');
      curl_setopt_array($ch, array(
          CURLOPT_HEADER => 0,
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_POST => 1,
          CURLOPT_POSTFIELDS => $data
      ));
      curl_exec($ch);
      curl_close($ch);
}

function discord_message($msg){
	
}

function email_message($msg){
	
}

function log_entry($msg){
	
}

function getAPIKey_ct($ctid) {
  global $CFG, $uConfig;
  $send = send_command($ctid, "/usr/bin/sudo /usr/bin/docker inspect $ctid", "docker_inspect_ct");
  $jDecode = json_decode($send, true);
	if(!empty($jDecode[0]['Mounts'])){
		
		foreach($jDecode[0]['Mounts'] as $mounts){
			if(strpos($mounts['Destination'], 'config') !== false) {
				 $send = send_command($ctid, "/usr/bin/sudo /usr/bin/docker exec $ctid cat ".$mounts['Destination']."/config.xml", "docker_inspect_ct");
				 $xml = simplexml_load_string($send, "SimpleXMLElement", LIBXML_NOCDATA);
				$json = json_encode($xml);
				$array = json_decode($json,TRUE);
					$ret = $array;
				}
			}
		}
   return $ret;
}

function dirToArray($dir) {
  
   $result = array();

   $cdir = scandir($dir);
   foreach ($cdir as $key => $value)
   {
      if (!in_array($value,array(".","..")))
      {
         if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
         {
            $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
         }
         else
         {
            $result[] = $value;
         }
      }
   }
  
   return $result;
}

function send_message($msg)
{
global $CFG, $uConfig;
	if($uConfig['METABOX_BOTS']){
		if(!empty($uConfig['TELEGRAM_BOTID']) && !empty($uConfig['TELEGRAM_GROUPID'])){
			$ret[] = telegram_message($msg);
		}
		if(!empty($uConfig['DISCORD_APIKEY']) && !empty($uConfig['DISCORD_SECRET'])){
			$ret[] = discord_message($msg);
		}
		if(!empty($email_smtp) && !empty($email_user)){
			$ret[] = email_message($msg);
		}
	}
	return json_encode($ret);
}



function docker_list()
{
    global $CFG;

    $command = "/usr/bin/sudo /usr/bin/docker ps -a | awk NR\>1 ";

    $result = send_command('', $command, "get_docker_list");
	$result = explode(PHP_EOL, $result);
	foreach($result as $results){
	if(!empty($results[0])){
		$ret[] = preg_split('/\s+/', $results); 
	} 
	} 
    log_entry(json_encode(array(
        "timeDate" => date("Y-m-d h:i:sa") ,
        "Command" => "get_ctid_list",
        "IPA" => $_SERVER['REMOTE_ADDR']
    )));
		
    return $ret;
}

function get_docker_name($docker_name){
$ret = explode('/', $docker_name);
$ret = ucwords(strtok($ret[1], ':'));
return $ret;
}

function appImage($imgName){
global $CFG;
if(!empty($imgName)){
$imgName = explode('/', $imgName);
$imgName = strtok($imgName[1], ':');

if(file_exists("assets/img/apps_images/".$imgName.".png")){
$ret = $imgName.".png";
}else{
$ret = "metaBox.png";
}
}
return $ret;
}

function docker_start($ctid)
{
    global $CFG;
    if (strlen($ctid) >= 13)
    {
        redirect("/", "Invalid Container ID Specified.", 5);
        die;
    }

    $command = "/usr/bin/sudo /usr/bin/docker start $ctid";

    $ret = send_command($ctid, $command, "start_docker_ct");
	if(trim($ret) == $ctid){
    log_entry(json_encode(array(
        "timeDate" => date("Y-m-d h:i:sa") ,
        "Command" => "docker_start_ct",
	"Status" => "successful",	
        "IPA" => $_SERVER['REMOTE_ADDR']
    )));
    if($uConfig['METABOX_BOTS']){
		send_message("Howdy! $ctid has been started by ".$_SERVER['REMOTE_ADDR'].".", "docker_start_ct");
	}
	redirect("/dash", "Container ".$ctid." Has Started Successfully.", 3);
	}elseif($ret !== $ctid){
    log_entry(json_encode(array(
        "timeDate" => date("Y-m-d h:i:sa") ,
        "Command" => "docker_start_ct",
	"Status" => "failed",	
        "IPA" => $_SERVER['REMOTE_ADDR']
    )));
    if($uConfig['METABOX_BOTS']){
		send_message("WHOA! $ctid failed to successfully start. ( ".$_SERVER['REMOTE_ADDR']." )", "docker_start_ct");
		redirect("/dash", "Container ".$ctid." Failed to Start.", 3);
	}
}
    return $ret;
}

function docker_stop($ctid)
{
    global $CFG;
    if (strlen($ctid) >= 13)
    {
        redirect("/", "Invalid Container ID Specified.", 5);
        die;
    }

    $command = "/usr/bin/sudo /usr/bin/docker stop $ctid";

    $ret = send_command($ctid, $command, "start_stop_ct");
	if(trim($ret) == $ctid){
    log_entry(json_encode(array(
        "timeDate" => date("Y-m-d h:i:sa") ,
        "Command" => "docker_stop_ct",
	"Status" => "successful",	
        "IPA" => $_SERVER['REMOTE_ADDR']
    )));
    if($uConfig['METABOX_BOTS']){
		send_message("Howdy! $ctid has been stopped by ".$_SERVER['REMOTE_ADDR'].".", "docker_stop_ct");
	}
	redirect("/dash", "Container ".$ctid." Has Stopped Successfully.", 3);
	}elseif($ret !== $ctid){
    log_entry(json_encode(array(
        "timeDate" => date("Y-m-d h:i:sa") ,
        "Command" => "docker_stop_ct",
	"Status" => "failed",	
        "IPA" => $_SERVER['REMOTE_ADDR']
    )));
    if($uConfig['METABOX_BOTS']){
		send_message("WHOA! $ctid failed to successfully stop. ( ".$_SERVER['REMOTE_ADDR']." )", "docker_stop_ct");
		redirect("/dash", "Container ".$ctid." Failed to Stop.", 3);
	}
	}
    return $ret;
}

function docker_exec($ctid, $cmd)
{
    global $CFG;
    if (strlen($ctid) >= 13)
    {
        redirect("/", "Invalid Container ID Specified.", 5);
        die;
    }

    $command = "/usr/bin/docker exec $ctid $cmd";

    $ret = send_command($command);
    log_entry(json_encode(array(
        "timeDate" => date("Y-m-d h:i:sa") ,
        "CTID" => $ctid,
        "Command" => "docker_exec",
        "IPA" => $_SERVER['REMOTE_ADDR']
    )));
    if($uConfig['METABOX_BOTS']){
		send_message("Hey! $CTID has had a manual command sent to it by ".$_SERVER['REMOTE_ADDR'].".", "docker_exec_custom");
	}
    return $ret;
}

function docker_inspect($ctid)
{
    global $CFG;
    if (strlen($ctid) >= 13)
    {
        redirect("/", "Invalid Container ID Specified.", 5);
        die;
    }
    $command = "/usr/bin/docker inspect $ctid";

    $ret = send_command($command);
    log_entry(json_encode(array(
        "timeDate" => date("Y-m-d h:i:sa") ,
        "CTID" => $ctid,
        "Command" => "docker_inspect",
        "IPA" => $_SERVER['REMOTE_ADDR']
    )));
    if($uConfig['METABOX_BOTS']){
		send_message("Guess what! $CTID just got 'inspected'.. ", "docket_inspect_ctid");
	}
    return $ret;
}


function docker_create_ct($CTName, $CTImage)
{
    global $CFG;

    $command = "/usr/bin/sudo /usr/bin/docker create --name $CTName $CTImage";

    $ret = send_command("", $command, "docker_create_ct");
	if(strlen(trim($ret)) == 64){
    log_entry(json_encode(array(
        "timeDate" => date("Y-m-d h:i:sa") ,
        "Command" => "docker_create_ct",
	"Status" => "successful",
	"CTName" => $CTName,	
	"CTImage" => $CTImage,
	"FullCTID" => $ret,
        "IPA" => $_SERVER['REMOTE_ADDR']
    )));
    if($uConfig['METABOX_BOTS']){
		send_message("YAY! Welcome to the family! $CTName has been created, running $CTImage . (".$_SERVER['REMOTE_ADDR'].")", "docker_create_ct");
	}
	redirect("/dash", "Container ".$CTName." has been created successfully!", 3);
	}else{
    log_entry(json_encode(array(
        "timeDate" => date("Y-m-d h:i:sa") ,
        "Command" => "docker_create_ct",
	"Status" => "failed",	
        "IPA" => $_SERVER['REMOTE_ADDR']
    )));
    if($uConfig['METABOX_BOTS']){
		send_message("Oh no! Container $CTName failed to create! :-( ( ".$_SERVER['REMOTE_ADDR']." )", "docker_create_ct");
		redirect("/dash", "Container ".$CTName." Failed creation", 3);
	}
	}
    return $ret;
}

function docker_delete_ct($ctid)
{
    global $CFG;

    $command = "/usr/bin/sudo /usr/bin/docker rm --force $ctid";

    $ret = send_command($ctid, $command, "docker_delete_ct");
	if(trim($ret) == $ctid){
    log_entry(json_encode(array(
        "timeDate" => date("Y-m-d h:i:sa") ,
        "Command" => "docker_delete_ct",
	"Status" => "successful",
	"ctid" => $ctid,	
        "IPA" => $_SERVER['REMOTE_ADDR']
    )));
    if($uConfig['METABOX_BOTS']){
		send_message("Container ".$ctid." has been removed. . (".$_SERVER['REMOTE_ADDR'].")", "docker_delete_ct");
	}
	redirect("/dash", "Container ".$ctid." has been removed successfully!", 3);
	}else{
    log_entry(json_encode(array(
        "timeDate" => date("Y-m-d h:i:sa") ,
        "Command" => "docker_delete_ct",
	"Status" => "failed",
	"ctid" => $ctid,	
        "IPA" => $_SERVER['REMOTE_ADDR']
    )));
    if($uConfig['METABOX_BOTS']){
		send_message("Oh no! Container $CTName failed to remote! :-( ( ".$_SERVER['REMOTE_ADDR']." )", "docker_delete_ct");
		redirect("/dash", "Container ".$CTName." Failed Removal!", 3);
	}
	}
    return $ret;
}


function docker_stats($ctid)
{
    global $CFG;
    if (strlen($ctid) >= 13)
    {
        redirect("/", "Invalid Container ID Specified.", 5);
        die;
    }

    $command = "/usr/bin/docker stats $ctid --no-stream";
    $ret = send_command($command);
    log_entry(json_encode(array(
        "timeDate" => date("Y-m-d h:i:sa") ,
        "CTID" => $ctid,
        "Command" => "get_ct_stats",
        "IPA" => $_SERVER['REMOTE_ADDR']
    )));
    if($uConfig['METABOX_BOTS']){
		send_message("STATS", "get_ctid_stats");
	}
    return $ret;
}

function docker_ports($ctid)
{
    global $CFG;
    if (strlen($ctid) >= 13)
    {
        redirect("/", "Invalid Container ID Specified.", 5);
        die;
    }

    $command = "/usr/bin/docker port $ctid";
    $ret = send_command($command);
    log_entry(json_encode(array(
        "timeDate" => date("Y-m-d h:i:sa") ,
        "CTID" => $ctid,
        "Command" => "get_ct_port",
        "IPA" => $_SERVER['REMOTE_ADDR']
    )));
    if($uConfig['METABOX_BOTS']){
		send_message("I'm chill.. just looking at some ports!", "get_ctid_ports");
	}
    return $ret;
}

function send_command($ctid, $command, $short)
{
    global $CFG;
    if (!empty($ctid) && strlen($ctid) >= 13)
    {
        redirect("/", "Invalid Container ID Specified.", 5);
        die;
    }
if(empty($ctid)){ $ctid = "NULL"; }
	
    $action = shell_exec($command);
    log_entry(json_encode(array(
        "timeDate" => date("Y-m-d h:i:sa") ,
        "CTID" => $ctid,
        "Command" => $short,
        "Action" => $command,
        "IPA" => $_SERVER['REMOTE_ADDR']
    )));
    if($uConfig['METABOX_BOTS']){
		if($short != "get_docker_list"){
		send_message("".$short.": Command Successful.");
		}
	}
    return $action;
}
function verify_login($username, $password)
{
global $CFG, $uConfig;
    if (empty($username) || empty($password)) return false;
		if($uConfig['METABOX_USERNAME'] == $username){
		if($uConfig['METABOX_PASSWORD'] == md5($password)){
			$ret = array("userName" => $uConfig['METABOX_USERNAME'], "password" => $uConfig['METABOX_PASSWORD']);
			log_entry(json_encode(array("timeDate" => date("Y-m-d h:i:sa"), "Command" => "user_login", "IPA" => $_SERVER['REMOTE_ADDR'] )));
   			 if($uConfig['METABOX_BOTS']){ send_message("Successful Login via metaBox WebUI (".$_SERVER['REMOTE_ADDR'].")"); }
		}else{
			$ret = FALSE;
		}
	}    
    return $ret;
}
function is_logged_in()
{
    global $_SESSION;
    return isset($_SESSION['userName']) && !empty($_SESSION['password']) && nvl($_SESSION["ip"]) == $_SERVER["REMOTE_ADDR"];
}

function require_login()
{
    global $CFG, $_SESSION;

    if (!is_logged_in())
    {
        $_SESSION["wantsurl"] = qualified_me();
        redirect("/login");
    }
}

function nvl(&$var, $default = "")
{
    return isset($var) ? $var : $default;
}

function evl(&$var, $default = "")
{
    return empty($var) ? $var : $default;
}

function ov(&$var)
{
    return o(nvl($var));
}

function pv(&$var)
{
    p(nvl($var));
}

function o($var)
{
    return empty($var) ? "" : htmlSpecialChars(stripslashes($var));
}

function p($var)
{
    echo o($var);
}

function redirect($url, $message = "", $delay = 0)
{
    echo "<meta http-equiv='Refresh' content='$delay; url=$url'>";
    if (!empty($message)) echo "<br><br><br><br><br><div style='font-family: Arial, Sans-serif; font-size: 20pt;' align=center>$message</div>";
    die;
}

?>

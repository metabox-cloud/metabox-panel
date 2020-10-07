<?php
include "includes/config.php";
switch (nvl($_REQUEST["act"]))
{

    case "logs":
	global $CFG, $uConfig, $_SESSION;
        if (!is_logged_in())
        {
            redirect("/login", "This page is for logged in users only. Please login before accessing.", 3);
            die;
        }
        include $uConfig['METABOX_PANEL_TEMPLATES']."/header.php";
        include $uConfig['METABOX_PANEL_TEMPLATES']."/logs.php";
        include $uConfig['METABOX_PANEL_TEMPLATES']."/footer.php";
    break;
		
    case "mounts":
	global $CFG, $uConfig, $_SESSION;
        if (!is_logged_in())
        {
//            redirect("/login", "This page is for logged in users only. Please login before accessing.", 3);
//            die;
        }
		if(isset($_POST['cmd']) && $_POST['cmd'] == "addMount"){
			
		}
		
		if(isset($_POST['cmd']) && $_POST['cmd'] == "deleteMount"){
			
		}
		
        include $uConfig['METABOX_PANEL_TEMPLATES']."/header.php";
        include $uConfig['METABOX_PANEL_TEMPLATES']."/mounts.php";
        include $uConfig['METABOX_PANEL_TEMPLATES']."/footer.php";
    break;
		
    case "mount":
	global $CFG, $uConfig, $_SESSION;
        if (!is_logged_in())
        {
//            redirect("/login", "This page is for logged in users only. Please login before accessing.", 3);
//            die;
        }
		
		if(isset($_POST['cmd']) && $_POST['cmd'] == "startMount"){
			
		}
		
		if(isset($_POST['cmd']) && $_POST['cmd'] == "stopMount"){
			
		}
		
		if(isset($_POST['cmd']) && $_POST['cmd'] == "enableMount"){
			
		}
		
		if(isset($_POST['cmd']) && $_POST['cmd'] == "disableMount"){
			
		}
		
		if(isset($_POST['cmd']) && $_POST['cmd'] == "editMount"){
			
		}
	
		if(isset($_POST['cmd']) && $_POST['cmd'] == "showSA"){
			
		}

        include $uConfig['METABOX_PANEL_TEMPLATES']."/header.php";
		if($_GET['service'] == 'gdrive'){
			include $uConfig['METABOX_PANEL_TEMPLATES']."/mount.gdrive.php";
		}elseif($_GET['service'] == 'mega'){
			include $uConfig['METABOX_PANEL_TEMPLATES']."/mount.mega.php";
		}
        include $uConfig['METABOX_PANEL_TEMPLATES']."/footer.php";
    break;
	
    case "test":
	
			$a = getAPIKey_ct("c256bec2190c");
			print_r($a);
			die;
	
	break;
    case "traktarr":
	global $CFG, $uConfig, $_SESSION;	
        if (!is_logged_in())
        {
          //  redirect("/login", "This page is for logged in users only. Please login before accessing.", 3);
         //   die;
        }
		if(!isset($_POST['cmd'])){
        include $uConfig['METABOX_PANEL_TEMPLATES']."/header.php";
        include $uConfig['METABOX_PANEL_TEMPLATES']."/traktarr.php";
        include $uConfig['METABOX_PANEL_TEMPLATES']."/footer.php";
		die;
		}
		if($_POST['cmd'] == "deleteList"){
				if(!empty($_POST['id'])){
					$file = $uConfig['METABOX_TRAKTARR']."/list/".stripslashes($_POST['id']);
					if(file_exists($file)){
						unlink($file);
						redirect("/traktarr", "List Removed Successfully", 2);
						send_message("Traktarr: Removed List Successfully (".$_GET['id'].")");
					}else{
						redirect("/traktarr", "ERROR: File does not exist", 2);
					}
				}else{
					redirect("/traktarr", "ERROR: Invalid List ID", 2);
				}
		}
		
		if($_POST['cmd'] == "deleteConf"){
				if(!empty($_POST['id'])){
					$file = $uConfig['METABOX_TRAKTARR']."/config/".stripslashes($_POST['id']);
					if(file_exists($file)){
						unlink($file);
						redirect("/traktarr", "Config Removed Successfully", 2);
						send_message("Traktarr: Config Removed Successfully ".$_GET['id'].")");
					}else{
						redirect("/traktarr", "ERROR: File does not exist", 2);
					}
				}else{
					redirect("/traktarr", "ERROR: Invalid Config ID", 2);
				}
		}
		
		if($_POST['cmd'] == "addConfig"){
			if(empty($_POST['global']['trakt']['client_id'])){
				redirect("/traktarr", "Error: Invalid Trakt.tv Client ID", 2);
				die;
			}
			if(empty($_POST['global']['trakt']['client_secret'])){
				redirect("/traktarr", "Error: Invalid Trakt.tv Client Secret", 2);
				die;
			}
			if(empty($_POST['movies']['api_key'])){
				redirect("/traktarr", "Error: Invalid Radarr API Key", 2);
				die;
			}
			if(empty($_POST['movies']['url'])){
				redirect("/traktarr", "Error: Invalid Radarr URL", 2);
				die;
			}
			if(empty($_POST['movies']['blacklisted_min_year'])){
				redirect("/traktarr", "Error: Invalid Radarr Minimum Year", 2);
				die;
			}
			if(empty($_POST['movies']['blacklisted_max_year'])){
				redirect("/traktarr", "Error: Invalid Radarr Maximum Year", 2);
				die;
			}
			if(empty($_POST['movies']['minimum_availability'])){
				redirect("/traktarr", "Error: Invalid Radarr Minimum Availability", 2);
				die;
			}
			if(empty($_POST['movies']['quality'])){
				redirect("/traktarr", "Error: Invalid Radarr Quality Profile", 2);
				die;
			}
			if(empty($_POST['movies']['root_folder'])){
				redirect("/traktarr", "Error: Invalid Radarr Root Folder", 2);
				die;
			}
			if(empty($_POST['shows']['api_key'])){
				redirect("/traktarr", "Error: Invalid Sonarr API Key", 2);
				die;
			}
			if(empty($_POST['shows']['url'])){
				redirect("/traktarr", "Error: Invalid Sonarr URL", 2);
				die;
			}
			if(empty($_POST['shows']['blacklisted_min_year'])){
				redirect("/traktarr", "Error: Invalid Sonarr Minimum Year", 2);
				die;
			}
			if(empty($_POST['shows']['blacklisted_max_year'])){
				redirect("/traktarr", "Error: Invalid Sonarr Maximum Year", 2);
				die;
			}
			if(empty($_POST['shows']['quality'])){
				redirect("/traktarr", "Error: Invalid Sonarr Quality Profile", 2);
				die;
			}
			if(empty($_POST['shows']['root_folder'])){
				redirect("/traktarr", "Error: Invalid Sonarr Root Folder.", 2);
				die;
			}
			$file = $uConfig['METABOX_TRAKTARR']."/config/".stripslashes($_POST['configName']).".json";
			$tempFile = $uConfig['METABOX_PANEL']."/includes/default/traktarr.default.json";
			
			$default = file_get_contents($tempFile);
			
			$modded = str_replace("RADARRMAXYEAR", $_POST['movies']['blacklisted_max_year'], $default);
			$modded = str_replace("RADARRMINYEAR", $_POST['movies']['blacklisted_min_year'], $modded);
			$modded = str_replace("SONARRMAXYEAR", $_POST['shows']['blacklisted_max_year'], $modded);
			$modded = str_replace("SONARRMINYEAR", $_POST['shows']['blacklisted_min_year'], $modded);
			$modded = str_replace("OMDBKEY", $_POST['global']['omdb'], $modded);
			$modded = str_replace("RADARRAPIKEY", $_POST['movies']['api_key'], $modded);
			$modded = str_replace("RADARRMINAVAILABILITY", $_POST['movies']['minimum_availability'], $modded);
			$modded = str_replace("RADARRQUALITY", $_POST['movies']['quality'], $modded);
			$modded = str_replace("RADARRROOT", "", $modded);
			$modded = str_replace("RADARRURL", $_POST['movies']['url'], $modded);
			$modded = str_replace("SONARRAPIKEY", $_POST['shows']['api_key'], $modded);
			$modded = str_replace("SONARRQUALITY", $_POST['shows']['quality'], $modded);
			$modded = str_replace("SONARRROOT", $_POST['shows']['root_folder'], $modded);
			$modded = str_replace("SONARRURL", $_POST['shows']['url'], $modded);
			$modded = str_replace("TRAKTID", $_POST['global']['trakt']['client_id'], $modded);
			$modded = str_replace("TRAKTSECRET", $_POST['global']['trakt']['client_secret'], $modded);

			file_put_contents($file, $modded);
			
			redirect("/traktarr", "Config Created Successfully", 2);
			send_message("Traktarr: New Config Added (".$_GET['id'].")");
		}	
		if($_POST['cmd'] == "addList"){
				if(empty($_POST['listName'])){
					redirect("/traktarr", "Invalid List Name", 2);
					die;
				}
				if(empty($_POST['listURL'])){
					redirect("/traktarr", "Invalid URL", 2);
					die;
				}
				if (strpos($_POST['listURL'], 'trakt.tv') == false) {
					redirect("/traktarr", "Invalid URL", 2);
				}
				if(empty($_POST['listConfig'])){
					redirect("/traktarr", "Invalid Config Specified", 2);
					die;
				}
				$file = $uConfig['METABOX_TRAKTARR']."/list/".stripslashes($_POST['listName']).".json";
				if(!file_exists($file)){
				$prep = json_encode(array("listName" => stripslashes($_POST['listName']), "listURL" => $_POST['listURL'], "listConfig" => $_POST['listConfig']));
				$open = fopen($file, "a+");
				fwrite($open,$prep);
				fclose($open);
				redirect("/traktarr", "List Created Successfully", 2);
				send_message("Traktarr: New List Created  (".$_GET['id'].")");
				}else{
					redirect("/traktarr", "List Name already Exists.", 2);
					die;
				}					
		}			
			
		
    break;

    case "log":
        if (!is_logged_in())
        {
            redirect("/login", "This page is for logged in users only. Please login before accessing.", 3);
            die;
        }
        if (is_numeric($_GET['id']))
        {
            die('invalid log id');
        }
        if (strlen($_GET['id']) <= '10')
        {
            die('invalid log id');
        }
        if (empty($_GET['id']))
        {
            die('invalid log id');
        }
        if (!isset($_GET['id']))
        {
            die('invalid log id');
        }
        include $uConfig['METABOX_PANEL_TEMPLATES']."/header.php";
        include $uConfig['METABOX_PANEL_TEMPLATES']."/logs.php";
        include $uConfig['METABOX_PANEL_TEMPLATES']."/footer.php";
    break;

    case "doCommand":
	global $CFG, $uConfig, $_SESSION;
if(isset($_POST['ctid'])){
    if (strlen($_POST['ctid']) >= 13){
        redirect("/", "Invalid Container ID Specified.", 5);
        die;
    }
}
	if($_POST['cmd'] == "start"){
		$action = docker_start($_POST['ctid']);
	}

	if($_POST['cmd'] == "stop"){
		$action = docker_stop($_POST['ctid']);
	}

	if($_POST['cmd'] == "create"){
		$action = docker_create_ct($_POST['ctname'], $_POST['image']);
	}

	if($_POST['cmd'] == "delete"){
		$action = docker_delete_ct($_POST['ctid']);
	}


    break;

    case "config":
	global $CFG, $uConfig, $_SESSION;
        if (!is_logged_in())
        {
           // redirect("/login", "This page is for logged in users only. Please login before accessing.", 3);
          //  die;
        }
        include $uConfig['METABOX_PANEL_TEMPLATES']."/header.php";
        include $uConfig['METABOX_PANEL_TEMPLATES']."/config.php";
        include $uConfig['METABOX_PANEL_TEMPLATES']."/footer.php";
    break;

    case "backup":
        if (!is_logged_in())
        {
            redirect("/login", "This page is for logged in users only. Please login before accessing.", 3);
            die;
        }
        include $uConfig['METABOX_PANEL_TEMPLATES']."/header.php";
        include $uConfig['METABOX_PANEL_TEMPLATES']."/backup.php";
        include $uConfig['METABOX_PANEL_TEMPLATES']."/footer.php";
    break;

    case "login":
        include $uConfig['METABOX_PANEL_TEMPLATES']."/login.php";
    break;

    case "doLogin":
	global $CFG, $uConfig, $_SESSION;
	session_start();
        if (isset($_POST["username"]) && isset($_POST["password"]))
        {
            $user = verify_login($_POST["username"], $_POST["password"]);
            if ($user)
            {
                $_SESSION["userName"] = $user['userName'];
                $_SESSION["password"] = $user['password'];
                $_SESSION["ip"] = $_SERVER["REMOTE_ADDR"];
	            redirect("/dash", "", 0);
                die;
            }
            else
            {
				log_entry(json_encode(array("timeDate" => date("Y-m-d h:i:sa"), "Command" => "failed_login_attempt", "IPA" => $_SERVER['REMOTE_ADDR'])));
				send_message("Failed Login Attempt Detected: ".date("Y-m-d h:i:sa")." <br />Time: <br />IP: ".$_SERVER['REMOTE_ADDR']."");
                redirect("/login", "Unsuccessful Login.. Please try again", 2);
            }
        }
    break;

    case "logout":
	global $CFG, $uConfig, $_SESSION;
	session_start();
        if (!is_logged_in())
        {
            redirect("/login", "You cannot logout.... you already have logged out.. THE WORLD IS ENDING!", 3);
            die;
        }

        session_destroy();
        header("Location: /login");
    break;

    case "dash":
	global $CFG, $uConfig, $_SESSION;
	print_r($_SESSION);
        include $uConfig['METABOX_PANEL_TEMPLATES']."/header.php";
        include $uConfig['METABOX_PANEL_TEMPLATES']."/dash.php";
        include $uConfig['METABOX_PANEL_TEMPLATES']."/footer.php";
    break;

    default:
	if(!isset($uConfig['METABOX_INSTALLED'])){
	 include $uConfig['METABOX_PANEL']."/install/install.php";
	  }else{
		  if(!is_logged_in()){
			include $uConfig['METABOX_PANEL_TEMPLATES']."/login.php";  
		  }else{
			 redirect("/dash", "", 0);
			
		  }
	  }
    break;
}

?>

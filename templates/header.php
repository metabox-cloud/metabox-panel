<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?=$uConfig['METABOX_WEBNAME']?> :: <?=$lang['QUIP']?></title>

  <!-- Bootstrap core CSS -->
  <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- Custom styles for this template -->
  <link href="/assets/css/heroic-features.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="/dash"><?=$uConfig['METABOX_WEBNAME']?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
	  
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/dash"><?=$lang['HOME_TITLE']?>
              <span class="sr-only">(current)</span>
            </a>
          </li>
		    <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?=$lang['MOUNTS_TITLE']?></a>
    <div class="dropdown-menu">
	<a class="dropdown-item" href="/mounts"><?=$lang['ADD_REM_MOUNT']?></a>
	    <div class="dropdown-divider"></div>
	<?php 
	$i = 0;
	foreach($uConfig as $key=>$value){
		if("METABOX_GD_TD" == substr($key,0,13)){
			if(!empty($value)){
			$gdArray[$i]['td'] = $value;
			}
		}
		if("METABOX_GD_NAME" == substr($key,0,15)){
			if(!empty($value)){
			$gdArray[$i]['name'] = $value;
			}
		}
		if("METABOX_GD_ENCRYPT" == substr($key,0,18)){
			if(!empty($value)){
			$gdArray[$i]['encrypted'] = $value;
			$i++;
			}
		}
	}	
		foreach($gdArray as $gDrive){ 
		if($gDrive['encrypted'] == "UNENCRYPTED"){
			$encrypt = "";
		}else{
			$encrypt = "(e)";
		}
			echo "<a class=\"dropdown-item\" href=\"/mount/gdrive/".$gDrive['td']."\">GD: ".$gDrive['name']." ".$encrypt."</a>";
		} 
		echo "<div class=\"dropdown-divider\"></div>";
		foreach($uConfig as $key=>$value){
		if("METABOX_MEGA_USER" == substr($key,0,17)){
			if(!empty($value)){
			echo "<a class=\"dropdown-item\" href=\"/mount/mega/".$value."\">MEGA: ".$value."</a>";
			}
		}
	} 
?>
    </div>
  </li>
		  <li class="nav-item">
            <a class="nav-link" href="/logs"><?=$lang['LOGS_TITLE']?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="modal" data-target="#services"><?=$lang['SERVICE_TITLE']?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/traktarr">Traktarr</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#"><?=$lang['UPDATES_TITLE']?></a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="/config"><?=$lang['CONFIG_TITLE']?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="modal" data-target="#backup"><?=$lang['BACKUP_TITLE']?></a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="/logout"><?=$lang['LOGOUT_TITLE']?></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

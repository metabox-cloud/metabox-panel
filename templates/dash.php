<?php
$result = docker_list();
$cArray = array();
$i = 0;

foreach($result as $calc){
$cArray[$i]['CTID'] = $calc['0'];
$cArray[$i]['Image'] = $calc['1'];
$cArray[$i]['Command'] = $calc['2'];
if($calc['3'] == "About"){ unset($calc['3']);  $calc= array_values($calc); }
$cArray[$i]['Created'] = $calc['3']. " ".$calc['4']." ".$calc['5'];
if (strpos($calc[6], 'Up') !== false) {
$cArray[$i]['Status'] = $calc['6']. " ".$calc['7']." ".$calc['8'];
$start = 8;
$arrayCount = (count($calc)-2);
while($start != $arrayCount){
$start++;
$cArray[$i]['Port'][] = $calc[$start];
}
}else{
 $cArray[$i]['Port'][] = "0.0.0.0:0000->0000/tcp";
}
$cArray[$i]['Name'] = end($calc);

$i++;
}
?>

  <!-- Page Content -->
  <div class="container">


    <!-- Jumbotron Header -->
<br />
    <!-- Page Features -->
    <div class="row text-center">
<?php 
$i = 0;
foreach($cArray as $r) { 
if(strpos(end($r),"rclone_gd_")!==false){ }else{
if (strpos($r['Status'], 'Up') !== false) {
    $cStatus = "<font color=\"green\"><b>".$lang['ONLINE']."</b></font>";
}else{
    $cStatus = "<font color=\"red\"><b>".$lang['OFFLINE']."</b></font>";
}
?>
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-80">
          <!--<img class="card-img-top" src="/assets/img/apps_images/<?=appImage($r['Image'])?>" alt="">-->
          <div class="card-body">
            <h4 class="card-title"><?=$r['Name']?></h4>
			<p class="card-text"><?=$lang['STATUS']?>: <?=$cStatus?></p>
            		<p class="card-text"><?=$lang['UPTIME']?>: <?=$r['Status']?></p>
          </div>
          <div class="card-footer">
		  <div class="dropdown">
            <button class="btn btn-success" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$lang['WEBUI']?></button>
			  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
<?php 
foreach($r['Port'] as $ports){ 
$ePort = explode(':', $ports);
$port = strtok($ePort[1] , '-');
?>

				<a class="dropdown-item" href="http://<?=$uConfig['METABOX_SUBDOMAIN']?>:<?=$port?>"><?=$lang['PORT']?>: <?=$port?></a>
<?php } ?>
			  </div>
		   </div>
			<?php if(strpos($r['Status'], 'Up') !== false){ ?>
			<button type="button" class="btn btn-primary" disabled><?=$lang['START_CT']?></button>
			<?php }else{ ?>
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#start<?=$r['CTID']?>"><?=$lang['START_CT']?></button>
			<?php 
			} 
			if(strpos($r['Status'], 'Up') !== false){
			?>
            		<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#stop<?=$r['CTID']?>"><?=$lang['STOP_CT']?></button>
			<?php }else{ ?>
			<button type="button" class="btn btn-danger" disabled><?=$lang['STOP_CT']?></button>
			<?php } ?>
          </div>
        </div>
      </div>
<div class="modal fade" id="start<?=$r['CTID']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?=$lang['START_CT_FULL']?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	<form action="/" method="post">
	<input type="hidden" name="act" value="doCommand" />
	<input type="hidden" name="cmd" value="start" />
	<input type="hidden" name="ctid" id="ctid" value="<?=$r['CTID']?>" />
	<button type="submit" class="btn btn-primary"><?=$lang['START_CT_FULL']?></button>
	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$lang['MODAL_CLOSE']?></button>
        
      </div>
    </div>
  </div>
</div>	

<div class="modal fade" id="stop<?=$r['CTID']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?=$lang['STOP_CT_FULL']?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	<form action="/" method="post">
	<input type="hidden" name="act" value="doCommand" />
	<input type="hidden" name="cmd" value="stop" />
	<input type="hidden" name="ctid" id="ctid" value="<?=$r['CTID']?>" />
	<button type="submit" class="btn btn-danger"><?=$lang['STOP_CT_FULL']?></button>
	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$lang['MODAL_CLOSE']?></button>
        
      </div>
    </div>
  </div>
</div>	

<?php
if( ($i+1)%4 == 0){
echo "</div>";
echo "<!-- /.row -->";
echo "<div class=\"row text-center\">";
}
$i++;
 } 
}
?>


  </div></div>
  <!-- /.container -->



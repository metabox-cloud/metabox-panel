  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white"><?=$lang['COPYRIGHT']?> &copy; <?=$uConfig['METABOX_WEBNAME']?> <?=date('Y')?></p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="/assets/vendor/jquery/jquery.min.js"></script>
  <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<div class="modal fade" id="services" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?=$lang['SERVICE_QUESTION']?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

<a class="btn btn-primary btn-block" data-dismiss="modal" data-toggle="modal" href="#addService"><?=$lang['SERVICE_ADD']?></a>
<br /><br />
<a class="btn btn-danger btn-block"data-dismiss="modal" data-toggle="modal" href="#delService"><?=$lang['SERVICE_REMOVE']?></a>

      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="delService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?=$lang['DEL_SERVICE']." ".$uConfig['METABOX_WEBNAME']?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/" method="post">
	<input type="hidden" name="act" value="doCommand" />
	<input type="hidden" name="cmd" value="delete" />

<select name="ctid" class="custom-select" required>
  <option selected disabled><?=$lang['DEL_CT_SELECT']?></option>
<?php
foreach($result as $calc){
if(strpos(end($calc),"rclone_gd_")!==false){ }else{
echo "  <option value=\"".$calc['0']."\">".end($calc)." (CTID: ".$calc['0'].")</option>";
}
}
?>
</select>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$lang['MODAL_CLOSE']?></button>
        <button type="submit" class="btn btn-danger"><?=$lang['MODAL_DELETE']?></button>
</form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="addService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?=$lang['ADD_SERVICE']?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/" method="post">
	<input type="hidden" name="act" value="doCommand" />
	<input type="hidden" name="cmd" value="create" />
  <div class="form-group">
    <label for="exampleInputEmail1"><?=$lang['ADD_CT_NAME']?></label>
    <input type="text" class="form-control" name="ctname" aria-describedby="emailHelp" placeholder="<?=$lang['ADD_CT_PLACEHOLDER']?>" required>
    <small id="emailHelp" class="form-text text-muted"><?=$lang['ADD_CT_NOTE']?></small>
  </div>
<select class="custom-select" name="image" required>
  <option selected disabled><?=$lang['ADD_CT_IMAGE']?></option>
<?php
$ctList = file_get_contents("includes/docker_containers.dat");
$cSort = explode(PHP_EOL, $ctList);
foreach($cSort as $cSorting){
if(strpos($cSorting, '::') !== false ){
	$catList[] = str_replace('::', '', $cSorting);
}else{
	$iList[] = $cSorting;
}
}
foreach($catList as $cList){
echo "<optgroup label=\"".$cList."\">";
foreach($iList as $imgList){
	$imgSort = explode("|", $imgList);
	if($imgSort[0] == $cList){
	echo "<option value=\"".$imgSort[2]."\">".$imgSort[1]." ( ".$imgSort[2]." )</option>";
}
}


echo "</optgroup>";
}

?>
</select>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$lang['MODAL_CLOSE']?></button>
        <button type="submit" class="btn btn-primary"><?=$lang['MODAL_CREATE']?></button>
</form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="backup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?=$uConfig['METABOX_WEBNAME']." ".$lang['BACKUP_MODAL_TITLE']?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col"><?=$lang['BACKUP_DATE']?></th>
      <th scope="col"><?=$lang['BACKUP_NAME']?></th>
      <th scope="col"><?=$lang['BACKUP_ACT']?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td><?=date("y-m-d")?></td>
      <td>backup-metabox-<?=date("y-m-d")?>.gz</td>
      <td><a href="#"><?=$lang['BACKUP_DOWNLOAD']?></a> - <a href="#"><?=$lang['BACKUP_DELETE']?></a> - <a href="#"><?=$lang['BACKUP_RESTORE']?></a></td>
    </tr>
    <tr>
      <th scope="row">1</th>
      <td><?=date("y-m-d")?></td>
      <td>backup-metabox-<?=date("y-m-d")?>.gz</td>
      <td><a href="#"><?=$lang['BACKUP_DOWNLOAD']?></a> - <a href="#"><?=$lang['BACKUP_DELETE']?></a> - <a href="#"><?=$lang['BACKUP_RESTORE']?></a></td>
    </tr>
  </tbody>
</table>
      </div>
      <div class="modal-footer">
	<button type="button" class="btn btn-block btn-primary"><?=$lang['BACKUP_CREATE']?></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$lang['MODAL_CLOSE']?></button>
      </div>
    </div>
  </div>
</div>

</body>

</html>

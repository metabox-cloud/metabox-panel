<?php
$TDSearch = preg_replace('/[^0-9]/', '', array_search($_GET['id'], $uConfig));
$SADir = $uConfig['METABOX_SA_DIR']."/".$uConfig['METABOX_GD_NAME_'.$TDSearch.'']."/keys";
$SAList = dirToArray($SADir);
?>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <!-- Post Content Column -->
      <div class="col-lg-8">

        <!-- Title -->
        <h2 class="mt-4">Google Drive: <?=$uConfig['METABOX_GD_NAME_'.$TDSearch.'']?></h2> <small><a href="https://drive.google.com/drive/folders/<?=$uConfig['METABOX_GD_TD_'.$TDSearch.'']?>" class="btn btn-sm btn-primary" target="_blank">Team Drive: <?=$uConfig['METABOX_GD_TD_'.$TDSearch.'']?></a></small> <small><a href="https://console.developers.google.com/apis/credentials?project=<?=$uConfig['METABOX_GD_PROJECT_'.$TDSearch.'']?>" class="btn btn-sm btn-info" target="_blank">Project ID: <?=$uConfig['METABOX_GD_PROJECT_'.$TDSearch.'']?></a></small> <small><button class="btn btn-sm btn-info" target="_blank">Mount Point: <?=$uConfig['METABOX_GD_MOUNT_'.$TDSearch.'']?></button></small>

        <hr>
<table class="table">
  <thead>
    <tr>
      <th scope="col" style="width:90%">SA Accounts</th>
      <th scope="col" style="width:5%">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php 
  foreach($SAList as $SA){ 
  $getSA = json_decode(file_get_contents($SADir."/".$SA), true);
  ?>
	<tr>
      <td><small><a href="https://console.developers.google.com/iam-admin/serviceaccounts/details/<?=$getSA['client_id']?>;edit=true"><?=$getSA['client_email']?></a></small></td>
	  <form action="/" method="post">
	  <input type="hidden" name="act" value="mount" />
	  <input type="hidden" name="cmd" value="deleteSA" />
	  <input type="hidden" name="id" value="<?=$uConfig['METABOX_GD_TD_'.$TDSearch.'']?>" />
	  <input type="hidden" name="mountName" value="<?=$uConfig['METABOX_GD_NAME_'.$TDSearch.'']?>" />
	  <input type="hidden" name="SAFile" value="<?=$SA?>" />
      <td><button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure? You will lose upload quota for this Team Drive. \n (-750GB Per Service Account)\n 10 Accounts = 7.5TB Maximum per 24hrs.');">Delete</button></td>
	  </form>
    </tr>
  <?php } ?>
  </tbody>
</table>
      </div> 

      <!-- Sidebar Widgets Column -->
      <div class="col-md-4">

        <!-- Categories Widget -->
        <div class="card my-4">
          <h5 class="card-header">FUNCTIONS</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <ul class="list-unstyled mb-0">
                  <li>
					<form action="/" method="post">
					<input type="hidden" name="act" value="mount" />
					<input type="hidden" name="cmd" value="start" />
					<input type="hidden" name="id" value="<?=$uConfig['METABOX_GD_TD_'.$TDSearch.'']?>" />
                    <button type="submit" class="btn btn-block btn-success">Start Mount</button>
					</form>
                  </li>
				  <br />
                  <li>
					<form action="/" method="post">
					<input type="hidden" name="act" value="mount" />
					<input type="hidden" name="cmd" value="disable" />
					<input type="hidden" name="id" value="<?=$uConfig['METABOX_GD_TD_'.$TDSearch.'']?>" />
                    <button type="submit" class="btn btn-block btn-dark">Disable Auto-Mount</button>
					</form>
                  </li>
				  <br />
				  <li>
					<form action="/" method="post">
					<input type="hidden" name="act" value="mount" />
					<input type="hidden" name="cmd" value="stop" />
					<input type="hidden" name="id" value="<?=$uConfig['METABOX_GD_TD_'.$TDSearch.'']?>" />
                    <button type="submit" class="btn btn-block btn-primary">Unmount from MergerFS</button>
					</form>
                  </li>
				  <br />
				  <li>
                    <button type="submit" class="btn btn-block btn-info" data-toggle="modal" data-target="#editMount">Edit Mountpoint</button>
                  </li>
				  <br />
				  <li>
					<form action="/" method="post">
					<input type="hidden" name="act" value="mount" />
					<input type="hidden" name="cmd" value="remove" />
					<input type="hidden" name="id" value="<?=$uConfig['METABOX_GD_TD_'.$TDSearch.'']?>" />
                    <button type="submit" class="btn btn-block btn-danger" onclick="return confirm('Are you sure you want to delete *THIS* mountpoint? \n Removing this, will remove it from mergerfs, remove all logs & service accounts for this mount.');">Delete Mountpoint</button>
					</form>
                  </li>
				  <br />
				  <li>
				  <a href="http://144.172.126.14:8110" class="btn btn-block btn-secondary">Live Log</a>
				  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Side Widget -->
        <div class="card my-4">
          <h5 class="card-header">Statistics</h5>
          <div class="card-body">
            yeah.. stats can go here...
          </div>
        </div>

      </div>

    </div>
    <!-- /.row -->
	
		<div class="col-md-12">
	
	        <div class="card my-4">
          <h5 class="card-header">LOG</h5>
          <div class="card-body">
              <div class="form-group">
                <textarea class="form-control" rows="100" style="max-height: 200px;"><?php echo file_get_contents($uConfig['METABOX_LOGS']."/".$uConfig['METABOX_GD_TD_'.$TDSearch.''].".rclone.log"); ?></textarea>
              </div>
          </div>
        </div>
      </div> 

  </div>
  <!-- /.container -->
  
 
  
  <div class="modal fade" id="editMount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?=$lang['EDIT_MOUNT']?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form action="/" method="post">
			<input type="hidden" name="act" value="mount" />
			<input type="hidden" name="cmd" value="editMount" />
            <input type="hidden" name="id" value="<?=$uConfig['METABOX_GD_TD_'.$TDSearch.'']?>" />
      </div>
	  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
		</form>
      </div>
    </div>
  </div>
</div>
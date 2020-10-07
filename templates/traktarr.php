  <!-- Page Content -->
  <div class="container">


    <!-- Jumbotron Header -->
<br />
    <!-- Page Features -->
    <div class="row text-center">
	
	
<?php
$scanConfig = dirToArray($uConfig['METABOX_TRAKTARR']."/config");
$scanList = dirToArray($uConfig['METABOX_TRAKTARR']."/list");
?>

<h4>Traktarr <?=$lang['TRAKTARR_CONFIG_TABLE']?></h4><button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newConfig"><?=$lang['TRAKTARR_ADD_CONFIG']?></button>
<table class="table">
  <thead>
    <tr>
      <th scope="col" style="width:40%"><?=$lang['TRAKTARR_FILENAME']?></th>
      <th scope="col" style="width:40%"><?=$lang['TRAKTARR_CREATED']?></th>
      <th scope="col" style="width:10%"><?=$lang['TRAKTARR_EDIT']?></th>
      <th scope="col" style="width:10%"><?=$lang['TRAKTARR_DELETE']?></th>
    </tr>
  </thead>
  <tbody>
 <?php foreach($scanConfig as $conf){ ?>
    <tr>
      <th scope="row"><?=$conf?></th>
      <td><?=date ("F d Y", filectime($uConfig['METABOX_TRAKTARR']."/config/".$conf));?></td>
      <td><button class="btn btn-success" data-toggle="modal" data-target="#newConfig"><?=$lang['TRAKTARR_EDIT']?></button></td>
	  <form action="/" method="post">
	  <input type="hidden" name="act" value="traktarr" />
	  <input type="hidden" name="cmd" value="deleteConf" />
	  <input type="hidden" name="id" value="<?=$conf?>" />
      <td><button type="submit"  class="btn btn-danger" onclick="return confirm('<?=$lang['TRAKTARR_RUSURE']?> Config?');"><?=$lang['TRAKTARR_DELETE']?></button></td>
	  </form>
    </tr>
 <?php } ?>
  </tbody>
</table>

<br /><br />

<h4>Traktarr - <a href="https://www.trakt.tv" target="_blank">Trakt.tv</a> <?=$lang['TRAKTARR_TV_LIST']?></h4><button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newList"><?=$lang['TRAKTARR_ADD_LIST']?></button>
<table class="table">
  <thead>
    <tr>
      <th scope="col" style="width:40%"><?=$lang['TRAKTARR_FILENAME']?></th>
      <th scope="col" style="width:30%"><?=$lang['TRAKTARR_CREATED']?></th>
	  <th scope="col" style="width:20%"><?=$lang['TRAKTARR_LRUN']?></th>
      <th scope="col" style="width:10%"><?=$lang['TRAKTARR_DELETE']?></th>
    </tr>
  </thead>
  <tbody>
 <?php foreach($scanList as $conf){ ?>
    <tr>
      <th scope="row"><?=$conf?></th>
      <td><?=date ("F d Y", filectime($uConfig['METABOX_TRAKTARR']."/list/".$conf));?></td>
	  <td>1 second ago</td>
	  <form action="/" method="post">
	  <input type="hidden" name="act" value="traktarr" />
	  <input type="hidden" name="cmd" value="deleteList" />
	  <input type="hidden" name="id" value="<?=$conf?>" />
      <td><button type="submit"  class="btn btn-danger" onclick="return confirm('<?=$lang['TRAKTARR_RUSURE']?> List?');"><?=$lang['TRAKTARR_DELETE']?></button></td>
	  </form>
    </tr>
 <?php } ?>
  </tbody>
</table>

  </div></div>
  <!-- /.container -->



<div class="modal fade" id="newConfig" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?=$lang['TRAKTARR_CREATE_CONFIG']?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<form action="/" method="post">
				<input type="hidden" name="act" value="traktarr" />
				<input type="hidden" name="cmd" value="addConfig" />
				<h4><?=$lang['TRAKTARR_GLOBAL']?></h4>
				<div class="input-group mb-4 mr-sm-4">
				<div class="form-group"><i class="fa fa-user"><?=$lang['TRAKTARR_CONFIGNAME']?></i><input type="text" class="form-control" name="configName" required /></div>
				<div class="form-group"><i class="fa fa-user">OMDB <?=$lang['TRAKTARR_API']?></i><input type="text" class="form-control" name="global[omdb]" /></div>
				</div>
				<div class="form-group"><i class="fa fa-user">Trakt.tv <?=$lang['TRAKTARR_CLIENTID']?></i><input type="text" class="form-control" name="global[trakt][client_id]" required /></div>
				<div class="form-group"><i class="fa fa-user">Trakt.tv <?=$list['TRAKTARR_SECRET']?></i><input type="text" class="form-control" name="global[trakt][client_secret]" required /></div>
				<h4>Radarr / Movies <?=$lang['CONFIG_TITLE']?></h4>
				<div class="input-group mb-4 mr-sm-4">
				<div class="form-group"><i class="fa fa-user">Radarr <?=$lang['TRAKTARR_API']?></i><input type="text" class="form-control" name="movies[api_key]" required /></div>
				<div class="form-group"><i class="fa fa-user">Radarr URL</i><input type="text" class="form-control" name="movies[url]" required /></div>
				</div>
				<div class="input-group mb-2 mr-sm-2">
				<div class="form-group"><i class="fa fa-user"><?=$lang['TRAKTARR_MIN_YR']?></i><select class="form-control" name="movies[blacklisted_min_year]" required /></div>
				<?php 
				$i = "1900";
				while($i != date('Y', strtotime('+10 years'))){
					echo "<option value=\"".$i."\">".$i."</option>";
					$i++;
				}
				?>
				</select>
				<div class="form-group"><i class="fa fa-user"><?=$lang['TRAKTARR_MAX_YR']?></i><select class="form-control datepicker" name="movies[blacklisted_max_year]" /></div>
				<?php 
				$i = "1900";
				while($i != date('Y', strtotime('+10 years'))){
					echo "<option value=\"".$i."\">".$i."</option>";
					$i++;
				}
				?>
				</select>
				<div class="form-group"><i class="fa fa-user"><?=$lang['TRAKTARR_MIN_AVAIL']?></i><select class="form-control" name="movies[minimum_availability]" /></div>
				<option value="announced">Announced</option>
				<option value="in cinemas">In Cinemas</option>
				<option value="released">Released</option>
				<option value="predb">PreDB</option>
				</select>
				</div></div></div></div>
								<div class="input-group mb-4 mr-sm-4">
				<div class="form-group"><i class="fa fa-user"><?=$lang['TRAKTARR_QUALITY']?></i><input type="text" class="form-control" name="movies[quality]" required /></div>
				<div class="form-group"><i class="fa fa-user"><?=$lang['TRAKTARR_ROOT_FOLDER']?></i><input type="text" class="form-control" name="movies[root_folder]" required /></div>
				</div>
				<h4>Sonarr / TV <?=$lang['CONFIG_TITLE']?></h4>
				<div class="input-group mb-4 mr-sm-4">
				<div class="form-group"><i class="fa fa-user">Sonarr <?=$lang['TRAKTARR_API']?></i><input type="text" class="form-control" name="shows[api_key]" required /></div>
				<div class="form-group"><i class="fa fa-user">Sonarr URL</i><input type="text" class="form-control" name="shows[url]" required /></div>
				</div>
				<div class="input-group mb-4 mr-sm-4">
				<div class="form-group"><i class="fa fa-user"><?=$lang['TRAKTARR_MIN_YR']?></i><select class="form-control datepicker" name="shows[blacklisted_min_year]" /></div>
				<?php 
				$i = "1900";
				while($i != date('Y', strtotime('+10 years'))){
					echo "<option value=\"".$i."\">".$i."</option>";
					$i++;
				}
				?>
				</select>
				<div class="form-group"><i class="fa fa-user"><?=$lang['TRAKTARR_MAX_YR']?></i><select class="form-control datepicker" name="shows[blacklisted_max_year]" /></div>
				<?php 
				$i = "1900";
				while($i != date('Y', strtotime('+10 years'))){
					echo "<option value=\"".$i."\">".$i."</option>";
					$i++;
				}
				?>
				</select>
				</div>
				<div class="input-group mb-4 mr-sm-4">
				<div class="form-group"><i class="fa fa-user"><?=$lang['TRAKTARR_QUALITY']?></i><input type="text" class="form-control" name="shows[quality]" required /></div>
				<div class="form-group"><i class="fa fa-user"><?=$lang['TRAKTARR_ROOT_FOLDER']?></i><input type="text" class="form-control" name="shows[root_folder]" required /></div>
				</div></div></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$lang['MODAL_CLOSE']?></button>
        <button type="submit" class="btn btn-primary"><?=$lang['TRAKTARR_CREATE_CONFIG']?></button>
		</form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="newList" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Create New Trakt.tv List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<form action="/" method="post">
				<input type="hidden" name="act" value="traktarr" />
				<input type="hidden" name="cmd" value="addList" />
					<div class="form-group">
						<i class="fa fa-user"></i>
						<input type="text" class="form-control" name="listName" placeholder="Name: trakt.tv-new-movies" required="required">
					</div>
					<div class="form-group">
						<i class="fa fa-user"></i>
						<input type="text" class="form-control" name="listURL" placeholder="https://trakt.tv/users/pixelhunterprime/lists/netflix" required="required">
					</div>
					<div class="form-group">
						<select name="listConfig" class="custom-select" >
						<option value="" disabled selected><?=$lang['TRAKTARR_CONFIG_LIST']?></option>
						<?php foreach($scanConfig as $conf){ echo "<option value=\"".$conf."\">".$conf."</option>"; } ?>
						</select>
					</div>
					  <div class="form-check">
						<input type="checkbox" class="form-check-input" name="listRun" id="exampleCheck1">
						<label class="form-check-label" for="exampleCheck1"><?=$lang['TRAKTARR_AUTOSTART']?></label>
					</div>
					
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$lang['MODAL_CLOSE']?></button>
        <button type="submit" class="btn btn-primary"><?=$lang['TRAKTARR_CREATE_LIST']?></button>
		</form>
      </div>
    </div>
  </div>
</div>

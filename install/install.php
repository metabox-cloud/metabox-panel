<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=$uConfig['METABOX_WEBNAME']?> :: Installer</title>
<link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div class="text-center">
	<a href="https://www.metabox.cloud" target="_blank"><img src="/assets/img/metabox.png"></a><br /><br />
	<a href="#installModal" class="btn btn-lg btn-primary" data-toggle="modal">Installer</a>
</div>

<!-- Modal HTML -->
<div id="installModal" class="modal fade">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <a href="/install/install-step1.php" class="btn btn-block btn-success">Install Fresh metaBox</a>
		<br /><br />
		<a href="/install/restore.php" class="btn btn-block btn-info">Restore from Backup File</a>
      </div>
      <div class="modal-footer">
	  <small>metaBox was created by MasterTeddy, metaBox is a Docker based Media Server tool. stuff and things</small>
      </div>
    </div>
  </div>
</div> 
</body>
</html>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#installModal').modal('show');
    });
	

</script>

  <script src="/assets/vendor/jquery/jquery.min.js"></script>
  <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

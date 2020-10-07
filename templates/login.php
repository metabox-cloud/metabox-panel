<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=$uConfig['METABOX_WEBNAME']?> :: <?=$lang['QUIP']?></title>
<link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style>
    body {
		font-family: 'Varela Round', sans-serif;
	}
	.modal-login {
		color: #636363;
		width: 350px;
		margin: 30px auto;
	}
	.modal-login .modal-content {
		padding: 20px;
		border-radius: 5px;
		border: none;
	}
	.modal-login .modal-header {
		border-bottom: none;
		position: relative;
		justify-content: center;
	}
	.modal-login h4 {
		text-align: center;
		font-size: 26px;
	}
	.modal-login  .form-group {
		position: relative;
	}
	.modal-login i {
		position: absolute;
		left: 13px;
		top: 11px;
		font-size: 18px;
	}
	.modal-login .form-control {
		padding-left: 40px;
	}
	.modal-login .form-control:focus {
		border-color: #00ce81;
	}
	.modal-login .form-control, .modal-login .btn {
		min-height: 40px;
		border-radius: 3px; 
	}
	.modal-login .hint-text {
		text-align: center;
		padding-top: 10px;
	}
	.modal-login .close {
        position: absolute;
		top: -5px;
		right: -5px;
	}
	.modal-login .btn {
		background: #00ce81;
		border: none;
		line-height: normal;
	}
	.modal-login .btn:hover, .modal-login .btn:focus {
		background: #00bf78;
	}
	.modal-login .modal-footer {
		background: #ecf0f1;
		border-color: #dee4e7;
		text-align: center;
		margin: 0 -20px -20px;
		border-radius: 5px;
		font-size: 13px;
		justify-content: center;
	}
	.modal-login .modal-footer a {
		color: #999;
	}
	.trigger-btn {
		display: inline-block;
		margin: 100px auto;
	}
</style>
</head>
<body>
<div class="text-center">
	<a href="https://www.metabox.cloud" target="_blank"><img src="/assets/img/metabox.png"></a><br /><br />
	<a href="#loginModal" class="btn btn-large btn-info" data-toggle="modal"><?=$uConfig['METABOX_WEBNAME']?> :: <?=$lang['QUIP']?></a>
</div>

<!-- Modal HTML -->
<div id="loginModal" class="modal fade">
	  <div class="modal-dialog modal-login modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">				
				<h4 class="modal-title"><?=$lang['ACCOUNT_LOGIN']?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form action="/" method="post">
				<input type="hidden" name="act" value="doLogin" />
					<div class="form-group">
						<i class="fa fa-user"></i>
						<input type="text" class="form-control" name="username" placeholder="<?=$lang['USERNAME']?>" required="required">
					</div>
					<div class="form-group">
						<i class="fa fa-lock"></i>
						<input type="password" class="form-control" name="password" placeholder="<?=$lang['PASSWORD']?>" required="required">					
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary btn-block" value="<?=$lang['LOGIN']?>">
					</div>
				</form>				
				
			</div>
			<div class="modal-footer">
				<button class="btn btn-lg btn-secondary" onclick="forgotPassword()"><?=$lang['FORGOT_PASSWORD']?></button>
			</div>
		</div>
	</div>
</div>     
</body>
</html>

<script type="text/javascript">
function forgotPassword() {
  alert("<?=$lang['SCREWED']?>");
}

    $(window).on('load',function(){
        $('#loginModal').modal('show');
    });
</script>

  <script src="/assets/vendor/jquery/jquery.min.js"></script>
  <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
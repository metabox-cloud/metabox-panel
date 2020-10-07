  <!-- Page Content -->
  <div class="container">


    <!-- Jumbotron Header -->
<br />
    <!-- Page Features -->
    <div class="row text-center">
	<h4><?=$lang['CONFIG_WARNING']?>: <br /><?=$lang['CONFIG_WARNING_L2']?></h4>
	<a href="/dash" class="btn btn-block btn-success" onclick="return confirm('<?=$lang['CONFIG_BACKOUT_TAUNT']?>');"><?=$lang['CONFIG_BACKOUT']?></a>

<!--<form action="/" method="post">-->
				<input type="hidden" name="act" value="editConfig" />

<textarea rows="30" class="form-control" style="margin: 25px 0px 25px 0px;"><?php echo  json_encode($uConfig, JSON_PRETTY_PRINT); ?></textarea>

<input type="text" class="form-control" name="verification" aria-describedby="emailHelp" placeholder="<?=$lang['CONFIG_SUM']?>" required>
	<button type="submit" style="margin: 25px 0px 25px 0px;" class="btn btn-block btn-danger" onclick="return confirm('<?=$lang['CONFIG_SUBMIT_TAUNT']?>');"><?=$lang['CONFIG_SUBMIT']?></button>
  </div>
  </div>
  <!-- /.container -->



<?php
require_once 'php/HTMLProcedural.php';
require_once 'php/Database.php';
require_once 'php/Encryption.php';

$html = new HTMLProcedural();
$db = new Database();

$error = false;

if (isset($_POST['bin']) && strcmp($_POST['bin'], "") != 0 &&
	isset($_POST['expiration']) && strcmp($_POST['expiration'], "") != 0)
{
	$rawbin = $_POST['bin'];
	$expiration = $_POST['expiration'];

	if (!is_numeric($expiration))
	{
		$error = true;
	}
	else
	{
		$key = Encryption::generateKey();
		$iv = Encryption::generateIV();
		$encbin = Encryption::encrypt($rawbin, $key, $iv);
		$longID = Encryption::generateRandomString();

		$db->addBin($encbin, base64_encode($iv), $longID, $expiration);
	}
} else {
	$error = true;
}

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<!--<link rel="icon" href="favicon.ico">-->

	<title>Cypher.Link</title>

	<!-- Bootstrap core CSS -->
	<link href="/css/bootstrap.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="/css/cover.css" rel="stylesheet">
	<link href="/css/cypherlink.css" rel="stylesheet">

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="/js/ie10-viewport-bug-workaround.js"></script>

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
<div class="site-wrapper">
	<div class="cover-container">
		<div class="masthead clearfix">
			<div class="inner">
				<h3 class="masthead-brand"><div></div>CypherLink<small> beta</small></h3>
				<ul class="nav masthead-nav">
					<li><a href="/">New Link</a></li>
					<li><a href="#">About</a></li>
					<li><a href="#">Contact</a></li>
				</ul>
			</div>
		</div>

		<div class="spacer hidden-xs"></div>

		<?php

		if (!$error)
		{
			$key64 = base64_encode($key);
			$link = "http://cypher.link/".$longID;
			$linkWithKey = $link."/".str_replace('+', '%2B', $key64);

			?>
			<div class="container text-left">
				<h3>Your new Cypher Link has been generated!</h3>
				<p>The content is now available. Access it using this link:</p>
				<div class="input-group links">
					<span class="input-group-addon">Link with Key</span>
					<input type="text" class="form-control" value="<?php echo $linkWithKey ?>" readonly>
				</div>
				<br>
				<div class="input-group links">
					<span class="input-group-addon">Link without Key</span>
					<input type="text" class="form-control" value="<?php echo $link ?>" readonly>
				</div>
				<br>
				<p>In order to successfully access the contents of the link, you have to provide the following cypher key to whoever you share your link with. It is already included in the first link above.</p>
				<div class="input-group">
					<span class="input-group-addon">Cypher Key</span>
					<input type="text" class="form-control" value="<?php echo $key64 ?>" readonly>
				</div>
				<p><small>You may want to store the key in a separate file or location of the link itself. It might improve the secrecy of your content.</small></p>
				<hr>
				<p><strong>Attention!</strong> This page can only be seen once. If you lose the cypher key shown in this page, you won't be able to retrieve the content. The cypher key is never stored in our servers.</p>
				<a href="<?php echo $linkWithKey ?>" class="btn btn-lg btn-default">Go to Cypher Link</a>
			</div>
			<?php
		} else {
			?>
			<div class="container text-left">
				<h3>There was a problem generating your Cypher Link!</h3>
				<p>Please try again!</p>

			</div>
			<?php
		}

		?>

		<div class="mastfoot">
			<div class="inner">
				<p>Created by <a href="https://brunophilipe.com">Bruno Philipe</a> &mdash; Disclaimer: This is beta software. Source available on <a href="https://github.com/brunophilipe/Cypher.Link" target="_blank">GitHub</a><br>All Rights Reserved &mdash; 2014 Bruno Philipe</p>
			</div>
		</div>
	</div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script>
	$(function(){
		$('input').click(function(){
			$(this).select();
		});
	});
</script>
</body>
</html>

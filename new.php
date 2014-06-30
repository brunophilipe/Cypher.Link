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
<html class="full" lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Create encrypted links to store and share your private content.">
		<meta name="author" content="Bruno Philipe <hello@brunophilipe.com>">
		<title>Cypher.Link</title>
		<link href="/css/bootstrap.css" rel="stylesheet">
		<link href="/css/full.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,700' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<nav class="navbar navbar-fixed-top navbar-inverse" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/">Cypher.Link</a>
				</div>
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav">
						<li><a href="/">New Link</a></li>
						<li><a href="/about.php">About</a></li>
						<li><a href="/contact.php">Contact</a></li>
					</ul>
				</div>
			</div>
		</nav>
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

		<footer class="text-center">
			<p>
				Created by <a href="https://brunophilipe.com">Bruno Philipe</a> &mdash; Disclaimer: This is beta software.<br>
				By using it you agree with the <a href="about.php">terms in the license</a>. Source available on <a href="https://github.com/brunophilipe/Cypher.Link" target="_blank">GitHub</a>.<br>
				All Rights Reserved &mdash; 2014 Bruno Philipe
			</p>
		</footer>
		</div>

		<!-- JavaScript -->
		<script src="/js/jquery-1.10.2.js"></script>
		<script src="/js/bootstrap.js"></script>
		<script>
			$(function(){
				$('input').click(function(){
					$(this).select();
				});
			});
		</script>
	</body>
</html>
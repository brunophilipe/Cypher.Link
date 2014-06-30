<?php
require_once 'php/HTMLProcedural.php';
require_once 'php/Database.php';
require_once 'php/Encryption.php';

$html = new HTMLProcedural();
$db = new Database();

$error = false;
$expired = false;

if (isset($_GET['longID']) && strcmp($_GET['longID'], "") != 0 && isset($_GET['key']) && strcmp($_GET['key'], "") != 0)
{
	$longID = $_GET['longID'];
	$key64 = str_replace(' ', '+', $_GET['key']);

	$bin = $db->getBinByLongID($longID);
	if ($bin === null)
	{
		$error = true;
	} else {
		$expiration = $bin['time_expiration'];
		if ($expiration > 0 && $expiration < time())
		{
			$expired = true;
		}
		else
		{
			$encbin = $bin['content'];
			$rawbin = Encryption::decrypt($encbin, base64_decode($key64), base64_decode($bin['salt']));
		}
	}
}
else if (isset($_GET['longID']) && strcmp($_GET['longID'], "") != 0)
{
	$longID = $_GET['longID'];
	$key64 = null;

	$bin = $db->getBinByLongID($longID);
	if ($bin === null)
	{
		$expired = true;
	} else {
		$expiration = $bin['time_expiration'];
		if ($expiration > 0 && $expiration < time())
		{
			$expired = true;
		}
	}
}
else
{
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
		<div class="spacer hidden-xs"></div>
		<div class="container">
			<?php

			if (!$expired && !$error && !is_null($key64))
			{
				$html->append(factory("h3", "Cypher Link: $longID", array("text-center")));
				$html->append(factory("p", factory("small", "", array("unixdate"), null, array("data-time"=>$bin['time_creation'])), array("text-center", "desc")));
				$html->append(factory("textarea", $rawbin, array("col-lg-10", "col-lg-offset-1", "col-md-10", "col-md-offset-1", "col-sm-12", "col-xs-12"), null, array("readonly")));
				$html->wrap("div", array("inner", "cover"));
				$html->render();
			} else if ($expired) {
				$html->append(factory("h3", "The Cypher Link '$longID' doesn't exist. Maybe it expired?", array("cover-heading")));
				$html->render();
			} else {
				$html->append(factory("h3", "The Cypher Link '$longID' is encrypted and Cypher.Link doesn't store keys.", array("cover-heading")));
				$html->append(factory("p", "You need to provide the Cypher Key yourself. Please paste the key in the field below:"));

				$form = new HTMLProcedural();
				$form->append(factory("span","Cypher Key", array("input-group-addon")));
				$form->append(factory("input", null, array("form-control"), "keyfield", array("placeholder"=>"Paste the key here")));
				$form->wrap("div", array("input-group"));
				$html->append($form->contents());

				$html->append("<br><br>".factory_a("Decrypt Cypher Link", null, null, array("btn", "btn-lg","btn-default"), null, array("onClick"=>"reloadWithKey();")));
				$html->wrap("div", array("inner", "cover"));
				$html->render();
			}

			?>
		</div>
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
		<script src="/js/moment.js"></script>
		<script>
			function reloadWithKey()
			{
				var longID = "<?php echo $longID; ?>";
				var key = $('#keyfield').val();
				var url = "http://cypher.link/"+longID+"/"+key;
				window.location.href = url;
			}

			$(function(){
				$('.unixdate').each(function() {
					var unix = $(this).attr("data-time");
					$(this).append("Created "+moment(unix*1000).fromNow()+".");
				});
			});
		</script>
	</body>
</html>

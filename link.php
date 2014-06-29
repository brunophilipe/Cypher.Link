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
			<div class="container">
				<?php

				if (!$expired && !$error && !is_null($key64))
				{
					$html->append(factory("h3", "Cypher Link: $longID", array("cover-heading")));
					$html->append(factory("p", factory("small", "", array("unixdate"), null, array("data-time"=>$bin['time_creation']))));
					$html->append(factory("textarea", $rawbin, array("col-lg-10", "col-lg-offset-1", "col-md-10", "col-md-offset-1", "col-sm-12", "col-xs-12"), null, array("readonly")));
					$html->wrap("div", array("inner", "cover"));
					$html->render();
				} else if ($expired) {
					$html->append(factory("h3", "The Cypher Link '$longID' doesn't exist. Maybe it expired?", array("cover-heading")));
					$html->render();
				} else {
					$html->append(factory("h3", "The Cypher Link '$longID' is Encrypted and Cypher.Link doesn't store keys.", array("cover-heading")));
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

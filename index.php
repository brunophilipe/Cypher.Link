<?php
require_once 'php/HTMLProcedural.php';
require_once 'php/Database.php';
require_once 'php/Encryption.php';

$html = new HTMLProcedural();
$db = new Database();

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
			<div class="site-wrapper-inner">
				<div class="cover-container">
					<div class="masthead clearfix">
						<div class="inner">
							<h3 class="masthead-brand"><div></div>CypherLink<small> beta</small></h3>
							<ul class="nav masthead-nav">
								<li class="active"><a href="/">New Link</a></li>
								<li><a href="/about.php">About</a></li>
								<li><a href="/contact.php">Contact</a></li>
							</ul>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
							<form action="/new" method="post">
								<h1 class="cover-heading">Create an encrypted link with your secret content:</h1>
								<textarea placeholder="Start by pasting your content here." name="bin"></textarea>
								<div>
									<span style="float: right; display: block">
										Expires:<br class="visible-xs">
										<select name="expiration">
											<option value="-1">Never</option>
											<option value="60">in 1 Minute</option>
											<option value="300">in 5 Minutes</option>
											<option value="1800">in 30 Minutes</option>
											<option value="3600">in 1 Hour</option>
											<option value="21600">in 6 Hours</option>
											<option value="86400">in 1 Day</option>
											<option value="2592000">in 1 Month</option>
											<option value="31104000">in 1 Year</option>
										</select>
									</span>
									<input type="submit" class="btn btn-lg btn-default" id="getlink" value="Get Cypher Link">
								</div>
							</form>
						</div>
					</div>

					<div class="mastfoot">
						<div class="inner">
							<p>
								Created by <a href="https://brunophilipe.com">Bruno Philipe</a> &mdash; Disclaimer: This is beta software.<br>
								By using it you agree with the <a href="about.php">terms in the license</a>. Source available on <a href="https://github.com/brunophilipe/Cypher.Link" target="_blank">GitHub</a>.<br>
								All Rights Reserved &mdash; 2014 Bruno Philipe
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
	</body>
</html>

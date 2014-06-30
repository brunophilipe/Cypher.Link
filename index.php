<?php
require_once 'php/HTMLProcedural.php';
require_once 'php/Database.php';
require_once 'php/Encryption.php';

$html = new HTMLProcedural();
$db = new Database();

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
						<li class="active"><a href="/">New Link</a></li>
						<li><a href="/about.php">About</a></li>
						<li><a href="/contact.php">Contact</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container" style="margin-top: 20px;">
			<div class="row">
				<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
					<form action="/new" method="post">
						<h1 class="text-center">Create an encrypted link with your secret content:</h1>
						<textarea placeholder="Start by pasting your content here." name="bin"></textarea>
						<div id="inputform">
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
			<div class="spacer hidden-xs"></div>
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
	</body>
</html>

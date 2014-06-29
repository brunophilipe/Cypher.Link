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
						<li><a href="/">New Link</a></li>
						<li class="active"><a href="/about.php">About</a></li>
						<li><a href="/contact.php">Contact</a></li>
					</ul>
				</div>
			</div>

			<div class="container page">
				<div>
					<h2>About</h2>
					<p>Cypher.Link was created with the intention to give people a tool that allowed them to share or
						store private information in a way that was free and easy to use.</p>
					<p>Most tools of this kind I found on the internet used client-side encryption which, despite in
						theory being safer, they either didn't work or were very slow. I also wanted to provide a tool
						that worked on mobile devices, and most of those don't have a js engine powerful enough to
						encrypt large chunks of data. For this reason I chose to do a server-side encryption.</p>
					<p>The entire source of this project is available on GitHub. Please feel free to explore the code,
						find problems and improvements.</p>
					<p>I have created this tool with the intention of making it useful, but I do not claim it to be
						correct or optimal in any way. By using this tool you accept the terms of the license to
						follow:</p>
					<textarea readonly>
<?php
	echo file_get_contents("LICENSE.txt");
?>
					</textarea>
				</div>
			</div>

			<div class="mastfoot">
				<div class="inner">
					<p>
						Created by <a href="https://brunophilipe.com">Bruno Philipe</a> &mdash; Disclaimer: This is beta software. By using it you agree with the <a href="about.php">terms in the license</a>.<br>
						Source available on <a href="https://github.com/brunophilipe/Cypher.Link" target="_blank">GitHub</a><br>
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
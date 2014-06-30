<?php
require_once 'php/Database.php';
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
						<li><a href="/">New Link</a></li>
						<li class="active"><a href="/about.php">About</a></li>
						<li><a href="/contact.php">Contact</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container page">
			<div>
				<h2>About</h2>
				<p>In total, <?php echo $db->getBinsCount(); ?> Cypher Links were created by anonymous users since June 29, 2014.</p>
				<p>Cypher.Link was created with the intention to give people a tool that allowed them to share or
					store private information in a way that was free and easy to use.</p>
				<p>Most tools of this kind I found on the internet used client-side encryption which, despite in
					theory being safer, either didn't work or were very slow. I also wanted to provide a tool
					that worked on mobile devices, and most of those don't have a js engine powerful enough to
					encrypt large chunks of data. For this reason I chose to do a server-side encryption.</p>
				<p>The entire source of this project is available on GitHub. Please feel free to explore the code
					to find problems and improvements.</p>
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

<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet"
	href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/themes/base/jquery-ui.css"
	type="text/css" media="all" />
<link rel="stylesheet" type="text/css"
	href="<?=base_url()?>css/style.css" />
<script
	src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"
	type="text/javascript"></script>
<script
	src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"
	type="text/javascript"></script>
<script
	src="http://jquery-ui.googlecode.com/svn/tags/latest/external/jquery.bgiframe-2.1.2.js"
	type="text/javascript"></script>
<script
	src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/i18n/jquery-ui-i18n.min.js"
	type="text/javascript"></script>
<script type="text/javascript"
	src="<?=base_url()?>scripts/autocomplete.js"></script>
<meta charset="utf-8" />
</head>

<body>
	<div id="main">
		<div id="top">
			<mp:Top />
		</div>
		<div id="bar">
			<mp:Bar />
		</div>
		<div id="middle">
			<nav id="mainNav">
				<mp:Mainnav />
			</nav>
			<div id="teamChoice">
				<mp:Teamchoice />
			</div>
			<div id="content">
				<mp:Content />
			</div>
			<div id="background"></div>

		</div>
		<div id="footer">
			<mp:Footer />
		</div>
	</div>
</body>
</html>

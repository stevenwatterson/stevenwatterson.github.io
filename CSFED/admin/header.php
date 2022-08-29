<?php
require_once "../res/x5engine.php";
require_once "../res/l10n.php";
require_once "../res/x5settings.php";
require_once "checkaccess.php";
?>
<!doctype html>
<html lang="en">
<head>
	<title>WebSite X5 Manager</title>
	<meta charset="UTF-8">
	<title>Document</title>
	<script type="text/javascript" src="../res/jquery.js"></script>
	<script type="text/javascript" src="../res/x5engine.js"></script>
	<script type="text/javascript">
		x5engine.settings.currentPath = "../";
		x5engine.settings.imAdv.show = false;
	</script>
	<link rel="stylesheet" type="text/css" href="../style/reset.css"/>
	<link rel="stylesheet" type="text/css" href="../style/style.css"/>
	<link rel="stylesheet" type="text/css" href="../style/print.css" media="print"/>
	<link rel="stylesheet" type="text/css" href="template.css"/>
	<style>
	<?php
		// Find the existing star image
		$n = 0;
		while (!file_exists("../images/star0" . ++$n . "-big-empty.png") && $n < 10);
	?>
		.topic-star-container-big { background-image: url("../images/star0<?php echo $n ?>-big-empty.png")}
		.topic-star-fixer-big  { background-image: url("../images/star0<?php echo $n ?>-big-full.png")}
		.topic-star-container-small { background-image: url("../images/star0<?php echo $n ?>-small-empty.png")}
		.topic-star-fixer-small  { background-image: url("../images/star0<?php echo $n ?>-small-full.png")}
	</style>
</head>
<body>
<?php if (isset($logged) && $logged): ?>
	<div id="imNavBar">
<?php if (isset($imSettings['blog'])): ?>
		<a href="blog.php"<?php if (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == "blog.php") echo " class=\"active\""; ?>>Blog</a>
<?php endif; ?>
<?php if (isset($imSettings['guestbooks']) && count($imSettings['guestbooks'])): ?>
		<a href="guestbook.php"<?php if (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == "guestbook.php") echo " class=\"active\""; ?>><?php echo l10n("admin_guestbook", "Guestbook") ?></a>
<?php endif; ?>
		<a href="website_test.php"<?php if (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == "website_test.php") echo " class=\"active\""; ?>>Test</a>
		<span><a href="login.php?logout"><?php echo l10n("admin_logout", "Logout") ?></a></span>
	</div>
<?php endif; ?>

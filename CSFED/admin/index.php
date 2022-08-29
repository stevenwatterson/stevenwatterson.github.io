<?php
	require_once("../res/x5engine.php");
	require_once("checkaccess.php");
	if ($logged)
	{
		require_once("../res/x5settings.php");
		if (isset($imSettings['blog']) && $imSettings['blog'] != FALSE)
		{
			header("Location: blog.php");
			exit;
		} else if (isset($imSettings['guestbooks']) && count($imSettings['guestbooks'])) {
			header("Location: guestbook.php");
			exit;
		} else {
			header("Location: website_test.php");
		}
	}

// End of file index.php

<?php
$ver = 'Financial 0.9.8.0.0beta';
define('TR','\n  <tr>');
define('TR_','\n  </tr>');
define('TRo','\n  <tr');

// TODO: Make user configurable
date_default_timezone_set('America/Los_Angeles');
//	error_reporting(0);
	
	if (!file_exists("f-config.php"))
	{
		header('Location: setup/');
	}
	require_once("f-config.php");
	$page = $_GET['page'];
	$ACC_TYPE;
	$ACC_1;
	$ACC_2;
	$ACC_3;
	$connection = mysql_connect(HOSTNAME, USERNAME, PASSWORD)
		or die("Unable to connect !\n is your database set up?".
				"<a href=\"setup\">setup</a>");
	mysql_select_db(DATABASENAME)
		or die("Unable to select database! DATABASENAME\n is your".
				"database set up?<a href=\"setup\">setup</a>");
?>
<html>
<head>
<?php
FINinit();
echo "\n\n<title> $ver </title>";
echo "<link href=\"resources/styles_main.css\" rel=\"stylesheet\" type=\"text/css\">\n";
echo "<link href=\"resources/styles_account.css\" rel=\"stylesheet\" type=\"text/css\">\n";
if ($page < -1 && ($page != ""))
{
	echo "<link href=\"resources/styles_-1.css\" rel=\"stylesheet\" type=\"text/css\">\n";
}
?>
</head>
<body>
<?php
	setupAcc($page, $ACC_TYPE, $ACC_1, $ACC_2, $ACC_3);
	if ($page > 0)
	{
		AccountPageLayout($page, $ACC_TYPE, $ACC_1);
	}
	else
	{
		if ($page != -1)
		{
			billsDue($page, $ACC_2);
		// Main Page Columns
			if ($ACC_1)
			{
				ShowMainPageColumn(true, $page, $ACC_TYPE, $ACC_1, $ACC_2, $ACC_3);
				ShowMainPageColumn(false, $page, $ACC_TYPE, $ACC_1, $ACC_2, $ACC_3);
				totals($ACC_1,$ACC_3,$ACC_TYPE);
			}
			newTR(0,$ACC_1);
		}
		else
		{
				echo "<div align=center><a href=\"". $_SERVER['PHP_SELF'] ."?page=0\">Go to the Main Page</a></div>";
		}
		if ($page)
		{
			echo  "<table border=3 align=center>\n"
				. "<tr>";
			$i = editAcc('new',$ACC_TYPE);
			$foo = "account" . $i;
			if (isset($_POST[$foo]))
			{
				if(submitAcc($i,'new'))
				{
					reloadPHP();
				}
			}
			echo "</tr></table>";
		}
	}
	mysql_close($connection); 
?>
</body>
</html>



<?php $F/*
	extract($_POST);extract($_SERVER);
	$host = "127.0.0.1";$local = true;$timeout = "1";
	if ($REMOTE_ADDR) {
		if ($REMOTE_ADDR != $host) {
			$local = false;
		}
	}
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS']))
		{$uri2 = 'https://';}
		else {$uri2 = 'http://';}
	$uri2 .= $_SERVER['HTTP_HOST'];
	$fti = 'ftp://' . $_SERVER['HTTP_HOST'];
	$uri = $uri2 . '/';
	$app = $uri . 'webapps/';
*/?>
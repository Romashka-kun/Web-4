<!doctype html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Массив $GLOBALS</title>
</head>
<body>
<h1>Массив $GLOBALS</h1>

<?
/*
	$a = 23;
	$b = 'fds';
	$c = 1.2;
	foreach ( $GLOBALS as $k=>$v ) {
		echo "$k = $v<br>";
	}
	echo '<pre>';
	print_r($GLOBALS);
	echo '<pre>';
	*/
	if (isSet($_GET['login']))
		echo 'Hello, '.$_GET['login'];
	else {
?>

<form method="get" 
	action="<? echo $_SERVER['PHP_SELF'] ?>" >
	<input type="text" name="login" />login<br>
	<input type="password" name="pwd" />password<br>
	<input type="submit" name="submit" value="Submit" />
</form>
<?
	};
?>
</body>
</html>
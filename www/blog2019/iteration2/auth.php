<?php 
	require_once 'inc/session.php';
	require_once 'inc/settings.php';	
	require_once 'inc/db-connect.php';
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Авторизация</title>
    <?php include 'inc/head_tags.php';  ?>	
</head>

<body>
    <?php
     include 'inc/header.php'; 
	 require_once 'inc/menu.php'; 
	?>	
	
	<div id="node">
	  <div class="wrap">
	  
	    <h1 class='pageTitle'>Авторизация</h1>
		
		<?php
		//---------------------------------------
		//Сначала обрабатываем результаты ВОЗМОЖНОГО POST-запроса.
		//Если была попытка авторизации (т.е., непуст POST запрос), посмотрим, правильные ли данные аккаунта пользователя введены:
		//		1. Если переданы правильные данные, зададим соответствующее значение $_SESSION['isAdmin'] и выведем сообщение со смыслом "OK"
		//		2. Иначе выведем сообщение о неудаче авторизации и снова покажем форму.
		
		if (isSet($_POST['login'])) {
			$login = mysql_real_escape_string($_POST['login']);
			$pwd = mysql_real_escape_string($_POST['pwd']);
			
			//Есть ли такой	 пользователь?
			$res = $pdo->query("SELECT * FROM user WHERE login='$login' AND pwd='$pwd'");
			$row = $res->fetch(); 
			
		    if (!empty($row)) {
				//Если найдена соответствующая запись в таблице user, значит всё OK. Поэтому:
				// 1. Создаём переменную сессии, которая будет регулировать доступ к администритивным функциям:
				$_SESSION['isAdmin'] = true;
				// 2. И выводим сообщение об успешной авторизации:
				echo 'Успешный вход. Вы администртор.';
			}
			else {
				//Попытка авторизации не удалась. Поэтому:
				// 1. Передаём в переменной сессии факт неудачной авторизации:
				$_SESSION['isAdmin'] = false;
				// 2. И выводим сообщение о провале авторизации:
				echo 'Авторизация не удалась. Попробуйте ещё раз'; 
			};
		 
		};	// if (isSet($_POST['login']))
			
		//---------------------------------------
		//К этой точке сценария уже понятно, авторизован ли пользователь.

		if ( $_SESSION['isAdmin'] ) {
		//Если ранее уже была успешная авторизация,
		// то это должен быть запрос на "выход".
		
		  if ($_GET['o']=='logout') {
			  session_destroy();
			  $_SESSION['isAdmin'] = false;
		  	  echo 'Вы вышли из авторизованного режима...';	
		  };	  
		}
		else {
		//Этот блок задействован, если ещё нет успешной авторизации.	
		//То ли пользователь ещё не пытался авторизоваться, то ли ошибся при вводе логина/пароля.	
		// В любом случае выводим форму:
		?>	
	
		<form id="auth" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div id="auth">
		  <div class="field">
			<div>Пользовательское имя</div>
			<div><input type="text" name="login" autofocus /></div>
		  </div> 
		  <div class="field">
			<div>Пароль</div>
			<div><input type="password" name="pwd" /></div>		
		  </div>		
		  <div class="field">
			<input type="submit" value="OK">
          </div>  
		</div>  
		</form>
		
		<?php
		};	// else    if ( $_SESSION['isAdmin'] )
		?>     
	  </div>	
	</div>  

	<?php include 'inc/footer.php'; ?>	

</body>
</html>
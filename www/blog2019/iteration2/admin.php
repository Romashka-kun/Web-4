<?php 
	require_once 'inc/session.php';
	require_once 'inc/settings.php';	
	require_once 'inc/db-connect.php';
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Администрирование</title>
    <?php include 'inc/head_tags.php';  ?>	
</head>

<body>
    <?php
     include 'inc/header.php'; 
	 require_once 'inc/menu.php'; 
	?>	
	
	<div id="node">
	  <div class="wrap">

	<?
	  if (!$isAdmin) {
		echo 'У вас нет прав для просмотра этой страницы'; 
		exit;
	  };
    ?>
	  
	    <h1 class='pageTitle'>Администрирование</h1>
	  
	    <h2>Добавление страницы</h2>
		<a href="page.php?o=add">Добавить</a>
		
		<h2>Редактирование</h2>
	    <ul id="admin-list">
		
	    <?php
	      //-------------------------------------------------------------------------------
		  //Выведем список заголовков существующих страниц со ссылками на их редактирование
		  //----- Получаем из БД (таблица node) всё в порядке "новый впереди"
		  //		результат - в переменной $res
		  $res = $pdo->query("SELECT node_id, title, created FROM node ORDER BY created DESC");
		
		 //----- И теперь в цикле из переменной $res получаем очередную строку $row результата SQL-запроса:
		   while ($row = $res->fetch()) {
			//	Из $row на каждой итерации можно извлечь полученные значения полей:
			$nodeID = $row['node_id'];
			$title = $row['title'];
			$created = $row['created'];
			
			//Выводим заголовок очередной страницы со ссылкой на её редактирование:
			echo "<li><a href='page.php?n=$nodeID&o=edit'>$title</a> ($created)</li>\n";
		  };	
	    ?>
	    </ul>
	      
	  </div>	
	</div>  

	<?php include 'inc/footer.php'; ?>	

</body>
</html>
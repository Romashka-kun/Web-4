<?php 
	require_once 'inc/session.php';
	require_once 'inc/settings.php';	
	require_once 'inc/db-connect.php';
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Блог</title>
    <?php include 'inc/head_tags.php';  ?>	
</head>

<body>
    <?php
     include 'inc/header.php'; 
	 require_once 'inc/menu.php'; 
	?>	
	
	<div id="node">
	  <div class="wrap">
	    <div id="post-list">
	  <?php
	    //-----------------------------------------------------------------------------------------------
		// К этому моменту мы уже успешно связались с БД, ибо не возникло ошибки в сценарии
		//	inc/db-connect.php, обеспечивающим связь с БД,
		//	  который - в свою очередь - использует ОСНОВНЫЕ ПАРАМЕТРЫ, определённые в inc/settings.php.
	    //-----------------------------------------------------------------------------------------------
	    
		//-----------------------------------------------------------------------------------------------
		// Раз уж связь с БД есть, выводим список аннотаций к постам со ссылками на соответствующие страницы, а именно:
		
		  //----- Получаем из БД (таблица node) нужные поля для страниц типа post в порядке "новый впереди"
		  //		результат - в переменной $res
		  $res = $pdo->query("SELECT node_id, title, annot, alias, created FROM node 
                                            WHERE node_type='post' ORDER BY created DESC");
		
		 //----- И теперь в цикле из переменной $res получаем очередную строку $row результата SQL-запроса:
		   while ($row = $res->fetch()) {
			//	Из $row на каждой итерации можно извлечь полученные значения полей:
			$nodeID = $row['node_id'];
			$title = $row['title'];
			$annot = $row['annot'];
			$alias = $row['alias'];
			
			//выводим заголовок со ссылкой на очередную страницу и аннотацию к ней:
		    echo "<div class='post-link'>\n";	
		      echo "<div class='row-title'><a href='/$alias'>$title</a></div>\n";
			  echo "<div class='row-annot'>$annot</div>\n";
		    echo "</div>\n";	
		  };	
	  ?>
	   </div>
	  </div>	
	</div>  

	<?php include 'inc/footer.php'; ?>	

</body>
</html>
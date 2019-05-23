<?php 	
  
  require_once 'inc/session.php';
  require_once 'inc/settings.php';
  require_once 'inc/db-connect.php'; 
  
  //Есть ли запрос на показ/редактирование/добавление?
  
  $operation = 'none';	//По умолчанию: операция не задана
  $pageExists = true;	//По умолчанию: пока надеемся, что запрошенная страница существует
  $nodeID = 0;			//По умолчанию задаём заведомо несуществующий ID страницы. 
						//  Далее в случае правильного запроса $nodeID примет соответствующее значение
  
  //----------------------------------------
  //Ситуация 1: запрос на добавление
  //То есть page.php?o=add
  
  if (@$_GET['o']=='add') 
	  $operation = 'add';
  
  //----------------------------------------
  //Ситуация 2: запрос на 
  // а) показ содержимого страницы
  //	То есть page.php?n=id_страницы
  // б) редактирование страницы
  //	То есть page.php?n=id_страницы&o=edit
  //В обоих случаях передан id_страницы
  
  if (isSet($_GET['n'])) {
  //передан ID страницы  
  
    //Какая страница запрошена?
    // NB! Безопасность
    $nodeID = (int)$_GET['n'];	
  
    //Какая операция предполагается?
	if (@$_GET['o']=='edit')
	//возможный запрос на редактирование	
		$operation = 'edit';
	else	
		$operation = 'show';	//показать содержимое страницы
	
	//А ещё может быть запрос на удаление страницы, но мы в этом примере его не рассматриваем
	
	//Используя ID страницы, выполняем запрос на получение её полей 
	// (для вывода либо редактирования):
	
    $res = $pdo->query("SELECT * FROM node WHERE node_id=$nodeID");
    $row = $res->fetch();  
	
	//Если адрес вида page.php?n=ID сформирован нашими сценариями, то мы получили поля СУЩЕСТВУЮЩЕЙ страницы.
	//Если же это вражеский эксперимент, то результат запроса пуст.
	
	$pageExists = !empty($row);
	
  };	// END if (isSet($_GET['n'])) (передан ID страницы)	
	  
  //----------------------------------------
  //Ситуация 3:
  //Если никакие параметры не переданы, то
  // а) либо это результат запроса на добавление / редактирование,
  // б) либо предполагаем, что в адресе использован синоним и ищем соответствующую страницу:

  if ( ($_SERVER['QUERY_STRING']=='') && ($_SERVER['REQUEST_URI']!='/page.php') ) {
	
    //получаем предполагаемый синоним:
	$alias = mysql_real_escape_string(substr($_SERVER['REQUEST_URI'], 1));	
	
	//Есть ли страница с таким синонимом?
	$res = $pdo->query("SELECT * FROM node WHERE alias='$alias'");
    $row = $res->fetch(); 
	  
	//Если адрес вида page.php?n=ID сформирован нашими сценариями, то мы получили поля СУЩЕСТВУЮЩЕЙ страницы.
	//Если же это вражеский эксперимент, то результат запроса пуст.
	
	$pageExists = !empty($row);
    $operation = 'show';
	
  };	// END if ($_SERVER['QUERY_STRING']=='')

  
  //----------------------------------------
  //Если предполанается операция показа содержимого страницы или её редактирования,
  // и страница существует:

  if ( $pageExists && ( ($operation=='show') || ($operation=='edit') )) { 

      //Если результат запроса непустой:      
      //Переменная $row - массив с ключами, соответствующими именам полей таблицы node
	  //Дальнейшие переменные пригодятся для вывода страницы или для начальных значений полец при её редактировании:
      $title = $row['title'];
      $body = $row['body'];
	  $annot = $row['annot'];
	  $alias = $row['alias'];
	  $created = $row['created'];
	  $node_type = $row['node_type'];

  };	// END if ( $pageExists && ( ($operation=='show') || ($operation=='edit') ))
 
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title><?php echo "$title :: $siteName"; ?></title>
	<?php include 'inc/head_tags.php';  ?>	
</head>

<body>
    <?php
     include 'inc/header.php'; 
	 require_once 'inc/menu.php'; 
	?>
	
	<div id="node">
	  <div class="wrap">
	  <?php 
	    if ( $pageExists )  {
		  if ($operation=='show') {	
				//выводим содержимое страницы:	
				echo "<h1 class='pageTitle'>$title</h1>";
				echo "<div id='created'>$created</div>";
				echo "<div id='main'>$body</div>";	
		  }
		  else {
				//включаем форму изменения/добавления:	
				require 'inc/edit.php';	
		  }
		}  
		else {
			echo '<h1>Ошибка 404. Запрошенная страница не существует.</h1>';
		}	
		  			
	  ?>
	  </div>	
	</div>  

	<?php include 'inc/footer.php'; ?>	

</body>
</html>
<?php

  if (!$isAdmin) {
	echo 'У вас нет прав для просмотра этой страницы'; 
	exit;
  };	
  
  //----------------------------
  //----------------------------
  //Если запрос на добавление или редактирование, выводим форму.
  //  NB! Очевидно, что это можно делать только для авторизованного пользователя с соответствущими полномочиями.
  
  //Если предполагается редактирование и результат запроса по переданному ID страницы непустой
  //  (то есть такая страница существует),
  //  то переменная $pageExists имеет значение true (см. page.php).

  if ( ($operation=='add') || (($operation=='edit')&&$pageExists) ) {
  //Если запрос на добавление страницы или изменение СУЩЕСТВУЮЩЕЙ,
  //  выводим заголовок:
  
    if ($operation=='add') 	echo "<h1 class='pageTitle'>Новая страница</h1>";	
	if ($operation=='edit') echo "<h1 class='pageTitle'>$title <em>(Редактирование)</em></h1>";
		
  //  и выводим форму:

  ?>  
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="edit">
 <div class="field">
  <div>Заголовок</div>
  <div><input type="text" name="title" <?php if ($operation=='edit') echo "value='$title'"?> autofocus required /></div>
 </div> 
 <div class="field">
  <div>Аннотация</div>
  <div><textarea name="annot" rows="5"><?php if ($operation=='edit') echo $annot;?></textarea></div>
 </div> 
 <div class="field">
  <div>Основное содержимое</div>
  <div><textarea type="text" name="body" rows="15"><?php if ($operation=='edit') echo $body;?></textarea></div>
 </div> 
 <div class="field">
  <div>Синоним адреса</div>
  <div><input type="text" name="alias" <?php if ($operation=='edit') echo "value='$alias'"?> required /></div>
 </div> 
 <div class="field">
  <div>Тип страницы</div>
  <!--<div><input type="text" name="node_type" <?php if ($operation=='edit') echo "value='$node_type'"?> /></div>-->
  <div>
    <select name="node_type" required>
	 <option value="post" <?php if (($operation=='edit')&&($node_type=='post')) echo "selected"?>>Заметка в блоге</option>
	 <option value="page" <?php if (($operation=='edit')&&($node_type=='page')) echo "selected"?>>Обычная страница</option>
	</select>
  </div>
 </div> 
  <input type="hidden" name="created" <?php if ($operation=='edit') echo "value='$created'"; else echo 'value="'.date("Y-m-d H:m:s").'"';?> />
  <input type="hidden" name="operation" <?php echo "value='$operation'";?> />
  <input type="hidden" name="node_id" <?php if ($operation=='edit') echo "value='$nodeID'";?> />
 <div class="field">
  <input type="submit" value="Сохранить">
 </div> 
</form> 

<?php
  };	// END if ( ($operation=='add') || (($operation=='add')&&$pageExists) )  Если запрос на добавление страницы или изменение СУЩЕСТВУЮЩЕЙ
  
  if ( ($operation=='edit')&&!$pageExists ) {
	//На всякий случай...  
	echo 'У Вас нет прав на просмотр этой страницы';
	exit;
  };	

  //----------------------------
  //----------------------------
  //В этом же сценарии выводим сообщение об успешном результате выполнения запроса на добавление/изменение страницы.
  // Если этот запрос был выполнен, то определён глобальный массив $_POST, поскольку начальном теге <form> указано:
  //  данные формы передаются методом POST и обрабатываются ТЕКУЩИМ СЦЕНАРИЕМ ($_SERVER['PHP_SELF'])
  
  if (isSet($_POST['title'])) {
	  
	//Здесь мы пока приводим устаревший вариант обработки введённых данных с помощью функции mysql_real_escape_string()
	//  Но даже так в значительной степени экранируются потенциально опасные символы, несущие угрозу SQL-инъекции

    $nodeID =  mysql_real_escape_string($_POST['node_id']);
	$title =  mysql_real_escape_string($_POST['title']);
    $body =  mysql_real_escape_string($_POST['body']);
	$annot =  mysql_real_escape_string($_POST['annot']);
	$alias =  mysql_real_escape_string($_POST['alias']);
	$created =  mysql_real_escape_string($_POST['created']);
	$node_type =  mysql_real_escape_string($_POST['node_type']);
	$operation =  mysql_real_escape_string($_POST['operation']);
	  
	if ($operation=='add') 	{	
		$res = $pdo->query("INSERT INTO node (title, body, annot, alias, created, node_type) 
							VALUES ('$title', '$body', '$annot', '$alias', '$created', '$node_type')");
		
		echo "Страница <strong>$title</strong> добавлена";	
    };	

	if ($operation=='edit') 	{	
		$res = $pdo->query("UPDATE node SET title='$title', body='$body', annot='$annot', alias='$alias', created='$created', node_type='$node_type' 
							WHERE node_id=$nodeID");
		
		echo "Страница <strong>$title</strong> изменена";	
    };		
	  
  };	  
?>	  
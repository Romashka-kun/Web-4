<?php

//параметры связи с базой данных:
$opt = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
);

//пытаемся связаться с БД $dbName от имени пользователя $userName:
try {
	$dsn = "mysql:host=$hostName; dbname=$dbName";
	$pdo = new PDO($dsn, $userName, $userPwd, $opt);
	//Теперь можно использовать переменную $pdo для реализации SQL-запросов к БД
	}
catch (PDOException $e) {
    echo '<p style="text-align:center; margin-top:50px;">Нет связи с базой данных. Попробуйте перезагрузить страницу позже.</p>';
    echo $e->getMessage();
	exit;
};	

?>
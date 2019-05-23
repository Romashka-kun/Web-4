<!doctype html>
<html>
<head>
 <title>Scandir with AJAX</title>
<style>
 .subDir {margin-left: 20px;}
 .dir {font-weight: bold; color: red; cursor: pointer;}
 .file {margin-left: 20px;}
</style>
<script src="https://code.jquery.com/jquery-1.11.2.js"></script>
<script>
$(document).ready ( function() {

// Привычная краткая форма объявления обработчика не работает с элементами, сгенерированными сценарием:
// $('.dir').click ( function() {
// Поэтому применяем альтернативный вариант:	
	$(document).on('click', '.dir', function () {
	
	var dirPath = $(this).attr('rel');
	
	$(this).after('<div class="subDir">...</div>');
	
	var subDir = $(this).next('.subDir');
	
	$.ajax({
		type: 'GET',
		url: 'ajax-for-scandir.php',
		data: 'qq=' + dirPath,
		success: function(data) {
			subDir.html(data)
		}	
	});
 })
});
</script>
</head>
<body>
<?
/*
function showdir($dirName) {
  $q = scandir($dirName);
  
  foreach ($q as $fileName) {
	if ( ($fileName=='.') || ($fileName=='..') ) continue;
	
	$pathToFile = "$dirName/$fileName";
	
	if (is_dir($pathToFile)) 
		echo "<div class='dir' rel='$pathToFile'>$fileName</div>\n";
	else
	  echo "  <div class='file'>$fileName</div>\n";	
	
  };	//end foreach
  
};	//end showDir()

showdir('.');
*/
  // Включаем файл, в котором описана функция showdir(). Здесь она будет вызвана для сканирования текущего каталога. 
  require_once('ajax-for-scandir.php');		
?>  
</body>
</html>
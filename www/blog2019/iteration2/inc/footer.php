	<div id="footer">
	 <div class="wrap">
	 <?php 
		//В подвале, как правило, размещается статическая информация: контакты, копирайт и т.д.
		//Но вполне может быть и повторение основной навигации (menu.php)
	 ?>
	  <p>Существенная информация в подвале...</p>
	  <p style="text-align: right;">
	 <?php
	  if ($_SESSION['isAdmin']) {
		  echo '<a href="/auth.php?o=logout">Выход</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/admin.php">Администрирование</a>';
	  }
	  else {
		  echo '<a href="/auth.php">Вход</a>';
	  };
	 ?> 
	  </p>
	 </div>
	</div>	
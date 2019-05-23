<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Scandir</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link href="scandir.css" type="text/css" rel="stylesheet"/>
    <script src="scandir.js" type="text/javascript"></script>
</head>
<body>
<?
require_once('toolbar.php');
?>
<div class="tree">
    <li class="root">
        <div class="content" rel="<? echo $_SERVER['DOCUMENT_ROOT']?>">
            <span class='navbar-arrow-opened'></span><span class='navbar-dir-opened'></span>
            www.com
        </div>
<?php

require_once('ajax-for-scandir.php');

?>
    </li>
</div>
<div class="table">
    <table>
        <thead>
            <tr class="table-item">
                <td>Имя</td>
                <td>Права доступа</td>
                <td>Дата изменения</td>
                <td>Размер</td>
                <td>Тип</td>
            </tr>
        </thead>
<?php

require_once('ajax-table-content.php');

?>
    </table>
</div>
</body>
</html>

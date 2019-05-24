<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Scandir</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
<div id="dialog-confirm" title="Empty the recycle bin?">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>These items will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>
</body>
</html>

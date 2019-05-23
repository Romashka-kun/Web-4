<?php
/**
 * Created by IntelliJ IDEA.
 * User: braid
 * Date: 08.04.2019
 * Time: 15:47
 */

if (isSet($_GET['dir']))
    showTree(new FilesystemIterator($_GET['dir']));
else
    showTree(new FilesystemIterator($_SERVER['DOCUMENT_ROOT']));

function showTree($dir) {

    echo "<ul class='container'>";

    foreach ($dir as $file)
        if ($file->isDir())
            echo "<li class='dir'><div class='content' rel='$file'>
                    <span class='navbar-arrow-closed'></span><span class='navbar-dir-closed'></span>
                    {$file->getFilename()}</div></li>";

    echo "</ul>";
}
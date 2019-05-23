<?php

if (isSet($_GET['dir']))
    showTable(new FilesystemIterator($_GET['dir']));
else
    showTable(new FilesystemIterator($_SERVER['DOCUMENT_ROOT']));

function showTable($dir)
{
    $directories = array();
    $files = array();

    foreach ($dir as $file) {

        if ($file->isDir())
            $directories[] = $file;
        else
            $files[] = $file;
    }

    $tz = 'Europe/Moscow';
    $date = new DateTime();
    $date->setTimezone(new DateTimeZone($tz));

    foreach ($directories as $directory) {
        $perms = substr(sprintf("%o", $directory->getPerms()), -4);
        $time = $directory->getMTime();
        $date->setTimestamp($time);
        echo "<tr class='table-item table-dir' rel='$directory'>
                    <td class='col-name'>{$directory->getFilename()}</td>
                    <td class='col-perm'>$perms</td>
                    <td class='col-date'>{$date->format('d-m-Y H:i')}</td>
                    <td class='col-size'>-</td>
                    <td class='col-type'>{$directory->getExtension()}</td>
                </tr>";
    }

    foreach ($files as $file) {
        $perms = substr(sprintf("%o", $file->getPerms()), -4);
        $time = $file->getMTime();
        $date->setTimestamp($time);
        $size = formatBytes($file->getSize());
        echo "<tr class='table-item table-file'>
                    <td class='col-name'>{$file->getFilename()}</td>
                    <td class='col-perm'>$perms</td>
                    <td class='col-date'>{$date->format('d-m-Y H:i')}</td>
                    <td class='col-size'>$size</td>
                    <td class='col-type'>{$file->getExtension()}</td>
                </tr>";
    }
}

function formatBytes($bytes, $precision = 2)
{
    $units = array('КБ', 'МБ', 'ГБ');
    $bytes = max($bytes, 1024);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= (1 << (10 * $pow));

    return round($bytes) . ' ' . $units[$pow - 1];

}
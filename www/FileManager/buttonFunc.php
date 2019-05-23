<?php

if (isSet($_POST['createFolder']))
    createFolder($_POST['createFolder']);
elseif (isSet($_POST['createFile']))
    createFile($_POST['createFile']);

function createFolder($dir)
{
    mkdir(addNumberIfExists($dir));
}

function createFile($file)
{
    fopen(addNumberIfExists($file), 'w');
}

function addNumberIfExists($fname)
{
    $original_name =pathinfo($fname,PATHINFO_FILENAME);
    $extension = pathinfo($fname, PATHINFO_EXTENSION);

    $i = 1;
    while (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $fname)) {
        $fname = (string)$original_name . " ($i)";
        if ($extension)
            $fname .= $extension;
        $i++;
    }
    return $_SERVER['DOCUMENT_ROOT'] . '/' . $fname;
}
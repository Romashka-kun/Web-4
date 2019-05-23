<!doctype html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Upload</title>
    </head>

    <body>
        <h2>Upload</h2>
        <form method="post" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF'] ?>">
            <input type="file" name="ff"/>
            <input type="submit" value="Send!" name="send"/>
        </form>
        <pre>
        <?
        print_r($_FILES);
        $uploadDir = 'upload';
//        phpinfo();

        if (!file_exists($uploadDir))
            mkdir($uploadDir, 0777);

        if (isSet($_FILES['ff']['tmp_name'])) {
            //файл успешно загружен
            //проверить код ошибки
            //проверить mime-type

            //новое имя файла
            $name = "$uploadDir/".time();

            if (move_uploaded_file($_FILES['ff']['tmp_name'], $name)) {
                echo 'Файл ' . $_FILES['ff']['name'] . ' успешно загружен';
//                bool imageCopyResized(resourse $dst_img, resourse $src_img,
//                    int $dst_x, int $dst_y, int $src_x, int $src_y,
//                    int $dst_width, int$src_width, int $dst_height, int $src_height )
                $image0 = imageCreateFromJpeg($name);
                $width0 = imageSX($image0);
                $height0 = imageSY($image0);
                $width = 250;
                $height = $height0 * $width0 / $width;
                $image = imageCreateTrueColor($width, $height);
                imageCopyResized($image, $image0, 0, 0, 0, 0, $width0, $height0, $width, $height);
                imageJpeg($image, "$name-thumb");

            }
        } else {
            //сообщаем о неудаче
        }
        ?>
        </pre>
    </body>
</html>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Comments</title>
    </head>
    <body>
        <form method="get" action="<?=$_SERVER['PHP_SELF']?>"> <!-- PHP_SELF - адрес текущего сценария -->
            <textarea name="inf" cols="80" rows="5"></textarea>
            <input type="submit" name="ok" value="Send" />
        </form>
        <?php
        /**
         * Created by IntelliJ IDEA.
         * User: braid
         * Date: 18.03.2019
         * Time: 14:52
         */
        $comment_fileName = "comments.dat";

        //открываем файл
        $f = fopen($comment_fileName, 'a+');

        //если пришла информация из формы, пишем её в файл:
        if (isSet($_GET['inf'])) {
            $newinf = $_GET['inf'];
            $newinf = HTMLSpecialChars(trim($newinf));
            $newinf = str_replace("\n", "<br>", $newinf);

            fputs($f, "$newinf\n");
            fflush($f);
        }

        fclose($f);

        //записываем
        $data = array();

        if (fileSize($comment_fileName) > 0)
            $data = file($comment_fileName);

        //выводим
        for ($i = count($data) - 1; $i >= 0; $i--)
            echo $data[$i].'<hr>';
        ?>
    </body>
<html>

<?php
    session_start();

    if (isset($_SESSION['isAdmin']) && $_SESSION)
        $isAdmin = true;
    else
        $isAdmin =  false;

?> 
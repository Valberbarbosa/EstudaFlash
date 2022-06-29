<?php

session_start();


setcookie('session', '', -1, '/');
setcookie('hash', '', -1, '/');

header('Location: /index.php');
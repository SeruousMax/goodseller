<?php
function request_url($get=true) {
    $result = ''; // Пока результат пуст
    $default_port = 80; // Порт по-умолчанию

    // А не в защищенном-ли мы соединении?
    if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=='on')) {
        // В защищенном! Добавим протокол...
        $result .= 'https://';
        // ...и переназначим значение порта по-умолчанию
        $default_port = 443;
    } else {
        // Обычное соединение, обычный протокол
        $result .= 'http://';
    }
    // Имя сервера, напр. site.com или www.site.com
    $result .= $_SERVER['SERVER_NAME'];

    // А порт у нас по-умолчанию?
    if ($_SERVER['SERVER_PORT'] != $default_port) {
        // Если нет, то добавим порт в URL
        $result .= ':'.$_SERVER['SERVER_PORT'];
    }
    if ($_SERVER['PHP_SELF']!='/index.php')
        $result.=$_SERVER['PHP_SELF'];
    // Последняя часть запроса (путь и GET-параметры).
    if ($get) $result .= $_SERVER['REQUEST_URI'];
    // Уфф, вроде получилось!
    return $result;
}

$scandir = scandir($_SERVER['DOCUMENT_ROOT']. '/models/');
for ($i = 0; $i < count($scandir); $i++) {
    if (mb_strpos($scandir[$i], '.class.php')) {
        include $_SERVER['DOCUMENT_ROOT'] . '/models/' . $scandir[$i];
    }
}

$scandir = scandir($_SERVER['DOCUMENT_ROOT'] . '/services/');
for ($i = 0; $i < count($scandir); $i++) {
    if (mb_strpos($scandir[$i], '.class.php')) {
        include $_SERVER['DOCUMENT_ROOT'] . '/services/' . $scandir[$i];
    }
}
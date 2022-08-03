<?php

$request = $_SERVER['REQUEST_URI'];

// var_dump(parse_url($request, PHP_URL_PATH)); die;

if ($request === '/') {
    $page = 'app/admin/login.php';
} else if ($request === '/admin') {
    $page = 'app/admin/index.php';
} else if (substr($request, 0, 6) === '/admin') {
    $params = substr($request, 7);
    $param = explode('/', $params);
    if($param[0] === 'edit'){
        $page = 'app/admin/get_data_id.php';
    }else{
        $page = 'app/admin/update.php';
    }
} else if (substr($request, 0, 9) === '/kegiatan') {
    $params = substr($request, 10);
    $page = 'app/post.php';
} else if ($request === '/logout') {
    $page = 'app/admin/logout.php';
} else if ($request === '/404') {
    http_response_code(404);
    $page = '404.php';
} else {
    if (!file_exists('index.php')) {
        header('Location: /404');
        exit();
    }
    header('Location: /404');
    exit();
}

include_once($page);

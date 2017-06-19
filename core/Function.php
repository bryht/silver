<?php

function p($var)
{
    if (is_bool($var)) {
        var_dump($var);
    } elseif (is_null($var)) {
        var_dump(null);
    } else {
        echo "<pre style='position:relative;z-index:1000;padding:10px;border-radius:5px;background:#F5F5F5;border:1px solid #aaa;font-size:14px;line-height:18px;opacity:0.9;'>" . print_r($var, true) . "</pre>";
    }
}

function pShow($value = '', $type = 'obj')
{
    switch ($type) {
        case 'string':
            throw new \Exception($value);
            break;
        case 'obj':
            throw new \Exception(json_encode($value));
            break;
    }
}

function guid($trim = true)
{
    // Windows
    if (function_exists('com_create_guid') === true) {
        if ($trim === true) {
            return trim(com_create_guid(), '{}');
        } else {
            return com_create_guid();
        }

    }

    // OSX/Linux
    if (function_exists('openssl_random_pseudo_bytes') === true) {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    // Fallback (PHP 4.2+)
    mt_srand((double) microtime() * 10000);
    $charid = strtolower(md5(uniqid(rand(), true)));
    $hyphen = chr(45); // "-"
    $lbrace = $trim ? "" : chr(123); // "{"
    $rbrace = $trim ? "" : chr(125); // "}"
    $guidv4 = $lbrace .
    substr($charid, 0, 8) . $hyphen .
    substr($charid, 8, 4) . $hyphen .
    substr($charid, 12, 4) . $hyphen .
    substr($charid, 16, 4) . $hyphen .
    substr($charid, 20, 12) .
        $rbrace;
    return $guidv4;
}

function errorHandler($errno, $errstr, $errfile, $errline)
{
    $arr = array(
        '[' . date('Y-m-d H-i-s') . ']',
        $errno,
        '|',
        $errstr,
        $errfile,
        'line:' . $errline,
    );
    //formate：  [time] [errorNum or errorType] | errstr errorfile lineNum
    if (is_dir(LOG) == false) {
        mkdir(LOG, 0777, \TRUE);
    }
    error_log(implode(' ', $arr) . "\r\n", 3, LOG . date('Y-m-d') . '.log', 'extra');
}

function fatalErrorHandler()
{
    $e = error_get_last();
    errorHandler($e['type'], $e['message'], $e['file'], $e['line']);
}

function session_set($name, $value)
{
    if (!session_id()) {
        session_start();
    }
    $_SESSION[$name] = $value;
}

function session_get($name)
{
    if (!session_id()) {
        session_start();
    }
    if (isset($_SESSION[$name])) {
        return $_SESSION[$name];
    } else {
        return false;
    }
}

function get_upload_path($type)
{
    $date = new \DateTime();
    $pathDate = $date->format('Y-m-d');
    $pathUrl = UPLOAD_RELATIVE . $type . '\\' . $pathDate . '\\';
    $pathDir = UPLOAD . $type . '/' . $pathDate . '/';
    $path['url'] = $pathUrl;
    $path['dir'] = $pathDir;
    return $path;
}

function upload_file($file)
{
    if ($file['error'] == UPLOAD_ERR_OK) {
        $temp_name = $file['tmp_name'];
        $file_name = $file['name'];
        $path = get_upload_path('img');
        if (is_dir($path['dir']) == false) {
            mkdir($path['dir'], 0777, \TRUE);
        }
        move_uploaded_file($temp_name, $path['dir'] . $file_name);
        return array('ok' => true, 'result' => $path['url'] . $file_name);
    } else {
        return array('ok' => false, 'error' => 'upload file fail!<br/>' . $file['error']);
    }
}

function base64_to_file($file_name, $base64Url)
{
    $path = get_upload_path('img');
    if (is_dir($path['dir']) == false) {
        mkdir($path['dir'], 0777, \TRUE);
    }
    $fileInfo = explode(',', $base64Url);
    $size = file_put_contents($path['dir'] . $file_name, base64_decode($fileInfo[1]));
    if ($size > 0) {
        return array('ok' => true, 'result' => $path['url'] . $file_name, 'size' => $size);
    } else {
        return array('ok' => false, 'error' => 'upload file fail!<br/>');
    }
}

function goback($step = -1)
{
    echo "<script>history.go(" . $step . ");</script>";
}

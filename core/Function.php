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
    error_log(implode(' ', $arr) . "\r\n", 3, LOG.date('Y-m-d').'.log', 'extra');
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
    return UPLOAD. $type . '\\' . $pathDate . '\\';
}

function upload_file($file)
{
    if ($file['error'] == UPLOAD_ERR_OK) {
        $temp_name = $file['tmp_name'];
        $file_name = $file['name'];
        $path = get_upload_path('img');
        if (is_dir($path) == false) {
            mkdir($path, 0777, \TRUE);
        }
        move_uploaded_file($temp_name, SILVER . $path . $file_name);
        return array('ok' => true, 'result' => $path . $file_name);
    } else {
        return array('ok' => false, 'error' => 'upload file fail!<br/>' . $file['error']);
    }
}


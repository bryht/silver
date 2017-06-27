<?php

namespace core;

class Conf
{
    public static function get_database()
    {
        return array(
            'database_type' => 'mysql',
            'database_name' => 'gallery',
            'server' => 'localhost',
            'username' => 'root',
            'password' => 'liming',
            'charset' => 'utf8',
            'prefix' => 'silver_',
        );
    }

    public static function get_init_index()
    {
        return array(
            'control' => 'index',
            'action' => 'index');
    }

    public static function get_mail()
    {
        return array(
            'host' => 'smtp-mail.outlook.com', // Specify main and backup SMTP servers
            'mail' => 'service_bryht@outlook.com', // SMTP username
            'password' => 'Bb123456', // SMTP password
            'smtpsecure' => 'tls', // Enable TLS encryption, `ssl` also accepted STARTTLS
            'port' => '587', // TCP port to connect to
        );

    }

}

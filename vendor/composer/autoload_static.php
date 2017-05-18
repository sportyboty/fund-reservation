<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita9cfbe772b9e7d5a4fa0fd57b457eac7
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MerryPayout\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MerryPayout\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
    );

    public static $classMap = array (
        'EasyPeasyICS' => __DIR__ . '/..' . '/phpmailer/phpmailer/extras/EasyPeasyICS.php',
        'PHPMailer' => __DIR__ . '/..' . '/phpmailer/phpmailer/class.phpmailer.php',
        'PHPMailerOAuth' => __DIR__ . '/..' . '/phpmailer/phpmailer/class.phpmaileroauth.php',
        'PHPMailerOAuthGoogle' => __DIR__ . '/..' . '/phpmailer/phpmailer/class.phpmaileroauthgoogle.php',
        'POP3' => __DIR__ . '/..' . '/phpmailer/phpmailer/class.pop3.php',
        'SMTP' => __DIR__ . '/..' . '/phpmailer/phpmailer/class.smtp.php',
        'ntlm_sasl_client_class' => __DIR__ . '/..' . '/phpmailer/phpmailer/extras/ntlm_sasl_client.php',
        'phpmailerException' => __DIR__ . '/..' . '/phpmailer/phpmailer/class.phpmailer.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita9cfbe772b9e7d5a4fa0fd57b457eac7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita9cfbe772b9e7d5a4fa0fd57b457eac7::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita9cfbe772b9e7d5a4fa0fd57b457eac7::$classMap;

        }, null, ClassLoader::class);
    }
}

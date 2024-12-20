<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2be34dd0435d4b3e07cdb7f65b18cba6
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2be34dd0435d4b3e07cdb7f65b18cba6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2be34dd0435d4b3e07cdb7f65b18cba6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2be34dd0435d4b3e07cdb7f65b18cba6::$classMap;

        }, null, ClassLoader::class);
    }
}
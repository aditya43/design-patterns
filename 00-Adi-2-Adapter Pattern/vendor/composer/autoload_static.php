<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7cca6e508abf00f494d04a5725a688b0
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Adi\\Classes\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Adi\\Classes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Classes',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7cca6e508abf00f494d04a5725a688b0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7cca6e508abf00f494d04a5725a688b0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

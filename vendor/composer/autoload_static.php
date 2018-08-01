<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit562d90231320db5dee62e19ce6e2804f
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\models\\' => 11,
            'app\\core\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/models',
        ),
        'app\\core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/core',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit562d90231320db5dee62e19ce6e2804f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit562d90231320db5dee62e19ce6e2804f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

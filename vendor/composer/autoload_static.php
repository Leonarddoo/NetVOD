<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfa6d5b539feb2914ef2ebe3f4ce49ff3
{
    public static $prefixLengthsPsr4 = array (
        'i' => 
        array (
            'iutnc\\sae\\netvod\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'iutnc\\sae\\netvod\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/classes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfa6d5b539feb2914ef2ebe3f4ce49ff3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfa6d5b539feb2914ef2ebe3f4ce49ff3::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfa6d5b539feb2914ef2ebe3f4ce49ff3::$classMap;

        }, null, ClassLoader::class);
    }
}
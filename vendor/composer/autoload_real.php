<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitfa6d5b539feb2914ef2ebe3f4ce49ff3
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitfa6d5b539feb2914ef2ebe3f4ce49ff3', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitfa6d5b539feb2914ef2ebe3f4ce49ff3', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitfa6d5b539feb2914ef2ebe3f4ce49ff3::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}

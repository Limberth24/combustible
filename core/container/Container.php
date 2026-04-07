<?php

class Container
{
    private static $instances = [];
    private static $conn = null;

    public static function setConnection($conn)
    {
        self::$conn = $conn;
    }

    public static function getConnection()
    {
        return self::$conn;
    }

    public static function get($className)
    {
        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = new $className(self::$conn);
        }
        return self::$instances[$className];
    }

    public static function getService($className, $strategy = null)
    {
        $key = $className . ($strategy ? '_' . get_class($strategy) : '');
        if (!isset(self::$instances[$key])) {
            self::$instances[$key] = new $className($strategy);
        }
        return self::$instances[$key];
    }
}

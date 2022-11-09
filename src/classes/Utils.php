<?php

namespace iutnc\netvod;

use Exception;
use PDOStatement;

class Utils
{
    public static function pdo2string(PDOStatement $statement, string|int $key, $separator=', ', $start='', $end='', $before='', $after=''): string
    {
        $result = '';
        while ($data=$statement->fetch()) {
            $result .= ($result === '') ? $start : $separator ;
            $result .= $before.$data[$key].$after;
        }
        return $result.$end;
    }

    public static function linked_button(string $text, string $value, $method='get', $name='action'): string
    {
        return "<form method='$method'><button name='$name' value='$value' type='submit'>$text</button></form>";
    }

    public static function redirect($url='?'): void
    {
        header("Location: $url");
    }
}
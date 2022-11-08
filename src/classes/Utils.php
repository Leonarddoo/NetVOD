<?php

namespace iutnc\netvod;

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
}
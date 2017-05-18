<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/16/2017
 * Time: 8:30 PM
 */
class SelectQuery {

    public static function build(string $table, array $values, array $conditions, int $limit = null) : string {
        $sql = "SELECT ";
        if (count($values) > 0) {
            foreach ($values as $value) {
                $sql .= "$value, ";
            }
        }
        $sql .= "FROM $table WHERE ";
        if (count($conditions) > 0) {
            $i = 0;
            foreach ($conditions as $key => $value) {
                $sql .= "$key = $value ";
                if ($i < count($conditions) - 1) {
                    $sql .= "AND ";
                }
            }
        }
        if ($limit != null) {
            $sql .= "LIMIT $limit";
        }
        return $sql;
    }
}
<?php
namespace DB;
const HOST = 'localhost';
const USER = 'user';
const PASSWORD = 'DlSHH!.8YqUmjSO*';
const DB_NAME = 'test';
class MySQL
{
    public static function getDB()
    {
        return mysqli_connect(HOST, USER,PASSWORD,DB_NAME);
    }

    public static function query($query, $db = null)
    {
        if ($db === null) {
            $db = self::getDB();
        }
        if($result = $db->query($query)){
            $rows = array();
            while ($row = $result->fetch_object()){
                $rows[] = $row;
            }
            $result->close();
            return $rows;
        }
        return false;
    }

    public static function insert($query, $db = null)
    {
        if ($db === null) {
            $db = self::getDB();
        }
        if ($db->query($query)) {
            return mysqli_insert_id($db);
        }
        return false;
    }

    public static function del($query, $db = null)
    {
        if ($db === null) {
            $db = self::getDB();
        }
        if ($db->query($query)) {
            return true;
        }
        return false;
    }

}
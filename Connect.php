<?php
class ConnectDB
{
    public function connect()
    {    
        $host = 'localhost';
        $user = 'root';
        $cpasswd = '';
        $schema = 'organization';
        $pdo = NULL;
        $dsn = 'mysql:host=' . $host . ';dbname=' . $schema;
        try
        {  
            $pdo = new PDO($dsn, $user,  $cpasswd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        }
        catch (PDOException $e)
        {
            echo 'Database connection failed.';
            die();
            return false;
        } 
    }
}
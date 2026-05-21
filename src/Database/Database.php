<?php

namespace App\Database;

use PDO;
use PDOException;

class Database
{
    public PDO $pdo;
    public function __construct(array $config)
    {
        extract($config);
        $dsn = "$engine:host=$host;dbname=$dbname;charset=$charset";
        try {

            $this->pdo = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            echo "Conexion exitosa";

        } catch (PDOException $e) {
            throw new \Exception("Error de conexion a la base de datos: " . $e->getMessage());
        }
    }

    public function query(string $query, array $params = [])
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
        return $statement;
    }
}

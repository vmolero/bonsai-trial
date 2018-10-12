<?php

namespace PlanetaHuerto;

class BonsaiController
{
    public function list(): array
    {
        // Create (connect to) SQLite database in file
        $file_db = new \PDO('sqlite:bonsaitrial.sqlite3');
        // Set errormode to exceptions
        $file_db->setAttribute(
            \PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION
        );

        // Select all data from memory db messages table
        $result = $file_db->query('SELECT * FROM bonsai');
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function show($id): array
    {
        // Create (connect to) SQLite database in file
        $file_db = new \PDO('sqlite:bonsaitrial.sqlite3');
        // Set errormode to exceptions
        $file_db->setAttribute(
            \PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION
        );
        // Select all data from memory db messages table
        $stmt = $file_db->prepare('SELECT * FROM bonsai WHERE id = :id');
        $stmt->bindParam(':id', $id, SQLITE3_INTEGER);
        $res = $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

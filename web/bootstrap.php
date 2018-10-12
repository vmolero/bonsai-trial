<?php
 
// Set default timezone
date_default_timezone_set('UTC');

try {
    /**************************************
     * Create databases and                *
    * open connections                    *
    **************************************/

    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:bonsaitrial.sqlite3');
    // Set errormode to exceptions
    $file_db->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );
    /**************************************
    * Create tables                       *
    **************************************/
    // Drop table messages from file db
    $file_db->exec("DROP TABLE bonsai");

    // Create table messages
    $file_db->exec("CREATE TABLE IF NOT EXISTS bonsai (
        id INTEGER PRIMARY KEY,
        titulo TEXT,
        img TEXT,
        tipo INTEGER,
        abonar INTEGER,
        transplantar INTEGER,
        regar INTEGER)");
    
    /**************************************
    * Set initial data                    *
    **************************************/
 
    // Array with some test data to insert to database
    $data = array(
        array('titulo' => 'Bonsai 1',
              'tipo' => 1,
              'img' => 'ficus.jpg',
              'abonar' => 1,
              'transplantar' => 1,
              'regar' => 1),
        array('titulo' => 'Bonsai 2',
              'tipo' => 1,
              'img' => 'ficus.jpg',
              'abonar' => 1,
              'transplantar' => 1,
              'regar' => 1),
        array('titulo' => 'Bonsai 3',
              'tipo' => 1,
              'img' => 'manzano.jpg',
              'abonar' => 1,
              'transplantar' => 2,
              'regar' => 1),
        array('titulo' => 'Bonsai 4',
              'tipo' => 1,
              'img' => 'olmo.jpg',
              'abonar' => 1,
              'transplantar' => 3,
              'regar' => 1),
        array('titulo' => 'Bonsai 5',
              'tipo' => 1,
              'img' => 'olivo.jpg',
              'abonar' => 1,
              'transplantar' => 4,
              'regar' => 1)
    );
    
    /**************************************
    * Play with databases and tables      *
    **************************************/
 
    // Prepare INSERT statement to SQLite3 file db
    $insert = "INSERT INTO bonsai (titulo, tipo, img, abonar, transplantar, regar) 
                VALUES (:titulo, :tipo, :img, :abonar, :transplantar, :regar)";
    $stmt = $file_db->prepare($insert);
 
    // Bind parameters to statement variables
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':img', $img);
    $stmt->bindParam(':abonar', $abonar);
    $stmt->bindParam(':transplantar', $transplantar);
    $stmt->bindParam(':regar', $regar);

    // Loop thru all messages and execute prepared insert statement
    foreach ($data as $m) {
        // Set values to bound variables
        extract($m);
        // Execute statement
        $stmt->execute();
    }
    /*
    // Select all data from memory db messages table
    $result = $file_db->query('SELECT * FROM bonsai');

    foreach ($result as $row) {
        echo "Id: " . $row['id'] . "\n";
        echo "Title: " . $row['titulo'] . "\n";
        echo "Img: " . $row['img'] . "\n";
        echo "Abonar: " . $row['abonar'] . "\n";
        echo "Transplantar: " . $row['transplantar'] . "\n";
        echo "Regar: " . $row['regar'] . "\n";
        echo "\n";
    }
     */
} catch (PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
}

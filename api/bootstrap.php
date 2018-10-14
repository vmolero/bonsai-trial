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
    if (isset($_GET['drop'])) {
        $file_db->exec("DROP TABLE bonsai");
    }

    // Create table messages
    $file_db->exec("CREATE TABLE IF NOT EXISTS bonsai (
        id INTEGER PRIMARY KEY,
        titulo TEXT,
        img TEXT,
        tipo INTEGER,
        abonado TEXT,
        transplantado TEXT,
        regado TEXT,
        pulverizado TEXT)");
    
    /**************************************
    * Set initial data                    *
    **************************************/
    // Drop table messages from file db
    $file_db->exec("DELETE FROM bonsai");

    // Array with some test data to insert to database
    $data = array(
        array('titulo' => 'Bonsai 1',
              'tipo' => 1,
              'img' => 'ficus_200x200.png',
              'abonado' => '',
              'transplantado' => '',
              'regado' => '',
              'pulverizado' => ''),
        array('titulo' => 'Bonsai 2',
              'tipo' => 1,
              'img' => 'ficus_200x200.png',
              'abonado' => '',
              'transplantado' => '',
              'regado' => '',
              'pulverizado' => ''),
        array('titulo' => 'Bonsai 3',
              'tipo' => 2,
              'img' => 'manzano_200x200.png',
              'abonado' => '',
              'transplantado' => '',
              'regado' => '',
              'pulverizado' => ''),
        array('titulo' => 'Bonsai 4',
              'tipo' => 3,
              'img' => 'olmo_200x200.png',
              'abonado' => '',
              'transplantado' => '',
              'regado' => '',
              'pulverizado' => ''),
        array('titulo' => 'Bonsai 5',
              'tipo' => 4,
              'img' => 'olivo_200x200.png',
              'abonado' => '',
              'transplantado' => '',
              'regado' => '',
              'pulverizado' => '')
    );
    
    /**************************************
    * Play with databases and tables      *
    **************************************/
 
    // Prepare INSERT statement to SQLite3 file db
    $insert = "INSERT INTO bonsai (titulo, tipo, img, abonado, transplantado, regado, pulverizado) 
                VALUES (:titulo, :tipo, :img, :abonado, :transplantado, :regado, :pulverizado)";
    $stmt = $file_db->prepare($insert);
 
    // Bind parameters to statement variables
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':img', $img);
    $stmt->bindParam(':abonado', $abonado);
    $stmt->bindParam(':transplantado', $transplantado);
    $stmt->bindParam(':regado', $regado);
    $stmt->bindParam(':pulverizado', $pulverizado);

    // Loop thru all messages and execute prepared insert statement
    foreach ($data as $m) {
        // Set values to bound variables
        extract($m);
        // Execute statement
        $stmt->execute();
    }
    
    // Select all data from memory db messages table
    /*
    $result = $file_db->query('SELECT * FROM bonsai');

    foreach ($result as $row) {
        echo "Id: " . $row['id'] . "\n";
        echo "Title: " . $row['titulo'] . "\n";
        echo "Img: " . $row['img'] . "\n";
        echo "abonado: " . $row['abonado'] . "\n";
        echo "transplantado: " . $row['transplantado'] . "\n";
        echo "regado: " . $row['regado'] . "\n";
        echo "\n";
    }*/
} catch (PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
}

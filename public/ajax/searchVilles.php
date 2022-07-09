<?php

try {
    $dbh = new PDO('mysql:host=localhost;dbname=meubliton', 'root', '');
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

if (isset($_POST['type'])) {
    $input = $_POST['type'];
    $sth = $dbh->prepare("SELECT * from villes where nom like '%".$input."%' LIMIT 10");
    $sth->execute();
    $result = $sth->fetchAll();
    if (count($result) > 0) {
        echo '<option>Choisissez une ville</option><br>';
        foreach($result as $row) {
            echo '<option value="'.$row['id'].'">'.$row['nom'].'</option><br>';
        }
    } else {
        echo '<option selected>Aucune ville trouvée</option>';
    }
}
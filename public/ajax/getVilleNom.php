<?php

try {
    $dbh = new PDO('mysql:host=localhost;dbname=meubliton', 'root', '');
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

if (isset($_POST['numero'])) {
    $input = $_POST['numero'];
    $sth = $dbh->prepare("SELECT * from villes where id = ".$input."");
    $sth->execute();
    while ($row = $sth->fetch()) {
        echo $row['nom']."<br />\n";
    }
}
<?php

require "Compte.php";
require "Personne.php";

$pdo = new PDO("mysql:host=localhost;dbname=banque", "root", "",
[
     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);
$pdo->exec("SET NAMES utf8");

//recupere les comptes et pour chaque
$stmt = $pdo->prepare("SELECT * FROM compte");
$stmt->execute();

//array vide
$comptes = [];

//parcours le resultat de la requete
while($res = $stmt->fetch()){
     //une instance de Compte
     $compte = new Compte($res);
     //ajout de compte dans l'array $comptes[]
     $comptes[] = $compte;
}

//RECUPERATION DES TITULAIRES
$stmt = $pdo->prepare("SELECT * FROM personne");
$stmt->execute();
$personnes = [];
while($resultat = $stmt->fetch()){
     $personnes[] = new Personne($resultat);
}

//CREATION NEW COMPTE
if( isset($_POST['solde']) ){
     $compte = new Compte($_POST);

     $stmt = $pdo->prepare("INSERT INTO compte VALUES(NULL, ?, ?)");
     $stmt->execute( [$compte->getTitulaire(), $compte->getSolde()] );
     header("location: .");
     exit;
}

//var_dump($resultat);
include "vues/compte.phtml";

function toto(){}

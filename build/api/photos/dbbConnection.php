<?php
// Data base connexion et affichage erreur au cas ou.
if($_SERVER["HTTP_HOST"] == 'localhost'){
	$bdd = new PDO('mysql:host=localhost; dbname=madeInItaly_AnaMaria', 'root', '');
} else {
	$bdd = new PDO('mysql:host=pascalevbsanamar.mysql.db; dbname=pascalevbsanamar', 'pascalevbsanamar', 'Caloulou1');
}
try {
	$bdd;
}
catch (exception $e) {
		die('Error xex : '.$e->getMessage());
}

?>

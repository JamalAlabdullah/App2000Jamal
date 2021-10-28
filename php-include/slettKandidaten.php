
<?php
include("db_pdo.php");
session_start();

$sql = "UPDATE `valg2021`.`kandidat` SET `trukket` = 'j' WHERE (`bruker` = :brukerId);";
$stmt = $db->prepare($sql);
$stmt->bindParam(':brukerId', $_SESSION['epost']);
$stmt->execute();

header('Location: ../profil.php');

?>


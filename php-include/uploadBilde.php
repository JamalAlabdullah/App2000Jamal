
<?php

$action = "$_SERVER[QUERY_STRING]";
$target_path = "../katalog/";
$bilde = basename( $_FILES['uploadedfile']['name']);
$target_path = $target_path .$bilde;
move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);

if ($action === nominering) header('Location: ../nominering.php?'.$bilde); // nominering
else header('Location: ../profilKandidat.php?'.$bilde); // Profil

?>


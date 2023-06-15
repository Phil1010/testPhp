<?php
header("Access-Control-Allow-Origin: *"); // Autorise toutes les origines à accéder à ce script
header("Access-Control-Allow-Headers: Content-Type"); // Autorise l'en-tête Content-Type
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!isset($_POST['quizID'])) {
    http_response_code(400);
    echo "Donnée manquante.";
    exit;
  }

  $quizID = $_POST['quizID'];

  $filename = 'quiz_fini.csv';
  $file = fopen($filename, 'r');

  if ($file === false) {
    http_response_code(500);
    echo "Erreur lors de l'ouverture du fichier.";
    exit;
  }

  $filteredData = [];

  while (($row = fgetcsv($file)) !== false) {
    if ($row[1] == $quizID) {
      $rowData = [
        'date' => $row[0],
        'quizID' => $row[1],
        'quizContent' => $row[2],
        'userID' => $row[4],
        'userName' => $row[5],
        'elapsedTime' => $row[6],
        'results' => $row[7],
        'note' => $row[8],
        'penalite' => $row[9]
      ];
      // on saute l'adresse IP entre les champs 2 et 4

      $filteredData[] = $rowData;
    }
  }

  fclose($file);

  header('Content-Type: application/json');
  echo json_encode($filteredData);
}

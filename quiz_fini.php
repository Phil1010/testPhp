<?php
header("Access-Control-Allow-Origin: *"); // Autorise toutes les origines à accéder à ce script
header("Access-Control-Allow-Headers: Content-Type"); // Autorise l'en-tête Content-Type
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $data = json_decode(file_get_contents("php://input"), true);

  // Validation
  if (
    !is_array($data) ||
    !isset($data['quizID']) ||
    !isset($data['quizContent']) ||
    !isset($data['userID']) ||
    !isset($data['userName']) ||
    !isset($data['elapsedTime']) ||
    !isset($data['results']) ||
    !isset($data['note']) ||
    !isset($data['penalite'])
  ) {
    http_response_code(400);
    echo "Données manquantes.";
    exit;
  }

  $quizID = $data['quizID'];
  $quizContent = $data['quizContent'];
  $userID = $data['userID'];
  $userName = $data['userName'];
  $elapsedTime = $data['elapsedTime'];
  $results = $data['results'];
  $note = $data['note'];
  $penalite = $data['penalite'];

  $currentDateTime = date('Y-m-d H:i:s');
  $userIP = $_SERVER['REMOTE_ADDR'];

  $rowData = [$currentDateTime, $quizID, $quizContent, $userIP, $userID, $userName, $elapsedTime, $results, $note, $penalite];

  $filename = 'quiz_fini.csv';
  $file = fopen($filename, 'a');

  fputcsv($file, $rowData);

  fclose($file);

  http_response_code(200);
  echo "Tutto bene.";
}

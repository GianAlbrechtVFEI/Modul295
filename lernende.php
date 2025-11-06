<?php

/**
 * @file
 * REST API for tbl_lernende.
 */

// Set JSON response header.
header('Content-Type: application/json');

// Database configuration.
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ausbildung";

// Establish database connection.
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
  exit;
}

// Get HTTP method.
$method = $_SERVER['REQUEST_METHOD'];

try {
  // CREATE - Insert new student.
  if ($method == 'POST') {
    $stmt = $conn->prepare(
      "INSERT INTO tbl_lernende (
        vorname, nachname, strasse, plz, ort, nr_land, geschlecht,
        telefon, handy, email, email_privat, birthdate
      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->execute([
      $_POST['vorname'] ?? NULL,
      $_POST['nachname'] ?? NULL,
      $_POST['strasse'] ?? NULL,
      $_POST['plz'] ?? NULL,
      $_POST['ort'] ?? NULL,
      $_POST['nr_land'] ?? NULL,
      $_POST['geschlecht'] ?? NULL,
      $_POST['telefon'] ?? NULL,
      $_POST['handy'] ?? NULL,
      $_POST['email'] ?? NULL,
      $_POST['email_privat'] ?? NULL,
      $_POST['birthdate'] ?? NULL,
    ]);
    echo json_encode(['message' => 'Lernende created successfully']);
  }
  // READ - Get all students or single student by ID.
  elseif ($method == 'GET') {
    // Get all students.
    if (!isset($_GET['id'])) {
      $stmt = $conn->prepare("SELECT * FROM tbl_lernende");
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($result);
    }
    // Get single student by ID.
    else {
      $id = $_GET['id'];
      $stmt = $conn->prepare("SELECT * FROM tbl_lernende WHERE id_lernende = ?");
      $stmt->execute([$id]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      echo json_encode($result);
    }
  }
  // DELETE - Delete student by ID.
  elseif ($method == 'DELETE') {
    // Parse request body.
    parse_str(file_get_contents("php://input"), $data);
    $id = $data['id'] ?? ($_GET['id'] ?? NULL);

    if (!$id) {
      http_response_code(400);
      echo json_encode(['error' => 'ID required']);
      exit;
    }

    $stmt = $conn->prepare("DELETE FROM tbl_lernende WHERE id_lernende = ?");
    $stmt->execute([$id]);
    echo json_encode(['message' => 'Lernende deleted successfully']);
  }
  // UPDATE - Update student by ID.
  elseif ($method == 'PUT') {
    // Parse request body.
    parse_str(file_get_contents("php://input"), $data);
    $id = $data['id'] ?? NULL;

    if (!$id) {
      http_response_code(400);
      echo json_encode(['error' => 'ID required']);
      exit;
    }

    $sql = "UPDATE tbl_lernende SET
              vorname = ?, nachname = ?, strasse = ?, plz = ?, ort = ?,
              nr_land = ?, geschlecht = ?, telefon = ?, handy = ?, email = ?,
              email_privat = ?, birthdate = ?
            WHERE id_lernende = ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
      $data['vorname'] ?? NULL,
      $data['nachname'] ?? NULL,
      $data['strasse'] ?? NULL,
      $data['plz'] ?? NULL,
      $data['ort'] ?? NULL,
      $data['nr_land'] ?? NULL,
      $data['geschlecht'] ?? NULL,
      $data['telefon'] ?? NULL,
      $data['handy'] ?? NULL,
      $data['email'] ?? NULL,
      $data['email_privat'] ?? NULL,
      $data['birthdate'] ?? NULL,
      $id,
    ]);
    echo json_encode(['message' => 'Lernende updated successfully']);
  }
  else {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method']);
  }
}
catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

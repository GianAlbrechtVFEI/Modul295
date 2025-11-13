<?php

/**
 * @file
 * REST API Endpoint: Dozenten (Instructors)
 * Supports: GET (all/single), POST (create), PUT (update), DELETE
 */

header('Content-Type: application/json');
include_once '../config/database.php';
include_once 'crud.php';

// Initialize connection and parse request.
$conn = (new Database())->getConnection();
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), TRUE) ?: [];
$id = $data['id'] ?? ($_GET['id'] ?? NULL);

// Define table and fields.
$table = 'tbl_dozenten';
$idField = 'id_dozent';
$fields = ['vorname', 'nachname', 'strasse', 'plz', 'ort', 'nr_land', 'geschlecht', 'telefon', 'handy', 'email', 'birthdate'];

try {
  if ($method == 'GET') {
    handleGet($conn, $table, $idField, $id);
  }
  elseif ($method == 'POST') {
    handlePost($conn, $table, $fields, $data);
  }
  elseif ($method == 'PUT') {
    handlePut($conn, $table, $idField, $id, $fields, $data);
  }
  elseif ($method == 'DELETE') {
    handleDelete($conn, $table, $idField, $id);
  }
  else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
  }
}
catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(['error' => 'Database error', 'details' => $e->getMessage()]);
}

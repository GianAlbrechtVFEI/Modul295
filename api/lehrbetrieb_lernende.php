<?php

/**
 * @file lehrbetrieb_lernende.php
 * REST API: Company-Student Assignments
 * Links apprentices to companies with dates & profession
 * GET all/single, POST, PUT, DELETE
 */

header('Content-Type: application/json');
include_once '../config/database.php';
include_once 'crud.php';

// Setup connection and request params
$conn = (new Database())->getConnection();
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), TRUE) ?: [];
$id = $data['id'] ?? ($_GET['id'] ?? NULL);

// Table config: Company-Student junction with period
$table = 'tbl_lehrbetrieb_lernende';
$idField = 'id_lehrbetrieb_lernende';
$fields = ['nr_lehrbetrieb', 'nr_lernende', 'start', 'ende', 'beruf'];

// Route to appropriate handler
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

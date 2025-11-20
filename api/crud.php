<?php

/**
 * @file crud.php
 * Generic CRUD functions for REST API
 * Handles GET, POST, PUT, DELETE with validation
 */

/**
 * Validates positive integer (for IDs)
 *
 * @param mixed $value Value to check
 * @return bool True if valid positive int
 */
function validateId($value) {
  return $value !== NULL && filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) !== FALSE;
}

/**
 * GET request handler
 * Returns all records or single record by ID
 *
 * @param PDO $conn DB connection
 * @param string $table Table name
 * @param string $idField Primary key field
 * @param mixed $id ID or null for all
 */
function handleGet($conn, $table, $idField, $id) {
  if (!$id) {
    $stmt = $conn->query("SELECT * FROM $table");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
  }
  else {
    if (!validateId($id)) {
      http_response_code(400);
      echo json_encode(['error' => 'Invalid ID format', 'details' => 'ID must be a positive integer']);
      return;
    }
    $stmt = $conn->prepare("SELECT * FROM $table WHERE $idField = ?");
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
      http_response_code(404);
      echo json_encode(['error' => 'Not found']);
    }
    else {
      echo json_encode($result);
    }
  }
}

/**
 * Email format validator
 *
 * @param string $email Email to check
 * @return bool True if valid or empty
 */
function validateEmail($email) {
  if ($email === NULL || $email === '') {
    return TRUE;
  }
  return filter_var($email, FILTER_VALIDATE_EMAIL) !== FALSE;
}

/**
 * Date format validator (YYYY-MM-DD)
 *
 * @param string $date Date to check
 * @return bool True if valid or empty
 */
function validateDate($date) {
  if ($date === NULL || $date === '') {
    return TRUE;
  }
  $d = \DateTime::createFromFormat('Y-m-d', $date);
  return $d && $d->format('Y-m-d') === $date;
}

/**
 * POST request handler (create)
 * Validates emails, dates, foreign keys before insert
 *
 * @param PDO $conn DB connection
 * @param string $table Table name
 * @param array $fields Fields to insert
 * @param array $data Request payload
 */
function handlePost($conn, $table, $fields, $data) {
  // Validate email fields.
  foreach (['email', 'email_privat'] as $emailField) {
    if (isset($data[$emailField]) && !validateEmail($data[$emailField])) {
      http_response_code(400);
      echo json_encode(['error' => 'Invalid email format', 'field' => $emailField, 'format' => 'Use valid email format (e.g. user@example.com)']);
      return;
    }
  }

  // Validate date fields.
  foreach (['birthdate', 'startdatum', 'enddatum', 'start', 'ende'] as $dateField) {
    if (isset($data[$dateField]) && !validateDate($data[$dateField])) {
      http_response_code(400);
      echo json_encode(['error' => 'Invalid date format', 'field' => $dateField, 'format' => 'Use YYYY-MM-DD']);
      return;
    }
  }

  // Validate foreign key IDs.
  foreach (['nr_land', 'nr_dozent', 'nr_lernende', 'nr_kurs', 'nr_lehrbetrieb'] as $fkField) {
    if (isset($data[$fkField]) && $data[$fkField] !== NULL && !validateId($data[$fkField])) {
      http_response_code(400);
      echo json_encode(['error' => 'Invalid ID format', 'field' => $fkField, 'details' => 'Must be a positive integer']);
      return;
    }
  }

  try {
    $placeholders = implode(', ', array_fill(0, count($fields), '?'));
    $values = array_map(fn($f) => $data[$f] ?? NULL, $fields);
    $stmt = $conn->prepare("INSERT INTO $table (" . implode(', ', $fields) . ") VALUES ($placeholders)");
    $stmt->execute($values);
    echo json_encode(['message' => 'Created', 'id' => $conn->lastInsertId()]);
  }
  catch (PDOException $e) {
    if ($e->getCode() == 23000) {
      http_response_code(409);
      echo json_encode(['error' => 'Duplicate entry', 'details' => $e->getMessage()]);
    }
    elseif ($e->getCode() == 22007 || strpos($e->getMessage(), '1292') !== FALSE) {
      http_response_code(400);
      echo json_encode(['error' => 'Invalid datetime format', 'details' => $e->getMessage(), 'format' => 'Use YYYY-MM-DD for date fields']);
    }
    else {
      throw $e;
    }
  }
}

/**
 * PUT request handler (update)
 * Validates before updating existing record
 *
 * @param PDO $conn DB connection
 * @param string $table Table name
 * @param string $idField Primary key field
 * @param mixed $id Record ID
 * @param array $fields Updatable fields
 * @param array $data Request payload
 */
function handlePut($conn, $table, $idField, $id, $fields, $data) {
  if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'ID required']);
    return;
  }

  if (!validateId($id)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid ID format', 'details' => 'ID must be a positive integer']);
    return;
  }

  // Validate email fields.
  foreach (['email', 'email_privat'] as $emailField) {
    if (isset($data[$emailField]) && !validateEmail($data[$emailField])) {
      http_response_code(400);
      echo json_encode(['error' => 'Invalid email format', 'field' => $emailField, 'format' => 'Use valid email format (e.g. user@example.com)']);
      return;
    }
  }

  // Validate date fields.
  foreach (['birthdate', 'startdatum', 'enddatum', 'start', 'ende'] as $dateField) {
    if (isset($data[$dateField]) && !validateDate($data[$dateField])) {
      http_response_code(400);
      echo json_encode(['error' => 'Invalid date format', 'field' => $dateField, 'format' => 'Use YYYY-MM-DD']);
      return;
    }
  }

  // Validate foreign key IDs.
  foreach (['nr_land', 'nr_dozent', 'nr_lernende', 'nr_kurs', 'nr_lehrbetrieb'] as $fkField) {
    if (isset($data[$fkField]) && $data[$fkField] !== NULL && !validateId($data[$fkField])) {
      http_response_code(400);
      echo json_encode(['error' => 'Invalid ID format', 'field' => $fkField, 'details' => 'Must be a positive integer']);
      return;
    }
  }

  $updateFields = [];
  $values = [];
  foreach ($fields as $f) {
    if (isset($data[$f])) {
      $updateFields[] = "$f = ?";
      $values[] = $data[$f];
    }
  }
  if (!$updateFields) {
    http_response_code(400);
    echo json_encode(['error' => 'No fields']);
    return;
  }
  $values[] = $id;
  $stmt = $conn->prepare("UPDATE $table SET " . implode(', ', $updateFields) . " WHERE $idField = ?");
  $stmt->execute($values);
  echo json_encode(['message' => 'Updated']);
}

/**
 * DELETE request handler
 * Removes record by ID
 *
 * @param PDO $conn DB connection
 * @param string $table Table name
 * @param string $idField Primary key field
 * @param mixed $id Record ID
 */
function handleDelete($conn, $table, $idField, $id) {
  if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'ID required']);
    return;
  }

  if (!validateId($id)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid ID format', 'details' => 'ID must be a positive integer']);
    return;
  }

  $stmt = $conn->prepare("DELETE FROM $table WHERE $idField = ?");
  $stmt->execute([$id]);
  if ($stmt->rowCount() === 0) {
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
  }
  else {
    echo json_encode(['message' => 'Deleted']);
  }
}

<?php

/**
 * Database connection class
 * Handles PDO connection to MySQL database
 */
class Database {
  private $host = "localhost";
  private $db = "db_ausbildung";
  private $user = "root";
  private $pass = "";

  /**
   * Establishes and returns database connection.
   *
   * @return PDO Database connection object
   */
  public function getConnection() {
    try {
      $conn = new PDO("mysql:host={$this->host};dbname={$this->db};charset=utf8mb4", $this->user, $this->pass);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
    }
    catch (PDOException $e) {
      http_response_code(500);
      echo json_encode(['error' => 'Connection failed', 'details' => $e->getMessage()]);
      exit;
    }
  }

}

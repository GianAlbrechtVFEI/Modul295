<?php

/**
 * Database connection handler
 * Creates PDO connection to MySQL database
 */
class Database {
  private $host = "localhost";
  private $db = "db_ausbildung";
  private $user = "root";
  private $pass = "";

  /**
   * Returns active database connection
   * Sets error mode to exceptions, uses UTF-8
   *
   * @return PDO Connection object
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

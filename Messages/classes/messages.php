<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Messages {

protected $host = '127.0.0.1';
protected $user = 'root';
protected $password = 'root';
protected $database = 'school';

public function __construct() {
  if (!isset($this->connection)) {
    $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database, 8889);
    if (!$this->connection) {
        echo 'Cannot connect to database server';
        exit;
    }
  }
  return $this->connection;
}

// read
public function read() {
  $sql = "SELECT name, email, message FROM messages";
  $stmt = $this->connection->prepare($sql);
  if ($stmt->execute()) {
      $result = $stmt->get_result();
      while ($row = $result->fetch_object()) {
          echo "<b>Naam:   </b> {$row->name}<br>";
          echo "<b>E-mail: </b> {$row->email}<br>";
          echo "<b>Message:</b> {$row->message}<br><br>";
      }
      return true;
  }
  return false;
}

// create 
public function create(string $name, string $email, string $message) {
    $sql = "INSERT INTO messages(name, email, message) VALUES (?, ?, ?)";
    $stmt = $this->connection->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();
}

// Update 
public function update(string $name, string $email, string $message) {
  $sql = "UPDATE messages SET name = ?, email = ?, message = ?  WHERE messages_id=15";
  $stmt = $this->connection->prepare($sql);
  $stmt->bind_param("sss", $name, $email, $message);
  $stmt->execute();
}

// delete 
public function delete( $messages_id) {
  $sql = "DELETE FROM messages WHERE messages_id='$messages_id' ";
  $stmt = $this->connection->prepare($sql);
  $stmt->execute();
  }
}

$m = new Messages();
$m->read('name', 'email', 'message');
$m->create('Iqra', 'jan@gmail.com', 'dit is een bericht');
$m->update('Bericht', 'is', 'veranderd');
$m->delete(13);

?>

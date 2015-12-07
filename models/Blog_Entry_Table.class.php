<?php

class Blog_Entry_Table {
  private $db;

  public function __construct ( $db ) {
    $this->db = $db;
  }

  private function makeStatement ( $sql, $data = NULL ) {
    $statement = $this->db->prepare( $sql );
    try {
      $statement->execute( $data );
    } catch (Exception $e) {
      $exceptionMessage = "<p>You tried to run this sql: $sql</p>
        <p>Exception: $e</p>";
      trigger_error($exceptionMessage);
    }
    return $statement;
  }


  public function getEntry( $id ){
    $sql = "SELECT entry_id, title, entry_text, date_created FROM blog_entry WHERE entry_id = ?";
    $data = array ( $id );
    $statement = $this->makeStatement($sql, $data);
    $model = $statement->fetchObject();
    return $model;
  }

  public function saveEntry ($title, $entry) {
    $entrySQL = "INSERT INTO blog_entry (title, entry_text)
      VALUES (?, ?)";
    $formData = array( $title, $entry );
    $entryStatement = $this->makeStatement( $entrySQL, $formData);
    return $this->db->lastInsertId();
  }

  public function getAllEntries () {
    $sql = "SELECT entry_id, title, SUBSTRING(entry_text, 1, 150) AS intro FROM blog_entry";
    $statement = $this->makeStatement( $sql );
    return $statement;
  }

  public function deleteCommentsByID( $id ){
    include_once "models/Comment_Table.class.php";
    $comments = new Comment_Table( $this->db );
    $comments->deleteByEntryId( $id );
  }

  public function deleteEntry ( $id ) {
    $this->deleteCommentsByID($id);
    $sql = "DELETE FROM blog_entry WHERE entry_id = ?";
    $data = array ( $id );
    $statement = $this->makeStatement( $sql, $data );
  }

  public function updateEntry ( $id, $title, $entry ){
    $sql = "UPDATE blog_entry
      SET title = ?,
          entry_text = ?
      WHERE entry_id = ?";
    $data = array( $title, $entry, $id );
    $statement = $this->makeStatement( $sql, $data );
    return $statement;
  }

  public function searchEntry ( $searchTerm ) {
    $sql = "SELECT entry_id, title FROM blog_entry
            WHERE title LIKE ?
            OR entry_text LIKE ?";
    $data = array( "%$searchTerm%", "%$searchTerm%" );
    $statement = $this->makeStatement($sql, $data);
    return $statement;
  }

}



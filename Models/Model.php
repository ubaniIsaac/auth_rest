<?php
include_once 'Database.php';

class Model extends Database{
    protected $table;
    protected $table_fields;

    public function __construct() {
        parent::__construct();
      }

      private function getTableFields(){
        $fields= array();
        foreach ($this->table_fields as $item){
          if($this->$item != NULL)
          $fields [$item] = $this -> $item;
          // array_push($fields, $item);
        }
        return $fields;
      }

      public function getAll(){
        $query = "SELECT * FROM " .$this->table;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($result);
      }

      public function find($id){

        $query = 'SELECT * FROM '. $this->table . '
         WHERE id = ? 
         LIMIT 0,1';

         $stmt = $this->conn->prepare($query);

         $stmt->bindParam(1, $id);

         $stmt->execute();
         
         if ($stmt->rowCount() == 0){
           echo json_encode(
             array('message'=> 'No data with this Id available')
         );
        }
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
         echo json_encode($result);
    }

    public function create($request){
      //write query
      $fields =  $this->getTableFields();
      $keys = array_keys($fields);
      $query = 'INSERT INTO ' . $this->table .'(' .join(',', $keys ) . ') values ('.join(',', $fields ) .')';
      echo $query;

      // prepare statement
      $stmt = $this->conn->query($query);

      //clean data (htmlspecialchars)
      // $request->name = htmlspecialchars(strip_tags($request->name));
    // echo $request;
      //bindparams
      // $stmt->bindParam('name', $request->name);
      // $stmt->bindParam('email', $request->email);
      // $stmt->bindParam('password', $request->password);

      //execute
      // if($stmt->execute()) {
          return $stmt;
        //  }
  // printf("Error: %s.\n", $stmt->error);

  // return false;
}

public function update($id, $request){
  $query = 'UPDATE ' . $this->table . ' SET name = :name
  WHERE id = :id ';

  $stmt = $this->conn->prepare($query);

  $request->name = htmlspecialchars(strip_tags($request->name));

  $stmt->bindParam(':name', $request->name);
  $stmt->bindParam(':id', $id);

  if($stmt->execute()) {
      return true;

  }
  printf("Error: %s.\n", $stmt->error);

  return false;
}
public function delete($id){
  $query = 'DELETE FROM '. $this->table . '
  WHERE id = ?';

  $stmt = $this->conn->prepare($query);

  $stmt->bindParam(1, $id);
  
  if($stmt->execute()) {
      return true;

  }
  printf("Error: %s.\n", $stmt->error);

  return false;
}

}
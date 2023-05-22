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
          $fields [$item] = $this -> $item;
          // array_push($fields, $item);
        }
        return $fields;
      }

      
    public function getAll(){
      $requestMethod = $_SERVER["REQUEST_METHOD"];
        if ($requestMethod == 'GET'){
        $query = "SELECT * FROM " .$this->table;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($result);
        }else {
          echo json_encode(array(
            "message"=> "invalid method"
          ));
          http_response_code(422);
        }
      }

      public function find($id){
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if ($requestMethod == 'GET'){
          if(!is_numeric($id)){
          http_response_code(422);
          echo json_encode(array(
            "message"=> "invalid id"
          ));
          return;
          }
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
        }else {
          echo json_encode(array(
            "message"=> "invalid method"
          ));
          http_response_code(422);
        }
    }

    public function create($request){
      //write query
      $requestMethod = $_SERVER["REQUEST_METHOD"];
      if ($requestMethod == 'POST'){
      $fields =  $this->getTableFields();
      $keys = array_keys($fields);
      $data = array_values((get_object_vars($request)));
      $query = "INSERT INTO "  . $this->table; 
      $query.="(" .join(',', $keys ) . ")  ";
      $query.="VALUES ('".join("','", $data ) ."')";

      // execute  statement
      $stmt = $this->conn->query($query);

      http_response_code(201);  
      echo json_encode(
        array('Message'=>'User created')
      );
      return $stmt;
  }else {
      echo json_encode(array(
        "message"=> "invalid method"
      ));
      http_response_code(422);
    }

}

public function update($id, $request){
  $requestMethod = $_SERVER["REQUEST_METHOD"];
  if ($requestMethod == 'PUT'){
      $fields = (get_object_vars($request));
      // $values = array_values((get_object_vars($request)));
  $query = "UPDATE $this->table SET ";
  foreach ($fields as $field => $value ){
    $update_values[] = "$field = '$value'";
  }
  $query.= join(',',$update_values);
  $query.= "WHERE id = $id ";

  $stmt = $this->conn->prepare($query);

  if($stmt->execute()) {
      return true;

  }
  printf("Error: %s.\n", $stmt->error);

  return false;
}else {
  echo json_encode(array(
    "message"=> "invalid method"
  ));
  http_response_code(422);
}

}


public function delete($id){
  $requestMethod = $_SERVER["REQUEST_METHOD"];
  if ($requestMethod == 'DELETE'){
  $query = "DELETE FROM $this->table WHERE id = $id";

  $stmt = $this->conn->prepare($query);

  if($stmt->execute()) {
      return true;

  }
  printf("Error: %s.\n", $stmt->error);

  return false;
 } else {
    echo json_encode(array(
      "message"=> "invalid method"
    ));
    http_response_code(422);
  }
}
}
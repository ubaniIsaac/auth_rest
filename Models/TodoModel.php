<?php

class TodoModel extends Model{

     // protected $id;
     protected $name;
     protected $description;
     protected $due_date;
     protected  $table = 'todo';
     protected  $table_fields = array('name', 'description', 'due_date');
 
 
     function __construct(){
         parent::__construct();
     }
 

}
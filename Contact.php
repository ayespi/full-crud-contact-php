<?php
// ***** INCLUDE DB Connection and Library ********
// require('../../dbconnect.php');
// require('../php/library.php');

class Contact{
  public $connection;
  public $id;
  public $email;
  public $first_name;
  public $last_name;
  public $phone;
  public $data_array;
  public $data_json;

  public function __construct($connection){
    $this->connection = $connection;
    // $this->init();
  }

  public function init(){
    echo('Contact Object Created...');
  }

  public function insert_contact($contact_params){
    $this->update_params($contact_params);
    $this->create_contact_table();
    $query = $this->get_insert_query();
    // prewrap($query);
    $result = mysqli_query($this->connection, $query);
    if(!$result){echo('[INSERT CONTACT] --- There has been an ERROR!!!');}
  }

  public function create_contact_table(){
    $query = $this->get_create_table_query();
    // prewrap($query);
    $result = mysqli_query($this->connection, $query);
    if(!$result){echo('[CREATE CONTACTS TABLE] --- There has been an ERROR!!!');}
  }

  public function get_insert_query(){
    return "INSERT INTO `contacts` (
      `contact_id`,
      `contact_email`,
      `contact_first_name`,
      `contact_last_name`,
      `contact_phone`,
      `contact_date_entered`
    ) VALUES (
      NULL,
      '$this->email',
      '$this->first_name',
      '$this->last_name',
      '$this->phone',
      CURRENT_TIMESTAMP
    );";
  }

  public function get_create_table_query(){
    return "CREATE TABLE IF NOT EXISTS `whollycoders`.`contacts` (
      `contact_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
      `contact_email` VARCHAR(100) NOT NULL ,
      `contact_first_name` VARCHAR(100) NOT NULL ,
      `contact_last_name` VARCHAR(100) NOT NULL ,
      `contact_phone` VARCHAR(20) NOT NULL ,
      `contact_date_entered` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
      PRIMARY KEY (`contact_id`)
    ) ENGINE = InnoDB;";
  }

  public function get_contacts(){
    $query = "SELECT * FROM contacts";
    // prewrap($query);
    $result = mysqli_query($this->connection, $query);
    return $result;
  }

  public function get_contacts_data_array(){
    $result = $this->get_contacts();
    if(!$result){echo('[GET CONTACT DATA | ARRAY] --- There has been an ERROR!!!');}
    $this->data_array = array();
    while($row = mysqli_fetch_assoc($result)){
      $this->data_array[] = array(
        'id'            =>    $row['contact_id'],
        'email'         =>    $row['contact_email'],
        'first_name'    =>    $row['contact_first_name'],
        'last_name'     =>    $row['contact_last_name'],
        'phone'         =>    $row['contact_phone'],
        'date_entered'  =>    $row['contact_date_entered']
      );
    }
    $this->data_json = json_encode($this->data_array);
    return $this->data_array;
  }

  public function get_contacts_json(){
    return $this->data_json;
  }

  public function select_contact($id){
    $query = "SELECT * FROM contacts WHERE contact_id = $id;";
    // prewrap($query);
    $result = mysqli_query($this->connection, $query);
    return $result;
  }

  public function update_params($params){
    $this->email        = $params['email'];
    $this->first_name   = $params['first_name'];
    $this->last_name    = $params['last_name'];
    $this->phone        = $params['phone'];
  }

  public function update_contact($update_params){
    $id = $update_params['id'];
    $this->update_params($update_params);
    $query = "UPDATE `contacts`
    SET `contact_email` = '$this->email',
    `contact_first_name` = '$this->first_name',
    `contact_last_name` = '$this->last_name',
    `contact_phone` = '$this->phone'
    WHERE `contacts`.`contact_id`='$id';";
    // prewrap($query);
    $result = mysqli_query($this->connection, $query);
    return $result;
  }

  public function delete_contact($id){
    $query = "DELETE FROM contacts WHERE contact_id = $id;";
    // prewrap($query);
    $result = mysqli_query($this->connection, $query);
    return $result;
  }

  public function set_id($id){
    $this->email = $id;
  }

  public function set_email($email){
    $this->email = $email;
  }

  public function set_first_name($first_name){
    $this->first_name = $first_name;
  }

  public function set_last_name($last_name){
    $this->last_name = $last_name;
  }

  public function set_phone($phone){
    $this->$phone = $phone;
  }
}
// ********************** FOR TESTING PURPOSES *********************************
// $contact = new Contact($connection);
// prewrap($contact);


// ***** CREATE *****
// $email        = 'obenson@gmail.com';
// $first_name   = 'Olivia';
// $last_name    = 'Benson';
// $phone        = '(212) 555-0216';
//
// $contact_params = array(
//   'email'         =>  $email,
//   'first_name'    =>  $first_name,
//   'last_name'     =>  $last_name,
//   'phone'         =>  $phone
// );
// $contact->insert_contact($contact_params);
// prewrap($contact);


// ***** READ *****
// $result = $contact->get_contacts();
// if(!$result){echo('[SELECT CONTACT] --- There is an ERROR!!!');}
//
// while($row = mysqli_fetch_assoc($result)){
//   echo('##########<br>');
//   echo('ID: '.$row['contact_id'].'<br>');
//   echo('Email: '.$row['contact_email'].'<br>');
//   echo('First Name: '.$row['contact_first_name'].'<br>');
//   echo('Last Name: '.$row['contact_last_name'].'<br>');
//   echo('Phone: '.$row['contact_phone'].'<br>');
//   echo('Date Entered: '.$row['contact_date_entered'].'<br>');
//   echo('##########<br>');
// }


// ***** UPDATE *****
// $u_id           = 2;
// $u_email        = 'gabbyrhogam@gmail.com';
// $u_first_name   = 'Rochelle';
// $u_last_name    = 'Parks';
// $u_phone        = '(240) 650-1272';

// $update_params = array(
//   'id'            =>  $u_id,
//   'email'         =>  $u_email,
//   'first_name'    =>  $u_first_name,
//   'last_name'     =>  $u_last_name,
//   'phone'         =>  $u_phone
// );

// $result = $contact->select_contact($u_id);
// if(!$result){echo('[SELECT CONTACT] --- There is an ERROR!!!');}
// while($row = mysqli_fetch_assoc($result)){
//   echo('ID: '.$row['contact_id'].'<br>');
//   echo('Email: '.$row['contact_email'].'<br>');
//   echo('First Name: '.$row['contact_first_name'].'<br>');
//   echo('Last Name: '.$row['contact_last_name'].'<br>');
//   echo('Phone: '.$row['contact_phone'].'<br>');
//   echo('Date Entered: '.$row['contact_date_entered'].'<br>');
// }


// ***** DELETE *****
// $contact->delete_contact(4);
// $contact->delete_contact(7);


//  ***** GET Data - Array | JSON *****
// $contact->get_contacts_data_array();
// prewrap($contact->data_array);
// $json = $contact->get_contacts_json();
// echo($json);

?>

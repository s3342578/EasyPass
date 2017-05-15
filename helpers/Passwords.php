<?php
   namespace Helpers;
   
   class Passwords extends Base {

      protected $config;
      protected $database;
      protected $secret_key;

      // The constructor sets the config variable which reads the database config from a file.
      public function __construct() {
         $this->config = Base::config('db');
         $this->database = Base::dbConnect($this->config);
         $this->secret_key = hash('sha256' ,$_SESSION['password']);
      }

      public function create($fields, $email) {
         $iv = openssl_random_pseudo_bytes(16);
         if($fields->username != "" ){
           $encrypt_username = openssl_encrypt($fields->username, 'aes-256-ctr', $this->secret_key, 0, $iv);
         }
         if($fields->username != "" ){
           $encrpyt_password = openssl_encrypt($fields->password, 'aes-256-ctr', $this->secret_key, 0, $iv);
         }
         $query = "INSERT INTO password (name, username, password, iv, notes, user) VALUES ('$fields->name', '$encrypt_username', '$encrpyt_password', '$iv', '$fields->notes', '$email')";
         $result = $this->database->query($query);
      }

      public function destroy($id, $email) {
         $query = "DELETE FROM password WHERE user = '$email' AND id = $id";
         if(!$result = $this->database->query($query)){
           die('There was an error running the query [' . $this->database->error . ']');
       }
      }

      public function getPasswords($email) {
         $query = "SELECT * FROM password WHERE user = '$email'";
         $result = $this->database->query($query);
         while($row = $result->fetch_array())
         {
            $rows[] = $row;
         }
	 if(isset($rows)) {
         foreach($rows as $row) {
            $iv = $row['IV'];
            $username = "";
            $password = "";
            if($row['username'] != ""){
                 $username = openssl_decrypt($row['username'], 'aes-256-ctr', $this->secret_key, 0, $iv);
            }
            if($row['password'] != ""){
                $password = openssl_decrypt($row['password'], 'aes-256-ctr', $this->secret_key, 0, $iv);
            }
            $passwords[] = (object) array(
               'id' => $row['id'],
               'name' => $row['name'],
               'username' => $username,
               'password' => $password,
               	'notes' => $row['notes'],
            	);
         	}
         	return $passwords;
	 }
      }

   }

 ?>

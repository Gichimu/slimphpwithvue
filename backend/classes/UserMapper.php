<?php

class UserMapper extends Mapper {

    public function getUsers() {
        $sql = "SELECT * from users";


            
        $stmt = $this->db->query($sql);
        
        $result = $stmt->fetchAll();
        
        return $result;
        
    }

    /**
     * Get one user by its ID
     *
     * @param int $user_id The ID of the user
     * @return UserEntity  The user
     */

    public function getUserById($user_id) {
        $sql = 'SELECT first_name, last_name, phone_number, password from users WHERE id = :user_id';
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(['user_id' => $user_id]);

        if($result) {
            return new UserEntity($stmt->fetch());
        
        }

    }

    public function getUserByName($first_name, $last_name) {
        $sql = 'SELECT first_name, last_name, phone_number, password from users WHERE first_name = :first_name COLLATE NOCASE AND last_name = :last_name COLLATE NOCASE';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $result = $stmt->execute();

        if($result) {
            if($row = $stmt->fetch()){
                return new UserEntity($row);
            }else{
                return false;
            }
        
        }

    }

    public function isValidUser($first_name, $last_name) {
        $sql = 'SELECT first_name, last_name, phone_number, password from users WHERE first_name = :first_name AND last_name = :last_name';
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();

        if($result) {
            return true;
        }else {
            return false;
        }

    }

    // create user
    public function save(UserEntity $user) {
        $sql = 'INSERT INTO users (first_name, last_name, phone_number, password) VALUES (:first_name, :last_name, :phone_number, :password)';

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'phone_number' => $user->getPhoneNumber(),
            'password' => $user->getPassword(),
        ]);

        if(!$result) {
            throw new Exception('could not save record');
        }
    }
}
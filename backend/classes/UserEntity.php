<?php

class UserEntity
{
    protected $id;
    protected $first_name;
    protected $last_name;
    protected $phone_number;
    protected $password;

    /**
     * Accept an array of data matching properties of this class
     * and create the class
     *
     * @param array $data The data to use to create
     */
    public function __construct(array $data) {
        // no id if we're creating
        if(isset($data['id'])) {
            $this->id = $data['id'];
        }

        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->phone_number = $data['phone_number'];
        $this->password = $data['password'];
    }

    public function getId() {
        return $this->id;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function getPhoneNumber() {
        return $this->phone_number;
    }

    public function getPassword() {
        return $this->password;
    }
}
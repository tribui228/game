<?php
class UserPermission {
    private $id;
    private $username;
    private $permission;
    private $value;

    public function __construct($id, $username, $permission, $value) {
        $this->id = $id;
        $this->username = $username;
        $this->permission = $permission;
        $this->value = $value;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of permission
     */ 
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Set the value of permission
     *
     * @return  self
     */ 
    public function setPermission($permission)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * Get the value of value
     */ 
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */ 
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
?>
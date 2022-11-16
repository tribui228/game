<?php
class GroupPermission {
    private $id;
    private $group;
    private $permission;
    private $value;

    public function __construct($id, $group, $permission, $value) {
        $this->id = $id;
        $this->group = $group;
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
     * Get the value of group
     */ 
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set the value of group
     *
     * @return  self
     */ 
    public function setGroup($group)
    {
        $this->group = $group;

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
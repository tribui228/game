<?php
class Group {
    private $name;
    private $display;

    public function __construct($name, $display) {
        $this->name = $name;
        $this->display = $display;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of display
     */ 
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * Set the value of display
     *
     * @return  self
     */ 
    public function setDisplay($display)
    {
        $this->display = $display;

        return $this;
    }
}
?>
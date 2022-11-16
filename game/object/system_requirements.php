<?php
class SystemRequirements{
    private $id;
    private $OS;
    private $processor;
    private $memory;
    private $graphics;
    private $soundCard;
    private $storage;

    public function __construct($id, $OS, $processor, $memory, $graphics, $soundCard, $storage){
        $this->id = $id;
        $this->OS = $OS;
        $this->processor = $processor;
        $this->memory = $memory;
        $this->graphics = $graphics;
        $this->soundCard = $soundCard;
        $this->storage = $storage;
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
     * Get the value of OS
     */ 
    public function getOS()
    {
        return $this->OS;
    }

    /**
     * Set the value of OS
     *
     * @return  self
     */ 
    public function setOS($OS)
    {
        $this->OS = $OS;

        return $this;
    }

    /**
     * Get the value of processor
     */ 
    public function getProcessor()
    {
        return $this->processor;
    }

    /**
     * Set the value of processor
     *
     * @return  self
     */ 
    public function setProcessor($processor)
    {
        $this->processor = $processor;

        return $this;
    }

    /**
     * Get the value of memory
     */ 
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * Set the value of memory
     *
     * @return  self
     */ 
    public function setMemory($memory)
    {
        $this->memory = $memory;

        return $this;
    }

    /**
     * Get the value of graphics
     */ 
    public function getGraphics()
    {
        return $this->graphics;
    }

    /**
     * Set the value of graphics
     *
     * @return  self
     */ 
    public function setGraphics($graphics)
    {
        $this->graphics = $graphics;

        return $this;
    }

    /**
     * Get the value of soundCard
     */ 
    public function getSoundCard()
    {
        return $this->soundCard;
    }

    /**
     * Set the value of soundCard
     *
     * @return  self
     */ 
    public function setSoundCard($soundCard)
    {
        $this->soundCard = $soundCard;

        return $this;
    }

    /**
     * Get the value of storage
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Set the value of storage
     *
     * @return  self
     */ 
    public function setStorage($storage)
    {
        $this->storage = $storage;

        return $this;
    }

}
?>
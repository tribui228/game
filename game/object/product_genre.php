<?php
class ProductGenre {
    private $productName;
    private $genreName;

    public function __construct($productName, $genreName) {
        $this->productName = $productName;
        $this->genreName = $genreName;
    }

    /**
     * Get the value of productName
     */ 
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Set the value of productName
     *
     * @return  self
     */ 
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get the value of genreName
     */ 
    public function getGenreName()
    {
        return $this->genreName;
    }

    /**
     * Set the value of genreName
     *
     * @return  self
     */ 
    public function setGenreName($genreName)
    {
        $this->genreName = $genreName;

        return $this;
    }
}
?>
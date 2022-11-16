<?php
class Product{
    private $name;
    private $minimumSystemRequirementsId;
    private $recommendedSystemRequirementsId;
    private $display;
    private $developer;
    private $publisher;
    private $releaseDate;
    private $price;
    private $saleName;
    private $saleDisplay;
    private $discount;
    private $image;
    private $backgroundImage;
    private $description;
    
    public function __construct($name, $minimumSystemRequirementsId, $recommendedSystemRequirementsId, $display, $developer, $publisher, $releaseDate, $price, $saleName, $image, $backgroundImage, $description) {
        $this->name = $name;
        $this->minimumSystemRequirementsId = $minimumSystemRequirementsId;
        $this->recommendedSystemRequirementsId = $recommendedSystemRequirementsId;
        $this->display = $display;
        $this->developer = $developer;
        $this->publisher = $publisher;
        $this->releaseDate = $releaseDate;
        $this->price = $price;
        $this->saleName = $saleName;
        $this->image = $image;
        $this->backgroundImage = $backgroundImage;
        $this->description = $description;
    }

    public function getFinalPrice() {
        return $this->price * (1 - $this->discount);
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
     * Get the value of minimumSystemRequirementsId
     */ 
    public function getMinimumSystemRequirementsId()
    {
        return $this->minimumSystemRequirementsId;
    }

    /**
     * Set the value of minimumSystemRequirementsId
     *
     * @return  self
     */ 
    public function setMinimumSystemRequirementsId($minimumSystemRequirementsId)
    {
        $this->minimumSystemRequirementsId = $minimumSystemRequirementsId;

        return $this;
    }

    /**
     * Get the value of recommendedSystemRequirementsId
     */ 
    public function getRecommendedSystemRequirementsId()
    {
        return $this->recommendedSystemRequirementsId;
    }

    /**
     * Set the value of recommendedSystemRequirementsId
     *
     * @return  self
     */ 
    public function setRecommendedSystemRequirementsId($recommendedSystemRequirementsId)
    {
        $this->recommendedSystemRequirementsId = $recommendedSystemRequirementsId;

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

    /**
     * Get the value of developer
     */ 
    public function getDeveloper()
    {
        return $this->developer;
    }

    /**
     * Set the value of developer
     *
     * @return  self
     */ 
    public function setDeveloper($developer)
    {
        $this->developer = $developer;

        return $this;
    }

     /**
     * Get the value of publisher
     */ 
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * Set the value of publisher
     *
     * @return  self
     */ 
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;

        return $this;
    }

        /**
     * Get the value of releaseDate
     */ 
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set the value of releaseDate
     *
     * @return  self
     */ 
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }


    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of sale name
     */ 
    public function getSaleName()
    {
        return $this->saleName;
    }

    /**
     * Set the value of sale name
     *
     * @return  self
     */ 
    public function setSaleName($saleName)
    {
        $this->saleName = $saleName;

        return $this;
    }

    /**
     * Get the value of sale display
     */ 
    public function getSaleDisplay()
    {
        return $this->saleDisplay;
    }

    /**
     * Set the value of sale display
     *
     * @return  self
     */ 
    public function setSaleDisplay($saleDisplay)
    {
        $this->saleDisplay = $saleDisplay;

        return $this;
    }

    /**
     * Get the value of discount
     */ 
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set the value of discount
     *
     * @return  self
     */ 
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get the value of image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Set the value of background image
     *
     * @return  self
     */ 
    public function setBackgroundImage($backgroundImage)
    {
        $this->backgroundImage = $backgroundImage;

        return $this;
    }

        /**
     * Get the value of background image
     */ 
    public function getBackgroundImage()
    {
        return $this->backgroundImage;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}
?>
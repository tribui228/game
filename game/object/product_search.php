<?php
class ProductSearch {
    private $basicSearch;
    private $advancedSearch;
    private $sortBy;
    private $sortDir;
    private $filterGenres;
    /*
        u5: under 5$
        u10: under 10$
        u15: under 15$
        u25: under 25$
        a25: 25+
        discounted: sale
    */
    private $filterPrice;

    public function __construct($basicSearch, $advancedSearch, $sortBy, $sortDir, $filterGenres, $filterPrice) {
        $this->basicSearch = $basicSearch;
        $this->advancedSearch = $advancedSearch;
        $this->sortBy = $sortBy;
        $this->sortDir = $sortDir;
        $this->filterGenres = $filterGenres;
        $this->filterPrice = $filterPrice;
    }

    /**
     * Get the value of basicSearch
     */ 
    public function getBasicSearch()
    {
        return $this->basicSearch;
    }

    /**
     * Set the value of basicSearch
     *
     * @return  self
     */ 
    public function setBasicSearch($basicSearch)
    {
        $this->basicSearch = $basicSearch;

        return $this;
    }

    /**
     * Get the value of advancedSearch
     */ 
    public function getAdvancedSearch()
    {
        return $this->advancedSearch;
    }

    /**
     * Set the value of advancedSearch
     *
     * @return  self
     */ 
    public function setAdvancedSearch($advancedSearch)
    {
        $this->advancedSearch = $advancedSearch;

        return $this;
    }

    /**
     * Get the value of sortBy
     */ 
    public function getSortBy()
    {
        return $this->sortBy;
    }

    /**
     * Set the value of sortBy
     *
     * @return  self
     */ 
    public function setSortBy($sortBy)
    {
        $this->sortBy = $sortBy;

        return $this;
    }

    /**
     * Get the value of sortDir
     */ 
    public function getSortDir()
    {
        return $this->sortDir;
    }

    /**
     * Set the value of sortDir
     *
     * @return  self
     */ 
    public function setSortDir($sortDir)
    {
        $this->sortDir = $sortDir;

        return $this;
    }

    /**
     * Get the value of filterGenres
     */ 
    public function getFilterGenres()
    {
        return $this->filterGenres;
    }

    /**
     * Set the value of filterGenres
     *
     * @return  self
     */ 
    public function setFilterGenres($filterGenres)
    {
        $this->filterGenres = $filterGenres;

        return $this;
    }

    /**
     * Get the value of filterPrice
     */ 
    public function getFilterPrice()
    {
        return $this->filterPrice;
    }

    /**
     * Set the value of filterPrice
     *
     * @return  self
     */ 
    public function setFilterPrice($filterPrice)
    {
        $this->filterPrice = $filterPrice;

        return $this;
    }
}
?>
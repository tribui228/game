<?php
class Sale {
    private $name;
    private $display;
    private $discount;
    private $dateBegin;
    private $dateEnd;

    public function __construct($name, $display, $discount, $dateBegin, $dateEnd) {
        $this->name = $name;
        $this->display = $display;
        $this->discount = $discount;
        $this->dateBegin = $dateBegin;
        $this->dateEnd = $dateEnd;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDisplay()
    {
        return $this->display;
    }

    public function setDisplay($display)
    {
        $this->display = $display;
        return $this;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function setDiscount($discount)
    {
        $this->discount = $discount;
        return $this;
    }

    public function getDateBegin()
    {
        return $this->dateBegin;
    }

    public function setDateBegin($dateBegin)
    {
        $this->dateBegin = $dateBegin;
        return $this;
    }

    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }
}
?>
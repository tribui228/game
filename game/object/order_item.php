<?php
class OrderItem {
	private $id;
	private $orderId;
	private $productName;
	private $code;
	private $price;
	private $discount;
	private $dateOrdered;
	
	public function __construct($id, $orderId, $productName, $code, $price, $discount) {
        $this->id = $id;
		$this->orderId = $orderId;
        $this->productName = $productName;
        $this->code = $code;
        $this->price = $price;
        $this->discount = $discount;
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
	 * Get the value of orderId
	 */ 
	public function getOrderId()
	{
		return $this->orderId;
	}

	/**
	 * Set the value of orderId
	 *
	 * @return  self
	 */ 
	public function setOrderId($orderId)
	{
		$this->orderId = $orderId;

		return $this;
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
	 * Get the value of code
	 */ 
	public function getCode()
	{
		return $this->code;
	}

	/**
	 * Set the value of code
	 *
	 * @return  self
	 */ 
	public function setCode($code)
	{
		$this->code = $code;

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
	 * Get the value of dateOrdered
	 */ 
	public function getDateOrdered()
	{
		return $this->dateOrdered;
	}

	/**
	 * Set the value of dateOrdered
	 *
	 * @return  self
	 */ 
	public function setDateOrdered($dateOrdered)
	{
		$this->dateOrdered = $dateOrdered;

		return $this;
	}
}
?>
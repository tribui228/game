<?php
class Order {
	private $id;
	private $username;
	private $totalPrice;
	private $quantity;
	private $status;
	private $dateOrdered;
	private $dateChecked;
	
	public function __construct($id, $username, $totalPrice, $quantity, $status, $dateOrdered, $dateChecked) {
		$this->id = $id;
		$this->username = $username;
		$this->totalPrice = $totalPrice;
		$this->quantity = $quantity;
		$this->status = $status;
		$this->dateOrdered = $dateOrdered;
		$this->dateChecked = $dateChecked;
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
	 * Get the value of totalPrice
	 */ 
	public function getTotalPrice()
	{
		return $this->totalPrice;
	}

	/**
	 * Set the value of totalPrice
	 *
	 * @return  self
	 */ 
	public function setTotalPrice($totalPrice)
	{
		$this->totalPrice = $totalPrice;

		return $this;
	}
	
	/**
	 * Get the value of quantity
	 */ 
	public function getQuantity()
	{
		return $this->quantity;
	}

	/**
	 * Set the value of quantity
	 *
	 * @return  self
	 */ 
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;

		return $this;
	}

	/**
	 * Get the value of status
	 */ 
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * Set the value of status
	 *
	 * @return  self
	 */ 
	public function setStatus($status)
	{
		$this->status = $status;

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

	
	/**
	 * Get the value of dateChecked
	 */ 
	public function getDateChecked()
	{
		return $this->dateChecked;
	}

	/**
	 * Set the value of dateChecked
	 *
	 * @return  self
	 */ 
	public function setDateChecked($dateChecked)
	{
		$this->dateChecked = $dateChecked;

		return $this;
	}
}
?>
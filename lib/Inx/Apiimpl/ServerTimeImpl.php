<?php
/*
 * Created on 11.09.2008
 *
 */
 
 class Inx_Apiimpl_ServerTimeImpl implements Inx_Api_ServerTime 
 {
 	private $date;
 	private $gmt;
 	private $dst;
 	private $timezone;
 	
 	public function __construct($date, $gmt, $dst, $timezone) {
		$this->date = $date;
		$this->gmt = $gmt;
		$this->dst = $dst;
		$this->timezone = $timezone;
 	}	
 	
 	/**
	 * Returns the server time as date object.
	 * 
	 * @return the server time as date
	 */
	public function getDatetime()
	{
		return $this->date;
	}


	/**
	 * Returns the GMT offset of the server in milliseconds
	 * 
	 * @return the GMT offset in milliseconds
	 */
	public function getGMTOffset()
	{
		return $this->gmt;
	}

	public function getDSTOffset()
	{
		return $this->dst;
	}
	
	public function getTimezoneId()
	{
		return $this->timezone;
	}
 	
 	
 }
?>

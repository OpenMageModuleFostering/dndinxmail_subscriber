<?php
/**
 * @package Inxmail
 */
/**
 * The <i>Inx_Api_ServerTime</code> represents the server time. With this, you are able to translate the date from your time
 * zone to the time zone of the server. Copyright (c) 2008 Inxmail GmbH. All Rights Reserved.
 * 
 * @since API 1.4.4
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 */
interface Inx_Api_ServerTime
{

	/**
	 * Returns the server time as iso 8601 formatted datetime string.
	 * 
	 * @return the server time as iso 8601 formatted datetime string.
	 */
	public function getDatetime();


	/**
	 * Returns the GMT offset of the server in milliseconds.
	 * 
	 * @return the GMT offset in milliseconds.
	 */
	public function getGMTOffset();


	/**
	 * Returns the day light saving time offset of the server in milliseconds.
	 * 
	 * @return the DST offset in milliseconds.
	 */
	public function getDSTOffset();
	
	
	/**
	 * Returns the time zone id, for example "Europe/Berlin".
	 * 
	 * @return the time zone as string.
	 */
	public function getTimezoneId();

}

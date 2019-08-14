<?php 
/**
 * @package Inxmail
 */
/**
 * The <i>User</i> object contains information about the actual logged in user.
 * <P>
 * Copyright (c) 2010 Inxmail GmbH. All Rights Reserved.
 * 
 * @since API 1.7.0
 * @package Inxmail
 */
class Inx_Api_User
{

	private $user;

	/**
	 * This constructor is used internally to create an <i>Inx_Api_User</i> object.
	 * @param stdClass $user the user data.
	 */
	public function __construct( $user )
	{
		$this->user = $user;
	}


	/**
	 * Returns the user name of the logged in user.
	 * 
	 * @return string the user name of the logged in user.
	 */
	public function getUsername()
	{
		return $this->user->username;
	}


	/**
	 * Returns the email address of the logged in user.
	 * 
	 * @return string the email address of the logged in user.
	 */
	public function getEMail()
	{
		return $this->user->email;
	}


	/**
	 * Returns the real name of the logged in user.
	 * 
	 * @return string the real name of the logged in user.
	 */
	public function getRealName()
	{
		return $this->user->realname;
	}


	/**
	 * Returns the description of the logged in user.
	 * 
	 * @return string the description of the logged in user.
	 */
	public function getDescription()
	{
		return $this->user->description;
	}


	/**
	 * Return the creation date of the logged in user as ISO 8601 formatted date string.
	 * 
	 * @return string the creation date of the logged in user as ISO 8601 formatted date string.
	 */
	public function getCreationDate()
	{
		return $this->user->creationdate;
	}

}
?>

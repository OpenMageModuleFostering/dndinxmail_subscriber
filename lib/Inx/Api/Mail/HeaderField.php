<?php
/**
* @package Inxmail
* @subpackage Mail
*/

/**
* An <i>Inx_Api_Mail_HeaderField</i> stores a name/value pair of an email header field.
*
* @since API 1.9.0
* @author chge
*/
class Inx_Api_Mail_HeaderField
{
	private $sName;
	
	private $sValue;
		
	
	/**
	 * Creates an <i>Inx_Api_Mail_HeaderField</i> with the specified name and value.
	 *
	 * @param string $sName the name of the header field. May be ommitted.
	 * @param string $sValue the value of the header field. May be ommitted.
	 */
	public function __construct( $sName = null, $sValue = null )
	{
		$this->setName( $sName );
		$this->setValue( $sValue );
	}
	
	
	/**
	 * Returns the name of the header field.
	 *
	 * @return string the name of the header field.
	 */
	public function getName()
	{
		return $this->sName;
	}
	
	
	/**
	 * Returns the value of the header field.
	 *
	 * @return string the value of the header field.
	 */
	public function getValue()
	{
		return $this->sValue;
	}
	
	
	/**
	 * Sets the name of the header field.
	 *
	 * @param string $sName the name of the header field.
	 */
	public function setName( $sName )
	{
		$this->sName = $sName;
	}
	
	
	/**
	 * Sets the value of the header field.
	 *
	 * @param string $sValue the value of the header field.
	 */
	public function setValue( $sValue )
	{
		$this->sValue = $sValue;
	}	
}
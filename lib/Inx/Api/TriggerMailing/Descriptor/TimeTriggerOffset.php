<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing_Descriptor
 */

/**
 * An <i>Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset</i> is used to adjust the dispatch date of an 
 * attribute driven time trigger mailing. A <i>TimeTriggerOffset</i> consists of three parts:
 * <ol>
 * <li><b>The offset type</b>: Defines whether the offset is positive or negative.
 * <li><b>The offset unit</b>: Defines the unit of the offset (e.g. day, week, month,...).
 * <li><b>The offset value</b>: Defines the actual offset.
 * </ol>
 * <p>
 * The following snippet shows how to create a tomorrow offset:
 * 
 * <pre>
 * $tomorrow = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset( 
 *      Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType::IS_IN(), 
 *      Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::DAY(), 1 );
 * </pre>
 * 
 * @since API 1.10.0
 * @author chge, 16.07.2012
 */
final class Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset
{
	private $type;

	private $unit;

	private $value;


	/**
	 * Creates a new offset with the given type, unit and offset value. The value may not be negative. 
         * If all parameters are omitted, creates an offset which represents "now".
	 * 
	 * @param Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType $type the offset type.
	 * @param Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit $unit the offset unit.
	 * @param int $iValue the actual offset value. May not be negative.
	 * @throws Inx_Api_IllegalArgumentException if the value is negative.
	 */
	public function __construct(Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType $type = null, 
                Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit $unit = null, $iValue = null)
	{
                if(null !== $iValue && $iValue < 0)
			throw new Inx_Api_IllegalArgumentException( "value may not be negative" );
                            
		$this->type = (null === $type) ? Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType::IS_IN() : $type;
		$this->unit = (null === $unit) ? Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::DAY() : $unit;
		$this->value = (null === $iValue) ? 0 : $iValue;
	}


	/**
	 * Returns the offset type.
	 * 
	 * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType the offset type.
	 */
	public function getType()
	{
		return $this->type;
	}


	/**
	 * Returns the offset unit.
	 * 
	 * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit the offset unit.
	 */
	public function getUnit()
	{
		return $this->unit;
	}


	/**
	 * Returns the actual offset value.
	 * 
	 * @return int the offset value.
	 */
	public function getValue()
	{
		return $this->value;
	}


	/**
	 * Compares this <i>TimeTriggerOffset</i> and the given object for equality. The two objects are considered
	 * equal if they are the same or are both <i>TimeTriggerOffset</i>s of the same type with the same unit and
	 * value.
	 * 
	 * @param mixed $obj the object to be compared to this <i>TimeTriggerOffset</i> for equality.
	 * @return bool <i>true</i> if the the given object is equal to this <i>TimeTriggerOffset</i>, <i>false</i> 
         *      otherwise.
	 */
	public function equals( $obj )
	{
		if( $this === $obj )
		{
			return true;
		}

		if( null === $obj )
		{
			return false;
		}

		if(gettype($this) !== gettype($obj) )
		{
			return false;
		}

		if( $this->type !== $obj->getType() )
		{
			return false;
		}

		if( $this->unit !== $obj->getUnit() )
		{
			return false;
		}

		if( $this->value !== $obj->getValue() )
		{
			return false;
		}

		return true;
	}
}
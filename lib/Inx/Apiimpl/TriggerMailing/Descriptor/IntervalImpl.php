<?php
final class Inx_Apiimpl_TriggerMailing_Descriptor_IntervalImpl implements Inx_Api_TriggerMailing_Descriptor_TriggerInterval
{
	private $intervalUnit;

	private $intervalCount;

	private $dispatchIntervals;

	private $dayInterval;


	public function __construct( Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit $intervalUnit, $iIntervalCount,
			array $dispatchIntervals, $iDayInterval )
	{
		$this->intervalUnit = $intervalUnit;
		$this->intervalCount = $iIntervalCount;
		$this->dispatchIntervals = $dispatchIntervals;
		$this->dayInterval = $iDayInterval;
	}


	public function getIntervalUnit()
	{
		return $this->intervalUnit;
	}


	public function getIntervalCount()
	{
		return $this->intervalCount;
	}


	public function getDispatchIntervals()
	{
		return $this->dispatchIntervals;
	}


	public function getDayInterval()
	{
		return $this->dayInterval;
	}


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

		if( gettype($this) !== gettype($obj) )
		{
			return false;
		}

		if( $this->dayInterval !== $obj->getDayInterval() )
		{
                        return false;
		}

		if( $this->dispatchIntervals !== $obj->getDispatchIntervals() )
		{
			return false;
		}

		if( $this->intervalCount !== $obj->getIntervalCount() )
		{
			return false;
		}

		if( $this->dayInterval !== $obj->getDayInterval() )
		{
			return false;
		}

		return true;
	}
}
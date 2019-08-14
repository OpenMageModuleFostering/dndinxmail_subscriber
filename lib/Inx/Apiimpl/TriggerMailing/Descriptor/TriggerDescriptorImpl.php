<?php
final class Inx_Apiimpl_TriggerMailing_Descriptor_TriggerDescriptorImpl implements Inx_Api_TriggerMailing_Descriptor_TriggerDescriptor
{
	private $type;

	private $startDate;
        
        private $sendingTime;

	private $endDate;

	private $attributeValueSetters;

	private $attributeId;

	private $offset;

	private $columnModificator;

	private $interval;


	public function __construct( Inx_Api_TriggerMailing_Descriptor_TriggerType $type, $sStartDate, $sSendingTime, 
                        $sEndDate, $iAttributeId, array $attributeValueSetters = null, 
                        Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset $offset = null,
			Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset $columnModificator = null, 
                        Inx_Api_TriggerMailing_Descriptor_TriggerInterval $interval = null )
	{
		$this->type = $type;
		$this->attributeValueSetters = !empty($attributeValueSetters) ? $attributeValueSetters : null;
		$this->attributeId = $iAttributeId;
		$this->offset = $offset;
		$this->columnModificator = $columnModificator;
		$this->interval = $interval;
                
                if(null !== $sSendingTime)
                {
                    $time = new DateTime( $sSendingTime );
                    $time->setTime( $time->format('H'), $time->format('i'), 0 );
                    $this->sendingTime = date('c', $time->getTimestamp());
                }
                
                if(null !== $sStartDate)
                {
                    $date = new DateTime( $sStartDate );
                    $time = new DateTime( $sSendingTime );
                    $date->setTime( $time->format('H'), $time->format('i'), 0 );
                    $this->startDate = date('c', $date->getTimestamp() );
                }
                
                if(null !== $sEndDate)
                {
                    $date = new DateTime( $sEndDate );
                    $time = new DateTime( $sSendingTime );
                    $date->setTime( $time->format('H'), $time->format('i'), 0 );
                    $this->endDate = date('c', $date->getTimestamp() );
                }
	}


	public function getType()
	{
		return $this->type;
	}


	public function getStartDate()
	{
		return $this->startDate;
	}
        
        
        public function getSendingTime() 
        {
                return $this->sendingTime;
        }


	public function getEndDate()
	{
		return $this->endDate;
	}


	public function getAttributeValueSetters()
	{
		return $this->attributeValueSetters;
	}


	public function getAttributeId()
	{
		return $this->attributeId;
	}


	public function getOffset()
	{
		return $this->offset;
	}


	public function getColumnModificator()
	{
		return $this->columnModificator;
	}


	public function getInterval()
	{
		return $this->interval;
	}
}
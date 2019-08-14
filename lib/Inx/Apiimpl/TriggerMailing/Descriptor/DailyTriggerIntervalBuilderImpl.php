<?php
class Inx_Apiimpl_TriggerMailing_Descriptor_DailyTriggerIntervalBuilderImpl 
        implements Inx_Api_TriggerMailing_Descriptor_DailyTriggerIntervalBuilder
{
        private $intervalCount;


        function __construct()
        {

        }


        public function build()
        {
                if( null === $this->intervalCount )
                {
                        throw new Inx_Api_IllegalStateException( "interval count must be specified" );
                }

                $dispatchInterval = array( Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::DAILY() );

                return new Inx_Apiimpl_TriggerMailing_Descriptor_IntervalImpl( 
                        Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::DAY(), $this->intervalCount, 
                        $dispatchInterval, null );
        }


        public function intervalCount( $iCount )
        {
                if( null === $iCount)
                {
                        throw new Inx_Api_NullPointerException( "The count may not be null" );
                }
            
                if( $iCount < Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::DAY()->getMinValue() )
                {
                        throw new Inx_Api_IllegalArgumentException( "count must not be less than " . 
                                Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::DAY()->getMinValue() );
                }

                if( $iCount > Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::DAY()->getMaxValue() )
                {
                        throw new Inx_Api_IllegalArgumentException( "count must not be more than " . 
                                Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::DAY()->getMaxValue() );
                }

                $this->intervalCount = $iCount;

                return $this;
        }

}
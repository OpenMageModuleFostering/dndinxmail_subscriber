<?php
class Inx_Apiimpl_TriggerMailing_Descriptor_MonthlyTriggerIntervalBuilderImpl 
        implements Inx_Api_TriggerMailing_Descriptor_MonthlyTriggerIntervalBuilder
{
        private $intervalCount;

        private $dispatchInterval;

        private $day;


        function __construct()
        {

        }


        public function build()
        {
                if( null === $this->intervalCount )
                {
                        throw new Inx_Api_IllegalStateException( "interval count must be specified" );
                }

                if( null === $this->dispatchInterval )
                {
                        throw new Inx_Api_IllegalStateException( "dispatch interval must be specified" );
                }

                if( $this->dispatchInterval === Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::LAST_DAY_OF_MONTH() 
                        && $this->day !== null && $this->day != 0 )
                {
                        throw new Inx_Api_IllegalStateException(
                                        "day must not be != 0 when using the dispatch interval LAST_DAY_OF_MONTH" );
                }

                if( $this->dispatchInterval === Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::SPECIFIC_DAY_OF_MONTH() 
                        && $this->day === null )
                {
                        throw new Inx_Api_IllegalStateException(
                                        "day must be specified when using the dispatch interval SPECIFIC_DAY_OF_MONTH" );
                }

                if( $this->dispatchInterval == Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::SPECIFIC_DAY_BEFORE_END_OF_MONTH() 
                        && $this->day === null )
                {
                        throw new Inx_Api_IllegalStateException(
                                        "day must be specified when using the dispatch interval SPECIFIC_DAY_BEFORE_END_OF_MONTH" );
                }

                $dispatchIntervals = array( $this->dispatchInterval );

                return new Inx_Apiimpl_TriggerMailing_Descriptor_IntervalImpl( Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::MONTH(), 
                        $this->intervalCount, $dispatchIntervals, $this->day );
        }


        public function intervalCount( $iCount )
        {
                if( null === $iCount )
                {
                        throw new Inx_Api_NullPointerException( "The count may not be null" );
                }
            
                if( $iCount < Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::MONTH()->getMinValue() )
                {
                        throw new Inx_Api_IllegalArgumentException( "count must not be less than " .
                                Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::MONTH()->getMinValue() );
                }

                if( $iCount > Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::MONTH()->getMaxValue() )
                {
                        throw new Inx_Api_IllegalArgumentException( "count must not be more than " .
                                Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::MONTH()->getMaxValue() );
                }

                $this->intervalCount = $iCount;

                return $this;
        }


        public function dispatchInterval( Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval $dispatchInterval )
        {
                if( null === $dispatchInterval )
                {
                        throw new Inx_Api_NullPointerException( "dispatchInterval must not be null" );
                }

                if( $dispatchInterval != Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::LAST_DAY_OF_MONTH()
                        && $dispatchInterval != Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::SPECIFIC_DAY_OF_MONTH()
                        && $dispatchInterval != Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::SPECIFIC_DAY_BEFORE_END_OF_MONTH() )
                {
                        throw new Inx_Api_IllegalArgumentException(
                                "dispatchInterval must be one of LAST_DAY_OF_MONTH, SPECIFIC_DAY_OF_MONTH or SPECIFIC_DAY_BEFORE_END_OF_MONTH" );
                }

                $this->dispatchInterval = $dispatchInterval;

                return $this;
        }


        public function day( $iDay )
        {
                if( $iDay < 1 )
                {
                        throw new Inx_Api_IllegalArgumentException( "day must not be less than 1" );
                }

                if( $iDay > 28 )
                {
                        throw new Inx_Api_IllegalArgumentException( "day must not be more than 28" );
                }

                $this->day = $iDay;

                return $this;
        }
}
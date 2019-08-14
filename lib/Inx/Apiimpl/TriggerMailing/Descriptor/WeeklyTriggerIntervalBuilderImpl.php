<?php
class Inx_Apiimpl_TriggerMailing_Descriptor_WeeklyTriggerIntervalBuilderImpl 
        implements Inx_Api_TriggerMailing_Descriptor_WeeklyTriggerIntervalBuilder
{
        private $intervalCount;

        private $dispatchIntervals;


        function __construct()
        {

        }


        public function build()
        {
                if( null === $this->intervalCount )
                {
                        throw new Inx_Api_IllegalStateException( "interval count must be specified" );
                }

                if( null === $this->dispatchIntervals )
                {
                        throw new Inx_Api_IllegalStateException( "dispatch intervals must be specified" );
                }

                return new Inx_Apiimpl_TriggerMailing_Descriptor_IntervalImpl( 
                        Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::WEEK(), $this->intervalCount, 
                        $this->dispatchIntervals, null );
        }


        public function intervalCount( $iCount )
        {
                if( null === $iCount )
                {
                        throw new Inx_Api_NullPointerException( "The count may not be null" );
                }
            
                if( $iCount < Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::WEEK()->getMinValue() )
                {
                        throw new Inx_Api_IllegalArgumentException( "count must not be less than " .
                                Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::WEEK()->getMinValue() );
                }

                if( $iCount > Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::WEEK()->getMaxValue() )
                {
                        throw new Inx_Api_IllegalArgumentException( "count must not be more than " .
                                Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::WEEK()->getMaxValue() );
                }

                $this->intervalCount = $iCount;

                return $this;
        }


        public function dispatchIntervals( array $dispatchIntervals )
        {
                if( null === $dispatchIntervals )
                {
                        throw new Inx_Api_NullPointerException( "dispatchIntervals must not be null" );
                }

                if( empty($dispatchIntervals) )
                {
                        throw new Inx_Api_IllegalArgumentException( "dispatchIntervals must not be empty" );
                }

                if( !self::containsWeekIntervalsOnly( $dispatchIntervals ) )
                {
                        throw new Inx_Api_IllegalArgumentException(
                                "dispatchIntervals may only contain MONDAY, TUESDAY, WEDNESDAY, " .
                                "THURSDAY, FRIDAY, SATURDAY and SUNDAY" );
                }

                $this->dispatchIntervals = $dispatchIntervals;

                return $this;
        }


        private static function containsWeekIntervalsOnly( array $intervals )
        {
                $result = true;

                foreach( $intervals as $interval )
                {
                        if( $interval !== Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::MONDAY() 
                                && $interval != Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::TUESDAY()
                                && $interval != Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::WEDNESDAY()
                                && $interval != Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::THURSDAY()
                                && $interval != Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::FRIDAY()
                                && $interval != Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::SATURDAY()
                                && $interval != Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::SUNDAY() )
                        {
                                $result = false;
                                break;
                        }
                }

                return $result;
        }
}
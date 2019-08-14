<?php
/**
 * The <i>Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType</i> defines the possible types of 
 * <i>Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset</i>s.
 * <p>
 * A note for programmers who are not familiar with the concept of enumerations: Enumerations or enumerated types are basically 
 * a fixed set of named values. They are usually used to define a couple of legitimate values in a specific context and serve a 
 * purpose similar to integer constants. 
 * The advantage of enumerations is, that you cannot specify any "weird" values because every value has to be an instance of 
 * the enumerated type. It is also possible to associate data or even behaviour (methods) with the values. 
 * PHP does not support such a language feature like Java and C# do. In most languages the named values are a sort of constant 
 * whose value is an instance of the enumerated type. In PHP a constant cannot contain a reference type. Therefore, we 
 * implemented enumerations as classes with private constructor and methods which return the named values.
 * Be aware that the objects returned by the static methods are always the same object. That way it is possible to use the 
 * identity operator (===) on these objects and use them comfortably in switch statements.
 * 
 * @since API 1.10.0
 * @author chge, 16.07.2012
 */
 final class Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType
 {
        private static $IS_IN = null;
        
        private static $WAS_AGO = null;
        
        private static $UNKNOWN = null;
     
        /**
         * Constant for positive offsets.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType the is in <i>TimeTriggerOffsetType</i>.
         */
        public static final function IS_IN()
        {
            if(null === self::$IS_IN)
                self::$IS_IN = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType( 1 );
            
            return self::$IS_IN;
        }
                
        /**
         * Constant for negative offsets.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType the was ago <i>TimeTriggerOffsetType</i>.
         */
        public static final function WAS_AGO()
        {
            if(null === self::$WAS_AGO)
                self::$WAS_AGO = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType( 2 );
            
            return self::$WAS_AGO;
        }

        /**
         * Constant for an unknown offset type. Indicates a version mismatch between API and server.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType the unknown <i>TimeTriggerOffsetType</i>.
         */
        public static final function UNKNOWN()
        {
            if(null === self::$UNKNOWN)
                self::$UNKNOWN = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType( -1 );
            
            return self::$UNKNOWN;
        }

        private $id;


        private function __construct( $iId )
        {
                $this->id = $iId;
        }


        /**
         * Returns the ID of the <i>TimeTriggerOffsetType</i>. The ID is used for transmission purposes and should
         * not be used inside client code.
         * 
         * @return int the ID of the <i>TimeTriggerOffsetType</i>.
         */
        public function getId()
        {
                return $this->id;
        }


        /**
         * Returns the <i>TimeTriggerOffsetType</i> corresponding to the given ID. If the ID is unknown, the
         * UNKNOWN type will be used. The ID is used for transmission purposes and should not be used inside client
         * code.
         * 
         * @param int $iId the ID of the <i>TimeTriggerOffsetType</i> to retrieve.
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType the <i>TimeTriggerOffsetType</i> corresponding 
         * to the given ID.
         */
        public static function byId( $iId )
        {
                foreach( self::values() as $type )
                {
                        if( $type->getId() == $iId )
                        {
                                return $type;
                        }
                }

                return self::UNKNOWN();
        }
        
        /**
         * Returns an array containing all available <i>TimeTriggerOffsetType</i>s including UNKNOWN.
         * 
         * @return array an array containing all available <i>TimeTriggerOffsetType</i>s including UNKNOWN.
         */
        public static function values()
        {
            return array(self::IS_IN(), self::WAS_AGO(), self::UNKNOWN());
        }
 }
<?php

class Inx_Apiimpl_Property_PropertyFormatterImpl implements Inx_Api_Property_PropertyFormatter
{

	private $context;


	public function __construct(  $context )
	{
		$this->context = $context;
	}


	public function createApprovalPropertyValue( $value )
	{

		return $this->context->createApprovalPropertyValue( $value );
	}


	public function parseApprovalPropertyValue( $property )
	{

		if( Inx_Api_Property_PropertyNames::APPROVAL_ACTIVE != $property->getName() )
			throw new Inx_Api_IllegalArgumentException( "wrong property" );
		return $this->context->parseApprovalProperty( $property->getInternalValue() );
	}
}

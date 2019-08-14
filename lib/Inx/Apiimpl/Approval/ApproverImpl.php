<?php

/**
 * ApproverImpl
 * 
 * @version 
 */
class Inx_Apiimpl_Approval_ApproverImpl implements Inx_Api_Approval_Approver
{

	protected $_oSc;
    
    protected $_oData;
     
    private $service;
    
    
    public function __construct( $oSc, stdClass $oData )
    {
	    $this->_oSc = $oSc;
	    $this->_oData = $oData;
	    $this->service = $oSc->getService( Inx_Apiimpl_SessionContext::APPROVER_SERVICE );
	}


	public function commitUpdate()
	{
		if( empty($this->_oData->comment) || empty($this->_oData->email) || empty($this->_oData->listIds) || 
			empty($this->_oData->name) )
			throw new Inx_Api_UpdateException( "Commiting wrong values", Inx_Api_UpdateException::ERROR_TYPE_ILLEGAL_VALUE,
					Inx_Api_UpdateException::ERROR_SOURCE_NOT_SPECIFIED );
		try
		{
			$adh = $this->service->update( $this->_oSc->createCxt(), $this->_oData );
			if( !empty($adh->excDesc) )
				throw new Inx_Api_UpdateException( $adh->excDesc->msg, $adh->excDesc->type, $adh->excDesc->source );

			if( !empty($adh->value) )
			{
				$this->_oData = $adh->value;
			}
			else
				throw new Inx_Api_DataException( "deleted object" );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
		}
	}


	public function getId()
	{
		return $this->_oData->id;
	}


	public function reload() 
	{
		try
		{
			$this->_oData = $this->service->get( $this->_oSc->createCxt(), $this->_oData->id );
			if( empty($this->_oData) )
				throw new Inx_Api_DataException( "approver deleted" );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
		}

	}


	public function convert( Inx_Apiimpl_SessionContext $sc, $approverData )
	{
		if( $approverData === null )
			return null;
		
		return new Inx_Apiimpl_Approval_ApproverImpl( $sc, $approverData );
	}


	public function convertArr( Inx_Apiimpl_SessionContext $sc, $data )
	{
		if( empty($data) )
			return array();

		$rs = array();
		foreach ($data as $i => $entryValue ) {
			if ($entryValue) {
				$rs[$i] = new Inx_Apiimpl_Approval_ApproverImpl( $sc, $entryValue );
			}
		}
		return $rs;
	}


	public function getComment()
	{
		return $this->_oData->comment;
	}


	public function getEmail()
	{
		return $this->_oData->email;
	}


	public function getLists()
	{
		return $this->_oData->listIds;
	}


	public function getName()
	{
		return $this->_oData->name;
	}


	public function updateComment( $sComment )
	{
		$this->_oData->comment = $sComment;
	}


	public function updateEmail( $sEmail )
	{
		$this->_oData->email = $sEmail;
	}


	public function updateLists( $lists )
	{
		$this->_oData->listIds = $lists;
	}


	public function updateName( $sName )
	{
		$this->_oData->name = $sName;
	}
}

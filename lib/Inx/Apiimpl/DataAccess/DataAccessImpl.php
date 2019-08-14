<?php

/**
 * 
 * 
 * @author sbn, 16.01.2007
 * @copyright Inxmail GmbH
 * @version $Revision:$ $Date:$ $Author:$
 */
class Inx_Apiimpl_DataAccess_DataAccessImpl implements Inx_Api_DataAccess_DataAccess
{
	private $_oSessionContext;

	public function __construct( Inx_Apiimpl_SessionContext $oSc )
	{
		$this->_oSessionContext = $oSc;
	}

	public function getClickData()
	{
		return new Inx_Apiimpl_DataAccess_ClickDataImpl($this->_oSessionContext);
	}

	public function getLinkData()
	{
		return new Inx_Apiimpl_DataAccess_LinkDataImpl($this->_oSessionContext, false);
	}

	public function getLinkDataWithNewLinkType()
	{
		return new Inx_Apiimpl_DataAccess_LinkDataImpl($this->_oSessionContext, true);
	}
}

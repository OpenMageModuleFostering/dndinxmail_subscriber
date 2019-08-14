<?php
/**
 * UserContextImpl
 * 
 * @version $Revision: 3332 $ $Date: 2005-10-07 13:32:53 +0000 (Fr, 07 Okt 2005) $ $Author: bgn $
 */
class Inx_Apiimpl_Core_UserContextImpl implements Inx_Api_UserContext
{
    
	protected $_oSessionContext;
	
	protected $_aUserRightSet = array();
    
    protected $_iRefreshTimestamp = null;

    
    public function __construct( Inx_Apiimpl_SessionContext $sc )
    {
    	$this->_oSessionContext = $sc;
    }
    
    
    public function hasUserRight( $sUserRight )
    {
    	if( $this->_iRefreshTimestamp === null )
    		$this->refresh();
    	
        return isset($this->_aUserRightSet[$sUserRight]);
    }

    
    public function refresh()
    {
    	try
	    {
            $cService = $this->_oSessionContext->getService( Inx_Apiimpl_SessionContext::CORE_SERVICE );
            $aUrs = Inx_Apiimpl_TConvert::TArrToArr( $cService->getUserRights( $this->_oSessionContext->sessionId() ) );
            
            $this->_iRefreshTimestamp = time();
            $this->_aUserRightSet = array();
            foreach($aUrs as $right) {
                $this->_aUserRightSet[$right] = true;
            }

	    }
	    catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
		}
    }


    public function getLastRefresh()
    {
    	return $this->_iRefreshTimestamp;
    }
    
    public function whoAmI()
    {
    	try
		{
			$cService = $this->_oSessionContext->getService( Inx_Apiimpl_SessionContext::CORE_SERVICE );
            $user = $cService->whoAmI($this->_oSessionContext->sessionId());
			return new Inx_Api_User($user);
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
    }
    
}

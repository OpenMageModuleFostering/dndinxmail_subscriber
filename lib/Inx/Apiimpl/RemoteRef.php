<?php
/**
 * RemoteRef represents the handle for a remote object. A local stub uses a 
 * remote reference to carry out a remote method invocation to a remote object. 
 * 
 * <P>Copyright (c) 2005 Inxmail GmbH. All Rights Reserved.
 * @version $Revision: 9350 $ $Date: 2007-12-10 09:36:24 +0200 (Pr, 10 Grd 2007) $ $Author: aurimas $
 */
interface Inx_Apiimpl_RemoteRef extends Inx_Apiimpl_SessionContext
{
    /**
	 * Returns the remote reference id.
	 * 
	 * @return	the remote reference id
	 */
    public function refId();
    
    /**
	 * Releases this remote reference and the corresponding report object on server.
	 * 
	 * @param immediate	releases this remote reference immediately instead of waiting
	 * for the next call to the server
	 */
	public function release( $blImmediate );

	
	/**
	 * Retrieves whether this remote reference has been released.
	 * 
	 * @return	true if this remote reference has been released; false otherwise
	 */
	public function isReleased();
    
}


?>
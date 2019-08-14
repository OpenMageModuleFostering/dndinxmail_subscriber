<?php
/**
 * Uploader
 * 
 * @version $Revision: 2934 $ $Date: 2005-07-04 15:00:09 +0000 (Mo, 04 Jul 2005) $ $Author: bgn $
 */
class Inx_Apiimpl_Core_Uploader
{
    /**
     * @param Inx_Apiimpl_RemoteRef $remoteRef
     * @param resource $is resource that can be read with fread
     * @throws Inx_Api_IOException
     */
    public static function upload( Inx_Apiimpl_RemoteRef $remoteRef, $is, $iMaxChunkSize,
            $blExplicitClose ) 
    {
        $oService = $remoteRef->getService( Inx_Apiimpl_RemoteRef::CORE_SERVICE ); 
        if (!is_int($iMaxChunkSize)) {
            throw new Inx_Api_IllegalArgumentException('Integer parameter $iMaxChunkSize expected, got '.gettype($iMaxChunkSize));
        }
        while( !feof($is) )
        {
            $buffer = fread($is, $iMaxChunkSize );
            
            try {
                $r = $oService->writeOutputStream($remoteRef->sessionId(), $remoteRef->refId(), $buffer);
            }
            catch(Inx_Api_RemoteException $e) {
                throw new Inx_Api_IOException($e->getMessage());
            }

        }
        if( $blExplicitClose )
        {
            try {
                $r = $oService->closeOutputStream( $remoteRef->sessionId(), $remoteRef->refId() );
            }
            catch(Inx_Api_RemoteException $e) {
                throw new Inx_Api_IOException($e->getMessage());
            }
            
        }
        
    }

}

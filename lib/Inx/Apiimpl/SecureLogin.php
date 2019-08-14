<?php
/**
 * Created on 2007.11.19
 *
 * @copyright (C) UAB "Net frequency" 2007
 *
 * This Software is the property of UAB "Net frequency" 
 * and is protected by copyright law - it is NOT Freeware.
 *
 * Any use of this software without a permission from
 * UAB "Net frequency" will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB "Net frequency":
 * E-mail: info@nfq.lt
 * Phone: +370 37 333053
 * http://www.nfq.lt
 */
 
 class Inx_Apiimpl_SecureLogin 
 {
 	private $ENCRYPTION_ALGO = "sha256";
 	private $userSalt;
 	private $sessionSalt;
 	private $md;
 	
 	public function __construct($params) {
		$this->userSalt = $params[1];
		$this->sessionSalt = $params[2];
 	}
 	
 	public function getAlgorithm()
 	{
 		return $this->ENCRYPTION_ALGO;
 	}
	
 	public function encodePassword( $password )
	{
		try
		{
			$initDigest = $this->saltedHash( $password, base64_decode( $this->userSalt ) );
			return base64_encode( $this->saltedHash( $initDigest, base64_decode( $this->sessionSalt ) ) );
		}
		catch( Exception $x )
		{
			throw new Inx_Api_APIException( $x->getMessage(), $x );
		}
	}


	protected function saltedHash( $pass, $salt )
	{
		$md = hash_init($this->ENCRYPTION_ALGO);
		hash_update($md, $salt);
		hash_update($md, $pass);
		return hash_final($md,TRUE);
	}
	
 }
 
 
?>

<?php
/**
 * ListSizeImpl
 * 
 * @version $Revision: 7335 $ $Date: 2007-09-10 14:58:22 +0200 (Mo, 10 Sep 2007) $ $Author: sbn $
 */
class Inx_Apiimpl_List_ListSizeImpl implements Inx_Api_List_ListSize
{
 
 	private $size;
 	private $creationDate;
 	public function __construct( $size, $creationDate )
	{
	    $this->size = $size;
	    $this->creationDate = $creationDate;
	}
 
	public function getSize()
	{
		return $this->size;
	}
	
	public function getCreationDate()
	{
		return $this->creationDate;
	}

}

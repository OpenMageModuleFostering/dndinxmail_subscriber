<?php

class Inx_Apiimpl_Recipient_RecipientContextImpl_AttributeIterator extends ArrayIterator {
	/**
	 * alias for ArrayIterator::valid();
	 *
	 * @return boolean
	 */
	public function hasNext()
	{
		return $this->valid();
	}
		
	public function remove()
	{
		throw new Exception("Unsupported operation");
	}
}
<?php

interface Inx_Apiimpl_Constants
{
	
	const ID_UNSPECIFIED = 0;
		
	const FETCH_FORWARD_DIRECTION = 1;
	
	const FETCH_BACKWARD_DIRECTION = -1;

	
	const SYSTEM_LIST_CONTEXT_ID = 1;

	
	const SERVER_RUNTIME_EXCEPTION = "SERVER_RUNTIME_EXCEPTION";

	const SERVER_INACTIVE_EXCEPTION = "SERVER_INACTIVE_EXCEPTION";

	const ILLEGAL_SESSION_EXCEPTION = "ILLEGAL_SESSION_EXCEPTION";

	const ILLEGAL_REFERENCE_EXCEPTION = "ILLEGAL_REFERENCE_EXCEPTION";
	
	const SECURITY_EXCEPTION = "SECURITY_EXCEPTION";

	const MEMORY_EXCEPTION = "MEMORY_EXCEPTION";

	
	/**
	 * the array index of list type of list context bo
	 */
	const LIST_ATTR_LIST_TYPE = 0;

	/**
	 * the array index of list type of list context bo
	 */
	const LIST_ATTR_CREATION_DATETIME = 3;

}

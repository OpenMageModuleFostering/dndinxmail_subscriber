<?php
/*
 * Copyright (c) 2006 Inxmail GmbH. All Rights Reserved. This code is part of the Inxmail API documentation. It is
 * distributed in the hope that it will be useful, but a warranty of any kind. ALL EXPRESS OR IMPLIED CONDITIONS,
 * REPRESENTATIONS AND WARRANTIES, INCLUDING ANY IMPLIED WARRANTY OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE
 * OR NON-INFRINGEMENT, ARE HEREBY EXCLUDED. INXMAIL GMBH ("INXMAIL") AND ITS LICENSORS SHALL NOT BE LIABLE FOR ANY
 * DAMAGES SUFFERED BY LICENSEE AS A RESULT OF USING, MODIFYING OR DISTRIBUTING THIS SOFTWARE OR ITS DERIVATIVES. IN NO
 * EVENT WILL INXMAIL OR ITS LICENSORS BE LIABLE FOR ANY LOST REVENUE, PROFIT OR DATA, OR FOR DIRECT, INDIRECT, SPECIAL,
 * CONSEQUENTIAL, INCIDENTAL OR PUNITIVE DAMAGES, HOWEVER CAUSED AND REGARDLESS OF THE THEORY OF LIABILITY, ARISING OUT
 * OF THE USE OF OR INABILITY TO USE THIS SOFTWARE, EVEN IF INXMAIL HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.
 * You acknowledge that this software is not designed, licensed or intended for use in the design, construction,
 * operation or maintenance of any nuclear facility.
 */

/**
 * @package Inxmail
 * @subpackage Action
 */
/**
 * Use the <i>Inx_Api_Action_SendActionMailCommand</i> to send an action mailing to a recipient. The action 
 * mailing must be approved in order to be used.
 * 
 * @see Inx_Api_Action_CommandFactory
 * @since API 1.10.0
 */
interface Inx_Api_Action_SendActionMailCommand extends Inx_Api_Action_Command
{
	/**
	 * Returns the id of the standard or filter list context associated with this command.
	 * 
	 * @return int the id of the list context.
	 */
	public function getListContextId();


	/**
	 * Returns the id of the action mailing associated with this command.
	 * 
	 * @return int the id of the action mailing.
	 */
	public function getMailingId();

}
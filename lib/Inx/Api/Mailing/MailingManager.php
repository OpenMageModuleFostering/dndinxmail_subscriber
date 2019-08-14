<?php
/**
 * @package Inxmail
 * @subpackage Mailing
 */

/**
 * The <i>Inx_Api_Mailing_MailingManager</i> manages all mailings. 
 * The <i>MailingManager</i> can be used to perform the following tasks:
 * <ul>
 * <li>Retrieve mailings
 * <li>Create mailings
 * <li>Clone mailings
 * <li>Create a renderer to generate a preview of the mailing
 * </ul>
 * <p>
 * <strong>Mailing retrieval</strong>
 * <p>
 * There are several ways to retrieve mailings. 
 * The simplest way is to call <i>selectAll()</i> which will retrieve all mailings. 
 * To retrieve a single mailing, use the <i>get($iMailingId)</i> method. 
 * To retrieve all mailings of a specific list use one of the <i>select(...)</i> methods. 
 * Using this type of method gives you the ability to define search filters, like the mailing state. 
 * It is also possible to order the result.
 * <p>
 * The following snippet shows how to retrieve all mailings of a specific list, which are either in the
 * <code>DRAFT</code> or the <code>TO_BE_APPROVE</code> state and print out their names:
 * 
 * <pre>
 * $oMailingManager = $oSession->getMailingManager();
 * $oBOResultSet = $oMailingManager->select($oListContext, Inx_Api_Mailing_Mailing::STATE_DRAFT 
 * 		| Inx_Api_Mailing_Mailing::STATE_TO_BE_APPROVE);
 * 
 * for( $i = 0; $i < $oBOResultSet->size(); $i++ )
 * {
 *   $oMailing = $oBOResultSet->get($i);
 *   echo $oMailing->getName()."&#60;br&#62;";
 * }
 * 
 * $oBOResultSet->close();
 * </pre>
 * 
 * To retrieve all mailings of a specific list, disregarding their state, use the state filter <i>STATE_FILTER_ALL</i>. 
 * This filter produces the same result as a bitwise combination of all mailing states.
 * <p>
 * If needed, it is possible to create much more complex select statements than the one above. This can be accomplished
 * using filter expressions. The following snippet extends the previous select statement with a filter that restricts
 * the result to mailings which were modified during the last hour. The result is also ordered by the mailing name:
 * 
 * <pre>
 * $oMailingManager = $oSession->getMailingManager();
 * 
 * $filterDate = date("d.m.Y H:i:s", strtotime("-1 hour"));
 * $filter = "Attribute(".Inx_Api_Mailing_Mailing::ATTRIBUTE_MODIFICATION_DATETIME.") > #".$filterDate."#";
 * 
 * $oBOResultSet = $oMailingManager->select($oListContext, Inx_Api_Mailing_Mailing::STATE_DRAFT 
 * 		| Inx_Api_Mailing_Mailing::STATE_TO_BE_APPROVE, $filter, Inx_Api_Mailing_Mailing::ATTRIBUTE_NAME, 
 * 		Inx_Api_Order::ASC);
 * 
 * for($i = 0; $i < $oBOResultSet->size(); $i++)
 * {
 *   $oMailing = $oBOResultSet->get($i);
 *   echo $oMailing->getName()."&#60;br&#62;";
 * }
 * 
 * $oBOResultSet->close();
 * </pre>
 * <p>
 * <strong>Mailing creation and editing</strong>
 * <p>
 * The following snippet shows how to create a mailing:
 * 
 * <pre>
 * $oMailingManager = $oSession->getMailingManager();
 * $oMailing = $oMailingManager->createMailing($oListContext);
 * $oMailing->updateSubject("Monthly Newsletter");
 * $oMailing->commitUpdate();
 * </pre>
 * <p>
 * <strong>Note:</strong> For existing mailings, always call <i>lock()</i> before updating it, and
 * <i>unlock()</i> after committing changes!
 * <p>
 * The following snippet shows how to edit an existing mailing:
 * 
 * <pre>
 * $oMailingManager = $oSession->getMailingManager();
 * $oMailing = $oMailingManager->get($iMailingId);
 * 
 * try
 * {
 *   $oMailing->lock();
 *   $oMailing->updateSubject("New Subject");
 *   $oMailing->commitUpdate();
 *   $oMailing->unlock();
 * }
 * catch(Inx_Api_LockException $x)
 * {
 *   //somone else has locked this mailing
 * }
 * </pre>
 * <p>
 * It is not necessary to repeatedly create almost identical mailings. This can be accomplished a lot easier using the
 * <i>clone()</i> method.
 * <p>
 * The following snippet shows how to clone a mailing and put the clone in the specified list:
 * 
 * <pre>
 * $oMailingManager = $oSession->getMailingManager();
 * $oMailingManager->cloneMailing($iMailingId, $oListContext);
 * </pre>
 * <p>
 * <strong>Preview generation</strong>
 * <p>
 * To create a preview of a mailing, an <i>Inx_Api_Mail_MailingRenderer</i> is needed. 
 * A renderer can be obtained using the <i>createRenderer()</i> method.
 * <p>
 * The following snippet shows how to create a <code>MailingRenderer</code> and generate a preview of the mailing:
 * 
 * <pre>
 * $oMailingManager = $oSession->getMailingManager();
 * $oMailingRenderer = $oMailingManager->createRenderer();
 * $oMailingRenderer->parse($iMailingId, Inx_Api_Mail_MailingRenderer::BUILD_MODE_PREVIEW);
 * $oMailContent = $oMailingRenderer->build($iRecipientId);
 * 
 * echo $oMailContent->getPlainText()."&#60;br&#62;";
 * </pre>
 * <p>
 * For more information on mailings, see the <i>Inx_Api_Mailing_Mailing</i> documentation.
 * <p>
 * Note: To use mailings, the following api user right is required: <i>Inx_Api_UserRights::MAILING_FEATURE_USE</i>
 * 
 * @see Inx_Api_Mailing_Mailing
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Mailing
 */
interface Inx_Api_Mailing_MailingManager extends Inx_Api_BOManager
{

	/** @deprecated replaced by Inx_Api_Order::ASC */
	const ORDER_ASC = 0;
	
	/** @deprecated replaced by Inx_Api_Order::DESC */
	const ORDER_DESC = 1;

	    
	/**
	 * State filter constants to returning all mailings.
	 * It's the same like:
	 * <pre>
	 * $iStateFilter = Inx_Api_Mailing_Mailing::STATE_DRAFT | Inx_Api_Mailing_Mailing::STATE_TO_BE_APPROVE | Inx_Api_Mailing_Mailing::STATE_APPROVED
	 * 		| Inx_Api_Mailing_Mailing::STATE_SCHEDULED | Inx_Api_Mailing_Mailing::STATE_SENDING| Inx_Api_Mailing_Mailing::STATE_INTERRUPTED
	 * 		| Inx_Api_Mailing_Mailing::STATE_SENT | Inx_Api_Mailing_Mailing::STATE_SENDING_FAILED;
	 * </pre>
	 */
	const STATE_FILTER_ALL = 0xFFFF;
	
	/**
	 * Selects mailings in specified order, filtered by the supplied condition.<br>
	 * The <i>Inx_Api_BOResultSet</i> contains a set of <i>Inx_Api_Mailing_Mailing</i> objects.
	 * 
	 * The stateFilter must be either a single value like:
	 * <ul>
	 * <li>Inx_Api_Mailing_Mailing::STATE_DRAFT
	 * <li>Inx_Api_Mailing_Mailing::STATE_TO_BE_APPROVE
	 * <li>Inx_Api_Mailing_Mailing::STATE_APPROVED
	 * <li>Inx_Api_Mailing_Mailing::STATE_SCHEDULED
	 * <li>Inx_Api_Mailing_Mailing::STATE_SENDING
	 * <li>Inx_Api_Mailing_Mailing::STATE_INTERRUPTED
	 * <li>Inx_Api_Mailing_Mailing::STATE_SENT
	 * <li>Inx_Api_Mailing_Mailing::STATE_SENDING_FAILED
	 * </ul>
	 * or a bitwise combination, e.g. Inx_Api_Mailing_Mailing::STATE_SCHEDULED|Inx_Api_Mailing_Mailing::STATE_SENDING
	 * or Inx_Api_Mailing_Mailing::STATE_DRAFT|Inx_Api_Mailing_Mailing::STATE_TO_BE_APPROVE|Inx_Api_Mailing_Mailing::STATE_APPROVED
	 * 
	 * 
	 * The filter is a boolean expression on one mailing attribute. Attributes are specified with the function <i>Attribute(id)</i>.
	 * Please note that date-values for the filter have to be specified in german 24-hour date-format. To accomplish this, the date() 
	 * function with the following date-pattern can be used:
	 * 
	 * <pre>
	 * $filterDate = date("d.m.Y H:i:s");
	 * </pre>
	 * 
	 * The orderAttribute is the id of the order attribute.
	 * 
	 * Allowed values for attribute ids are:
	 * <ul>
	 * <li>Inx_Api_Mailing_Mailing::ATTRIBUTE_SUBJECT
	 * <li>Inx_Api_Mailing_Mailing::ATTRIBUTE_MODIFICATION_DATETIME
	 * <li>Inx_Api_Mailing_Mailing::ATTRIBUTE_SENT_START_DATETIME
	 * <li>Inx_Api_Mailing_Mailing::ATTRIBUTE_SENT_END_DATETIME 
	 * </ul>
	 * 
	 * @param Inx_Api_List_ListContext $oListContext list from which to select
	 * @param int $iStateFilter s.above.
	 * @param string $sFilter filter expression
	 * @param int $iOrderAttribute order attribute id
	 * @param int $iOrderType one of Order.ASC and Order.DESC fort order direction
	 * @return Inx_Api_BOResultSet	the result set of <i>Inx_Api_Mailing_Mailing</i> objects
	 * @throws Inx_Api_FilterStmtException
	 */
	public function select( Inx_Api_List_ListContext $oListContext = null, $iStateFilter, $sFilter = null,
    		$iOrderAttribute = null, $iOrderType = null );
	
	/**
	 * Creates a new mailing in the specified list.
	 * 
	 * @param $oListContext	list owner of the mailing
	 * @return Inx_Api_Mailing_Mailing a new mailing
	 */
	public function createMailing( Inx_Api_List_ListContext $oListContext );


	/**
	 * Creates the new <i>Inx_Api_Mail_MailingRenderer</i> to rendering a <i>Inx_Api_Mailing_Mailing</i>.
	 * 
	 * @return Inx_Api_Mail_MailingRenderer the new <i>Inx_Api_Mail_MailingRenderer</i>
	 */
	public function createRenderer();
	
		/**
	 * Creates the new <code>Inx_Api_Mail_MailingRenderer</code> to rendering a <code>Mailing</code> with test recipients.
	 * 
	 * @return the new <code>Inx_Api_Mail_MailingRenderer</code>
	 * @since API 1.6.0
	 */
	public function createRendererForTestRecipient();

	/**
	 * Copies a <code>Inx_Api_Mail_Mailing</code> to the specified list.
	 * 
	 * @return the new <code>Inx_Api_Mail_Mailing</code>
	 * @since API 1.6.0
	 */
	public function cloneMailing($iMailingId, Inx_Api_List_ListContext $oListContext );
	
}

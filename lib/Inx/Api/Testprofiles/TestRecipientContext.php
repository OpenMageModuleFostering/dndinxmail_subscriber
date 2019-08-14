<?php

/**
 * @package Inxmail
 * @subpackage Recipient
 */

/**
 * The <i>Inx_Api_Testprofiles_TestRecipientContext</i> is used to access and manipulate test recipient data. 
 * The following operations can be performed using the <i>Inx_Api_Testprofiles_TestRecipientContext</i>:
 * <p>
 * <ul>
 * <li>Fetch test recipient data as <i>Inx_Api_Testprofiles_TestRecipientRowSet</i>
 * <li>Add and remove test recipients
 * <li>Retrieve and update test recipient attribute values
 * </ul>
 * There are various methods for fetching test recipient data as <i>Inx_Api_Testprofiles_TestRecipientRowSet</i>. 
 * The following snippet exemplary shows how to use one specific <code>select</code> method which retrieves all 
 * test recipients of the specified list whose name is equal to smith, ignoring case considerations:
 * 
 * <pre>
 * $oTestRecipientContext = $oSession->createTestRecipientContext();
 * $oRecipientContext = $oSession->createRecipientContext();
 * $oAttribute_name = $oRecipientContext->getMetaData()->getUserAttribute( &quot;name&quot; );
 * $oListContext = $oSession->getListContextManager()->findByName( &quot;Desired list&quot; );
 * 
 * $sNameFilter = 'Column(&quot;name&quot;) LIKE &quot;smith&quot;';
 * $oTestRecipientRowSet = $oTestRecipientContext->select( $oListContext, null, $sNameFilter );
 * 
 * while( $oTestRecipientRowSet->next() )
 * {
 * 	echo $oTestRecipientRowSet->getString( $oAttribute_name ).&quot;&#60;br&#62;&quot;;
 * }
 * 
 * $oTestRecipientRowSet->close();
 * </pre>
 * 
 * <strong>Note:</strong> The % sign can not be used as wildcard in the LIKE statements of the <i>TestRecipientContext</i>. 
 * If you use a filter which includes the % sign, the filter will only match test recipients which contain the % sign.<br>
 * For example the filter statement <i>&quot;Column(\&quot;name\&quot;) LIKE \&quot;s%\&quot;&quot;</i> will match test 
 * recipients whose name is either s% or S% but not, for example, Smith.
 * <p>
 * Adding and removing recipients can be accomplished by using the <i>Inx_Api_Testprofiles_TestRecipientRowSet</i>. 
 * The name and email address are mandatory fields and must be updated. 
 * Otherwise an <i>Inx_Api_Recipient_IllegalValueException</i> will be triggered. 
 * The following snippet shows how to add a new test recipient using an empty <i>TestRecipientRowSet</i>:
 * 
 * <pre>
 * $oTestRecipientContext = $oSession->createTestRecipientContext();
 * $oListContext = $oSession->getListContextManager()->findByName( &quot;Desired list&quot; );
 * $oTestRecipientRowSet = $oTestRecipientContext->createRowSet( $oListContext );
 * $oAttribute_email = $oSession->createRecipientContext()->getMetaData()->getEmailAttribute();
 * 
 * $oTestRecipientRowSet->moveToInsertRow();
 * $oTestRecipientRowSet->updateName( &quot;New recipient&quot; );
 * $oTestRecipientRowSet->updateString( $oAttribute_email, &quot;new@recipient.invalid&quot; );
 * $oTestRecipientRowSet->commitRowUpdate();
 * $oTestRecipientRowSet->close();
 * </pre>
 * 
 * Removing a recipient using the <i>TestRecipientRowSet</i> can be accomplished by selecting only one specific test recipient. 
 * To do so, use a filter expression on the email attribute. 
 * The following snippet shows how to do this:
 * 
 * <pre>
 * $oTestRecipientContext = $oSession->createTestRecipientContext();
 * $oListContext = $oSession->getListContextManager()->findByName( &quot;Desired list&quot; );
 * $oTestRecipientRowSet = $oTestRecipientContext->select( $oListContext, null, 'Column(&quot;email&quot;) = &quot;abusive@recipient.invalid&quot;' );
 * 
 * $oTestRecipientRowSet->next();
 * $oTestRecipientRowSet->deleteRow();
 * $oTestRecipientRowSet->close();
 * </pre>
 * <p>
 * Test recipient attribute values can be updated using the 
 * <i>Inx_Api_Testprofiles_TestRecipientRowSet::setAttributeValue($oAttribute, $oValue)</i> method. 
 * The test recipient creation example further above used this method to update the email address of the newly created test recipient.
 * <p>
 * <strong>Note:</strong> Getting this context from the session will get a snapshot of the current attributes defined.
 * This snapshot will be used for the lifetime of the context, changes in the underlying attribute configuration won't
 * be reflected to it. 
 * This ensures that you can safely work with recipient data, even if other users possibly add or change attributes.
 * <p>
 * However, if a recipient attribute is deleted or the type is changed, this will also not be reflected to the 
 * <i>TestRecipientContext</i>. 
 * The attribute values may still be changed without any error, though this change will not be visible in Inxmail. 
 * The recipient attribute will not be undeleted. 
 * Therefore, it is not recommended to use the same test recipient context during long operations as the possibility 
 * of changes in the recipient attributes will rise.
 * <p>
 * <strong>Note:</strong> An <i>Inx_Api_Testprofiles_TestRecipientContext</i> object <strong>must</strong> be closed once it is not
 * needed anymore to prevent memory leaks and other potentially harmful side effects.
 * 
 * @see Inx_Api_Testprofiles_TestRecipientRowSet
 * @see Inx_Api_Recipient_RecipientContext
 * @see Inx_Api_Recipient_RecipientMetaData
 * @since API 1.6
 * @version $Revision: 9506 $ $Date: 2007-12-20 15:44:56 +0200 (Kt, 20 Grd 2007) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Testprofiles
 */
interface Inx_Api_Testprofiles_TestRecipientContext
{

	/**
	 * Returns an <i>Inx_Api_Testprofiles_TestRecipientRowSet</i> containing all test recipients that are members of 
	 * the given list and match the given filter and additional filter statement. 
	 * The filter and additional filter statement attributes may be ommitted or <i>null</i>, though the list 
	 * parameter is mandatory.
	 * <p>
	 * For further information on the filter statement syntax, see the
	 * <i>Inx_Api_Filter_Filter::updateStatement($sStatement)</i> documentation.
	 * <p>
	 * <strong>Note:</strong> The % sign can not be used as wildcard in the LIKE statements of the* <i>TestRecipientContext</i>. 
	 * If you use a filter which includes the % sign, the filter will only match test recipients which contain the % sign.<br>
	 * For example the filter statement <i>'Column(&quot;name&quot;) LIKE &quot;s%&quot;'</i> will match test recipients 
	 * whose name is either s% or S% but not, for example, Smith.
	 * 
	 * @param Inx_Api_List_ListContext $list all members of this list will be selected.
	 * @param Inx_Api_Filter_Filter $oFilter the selection filter. May be ommitted or <i>null</i>.
	 * @param string $sAdditionalFilter the additional filter statement. May be ommitted or <i>null</i>.
	 * @return a <i>TestRecipientRowSet</i> containing all test recipients fetched by the given query.
	 * @throws Inx_Api_Recipient_SelectException if the selection failed.
	 */
	public function select( Inx_Api_List_ListContext $list=null, Inx_Api_Filter_Filter $oFilter=null, $sAdditionalFilter=null );


	/**
	 * Returns an empty <i>Inx_Api_Testprofiles_TestRecipientRowSet</i>. 
	 * Use this to add new test recipients to the specified list.
	 * 
	 * @param Inx_Api_List_ListContext $list the list context for which the test recipient should be created.
	 * @return an empty <i>TestRecipientRowSet</i>.
	 */
	public function createRowSet( Inx_Api_List_ListContext $list );
	
	/**
	 * Closes this test recipient context and releases any resources associated with it. 
     * An <i>Inx_Api_Testprofiles_TestRecipientContext</i> object <strong>must</strong> be closed once it is not
 	 * needed anymore to prevent memory leaks and other potentially harmful side effects.
	 */
	public function close();

}

?>

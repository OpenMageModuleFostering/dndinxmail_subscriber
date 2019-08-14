<?php

/**
 * @package Inxmail
 * @subpackage Recipient
 */
/**
 * The <i>Inx_Api_Recipient_RecipientContext</i> is used to access and manipulate recipient data. 
 * The following operations can be performed using the <i>RecipientContext</i>:
 * <p>
 * <ul>
 * <li>Fetch recipient data as <i>Inx_Api_Recipient_RecipientRowSet</i>
 * <li>Fetch data of unsubscribed recipients as <i>Inx_Api_Recipient_UnsubscriptionRecipientRowSet</i>
 * <li>Add and remove recipients (multiple methods)
 * <li>Retrieve and manipulate recipient attributes using <i>Inx_Api_Recipient_RecipientMetaData</i> 
 * and the <i>Inx_Api_Recipient_AttributeManager</i>
 * <li>Retrieve and update recipient attribute values (multiple methods)
 * <li>Resubscribe recipients using <i>Inx_Api_Recipient_UnsubscriptionRecipientRowSet</i>
 * </ul>
 * There are a number of varieties of the methods for fetching recipient data either as 
 * <i>Inx_Api_RecipientRecipientRowSet</i> or <i>Inx_Api_Recipient_UnsubscriptionRecipientRowSet</i>. 
 * The following snippet exemplary shows how to use one specific <i>select</i> method which retrieves all 
 * recipients of the specified list whose name starts with the letter M, ordered by the given attribute:
 * 
 * <pre>
 * $oRecipientContext = $oSession->createRecipientContext();
 * $oAttribute = $oRecipientContext->getMetaData()->getUserAttribute( &quot;name&quot; );
 * $oListContext = $oSession->getListContextManager()->findByName( &quot;Desired list&quot; );
 * 
 * $sNameFilter = 'Column(&quot;name&quot;) LIKE &quot;m%&quot;';
 * $oRecipientRowSet = $oRecipientContext->select( $oListContext, null, $sNameFilter, $oAttribute, Inx_Api_Order::ASC );
 * 
 * while( $oRecipientRowSet->next() )
 * {
 * 	echo $oRecipientRowSet->getString( $oAttribute ).&quot;&#60;br&#62;&quot;;
 * }
 * 
 * $oRecipientRowSet->close();
 * </pre>
 * 
 * To fetch only recipients which unsubscribed from a specific list, use the <i>selectUnsubscriber()</i> method 
 * which returns an <i>Inx_Api_Recipient_UnsubscriptionRecipientRowSet</i>.
 * <p>
 * Adding and removing recipients can be accomplished in two ways:
 * <ol>
 * <li>Using the <i>Inx_Api_Recipient_RecipientRowSet</i>
 * <li>Using the <i>Inx_Api_Recipient_BatchChannel</i>
 * </ol>
 * The <i>Inx_Api_Recipient_BatchChannel</i> is a powerful tool which enables you to update large amounts of data with 
 * a reasonable performance by aggregating the commands. 
 * The usage of the <i>BatchChannel</i> is not covered by this documentation. 
 * For more information, see the <i>Inx_Api_Recipient_BatchChannel</i> documentation.
 * <p>
 * The following snippet shows how to add a new recipient using an empty <i>Inx_Api_Recipient_RecipientRowSet</i>:
 * 
 * <pre>
 * $oRecipientContext = $oSession->createRecipientContext();
 * $oRecipientRowSet = $oRecipientContext->createRowSet();
 * $oAttribute = $oRecipientRowSet->getMetaData()->getEmailAttribute();
 * 
 * $oRecipientRowSet->moveToInsertRow();
 * $oRecipientRowSet->updateString( $oAttribute, &quot;new@recipient.invalid&quot; );
 * $oRecipientRowSet->commitRowUpdate();
 * $oRecipientRowSet->close();
 * </pre>
 * 
 * Removing a recipient using the <i>Inx_Api_Recipient_RecipientRowSet</i> can be accomplished by selecting only 
 * one specific recipient. 
 * To do so, use a filter expression on the email attribute. The following snippet shows how to do this:
 * 
 * <pre>
 * $oRecipientContext = $oSession->createRecipientContext();
 * $oRecipientRowSet = $oRecipientContext->select( null, null, 'Column(&quot;email&quot;) = &quot;abusive@recipient.invalid&quot;' );
 * 
 * $oRecipientRowSet->next();
 * $oRecipientRowSet->deleteRow();
 * $oRecipientRowSet->close();
 * </pre>
 * 
 * Note: Both tasks are easier to perform using the <i>Inx_Api_Recipient_BatchChannel</i>.
 * <p>
 * The retrieval of recipient attributes using the <i>Inx_Api_Recipient_RecipientMetaData</i> was already shown in 
 * the fetching example. 
 * Creating new attributes is almost as easy, as shown in the following snippet which creates the previously used 
 * name attribute:
 * 
 * <pre>
 * $oAttributeManager = $oSession->getAttributeManager();
 * $oAttributeManager->create( &quot;name&quot;, Inx_Api_Recipient_Attribute::DATA_TYPE_STRING, 50 );
 * </pre>
 * 
 * For more information on the manipulation of recipient attributes, see the <i>Inx_Api_Recipient_AttributeManager</i> documentation.
 * <p>
 * A more common action than manipulating recipient attributes is to update their values. 
 * There are several ways in which this can be accomplished:
 * <p>
 * <ul>
 * <li>Using the <i>setAttributeValue($oAttribute, $oValue)</i> method to change the attribute value for all recipients
 * <li>Using the <i>Inx_Api_Recipient_RecipientRowSet::setAttributeValue($oAttribute, $oValue)</I> method to change the 
 * attribute value for a set of recipients
 * <li>Using one of the <i>update*()</i> methods in <i>Inx_Api_Recipient_RecipientRowSet</i>
 * <li>Using <i>Inx_Api_Recipient_BatchChannel::write($oAttribute, $oValue)</i> or 
 * <i>Inx_Api_Recipient_BatchChannel::writeIfNull($oAttribute, $oValue)</i>
 * </ul>
 * For the <i>BatchChannel</i> methods, see the <i>Inx_Api_Recipient_BatchChannel</i> documentation. 
 * The following snippet shows how to change the attribute value of all recipients:
 * 
 * <pre>
 * $oRecipientContext = $oSession->createRecipientContext();
 * $oAttribute = $oRecipientContext->getMetaData()->getUserAttribute( &quot;defaultFormat&quot; );
 * 
 * $value = new stdClass();
 * $value->value = &quot;html&quot;;
 * $oRecipientContext->setAttributeValue( $oAttribute, $value );
 * </pre>
 * 
 * Setting the attribute value for all recipients in a specific <i>Inx_Api_Recipient_RecipientRowSet</i> works very much the same.
 * Also, the <i>RecipientRowSet</i> can be used to change the attribute value for a selection of recipients in the set. 
 * The following snippet shows how to do this:
 * 
 * <pre>
 * $oRecipientContext = $oSession->createRecipientContext();
 * $oAttribute = $oRecipientContext->getMetaData()->getUserAttribute( &quot;top10&quot; );
 * $oRecipientRowSet = $oRecipientContext->select(); // fetches all recipients
 * 
 * $value = new stdClass();
 * $value->value = true;
 * $oRecipientRowSet->setAttributeValue( $oAttribute, $value, new Inx_Api_IndexSelection( 0, 9 ) );
 * $oRecipientRowSet->close();
 * </pre>
 * 
 * The last available option is to change the attribute value of a single recipient. 
 * The recipient creation example further above used this method to update the email address of the newly created recipient.
 * <p>
 * For an example on how to resubscribe recipients to a list, see the <i>Inx_Api_Recipient_UnsubscriptionRecipientRowSet</i>
 * documentation.
 * <p>
 * <strong>Note:</strong> Getting this context from the session will get a snapshot of the current attributes defined.
 * This snapshot will be used for the lifetime of the context, changes in the underlying attribute configuration won't
 * be reflected to it. 
 * This ensures that you can safely work with recipient data, even if other users possibly add or change attributes.
 * <p>
 * However, if a recipient attribute is deleted or the type is changed, this will also not be reflected to the <i>RecipientContext</i>. 
 * The attribute values may still be changed without any error, though this change will not be visible in Inxmail. 
 * The recipient attribute will not be undeleted. 
 * Therefore, it is not recommended to use the same recipient context during long operations as the possibility of 
 * changes in the recipient attributes will rise.
 * <p>
 * Instead of creating a new <i>Inx_Api_Recipient_RecipientContext</i> repeatedly (possibly without any need to do this), 
 * it is also possible to check whether some attributes have changed. 
 * This can be achieved using the <i>isUpToDate()</i> method. The following snippet shows hot to use this method:
 * 
 * <pre>
 * $oRecipientContext = $oSession->createRecipientContext();
 * 
 * while( !$taskDone )
 * {
 * 	if( !$oRecipientContext->isUpToDate() )
 * 	{
 * 		$oRecipientContext = $oSession->createRecipientContext();
 * 	}
 * 
 * 	// perform some operations on the recipient context
 * }
 * </pre>
 * 
 * Of course this is a very simple example, though it illustrates how to update the <i>RecipientContext</i> only if needed. 
 * A more realistic example might be a triggered operation that checks if the <i>RecipientContext</i>is still up to date 
 * (possibly some time passed after the last trigger) before executing the operation.
 * <p>
 * <strong>Note:</strong> An <i>Inx_Api_Recipient_RecipientContext</i> object <strong>must</strong> be closed once it is 
 * not needed anymore to prevent memory leaks and other potentially harmful side effects.
 * 
 * @see Inx_Api_Recipient_RecipientRowSet
 * @see Inx_Api_Recipient_UnsubscriptionRecipientRowSet
 * @see Inx_Api_Recipient_RecipientMetaData
 * @see Inx_Api_Recipient_BatchChannel
 * @see Inx_Api_Recipient_AttributeManager
 * @since API 1.0
 * @version $Revision: 9506 $ $Date: 2007-12-20 15:44:56 +0200 (Kt, 20 Grd 2007) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Recipient
 */
interface Inx_Api_Recipient_RecipientContext
{

	/** @deprecated replaced by <i>Inx_Api_Order::ASC</i> */
	const ORDER_ASC = 0;
	
	/** @deprecated replaced by <i>Inx_Api_Order::DESC</i> */
	const ORDER_DESC = 1;
	
	
	/**
	 * Retrieves an <i>Inx_Api_Recipient_RecipientMetaData</i> object that contains meta data about the recipients 
	 * represented by this <i>Inx_Api_Recipient_RecipientMetaData</i> object. 
	 * The meta data includes information about the available attributes, though can not be used to retrieve the 
	 * actual attribute values.
	 * 
	 * @return Inx_Api_Recipient_RecipientMetaData an <i>Inx_Api_Recipient_RecipientMetaData</i> object that contains meta data.
	 */
	public function getMetaData();

	
	/**
	 * Returns an empty <i>Inx_Api_Recipient_RecipientRowSet</i>. Use this to add new recipients to the system.
	 * 
	 * @return Inx_Api_Recipient_RecipientRowSet an empty <i>Inx_Api_Recipient_RecipientRowSet</i>.
	 */
	public function createRowSet();
	
	/**
	 * Returns an <i>Inx_Api_Recipient_RecipientRowSet</i> containing all recipients that are members of the given list 
	 * and match the given filter and additional filter statement, ordered by the given attribute and order type. 
	 * All of the parameters are optional and may be omitted.
	 * <p>
	 * For further information on the filter statement syntax, see the 
	 * <i>Inx_Api_Filter_Filter::updateStatement($sStmt)</i> documentation.
	 * 
	 * @param Inx_Api_List_ListContext $list all members of this list will be selected. May be omitted.
	 * @param Inx_Api_Filter_Filter $oFilter the selection filter. May be omitted.
	 * @param string $sAdditionalFilter the additional filter statement. May be omitted.
	 * @param Inx_Api_Recipient_Attribute $oOrderAttribute the attribute used to order the result. May be omitted.
	 * @param int $iOrderType the order type (<i>Inx_Api_Order::ASC</i> or <i>Inx_Api_Order::DESC</i>). May be omitted.
	 * @return Inx_Api_Recipient_RecipientRowSet a <i>RecipientRowSet</i> containing all recipients fetched by the given query.
	 * @throws Inx_Api_Recipient_SelectException if the selection failed.
	 */
	public function select(Inx_Api_List_ListContext $list=null, Inx_Api_Filter_Filter $oFilter=null, $sAdditionalFilter=null,
		Inx_Api_Recipient_Attribute $oOrderAttribute=null, $iOrderType=null);


	/**
	 * Returns an <i>Inx_Api_Recipient_RecipientRowSet</i> containing exactly one recipient: the one with the specified key. 
	 * If multiple recipients use that key, only the first one will be retrieved. 
	 * If you wish to retrieve all recipients with the given key, use <i>findAllByKey($sKey)</i> instead.
	 *
	 * @param $sKey the key of the recipient to be retrieved. Usually the email address.
	 * @return Inx_Api_Recipient_RecipientRowSet a <i>RecipientRowSet</i> containing only the first matching recipient.
	 * @since API 1.9.0
	 */
	public function findByKey( $sKey );
	
	
	/**
	 * Returns an <i>Inx_Api_Recipient_RecipientRowSet</i> containing all recipients with the specified key. 
	 * If multiple recipients use that key, all of them will be retrieved. 
	 * If you wish to retrieve only the first recipient with that key, use <i>findByKey($sKey)</i> instead.
	 *
	 * @param $sKey the key of the recipients to be retrieved. Usually the email address.
	 * @return Inx_Api_Recipient_RecipientRowSet a <i>RecipientRowSet</i> containing all recipients with the given key.
	 * @since API 1.9.0
	 */
	public function findAllByKey( $sKey );
	
	
	/**
	 * Returns an <i>Inx_Api_Recipient_RecipientRowSet</i> containing all recipients with the specified keys. 
	 * If multiple recipients use one of the keys, only the first one will be retrieved. 
	 * If you wish to retrieve all recipients with that key, use <i>findAllByKeys($aKeys)</i> instead.
	 *
	 * @param $aKeys the keys of the recipients to be retrieved. Usually the email address.
	 * @return Inx_Api_Recipient_RecipientRowSet a <i>RecipientRowSet</i> containing all recipients with the given keys.
	 * @since API 1.9.0
	 */
	public function findByKeys( $aKeys );
	
	
	/**
	 * Returns an <i>Inx_Api_Recipient_RecipientRowSet</i> containing all recipients with the specified keys. 
	 * If multiple recipients use one of the keys, all of them will be retrieved. 
	 * If you wish to retrieve only the first recipient with that key, use <i>findByKeys($aKeys)</i> instead.
	 *
	 * @param $aKeys the keys of the recipients to be retrieved. Usually the email address.
	 * @return Inx_Api_Recipient_RecipientRowSet a <i>RecipientRowSet</i> containing all recipients with the given keys.
	 * @since API 1.9.0
	 */
	public function findAllByKeys( $aKeys );
		
		
	/**
	 * Returns an <i>Inx_Api_Recipient_UnsubscriptionRecipientRowSet</i> containing all recipients that have been 
	 * unsubscribed from the given list and match the given filter and additional filter statement, ordered by the 
	 * given attribute and order type.
	 * All parameters except for the list are optional and may be omitted.
	 * <p>
	 * For further information on the filter statement syntax, see the 
	 * <i>Inx_Api_Filter_Filter::updateStatement($sStmt)</i> documentation.
	 * 
	 * @param Inx_Api_List_ListContext $list all recipients that have been unsubscribed from this list will be selected.
	 * @param Inx_Api_Filter_Filter $oFilter the selection filter. May be omitted.
	 * @param string $sAdditionalFilter the additional filter statement. May be omitted.
	 * @param Inx_Api_Recipient_Attribute $oOrderAttribute the attribute used to order the result. May be omitted.
	 * @param int $iOrderType the order type (<i>Inx_Api_Order::ASC</i> or <i>Inx_Api_Order::DESC</i>). May be omitted.
	 * @return Inx_Api_Recipient_UnsubscriptionRecipientRowSet an <i>Inx_Api_Recipient_UnsubscriptionRecipientRowSet</i> 
	 * containing all recipients fetched by the given query.
	 * @throws Inx_Api_Recipient_SelectException if the selection failed.
	 * @since API 1.6.0
	 */
	public function selectUnsubscriber( Inx_Api_List_ListContext $list, Inx_Api_Filter_Filter $oFilter=null, $sAdditionalFilter=null,
		Inx_Api_Recipient_Attribute $oOrderAttribute=null, $iOrderType=null );
		
		

    /**
     * Sets the specified attribute value to all recipients in the system.
	 * Note: $newValue must be of type stdClass. To set the actual value, use the value variable.
	 * The following snippet demonstrates this:
	 * <pre>
	 * $value = new stdClass();
	 * $value->value = "the new value of any type";
	 * 
	 * $oRecipientContext->setAttributeValue($oAttribute, $value);
	 * </pre>
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the designated attribute.
	 * @param stdClass $newValue the new attribute value.
	 * @return bool <i>true</i>, if the attribute was updated on all recipients, <i>false</i> otherwise.
     */
    public function setAttributeValue( Inx_Api_Recipient_Attribute $attr, stdClass $newValue );


	
	/**
	 * Creates an <i>Inx_Api_Recipient_BatchChannel</i> for fast recipient data manipulation with an optional 
	 * alternative 'key attribute' to select the recipient.
	 *  
	 * The type of the select attribute must be <i>Inx_Api_Recipient_Attribute::DATA_TYPE_STRING</i> or
	 * <i>Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER</i>.
	 *  
	 * If the specified select value exists for multiple recipients, any of these recipients may be selected (undetermined).
	 * 
	 * @return Inx_Api_Recipient_BatchChannel an <i>Inx_Api_Recipient_BatchChannel</i>.
	 */
	public function createBatchChannel( Inx_Api_Recipient_Attribute $oSelectAttribute = null );

	
	/**
	 * Checks whether or not this <i>Inx_Api_Recipient_RecipientContext</i> is up to date. 
	 * If attributes were added, removed or manipulated (renamed, different type) since this 
	 * <i>RecipientContext</i> was created, <i>false</i> will be returned. 
	 * This information may be used to check whether the <i>RecipientContext</i> needs to be
	 * updated before executing the next operation.
	 * 
	 * @return bool <i>true</i> if this <i>RecipientContext</i> is up to date, <i>false</i> otherwise.
	 */
	public function isUpToDate();
	
	
	/**
	 * Determines if the key is unique. If you have not explicitly allowed the recipient key to have duplicate values,
	 * you need not worry about this method.
	 * 
	 * @return bool <i>true</i> if the key is unique, <i>false</i> otherwise.
	 */
	public function isKeyUnique();

	
    /**
     * Closes this recipient context and releases any resources associated with it. 
     * An <i>Inx_Api_Recipient_RecipientContext</i> object <strong>must</strong> be closed once it is 
 	 * not needed anymore to prevent memory leaks and other potentially harmful side effects.
     */
	public function close();
	
}

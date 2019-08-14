<?php

/**
 * @package Inxmail
 * @subpackage Testprofiles
 */
/**
 * An <i>Inx_Api_Testprofiles_TestRecipientRowSet</i> is best explained as a table of data representing a set of test 
 * recipients, which is usually generated by executing a selection that queries the test recipient context.
 * <p>
 * Test recipients (or test profiles) can be used to create a personalized preview of a mailing. 
 * A test recipient object holds the following information:
 * <p>
 * <ul>
 * <li><i>The unique identifier (immutable)</i>: Uniquely identifies a test recipient.
 * <li><i>The name / profile description</i>: Describes the test recipient. While this attribute is not required to be
 * unique, still it is mandatory.
 * <li><i>The email address</i>: Mandatory attribute which can be set using <i>updateString($oAttribute, $sValue)</i>.
 * <li><i>Some other recipient attribute values</i>: Probably a test recipients contains other recipient attribute
 * values which can be used to personalize a mailing.
 * </ul>
 * <P>
 * A <i>TestRecipientRowSet</i> object maintains a cursor pointing to its current row of data. 
 * Initially the cursor is positioned before the first row. 
 * The <i>next()</i> method moves the cursor to the next row (test recipient), and because it returns <i>false</i> 
 * when there are no more rows in the <i>TestRecipientRowSet</i> object, it can be used in a <i>while</i> loop to 
 * iterate through the result set.
 * <p>
 * Be sure to call <i>next()</i> before the first retrieval statement on the row set. 
 * As stated above, initially the cursor is before the first row, thus no data can be retrieved from the row set before 
 * calling <i>next()</i>. 
 * Doing so will trigger an <i>Inx_Api_DataException</i>.
 * <P>
 * The <i>TestRecipientRowSet</i> interface provides <i>getter</i> methods (<i>getString</i>, <i>getInteger</i>, and so on) 
 * for retrieving attribute values from the current row. 
 * Values can be retrieved using the attribute object.
 * <p>
 * The following snippet shows how to retrieve the email address of all test recipients in the row set, thus also
 * illustrating how to iterate over a <i>TestRecipientRowSet</i>:
 * 
 * <pre>
 * $oTestRecipientContext = $oSession->createTestRecipientContext();
 * $oAttribute_email = $oSession->createRecipientContext()->getMetaData()->getEmailAttribute();
 * $oListContext = $oSession->getListContextManager()->findByName( &quot;Desired List&quot; );
 * $oTestRecipientRowSet = $oTestRecipientContext->select( $oListContext );
 * 
 * while( $oTestRecipientRowSet->next() )
 * {
 * 	echo $oTestRecipientRowSet->getString( $oAttribute_email ).&quot;&#60;br&#62;&quot;;
 * }
 * 
 * $oTestRecipientRowSet->close();
 * </pre>
 * <P>
 * The update methods may be used in two ways:
 * <ol>
 * <LI>To update a column value in the current row. 
 * In a <i>TestRecipientRowSet</i> object, the cursor can be moved backwards and forwards, to an absolute position. 
 * The following snippet shows how to update the <i>Lastname</i> attribute in the fifth row of the 
 * <i>TestRecipientRowSet</i> object <i>trrs</i> and then uses the method <i>commitRowUpdate</i> to 
 * commit the changed data from which <i>trrs</i> was derived:
 * 
 * <PRE>
 * $oAttribute = $oRecipientMetaData->getUserAttribute( &quot;Lastname&quot; );
 * $oTestRecipientRowSet->setRow( 4 ); // moves the cursor to the fifth row of trrs
 * // updates the 'Lastname' attribute of row 4 (fifth row) to be 'Smith'
 * $oTestRecipientRowSet->updateString( $oAttribute, &quot;Smith&quot; );
 * $oTestRecipientRowSet->commitRowUpdate(); // updates the row in the data source
 * </PRE>
 * <LI>To insert attribute values into the insert row. 
 * The <i>TestRecipientRowSet</i> object has a special row associated with it that serves as a staging area for 
 * building a test recipient to be inserted. 
 * The following snippet shows how to move the cursor to the insert row and insert the new test recipient 
 * data into <i>trrs</i> and into the data source table using the method <i>commitRowUpdate</i>:
 * 
 * <PRE>
 * $oAttribute_email = $oRecipientMetaData->getEmailAttribute();
 * $oAttribute_attr = $oRecipientMetaData->getUserAttribute( &quot;Lastname&quot; );
 * $oTestRecipientRowSet->moveToInsertRow(); // moves cursor to the insert row
 * // email attribute of the insert row to be smith@gmx.com - mandatory
 * $oTestRecipientRowSet->updateString( $oAttribute_email, &quot;smith@gmx.com&quot; );
 * // update profile description - mandatory
 * $oTestRecipientRowSet->updateName( &quot;Smith&quot; );
 * $oTestRecipientRowSet->updateString( $oAttribute_attr, &quot;Smith&quot; );
 * $oTestRecipientRowSet->commitRowUpdate(); // insert the row in the data source
 * </PRE>
 * 
 * The code above will create a new recipient with the address smith@gmx.com, the name / 
 * profile description Smith and the last name Smith. 
 * Usually creating new recipients is accomplished using an empty <i>TestRecipientRowSet</i>.
 * Such a row set can be obtained using the <i>Inx_Api_Testprofile_TestRecipientContext::createRowSet($oListContext)</i> method. 
 * However, the returned row set can only be used to create recipients, as there are no recipients in the row set.
 * </ol>
 * <p>
 * All row changes except for the <i>remove()</i> method require a call of <i>commitRowUpdate()</i> to be reflected on the server. 
 * Any uncommitted changes will be lost once the <i>TestRecipientRowSet</i> is closed.
 * However, calling <i>commitRowUpdate()</i> on deleted rows will trigger an <i>Inx_Api_DataException</i>, as the recipient 
 * in the current row no longer exists.
 * <p>
 * Note: To safely abandon all changes of the current row, use the <i>rollbackRowUpdate()</i> method. 
 * This will prevent any changes to the current row from being committed through <i>commitRowUpdate()</i>. 
 * Be aware that <i>rollbackRowUpdate</i> will only undo <i>uncommitted</i> changes to the current row. 
 * So, once you called <i>commitRowUpdate()</i> there is "no way back".
 * <p>
 * <strong>Note:</strong> An <i>Inx_Api_Testprofiles_TestRecipientRowSet</i> object <strong>must</strong> be closed once it is not
 * needed anymore to prevent memory leaks and other potentially harmful side effects.
 * <p>
 * For more information about the retrieval of test recipients, see the <i>Inx_Api_Testprofile_TestRecipientContext</i> documentation.
 * 
 * @see Inx_Api_Testprofiles_TestRecipientContext 
 * @since API 1.6.0
 * @version $Revision: 2934 $ $Date: 2005-07-04 17:00:09 +0200 (Mo, 04 Jul 2005) $ $Author: bgn $
 */
interface Inx_Api_Testprofiles_TestRecipientRowSet
{

	/**
	 * Moves the cursor to the front of this <i>TestRecipientRowSet</i> object, just before the first row. 
	 * This method has no effect if the result set contains no rows.
	 */
	public function beforeFirstRow();


	/**
	 * Moves the cursor to the end of this <i>TestRecipientRowSet</i> object, just after the last row. 
	 * This method has no effect if the result set contains no rows.
	 */
	public function afterLastRow();


	/**
	 * Moves the cursor to the given row number in this <i>TestRecipientRowSet</i> object. 
	 * The first row is row 0, the second is row 1, and so on.
	 * 
	 * @param int $row the number of the row to which the cursor should move.
	 */
	public function setRow( $row );


	/**
	 * Retrieves the current row number. 
	 * The first row is number 0, the second number 1, and so on.
	 * 
	 * @return int the current row number.
	 */
	public function getRow();


	/**
	 * Moves the cursor down one row from its current position. 
	 * A <i>TestRecipientRowSet</i> cursor is initially positioned before the first row; 
	 * the first call to the method <i>next</i> makes the first row the current row; 
	 * the second call makes the second row the current row, and so on.
	 * 
	 * @return bool <i>true</i> if the new current row is valid, <i>false</i> if there are no more rows.
	 */
	public function next();


	/**
	 * Moves the cursor to the previous row in this <i>TestRecipientRowSet</i> object.
	 * 
	 * @return bool <i>true</i> if the cursor is on a valid row, <i>false</i> if it is off the row set.
	 */
	public function previous();


	/**
	 * Returns the number of rows in this <i>TestRecipientRowSet</i> object.
	 * 
	 * @return int the number of rows.
	 */
	public function getRowCount();


	/**
	 * Updates the underlying recipient on the server with the new contents of the current row of this
	 * <i>TestRecipientRowSet</i> object.
	 * 
	 * @throws Inx_Api_Recipient_IllegalValueException if one of the attribute values is invalid or missing.
	 * @throws Inx_Api_Recipient_DuplicateKeyException if the key value is already used.
	 * @throws Inx_Api_DataException if the recipient was deleted or no test recipient is selected (e.g. you forgot 
	 * 				to call <i>next()</i>).
	 */
	public function commitRowUpdate() ;


	/**
	 * Reverts the updates made to the current row in this <i>TestRecipientRowSet</i> object. 
	 * This method may be called after calling one or several update methods to roll back the updates made to a row. 
	 * If no updates have been made or <i>commitRowUpdate</i> has already been called, this method has no effect.
	 */
	public function rollbackRowUpdate();


	/**
	 * Deletes the current row from this <i>TestRecipientRowSet</i> object. 
	 * This method cannot be called when the cursor is on the insert row. 
	 * Do <strong>not</strong> call <i>commitRowUpdate()</i> after invoking this method, as this would trigger an 
	 * <i>Inx_Api_DataException</i>.
	 */
	public function deleteRow();


	/**
	 * Deletes the specified rows from this <i>TestRecipientRowSet</i> object. 
	 * Do <strong>not</strong> call <i>commitRowUpdate()</i> on an affected row after invoking this method, as this 
	 * would trigger an <i>Inx_Api_DataException</i>.
	 * 
	 * @param Inx_Api_IndexSelection $selection the rows to be deleted.
	 */
	public function deleteRows( Inx_Api_IndexSelection $selection );


	/**
	 * Moves the cursor to the insert row. 
	 * The current cursor position is remembered while the cursor is positioned on the insert row. 
	 * The insert row is a special row associated with a <i>TestRecipientRowSet</i>. 
	 * It is essentially a buffer where a new row may be constructed by calling the update methods prior to inserting 
	 * the row into the row set. 
	 * Only the update, getter, and <i>commitRowUpdate</i> method may be called when the cursor is on the insert row.
	 */
	public function moveToInsertRow();


	/**
	 * Reports whether the underlying test recipient is deleted or not.
	 * 
	 * @return bool <i>true</i> if the underlying test recipient is deleted, <i>false</i> otherwise.
	 */
	public function isRowDeleted();


	/**
	 * Retrieves the test recipient id of the current row of this <i>TestRecipientRowSet</i> object.
	 * 
	 * @return int the id of the current test recipient.
	 * @throws Inx_Api_DataException if the test recipient was deleted or no test recipient is selected (e.g. you 
	 * 				forgot to call <i>next()</i>).
	 */
	public function getId();


	/**
	 * Retrieves the name/profile description of the test recipient in the current row of this
	 * <i>TestRecipientRowSet</i> object.
	 * 
	 * @return string the name of the test recipient.
	 * @throws Inx_Api_DataException if the test recipient was deleted or no test recipient is selected (e.g. you 
	 * 				forgot to call <i>next()</i>).
	 */
	public function getName();


	/**
	 * Updates the name/profile description of the test recipient in the current row of this
	 * <i>TestRecipientRowSet</i> object.
	 * 
	 * @param string $sName the name of the test recipient profile.
	 * @throws Inx_Api_DataException if the test recipient was deleted or no test recipient is selected (e.g. you 
	 * 				forgot to call <i>next()</i>).
	 */
	public function updateName( $sName );


	/**
	 * Retrieves the value of the designated attribute in the current row of this <i>TestRecipientRowSet</i>
	 * object as a <i>string</i>.
	 * 
	 * @param Inx_Api_Recipient_Attribute $oAttr the designated attribute.
	 * @return string the attribute value as string.
	 * @throws Inx_Api_DataException if the test recipient was deleted or no test recipient is selected (e.g. you 
	 * 				forgot to call <i>next()</i>).
	 * @throws Inx_Api_IllegalStateException if the attribute is not of type <i>string</i>.
	 */
	public function getString( Inx_Api_Recipient_Attribute $oAttr );


	/**
	 * Retrieves the value of the designated attribute in the current row of this <i>TestRecipientRowSet</i>
	 * object as a <i>bool</i>.
	 * 
	 * @param Inx_Api_Recipient_Attribute $oAttr the designated attribute.
	 * @return bool the attribute value as bool.
	 * @throws Inx_Api_DataException if the test recipient was deleted or no test recipient is selected (e.g. you 
	 * 				forgot to call <i>next()</i>).
	 * @throws Inx_Api_IllegalStateException if the attribute is not of type <i>bool</i>.
	 */
	public function getBoolean( Inx_Api_Recipient_Attribute $oAttr );


	/**
	 * Retrieves the value of the designated attribute in the current row of this <i>TestRecipientRowSet</i>
	 * object as an <i>integer</i>.
	 * 
	 * @param Inx_Api_Recipient_Attribute $oAttr the designated attribute.
	 * @return int the attribute value as integer.
	 * @throws Inx_Api_DataException if the test recipient was deleted or no test recipient is selected (e.g. you 
	 * 				forgot to call <i>next()</i>).
	 * @throws Inx_Api_IllegalStateException if the attribute is not of type <i>integer</i>.
	 */
	public function getInteger( Inx_Api_Recipient_Attribute $oAttr );


	/**
	 * Retrieves the value of the designated attribute in the current row of this <i>TestRecipientRowSet</i>
	 * object as a <i>float</i>.
	 * 
	 * @param Inx_Api_Recipient_Attribute $oAttr the designated attribute.
	 * @return float the attribute value as float.
	 * @throws Inx_Api_DataException if the test recipient was deleted or no test recipient is selected (e.g. you 
	 * 				forgot to call <i>next()</i>).
	 * @throws Inx_Api_IllegalStateException if the attribute is not of type <i>float</i>.
	 */
	public function getDouble( Inx_Api_Recipient_Attribute $oAttr );


	/**
	 * Retrieves the value of the designated attribute in the current row of this <i>TestRecipientRowSet</i>
	 * object as a <i>date</i>.
	 * 
	 * @param Inx_Api_Recipient_Attribute $oAttr the designated attribute.
	 * @return string the date value as ISO 8601 formatted date string. 
	 * @throws Inx_Api_DataException if the test recipient was deleted or no test recipient is selected (e.g. you 
	 * 				forgot to call <i>next()</i>).
	 * @throws Inx_Api_IllegalStateException if the attribute is not of type <i>date</i>.
	 */
	public function getDate( Inx_Api_Recipient_Attribute $oAttr );


	/**
	 * Retrieves the value of the designated attribute in the current row of this <i>TestRecipientRowSet</i>
	 * object as a <i>time</i>.
	 * 
	 * @param Inx_Api_Recipient_Attribute $oAttr the designated attribute.
	 * @return string the time value as ISO 8601 formatted time string. 
	 * @throws Inx_Api_DataException if the test recipient was deleted or no test recipient is selected (e.g. you 
	 * 				forgot to call <i>next()</i>).
	 * @throws Inx_Api_IllegalStateException if the attribute is not of type <i>time</i>.
	 */
	public function getTime( Inx_Api_Recipient_Attribute $oAttr );


	/**
	 * Retrieves the value of the designated attribute in the current row of this <i>TestRecipientRowSet</i>
	 * object as a <i>datetime</i>.
	 * 
	 * @param Inx_Api_Recipient_Attribute $oAttr the designated attribute.
	 * @return string the datetime value as ISO 8601 formatted datetime string. 
	 * @throws Inx_Api_DataException if the test recipient was deleted or no test recipient is selected (e.g. you 
	 * 				forgot to call <i>next()</i>).
	 * @throws Inx_Api_IllegalStateException if the attribute is not of type <i>datetime</i>.
	 */
	public function getDatetime( Inx_Api_Recipient_Attribute $oAttr );


	/**
	 * Retrieves the value of the designated attribute in the current row of this <i>TestRecipientRowSet</i>
	 * object.
	 * 
	 * @param Inx_Api_Recipient_Attribute $oAttr the designated attribute.
	 * @return mixed the attribute value.
	 * @throws Inx_Api_DataException if the test recipient was deleted or no test recipient is selected (e.g. you 
	 * 				forgot to call <i>next()</i>).
	 */
	public function getObject( Inx_Api_Recipient_Attribute $attr ) ;


	/**
	 * Updates the designated attribute with a <i>string</i> value. 
	 * The update methods are used to update attribute values in the current row or the insert row. 
	 * The update methods do not update the underlying recipient on the server; 
	 * instead the <i>commitRowUpdate</i> method is called to commit the changes.
	 * 
	 * @param Inx_Api_Reciptient_Attribute $oAttr the designated attribute.
	 * @param string $sValue the new attribute value.
	 * @throws Inx_Api_DataException if the test recipient was deleted or no test recipient is selected (e.g. you 
	 * 				forgot to call <i>next()</i>).
	 * @throws Inx_Api_IllegalStateException if the attribute is not of type <i>string</i>.
	 */
	public function updateString( Inx_Api_Recipient_Attribute $oAttr, $sValue );


	/**
	 * Updates the designated attribute with a <i>bool</i> value. 
	 * The update methods are used to update attribute values in the current row or the insert row. 
	 * The update methods do not update the underlying recipient on the server; 
	 * instead the <i>commitRowUpdate</i> method is called to commit the changes.
	 * 
	 * @param Inx_Api_Reciptient_Attribute $oAttr the designated attribute.
	 * @param bool $blValue the new attribute value.
	 * @throws Inx_Api_DataException if the test recipient was deleted or no test recipient is selected (e.g. you 
	 * 				forgot to call <i>next()</i>).
	 * @throws Inx_Api_IllegalStateException if the attribute is not of type <i>bool</i>.
	 */
	public function updateBoolean( Inx_Api_Recipient_Attribute $oAttr, $blValue ) ;


	/**
	 * Updates the designated attribute with an <i>integer</i> value. 
	 * The update methods are used to update attribute values in the current row or the insert row. 
	 * The update methods do not update the underlying recipient on the server; 
	 * instead the <i>commitRowUpdate</i> method is called to commit the changes.
	 * 
	 * @param Inx_Api_Reciptient_Attribute $oAttr the designated attribute.
	 * @param int $iValue the new attribute value.
	 * @throws Inx_Api_DataException if the test recipient was deleted or no test recipient is selected (e.g. you 
	 * 				forgot to call <i>next()</i>).
	 * @throws Inx_Api_IllegalStateException if the attribute is not of type <i>integer</i>.
	 */
	public function updateInteger( Inx_Api_Recipient_Attribute $oAttr, $iValue );


	/**
	 * Updates the designated attribute with a <i>float</i> value. 
	 * The update methods are used to update attribute values in the current row or the insert row. 
	 * The update methods do not update the underlying recipient on the server; 
	 * instead the <i>commitRowUpdate</i> method is called to commit the changes.
	 * 
	 * @param Inx_Api_Reciptient_Attribute $oAttr the designated attribute.
	 * @param float $iValue the new attribute value.
	 * @throws Inx_Api_DataException if the test recipient was deleted or no test recipient is selected (e.g. you 
	 * 				forgot to call <i>next()</i>).
	 * @throws Inx_Api_IllegalStateException if the attribute is not of type <i>float</i>.
	 */
	public function updateDouble( Inx_Api_Recipient_Attribute $oAttr, $iValue );


	/**
	 * Updates the designated attribute with a <i>float</i> value.
	 * The value has to be passed either as a <i>Unix-Timestamp</i> or an ISO 8601 formatted date string.
     * To format the value correctly, use one of the following methods:
     * <ul>
     * <li><i>ISO-8601</i>: <pre>$sDate = date("Y-m-d");</pre>
     * <li><i>Unix-Timestamp</i>: <pre>$iTimestamp = time();</pre>
     * </ul>   
	 * The update methods are used to update attribute values in the current row or the insert row. 
	 * The update methods do not update the underlying recipient on the server; 
	 * instead the <i>commitRowUpdate</i> method is called to commit the changes.
	 * 
	 * @param Inx_Api_Reciptient_Attribute $oAttr the designated attribute.
	 * @param string $dValue the new attribute value.
	 * @throws Inx_Api_DataException if the test recipient was deleted or no test recipient is selected (e.g. you 
	 * 				forgot to call <i>next()</i>).
	 * @throws Inx_Api_IllegalStateException if the attribute is not of type <i>date</i>.
	 */
	public function updateDate( Inx_Api_Recipient_Attribute $oAttr, $dValue );


	/**
	 * Updates the designated attribute with a <i>time</i> value.
	 * The value has to be passed either as a <i>Unix-Timestamp</i> or an ISO 8601 formatted time string.
     * To format the value correctly, use one of the following methods:
     * <ul>
     * <li><i>ISO-8601</i>: <pre>$sTime = date("H:i:sP");</pre>
     * <li><i>Unix-Timestamp</i>: <pre>$iTimestamp = time();</pre>
     * </ul>  
	 * The update methods are used to update attribute values in the current row or the insert row. 
	 * The update methods do not update the underlying recipient on the server; 
	 * instead the <i>commitRowUpdate</i> method is called to commit the changes.
	 * 
	 * @param Inx_Api_Reciptient_Attribute $oAttr the designated attribute.
	 * @param string $tValue the new attribute value.
	 * @throws Inx_Api_DataException if the test recipient was deleted or no test recipient is selected (e.g. you 
	 * 				forgot to call <i>next()</i>).
	 * @throws Inx_Api_IllegalStateException if the attribute is not of type <i>time</i>.
	 */
	public function updateTime( Inx_Api_Recipient_Attribute $oAttr, $tValue );


	/**
	 * Updates the designated attribute with a <i>datetime</i> value.
	 * The value has to be passed either as a <i>Unix-Timestamp</i> or an ISO 8601 formatted datetime string.
     * To format the value correctly, use one of the following methods:
     * <ul>
     * <li><i>ISO-8601</i>: <pre>$sDatetime = date('c');</pre>
     * <li><i>Unix-Timestamp</i>: <pre>$iTimestamp = time();</pre>
     * </ul>  
	 * The update methods are used to update attribute values in the current row or the insert row. 
	 * The update methods do not update the underlying recipient on the server; 
	 * instead the <i>commitRowUpdate</i> method is called to commit the changes.
	 * 
	 * @param Inx_Api_Reciptient_Attribute $oAttr the designated attribute.
	 * @param string $dtValue the new attribute value.
	 * @throws Inx_Api_DataException if the test recipient was deleted or no test recipient is selected (e.g. you 
	 * 				forgot to call <i>next()</i>).
	 * @throws Inx_Api_IllegalStateException if the attribute is not of type <i>datetime</i>.
	 */
	public function updateDatetime( Inx_Api_Recipient_Attribute $oAttr, $dtValue );


	/**
	 * Updates the designated attribute with a new value.
	 * Most string values can be converted regardless of their content. 
     * The string "test" can, for example, be converted to a boolean and will return true.
     * However, this is not true for attributes of type date, time or datetime.
     * These values have to be passed either as a <i>Unix-Timestamp</i> or an ISO 8601 formatted date, time or datetime string.
     * To format the value correctly, use one of the following methods, according to the datatype of the attribute:
     * <ul>
     * <li><i>Date</i>: <pre>$sDate = date("Y-m-d");</pre>
     * <li><i>Time</i>: <pre>$sTime = date("H:i:sP");</pre>
     * <li><i>Datetime</i>: <pre>$sDatetime = date('c');</pre>
     * <li><i>Unix-Timestamp (works for all)</i>: <pre>$iTimestamp = time();</pre>
     * </ul>   
	 * The update methods are used to update attribute values in the current row or the insert row. 
	 * The update methods do not update the underlying recipient on the server; 
	 * instead the <i>commitRowUpdate</i> method is called to commit the changes.
	 * 
	 * @param Inx_Api_Reciptient_Attribute $oAttr the designated attribute.
	 * @param string|mixed $oValue the new attribute value.
	 * @throws Inx_Api_DataException if the test recipient was deleted or no test recipient is selected (e.g. you 
	 * 				forgot to call <i>next()</i>).
	 */
	public function updateObject( Inx_Api_Recipient_Attribute $oAttr, $oValue );


	/**
	 * Releases the resources associated with this <i>Inx_Api_Testprofiles_TestRecipientRowSet</i> object on the server immediately.
     * <p>
     * An <i>Inx_Api_Testprofiles_TestRecipientRowSet</i> object <strong>must</strong> be closed once it is not
 	 * needed anymore to prevent memory leaks and other potentially harmful side effects.
	 */
	public function close();
}
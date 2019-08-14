<?php
/**
 * @package Inxmail
 * @subpackage Filter
 */
/**
 * An <i>Inx_Api_Filter_Filter</i> is used to define target groups of recipients that share common properties. 
 * For example: All recipients born after 1970. To accomplish this, a <code>Filter</code> uses a statement. 
 * The statement syntax is described in the documentation for {@link #updateStatement(String)}.
 * <p>
 * For an example on how to create filters, see the <i>Inx_Api_Filter_FilterManager</i> documentation.
 * 
 * @see Inx_Api_Filter_FilterManager
 * @since API 1.1.0
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Filter
 */
interface Inx_Api_Filter_Filter extends Inx_Api_BusinessObject
{
    /**
	 * Constant for the name attribute. Used as order attribute in <i>select</i> statements.
	 * 
	 * @see Inx_Api_Filter_FilterManager::select($oListContext, $iOrderAttribute, $iOrderType)
	 */
    const ATTRIBUTE_NAME = 0;
    
    /**
	 * Constant for the statement attribute.
	 */
    const ATTRIBUTE_STATEMENT = 1;

    /**
	 * Constant for the creation datetime attribute. Used as order attribute in <i>select</i> statements.
	 * 
	 * @see Inx_Api_Filter_FilterManager::select($oListContext, $iOrderAttribute, $iOrderType)
	 */
    const ATTRIBUTE_CREATION_DATETIME = 2;

    /**
	 * Constant for the list context attribute.
	 */
    const ATTRIBUTE_LIST_CONTEXT_ID = 3;

	
    /**
     * Returns the unique name of this filter.
     * 
     * @return string the unique name of this filter.
     */
    public function getName();
    
    
	/**
	 * Sets the unique name of this filter.
	 * 
	 * @param string $sName the unique name of this filter.
	 */
	public function updateName( $sName );

    
    /**
     * Returns the statment of this filter. The statement defines the target group of recipients.
     * 
     * @return string the statment of this filter.
     */
    public function getStatement();

 
	/**
	 * Sets the filter statement. The statement defines the target group of recipients.
	 * <p>
	 * A filter statement consists of at least one condition that recipients must match. Multiple conditions may be
	 * composed to a filter using the AND/OR operators. There are four possible condition types which may be used:
	 * <ul>
	 * <li><i>Column condition</i>: Compares the value of a column.
	 * <li><i>Recipient reaction condition</i>: Checks if a recipient opened a mailing or clicked a link.
	 * <li><i>Filter membership condition</i>: Checks if a recipient is member of a filter.
	 * <li><i>Free expression</i>: Special checks and comparisons.
	 * </ul>
	 * <p>
	 * The following operators may be used to compare columns to a given value or check their content:
	 * <ul>
	 * <li>column = value - checks for equality
	 * <li>column <> value - checks for inequality
	 * <li>column < value - checks if column value is less than given value
	 * <li>column <= value - checks if column value is less than or equal to given value
	 * <li>column > value - checks if column value is greater than given value
	 * <li>column >= value - checks if column value is greater than or equal to given value
	 * <li>column IS_EMPTY - checks if column value is empty
	 * <li>column NOT_IS_EMPTY - checks if column value is not empty
	 * </ul>
	 * The check values have to be specified in the same data type as the column value. The different date types must be
	 * specified as follows:
	 * <ul>
	 * <li><i>Text</i>: "Text" (be sure to escape the double quotes or use single quotes for the filter)
	 * <li><i>Datetime</i>: #01.01.1970 13:37:42# (be sure to put a single whitespace between date and time)
	 * <li><i>Date</i>: #01.01.1970#
	 * <li><i>Time</i>: #13:37:42#
	 * <li><i>Integer</i>: 42
	 * <li><i>Floating point</i>: 47.11
	 * <li><i>Boolean</i>: TRUE or FALSE (attention: case sensitive!)
	 * </ul>
	 * To specify the column which shall be compared it is best to use the Column("columnName") operator.
	 * <p>
	 * Using free expressions you can create more powerful statements. The operators which can be used in free
	 * expressions are:
	 * <ul>
	 * <li>column LIKE value: checks for equality (case insensitive)
	 * <li>column NOT_LIKE value: checks for inequality (case insensitive)
	 * <li>column STARTS_WITH value: checks if column value starts with given value
	 * <li>column NOT_STARTS_WITH value: checks if column value does not start with given value
	 * <li>column ENDS_WITH value: checks if column value ends with given value
	 * <li>column NOT_ENDS_WITH value: checks if column value does not end with given value
	 * <li>column CONTAINS value: checks if column value contains given value
	 * <li>column NOT_CONTAINS value: checks if column value does not contain given value
	 * </ul>
	 * All of these operators may be used along with text columns. The check values of free expressions may contain
	 * wildcards to match a specific pattern.<br>
	 * <strong>Note:</strong> The wilcard character used in free expressions is NOT the asterisk (*) but the percentage
	 * sign (%).
	 * <p>
	 * Recipient reaction conditions may be used to select recipients who reacted on a specific mailing or link. The
	 * operators used for recipient reaction conditions are:
	 * <ul>
	 * <li><i>HasOpened(mailingId)</i>: checks if the recipient opened the specified mailing
	 * <li><i>HasClickedAnyLink(mailingId)</i>: checks if the recipient clicked any link in the specified mailing
	 * <li><i>HasClicked(linkId)</i>: checks if the recipient clicked the specified link
	 * </ul>
	 * <p>
	 * Filter membership conditions may be used to select recipients who are (or aren't) member of another filter. The
	 * operators used for these checks are:
	 * <ul>
	 * <li><i>BelongsToGroup(filterName)</i>: checks if the recipient is a member of the specified filter.
	 * <li><i>BelongsNotToGroup(filterName)</i>: checks if the recipient is not a member of the specified filter.
	 * </ul>
	 * <p>
	 * Please note that date values for the filter have to be specified in german 24-hour date format. To accomplish this, 
	 * the date() function with the following date pattern can be used:
	 * <pre>
	 * $filterDate = date("d.m.Y H:i:s");
	 * </pre>
	 * 
	 * @param string $sStmt the filter statment.
	 */
	public function updateStatement( $sStmt );

	
	/**
	 * Returns the id of the list which this filter belongs to.
	 * 
	 * @return int the id of the list  which this filter belongs to.
	 */
	public function getListContextId();

	
    /**
     * Returns the creation datetime of this filter.
     * 
     * @return string the creation datetime of this filter. The creation datetime will be returned as ISO 8601 
     * formatted datetime string.
     */
    public function getCreationDatetime();

}

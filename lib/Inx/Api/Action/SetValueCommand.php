<?php
/**
 * @package Inxmail
 * @subpackage Action
 */
/**
 * Use the <i>Inx_Api_Action_SetValueCommand</i> to set an attribute value. There are three ways to set the attribute value:
 * <ul>
 * <li>CMD_TYPE_ABSOLUTE: Absolute value (e.g. 5 or 1)
 * <li>CMD_TYPE_RELATIVE: Relative value (e.g. 2 to increment the value by 2)
 * <li>CMD_TYPE_FREE_EXPRESSION: Free expression (e.g. "=Date()" to set a date attribute to the current date)
 * </ul>
 * Note: The data type of a value must be the same as the data type of the specified attribute. Relative values can only
 * be set for the following data types:
 * <ul>
 * <li>DataType.Integer
 * <li>DataType.Double
 * <li>DataType.Text
 * </ul>
 * 
 * @see Inx_Api_Action_CommandFactory
 * @see Inx_Api_Recipient_Attribute
 * @since API 1.2.0
 * @version $Revision: 9482 $ $Date: 2007-12-18 16:42:11 +0200 (An, 18 Grd 2007) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Action
 */
interface Inx_Api_Action_SetValueCommand extends Inx_Api_Action_Command
{
	/**
	 * Command type: Sets an absolute value.
	 */
	const CMD_TYPE_ABSOLUTE = 0;

	/**
	 * Command type: Sets a relative value.
	 */
	const CMD_TYPE_RELATIVE = 1;

	/**
	 * Command type: Sets a value from a free expression.
	 */
	const CMD_TYPE_FREE_EXPRESSION = 2;


	/**
	 * Returns the id of the affected user attribute.
	 * 
	 * @return int the id of the affected user attribute.
	 */
	public function getAttributeId();
	
	
	/**
	 * Returns the command type: 
	 * Inx_Api_Action_SetValueCommand::CMD_TYPE_ABSOLUTE, 
	 * Inx_Api_Action_SetValueCommand::CMD_TYPE_RELATIVE or
	 * Inx_Api_Action_SetValueCommand::CMD_TYPE_FREE_EXPRESSION
	 * 
	 * @return int the command type.
	 */
	public function getCmdType();
	
	
	/**
	 * Returns the expression/value to set for the attribute.
	 * 
	 * @return string the expression/value.
	 */
	public function getExpression();
	
}

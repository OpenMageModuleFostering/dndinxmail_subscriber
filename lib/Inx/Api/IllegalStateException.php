<?php
/**
 * @package Inxmail
 */
/**
 * An <i>Inx_Api_IllegalStateException</i> is thrown when a method cannot operate as expected, 
 * because the application is in the wrong state.
 * This exception is often thrown by attribute getters when methods are invoked which are illegal 
 * for the given attribute getter.
 * <p> 
 * Example: A Bounce attribute getter is incapable to retrieve any datetime attributes, although 
 * a method for doing so is provided. However, invokig this method will raise an illegal state 
 * exception, as this method may not be called for the given getter.
 * 
 * @package Inxmail
 */
class Inx_Api_IllegalStateException extends Exception {
	
}
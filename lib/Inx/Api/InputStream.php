<?php
/**
 * @package Inxmail
 */
/**
 * This abstract class is the superclass of all classes representing an input stream of bytes.
 * Subclasses of InputStream must always provide a method that returns the next byte of input as well as a method 
 * used to close the stream. 
 * 
 * @package Inxmail
 */
abstract class Inx_Api_InputStream
{
    abstract public function read();
    abstract public function close();
}
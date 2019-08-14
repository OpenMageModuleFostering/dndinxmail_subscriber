<?php
/**
 * @package Inxmail
 * @subpackage Mail
 */
/**
 * An <i>Inx_Api_Mail_RenderError</i> object describes the details of an error which occurred during the parsing or building of
 * a mailing. 
 * <i>Inx_Api_Mail_RenderError</i> offers the following information:
 * <ul>
 * <li><i>Error type</i>: an internal error code
 * <li><i>Mail part</i>: the internal mail part code
 * <li><i>Begin line / column</i>: the line and column where the malicious token begins
 * <li><i>End line / column</i>: the line and column where the malicious token ends.
 * <li><i>Error messages</i>: the error messages
 * </ul>
 * <p>
 * <i>Inx_Api_Mail_RenderError</i> is mainly used internally but may provide some insight on the error source to API developers. 
 * For example, the token position will assist you in identifying syntax errors. 
 * The error messages may also be analyzed to identify the error source.
 * 
 * @see Inx_Api_Mail_BuildException::getError()
 * @see Inx_Api_Mail_ParseException::getError($iIndex)
 * @version $Revision: 9479 $ $Date: 2007-12-18 15:43:23 +0200 (An, 18 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Mail
 */
class Inx_Api_Mail_RenderError
{
    private $iErrorType;
    private $iMailPart;
    private $iBeginLine;
    private $iEndLine;
    private $iBeginColumn;
    private $iEndColumn;
    /**
     * @var array of string arguments
     */
    private $aMsgArgs;

    
   /**
    * Creates an <i>Inx_Api_Mail_RenderError</i> with the given details.
    *
    * @param $iErrorType the internal error code.
    * @param $iMailPart the internal mail part code.
    * @param $iBeginLine the line where the malicious token begins.
    * @param $iEndLine the line where the malicious token ends.
    * @param $iBeginColumn the column where the malicious token begins.
    * @param $iEndColumn the column where the malicious token ends.
    * @param $aMsgArgs the string error messages.
    */
    public function __construct( $iErrorType, $iMailPart, $iBeginLine,
            $iEndLine, $iBeginColumn, $iEndColumn, $aMsgArgs )
    {
        $this->iErrorType = $iErrorType;
        $this->iMailPart = $iMailPart;
        $this->iBeginLine = $iBeginLine;
        $this->iEndLine = $iEndLine;
        $this->iBeginColumn = $iBeginColumn;
        $this->iEndColumn = $iEndColumn;
        $this->aMsgArgs = $aMsgArgs;
    }
    
   
   /**
    * Returns the internal error code.
    *
    * @return int the internal error code.
    */
    public function getErrorType()
    {
        return  $this->iErrorType;
    }


   /**
    * Returns the internal mail part code.
    *
    * @return int the internal mail part code.
    */
    public function getMailPart()
    {
        return $this->iMailPart ;
    }


   /**
    * Returns the line where the malicious token begins.
    *
    * @return int the line where the malicious token begins.
    */
    public function getBeginLine()
    {
        return $this->iBeginLine;
    }

    
   /**
    * Returns the line where the malicious token ends.
    *
    * @return int the line where the malicious token ends.
    */
    public function getEndLine()
    {
        return $this->iEndLine;
    }
    

   /**
    * Returns the column where the malicious token begins.
    *
    * @return int the column where the malicious token begins.
    */
    public function getBeginColumn()
    {
        return $this->iBeginColumn;
    }


   /**
    * Returns the column where the malicious token ends.
    *
    * @return int the column where the malicious token ends.
    */
    public function getEndColumn()
    {
        return $this->iEndColumn;
    }


    /**
    * Returns the error messages.
    *
    * @return array the string error messages.
    */
    public function getMsgArgs()
    {
        return $this->aMsgArgs;
    }

}

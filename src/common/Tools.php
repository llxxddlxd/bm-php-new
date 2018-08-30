<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\common;

class Tools{ 
    /**
     * [isEmpty description]
     * @param  [type]  $info [description]
     * @return boolean       [description]
     */
   static public function isEmpty($info){
        if(empty($info)){
            return true;
        }
        else{
            return false;
        }   
   }

   /**
    * [isNULL description]
    * @param  [type]  $info [description]
    * @return boolean       [description]
    */
   static public function isNULL($info){
        if(!isset($info)  || is_null($info)){
            return true;
        }
        else{
            return false;
        }   
   }
}
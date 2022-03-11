<?php
/**------------------------------------------------------
 *   ¬спомогательный модуль дл€ работы со строками
 * ------------------------------------------------------
 * Created by PhpStorm.
 * User: eryabov
 * Date: 06.12.2021
 * Time: 20:12
 */


function UnEncodingStr($cStr_){
    $bWasChanged = true;
    $aSpecStr = array ("&lt;", "&gt;", "&amp;", "&quot;", "&apos;", "</br>");
    $aAlterStr = array ("<", ">", "&", "\"", "'", "\n");

    if ($cStr_ == null) return " ";

    $cStr_ = trim(htmlspecialchars_decode($cStr_, ENT_QUOTES));

    while ($bWasChanged) {
        $bWasChanged = false;
        for ($i = 0; $i < count($aSpecStr); $i++){
          $cSpecStr = $aSpecStr[$i];
          $nSpecStrLen = strlen($aSpecStr[$i]);
          if (strripos($cStr_, $cSpecStr)){
            $nPos = strripos($cStr_, $cSpecStr);
            $cPrefix = substr($cStr_, 0, $nPos);
            $cSuffix = substr($cStr_, $nPos+$nSpecStrLen);
            $cStr_ = $cPrefix . $aAlterStr[$i]. $cSuffix;
            $bWasChanged = true;
          }
        }
    }
    return $cStr_;
  }

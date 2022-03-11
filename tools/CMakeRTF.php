<?php
/**
//  Класс для формирования отчета в rtf-файле.
//
//---------------------------------------------------------------------------------------------------------------------
//   Author: E. Ryabov
 * Date: 29.11.2021
 * Time: 0:20
 */

class CMakeRtf {

public static $raLeft      = 1;
public static $raRight     = 2;
public static $raCenter    = 3;
public static $raJustify   = 4;
public static $rfsBold        =  '1';
public static $rfsItalic      =  '2';
public static $rfsStrike      =  '3';
public static $rfsUnderline   =  '4';
public static $rfsUnderword   =  '5';
public static $rfsUnderdot    =  '6';
public static $rfsUnderdouble =  '7';
public static $rfsSuperScript =  '8';
public static $rfsSubScript   =  '9';
public static $rfsDefault     =  '0';
public static $rfsKeep        =  'A';

public $m_cStyle ;
public $m_nSubSize = 10;
public $m_nFont         = 121;
public $m_nSize         = 24;
public $m_nAlign        = 0;
public $m_nColumnsCount = 100;                  // количество столбцов
public $m_arTblValues = array();  // содержимое ячеек
public $m_arTblWidths = array();     // ширины столбцов
public $m_arTblBorders =  array();
public $m_arTblAlign =  array();      // выравнивание в столбцах
public $m_cTextResult = "";

function __construct() {}


  public static function Twips($nCm_){
    $nTwips = Round($nCm_ * 1440 / 2.54);
    return $nTwips;
  }


   public function BeginTable(){
     $this->m_cTextResult .= "{\\plain\\fs16";
   }

   public function EndTable(){
     if ($this->m_nColumnsCount > 0){
         $this->m_cTextResult .= "\\pard}";
     }
     $this->m_nColumnsCount = 0;
   }

   public function setColumnsCount($nCount_){ $this->m_nColumnsCount = $nCount_;}

   public function  getColumnsCount(){return $this->m_nColumnsCount;}

  public function SetupColumns($nLeftInd_, $cBorders_){
    $this->m_cTextResult .= "\\trowd";
    $this->m_cTextResult .= "\\trlef".$nLeftInd_;
    $nCurIndent = $nLeftInd_;
    for ($i = 0; $i < $this->m_nColumnsCount; $i++) {
        $nCurIndent += $this->m_arTblWidths[$i];
        if ($cBorders_ == 'S')      $this->m_cTextResult .= "\\clbrdrt\\brdrs\\clbrdrl\\brdrs\\clbrdrr\\brdrs\\clbrdrb\\brdrs";
        else if ($cBorders_ == 'D') $this->m_cTextResult .= "\\clbrdrt\\brdrdb\\clbrdrl\\brdrdb\\clbrdrr\\brdrdb\\clbrdrb\\brdrdb";
        $this->m_cTextResult .= "\\cellx".$nCurIndent;
        $this->m_arTblAlign[$i]  = $this->m_nAlign;
        $this->m_arTblValues[$i] = "";
    }
  }

  public function SetupFlexColumns($nLeftInd_){

    $this->m_cTextResult .= "\\trowd";
    $this->m_cTextResult .= "\\trleft".$nLeftInd_;
    $nTmp = 0;
    for ($i = 1; $i <= $this->m_nColumnsCount; $i++) {
        $nTmp = $nTmp + $this->m_arTblWidths[$i];
        $this->m_cTextResult .= "\\clbrdrt\\brdr" . (substr($this->m_arTblBorders[$i], 2, 1)=="S" ?"s":"db").
            "\\clbrdrl\\brdr" . (substr($this->m_arTblBorders[$i],0,1)=="S" ? "s" : "db").
            "\\clbrdrr\\brdr" . (substr($this->m_arTblBorders[$i],1,1)=="S" ? "s" : "db").
            "\\clbrdrb\\brdr" . (substr($this->m_arTblBorders[$i],3,1)=="S"  ? "s" : "db");
        $this->m_cTextResult .= "\\cellx".$nTmp;
        $this->m_arTblAlign[$i] = CMakeRtf::$raLeft;
        $this->m_arTblValues[$i] = "";
    }
  }

  public function WriteRow() {
    if ($this->m_nColumnsCount > 0){
      $this->m_cTextResult .= "\\intbl{";
      $this->m_cTextResult .= $this->AlignConvert($this->m_nAlign);
      $cText = "";
      for ($i = 1; $i <= $this->m_nColumnsCount; $i++){
        $cString = "{". $this->AlignConvert($this->m_arTblAlign[$i])."\\li50\\ri50\\cell}";
        $cText .= ($i == 1 ? "" : "{") . $this->StyleConvert($this->m_cStyle) . "\\fs" . $this->m_nSize . " ".
                  $this->m_arTblValues[$i] . "}" . $cString;
      }
        $this->m_cTextResult .= $cText . "{\\row}";
    }
  }

  public function StyleConvert($cStyle_){
    $cResult = "";
    for ($i = 0; $i < strlen($cStyle_); $i++){
      $cChar = $cStyle_.substr($i,1);
      if ($cChar == CMakeRtf::$rfsBold)        { $cResult = "\\b"; }
      else if ($cChar == CMakeRtf::$rfsItalic )  { $cResult = "\\i"; }
      else if ($cChar == CMakeRtf::$rfsStrike)  { $cResult = "\\strike"; }
      else if ($cChar == CMakeRtf::$rfsUnderline) { $cResult = "\\ul"; }
      else if ($cChar == CMakeRtf::$rfsUnderword) { $cResult = "\\ulw"; }
      else if ($cChar == CMakeRtf::$rfsUnderdot) { $cResult = "\\uld"; }
      else if ($cChar == CMakeRtf::$rfsUnderdouble) { $cResult = "\\uldb"; }
      else if ($cChar == CMakeRtf::$rfsSuperScript) { $cResult = "\\up".$this->m_nSubSize; }
      else if ($cChar == CMakeRtf::$rfsSubScript) { $cResult = "\\sub"; }
      else if ($cChar == CMakeRtf::$rfsDefault) { $cResult = "\\plain"; }
    }
    return $cResult;
  }

  public function AlignConvert($nAlign_){
    $cResult = "";
    if      ($nAlign_ == CMakeRtf::$raLeft)    { $cResult = "\\ql"; }
    else if ($nAlign_ == CMakeRtf::$raRight )  { $cResult = "\\qr"; }
    else if ($nAlign_ == CMakeRtf::$raCenter)  { $cResult = "\\qc"; }
    else if ($nAlign_ == CMakeRtf::$raJustify) { $cResult = "\\qj"; }
    return $cResult;
  }

}
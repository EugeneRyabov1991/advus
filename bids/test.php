<?php

include("../tools/CMakeRTF.php");

$oReport = new CMakeRTF();

$oReport->BeginTable();
$oReport->setColumnsCount(6);
$oReport->m_arTblWidths[1] = CMakeRTF::Twips(1);
$oReport->m_arTblWidths[2] = CMakeRTF::Twips(6.5);
$oReport->m_arTblWidths[3] = CMakeRTF::Twips(3);
$oReport->m_arTblWidths[4] = CMakeRTF::Twips(2);
$oReport->m_arTblWidths[5] = CMakeRTF::Twips(2);
$oReport->m_arTblWidths[6] = CMakeRTF::Twips(3);
$oReport->m_arTblBorders[1] = "dsds";
$oReport->m_arTblBorders[2] = "ssds";
$oReport->m_arTblBorders[3] = "ssds";
$oReport->m_arTblBorders[4] = "ssds";
$oReport->m_arTblBorders[5] = "ssds";
$oReport->m_arTblBorders[6] = "sdds";
$oReport->SetupFlexColumns(0);
$oReport->m_arTblAlign[1] = CMakeRTF::$raCenter;
$oReport->m_arTblAlign[2] = CMakeRTF::$raCenter;
$oReport->m_arTblAlign[3] = CMakeRTF::$raCenter;
$oReport->m_arTblAlign[4] = CMakeRTF::$raCenter;
$oReport->m_arTblAlign[5] = CMakeRTF::$raCenter;
$oReport->m_arTblAlign[6] = CMakeRTF::$raCenter;
$oReport->m_arTblValues[1] = "";
$oReport->m_arTblValues[2] = "Наименование продукции, услуги";
$oReport->m_arTblValues[3] = "Цена, руб.";
$oReport->m_arTblValues[4] = "Кол-во";
$oReport->m_arTblValues[5] = "Ст. НДС";
$oReport->m_arTblValues[6] = "Сумма";

$oReport->m_cStyle = CMakeRTF::$rfsBold;
$oReport->WriteRow();
$oReport->EndTable();


$oReport->BeginTable();
$oReport->setColumnsCount(2);
$oReport->m_arTblWidths[1] = CMakeRTF::Twips(14.5);
$oReport->m_arTblWidths[2] = CMakeRTF::Twips(3);
$oReport->m_arTblBorders[1] = "dsdd";
$oReport->m_arTblBorders[2] = "sddd";
$oReport->SetupFlexColumns(0);
$oReport->m_arTblAlign[1] = CMakeRTF::$raLeft;
$oReport->m_arTblAlign[2] = CMakeRTF::$raRight;
$oReport->m_arTblValues[1] = "И Т О Г О";
$oReport->m_arTblValues[2] = ("6784");
$oReport->WriteRow();
$oReport->m_arTblValues[1] = "НДС не облагается";
$oReport->m_arTblValues[2] = "---";
$oReport->WriteRow();
$oReport->m_arTblValues[1] = "В С Е Г О";
$oReport->m_arTblValues[2] = "9874";
$oReport->m_cStyle = CMakeRTF::$rfsBold;
$oReport->WriteRow();
$oReport->EndTable();

 echo $oReport->m_cTextResult;

?>
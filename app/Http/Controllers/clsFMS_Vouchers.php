<?php

include_once('clsFMS_Reports.php');
include_once('clsFMS_Reports_AccountReports.php');
date_default_timezone_set("Asia/Karachi");

class clsFMS_Vouchers {

    public $aEntryType;
    public $aPaymentType;
    public $aRecipient;
    public $aReceiptType;
    public $aStatus;
    public $aStatusType;
    public $VouchersArray;

    function GetAssignedOffices($EmployeeId, $IncludeAreas = false) {
        global $objDatabase;
        global $objDB_FIS;
        $sOfficeCondition = "";
        $condArray = array();
        $EmployeeCondition = "";
        if ($EmployeeId != 1) {
            $EmployeeCondition = "AND eo.EmployeeId='$EmployeeId'";
        }
        $varResult = $objDB_FIS->ExecQueryAll("SELECT eo.OfficeId, o.OfficeParentId FROM organization_employees_offices as eo "
                . "inner join organization_offices as o on o.OfficeId = eo.OfficeId "
                . "WHERE 1=1 $EmployeeCondition AND o.Status='1'");
        if ( $varResult ) {
            foreach ( $varResult as $varResult) {
                $Officeid = $varResult["OfficeId"];
                $OfficeParentId = $varResult["OfficeParentId"];
                $condArray[$Officeid] = $Officeid;
                if ($IncludeAreas)
                    $condArray[$OfficeParentId] = $OfficeParentId;
            }
            $sOfficeCondition = implode(",", $condArray);
            $sOfficeCondition = " AND (O.OfficeId in ($sOfficeCondition))";
        }

        return($sOfficeCondition);
    }

    public function __construct() {
        $this->VouchersArray = array(
            array("Prepared Voucher", "#FA6900"),
            array("Checked Voucher", "#70B7BA"),
            array("Authorized Voucher", "#3D4C53"),
            array("Complianced/UnApproved Voucher", "#960088"),
            array("Approved Voucher", "#A9CF54"),
            array("Acknowledged Voucher", "#FF4C65"),
            array("Under Observation Voucher", "#F1433F")
        );

        $this->aEntryType = array('Payment', 'Receipt', 'Journal Entry');
        $this->aPaymentType = array('Bank Payment', 'Cash Payment');
        $this->aRecipient = array('Vendor', 'Customer', 'Employee');
        $this->aReceiptType = array('Bank Receipt', 'Cash Receipt');
        $this->aBankPaymentType = array('CheckBook', 'Online Transfer', 'ATM');

        $this->aStatus = array('Approved', 'ServiceChargesPosted', 'Posted');

        //$this->aStatus = array('Posted', 'Initiated', 'Cancelled');
        $this->aStatusType = array(1, 0, 1);
    }

    function ShowMenu($Page) {
        global $objEmployee;

        $VoucherAccess = $objEmployee->iVoucherAccess;



        $PreparedVouchers = '';
        $CheckedVouchers = '';
        $AuthorizedVouchers = '';
        $CompliancedVouchers = '';
        $UnAcknowledgedVouchers = '';



        if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanAcknowledgeVoucher) {
            $UnAcknowledgedVouchers = '<a ' . (($Page == "UnAcknowledgedVouchers") ? 'style="color:blue; text-decoration:underline; font-weight:bold;"' : '') . ' href="../vouchers/?page=UnAcknowledgedVouchers"><img src="../images/banking/iconBankAccounts_disabled.gif" alt="UnAcknowledged Vouchers" title="UnAcknowledged Vouchers" border="0" /><br />UnAcknowledged Vouchers</a>';
        }
        if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanApproveVoucher) {
            $CompliancedVouchers = '<a ' . (($Page == "CompliancedVouchers") ? 'style="color:blue; text-decoration:underline; font-weight:bold;"' : '') . ' href="../vouchers/?page=CompliancedVouchers"><img src="../images/banking/iconBankAccounts.gif" alt="Complianced Vouchers" title="Complianced Vouchers" border="0" /><br />UnApproved Vouchers</a>';
        }
        if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanComplianceVoucher) {
            $AuthorizedVouchers = '<a ' . (($Page == "AuthorizedVouchers") ? 'style="color:blue; text-decoration:underline; font-weight:bold;"' : '') . ' href="../vouchers/?page=AuthorizedVouchers"><img src="../images/banking/iconBankReconciliation.gif" alt="Authorized Vouchers" title="Authorized Vouchers" border="0" /><br />Authorized Vouchers</a>';
        }
        if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanAuthorizeVoucher) {
            $CheckedVouchers = '<a ' . (($Page == "CheckedVouchers") ? 'style="color:blue; text-decoration:underline; font-weight:bold;"' : '') . ' href="../vouchers/?page=CheckedVouchers"><img src="../images/banking/_iconBanks.gif" alt="Checked Vouchers" title="Checked Vouchers" border="0" /><br />Checked Vouchers</a>';
        }
        if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanCheckVoucher) {
            $PreparedVouchers = '<a ' . (($Page == "PreparedVouchers") ? 'style="color:blue; text-decoration:underline; font-weight:bold;"' : '') . ' href="../vouchers/?page=PreparedVouchers"><img src="../images/banking/iconBankCheckbooks.gif" alt="Prepared Vouchers" title="Prepared Vouchers" border="0" /><br />Prepared Vouchers</a>';
        }
        $sReturn .= '
    	<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
    	 <tr>
    	  <td valign="bottom">

    	<table border="0" cellspacing="0" cellpadding="3" width="70%" align="center">
    	 <tr>';


        $sReturn .= '<td align="center" width="10%">' . $PreparedVouchers . '</td>';

        $sReturn .= '<td align="center" width="10%">' . $CheckedVouchers . '</td>';

        $sReturn .= '<td align="center" width="10%">' . $AuthorizedVouchers . '</td>';

        $sReturn .= '<td align="center" width="10%">' . $CompliancedVouchers . '</td>';

        //$sReturn .= '<td align="center" width="10%">' . $UnAcknowledgedVouchers . '</td>';    	 

        $sReturn .= '</tr>
    	</table>

    	</td></tr></table>';

        return($sReturn);
    }

    function ShowVoucherPages($sPage) {
        global $objEmployee;
        $VoucherAccess = $objEmployee->iVoucherAccess;
        //include(cVSFFolder . '/classes/clsDHTMLSuite.php');
        $objDHTMLSuite = new clsDHTMLSuite();
        if ($sPage == "UnAcknowledgedVouchers" && $objEmployee->objEmployeeRoles->bEmployeeRole_CanAcknowledgeVoucher == 0) {
            $sPage = "";
        } else if ($sPage == "CompliancedVouchers" && $objEmployee->objEmployeeRoles->bEmployeeRole_CanApproveVoucher == 0) {
            $sPage = "";
        } else if ($sPage == "AuthorizedVouchers" && $objEmployee->objEmployeeRoles->bEmployeeRole_CanComplianceVoucher == 0) {
            $sPage = "";
        } else if ($sPage == "CheckedVouchers" && $objEmployee->objEmployeeRoles->bEmployeeRole_CanAuthorizeVoucher == 0) {
            $sPage = "";
        } else if ($sPage == "PreparedVouchers" && $objEmployee->objEmployeeRoles->bEmployeeRole_CanCheckVoucher == 0) {
            $sPage = "";
        } else if ($sPage == "UnderObservationVouchers" && $objEmployee->objEmployeeRoles->bEmployeeRole_CanProcessObservationVoucher == 0) {
            $sPage = "";
        }

        if ($sPage == "") {
            if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanAcknowledgeVoucher) {
                $sPage = "UnAcknowledgedVouchers";
            }
            if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanApproveVoucher) {
                $sPage = "CompliancedVouchers";
            }
            if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanComplianceVoucher) {
                $sPage = "AuthorizedVouchers";
            }
            if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanAuthorizeVoucher) {
                $sPage = "CheckedVouchers";
            }
            if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanCheckVoucher) {
                $sPage = "PreparedVouchers";
            }
            if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanProcessObservationVoucher) {
                $sPage = "UnderObservationVouchers";
            }
        }
//
//        

        switch ($sPage) {
            case "UnderObservationVouchers":
            case "PreparedVouchers":
                if ($sPage == "PreparedVouchers")
                    $aTabs[0][0] = 'Prepared Vouchers';
                else
                    $aTabs[0][0] = 'U.Obser. Vouchers';

                $aTabs[0][1] = '../vouchers/preparedvouchers.php';
                break;
            case "CheckedVouchers":
                $aTabs[0][0] = 'Checked Vouchers';
                $aTabs[0][1] = '../vouchers/checkedvouchers.php';
                break;
            case "AuthorizedVouchers":
                $aTabs[0][0] = 'Authorized Vouchers';
                $aTabs[0][1] = '../vouchers/authorizedvouchers.php';
                break;
            case "CompliancedVouchers":
                $aTabs[0][0] = 'UnApproved Vouchers';
                $aTabs[0][1] = '../vouchers/compliancedvouchers.php';
                break;
            case "UnApprovedVouchers":
                $aTabs[0][0] = 'UnApproved Vouchers';
                $aTabs[0][1] = '../vouchers/unapprovedvouchers.php';
                break;
            case "UnAcknowledgedVouchers":
                $aTabs[0][0] = 'Un-Acknowledged Vouchers';
                $aTabs[0][1] = '../vouchers/unapprovedvouchers.php';
                break;
        }

        $sReturn = $objDHTMLSuite->TabBar($aTabs, $this->ShowMenu($sPage));
        return($sReturn);
    }

    public function GetVouchersDocuments($iGeneralJournalId, $GJTransactionDate) {

        //muqeemsarwar
        $r = '<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
';

        $r .= '<div class="carousel-inner" role="listbox">';

        $dir = '../../uploads/source/' . $GJTransactionDate . '/' . $iGeneralJournalId;
        $files1 = scandir($dir);
        $files2 = scandir($dir, 1);

        $j = 0;
        for ($i = 0; $i < count($files2); $i++) {
            $file_ext = $files2[$i];
            $aFileExt = explode(".", $file_ext);
            if (count($aFileExt) == 2) {
                //,"pdf","doc","docx"


                //                fis.tmf.org.pk/uploads/source/2022-05-20/695902/electricy bill region office.pdf

                
                $imgPath = $_SERVER['HTTP_HOST'] . '/uploads/source/' . $GJTransactionDate . '/' . $iGeneralJournalId . '/' . $file_ext;
              
                if (in_array($aFileExt[1], array("jpg", "png", "gif"))) {

                   
                    $r .= '<div class="item ' . ($j == 0 ? "active" : "") . '">
                    <img style="margin:0 auto; height:520px;" src="https://' . $imgPath . '" alt="">
                    <div class="carousel-caption" style="position:static;top:25px;color:#000;">
                        ' . $aFileExt[0] . '
                    </div>
                </div>';

                    $j++;
                }
                // <div style="margin:0 auto; height:520px;" caste="sahito">
                //     <iframe src="https://docs.google.com/viewer?url=https://' . $imgPath . '&embedded=true" frameborder="0" style="margin:0 auto;width:85%; height:520px;display:block;"></iframe>
                // </div>
                if (in_array($aFileExt[1], array("pdf", "doc", "docx", "txt"))) {
                    
                    $r .= '<div class="item ' . ($j == 0 ? "active" : "") . '">                    
                    
                    <div style="margin:0 auto; height:520px;" caste="sahito">
                        <iframe src="https://' . $imgPath . '" frameborder="0" style="margin:0 auto;width:85%; height:520px;display:block;"></iframe>
                    </div>
                    <div class="carousel-caption" style="position:static;top:25px;color:#000;">
                        ' . $aFileExt[0] . '
                    </div>
                </div>';
                    $j++;
                    //<embed src="pdfFiles/interfaces.pdf" width="600" height="500" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
                }
                //echo "<br>";
            }
        }
        if ($j == 0) {
            $r .= '<div align="center" style="padding:10px;">..:: No Any Documents Found ::..</div>';
        }
        $r .= '</div>';

        $r .= '<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="sr-only">Next</span>
  </a>
</div>';
        return $r;
    }

    public function ShowVoucherDetails($iGeneralJournalId) {

        
        global $objDatabase;
        global $objGeneral;
        global $objEmployee;
        global $objDB_FIS;

        $CalledStatus = $objGeneral->fnGet("pStatus");

//muqeemsarwar 20-05-2022


//        echo "Check: ".$objEmployee->objEmployeeRoles->bEmployeeRole_CanCheckVoucher;
//        echo "<br>";
//        echo "Auth: ".$objEmployee->objEmployeeRoles->bEmployeeRole_CanAuthorizeVoucher;
//        echo "<br>";
//        echo "Compliance: ".$objEmployee->objEmployeeRoles->bEmployeeRole_CanComplianceVoucher;
//        echo "<br>";
//        echo "Appr: ".$objEmployee->objEmployeeRoles->bEmployeeRole_CanApproveVoucher;
//
//        echo "<br>";
//        echo $iStatus." - ".$objEmployee->objEmployeeRoles->bEmployeeRole_CanAuthorizeVoucher;
//        echo "<br>";

        $LoggedInEmployeeId = $objEmployee->iEmployeeId;

        $CheckMinLimit = $objEmployee->objEmployeeRoles->bEmployeeRole_CanCheckVoucherAmountMin;
        $CheckMaxLimit = $objEmployee->objEmployeeRoles->bEmployeeRole_CanCheckVoucherAmountMax;
        $AuthorizeMinLimit = $objEmployee->objEmployeeRoles->bEmployeeRole_CanAuthorizeVoucherAmountMin;
        $AuthorizeMaxLimit = $objEmployee->objEmployeeRoles->bEmployeeRole_CanAuthorizeVoucherAmountMax;
        $ApproveMinLimit = $objEmployee->objEmployeeRoles->bEmployeeRole_CanApproveVoucherAmountMin;
        $ApproveMaxLimit = $objEmployee->objEmployeeRoles->bEmployeeRole_CanApproveVoucherAmountMax;
        $VoucherRole = $objEmployee->objEmployeeRoles->bEmployeeRole_VoucherRole;
        if ($CheckMinLimit == "")
            $CheckMinLimit = 0;
        if ($AuthorizeMinLimit == "")
            $AuthorizeMinLimit = 0;
        if ($ApproveMinLimit == "")
            $ApproveMinLimit = 0;
        if ($CheckMaxLimit == "")
            $CheckMaxLimit = 0;
        if ($AuthorizeMaxLimit == "")
            $AuthorizeMaxLimit = 0;
        if ($ApproveMaxLimit == "")
            $ApproveMaxLimit = 0;



        $return = '
        <link rel="stylesheet" href="mystyle/bootstrap.min.css" >
        <script src="mystyle/jquery.min.js"></script>
        <script src="mystyle/bootstrap.min.js" ></script>
        <script type="text/javascript" language="Javascript" src="mystyle/jquery.min.js" ></script>';

        
        $return .= "<style>
            .noradius{
                border-radius: 0px !important;
            }
            .down-fixed {
                padding:8px;
                position:fixed;
                bottom:0;
                width:100%;
            }
            .alert-position{
    position: fixed;
    right: 50px;
    top: 30px;
    width: 30%;            
    }
    .mediastyle {
    background-color:#FFFFFF;
     border: 0 solid #ccc;
    box-shadow: 0 0 2px 1px #ccc;
    margin-bottom: -5px;
    padding: 5px; 
    }
.main-contain {
    margin: 5px auto;
    width: 95%;
    background-color: rgba(200, 200, 200, 0.1);
    padding: 10px;
    border: 2px solid #ccc;
    border-radius: 5px;
    height: 640px;
    overflow-y: scroll;
}
    
        #loadingDiv{
  position:fixed;
  top:0px;
  right:0px;
  width:100%;
  height:100%;
  background-color:#EEEEEE;
  background-image:url('ajax-loader.gif');
  background-repeat:no-repeat;
  background-position:center;
  z-index:10000000;
  display:none;
  opacity: 0.4;
  filter: alpha(opacity=40); /* For IE8 and earlier */
}
.carousel-control {
    width:4% !important;
}
.carousel-inner {
    position: relative;
    width: 100%;
    overflow: hidden;
    border: 2px solid #FFFFFF;
    box-shadow: 0px 0px 9px 3px #CCCCCC;
}
.carousel-inner iframe {
    margin: 1% auto !important;
    width: 91% !important;
    height: 110% !important;
}
.media-heading {
    margin-top: 10px !important;
}
        </style>";
        $QueryGeneralJournal = "
            select GJ.Status, S.StationId, S.StationName, GJ.TransactionDate from fms_accounts_generaljournal as GJ 
            inner join organization_stations as S on S.StationId = GJ.StationId 
            where GeneralJournalId = '$iGeneralJournalId'";

        $GJ_Result = $objDB_FIS->ExecQueryRow($QueryGeneralJournal);
        
//        $GJ_RowsNumber = count($GJ_Result);
        $GJ_Status = 0;
        $VoucherRole = $objEmployee->objEmployeeRoles->bEmployeeRole_VoucherRole;

        if ($GJ_Result) {
            
            $GJ_Status =$GJ_Result["Status"];
            if ($CalledStatus <> $GJ_Status){
                die("<strong>Voucher Already Processed...</strong>");
            }
            if ($GJ_Status < 4) {
                if ($GJ_Status == 3 && $objEmployee->objEmployeeRoles->bEmployeeRole_CanComplianceVoucher) {
                    //die("<h2>Voucher is Already Complianced</h2>");
                } else if ($VoucherRole == 2 && $GJ_Status == 2) {
                    //die("<h2>Voucher is Already Authorized</h2>");
                } else if ($VoucherRole == 1 && $GJ_Status == 1) {
                    //die("<h2>Voucher is Already Checked</h2>");
                }
            } else if ($GJ_Status == 4) {
                die("<h2>Voucher is Already Approved</h2>");
            }
            $GJ_StationId = $GJ_Result["StationId"];
            $GJ_StationName = $GJ_Result["StationName"];
            $GJTransactionDate = $GJ_Result["TransactionDate"];
        }
        
        
        $dummy = "";
        $AccountsReports = new clsFMS_Reports_AccountReports();
        $GeneralJournalVoucher = $AccountsReports->GenerateGeneralJournalReceiptlReport(false, $dummy, $iGeneralJournalId);
        $VoucherDocuments = $this->GetVouchersDocuments($iGeneralJournalId, $GJTransactionDate);


        $sReceipt = '<button class="row col-sm-12 btn btn-info" href="#noanchor" onclick="jsOpenWindow(\'../reports/showreport.php?report=AccountsReports&reporttype=GeneralJournalReceipt&selEmployee=-1&selStation=-1&id=' . $iGeneralJournalId . '&txtReference=' . $sReference . '\', 800,600);">View Voucher</button>';
        $ViewDocuments = '<button class="row col-sm-12 btn btn-info" href="#noanchor" onclick="window.top.MOOdalBox.open(\'../common/documents_show.php?componentname=Accounts_GeneralJournal&id=' . $iGeneralJournalId . '\', \'Documents of ' . str_replace('"', '', $sReference) . '\', \'700 420\');">View Documents</button>';

        //Current Voucher Attachments Panel
        $return .= '<div id="loadingDiv"></div>'
                . '<div class="main-contain">';
        $return .= '
        <fieldset>
            <legend>Basic Reviews:</legend>
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div data-toggle="collapse" data-target="#demo_inc" class="panel-heading collapsed" aria-expanded="false">Review Attached Documents</div>
                    <div id="demo_inc" class="collapse" aria-expanded="false" style="height: 0px;">
                        <div class="panel-body">
                            <p>' . $VoucherDocuments . '</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div data-toggle="collapse" data-target="#demo_voucher" class="panel-heading collapsed" aria-expanded="false">Review Attached Voucher</div>
                    <div id="demo_voucher" class="collapse" aria-expanded="false" style="height: 0px;">
                        <div class="panel-body">
                            <p>' . $GeneralJournalVoucher . '</p>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset><br>';

        //Current Voucher Status Panel
        //Current Voucher Comments Panel
        $GJH_Result = $objDB_FIS->ExecQueryAll("select 
                GJH.ProcessComment AS 'ProcessComment', GJH.ProcessTo AS 'ProcessTo', GJH.IsProcessed AS 'IsProcessed', GJH.ActionType AS 'ActionType', 
                GJH.ProcessBy AS 'ProcessBy', GJH.CreatedOn AS 'CreatedOn', concat(E.FirstName,' ',E.LastName) as 'FullName', E.Designation AS 'Designation'
                from fms_accounts_generaljournal_history as GJH
                inner join fms_organization_employees as E on E.EmployeeId = GJH.ProcessBy   
                where  GJH.GeneralJournalId = '$iGeneralJournalId'");

        $return .= '<div id="Div_HistoryContainer">';

        if ($GJH_Result) {
            $return .= '
            <fieldset>
                <legend>Current Voucher Status:</legend>
                <div class="col-lg-12 panel panel-info" align="center">' . ($this->VouchersArray[$GJ_Status][0]) . '</div>
            </fieldset>
            <fieldset>
                <legend>Comments <span class="badge">' . count($GJH_Result) . '</span>:</legend>';

            foreach ( $GJH_Result as $GJH_Result){
                $Comment = $GJH_Result["ProcessComment"];
                $ProcessTo = $GJH_Result["ProcessTo"];
                $IsProcessed = $GJH_Result["IsProcessed"];
                $ActionType = $GJH_Result["ActionType"];
                //$Ar_ActTitle = array(0=>"Prepared",1=>"Checked",2=>"Authorized",3=>"Complianced",4=>"Approved");
                $ProcessBy = $GJH_Result["ProcessBy"];
                $CreatedOn = $GJH_Result["CreatedOn"];
                $Designation = $GJH_Result["Designation"];
                $FullName = $GJH_Result["FullName"];
                $return .= '
                <div class="media col-md-12 mediastyle">
                    <div class="media-left">
                        <a href="#">
                            <img alt="64x64" class="media-object" data-src="holder.js/64x64" style="width: 64px; height: 64px;" src="../images/template/comment2.png" data-holder-rendered="true">
                        </a>
                    </div>
                    <div class="media-body"><h5 class="media-heading"><strong>' . $FullName . '</strong> <span style="font-style:italic;">(' . $Designation . ')</span> ' . '</strong> ' . ($IsProcessed ? "<span style='color:" . $this->VouchersArray[$ActionType][1] . ";'>" . $this->VouchersArray[$ActionType][0] . "</span>" : "<span style='color:#C9302C;'>Reversed</span>") . ' On <strong>' . date("F j, Y g:i a", strtotime($CreatedOn)) . '</strong> :</h5>' . ($IsProcessed ? '<strong style="color:#449d44;">Comment</strong>' : '<strong style="color:#c9302c;">Something went Wrong</strong>') . ':&nbsp;&nbsp;' . $Comment . '</div>
                </div>';
            }
            $return .= '</fieldset>';
        }
        $return .= '</div><br>';

        $ReversedButtonDisabled = "";
//Current Voucher Reviews Panel
        $return .= '
        <fieldset>
            <div class="col-md-12">
                <div class="alert alert-success alert-position" style="display:none;">Updated Successfully</div>
            </div>

            <div class="col-md-12">
            <input type="hidden" id="id" value="' . $iGeneralJournalId . '" />
            <input type="hidden" value="' . $LoggedInEmployeeId . '" id="user" />
                <textarea class="form-control noradius" name="comment" id="comment" placeholder="Comments here..."></textarea>
            </div>
            <div class="col-md-12 btn-group btn-group-justified" role="group" >
                <div class="btn-group" role="group">
                    <input action="0" class="btn btn-lg btn-danger noradius ' . $ReversedButtonDisabled . '" id="cancel" value="Reverse" type="button">
                </div>                
                <div class="btn-group" role="group">
                    <input action="1" class="btn btn-lg btn-success noradius" id="process" value="Process" type="button">
                </div>
            </div>
        </fieldset>';

        $return .= '</div>';
        $DocumentsSlider = "";
        //$ViewVoucher = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.MOOdalBox.open(\'../common/documents_show.php?componentname=Accounts_GeneralJournal&id=' . $iGeneralJournalId . '\', \'Documents of ' . mysql_real_escape_string(str_replace('"', '', $sReference)) . '\', \'700 420\');"><img src="../images/icons/iconImages.gif" border="0" alt="General Journal Documents" title="General Journal Documents"></a></td>';
        //echo $ViewVoucher = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.MOOdalBox.open(\'../reports/showreport.php?report=AccountsReports&reporttype=GeneralJournalReceipt&selEmployee=-1&selStation=-1&id=' . $iGeneralJournalId . '&txtReference=' . $sReference . '\', \'Vocher\', \'1024 860\');"><img src="../images/icons/iconImages.gif" border="0" alt="General Journal Documents" title="General Journal Documents"></a></td>';


        $CommentsByLoop = "";
        $CommentsLoop = "";

        //JQuery/Javascript Code
        $return .= '<script  type="text/javascript" language="Javascript">
            
       jQuery("#loadingDiv").show();
                    $(document).ready(function(){
                    jQuery("#loadingDiv").hide();
                        jQuery(".btn").click(function(){
                        //jQuery(".btn")
                            var do_action = jQuery(this).attr("action");
                            var comment_gj_id = jQuery("#id").val();
                            var comment_user = jQuery("#user").val();
                            var comment_text = jQuery("#comment").val();
                            if(comment_text!=""){
                            jQuery("#loadingDiv").show();
                            jQuery("#comment").removeClass("alert-danger");
                                jQuery.post("../vouchers/",{
                                        action:do_action,
                                        userComment:comment_text,
                                        user_id:comment_user,
                                        gj_id:comment_gj_id
                                    },
                                    function(data){
                                    
                                        if(data){
                                            jQuery("#Div_HistoryContainer").html(data);
                                            jQuery("#comment").val("");
                                            jQuery(".alert").fadeIn(300);
                                            setTimeout(function(){
                                            jQuery("#loadingDiv").hide();
                                                jQuery(".alert").fadeOut(700);
                                                //window.location.replace("../vouchers/");
                                                window.close();
                                       },1500);
                                    }
                                });
                            } else {
                                alert("Please Enter Comment First");
                                jQuery("#comment").focus();
                                jQuery("#comment").addClass("alert-danger");
                            }
                        });
                    });
                </script>';
        return $return;
    }

    public function AddUpdateDetails($action, $userComment, $user_id, $gj_id) {
//        global $objDatabase;
        global $objEmployee;
        global $objDB_FIS;
        
        $result = $objDB_FIS->ExecQueryRow("select * from fms_accounts_generaljournal_history 
                where  GeneralJournalId = '$gj_id' and ProcessBy='$user_id'");
        $lastInsertId = 0;
        if ( $result ) {
            $lastInsertId = $result["HistoryId"];
            $varResult = $objDB_FIS->Execute("update fms_accounts_generaljournal_history 
                set 
                GeneralJournalId='$gj_id', 
                ProcessBy='$user_id', 
                IsProcessed='$action', 
                ProcessComment = '$userComment', 
                UpdatedOn=now()
                where  GeneralJournalId = '$gj_id' and ProcessBy='$user_id'");
        } else {
            $varResult = $objDB_FIS->Execute("insert into fms_accounts_generaljournal_history 
                (GeneralJournalId, ProcessBy, IsProcessed, ProcessComment) 
                values('$gj_id','$user_id','$action','$userComment')");
            $lastInsertId = $objDB_FIS->getLastInsertId();
//            echo $lastInsertId;
        }
                
        
//
        //Update General Journal
//        $Q_SelectGJ = $objDatabase->Query("select TotalDebit, Status from fms_accounts_generaljournal "
//                . "where GeneralJournalId = '$gj_id'");


        $Q_SelectGJ = $objDB_FIS->ExecQueryRow("select gj.TotalDebit, gj.Status, ca.ParentChartOfAccountsId, ca.ChartOfAccountsId 
                from fms_accounts_generaljournal as gj 
                inner join fms_accounts_generaljournal_entries as gje on gje.GeneralJournalId = gj.GeneralJournalId 
                inner join fms_accounts_chartofaccounts as ca on gje.ChartOfAccountsId = ca.ChartOfAccountsId 
                where gj.GeneralJournalId = '$gj_id'  limit 1");

        $Q_SelectGJContains = $objDB_FIS->ExecQueryRow("select min(ca.ParentChartOfAccountsId) as 'pa',max(ca.ParentChartOfAccountsId) as 'pb',count(gje.Credit) as 'num' 
                from fms_accounts_generaljournal as gj 
                inner join fms_accounts_generaljournal_entries as gje on gje.GeneralJournalId = gj.GeneralJournalId 
                inner join fms_accounts_chartofaccounts as ca on gje.ChartOfAccountsId = ca.ChartOfAccountsId 
                where gj.GeneralJournalId = '$gj_id'  and ca.ParentChartOfAccountsId in (3,4,89)");
        $ParentChartOfAccountsId = 0;
        if ( $Q_SelectGJContains ) {
            $pa = $Q_SelectGJContains["pa"];
            $pb = $Q_SelectGJContains["pb"];
            $num = $Q_SelectGJContains["num"];
            if (($pa == 3 || $pa == 4) && ($pb == 3 || $pb == 4) && $num == 2) {
                $ParentChartOfAccountsId = 1;
            } else if (($pa == 89 || $pb == 89)) {
                $ParentChartOfAccountsId = 2;
            }
        }
        $TotalDebit = $Status = 0;
        if ($Q_SelectGJ) {
            $TotalDebit = $Q_SelectGJ["TotalDebit"];
            $TotalDebit = round($TotalDebit);
            $iStatus = $Q_SelectGJ["Status"];
        }

        $ComplianceMinLimit = $objEmployee->objEmployeeRoles->bEmployeeRole_CanComplianceVoucherAmountMin;
        $ComplianceMaxLimit = $objEmployee->objEmployeeRoles->bEmployeeRole_CanComplianceVoucherAmountMax;
        $CheckMinLimit = $objEmployee->objEmployeeRoles->bEmployeeRole_CanCheckVoucherAmountMin;
        $CheckMaxLimit = $objEmployee->objEmployeeRoles->bEmployeeRole_CanCheckVoucherAmountMax;
        $AuthorizeMinLimit = $objEmployee->objEmployeeRoles->bEmployeeRole_CanAuthorizeVoucherAmountMin;
        $AuthorizeMaxLimit = $objEmployee->objEmployeeRoles->bEmployeeRole_CanAuthorizeVoucherAmountMax;
        $ApproveMinLimit = $objEmployee->objEmployeeRoles->bEmployeeRole_CanApproveVoucherAmountMin;
        $ApproveMaxLimit = $objEmployee->objEmployeeRoles->bEmployeeRole_CanApproveVoucherAmountMax;

        $VoucherRole = $objEmployee->objEmployeeRoles->bEmployeeRole_VoucherRole;

        if ($CheckMinLimit == "")
            $CheckMinLimit = 0;

        if ($AuthorizeMinLimit == "")
            $AuthorizeMinLimit = 0;

        if ($ApproveMinLimit == "")
            $ApproveMinLimit = 0;

        if ($CheckMaxLimit == "")
            $CheckMaxLimit = 0;

        if ($AuthorizeMaxLimit == "")
            $AuthorizeMaxLimit = 0;

        if ($ApproveMaxLimit == "")
            $ApproveMaxLimit = 0;
        // Limit Settings
        //
        
        
        $GJ_Status = 0;
        $GJH_Status = 0;
        if ($action) {
            if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanProcessObservationVoucher && $iStatus == 6) {
                $GJ_Status = 0;
                $GJH_Status = 0;
            } else {
                if ($iStatus == 2) {                                        
                    $GJ_Status = 3;
                    $GJH_Status = 3;
                } else {                       
                    if ($VoucherRole == 1 && $iStatus == 0) {
                        //Check
                        $GJ_Status = 1;
                        $GJH_Status = 1;
                    } else if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanCompliance && $VoucherRole == 7 && $iStatus == 2) {
                        //Compliance
                        if ($TotalDebit >= $ComplianceMinLimit && $TotalDebit <= $ComplianceMaxLimit) {
                            $GJ_Status = 3;
                            $GJH_Status = 3;
                        } else {
                            $GJ_Status = $iStatus;
                            $GJH_Status = 9;
                        }
                    } else if ($VoucherRole == 2 && ($iStatus == 0 || $iStatus == 1 || $iStatus == 3)) {
                        // Manager
                        if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanCheckVoucher && $iStatus == 0) {
                            if ($TotalDebit >= $CheckMinLimit && $TotalDebit <= $CheckMaxLimit) {
                                $GJ_Status = 1;
                                $GJH_Status = 1;
                            } else {
                                $GJ_Status = $iStatus;
                                $GJH_Status = 9;
                            }
                        } else if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanAuthorizeVoucher && $iStatus == 1) {
                            if ($TotalDebit >= $AuthorizeMinLimit && $TotalDebit <= $AuthorizeMaxLimit) {
                                $GJ_Status = 2;
                                $GJH_Status = 2;
                            } else {
                                $GJ_Status = $iStatus;
                                $GJH_Status = 25;
                            }
                        } else if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanApproveVoucher && $iStatus == 3) {
                            if (($TotalDebit >= $ApproveMinLimit && $TotalDebit <= $ApproveMaxLimit)) {
                                $GJ_Status = 4;
                                $GJH_Status = 4;
                            } else {
                                $GJ_Status = $iStatus;
                                $GJH_Status = 26;
                            }
                        } else {
                            $GJ_Status = $iStatus;
                            $GJH_Status = 11;
                        }
                        if ($GJ_Status == 2) {
                            if (($TotalDebit >= $ApproveMinLimit && $TotalDebit <= $ApproveMaxLimit) && ($TotalDebit < $ComplianceMinLimit) && ($ParentChartOfAccountsId != 2)) {
                                $GJ_Status = 4;
                                $GJH_Status = 4;
                            }                        
                            
                            }
                    } else if ($VoucherRole == 3) {
                        // RM
                        if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanAuthorizeVoucher && $iStatus == 1) {
                            if ($TotalDebit >= $AuthorizeMinLimit && $TotalDebit <= $AuthorizeMaxLimit) {
                                $GJ_Status = 2;
                                $GJH_Status = 2;
                            } else {
                                $GJ_Status = $iStatus;
                                $GJH_Status = 25;
                            }
                        } else if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanApproveVoucher && $iStatus == 3) {
                            if (($TotalDebit >= $ApproveMinLimit && $TotalDebit <= $ApproveMaxLimit)) {
                                $GJ_Status = 4;
                                $GJH_Status = 4;
                            } else {
                                $GJ_Status = $iStatus;
                                $GJH_Status = 26;
                            }
                        }
                        //Chander
                        else {
                            $GJ_Status = $iStatus;
                            $GJH_Status = 11;
                        }
                        if ($GJ_Status == 2) {
                            if (($TotalDebit >= $ApproveMinLimit && $TotalDebit <= $ApproveMaxLimit) && ($TotalDebit < $ComplianceMinLimit) && ($ParentChartOfAccountsId != 2)) {
                                $GJ_Status = 4;
                                $GJH_Status = 4;
                            }
                        }
                        //$Status = 3;
                    } else if ($VoucherRole == 4 && ($iStatus == 1 || $iStatus == 3)) {
                        // AGM
                        if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanAuthorizeVoucher && $iStatus == 1) {
                            if ($TotalDebit >= $AuthorizeMinLimit && $TotalDebit <= $AuthorizeMaxLimit) {
                                $GJ_Status = 2;
                                $GJH_Status = 2;

                                if ($ParentChartOfAccountsId == 1) {
                                    if ($TotalDebit <= 100000000) {
                                        $GJ_Status = 4;
                                        $GJH_Status = 4;
                                    } else {
                                        $GJ_Status = 3;
                                    }
                                }
                            } else {
                                $GJ_Status = $iStatus;
                                $GJH_Status = 9;
                            }
                        } else if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanApproveVoucher && $iStatus == 3) {
                            if ($TotalDebit >= $ApproveMinLimit && $TotalDebit <= $ApproveMaxLimit) {
                                $GJ_Status = 4;
                                $GJH_Status = 4;
                            } else {
                                $GJ_Status = $iStatus;
                                $GJH_Status = 15;
                            }
                        } else {
                            $GJ_Status = $iStatus;
                            $GJH_Status = 16;
                        }
                    } else if ($VoucherRole == 5) {
                        // GM
                        $GJ_Status = 4;
                        $GJH_Status = 4;
                    } else if ($VoucherRole == 6) {
                        // CEO
                        $GJ_Status = 4;
                        $GJH_Status = 4;
                    }
                }
            }
        } else {
            $GJ_Status = 6;
            $GJH_Status = 6;
        }        

//        echo "GJ: " . $GJ_Status . " - GJH: " . $GJH_Status;        
//
        if ($lastInsertId) {           
            $Q_UpdateGJH = "update fms_accounts_generaljournal_history set ActionType='$GJH_Status' "
                    . " where HistoryId = '$lastInsertId'";
        } else {
            $Q_UpdateGJH = "update fms_accounts_generaljournal_history set ActionType='$GJH_Status' "
                    . " where  GeneralJournalId = '$gj_id' and ProcessBy='$user_id'";
        }
        
        $varResultGJH = $objDB_FIS->Execute($Q_UpdateGJH);
        $Q_UpdateGJ = "update fms_accounts_generaljournal set Status='$GJ_Status' "
                . "where GeneralJournalId = '$gj_id'";
        $varResult2 = $objDB_FIS->Execute($Q_UpdateGJ);        
        
        if ($varResult->rowCount()) {            
            $GJH_Result = $objDB_FIS->ExecQueryAll("select 
                GJH.*, concat(E.FirstName,' ',E.LastName) as 'FullName', E.Designation 
                from fms_accounts_generaljournal_history as GJH
                inner join fms_organization_employees as E on E.EmployeeId = gjh.ProcessBy   
                where  GJH.GeneralJournalId = '$gj_id'");
            if ($GJH_Result){
                $return = '
                <fieldset>
                    <legend>Current Voucher Status:</legend>
                    <div class="col-lg-12 panel panel-info" align="center">' . ($this->VouchersArray[$Status][0]) . '</div>
                </fieldset>                
                <fieldset>
                    <legend>Comments <span class="badge">' . (count($GJH_Result)) . '</span>:</legend>';
                foreach ($GJH_Result as $value){
                    $Comment = $value["ProcessComment"];
                    $ProcessTo = $value["ProcessTo"];
                    $IsProcessed = $value["IsProcessed"];
                    $ProcessBy = $value["ProcessBy"];
                    $CreatedOn = $value["CreatedOn"];
                    $Designation = $value["Designation"];
                    $FullName = $value["FullName"];
                    $return .= '
                    <div class="media col-md-12 mediastyle">
                        <div class="media-left">
                            <a href="#">
                                <img alt="64x64" class="media-object" data-src="holder.js/64x64" style="width: 64px; height: 64px;" src="../images/template/comment2.png" data-holder-rendered="true">
                            </a>
                        </div>
                        <div class="media-body">
                            <h5 class="media-heading"><strong>' . $FullName . '</strong> <span style="font-style:italic;">(' . $Designation . ')</span> ' . '</strong> ' . ($IsProcessed ? "<span style='color:" . $this->VouchersArray[$ActionType][1] . ";'>" . $this->VouchersArray[$ActionType][0] . "</span>" : "<span style='color:#C9302C;'>Reversed</span>") . ' On <strong>' . date("F j, Y g:i a", strtotime($CreatedOn)) . '</strong> :</h5>
                        ' . ($IsProcessed ? '<strong style="color:#449d44;">Comment</strong>' : '<strong style="color:#c9302c;">Query</strong>') . ':&nbsp;&nbsp;' . $Comment . '
                        </div>
                    </div>';
                }
            }
            $return .= '</fieldset>';
            return $return;
        } else {            
            return 0;
        }
    }

    private $StationsHirarchiArray;

    function getOfficeHirarchi($StationId) {
        global $objDB_FIS;
        $this->StationsHirarchiArray[$StationId] = $StationId;
        $varResult = $objDB_FIS->ExecQueryAll("SELECT S.StationId, S.StationName FROM organization_stations AS S WHERE S.Status='1' AND S.StationParentId = '$StationId' AND S.StationType!='4'");
        if ( $varResult ) {
            foreach ( $varResult as $varResult) {
                $StationId = $varResult["StationId"];
                $this->getOfficeHirarchi($StationId);
            }
        }
    }

    public function ShowAllPreparedVouchers($sSearch = "", $revStatus = "") {
        
        global $objGeneral;
        global $objEmployee;
        global $objDB_FIS_Rep;
        
        $iEmployeeId = $objEmployee->iEmployeeId;

        $iEmployeeStationId = $objEmployee->iEmployeeStationId;
        $iEmployeeStationsVoucher = $objEmployee->objEmployeeRoles->bEmployeeRole_CanCheckVoucherOffice;

        $sStationConditionVouchers = "";
        //print_r($iEmployeeStationsVoucher);
        //echo "<br>";
        if ($iEmployeeStationsVoucher) {
            $StationsToCondition = implode(",", $iEmployeeStationsVoucher);
            $sStationConditionVouchers = " AND (S.StationId IN ($StationsToCondition) OR (S.StationId = '$iEmployeeStationId')) ";
        } else {
            $sStationConditionVouchers = " AND S.StationId IN ($iEmployeeStationId) ";
        }
        
        $iEmployeeTypeId = $objEmployee->iEmployeeTypeId;



        $iVoucherAccess = $objEmployee->iVoucherAccess;
        if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[0] == 0) // View Disabled
            return('<br /><br /><div align="center">Sorry, Access Denied to this Area...</div><br /><br />');

        //die("Wait for a while, we are upgrading your system...!");
        
        $sSortBy = $objGeneral->fnGet("sortby");
        $sSortOrder = $objGeneral->fnGet("sortorder");
        $iShow = $objGeneral->fnGet("show");
        $iPage = $objGeneral->fnGet("page");
        if ($iPage == '')
            $iPage = 1;
        $sVoucherType = $objGeneral->fnGet("selVoucherType");
        $iStationId1 = $objGeneral->fnGet("selStation");
        $selVoucherStatus = $objGeneral->fnGet("selVoucherStatus");

        if ($iStationId1 > 0) {
            $sStationName = $objDB_FIS_Rep->ExecQueryCol("SELECT S.StationName FROM organization_stations AS S WHERE S.OrganizationId='" . cOrganizationId . "' AND S.Status='1' AND S.StationId='$iStationId1'");
            if ( !$sStationName )
                die('Sorry, Invalid StationId Id');
            $sTitle = "Vouchers from " . $sStationName;

            $sStationCondition = "AND S.StationId='$iStationId1' ";
        } else
            $sStationCondition = "";
        
        
        if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanProcessObservationVoucher) {
            $sGeneralJournalStatusCond = " GJ.Status = '6' ";
        }
        if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanCheckVoucher) {
            $sGeneralJournalStatusCond = " GJ.Status in (0) ";
            $sGeneralJournalStatusCond .= " AND GJ.TotalDebit BETWEEN '" . $objEmployee->objEmployeeRoles->bEmployeeRole_CanCheckVoucherAmountMin . "' AND '" . $objEmployee->objEmployeeRoles->bEmployeeRole_CanCheckVoucherAmountMax . "'  ";
        }
        if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanCheckVoucher && $objEmployee->objEmployeeRoles->bEmployeeRole_CanProcessObservationVoucher) {
            $sGeneralJournalStatusCond = " GJ.Status in (0, 6) ";
            $sGeneralJournalStatusCond .= " AND GJ.TotalDebit BETWEEN '" . $objEmployee->objEmployeeRoles->bEmployeeRole_CanCheckVoucherAmountMin . "' AND '" . $objEmployee->objEmployeeRoles->bEmployeeRole_CanCheckVoucherAmountMax . "'  ";
        }

        $sGeneralJournalStatusCond .= " AND GJ.TransactionDate>='2018-01-01' ";

        
        if ($sVoucherType != '0') {
            $sTitle = "General Journal as " . $sVoucherType;
            $sVoucherTypeString = " AND GJ.Reference Like '$sVoucherType%'";
        }
        if ($selVoucherStatus != "") {
            $sTitle = "General Journal as " . $this->VouchersArray[$selVoucherStatus][0];
            $sGeneralJournalStatusCond = " GJ.Status in ($selVoucherStatus) ";
            $sGeneralJournalStatusCond .= " AND GJ.TotalDebit BETWEEN '" . $objEmployee->objEmployeeRoles->bEmployeeRole_CanCheckVoucherAmountMin . "' AND '" . $objEmployee->objEmployeeRoles->bEmployeeRole_CanCheckVoucherAmountMax . "'  ";
        }

        
        //Advance Search
        $iView = $objGeneral->fnGet("view");
        if ($iView == 1) {
            $sAdnacedSearch_VoucherNumber = $objGeneral->fnGet("txtVoucherNumber");
            $sAdnacedSearch_TransactionDateFrom = $objGeneral->fnGet("txtTransactionDateFrom");
            $sAdnacedSearch_TransactionDateTo = $objGeneral->fnGet("txtTransactionDateTo");
            $sAdnacedSearch_Amount = $objGeneral->fnGet("txtAmount");

            if ($sAdnacedSearch_VoucherNumber != "")
                $sAdnacedSearchString = " AND (GJ.Reference = '$sAdnacedSearch_VoucherNumber')";
            if ($sAdnacedSearch_Amount != "")
                $sAdnacedSearchString .= " AND (GJ.TotalDebit = '$sAdnacedSearch_Amount' OR GJ.TotalCredit = '$sAdnacedSearch_Amount')";
            if (($sAdnacedSearch_TransactionDateFrom != ""))
                $sAdnacedSearchString .= " AND (GJ.TransactionDate = '$sAdnacedSearch_TransactionDateFrom')";
        }
        //End Advance Search

        $sTitle = "Prepared / UnChecked / Under Observational Vouchers";
        if ($sSortBy == "")
            $sSortBy = "GJ.GeneralJournalAddedOn DESC";

        if ($sSearch != "") {
//            $sSearch = mysql_real_escape_string($sSearch);
            $sSearchCondition = " AND ((GJ.Reference LIKE '%$sSearch%') OR (GJ.GeneralJournalId LIKE '%$sSearch%') OR (GJ.TransactionDate LIKE '%$sSearch%') OR (GJ.CheckNumber LIKE '%$sSearch%') OR (GJ.TotalDebit LIKE '%$sSearch%') OR (GJ.Description LIKE '%$sSearch%') OR (S.StationName LIKE '%$sSearch%'))";

            $sSearch = stripslashes($sSearch);
            $sTitle = 'Search Results for "' . $sSearch . '"';
        } else
            $sSearchCondition = $sAdnacedSearchString;

        //if($iEmployeeId != 1) $sEmployeeCondition = " AND GJ.GeneralJournalAddedBy = '$iEmployeeId'";
        //print_r($_SESSION);
        $iEmployeeStationId = $_SESSION['Employee_StationId'];
        if ($iEmployeeId != 1)
            $sStationCondition1 = " AND GJ.StationId = '$iEmployeeStationId'";
        if ($iEmployeeStationId == 232 || $iEmployeeStationId == 233) {
            $this->getOfficeHirarchi($iEmployeeStationId);
            $StationIds = implode(",", $this->StationsHirarchiArray);
            $sStationCondition1 = " AND S.StationId in ($StationIds)";
        }
        
        
        $MIS_Cond = " AND GJ.DepositSlipId <=> NULL AND GroupId <=> NULL ";
        $iTotalRecords = $objDB_FIS_Rep->ExecQueryCol("SELECT count(0) as total FROM fms_accounts_generaljournal AS GJ INNER JOIN fms_organization_employees AS E ON E.EmployeeId = GJ.GeneralJournalAddedBy INNER JOIN organization_stations AS S ON S.StationId = GJ.StationId where $sGeneralJournalStatusCond $sVoucherTypeString $sSearchCondition $MIS_Cond $sStationConditionVouchers");
        $sRefresh = '<a href="#noanchor" onclick="window.location=\'?show=' . $iShow . '&page=' . $iPage . '\';"><img src="../images/icons/iconRefresh.gif" border="0" alt="Refresh" title="Refresh" /></a>';
        $sPagingString = $objGeneral->Grid_GeneratePagingString($iPage, $iShow, $iTotalRecords, $sRefresh, $iPagingLimit, $iOffSet, $sCurrentURL);


        //$varResult = $objDatabase->Query("


        //$objDB_FIS = new clsConnect(cDatabaseHost, cDatabaseUser, cDatabasePassword, cDatabaseDatabase);

        //$Query = ;
        //if ($objEmployee->objEmployeeRoles->bEmployeeRole_CanProcessObservationVoucher) {
        //echo "<pre>$Query</pre>";
        //}
        $varResult = $objDB_FIS_Rep->ExecQueryAll("
		SELECT 
                GJ.GeneralJournalId, 
                GJ.StationId, 
                S.StationName, 
                GJ.EntryType, 
                GJ.Reference, 
                GJ.TotalDebit, 
                GJ.TotalCredit, 
                GJ.TransactionDate, 
                GJ.Status AS 'Status',
                GJ.GeneralJournalAddedOn                 
                FROM fms_accounts_generaljournal AS GJ
		INNER JOIN fms_organization_employees AS E ON E.EmployeeId = GJ.GeneralJournalAddedBy 
		INNER JOIN organization_stations AS S ON S.StationId = GJ.StationId 
		WHERE $sGeneralJournalStatusCond $sVoucherTypeString $sSearchCondition $MIS_Cond $sStationConditionVouchers ORDER BY $sSortBy $sSortOrder LIMIT $iOffSet,$iPagingLimit");
        
        //echo $iOffSet;
       // LIMIT $iOffSet, $iPagingLimit
//        echo "<pre>";
//        print_r($varResult);
//        die;
        $sReturn = '
		<table border="0" cellspacing="0" cellpadding="3" width="100%" align="center">
		 <tr>
		  <td colspan="2" align="left"><span class="heading">' . $sTitle . ' (' . $iTotalRecords . ' Records)</span></td>
		  <td colspan="2" align="right">' . $sPagingString . '</td>
		 </tr>
		</table>
		<table class="GridTable" border="1" cellspacing="0" cellpadding="3" width="100%" align="center">
		 <tr class="GridTR">		  
		  <td align="left"><span class="WhiteHeading">Type&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.EntryType&sortorder="><img src="../images/sort_up.gif" alt="Sort by Entry Type in Ascending Order" title="Sort by Entry Type in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.EntryType&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Entry Type in Descending Order" title="Sort by Entry Type in Descending Order" border="0" /></a></span></td>
		  <td align="left"><span class="WhiteHeading">Transaction Date&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.TransactionDate&sortorder="><img src="../images/sort_up.gif" alt="Sort by Transaction Date in Ascending Order" title="Sort by Transaction Date in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.TransactionDate&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Transacation Date in Descending Order" title="Sort by Transaction Date in Descending Order" border="0" /></a></span></td>
		  <td align="left"><span class="WhiteHeading">Reference&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.Reference&sortorder="><img src="../images/sort_up.gif" alt="Sort by Reference in Ascending Order" title="Sort by Reference in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.Reference&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Reference in Descending Order" title="Sort by Reference in Descending Order" border="0" /></a></span></td>
		  <td align="left"><span class="WhiteHeading">Offices&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=S.StationName&sortorder="><img src="../images/sort_up.gif" alt="Sort by Office in Ascending Order" title="Sort by Office in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=S.StationName&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Office in Descending Order" title="Sort by Office in Descending Order" border="0" /></a></span></td>
		  <td align="right"><span class="WhiteHeading">Amount&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.TotalDebit&sortorder="><img src="../images/sort_up.gif" alt="Sort by Transaction Amount in Ascending Order" title="Sort by Transaction Amount in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.TotalDebit&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Transaction Amount in Descending Order" title="Sort by Transaction Amount in Descending Order" border="0" /></a></span></td>
                      <td align="left"><span class="WhiteHeading">Status&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.Status&sortorder="><img src="../images/sort_up.gif" alt="Sort by Status in Ascending Order" title="Sort by Status in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.TotalDebit&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Status in Descending Order" title="Sort by Status in Descending Order" border="0" /></a></span></td>
		  <td width="6%" colspan="6"><span class="WhiteHeading">Operations</span></td>
		 </tr>';

        foreach ( $varResult as $varResult){
            $sTRBGColor = ($sTRBGColor == '#edeff1') ? '#ffffff' : '#edeff1';
//GJ.GeneralJournalId GJ.StationId S.StationName GJ.EntryType GJ.Reference GJ.TotalDebit GJ.TotalCredit GJ.TransactionDate GJ.GeneralJournalAddedOn
            $iGeneralJournalId = $varResult["GeneralJournalId"];
            $iStationId = $varResult["StationId"];
//            $Status = $varResult["Status"];
            $sStationName = $varResult["StationName"];
            $iEntryType = $varResult["EntryType"];
            $sEntryType = $this->aEntryType[$iEntryType];
            $sReference = $varResult["Reference"];
            $dTotalDebit = $varResult["TotalDebit"];
            $dTotalCredit = $varResult["TotalCredit"];
            $sTotalDebit = number_format($dTotalDebit, 2);
            $sTotalCredit = number_format($dTotalCredit, 2);
            $dTransactionDate = $varResult["TransactionDate"];
            $dAddedOn = $varResult["GeneralJournalAddedOn"];
            $sAddedOn = date("F j, Y", strtotime($dAddedOn));
            $sTransactionDate = date("F j, Y", strtotime($dTransactionDate));


            $iGJStatus = $varResult["Status"];
            $sStatus = $this->VouchersArray[$iGJStatus][0];

            if ($dTotalDebit == $dTotalCredit)
                $dTransactionAmount = $dTotalDebit;
            else
                $dTransactionAmount = 0;
            $sReviewGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="jsOpenWindow(\'../vouchers/?action=ProcessVoucher&id=' . $iGeneralJournalId . '&pStatus=' . $iGJStatus . '&pStatus=' . $iGJStatus . '\', 1024,760);"><img src="../images/icons/iconRight.gif" border="0" alt="Disbursment Cheque" title="Disbursment Cheque"></a></td>';
            $sUploadGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.CreateTab(\'tabContainer\', \'Uploads for ' . str_replace('"', '', $sReference) . '\', \'../accounts/generaljournal_details.php?action2=upload&id=' . $iGeneralJournalId . '\', \'520px\', true);"><img src="../images/icons/clip.gif" border="0" alt="General Journal Document Details" title="General Journal Document Details"></a></td>';
            $sEditGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.CreateTab(\'tabContainer\', \'Update ' . str_replace('"', '', $sReference) . '\', \'../accounts/generaljournal_details.php?action2=edit&id=' . $iGeneralJournalId . '\', \'520px\', true);"><img src="../images/icons/iconEdit.gif" border="0" alt="Edit this General Journal Entry Details" title="Edit this General Journal Entry Details"></a></td>';
            $sDeleteGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="if(confirm(\'Do you really want to delete this General Journal Entry?\')) {window.location = \'?action=DeleteGeneralJournal&id=' . $iGeneralJournalId . '\';}"><img src="../images/icons/iconDelete.gif" border="0" alt="Delete this General Journal Entry" title="Delete this General Journal Entry"></a></td>';

            $sUploadGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.CreateTab(\'tabContainer\', \'Uploads for ' . str_replace('"', '', $sReference) . '\', \'../filemanager/dialog.php?action2=upload&id=' . $iGeneralJournalId . '&trans_date=' . $dTransactionDate . '\', \'520px\', true);"><img src="../images/icons/clip.gif" border="0" alt="General Journal Document Details" title="General Journal Document Details"></a></td>';

            if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[2] == 0)
                $sEditGeneralJournal = '';
            if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[3] == 0)
                $sDeleteGeneralJournal = '';

            $sReceipt = '<td class="GridTD" align="center"><a href="#noanchor" onclick="jsOpenWindow(\'../reports/showreport.php?report=AccountsReports&reporttype=GeneralJournalReceipt&selEmployee=-1&selStation=-1&id=' . $iGeneralJournalId . '&txtReference=' . $sReference . '\', 800,600);"><img src="../images/icons/iconPrint2.gif" border="0" alt="Receipt" title="Receipt"></a></td>';

            $sDisbursmentCheque = '<td class="GridTD" align="center"><a href="#noanchor" onclick="jsOpenWindow(\'../reports/loans_disbursement_printreports.php?report=AccountsReports&reporttype=GeneralJournalReceipt&selEmployee=-1&selStation=-1&id=' . $iGeneralJournalId . '&txtReference=' . $sReference . '\', 800,600);"><img src="../images/icons/iconCheques.gif" border="0" alt="Disbursment Cheque" title="Disbursment Cheque"></a></td>';

            $sDocuments = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.MOOdalBox.open(\'../common/documents_show.php?componentname=Accounts_GeneralJournal&id=' . $iGeneralJournalId . '\', \'Documents of ' . str_replace('"', '', $sReference) . '\', \'700 420\');"><img src="../images/icons/iconImages.gif" border="0" alt="General Journal Documents" title="General Journal Documents"></a></td>';

            if (strtolower(cAllowEditDeleteTransactions) != 'yes')
                $sEditGeneralJournal = $sDeleteGeneralJournal = '<td>&nbsp;</td>';

            $sChangeStatus = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.MOOdalBox.open(\'../common/status_show.php?componentname=Accounts_GeneralJournal&id=' . $iGeneralJournalId . '\', \'Status Update for ' . str_replace('"', '', $sReference) . '\', \'700 420\');"><img src="../images/icons/tick.gif" border="0" alt="Update Status" title="Update Status"></a></td>';

            $sChangeStatus = '';
            //if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournal_Documents[0] == 0) // View Disabled
            //	$sDocuments = '<td>&nbsp;</td>';
            
//            echo '--'.$this->VouchersArray[$iGJStatus][1].'<br>';
//            echo '---'.$this->VouchersArray[$iGJStatus][0].'<br>';
//            exit();
            

            $sReturn .= '
                <tr onMouseOver="bgColor=\'#ffe69c\';" onMouseOut="bgColor=\'' . $sTRBGColor . '\';" bgcolor="' . $sTRBGColor . '">			 
                 <td class="GridTD" align="left" valign="top">' . $sEntryType . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
                 <td class="GridTD" align="left" valign="top">' . $sTransactionDate . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
                 <td class="GridTD" align="left" valign="top">' . $sReference . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
                 <td class="GridTD" align="left" valign="top">' . $sStationName . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
                 <td class="GridTD" align="right" valign="top">' . number_format($dTransactionAmount, 0) . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
                 <td class="GridTD" align="left" valign="top"><span style="color:' . ($this->VouchersArray[$iGJStatus][1]) . ';">' . ($this->VouchersArray[$iGJStatus][0]) . '</span><img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
                 <td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.CreateTab(\'tabContainer\', \'General Jouranl Entry Details\', \'../accounts/generaljournal_details.php?id=' . $iGeneralJournalId . '\', \'520px\', true);"><img src="../images/icons/iconDetails.gif" border="0" alt="View this General Journal Entry Details" title="View this General Journal Entry Details"></a></td>
                 ' . $sEditGeneralJournal . $sReviewGeneralJournal . $sUploadGeneralJournal . $sReceipt . $sDeleteGeneralJournal . '
                </tr>';
            }

        //$sStationSelect = '<select class="form1" name="selStation" onchange="window.location=\'?StationId=\'+GetSelectedListBox(\'selStation\');" id="selStation">
        $sStationSelect = '<select class="form1" name="selStation" onchange="document.frm.submit();" id="selStation">
		<option value="0">All Offices</option>';
        $varResult = $objDB_FIS_Rep->ExecQueryAll("SELECT S.StationId,S.StationName FROM organization_stations AS S WHERE  S.Status='1' AND S.OrganizationId='" . cOrganizationId . "' ORDER BY S.StationName");
        foreach ( $varResult as $varResult)
            $sStationSelect .= '<option ' . (($iStationId1 == $varResult["StationId"]) ? 'selected="true"' : '') . ' value="' . $varResult["StationId"] . '">' . $varResult["StationName"] . '</option>';
        $sStationSelect .= '</select>';

        $sVoucherStatusSelect = '<select class="form1" name="selVoucherStatus" onchange="document.frm.submit();" id="selVoucherStatus">';
        $sVoucherStatusSelect .= '<option value="">Select Voucher Status</option>';
        for ($i = 0; $i < count($this->VouchersArray); $i++)
            $sVoucherStatusSelect .= '<option ' . ($selVoucherStatus != "" ? (($i == $selVoucherStatus) ? 'selected="true"' : '') : "") . ' value="' . $i . '">' . ($this->VouchersArray[$i][0]) . '</option>';
        $sVoucherStatusSelect .= '</select>';


        //$sprams = ;
        //$sVoucherTypeSelect = '<select class="form1" name="selVoucherType" onchange="window.location=\'?vouchertype=\'+GetSelectedListBox(\'selVoucherType\');" id="selVoucherType">';
        $sVoucherTypeSelect = '<select class="form1" name="selVoucherType" onchange="document.frm.submit();" id="selVoucherType">';
        $sVoucherTypeSelect .= '<option value="0">Voucher Type</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'BPV') ? 'selected="true"' : '') . ' value="BPV">BPV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'BRV') ? 'selected="true"' : '') . ' value="BRV">BRV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'CPV') ? 'selected="true"' : '') . ' value="CPV">CPV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'CRV') ? 'selected="true"' : '') . ' value="CRV">CRV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'JV') ? 'selected="true"' : '') . ' value="JV">JV</option>';
        $sVoucherTypeSelect .= '</select>';



        $sAddGeneralJournal = '<input onclick="window.top.CreateTab(\'tabContainer\', \'Add New Entry\', \'../accounts/generaljournal_details.php?action2=addnew\', \'520px\', true);" type="button" class="AdminFormButton1" value="Add New">';

        if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[1] == 0)
            $sAddGeneralJournal = '';

        $sReturn .= '</table>
		<table border="0" cellspacing="0" cellpadding="3" width="100%" align="center">
		 <tr>
		  <td>
 		   <form method="GET" action=""><label>Search:</label><br><input type="text" class="form1" size="45" name="p" id="p" />&nbsp;<input type="image" src="../images/icons/search.gif" alt="Search for General Journal Entry" title="Search for General Journal Entry" border="0">
		  &nbsp;</td>
		  <td height="40" colspan="2" align="right">' . $sPagingString . '</td>
		  </form>
		 </tr>
		 <tr>
		  <td>
		   <form method="GET" name="frm" id="frm"> ' . $sStationSelect . ' ' . $sVoucherTypeSelect . ' ' . $sVoucherStatusSelect . '</form>
		  </td>
		 </tr>		
		</table>';

        return($sReturn);
    }

    public function ShowAllCheckedVouchers($id) {
        global $objDatabase;
        global $objGeneral;
        global $objEmployee;
        global $objDB_FIS;
        // Employee Roles
        $iEmployeeId = $objEmployee->iEmployeeId;
        $iEmployeeTypeId = $objEmployee->iEmployeeTypeId;
        $iEmployeeStationId = $objEmployee->iEmployeeStationId;


        if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[0] == 0) // View Disabled
            return('<br /><br /><div align="center">Sorry, Access Denied to this Area...</div><br /><br />');

        $iEmployeeStationsVoucher = $objEmployee->objEmployeeRoles->bEmployeeRole_CanAuthorizeVoucherOffice;

        $sStationConditionVouchers = "";
        //print_r($iEmployeeStationsVoucher);
        //echo "<br>";
        if ($iEmployeeStationsVoucher) {
            $StationsToCondition = implode(",", $iEmployeeStationsVoucher);
            $sStationConditionVouchers = " AND (S.StationId IN ($StationsToCondition) OR (S.StationId = '$iEmployeeStationId')) ";
        } else {
            $sStationConditionVouchers = " AND S.StationId IN ($iEmployeeStationId) ";
        }


        //die("Wait for a while, we are upgrading your system...!");

        $sSortBy = $objGeneral->fnGet("sortby");
        $sSortOrder = $objGeneral->fnGet("sortorder");
        $iShow = $objGeneral->fnGet("show");
        $iPage = $objGeneral->fnGet("page");
        if ($iPage == '')
            $iPage = 1;
        $sVoucherType = $objGeneral->fnGet("selVoucherType");
        $iStationId1 = $objGeneral->fnGet("selStation");

        if ($iStationId1 > 0) {
            $varResult = $objDB_FIS->ExecQueryRow("SELECT S.StationName FROM organization_stations AS S WHERE S.OrganizationId='" . cOrganizationId . "' AND S.Status='1' AND S.StationId='$iStationId1'");
            if ( !$varResult )
                die('Sorry, Invalid StationId Id');
            $sStationName = $varResult["StationName"];
            $sTitle = "Vouchers from " . $sStationName;
            $sStationCondition = "AND S.StationId='$iStationId1' ";
        } else
            $sStationCondition = "";

        $sGeneralJournalStatusCond = "GJ.Status=1 ";
        $sGeneralJournalStatusCond .= " AND GJ.TotalDebit BETWEEN '" . $objEmployee->objEmployeeRoles->bEmployeeRole_CanAuthorizeVoucherAmountMin . "' AND '" . $objEmployee->objEmployeeRoles->bEmployeeRole_CanAuthorizeVoucherAmountMax . "'  ";
        $sGeneralJournalStatusCond .= " AND GJ.TransactionDate>='2018-01-01' ";
        if ($sVoucherType != '0') {
            $sTitle = "General Journal as " . $sVoucherType;
            $sVoucherTypeString = " AND GJ.Reference Like '$sVoucherType%'";
        }

        //Advance Search
        $iView = $objGeneral->fnGet("view");
        if ($iView == 1) {
            $sAdnacedSearch_VoucherNumber = $objGeneral->fnGet("txtVoucherNumber");
            $sAdnacedSearch_TransactionDateFrom = $objGeneral->fnGet("txtTransactionDateFrom");
            $sAdnacedSearch_TransactionDateTo = $objGeneral->fnGet("txtTransactionDateTo");
            $sAdnacedSearch_Amount = $objGeneral->fnGet("txtAmount");

            if ($sAdnacedSearch_VoucherNumber != "")
                $sAdnacedSearchString = " AND (GJ.Reference = '$sAdnacedSearch_VoucherNumber')";
            if ($sAdnacedSearch_Amount != "")
                $sAdnacedSearchString .= " AND (GJ.TotalDebit = '$sAdnacedSearch_Amount' OR GJ.TotalCredit = '$sAdnacedSearch_Amount')";
            if (($sAdnacedSearch_TransactionDateFrom != ""))
                $sAdnacedSearchString .= " AND (GJ.TransactionDate = '$sAdnacedSearch_TransactionDateFrom')";
        }
        //End Advance Search

        $sTitle = "Checked / UnAuthorized Vouchers";
        if ($sSortBy == "")
            $sSortBy = "GJ.GeneralJournalAddedOn DESC";

        if ($sSearch != "") {
//            $sSearch = mysql_real_escape_string($sSearch);
            $sSearchCondition = " AND ((GJ.Reference LIKE '%$sSearch%') OR (GJ.GeneralJournalId LIKE '%$sSearch%') OR (GJ.TransactionDate LIKE '%$sSearch%') OR (GJ.CheckNumber LIKE '%$sSearch%') OR (GJ.TotalDebit LIKE '%$sSearch%') OR (GJ.Description LIKE '%$sSearch%') OR (S.StationName LIKE '%$sSearch%'))";

            $sSearch = stripslashes($sSearch);
            $sTitle = 'Search Results for "' . $sSearch . '"';
        } else
            $sSearchCondition = $sAdnacedSearchString;

        //if($iEmployeeId != 1) $sEmployeeCondition = " AND GJ.GeneralJournalAddedBy = '$iEmployeeId'";
        //print_r($_SESSION);
        $iEmployeeStationId = $_SESSION['Employee_StationId'];
        if ($iEmployeeId != 1)
            $sStationCondition1 = " AND GJ.StationId = '$iEmployeeStationId'";

        $iTotalRecords = $objDB_FIS->ExecQueryCol("SELECT count(0) FROM fms_accounts_generaljournal AS GJ INNER JOIN fms_organization_employees AS E ON E.EmployeeId = GJ.GeneralJournalAddedBy INNER JOIN organization_stations AS S ON S.StationId = GJ.StationId", " $sGeneralJournalStatusCond $sVoucherTypeString $sSearchCondition $sStationConditionVouchers");
        $sRefresh = '<a href="#noanchor" onclick="window.location=\'?show=' . $iShow . '&page=' . $iPage . '\';"><img src="../images/icons/iconRefresh.gif" border="0" alt="Refresh" title="Refresh" /></a>';
        $sPagingString = $objGeneral->Grid_GeneratePagingString($iPage, $iShow, $iTotalRecords, $sRefresh, $iPagingLimit, $iOffSet, $sCurrentURL);


//        echo "<pre>
//		SELECT 
//                GJ.GeneralJournalId, 
//                GJ.StationId, 
//                S.StationName, 
//                GJ.EntryType, 
//                GJ.Reference, 
//                GJ.TotalDebit, 
//                GJ.TotalCredit, 
//                GJ.TransactionDate, 
//                GJ.Status,
//                GJ.GeneralJournalAddedOn                 
//                FROM fms_accounts_generaljournal AS GJ
//		INNER JOIN fms_organization_employees AS E ON E.EmployeeId = GJ.GeneralJournalAddedBy
//		INNER JOIN organization_stations AS S ON S.StationId = GJ.StationId
//		WHERE  $sGeneralJournalStatusCond $sStationCondition1 $sVoucherTypeString $sStationCondition $sStationCondition1 $sSearchCondition
//		ORDER BY $sSortBy $sSortOrder
//		LIMIT $iOffSet, $iPagingLimit</pre>";
        //$varResult = $objDatabase->Query("
        $Query = "
		SELECT 
                GJ.GeneralJournalId, 
                GJ.StationId, 
                S.StationName, 
                GJ.EntryType, 
                GJ.Reference, 
                GJ.TotalDebit, 
                GJ.TotalCredit, 
                GJ.TransactionDate, 
                GJ.Status,
                GJ.GeneralJournalAddedOn                 
                FROM fms_accounts_generaljournal AS GJ
		INNER JOIN fms_organization_employees AS E ON E.EmployeeId = GJ.GeneralJournalAddedBy
		INNER JOIN organization_stations AS S ON S.StationId = GJ.StationId
		WHERE  $sGeneralJournalStatusCond $sVoucherTypeString $sSearchCondition $sStationConditionVouchers 
		ORDER BY $sSortBy $sSortOrder
		LIMIT $iOffSet, $iPagingLimit";


        // echo "<pre>$Query</pre>";
        $varResult = $objDB_FIS->ExecQueryAll($Query);
        $sReturn = '
		<table border="0" cellspacing="0" cellpadding="3" width="100%" align="center">
		 <tr>
		  <td colspan="2" align="left"><span class="heading">' . $sTitle . ' (' . $iTotalRecords . ' Records)</span></td>
		  <td colspan="2" align="right">' . $sPagingString . '</td>
		 </tr>
		</table>
		<table class="GridTable" border="1" cellspacing="0" cellpadding="3" width="100%" align="center">
		 <tr class="GridTR">		  
		  <td align="left"><span class="WhiteHeading">Type&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.EntryType&sortorder="><img src="../images/sort_up.gif" alt="Sort by Entry Type in Ascending Order" title="Sort by Entry Type in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.EntryType&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Entry Type in Descending Order" title="Sort by Entry Type in Descending Order" border="0" /></a></span></td>
		  <td align="left"><span class="WhiteHeading">Transaction Date&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.TransactionDate&sortorder="><img src="../images/sort_up.gif" alt="Sort by Transaction Date in Ascending Order" title="Sort by Transaction Date in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.TransactionDate&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Transacation Date in Descending Order" title="Sort by Transaction Date in Descending Order" border="0" /></a></span></td>
		  <td align="left"><span class="WhiteHeading">Reference&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.Reference&sortorder="><img src="../images/sort_up.gif" alt="Sort by Reference in Ascending Order" title="Sort by Reference in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.Reference&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Reference in Descending Order" title="Sort by Reference in Descending Order" border="0" /></a></span></td>
		  <td align="left"><span class="WhiteHeading">Offices&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=S.StationName&sortorder="><img src="../images/sort_up.gif" alt="Sort by Office in Ascending Order" title="Sort by Office in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=S.StationName&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Office in Descending Order" title="Sort by Office in Descending Order" border="0" /></a></span></td>
		  <td align="right"><span class="WhiteHeading">Amount&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.TotalDebit&sortorder="><img src="../images/sort_up.gif" alt="Sort by Transaction Amount in Ascending Order" title="Sort by Transaction Amount in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.TotalDebit&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Transaction Amount in Descending Order" title="Sort by Transaction Amount in Descending Order" border="0" /></a></span></td>
                      <td align="left"><span class="WhiteHeading">Status&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.Status&sortorder="><img src="../images/sort_up.gif" alt="Sort by Status in Ascending Order" title="Sort by Status in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.TotalDebit&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Status in Descending Order" title="Sort by Status in Descending Order" border="0" /></a></span></td>
		  <td width="6%" colspan="6"><span class="WhiteHeading">Operations</span></td>
		 </tr>';

        foreach ( $varResult as $varResult ) {
            $sTRBGColor = ($sTRBGColor == '#edeff1') ? '#ffffff' : '#edeff1';
//GJ.GeneralJournalId GJ.StationId S.StationName GJ.EntryType GJ.Reference GJ.TotalDebit GJ.TotalCredit GJ.TransactionDate GJ.GeneralJournalAddedOn
            $iGeneralJournalId = $varResult["GeneralJournalId"];
            $iStationId = $varResult["StationId"];
            $iGJStatus = $varResult["Status"];
            $sStatus = $this->VouchersArray[$iGJStatus][0];
            $sStationName = $varResult["StationName"];
            $iEntryType = $varResult["EntryType"];
            $sEntryType = $this->aEntryType[$iEntryType];
            $sReference = $varResult["Reference"];
            $dTotalDebit = $varResult["TotalDebit"];
            $dTotalCredit = $varResult["TotalCredit"];
            $sTotalDebit = number_format($dTotalDebit, 2);
            $sTotalCredit = number_format($dTotalCredit, 2);
            $dTransactionDate = $varResult["TransactionDate"];
            $dAddedOn = $varResult["GeneralJournalAddedOn"];
            $sAddedOn = date("F j, Y", strtotime($dAddedOn));
            $sTransactionDate = date("F j, Y", strtotime($dTransactionDate));
            $iGJStatus = $varResult["Status"];
            $sStatus = $this->VouchersArray[$iGJStatus][0];

            if ($dTotalDebit == $dTotalCredit)
                $dTransactionAmount = $dTotalDebit;
            else
                $dTransactionAmount = 0;
            $sReviewGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="jsOpenWindow(\'../vouchers/?action=ProcessVoucher&id=' . $iGeneralJournalId . '&pStatus=' . $iGJStatus . '\', 1024,760);"><img src="../images/icons/iconRight.gif" border="0" alt="Disbursment Cheque" title="Disbursment Cheque"></a></td>';

            $sUploadGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.CreateTab(\'tabContainer\', \'Uploads for ' . str_replace('"', '', $sReference) . '\', \'../accounts/generaljournal_details.php?action2=upload&id=' . $iGeneralJournalId . '\', \'520px\', true);"><img src="../images/icons/clip.gif" border="0" alt="General Journal Document Details" title="General Journal Document Details"></a></td>';
            $sEditGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.CreateTab(\'tabContainer\', \'Update ' . str_replace('"', '', $sReference) . '\', \'../accounts/generaljournal_details.php?action2=edit&id=' . $iGeneralJournalId . '\', \'520px\', true);"><img src="../images/icons/iconEdit.gif" border="0" alt="Edit this General Journal Entry Details" title="Edit this General Journal Entry Details"></a></td>';
            $sDeleteGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="if(confirm(\'Do you really want to delete this General Journal Entry?\')) {window.location = \'?action=DeleteGeneralJournal&id=' . $iGeneralJournalId . '\';}"><img src="../images/icons/iconDelete.gif" border="0" alt="Delete this General Journal Entry" title="Delete this General Journal Entry"></a></td>';
            if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[2] == 0)
                $sEditGeneralJournal = '';
            if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[3] == 0)
                $sDeleteGeneralJournal = '';

            $sReceipt = '<td class="GridTD" align="center"><a href="#noanchor" onclick="jsOpenWindow(\'../reports/showreport.php?report=AccountsReports&reporttype=GeneralJournalReceipt&selEmployee=-1&selStation=-1&id=' . $iGeneralJournalId . '&txtReference=' . $sReference . '\', 800,600);"><img src="../images/icons/iconPrint2.gif" border="0" alt="Receipt" title="Receipt"></a></td>';

            $sDisbursmentCheque = '<td class="GridTD" align="center"><a href="#noanchor" onclick="jsOpenWindow(\'../reports/loans_disbursement_printreports.php?report=AccountsReports&reporttype=GeneralJournalReceipt&selEmployee=-1&selStation=-1&id=' . $iGeneralJournalId . '&txtReference=' . $sReference . '\', 800,600);"><img src="../images/icons/iconCheques.gif" border="0" alt="Disbursment Cheque" title="Disbursment Cheque"></a></td>';

            $sDocuments = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.MOOdalBox.open(\'../common/documents_show.php?componentname=Accounts_GeneralJournal&id=' . $iGeneralJournalId . '\', \'Documents of ' . str_replace('"', '', $sReference) . '\', \'700 420\');"><img src="../images/icons/save.gif" border="0" alt="General Journal Documents" title="General Journal Documents"></a></td>';

            if (strtolower(cAllowEditDeleteTransactions) != 'yes')
                $sEditGeneralJournal = $sDeleteGeneralJournal = '<td>&nbsp;</td>';

            $sChangeStatus = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.MOOdalBox.open(\'../common/status_show.php?componentname=Accounts_GeneralJournal&id=' . $iGeneralJournalId . '\', \'Status Update for ' . str_replace('"', '', $sReference) . '\', \'700 420\');"><img src="../images/icons/tick.gif" border="0" alt="Update Status" title="Update Status"></a></td>';

            //if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournal_Documents[0] == 0) // View Disabled
            //	$sDocuments = '<td>&nbsp;</td>';

            $sReturn .= '
			<tr onMouseOver="bgColor=\'#ffe69c\';" onMouseOut="bgColor=\'' . $sTRBGColor . '\';" bgcolor="' . $sTRBGColor . '">			 
			 <td class="GridTD" align="left" valign="top">' . $sEntryType . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="left" valign="top">' . $sTransactionDate . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="left" valign="top">' . $sReference . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="left" valign="top">' . $sStationName . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="right" valign="top">' . number_format($dTransactionAmount, 0) . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
                             <td class="GridTD" align="left" valign="top"><span style="color:' . ($this->VouchersArray[$iGJStatus][1]) . ';">' . ($this->VouchersArray[$iGJStatus][0]) . '</span><img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.CreateTab(\'tabContainer\', \'General Jouranl Entry Details\', \'../accounts/generaljournal_details.php?id=' . $iGeneralJournalId . '\', \'520px\', true);"><img src="../images/icons/iconDetails.gif" border="0" alt="View this General Journal Entry Details" title="View this General Journal Entry Details"></a></td>
			 ' . $sEditGeneralJournal . $sReviewGeneralJournal . $sUploadGeneralJournal . $sReceipt . $sDeleteGeneralJournal . '
			</tr>';
        }

        //$sStationSelect = '<select class="form1" name="selStation" onchange="window.location=\'?StationId=\'+GetSelectedListBox(\'selStation\');" id="selStation">
        $sStationSelect = '<select class="form1" name="selStation" onchange="document.frm.submit();" id="selStation">
		<option value="0">All Offices</option>';
        $varResult = $objDB_FIS->ExecQueryAll("SELECT S.StationId,S.StationName FROM organization_stations AS S WHERE  S.Status='1' AND S.OrganizationId='" . cOrganizationId . "' ORDER BY S.StationName");
        foreach ( $varResult as $varResult)
            $sStationSelect .= '<option ' . (($iStationId1 == $varResult["StationId"]) ? 'selected="true"' : '') . ' value="' . $varResult["StationId"] . '">' . $varResult["StationName"] . '</option>';
        $sStationSelect .= '</select>';

        //$sprams = ;
        //$sVoucherTypeSelect = '<select class="form1" name="selVoucherType" onchange="window.location=\'?vouchertype=\'+GetSelectedListBox(\'selVoucherType\');" id="selVoucherType">';
        $sVoucherTypeSelect = '<select class="form1" name="selVoucherType" onchange="document.frm.submit();" id="selVoucherType">';
        $sVoucherTypeSelect .= '<option value="0">Voucher Type</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'BPV') ? 'selected="true"' : '') . ' value="BPV">BPV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'BRV') ? 'selected="true"' : '') . ' value="BRV">BRV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'CPV') ? 'selected="true"' : '') . ' value="CPV">CPV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'CRV') ? 'selected="true"' : '') . ' value="CRV">CRV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'JV') ? 'selected="true"' : '') . ' value="JV">JV</option>';
        $sVoucherTypeSelect .= '</select>';

        $sAddGeneralJournal = '<input onclick="window.top.CreateTab(\'tabContainer\', \'Add New Entry\', \'../accounts/generaljournal_details.php?action2=addnew\', \'520px\', true);" type="button" class="AdminFormButton1" value="Add New">';

        if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[1] == 0)
            $sAddGeneralJournal = '';

        $sReturn .= '</table>
		<table border="0" cellspacing="0" cellpadding="3" width="100%" align="center">
		 <tr>
		  <td>
 		   <form method="GET" action=""><label>Search:</label><br><input type="text" class="form1" size="45" name="p" id="p" />&nbsp;<input type="image" src="../images/icons/search.gif" alt="Search for General Journal Entry" title="Search for General Journal Entry" border="0">
		  &nbsp;</td>
		  <td height="40" colspan="2" align="right">' . $sPagingString . '</td>
		  </form>
		 </tr>
		 <tr>
		  <td>
		   <form method="GET" name="frm" id="frm"> ' . $sStationSelect . ' ' . $sVoucherTypeSelect . '</form>
		  </td>
		 </tr>		
		</table>';

        return($sReturn);
    }

    public function ShowAllAuthorizedVouchers($id) {
//        die("OKKK");
        global $objDatabase;
        global $objGeneral;
        global $objEmployee;
        global $objDB_FIS;
        // Employee Roles
        $iEmployeeId = $objEmployee->iEmployeeId;
        $iEmployeeTypeId = $objEmployee->iEmployeeTypeId;
        $iEmployeeStationId = $objEmployee->iEmployeeStationId;

        if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[0] == 0) // View Disabled
            return('<br /><br /><div align="center">Sorry, Access Denied to this Area...</div><br /><br />');

        $iEmployeeStationsVoucher = $objEmployee->objEmployeeRoles->bEmployeeRole_CanComplianceVoucherOffice;
        $sStationConditionVouchers = "";
        //print_r($iEmployeeStationsVoucher);
        //echo "<br>";
        if ($iEmployeeStationsVoucher) {
            $StationsToCondition = implode(",", $iEmployeeStationsVoucher);
            $sStationConditionVouchers = " AND (S.StationId IN ($StationsToCondition) OR (S.StationId = '$iEmployeeStationId')) ";
        } else {
            $sStationConditionVouchers = " AND S.StationId IN ($iEmployeeStationId) ";
        }

        //die("Wait for a while, we are upgrading your system...!");

        $sSortBy = $objGeneral->fnGet("sortby");
        $sSortOrder = $objGeneral->fnGet("sortorder");
        $iShow = $objGeneral->fnGet("show");
        $iPage = $objGeneral->fnGet("page");
        if ($iPage == '')
            $iPage = 1;
        $sVoucherType = $objGeneral->fnGet("selVoucherType");
        $iStationId1 = $objGeneral->fnGet("selStation");

        if ($iStationId1){
            $varResult = $objDB_FIS->ExecQueryCol("SELECT S.StationName FROM organization_stations AS S WHERE S.OrganizationId='" . cOrganizationId . "' AND S.Status='1' AND S.StationId='$iStationId1'");
            if ( !$varResult )
                die('Sorry, Invalid StationId Id');
            $sStationName = $varResult["StationName"];
            $sTitle = "Vouchers from " . $sStationName;

            $sStationCondition = "AND S.StationId='$iStationId1' ";
        } else
            $sStationCondition = "";
        $sGeneralJournalStatusCond = "GJ.Status=2 ";
        //$sGeneralJournalStatusCond .= " AND ( (GJ.TotalDebit BETWEEN '" . $objEmployee->objEmployeeRoles->bEmployeeRole_CanComplianceVoucherAmountMin . "' AND '" . $objEmployee->objEmployeeRoles->bEmployeeRole_CanComplianceVoucherAmountMax . "') OR () )  ";
        $sGeneralJournalStatusCond .= " AND GJ.TransactionDate>='2018-01-01' ";
        if ($sVoucherType != '0') {
            $sTitle = "General Journal as " . $sVoucherType;
            $sVoucherTypeString = " AND GJ.Reference Like '$sVoucherType%'";
        }

        //Advance Search
        $iView = $objGeneral->fnGet("view");
        if ($iView == 1) {
            $sAdnacedSearch_VoucherNumber = $objGeneral->fnGet("txtVoucherNumber");
            $sAdnacedSearch_TransactionDateFrom = $objGeneral->fnGet("txtTransactionDateFrom");
            $sAdnacedSearch_TransactionDateTo = $objGeneral->fnGet("txtTransactionDateTo");
            $sAdnacedSearch_Amount = $objGeneral->fnGet("txtAmount");

            if ($sAdnacedSearch_VoucherNumber != "")
                $sAdnacedSearchString = " AND (GJ.Reference = '$sAdnacedSearch_VoucherNumber')";
            if ($sAdnacedSearch_Amount != "")
                $sAdnacedSearchString .= " AND (GJ.TotalDebit = '$sAdnacedSearch_Amount' OR GJ.TotalCredit = '$sAdnacedSearch_Amount')";
            if (($sAdnacedSearch_TransactionDateFrom != ""))
                $sAdnacedSearchString .= " AND (GJ.TransactionDate = '$sAdnacedSearch_TransactionDateFrom')";
        }
        //End Advance Search

        $sTitle = "Authorized / UnComplianced Vouchers";
        if ($sSortBy == "")
            $sSortBy = "GJ.GeneralJournalAddedOn DESC";

        if ($sSearch != "") {
//            $sSearch = mysql_real_escape_string($sSearch);
            $sSearchCondition = " AND ((GJ.Reference LIKE '%$sSearch%') OR (GJ.GeneralJournalId LIKE '%$sSearch%') OR (GJ.TransactionDate LIKE '%$sSearch%') OR (GJ.CheckNumber LIKE '%$sSearch%') OR (GJ.TotalDebit LIKE '%$sSearch%') OR (GJ.Description LIKE '%$sSearch%') OR (S.StationName LIKE '%$sSearch%'))";

            $sSearch = stripslashes($sSearch);
            $sTitle = 'Search Results for "' . $sSearch . '"';
        } else
            $sSearchCondition = $sAdnacedSearchString;

        //if($iEmployeeId != 1) $sEmployeeCondition = " AND GJ.GeneralJournalAddedBy = '$iEmployeeId'";
        //print_r($_SESSION);
        $iEmployeeStationId = $_SESSION['Employee_StationId'];
        if ($iEmployeeId != 1)
            $sStationCondition1 = " AND GJ.StationId = '$iEmployeeStationId'";

        $iTotalRecords = $objDB_FIS->ExecQueryCol("SELECT count(0) FROM fms_accounts_generaljournal AS GJ INNER JOIN fms_organization_employees AS E ON E.EmployeeId = GJ.GeneralJournalAddedBy INNER JOIN organization_stations AS S ON S.StationId = GJ.StationId WHERE $sGeneralJournalStatusCond $sVoucherTypeString $sSearchCondition $sStationConditionVouchers ");
//        echo "<br>";
//        print_r($iTotalRecords);
//        die("GGGGG");
        $sRefresh = '<a href="#noanchor" onclick="window.location=\'?show=' . $iShow . '&page=' . $iPage . '\';"><img src="../images/icons/iconRefresh.gif" border="0" alt="Refresh" title="Refresh" /></a>';
        $sPagingString = $objGeneral->Grid_GeneratePagingString($iPage, $iShow, $iTotalRecords, $sRefresh, $iPagingLimit, $iOffSet, $sCurrentURL);


        //$varResult = $objDatabase->Query("
        $Query = "
		SELECT 
                GJ.GeneralJournalId, 
                GJ.StationId, 
                S.StationName, 
                GJ.EntryType, 
                GJ.Reference, 
                GJ.TotalDebit, 
                GJ.TotalCredit, 
                GJ.TransactionDate, 
                GJ.Status,
                GJ.GeneralJournalAddedOn                 
                FROM fms_accounts_generaljournal AS GJ
		INNER JOIN fms_organization_employees AS E ON E.EmployeeId = GJ.GeneralJournalAddedBy
		INNER JOIN organization_stations AS S ON S.StationId = GJ.StationId
		WHERE  $sGeneralJournalStatusCond $sVoucherTypeString $sSearchCondition $sStationConditionVouchers 
		ORDER BY $sSortBy $sSortOrder
		LIMIT $iOffSet, $iPagingLimit";
//        echo "<pre>" . $Query . "</pre>";
//        die("OJJJ");
        $varResult = $objDB_FIS->ExecQueryAll($Query);

        $sReturn = '
		<table border="0" cellspacing="0" cellpadding="3" width="100%" align="center">
		 <tr>
		  <td colspan="2" align="left"><span class="heading">' . $sTitle . ' (' . $iTotalRecords . ' Records)</span></td>
		  <td colspan="2" align="right">' . $sPagingString . '</td>
		 </tr>
		</table>
		<table class="GridTable" border="1" cellspacing="0" cellpadding="3" width="100%" align="center">
		 <tr class="GridTR">		  
		  <td align="left"><span class="WhiteHeading">Type&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.EntryType&sortorder="><img src="../images/sort_up.gif" alt="Sort by Entry Type in Ascending Order" title="Sort by Entry Type in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.EntryType&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Entry Type in Descending Order" title="Sort by Entry Type in Descending Order" border="0" /></a></span></td>
		  <td align="left"><span class="WhiteHeading">Transaction Date&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.TransactionDate&sortorder="><img src="../images/sort_up.gif" alt="Sort by Transaction Date in Ascending Order" title="Sort by Transaction Date in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.TransactionDate&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Transacation Date in Descending Order" title="Sort by Transaction Date in Descending Order" border="0" /></a></span></td>
		  <td align="left"><span class="WhiteHeading">Reference&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.Reference&sortorder="><img src="../images/sort_up.gif" alt="Sort by Reference in Ascending Order" title="Sort by Reference in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.Reference&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Reference in Descending Order" title="Sort by Reference in Descending Order" border="0" /></a></span></td>
		  <td align="left"><span class="WhiteHeading">Offices&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=S.StationName&sortorder="><img src="../images/sort_up.gif" alt="Sort by Office in Ascending Order" title="Sort by Office in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=S.StationName&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Office in Descending Order" title="Sort by Office in Descending Order" border="0" /></a></span></td>
		  <td align="right"><span class="WhiteHeading">Amount&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.TotalDebit&sortorder="><img src="../images/sort_up.gif" alt="Sort by Transaction Amount in Ascending Order" title="Sort by Transaction Amount in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.TotalDebit&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Transaction Amount in Descending Order" title="Sort by Transaction Amount in Descending Order" border="0" /></a></span></td>
                      <td align="left"><span class="WhiteHeading">Status&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.Status&sortorder="><img src="../images/sort_up.gif" alt="Sort by Status in Ascending Order" title="Sort by Status in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.TotalDebit&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Status in Descending Order" title="Sort by Status in Descending Order" border="0" /></a></span></td>
		  <td width="6%" colspan="6"><span class="WhiteHeading">Operations</span></td>
		 </tr>';

        foreach ( $varResult as $varResult) {
            $sTRBGColor = ($sTRBGColor == '#edeff1') ? '#ffffff' : '#edeff1';
//GJ.GeneralJournalId GJ.StationId S.StationName GJ.EntryType GJ.Reference GJ.TotalDebit GJ.TotalCredit GJ.TransactionDate GJ.GeneralJournalAddedOn
            $iGeneralJournalId = $varResult["GeneralJournalId"];
            $iStationId = $varResult["StationId"];
            $Status = $varResult["Status"];
            $sStationName = $varResult["StationName"];
            $iEntryType = $varResult["EntryType"];
            $sEntryType = $this->aEntryType[$iEntryType];
            $sReference = $varResult["Reference"];
            $dTotalDebit = $varResult["TotalDebit"];
            $dTotalCredit = $varResult["TotalCredit"];
            $sTotalDebit = number_format($dTotalDebit, 2);
            $sTotalCredit = number_format($dTotalCredit, 2);
            $dTransactionDate = $varResult["TransactionDate"];
            $dAddedOn = $varResult["GeneralJournalAddedOn"];
            $sAddedOn = date("F j, Y", strtotime($dAddedOn));
            $sTransactionDate = date("F j, Y", strtotime($dTransactionDate));
            $iGJStatus = $varResult["Status"];
            $sStatus = $this->VouchersArray[$iGJStatus][0];

            if ($dTotalDebit == $dTotalCredit)
                $dTransactionAmount = $dTotalDebit;
            else
                $dTransactionAmount = 0;
            $sReviewGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="jsOpenWindow(\'../vouchers/?action=ProcessVoucher&id=' . $iGeneralJournalId . '&pStatus=' . $iGJStatus . '\', 1024,760);"><img src="../images/icons/iconRight.gif" border="0" alt="Disbursment Cheque" title="Disbursment Cheque"></a></td>';

            $sUploadGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.CreateTab(\'tabContainer\', \'Uploads for ' . str_replace('"', '', $sReference) . '\', \'../accounts/generaljournal_details.php?action2=upload&id=' . $iGeneralJournalId . '\', \'520px\', true);"><img src="../images/icons/clip.gif" border="0" alt="General Journal Document Details" title="General Journal Document Details"></a></td>';
            $sEditGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.CreateTab(\'tabContainer\', \'Update ' . str_replace('"', '', $sReference) . '\', \'../accounts/generaljournal_details.php?action2=edit&id=' . $iGeneralJournalId . '\', \'520px\', true);"><img src="../images/icons/iconEdit.gif" border="0" alt="Edit this General Journal Entry Details" title="Edit this General Journal Entry Details"></a></td>';
            $sDeleteGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="if(confirm(\'Do you really want to delete this General Journal Entry?\')) {window.location = \'?action=DeleteGeneralJournal&id=' . $iGeneralJournalId . '\';}"><img src="../images/icons/iconDelete.gif" border="0" alt="Delete this General Journal Entry" title="Delete this General Journal Entry"></a></td>';

            $sReviewGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.MOOdalBox.open(\'../vouchers/?action=ProcessVoucher&id=' . $iGeneralJournalId . '&pStatus=' . $iGJStatus . '\', \'' . str_replace('"', '', $sReference) . '\', \'960 540\');"><img src="../images/icons/iconRight.gif" border="0" alt="General Journal Process" title="General Journal Process"></a></td>';

            if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[2] == 0)
                $sEditGeneralJournal = '';
            if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[3] == 0)
                $sDeleteGeneralJournal = '';

            $sReceipt = '<td class="GridTD" align="center"><a href="#noanchor" onclick="jsOpenWindow(\'../reports/showreport.php?report=AccountsReports&reporttype=GeneralJournalReceipt&selEmployee=-1&selStation=-1&id=' . $iGeneralJournalId . '&txtReference=' . $sReference . '\', 800,600);"><img src="../images/icons/iconPrint2.gif" border="0" alt="Receipt" title="Receipt"></a></td>';

            $sReviewGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="jsOpenWindow(\'../vouchers/?action=ProcessVoucher&id=' . $iGeneralJournalId . '&pStatus=' . $iGJStatus . '\', 1024,760);"><img src="../images/icons/iconRight.gif" border="0" alt="Disbursment Cheque" title="Disbursment Cheque"></a></td>';

            $sDocuments = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.MOOdalBox.open(\'../common/documents_show.php?componentname=Accounts_GeneralJournal&id=' . $iGeneralJournalId . '\', \'Documents of ' . str_replace('"', '', $sReference) . '\', \'700 420\');"><img src="../images/icons/save.gif" border="0" alt="General Journal Documents" title="General Journal Documents"></a></td>';

            if (strtolower(cAllowEditDeleteTransactions) != 'yes')
                $sEditGeneralJournal = $sDeleteGeneralJournal = '<td>&nbsp;</td>';

            $sChangeStatus = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.MOOdalBox.open(\'../common/status_show.php?componentname=Accounts_GeneralJournal&id=' . $iGeneralJournalId . '\', \'Status Update for ' . str_replace('"', '', $sReference) . '\', \'700 420\');"><img src="../images/icons/tick.gif" border="0" alt="Update Status" title="Update Status"></a></td>';

            //if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournal_Documents[0] == 0) // View Disabled
            //	$sDocuments = '<td>&nbsp;</td>';

            $sReturn .= '
			<tr onMouseOver="bgColor=\'#ffe69c\';" onMouseOut="bgColor=\'' . $sTRBGColor . '\';" bgcolor="' . $sTRBGColor . '">			 
			 <td class="GridTD" align="left" valign="top">' . $sEntryType . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="left" valign="top">' . $sTransactionDate . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="left" valign="top">' . $sReference . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="left" valign="top">' . $sStationName . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="right" valign="top">' . number_format($dTransactionAmount, 0) . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
                             <td class="GridTD" align="left" valign="top"><span style="color:' . ($this->VouchersArray[$iGJStatus][1]) . ';">' . ($this->VouchersArray[$iGJStatus][0]) . '</span><img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.CreateTab(\'tabContainer\', \'General Jouranl Entry Details\', \'../accounts/generaljournal_details.php?id=' . $iGeneralJournalId . '\', \'520px\', true);"><img src="../images/icons/iconDetails.gif" border="0" alt="View this General Journal Entry Details" title="View this General Journal Entry Details"></a></td>
			 ' . $sEditGeneralJournal . $sReviewGeneralJournal . $sUploadGeneralJournal . $sReceipt . $sDeleteGeneralJournal . '
			</tr>';
        }

        //$sStationSelect = '<select class="form1" name="selStation" onchange="window.location=\'?StationId=\'+GetSelectedListBox(\'selStation\');" id="selStation">
        $sStationSelect = '<select class="form1" name="selStation" onchange="document.frm.submit();" id="selStation">
		<option value="0">All Offices</option>';
        $varResult = $objDB_FIS->ExecQueryAll("SELECT S.StationId,S.StationName FROM organization_stations AS S WHERE  S.Status='1' AND S.OrganizationId='" . cOrganizationId . "' ORDER BY S.StationName");
        foreach ($varResult as $varResult)
            $sStationSelect .= '<option ' . (($iStationId1 == $varResult["StationId"]) ? 'selected="true"' : '') . ' value="' . $varResult["StationId"] . '">' . $varResult["StationName"] . '</option>';
        $sStationSelect .= '</select>';

        //$sprams = ;
        //$sVoucherTypeSelect = '<select class="form1" name="selVoucherType" onchange="window.location=\'?vouchertype=\'+GetSelectedListBox(\'selVoucherType\');" id="selVoucherType">';
        $sVoucherTypeSelect = '<select class="form1" name="selVoucherType" onchange="document.frm.submit();" id="selVoucherType">';
        $sVoucherTypeSelect .= '<option value="0">Voucher Type</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'BPV') ? 'selected="true"' : '') . ' value="BPV">BPV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'BRV') ? 'selected="true"' : '') . ' value="BRV">BRV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'CPV') ? 'selected="true"' : '') . ' value="CPV">CPV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'CRV') ? 'selected="true"' : '') . ' value="CRV">CRV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'JV') ? 'selected="true"' : '') . ' value="JV">JV</option>';
        $sVoucherTypeSelect .= '</select>';

        $sAddGeneralJournal = '<input onclick="window.top.CreateTab(\'tabContainer\', \'Add New Entry\', \'../accounts/generaljournal_details.php?action2=addnew\', \'520px\', true);" type="button" class="AdminFormButton1" value="Add New">';

        if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[1] == 0)
            $sAddGeneralJournal = '';

        $sReturn .= '</table>
		<table border="0" cellspacing="0" cellpadding="3" width="100%" align="center">
		 <tr>
		  <td>
 		   <form method="GET" action=""><label>Search:</label><br><input type="text" class="form1" size="45" name="p" id="p" />&nbsp;<input type="image" src="../images/icons/search.gif" alt="Search for General Journal Entry" title="Search for General Journal Entry" border="0">
		  &nbsp;</td>
		  <td height="40" colspan="2" align="right">' . $sPagingString . '</td>
		  </form>
		 </tr>
		 <tr>
		  <td>
		   <form method="GET" name="frm" id="frm"> ' . $sStationSelect . ' ' . $sVoucherTypeSelect . '</form>
		  </td>
		 </tr>		
		</table>';

        return($sReturn);
    }

    public function ShowAllCompliancedVouchers($id) {
        global $objDatabase;
        global $objGeneral;
        global $objEmployee;
        global $objDB_FIS;
        // Employee Roles
        $iEmployeeId = $objEmployee->iEmployeeId;
        $iEmployeeTypeId = $objEmployee->iEmployeeTypeId;
        $iEmployeeStationId = $objEmployee->iEmployeeStationId;

        if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[0] == 0) // View Disabled
            return('<br /><br /><div align="center">Sorry, Access Denied to this Area...</div><br /><br />');
        $iEmployeeStationsVoucher = $objEmployee->objEmployeeRoles->bEmployeeRole_CanApproveVoucherOffice;
        $sStationConditionVouchers = "";
        //print_r($iEmployeeStationsVoucher);
        //echo "<br>";
        if ($iEmployeeStationsVoucher) {
            $StationsToCondition = implode(",", $iEmployeeStationsVoucher);
            $sStationConditionVouchers = " AND (S.StationId IN ($StationsToCondition) OR (S.StationId = '$iEmployeeStationId')) ";
        } else {
            $sStationConditionVouchers = " AND S.StationId IN ($iEmployeeStationId) ";
        }

        //die("Wait for a while, we are upgrading your system...!");

        $sSortBy = $objGeneral->fnGet("sortby");
        $sSortOrder = $objGeneral->fnGet("sortorder");
        $iShow = $objGeneral->fnGet("show");
        $iPage = $objGeneral->fnGet("page");
        if ($iPage == '')
            $iPage = 1;
        $sVoucherType = $objGeneral->fnGet("selVoucherType");
        $iStationId1 = $objGeneral->fnGet("selStation");

        if ($iStationId1 > 0) {
            $varResult = $objDB_FIS->ExecQueryCol("SELECT S.StationName FROM organization_stations AS S WHERE S.OrganizationId='" . cOrganizationId . "' AND S.Status='1' AND S.StationId='$iStationId1'");
            if ( !$varResult )
                die('Sorry, Invalid StationId Id');
            $sStationName = $varResult["StationName"];
            $sTitle = "Vouchers from " . $sStationName;

            $sStationCondition = "AND S.StationId='$iStationId1' ";
        } else
            $sStationCondition = "";

        $sGeneralJournalStatusCond = "GJ.Status=3 ";
        $sGeneralJournalStatusCond .= " AND GJ.TotalDebit BETWEEN '" . $objEmployee->objEmployeeRoles->bEmployeeRole_CanApproveVoucherAmountMin . "' AND '" . $objEmployee->objEmployeeRoles->bEmployeeRole_CanApproveVoucherAmountMax . "'  ";
        $sGeneralJournalStatusCond .= " AND GJ.TransactionDate>='2018-01-01' ";
        if ($sVoucherType != '0') {
            $sTitle = "General Journal as " . $sVoucherType;
            $sVoucherTypeString = " AND GJ.Reference Like '$sVoucherType%'";
        }

        //Advance Search
        $iView = $objGeneral->fnGet("view");
        if ($iView == 1) {
            $sAdnacedSearch_VoucherNumber = $objGeneral->fnGet("txtVoucherNumber");
            $sAdnacedSearch_TransactionDateFrom = $objGeneral->fnGet("txtTransactionDateFrom");
            $sAdnacedSearch_TransactionDateTo = $objGeneral->fnGet("txtTransactionDateTo");
            $sAdnacedSearch_Amount = $objGeneral->fnGet("txtAmount");

            if ($sAdnacedSearch_VoucherNumber != "")
                $sAdnacedSearchString = " AND (GJ.Reference = '$sAdnacedSearch_VoucherNumber')";
            if ($sAdnacedSearch_Amount != "")
                $sAdnacedSearchString .= " AND (GJ.TotalDebit = '$sAdnacedSearch_Amount' OR GJ.TotalCredit = '$sAdnacedSearch_Amount')";
            if (($sAdnacedSearch_TransactionDateFrom != ""))
                $sAdnacedSearchString .= " AND (GJ.TransactionDate = '$sAdnacedSearch_TransactionDateFrom')";
        }
        //End Advance Search

        $sTitle = "UnApproved Vouchers";
        if ($sSortBy == "")
            $sSortBy = "GJ.GeneralJournalAddedOn DESC";

        if ($sSearch != "") {
//            $sSearch = mysql_real_escape_string($sSearch);
            $sSearchCondition = " AND ((GJ.Reference LIKE '%$sSearch%') OR (GJ.GeneralJournalId LIKE '%$sSearch%') OR (GJ.TransactionDate LIKE '%$sSearch%') OR (GJ.CheckNumber LIKE '%$sSearch%') OR (GJ.TotalDebit LIKE '%$sSearch%') OR (GJ.Description LIKE '%$sSearch%') OR (S.StationName LIKE '%$sSearch%'))";

            $sSearch = stripslashes($sSearch);
            $sTitle = 'Search Results for "' . $sSearch . '"';
        } else
            $sSearchCondition = $sAdnacedSearchString;

        //if($iEmployeeId != 1) $sEmployeeCondition = " AND GJ.GeneralJournalAddedBy = '$iEmployeeId'";
        //print_r($_SESSION);
        $iEmployeeStationId = $_SESSION['Employee_StationId'];
        if ($iEmployeeId != 1)
            $sStationCondition1 = " AND GJ.StationId = '$iEmployeeStationId'";

        $iTotalRecords = $objDB_FIS->ExecQueryCol("SELECT count(0) as 'Total' FROM fms_accounts_generaljournal AS GJ INNER JOIN fms_organization_employees AS E ON E.EmployeeId = GJ.GeneralJournalAddedBy INNER JOIN organization_stations AS S ON S.StationId = GJ.StationId", " $sGeneralJournalStatusCond $sVoucherTypeString $sSearchCondition $sStationConditionVouchers ");
        $sRefresh = '<a href="#noanchor" onclick="window.location=\'?show=' . $iShow . '&page=' . $iPage . '\';"><img src="../images/icons/iconRefresh.gif" border="0" alt="Refresh" title="Refresh" /></a>';
        $sPagingString = $objGeneral->Grid_GeneratePagingString($iPage, $iShow, $iTotalRecords, $sRefresh, $iPagingLimit, $iOffSet, $sCurrentURL);


        //$varResult = $objDatabase->Query("
        $Q = "
		SELECT 
                GJ.GeneralJournalId, 
                GJ.StationId, 
                S.StationName, 
                GJ.EntryType, 
                GJ.Reference, 
                GJ.TotalDebit, 
                GJ.TotalCredit, 
                GJ.TransactionDate, 
                GJ.Status,
                GJ.GeneralJournalAddedOn                 
                FROM fms_accounts_generaljournal AS GJ
		INNER JOIN fms_organization_employees AS E ON E.EmployeeId = GJ.GeneralJournalAddedBy
		INNER JOIN organization_stations AS S ON S.StationId = GJ.StationId
		WHERE  $sGeneralJournalStatusCond $sVoucherTypeString $sSearchCondition $sStationConditionVouchers 
		ORDER BY $sSortBy $sSortOrder
		LIMIT $iOffSet, $iPagingLimit";
        // echo "<pre>" . $Q . "</pre>";
        $varResult = $objDB_FIS->ExecQueryAll($Q);
        $sReturn = '
		<table border="0" cellspacing="0" cellpadding="3" width="100%" align="center">
		 <tr>
		  <td colspan="2" align="left"><span class="heading">' . $sTitle . ' (' . $iTotalRecords . ' Records)</span></td>
		  <td colspan="2" align="right">' . $sPagingString . '</td>
		 </tr>
		</table>
		<table class="GridTable" border="1" cellspacing="0" cellpadding="3" width="100%" align="center">
                    <tr class="GridTR">		  
                        <td align="left"><span class="WhiteHeading">Type&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.EntryType&sortorder="><img src="../images/sort_up.gif" alt="Sort by Entry Type in Ascending Order" title="Sort by Entry Type in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.EntryType&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Entry Type in Descending Order" title="Sort by Entry Type in Descending Order" border="0" /></a></span></td>
                        <td align="left"><span class="WhiteHeading">Transaction Date&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.TransactionDate&sortorder="><img src="../images/sort_up.gif" alt="Sort by Transaction Date in Ascending Order" title="Sort by Transaction Date in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.TransactionDate&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Transacation Date in Descending Order" title="Sort by Transaction Date in Descending Order" border="0" /></a></span></td>
                        <td align="left"><span class="WhiteHeading">Reference&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.Reference&sortorder="><img src="../images/sort_up.gif" alt="Sort by Reference in Ascending Order" title="Sort by Reference in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.Reference&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Reference in Descending Order" title="Sort by Reference in Descending Order" border="0" /></a></span></td>
                        <td align="left"><span class="WhiteHeading">Offices&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=S.StationName&sortorder="><img src="../images/sort_up.gif" alt="Sort by Office in Ascending Order" title="Sort by Office in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=S.StationName&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Office in Descending Order" title="Sort by Office in Descending Order" border="0" /></a></span></td>
                        <td align="right"><span class="WhiteHeading">Amount&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.TotalDebit&sortorder="><img src="../images/sort_up.gif" alt="Sort by Transaction Amount in Ascending Order" title="Sort by Transaction Amount in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.TotalDebit&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Transaction Amount in Descending Order" title="Sort by Transaction Amount in Descending Order" border="0" /></a></span></td>
                        <td align="left"><span class="WhiteHeading">Status&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.Status&sortorder="><img src="../images/sort_up.gif" alt="Sort by Status in Ascending Order" title="Sort by Status in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.TotalDebit&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Status in Descending Order" title="Sort by Status in Descending Order" border="0" /></a></span></td>
                        <td width="6%" colspan="6"><span class="WhiteHeading">Operations</span></td>
                    </tr>';

        foreach ( $varResult as $varResult) {
            $sTRBGColor = ($sTRBGColor == '#edeff1') ? '#ffffff' : '#edeff1';
//GJ.GeneralJournalId GJ.StationId S.StationName GJ.EntryType GJ.Reference GJ.TotalDebit GJ.TotalCredit GJ.TransactionDate GJ.GeneralJournalAddedOn
            $iGeneralJournalId = $varResult["GeneralJournalId"];
            $iStationId = $varResult["StationId"];
            $Status = $varResult["Status"];
            $sStationName = $varResult["StationName"];
            $iEntryType = $varResult["EntryType"];
            $sEntryType = $this->aEntryType[$iEntryType];
            $sReference = $varResult["Reference"];
            $dTotalDebit = $varResult["TotalDebit"];
            $dTotalCredit = $varResult["TotalCredit"];
            $sTotalDebit = number_format($dTotalDebit, 2);
            $sTotalCredit = number_format($dTotalCredit, 2);
            $dTransactionDate = $varResult["TransactionDate"];
            $dAddedOn = $varResult["GeneralJournalAddedOn"];
            $sAddedOn = date("F j, Y", strtotime($dAddedOn));
            $sTransactionDate = date("F j, Y", strtotime($dTransactionDate));
            $iGJStatus = $varResult["Status"];
            $sStatus = $this->VouchersArray[$iGJStatus][0];

            if ($dTotalDebit == $dTotalCredit)
                $dTransactionAmount = $dTotalDebit;
            else
                $dTransactionAmount = 0;
            $sReviewGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="jsOpenWindow(\'../vouchers/?action=ProcessVoucher&id=' . $iGeneralJournalId . '&pStatus=' . $iGJStatus . '\', 1024,760);"><img src="../images/icons/iconRight.gif" border="0" alt="Disbursment Cheque" title="Disbursment Cheque"></a></td>';

            $sUploadGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.CreateTab(\'tabContainer\', \'Uploads for ' . str_replace('"', '', $sReference) . '\', \'../accounts/generaljournal_details.php?action2=upload&id=' . $iGeneralJournalId . '\', \'520px\', true);"><img src="../images/icons/clip.gif" border="0" alt="General Journal Document Details" title="General Journal Document Details"></a></td>';
            $sEditGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.CreateTab(\'tabContainer\', \'Update ' . str_replace('"', '', $sReference) . '\', \'../accounts/generaljournal_details.php?action2=edit&id=' . $iGeneralJournalId . '\', \'520px\', true);"><img src="../images/icons/iconEdit.gif" border="0" alt="Edit this General Journal Entry Details" title="Edit this General Journal Entry Details"></a></td>';
            $sDeleteGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="if(confirm(\'Do you really want to delete this General Journal Entry?\')) {window.location = \'?action=DeleteGeneralJournal&id=' . $iGeneralJournalId . '\';}"><img src="../images/icons/iconDelete.gif" border="0" alt="Delete this General Journal Entry" title="Delete this General Journal Entry"></a></td>';

            if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[2] == 0)
                $sEditGeneralJournal = '';
            if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[3] == 0)
                $sDeleteGeneralJournal = '';

            $sReceipt = '<td class="GridTD" align="center"><a href="#noanchor" onclick="jsOpenWindow(\'../reports/showreport.php?report=AccountsReports&reporttype=GeneralJournalReceipt&selEmployee=-1&selStation=-1&id=' . $iGeneralJournalId . '&txtReference=' . $sReference . '\', 800,600);"><img src="../images/icons/iconPrint2.gif" border="0" alt="Receipt" title="Receipt"></a></td>';

            $sDisbursmentCheque = '<td class="GridTD" align="center"><a href="#noanchor" onclick="jsOpenWindow(\'../reports/loans_disbursement_printreports.php?report=AccountsReports&reporttype=GeneralJournalReceipt&selEmployee=-1&selStation=-1&id=' . $iGeneralJournalId . '&txtReference=' . $sReference . '\', 800,600);"><img src="../images/icons/iconCheques.gif" border="0" alt="Disbursment Cheque" title="Disbursment Cheque"></a></td>';

            $sDocuments = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.MOOdalBox.open(\'../common/documents_show.php?componentname=Accounts_GeneralJournal&id=' . $iGeneralJournalId . '\', \'Documents of ' . str_replace('"', '', $sReference) . '\', \'700 420\');"><img src="../images/icons/save.gif" border="0" alt="General Journal Documents" title="General Journal Documents"></a></td>';

            if (strtolower(cAllowEditDeleteTransactions) != 'yes')
                $sEditGeneralJournal = $sDeleteGeneralJournal = '<td>&nbsp;</td>';

            $sChangeStatus = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.MOOdalBox.open(\'../common/status_show.php?componentname=Accounts_GeneralJournal&id=' . $iGeneralJournalId . '\', \'Status Update for ' . str_replace('"', '', $sReference) . '\', \'700 420\');"><img src="../images/icons/tick.gif" border="0" alt="Update Status" title="Update Status"></a></td>';

            //if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournal_Documents[0] == 0) // View Disabled
            //	$sDocuments = '<td>&nbsp;</td>';

            $sReturn .= '
			<tr onMouseOver="bgColor=\'#ffe69c\';" onMouseOut="bgColor=\'' . $sTRBGColor . '\';" bgcolor="' . $sTRBGColor . '">			 
			 <td class="GridTD" align="left" valign="top">' . $sEntryType . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="left" valign="top">' . $sTransactionDate . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="left" valign="top">' . $sReference . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="left" valign="top">' . $sStationName . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="right" valign="top">' . number_format($dTransactionAmount, 0) . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
                             <td class="GridTD" align="left" valign="top"><span style="color:' . ($this->VouchersArray[$iGJStatus][1]) . ';">' . ($this->VouchersArray[$iGJStatus][0]) . '</span><img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.CreateTab(\'tabContainer\', \'General Jouranl Entry Details\', \'../accounts/generaljournal_details.php?id=' . $iGeneralJournalId . '\', \'520px\', true);"><img src="../images/icons/iconDetails.gif" border="0" alt="View this General Journal Entry Details" title="View this General Journal Entry Details"></a></td>
			 ' . $sEditGeneralJournal . $sReviewGeneralJournal . $sUploadGeneralJournal . $sReceipt . $sDeleteGeneralJournal . '
			</tr>';
        }

        //$sStationSelect = '<select class="form1" name="selStation" onchange="window.location=\'?StationId=\'+GetSelectedListBox(\'selStation\');" id="selStation">
        $sStationSelect = '<select class="form1" name="selStation" onchange="document.frm.submit();" id="selStation">
		<option value="0">All Offices</option>';
        $varResult = $objDB_FIS->ExecQueryAll("SELECT S.StationId,S.StationName FROM organization_stations AS S WHERE  S.Status='1' AND S.OrganizationId='" . cOrganizationId . "' ORDER BY S.StationName");
        foreach ( $varResult as $varResult)
            $sStationSelect .= '<option ' . (($iStationId1 == $varResult["StationId"]) ? 'selected="true"' : '') . ' value="' . $varResult["StationId"] . '">' . $varResult["StationName"] . '</option>';
        $sStationSelect .= '</select>';

        //$sprams = ;
        //$sVoucherTypeSelect = '<select class="form1" name="selVoucherType" onchange="window.location=\'?vouchertype=\'+GetSelectedListBox(\'selVoucherType\');" id="selVoucherType">';
        $sVoucherTypeSelect = '<select class="form1" name="selVoucherType" onchange="document.frm.submit();" id="selVoucherType">';
        $sVoucherTypeSelect .= '<option value="0">Voucher Type</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'BPV') ? 'selected="true"' : '') . ' value="BPV">BPV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'BRV') ? 'selected="true"' : '') . ' value="BRV">BRV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'CPV') ? 'selected="true"' : '') . ' value="CPV">CPV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'CRV') ? 'selected="true"' : '') . ' value="CRV">CRV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'JV') ? 'selected="true"' : '') . ' value="JV">JV</option>';
        $sVoucherTypeSelect .= '</select>';

        $sAddGeneralJournal = '<input onclick="window.top.CreateTab(\'tabContainer\', \'Add New Entry\', \'../accounts/generaljournal_details.php?action2=addnew\', \'520px\', true);" type="button" class="AdminFormButton1" value="Add New">';

        if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[1] == 0)
            $sAddGeneralJournal = '';

        $sReturn .= '</table>
		<table border="0" cellspacing="0" cellpadding="3" width="100%" align="center">
		 <tr>
		  <td>
 		   <form method="GET" action=""><label>Search:</label><br><input type="text" class="form1" size="45" name="p" id="p" />&nbsp;<input type="image" src="../images/icons/search.gif" alt="Search for General Journal Entry" title="Search for General Journal Entry" border="0">
		  &nbsp;</td>
		  <td height="40" colspan="2" align="right">' . $sPagingString . '</td>
		  </form>
		 </tr>
		 <tr>
		  <td>
		   <form method="GET" name="frm" id="frm"> ' . $sStationSelect . ' ' . $sVoucherTypeSelect . '</form>
		  </td>
		 </tr>		
		</table>';

        return($sReturn);
    }

    public function ShowAllUnApprovedVouchers($id) {
        global $objDatabase;
        global $objGeneral;
        global $objEmployee;
        global $objDB_FIS;
        // Employee Roles
        $iEmployeeId = $objEmployee->iEmployeeId;
        $iEmployeeTypeId = $objEmployee->iEmployeeTypeId;
        $iEmployeeStationId = $objEmployee->iEmployeeStationId;

        if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[0] == 0) // View Disabled
            return('<br /><br /><div align="center">Sorry, Access Denied to this Area...</div><br /><br />');

        $iEmployeeStationsVoucher = $objEmployee->objEmployeeRoles->bEmployeeRole_CanApproveVoucherOffice;
        $sStationConditionVouchers = "";
        //print_r($iEmployeeStationsVoucher);
        //echo "<br>";
        if ($iEmployeeStationsVoucher) {
            $StationsToCondition = implode(",", $iEmployeeStationsVoucher);
            $sStationConditionVouchers = " AND (S.StationId IN ($StationsToCondition) OR (S.StationId = '$iEmployeeStationId')) ";
        } else {
            $sStationConditionVouchers = " AND S.StationId IN ($iEmployeeStationId) ";
        }

        //die("Wait for a while, we are upgrading your system...!");

        $sSortBy = $objGeneral->fnGet("sortby");
        $sSortOrder = $objGeneral->fnGet("sortorder");
        $iShow = $objGeneral->fnGet("show");
        $iPage = $objGeneral->fnGet("page");
        if ($iPage == '')
            $iPage = 1;
        $sVoucherType = $objGeneral->fnGet("selVoucherType");
        $iStationId1 = $objGeneral->fnGet("selStation");

        if ($iStationId1 > 0) {
            $varResult = $objDB_FIS->ExecQueryCol("SELECT S.StationName FROM organization_stations AS S WHERE S.OrganizationId='" . cOrganizationId . "' AND S.Status='1' AND S.StationId='$iStationId1'");
            if ( !$varResult )
                die('Sorry, Invalid StationId Id');
            $sStationName = $varResult["StationName"];
            $sTitle = "Vouchers from " . $sStationName;

            $sStationCondition = "AND S.StationId='$iStationId1' ";
        } else
            $sStationCondition = "";

        $sGeneralJournalStatusCond = "GJ.Status=3 ";
        $sGeneralJournalStatusCond .= " AND GJ.TotalDebit BETWEEN '" . $objEmployee->objEmployeeRoles->bEmployeeRole_CanApproveVoucherAmountMin . "' AND '" . $objEmployee->objEmployeeRoles->bEmployeeRole_CanApproveVoucherAmountMax . "'  ";
        $sGeneralJournalStatusCond .= " AND GJ.TransactionDate>='2018-01-01' ";
        if ($sVoucherType != '0') {
            $sTitle = "General Journal as " . $sVoucherType;
            $sVoucherTypeString = " AND GJ.Reference Like '$sVoucherType%'";
        }

        //Advance Search
        $iView = $objGeneral->fnGet("view");
        if ($iView == 1) {
            $sAdnacedSearch_VoucherNumber = $objGeneral->fnGet("txtVoucherNumber");
            $sAdnacedSearch_TransactionDateFrom = $objGeneral->fnGet("txtTransactionDateFrom");
            $sAdnacedSearch_TransactionDateTo = $objGeneral->fnGet("txtTransactionDateTo");
            $sAdnacedSearch_Amount = $objGeneral->fnGet("txtAmount");

            if ($sAdnacedSearch_VoucherNumber != "")
                $sAdnacedSearchString = " AND (GJ.Reference = '$sAdnacedSearch_VoucherNumber')";
            if ($sAdnacedSearch_Amount != "")
                $sAdnacedSearchString .= " AND (GJ.TotalDebit = '$sAdnacedSearch_Amount' OR GJ.TotalCredit = '$sAdnacedSearch_Amount')";
            if (($sAdnacedSearch_TransactionDateFrom != ""))
                $sAdnacedSearchString .= " AND (GJ.TransactionDate = '$sAdnacedSearch_TransactionDateFrom')";
        }
        //End Advance Search

        $sTitle = "UnApproved Vouchers";
        if ($sSortBy == "")
            $sSortBy = "GJ.GeneralJournalAddedOn DESC";

        if ($sSearch != "") {
//            $sSearch = mysql_real_escape_string($sSearch);
            $sSearchCondition = " AND ((GJ.Reference LIKE '%$sSearch%') OR (GJ.GeneralJournalId LIKE '%$sSearch%') OR (GJ.TransactionDate LIKE '%$sSearch%') OR (GJ.CheckNumber LIKE '%$sSearch%') OR (GJ.TotalDebit LIKE '%$sSearch%') OR (GJ.Description LIKE '%$sSearch%') OR (S.StationName LIKE '%$sSearch%'))";

            $sSearch = stripslashes($sSearch);
            $sTitle = 'Search Results for "' . $sSearch . '"';
        } else
            $sSearchCondition = $sAdnacedSearchString;

        //if($iEmployeeId != 1) $sEmployeeCondition = " AND GJ.GeneralJournalAddedBy = '$iEmployeeId'";
        //print_r($_SESSION);
        $iEmployeeStationId = $_SESSION['Employee_StationId'];
        if ($iEmployeeId != 1)
            $sStationCondition1 = " AND GJ.StationId = '$iEmployeeStationId'";

        $iTotalRecords = $objDB_FIS->ExecQueryCol("SELECT count(0) as 'Total' FROM fms_accounts_generaljournal AS GJ INNER JOIN fms_organization_employees AS E ON E.EmployeeId = GJ.GeneralJournalAddedBy INNER JOIN organization_stations AS S ON S.StationId = GJ.StationId", " $sGeneralJournalStatusCond $sVoucherTypeString $sSearchCondition $sStationConditionVouchers ");
        $sRefresh = '<a href="#noanchor" onclick="window.location=\'?show=' . $iShow . '&page=' . $iPage . '\';"><img src="../images/icons/iconRefresh.gif" border="0" alt="Refresh" title="Refresh" /></a>';
        $sPagingString = $objGeneral->Grid_GeneratePagingString($iPage, $iShow, $iTotalRecords, $sRefresh, $iPagingLimit, $iOffSet, $sCurrentURL);

        $Query = "
		SELECT 
                GJ.GeneralJournalId, 
                GJ.StationId, 
                S.StationName, 
                GJ.EntryType, 
                GJ.Reference, 
                GJ.TotalDebit, 
                GJ.TotalCredit, 
                GJ.TransactionDate, 
                GJ.Status,
                GJ.GeneralJournalAddedOn                 
                FROM fms_accounts_generaljournal AS GJ 
		INNER JOIN fms_organization_employees AS E ON E.EmployeeId = GJ.GeneralJournalAddedBy 
		INNER JOIN organization_stations AS S ON S.StationId = GJ.StationId 
		WHERE  $sGeneralJournalStatusCond $sVoucherTypeString $sSearchCondition $sStationConditionVouchers 
		ORDER BY $sSortBy $sSortOrder 
		LIMIT $iOffSet, $iPagingLimit";
        //echo "<pre>" . $Query . "</pre>";
        $varResult = $objDB_FIS->ExecQueryAll($Query);

        $sReturn = '
		<table border="0" cellspacing="0" cellpadding="3" width="100%" align="center">
		 <tr>
		  <td colspan="2" align="left"><span class="heading">' . $sTitle . ' (' . $iTotalRecords . ' Records)</span></td>
		  <td colspan="2" align="right">' . $sPagingString . '</td>
		 </tr>
		</table>
		<table class="GridTable" border="1" cellspacing="0" cellpadding="3" width="100%" align="center">
		 <tr class="GridTR">		  
		  <td align="left"><span class="WhiteHeading">Type&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.EntryType&sortorder="><img src="../images/sort_up.gif" alt="Sort by Entry Type in Ascending Order" title="Sort by Entry Type in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.EntryType&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Entry Type in Descending Order" title="Sort by Entry Type in Descending Order" border="0" /></a></span></td>
		  <td align="left"><span class="WhiteHeading">Transaction Date&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.TransactionDate&sortorder="><img src="../images/sort_up.gif" alt="Sort by Transaction Date in Ascending Order" title="Sort by Transaction Date in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.TransactionDate&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Transacation Date in Descending Order" title="Sort by Transaction Date in Descending Order" border="0" /></a></span></td>
		  <td align="left"><span class="WhiteHeading">Reference&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.Reference&sortorder="><img src="../images/sort_up.gif" alt="Sort by Reference in Ascending Order" title="Sort by Reference in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.Reference&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Reference in Descending Order" title="Sort by Reference in Descending Order" border="0" /></a></span></td>
		  <td align="left"><span class="WhiteHeading">Offices&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=S.StationName&sortorder="><img src="../images/sort_up.gif" alt="Sort by Office in Ascending Order" title="Sort by Office in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=S.StationName&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Office in Descending Order" title="Sort by Office in Descending Order" border="0" /></a></span></td>
		  <td align="right"><span class="WhiteHeading">Amount&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.TotalDebit&sortorder="><img src="../images/sort_up.gif" alt="Sort by Transaction Amount in Ascending Order" title="Sort by Transaction Amount in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.TotalDebit&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Transaction Amount in Descending Order" title="Sort by Transaction Amount in Descending Order" border="0" /></a></span></td>
                      <td align="left"><span class="WhiteHeading">Status&nbsp;&nbsp;<a href="' . $sCurrentURL . '&sortby=GJ.Status&sortorder="><img src="../images/sort_up.gif" alt="Sort by Status in Ascending Order" title="Sort by Status in Ascending Order" border="0" /></a><a href="' . $sCurrentURL . '&sortby=GJ.TotalDebit&sortorder=DESC"><img src="../images/sort_dn.gif" alt="Sort by Status in Descending Order" title="Sort by Status in Descending Order" border="0" /></a></span></td>
		  <td width="6%" colspan="6"><span class="WhiteHeading">Operations</span></td>
		 </tr>';

        foreach ( $varResult as $varResult) {
            $sTRBGColor = ($sTRBGColor == '#edeff1') ? '#ffffff' : '#edeff1';
//GJ.GeneralJournalId GJ.StationId S.StationName GJ.EntryType GJ.Reference GJ.TotalDebit GJ.TotalCredit GJ.TransactionDate GJ.GeneralJournalAddedOn
            $iGeneralJournalId = $varResult["GeneralJournalId"];
            $iStationId = $varResult["StationId"];
            $Status = $varResult["Status"];
            $sStationName = $varResult["StationName"];
            $iEntryType = $varResult["EntryType"];
            $sEntryType = $this->aEntryType[$iEntryType];
            $sReference = $varResult["Reference"];
            $dTotalDebit = $varResult["TotalDebit"];
            $dTotalCredit = $varResult["TotalCredit"];
            $sTotalDebit = number_format($dTotalDebit, 2);
            $sTotalCredit = number_format($dTotalCredit, 2);
            $dTransactionDate = $varResult["TransactionDate"];
            $dAddedOn = $varResult["GeneralJournalAddedOn"];
            $sAddedOn = date("F j, Y", strtotime($dAddedOn));
            $sTransactionDate = date("F j, Y", strtotime($dTransactionDate));
            $iGJStatus = $varResult["Status"];
            $sStatus = $this->VouchersArray[$iGJStatus][0];

            if ($dTotalDebit == $dTotalCredit)
                $dTransactionAmount = $dTotalDebit;
            else
                $dTransactionAmount = 0;
            $sReviewGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="jsOpenWindow(\'../vouchers/?action=ProcessVoucher&id=' . $iGeneralJournalId . '&pStatus=' . $iGJStatus . '\', 1024,760);"><img src="../images/icons/iconRight.gif" border="0" alt="Disbursment Cheque" title="Disbursment Cheque"></a></td>';

            $sUploadGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.CreateTab(\'tabContainer\', \'Uploads for ' . str_replace('"', '', $sReference) . '\', \'../accounts/generaljournal_details.php?action2=upload&id=' . $iGeneralJournalId . '\', \'520px\', true);"><img src="../images/icons/clip.gif" border="0" alt="General Journal Document Details" title="General Journal Document Details"></a></td>';
            $sEditGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.CreateTab(\'tabContainer\', \'Update ' . str_replace('"', '', $sReference) . '\', \'../accounts/generaljournal_details.php?action2=edit&id=' . $iGeneralJournalId . '\', \'520px\', true);"><img src="../images/icons/iconEdit.gif" border="0" alt="Edit this General Journal Entry Details" title="Edit this General Journal Entry Details"></a></td>';
            $sDeleteGeneralJournal = '<td class="GridTD" align="center"><a href="#noanchor" onclick="if(confirm(\'Do you really want to delete this General Journal Entry?\')) {window.location = \'?action=DeleteGeneralJournal&id=' . $iGeneralJournalId . '\';}"><img src="../images/icons/iconDelete.gif" border="0" alt="Delete this General Journal Entry" title="Delete this General Journal Entry"></a></td>';

            if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[2] == 0)
                $sEditGeneralJournal = '';
            if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[3] == 0)
                $sDeleteGeneralJournal = '';

            $sReceipt = '<td class="GridTD" align="center"><a href="#noanchor" onclick="jsOpenWindow(\'../reports/showreport.php?report=AccountsReports&reporttype=GeneralJournalReceipt&selEmployee=-1&selStation=-1&id=' . $iGeneralJournalId . '&txtReference=' . $sReference . '\', 800,600);"><img src="../images/icons/iconPrint2.gif" border="0" alt="Receipt" title="Receipt"></a></td>';

            $sDisbursmentCheque = '<td class="GridTD" align="center"><a href="#noanchor" onclick="jsOpenWindow(\'../reports/loans_disbursement_printreports.php?report=AccountsReports&reporttype=GeneralJournalReceipt&selEmployee=-1&selStation=-1&id=' . $iGeneralJournalId . '&txtReference=' . $sReference . '\', 800,600);"><img src="../images/icons/iconCheques.gif" border="0" alt="Disbursment Cheque" title="Disbursment Cheque"></a></td>';

            $sDocuments = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.MOOdalBox.open(\'../common/documents_show.php?componentname=Accounts_GeneralJournal&id=' . $iGeneralJournalId . '\', \'Documents of ' . str_replace('"', '', $sReference) . '\', \'700 420\');"><img src="../images/icons/save.gif" border="0" alt="General Journal Documents" title="General Journal Documents"></a></td>';

            if (strtolower(cAllowEditDeleteTransactions) != 'yes')
                $sEditGeneralJournal = $sDeleteGeneralJournal = '<td>&nbsp;</td>';

            $sChangeStatus = '<td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.MOOdalBox.open(\'../common/status_show.php?componentname=Accounts_GeneralJournal&id=' . $iGeneralJournalId . '\', \'Status Update for ' . str_replace('"', '', $sReference) . '\', \'700 420\');"><img src="../images/icons/tick.gif" border="0" alt="Update Status" title="Update Status"></a></td>';

            //if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournal_Documents[0] == 0) // View Disabled
            //	$sDocuments = '<td>&nbsp;</td>';

            $sReturn .= '
			<tr onMouseOver="bgColor=\'#ffe69c\';" onMouseOut="bgColor=\'' . $sTRBGColor . '\';" bgcolor="' . $sTRBGColor . '">			 
			 <td class="GridTD" align="left" valign="top">' . $sEntryType . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="left" valign="top">' . $sTransactionDate . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="left" valign="top">' . $sReference . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="left" valign="top">' . $sStationName . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="right" valign="top">' . number_format($dTransactionAmount, 0) . '<img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
                             <td class="GridTD" align="left" valign="top"><span style="color:' . ($this->VouchersArray[$iGJStatus][1]) . ';">' . ($this->VouchersArray[$iGJStatus][0]) . '</span><img src="../images/spacer.gif" border="0" alt="blank" title="blank" /></td>
			 <td class="GridTD" align="center"><a href="#noanchor" onclick="window.top.CreateTab(\'tabContainer\', \'General Jouranl Entry Details\', \'../accounts/generaljournal_details.php?id=' . $iGeneralJournalId . '\', \'520px\', true);"><img src="../images/icons/iconDetails.gif" border="0" alt="View this General Journal Entry Details" title="View this General Journal Entry Details"></a></td>
			 ' . $sEditGeneralJournal . $sReviewGeneralJournal . $sUploadGeneralJournal . $sReceipt . $sDeleteGeneralJournal . '
			</tr>';
        }

        //$sStationSelect = '<select class="form1" name="selStation" onchange="window.location=\'?StationId=\'+GetSelectedListBox(\'selStation\');" id="selStation">
        $sStationSelect = '<select class="form1" name="selStation" onchange="document.frm.submit();" id="selStation">
		<option value="0">All Offices</option>';
        $varResult = $objDB_FIS->ExecQueryAll("SELECT S.StationId,S.StationName FROM organization_stations AS S WHERE  S.Status='1' AND S.OrganizationId='" . cOrganizationId . "' ORDER BY S.StationName");
        foreach ( $varResult as $varResult)
            $sStationSelect .= '<option ' . (($iStationId1 == $varResult["StationId"]) ? 'selected="true"' : '') . ' value="' . $varResult["StationId"] . '">' . $varResult["StationName"] . '</option>';
        $sStationSelect .= '</select>';

        //$sprams = ;
        //$sVoucherTypeSelect = '<select class="form1" name="selVoucherType" onchange="window.location=\'?vouchertype=\'+GetSelectedListBox(\'selVoucherType\');" id="selVoucherType">';
        $sVoucherTypeSelect = '<select class="form1" name="selVoucherType" onchange="document.frm.submit();" id="selVoucherType">';
        $sVoucherTypeSelect .= '<option value="0">Voucher Type</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'BPV') ? 'selected="true"' : '') . ' value="BPV">BPV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'BRV') ? 'selected="true"' : '') . ' value="BRV">BRV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'CPV') ? 'selected="true"' : '') . ' value="CPV">CPV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'CRV') ? 'selected="true"' : '') . ' value="CRV">CRV</option>';
        $sVoucherTypeSelect .= '<option ' . (($sVoucherType == 'JV') ? 'selected="true"' : '') . ' value="JV">JV</option>';
        $sVoucherTypeSelect .= '</select>';

        $sAddGeneralJournal = '<input onclick="window.top.CreateTab(\'tabContainer\', \'Add New Entry\', \'../accounts/generaljournal_details.php?action2=addnew\', \'520px\', true);" type="button" class="AdminFormButton1" value="Add New">';

        if ($objEmployee->objEmployeeRoles->aEmployeeRole_FMS_Accounts_GeneralJournals[1] == 0)
            $sAddGeneralJournal = '';

        $sReturn .= '</table>
		<table border="0" cellspacing="0" cellpadding="3" width="100%" align="center">
		 <tr>
		  <td>
 		   <form method="GET" action=""><label>Search:</label><br><input type="text" class="form1" size="45" name="p" id="p" />&nbsp;<input type="image" src="../images/icons/search.gif" alt="Search for General Journal Entry" title="Search for General Journal Entry" border="0">
		  &nbsp;</td>
		  <td height="40" colspan="2" align="right">' . $sPagingString . '</td>
		  </form>
		 </tr>
		 <tr>
		  <td>
		   <form method="GET" name="frm" id="frm"> ' . $sStationSelect . ' ' . $sVoucherTypeSelect . '</form>
		  </td>
		 </tr>		
		</table>';

        return($sReturn);
    }

}

?>
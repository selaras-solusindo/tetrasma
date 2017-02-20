<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "phprptinc/ewrcfg10.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "phprptinc/ewmysql.php") ?>
<?php include_once "phprptinc/ewrfn10.php" ?>
<?php include_once "phprptinc/ewrusrfn10.php" ?>
<?php include_once "r_bukubesarsmryinfo.php" ?>
<?php

//
// Page class
//

$r_bukubesar_summary = NULL; // Initialize page object first

class crr_bukubesar_summary extends crr_bukubesar {

	// Page ID
	var $PageID = 'summary';

	// Project ID
	var $ProjectID = "{0947E56A-59DA-4545-A2FF-20A7F7239C7D}";

	// Page object name
	var $PageObjName = 'r_bukubesar_summary';

	// Page name
	function PageName() {
		return ewr_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewr_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Export URLs
	var $ExportPrintUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportPdfUrl;
	var $ReportTableClass;
	var $ReportTableStyle = "";

	// Custom export
	var $ExportPrintCustom = FALSE;
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Message
	function getMessage() {
		return @$_SESSION[EWR_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EWR_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EWR_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EWR_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_WARNING_MESSAGE], $v);
	}

		// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EWR_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EWR_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EWR_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EWR_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog ewDisplayTable\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") // Header exists, display
			echo $sHeader;
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") // Fotoer exists, display
			echo $sFooter;
	}

	// Validate page request
	function IsPageRequest() {
		if ($this->UseTokenInUrl) {
			if (ewr_IsHttpPost())
				return ($this->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $CheckToken = EWR_CHECK_TOKEN;
	var $CheckTokenFn = "ewr_CheckToken";
	var $CreateTokenFn = "ewr_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ewr_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EWR_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EWR_TOKEN_NAME]);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $ReportLanguage;
		global $UserTable, $UserTableConn;

		// Language object
		$ReportLanguage = new crLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (r_bukubesar)
		if (!isset($GLOBALS["r_bukubesar"])) {
			$GLOBALS["r_bukubesar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["r_bukubesar"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";

		// Page ID
		if (!defined("EWR_PAGE_ID"))
			define("EWR_PAGE_ID", 'summary', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWR_TABLE_NAME"))
			define("EWR_TABLE_NAME", 'r_bukubesar', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new crTimer();

		// Open connection
		if (!isset($conn)) $conn = ewr_Connect($this->DBID);

		// User table object (t_user)
		if (!isset($UserTable)) {
			$UserTable = new crt_user();
			$UserTableConn = ReportConn($UserTable->DBID);
		}

		// Export options
		$this->ExportOptions = new crListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Search options
		$this->SearchOptions = new crListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Filter options
		$this->FilterOptions = new crListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fr_bukubesarsummary";

		// Generate report options
		$this->GenerateOptions = new crListOptions();
		$this->GenerateOptions->Tag = "div";
		$this->GenerateOptions->TagClassName = "ewGenerateOption";
	}

	//
	// Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $gsEmailContentType, $ReportLanguage, $Security;
		global $gsCustomExport;

		// Security
		$Security = new crAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin(); // Auto login
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . 'r_bukubesar');
		$Security->TablePermission_Loaded();
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($ReportLanguage->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate(ewr_GetUrl("index.php"));
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();
		if ($Security->IsLoggedIn() && strval($Security->CurrentUserID()) == "") {
			$Security->SaveLastUrl();
			$this->setFailureMessage($ReportLanguage->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate(ewr_GetUrl("login.php"));
		}

		// Get export parameters
		if (@$_GET["export"] <> "")
			$this->Export = strtolower($_GET["export"]);
		elseif (@$_POST["export"] <> "")
			$this->Export = strtolower($_POST["export"]);
		$gsExport = $this->Export; // Get export parameter, used in header
		$gsExportFile = $this->TableVar; // Get export file, used in header
		$gsEmailContentType = @$_POST["contenttype"]; // Get email content type

		// Setup placeholder
		// Setup export options

		$this->SetupExportOptions();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $ReportLanguage->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Security, $ReportLanguage, $ReportOptions;
		$exportid = session_id();
		$ReportTypes = array();

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("PrinterFriendly", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("PrinterFriendly", TRUE)) . "\" href=\"" . $this->ExportPrintUrl . "\">" . $ReportLanguage->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = FALSE;
		$ReportTypes["print"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormPrint") : "";

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToExcel", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToExcel", TRUE)) . "\" href=\"" . $this->ExportExcelUrl . "\">" . $ReportLanguage->Phrase("ExportToExcel") . "</a>";
		$item->Visible = FALSE;
		$ReportTypes["excel"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormExcel") : "";

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" href=\"" . $this->ExportWordUrl . "\">" . $ReportLanguage->Phrase("ExportToWord") . "</a>";

		//$item->Visible = FALSE;
		$item->Visible = FALSE;
		$ReportTypes["word"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormWord") : "";

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" href=\"" . $this->ExportPdfUrl . "\">" . $ReportLanguage->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Uncomment codes below to show export to Pdf link
//		$item->Visible = FALSE;

		$ReportTypes["pdf"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormPdf") : "";

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = $this->PageUrl() . "export=email";
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" id=\"emf_r_bukubesar\" href=\"javascript:void(0);\" onclick=\"ewr_EmailDialogShow({lnk:'emf_r_bukubesar',hdr:ewLanguage.Phrase('ExportToEmail'),url:'$url',exportid:'$exportid',el:this});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;
		$ReportTypes["email"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormEmail") : "";
		$ReportOptions["ReportTypes"] = $ReportTypes;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = FALSE;
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = $this->ExportOptions->UseDropDownButton;
		$this->ExportOptions->DropDownButtonPhrase = $ReportLanguage->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fr_bukubesarsummary\" href=\"#\">" . $ReportLanguage->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fr_bukubesarsummary\" href=\"#\">" . $ReportLanguage->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton; // v8
		$this->FilterOptions->DropDownButtonPhrase = $ReportLanguage->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Set up options (extended)
		$this->SetupExportOptionsExt();

		// Hide options for export
		if ($this->Export <> "") {
			$this->ExportOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}

		// Set up table class
		if ($this->Export == "word" || $this->Export == "excel" || $this->Export == "pdf")
			$this->ReportTableClass = "ewTable";
		else
			$this->ReportTableClass = "table ewTable";
	}

	// Set up search options
	function SetupSearchOptions() {
		global $ReportLanguage;

		// Filter panel button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = $this->FilterApplied ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-caption=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-toggle=\"button\" data-form=\"fr_bukubesarsummary\">" . $ReportLanguage->Phrase("SearchBtn") . "</button>";
		$item->Visible = FALSE;

		// Reset filter
		$item = &$this->SearchOptions->Add("resetfilter");
		$item->Body = "<button type=\"button\" class=\"btn btn-default\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" onclick=\"location='" . ewr_CurrentPage() . "?cmd=reset'\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</button>";
		$item->Visible = FALSE && $this->FilterApplied;

		// Button group for reset filter
		$this->SearchOptions->UseButtonGroup = TRUE;

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->SearchOptions->HideAllOptions();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $ReportLanguage, $EWR_EXPORT, $gsExportFile;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		if ($this->Export <> "" && array_key_exists($this->Export, $EWR_EXPORT)) {
			$sContent = ob_get_contents();
			if (ob_get_length())
				ob_end_clean();

			// Remove all <div data-tagid="..." id="orig..." class="hide">...</div> (for customviewtag export, except "googlemaps")
			if (preg_match_all('/<div\s+data-tagid=[\'"]([\s\S]*?)[\'"]\s+id=[\'"]orig([\s\S]*?)[\'"]\s+class\s*=\s*[\'"]hide[\'"]>([\s\S]*?)<\/div\s*>/i', $sContent, $divmatches, PREG_SET_ORDER)) {
				foreach ($divmatches as $divmatch) {
					if ($divmatch[1] <> "googlemaps")
						$sContent = str_replace($divmatch[0], '', $sContent);
				}
			}
			$fn = $EWR_EXPORT[$this->Export];
			if ($this->Export == "email") { // Email
				if (@$this->GenOptions["reporttype"] == "email") {
					$saveResponse = $this->$fn($sContent, $this->GenOptions);
					$this->WriteGenResponse($saveResponse);
				} else {
					echo $this->$fn($sContent, array());
				}
				$url = ""; // Avoid redirect
			} else {
				$saveToFile = $this->$fn($sContent, $this->GenOptions);
				if (@$this->GenOptions["reporttype"] <> "") {
					$saveUrl = ($saveToFile <> "") ? ewr_ConvertFullUrl($saveToFile) : $ReportLanguage->Phrase("GenerateSuccess");
					$this->WriteGenResponse($saveUrl);
					$url = ""; // Avoid redirect
				}
			}
		}

		 // Close connection
		ewr_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EWR_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	// Initialize common variables
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $FilterOptions; // Filter options

	// Paging variables
	var $RecIndex = 0; // Record index
	var $RecCount = 0; // Record count
	var $StartGrp = 0; // Start group
	var $StopGrp = 0; // Stop group
	var $TotalGrps = 0; // Total groups
	var $GrpCount = 0; // Group count
	var $GrpCounter = array(); // Group counter
	var $DisplayGrps = 3; // Groups per page
	var $GrpRange = 10;
	var $Sort = "";
	var $Filter = "";
	var $PageFirstGroupFilter = "";
	var $UserIDFilter = "";
	var $DrillDown = FALSE;
	var $DrillDownInPanel = FALSE;
	var $DrillDownList = "";

	// Clear field for ext filter
	var $ClearExtFilter = "";
	var $PopupName = "";
	var $PopupValue = "";
	var $FilterApplied;
	var $SearchCommand = FALSE;
	var $ShowHeader;
	var $GrpColumnCount = 0;
	var $SubGrpColumnCount = 0;
	var $DtlColumnCount = 0;
	var $Cnt, $Col, $Val, $Smry, $Mn, $Mx, $GrandCnt, $GrandSmry, $GrandMn, $GrandMx;
	var $TotCount;
	var $GrandSummarySetup = FALSE;
	var $GrpIdx;
	var $DetailRows = array();

	//
	// Page main
	//
	function Page_Main() {
		global $rs;
		global $rsgrp;
		global $Security;
		global $gsFormError;
		global $gbDrillDownInPanel;
		global $ReportBreadcrumb;
		global $ReportLanguage;

		// Set field visibility for detail fields
		$this->level4_id->SetVisibility();
		$this->no_nama_akun->SetVisibility();
		$this->jurnal->SetVisibility();
		$this->jurnal_kode->SetVisibility();
		$this->no_akun->SetVisibility();
		$this->nama_akun->SetVisibility();

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 7;
		$nGrps = 1;
		$this->Val = &ewr_InitArray($nDtls, 0);
		$this->Cnt = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Smry = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Mn = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->Mx = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->GrandCnt = &ewr_InitArray($nDtls, 0);
		$this->GrandSmry = &ewr_InitArray($nDtls, 0);
		$this->GrandMn = &ewr_InitArray($nDtls, NULL);
		$this->GrandMx = &ewr_InitArray($nDtls, NULL);

		// Set up array if accumulation required: array(Accum, SkipNullOrZero)
		$this->Col = array(array(FALSE, FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE));

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Load custom filters
		$this->Page_FilterLoad();

		// Set up popup filter
		$this->SetupPopup();

		// Load group db values if necessary
		$this->LoadGroupDbValues();

		// Handle Ajax popup
		$this->ProcessAjaxPopup();

		// Extended filter
		$sExtendedFilter = "";

		// Build popup filter
		$sPopupFilter = $this->GetPopupFilter();

		//ewr_SetDebugMsg("popup filter: " . $sPopupFilter);
		ewr_AddFilter($this->Filter, $sPopupFilter);

		// No filter
		$this->FilterApplied = FALSE;
		$this->FilterOptions->GetItem("savecurrentfilter")->Visible = FALSE;
		$this->FilterOptions->GetItem("deletefilter")->Visible = FALSE;

		// Call Page Selecting event
		$this->Page_Selecting($this->Filter);

		// Search options
		$this->SetupSearchOptions();

		// Get sort
		$this->Sort = $this->GetSort($this->GenOptions);

		// Get total count
		$sSql = ewr_BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0 || $this->DrillDown) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowHeader = ($this->TotalGrps > 0);

		// Set up start position if not export all
		if ($this->ExportAll && $this->Export <> "")
			$this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup($this->GenOptions);

		// Set no record found message
		if ($this->TotalGrps == 0) {
			if ($Security->CanList()) {
				if ($this->Filter == "0=101") {
					$this->setWarningMessage($ReportLanguage->Phrase("EnterSearchCriteria"));
				} else {
					$this->setWarningMessage($ReportLanguage->Phrase("NoRecord"));
				}
			} else {
				$this->setWarningMessage($ReportLanguage->Phrase("NoPermission"));
			}
		}

		// Hide export options if export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();

		// Hide search/filter options if export/drilldown
		if ($this->Export <> "" || $this->DrillDown) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
			$this->GenerateOptions->HideAllOptions();
		}

		// Get current page records
		$rs = $this->GetRs($sSql, $this->StartGrp, $this->DisplayGrps);
		$this->SetupFieldCount();
	}

	// Accummulate summary
	function AccumulateSummary() {
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				if ($this->Col[$iy][0]) { // Accumulate required
					$valwrk = $this->Val[$iy];
					if (is_null($valwrk)) {
						if (!$this->Col[$iy][1])
							$this->Cnt[$ix][$iy]++;
					} else {
						$accum = (!$this->Col[$iy][1] || !is_numeric($valwrk) || $valwrk <> 0);
						if ($accum) {
							$this->Cnt[$ix][$iy]++;
							if (is_numeric($valwrk)) {
								$this->Smry[$ix][$iy] += $valwrk;
								if (is_null($this->Mn[$ix][$iy])) {
									$this->Mn[$ix][$iy] = $valwrk;
									$this->Mx[$ix][$iy] = $valwrk;
								} else {
									if ($this->Mn[$ix][$iy] > $valwrk) $this->Mn[$ix][$iy] = $valwrk;
									if ($this->Mx[$ix][$iy] < $valwrk) $this->Mx[$ix][$iy] = $valwrk;
								}
							}
						}
					}
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0]++;
		}
	}

	// Reset level summary
	function ResetLevelSummary($lvl) {

		// Clear summary values
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				$this->Cnt[$ix][$iy] = 0;
				if ($this->Col[$iy][0]) {
					$this->Smry[$ix][$iy] = 0;
					$this->Mn[$ix][$iy] = NULL;
					$this->Mx[$ix][$iy] = NULL;
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0] = 0;
		}

		// Reset record count
		$this->RecCount = 0;
	}

	// Accummulate grand summary
	function AccumulateGrandSummary() {
		$this->TotCount++;
		$cntgs = count($this->GrandSmry);
		for ($iy = 1; $iy < $cntgs; $iy++) {
			if ($this->Col[$iy][0]) {
				$valwrk = $this->Val[$iy];
				if (is_null($valwrk) || !is_numeric($valwrk)) {
					if (!$this->Col[$iy][1])
						$this->GrandCnt[$iy]++;
				} else {
					if (!$this->Col[$iy][1] || $valwrk <> 0) {
						$this->GrandCnt[$iy]++;
						$this->GrandSmry[$iy] += $valwrk;
						if (is_null($this->GrandMn[$iy])) {
							$this->GrandMn[$iy] = $valwrk;
							$this->GrandMx[$iy] = $valwrk;
						} else {
							if ($this->GrandMn[$iy] > $valwrk) $this->GrandMn[$iy] = $valwrk;
							if ($this->GrandMx[$iy] < $valwrk) $this->GrandMx[$iy] = $valwrk;
						}
					}
				}
			}
		}
	}

	// Get count
	function GetCnt($sql) {
		$conn = &$this->Connection();
		$rscnt = $conn->Execute($sql);
		$cnt = ($rscnt) ? $rscnt->RecordCount() : 0;
		if ($rscnt) $rscnt->Close();
		return $cnt;
	}

	// Get recordset
	function GetRs($wrksql, $start, $grps) {
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EWR_ERROR_FN"];
		$rswrk = $conn->SelectLimit($wrksql, $grps, $start - 1);
		$conn->raiseErrorFn = '';
		return $rswrk;
	}

	// Get row values
	function GetRow($opt) {
		global $rs;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row
			$rs->MoveFirst(); // Move first
				$this->FirstRowData = array();
				$this->FirstRowData['level4_id'] = ewr_Conv($rs->fields('level4_id'), 3);
				$this->FirstRowData['no_nama_akun'] = ewr_Conv($rs->fields('no_nama_akun'), 200);
				$this->FirstRowData['jurnal'] = ewr_Conv($rs->fields('jurnal'), 16);
				$this->FirstRowData['jurnal_kode'] = ewr_Conv($rs->fields('jurnal_kode'), 200);
				$this->FirstRowData['no_akun'] = ewr_Conv($rs->fields('no_akun'), 200);
				$this->FirstRowData['nama_akun'] = ewr_Conv($rs->fields('nama_akun'), 200);
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$this->level4_id->setDbValue($rs->fields('level4_id'));
			$this->no_nama_akun->setDbValue($rs->fields('no_nama_akun'));
			$this->jurnal->setDbValue($rs->fields('jurnal'));
			$this->jurnal_kode->setDbValue($rs->fields('jurnal_kode'));
			$this->no_akun->setDbValue($rs->fields('no_akun'));
			$this->nama_akun->setDbValue($rs->fields('nama_akun'));
			$this->Val[1] = $this->level4_id->CurrentValue;
			$this->Val[2] = $this->no_nama_akun->CurrentValue;
			$this->Val[3] = $this->jurnal->CurrentValue;
			$this->Val[4] = $this->jurnal_kode->CurrentValue;
			$this->Val[5] = $this->no_akun->CurrentValue;
			$this->Val[6] = $this->nama_akun->CurrentValue;
		} else {
			$this->level4_id->setDbValue("");
			$this->no_nama_akun->setDbValue("");
			$this->jurnal->setDbValue("");
			$this->jurnal_kode->setDbValue("");
			$this->no_akun->setDbValue("");
			$this->nama_akun->setDbValue("");
		}
	}

	// Set up starting group
	function SetUpStartGroup($options = array()) {

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;
		$startGrp = (@$options["start"] <> "") ? $options["start"] : @$_GET[EWR_TABLE_START_GROUP];
		$pageNo = (@$options["pageno"] <> "") ? $options["pageno"] : @$_GET["pageno"];

		// Check for a 'start' parameter
		if ($startGrp != "") {
			$this->StartGrp = $startGrp;
			$this->setStartGroup($this->StartGrp);
		} elseif ($pageNo != "") {
			$nPageNo = $pageNo;
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$this->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $this->getStartGroup();
			}
		} else {
			$this->StartGrp = $this->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$this->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$this->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$this->setStartGroup($this->StartGrp);
		}
	}

	// Load group db values if necessary
	function LoadGroupDbValues() {
		$conn = &$this->Connection();
	}

	// Process Ajax popup
	function ProcessAjaxPopup() {
		global $ReportLanguage;
		$conn = &$this->Connection();
		$fld = NULL;
		if (@$_GET["popup"] <> "") {
			$popupname = $_GET["popup"];

			// Check popup name
			// Output data as Json

			if (!is_null($fld)) {
				$jsdb = ewr_GetJsDb($fld, $fld->FldType);
				if (ob_get_length())
					ob_end_clean();
				echo $jsdb;
				exit();
			}
		}
	}

	// Set up popup
	function SetupPopup() {
		global $ReportLanguage;
		$conn = &$this->Connection();
		if ($this->DrillDown)
			return;

		// Process post back form
		if (ewr_IsHttpPost()) {
			$sName = @$_POST["popup"]; // Get popup form name
			if ($sName <> "") {
				$cntValues = (is_array(@$_POST["sel_$sName"])) ? count($_POST["sel_$sName"]) : 0;
				if ($cntValues > 0) {
					$arValues = ewr_StripSlashes($_POST["sel_$sName"]);
					if (trim($arValues[0]) == "") // Select all
						$arValues = EWR_INIT_VALUE;
					$_SESSION["sel_$sName"] = $arValues;
					$_SESSION["rf_$sName"] = ewr_StripSlashes(@$_POST["rf_$sName"]);
					$_SESSION["rt_$sName"] = ewr_StripSlashes(@$_POST["rt_$sName"]);
					$this->ResetPager();
				}
			}

		// Get 'reset' command
		} elseif (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];
			if (strtolower($sCmd) == "reset") {
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
	}

	// Reset pager
	function ResetPager() {

		// Reset start position (reset command)
		$this->StartGrp = 1;
		$this->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		$sWrk = @$_GET[EWR_TABLE_GROUP_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayGrps = intval($sWrk);
			} else {
				if (strtoupper($sWrk) == "ALL") { // Display all groups
					$this->DisplayGrps = -1;
				} else {
					$this->DisplayGrps = 3; // Non-numeric, load default
				}
			}
			$this->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$this->setStartGroup($this->StartGrp);
		} else {
			if ($this->getGroupPerPage() <> "") {
				$this->DisplayGrps = $this->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 3; // Load default
			}
		}
	}

	// Render row
	function RenderRow() {
		global $rs, $Security, $ReportLanguage;
		$conn = &$this->Connection();
		if (!$this->GrandSummarySetup) { // Get Grand total
			$bGotCount = FALSE;
			$bGotSummary = FALSE;

			// Get total count from sql directly
			$sSql = ewr_BuildReportSql($this->getSqlSelectCount(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
				$bGotCount = TRUE;
			} else {
				$this->TotCount = 0;
			}
		$bGotSummary = TRUE;

			// Accumulate grand summary from detail records
			if (!$bGotCount || !$bGotSummary) {
				$sSql = ewr_BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
				$rs = $conn->Execute($sSql);
				if ($rs) {
					$this->GetRow(1);
					while (!$rs->EOF) {
						$this->AccumulateGrandSummary();
						$this->GetRow(2);
					}
					$rs->Close();
				}
			}
			$this->GrandSummarySetup = TRUE; // No need to set up again
		}

		// Call Row_Rendering event
		$this->Row_Rendering();

		//
		// Render view codes
		//

		if ($this->RowType == EWR_ROWTYPE_TOTAL && !($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowTotalSubType == EWR_ROWTOTAL_HEADER)) { // Summary row
			ewr_PrependClass($this->RowAttrs["class"], ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel); // Set up row class

			// level4_id
			$this->level4_id->HrefValue = "";

			// no_nama_akun
			$this->no_nama_akun->HrefValue = "";

			// jurnal
			$this->jurnal->HrefValue = "";

			// jurnal_kode
			$this->jurnal_kode->HrefValue = "";

			// no_akun
			$this->no_akun->HrefValue = "";

			// nama_akun
			$this->nama_akun->HrefValue = "";
		} else {
			if ($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowTotalSubType == EWR_ROWTOTAL_HEADER) {
			} else {
			}

			// level4_id
			$this->level4_id->ViewValue = $this->level4_id->CurrentValue;
			$this->level4_id->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// no_nama_akun
			$this->no_nama_akun->ViewValue = $this->no_nama_akun->CurrentValue;
			$this->no_nama_akun->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// jurnal
			$this->jurnal->ViewValue = $this->jurnal->CurrentValue;
			$this->jurnal->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// jurnal_kode
			$this->jurnal_kode->ViewValue = $this->jurnal_kode->CurrentValue;
			$this->jurnal_kode->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// no_akun
			$this->no_akun->ViewValue = $this->no_akun->CurrentValue;
			$this->no_akun->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// nama_akun
			$this->nama_akun->ViewValue = $this->nama_akun->CurrentValue;
			$this->nama_akun->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// level4_id
			$this->level4_id->HrefValue = "";

			// no_nama_akun
			$this->no_nama_akun->HrefValue = "";

			// jurnal
			$this->jurnal->HrefValue = "";

			// jurnal_kode
			$this->jurnal_kode->HrefValue = "";

			// no_akun
			$this->no_akun->HrefValue = "";

			// nama_akun
			$this->nama_akun->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row
		} else {

			// level4_id
			$CurrentValue = $this->level4_id->CurrentValue;
			$ViewValue = &$this->level4_id->ViewValue;
			$ViewAttrs = &$this->level4_id->ViewAttrs;
			$CellAttrs = &$this->level4_id->CellAttrs;
			$HrefValue = &$this->level4_id->HrefValue;
			$LinkAttrs = &$this->level4_id->LinkAttrs;
			$this->Cell_Rendered($this->level4_id, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// no_nama_akun
			$CurrentValue = $this->no_nama_akun->CurrentValue;
			$ViewValue = &$this->no_nama_akun->ViewValue;
			$ViewAttrs = &$this->no_nama_akun->ViewAttrs;
			$CellAttrs = &$this->no_nama_akun->CellAttrs;
			$HrefValue = &$this->no_nama_akun->HrefValue;
			$LinkAttrs = &$this->no_nama_akun->LinkAttrs;
			$this->Cell_Rendered($this->no_nama_akun, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// jurnal
			$CurrentValue = $this->jurnal->CurrentValue;
			$ViewValue = &$this->jurnal->ViewValue;
			$ViewAttrs = &$this->jurnal->ViewAttrs;
			$CellAttrs = &$this->jurnal->CellAttrs;
			$HrefValue = &$this->jurnal->HrefValue;
			$LinkAttrs = &$this->jurnal->LinkAttrs;
			$this->Cell_Rendered($this->jurnal, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// jurnal_kode
			$CurrentValue = $this->jurnal_kode->CurrentValue;
			$ViewValue = &$this->jurnal_kode->ViewValue;
			$ViewAttrs = &$this->jurnal_kode->ViewAttrs;
			$CellAttrs = &$this->jurnal_kode->CellAttrs;
			$HrefValue = &$this->jurnal_kode->HrefValue;
			$LinkAttrs = &$this->jurnal_kode->LinkAttrs;
			$this->Cell_Rendered($this->jurnal_kode, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// no_akun
			$CurrentValue = $this->no_akun->CurrentValue;
			$ViewValue = &$this->no_akun->ViewValue;
			$ViewAttrs = &$this->no_akun->ViewAttrs;
			$CellAttrs = &$this->no_akun->CellAttrs;
			$HrefValue = &$this->no_akun->HrefValue;
			$LinkAttrs = &$this->no_akun->LinkAttrs;
			$this->Cell_Rendered($this->no_akun, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// nama_akun
			$CurrentValue = $this->nama_akun->CurrentValue;
			$ViewValue = &$this->nama_akun->ViewValue;
			$ViewAttrs = &$this->nama_akun->ViewAttrs;
			$CellAttrs = &$this->nama_akun->CellAttrs;
			$HrefValue = &$this->nama_akun->HrefValue;
			$LinkAttrs = &$this->nama_akun->LinkAttrs;
			$this->Cell_Rendered($this->nama_akun, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
		}

		// Call Row_Rendered event
		$this->Row_Rendered();
		$this->SetupFieldCount();
	}

	// Setup field count
	function SetupFieldCount() {
		$this->GrpColumnCount = 0;
		$this->SubGrpColumnCount = 0;
		$this->DtlColumnCount = 0;
		if ($this->level4_id->Visible) $this->DtlColumnCount += 1;
		if ($this->no_nama_akun->Visible) $this->DtlColumnCount += 1;
		if ($this->jurnal->Visible) $this->DtlColumnCount += 1;
		if ($this->jurnal_kode->Visible) $this->DtlColumnCount += 1;
		if ($this->no_akun->Visible) $this->DtlColumnCount += 1;
		if ($this->nama_akun->Visible) $this->DtlColumnCount += 1;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $ReportBreadcrumb;
		$ReportBreadcrumb = new crBreadcrumb();
		$url = substr(ewr_CurrentUrl(), strrpos(ewr_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$ReportBreadcrumb->Add("summary", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage, $ReportOptions;
		$ReportTypes = $ReportOptions["ReportTypes"];
		$ReportOptions["ReportTypes"] = $ReportTypes;
	}

	// Return popup filter
	function GetPopupFilter() {
		$sWrk = "";
		if ($this->DrillDown)
			return "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWR_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort($options = array()) {
		if ($this->DrillDown)
			return "";
		$bResetSort = @$options["resetsort"] == "1" || @$_GET["cmd"] == "resetsort";
		$orderBy = (@$options["order"] <> "") ? @$options["order"] : ewr_StripSlashes(@$_GET["order"]);
		$orderType = (@$options["ordertype"] <> "") ? @$options["ordertype"] : ewr_StripSlashes(@$_GET["ordertype"]);

		// Check for a resetsort command
		if ($bResetSort) {
			$this->setOrderBy("");
			$this->setStartGroup(1);
			$this->level4_id->setSort("");
			$this->no_nama_akun->setSort("");
			$this->jurnal->setSort("");
			$this->jurnal_kode->setSort("");
			$this->no_akun->setSort("");
			$this->nama_akun->setSort("");

		// Check for an Order parameter
		} elseif ($orderBy <> "") {
			$this->CurrentOrder = $orderBy;
			$this->CurrentOrderType = $orderType;
			$sSortSql = $this->SortSql();
			$this->setOrderBy($sSortSql);
			$this->setStartGroup(1);
		}
		return $this->getOrderBy();
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ewr_Header(FALSE) ?>
<?php

// Create page object
if (!isset($r_bukubesar_summary)) $r_bukubesar_summary = new crr_bukubesar_summary();
if (isset($Page)) $OldPage = $Page;
$Page = &$r_bukubesar_summary;

// Page init
$Page->Page_Init();

// Page main
$Page->Page_Main();

// Global Page Rendering event (in ewrusrfn*.php)
Page_Rendering();

// Page Rendering event
$Page->Page_Render();
?>
<?php include_once "header.php" ?>
<?php include_once "phprptinc/header.php" ?>
<script type="text/javascript">

// Create page object
var r_bukubesar_summary = new ewr_Page("r_bukubesar_summary");

// Page properties
r_bukubesar_summary.PageID = "summary"; // Page ID
var EWR_PAGE_ID = r_bukubesar_summary.PageID;

// Extend page with Chart_Rendering function
r_bukubesar_summary.Chart_Rendering = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// Extend page with Chart_Rendered function
r_bukubesar_summary.Chart_Rendered = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php if (!$Page->DrillDown) { ?>
<?php } ?>
<?php if (!$Page->DrillDown) { ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<!-- container (begin) -->
<div id="ewContainer" class="ewContainer">
<!-- top container (begin) -->
<div id="ewTop" class="ewTop">
<a id="top"></a>
<?php if (@$Page->GenOptions["showfilter"] == "1") { ?>
<?php $Page->ShowFilterList(TRUE) ?>
<?php } ?>
<!-- top slot -->
<div class="ewToolbar">
<?php if (!$Page->DrillDown || !$Page->DrillDownInPanel) { ?>
<?php if ($ReportBreadcrumb) $ReportBreadcrumb->Render(); ?>
<?php } ?>
<?php
if (!$Page->DrillDownInPanel) {
	$Page->ExportOptions->Render("body");
	$Page->SearchOptions->Render("body");
	$Page->FilterOptions->Render("body");
	$Page->GenerateOptions->Render("body");
}
?>
<?php if (!$Page->DrillDown) { ?>
<?php echo $ReportLanguage->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php $Page->ShowPageHeader(); ?>
<?php $Page->ShowMessage(); ?>
</div>
<!-- top container (end) -->
	<!-- left container (begin) -->
	<div id="ewLeft" class="ewLeft">
	<!-- Left slot -->
	</div>
	<!-- left container (end) -->
	<!-- center container - report (begin) -->
	<div id="ewCenter" class="ewCenter">
	<!-- center slot -->
<!-- summary report starts -->
<div id="report_summary">
<?php

// Set the last group to display if not export all
if ($Page->ExportAll && $Page->Export <> "") {
	$Page->StopGrp = $Page->TotalGrps;
} else {
	$Page->StopGrp = $Page->StartGrp + $Page->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Page->StopGrp) > intval($Page->TotalGrps))
	$Page->StopGrp = $Page->TotalGrps;
$Page->RecCount = 0;
$Page->RecIndex = 0;

// Get first row
if ($Page->TotalGrps > 0) {
	$Page->GetRow(1);
	$Page->GrpCount = 1;
}
$Page->GrpIdx = ewr_InitArray(2, -1);
$Page->GrpIdx[0] = -1;
$Page->GrpIdx[1] = $Page->StopGrp - $Page->StartGrp + 1;
while ($rs && !$rs->EOF && $Page->GrpCount <= $Page->DisplayGrps || $Page->ShowHeader) {

	// Show dummy header for custom template
	// Show header

	if ($Page->ShowHeader) {
?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="panel panel-default ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<!-- Report grid (begin) -->
<div class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="<?php echo $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($Page->level4_id->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="level4_id"><div class="r_bukubesar_level4_id"><span class="ewTableHeaderCaption"><?php echo $Page->level4_id->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="level4_id">
<?php if ($Page->SortUrl($Page->level4_id) == "") { ?>
		<div class="ewTableHeaderBtn r_bukubesar_level4_id">
			<span class="ewTableHeaderCaption"><?php echo $Page->level4_id->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r_bukubesar_level4_id" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->level4_id) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->level4_id->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->level4_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->level4_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->no_nama_akun->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="no_nama_akun"><div class="r_bukubesar_no_nama_akun"><span class="ewTableHeaderCaption"><?php echo $Page->no_nama_akun->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="no_nama_akun">
<?php if ($Page->SortUrl($Page->no_nama_akun) == "") { ?>
		<div class="ewTableHeaderBtn r_bukubesar_no_nama_akun">
			<span class="ewTableHeaderCaption"><?php echo $Page->no_nama_akun->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r_bukubesar_no_nama_akun" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->no_nama_akun) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->no_nama_akun->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->no_nama_akun->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->no_nama_akun->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->jurnal->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="jurnal"><div class="r_bukubesar_jurnal"><span class="ewTableHeaderCaption"><?php echo $Page->jurnal->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="jurnal">
<?php if ($Page->SortUrl($Page->jurnal) == "") { ?>
		<div class="ewTableHeaderBtn r_bukubesar_jurnal">
			<span class="ewTableHeaderCaption"><?php echo $Page->jurnal->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r_bukubesar_jurnal" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->jurnal) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->jurnal->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->jurnal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->jurnal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->jurnal_kode->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="jurnal_kode"><div class="r_bukubesar_jurnal_kode"><span class="ewTableHeaderCaption"><?php echo $Page->jurnal_kode->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="jurnal_kode">
<?php if ($Page->SortUrl($Page->jurnal_kode) == "") { ?>
		<div class="ewTableHeaderBtn r_bukubesar_jurnal_kode">
			<span class="ewTableHeaderCaption"><?php echo $Page->jurnal_kode->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r_bukubesar_jurnal_kode" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->jurnal_kode) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->jurnal_kode->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->jurnal_kode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->jurnal_kode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->no_akun->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="no_akun"><div class="r_bukubesar_no_akun"><span class="ewTableHeaderCaption"><?php echo $Page->no_akun->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="no_akun">
<?php if ($Page->SortUrl($Page->no_akun) == "") { ?>
		<div class="ewTableHeaderBtn r_bukubesar_no_akun">
			<span class="ewTableHeaderCaption"><?php echo $Page->no_akun->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r_bukubesar_no_akun" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->no_akun) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->no_akun->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->no_akun->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->no_akun->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->nama_akun->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="nama_akun"><div class="r_bukubesar_nama_akun"><span class="ewTableHeaderCaption"><?php echo $Page->nama_akun->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="nama_akun">
<?php if ($Page->SortUrl($Page->nama_akun) == "") { ?>
		<div class="ewTableHeaderBtn r_bukubesar_nama_akun">
			<span class="ewTableHeaderCaption"><?php echo $Page->nama_akun->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r_bukubesar_nama_akun" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->nama_akun) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->nama_akun->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->nama_akun->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->nama_akun->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
	</tr>
</thead>
<tbody>
<?php
		if ($Page->TotalGrps == 0) break; // Show header only
		$Page->ShowHeader = FALSE;
	}
	$Page->RecCount++;
	$Page->RecIndex++;
?>
<?php

		// Render detail row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_DETAIL;
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->level4_id->Visible) { ?>
		<td data-field="level4_id"<?php echo $Page->level4_id->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_r_bukubesar_level4_id"<?php echo $Page->level4_id->ViewAttributes() ?>><?php echo $Page->level4_id->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->no_nama_akun->Visible) { ?>
		<td data-field="no_nama_akun"<?php echo $Page->no_nama_akun->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_r_bukubesar_no_nama_akun"<?php echo $Page->no_nama_akun->ViewAttributes() ?>><?php echo $Page->no_nama_akun->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->jurnal->Visible) { ?>
		<td data-field="jurnal"<?php echo $Page->jurnal->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_r_bukubesar_jurnal"<?php echo $Page->jurnal->ViewAttributes() ?>><?php echo $Page->jurnal->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->jurnal_kode->Visible) { ?>
		<td data-field="jurnal_kode"<?php echo $Page->jurnal_kode->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_r_bukubesar_jurnal_kode"<?php echo $Page->jurnal_kode->ViewAttributes() ?>><?php echo $Page->jurnal_kode->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->no_akun->Visible) { ?>
		<td data-field="no_akun"<?php echo $Page->no_akun->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_r_bukubesar_no_akun"<?php echo $Page->no_akun->ViewAttributes() ?>><?php echo $Page->no_akun->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->nama_akun->Visible) { ?>
		<td data-field="nama_akun"<?php echo $Page->nama_akun->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_r_bukubesar_nama_akun"<?php echo $Page->nama_akun->ViewAttributes() ?>><?php echo $Page->nama_akun->ListViewValue() ?></span></td>
<?php } ?>
	</tr>
<?php

		// Accumulate page summary
		$Page->AccumulateSummary();

		// Get next record
		$Page->GetRow(2);
	$Page->GrpCount++;
} // End while
?>
<?php if ($Page->TotalGrps > 0) { ?>
</tbody>
<tfoot>
<?php if (($Page->StopGrp - $Page->StartGrp + 1) <> $Page->TotalGrps) { ?>
<?php
	$Page->ResetAttrs();
	$Page->RowType = EWR_ROWTYPE_TOTAL;
	$Page->RowTotalType = EWR_ROWTOTAL_PAGE;
	$Page->RowTotalSubType = EWR_ROWTOTAL_FOOTER;
	$Page->RowAttrs["class"] = "ewRptPageSummary";
	$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>><td colspan="<?php echo ($Page->GrpColumnCount + $Page->DtlColumnCount) ?>"><?php echo $ReportLanguage->Phrase("RptPageSummary") ?> <span class="ewDirLtr">(<?php echo ewr_FormatNumber($Page->Cnt[0][0],0,-2,-2,-2); ?><?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</span></td></tr>
<?php } ?>
<?php
	$Page->ResetAttrs();
	$Page->RowType = EWR_ROWTYPE_TOTAL;
	$Page->RowTotalType = EWR_ROWTOTAL_GRAND;
	$Page->RowTotalSubType = EWR_ROWTOTAL_FOOTER;
	$Page->RowAttrs["class"] = "ewRptGrandSummary";
	$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes() ?>><td colspan="<?php echo ($Page->GrpColumnCount + $Page->DtlColumnCount) ?>"><?php echo $ReportLanguage->Phrase("RptGrandSummary") ?> <span class="ewDirLtr">(<?php echo ewr_FormatNumber($Page->TotCount,0,-2,-2,-2); ?><?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</span></td></tr>
	</tfoot>
<?php } elseif (!$Page->ShowHeader && FALSE) { // No header displayed ?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="panel panel-default ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<!-- Report grid (begin) -->
<div class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="<?php echo $Page->ReportTableClass ?>">
<?php } ?>
<?php if ($Page->TotalGrps > 0 || FALSE) { // Show footer ?>
</table>
</div>
<?php if (!($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php include "r_bukubesarsmrypager.php" ?>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
</div>
<!-- Summary Report Ends -->
	</div>
	<!-- center container - report (end) -->
	<!-- right container (begin) -->
	<div id="ewRight" class="ewRight">
	<!-- Right slot -->
	</div>
	<!-- right container (end) -->
<div class="clearfix"></div>
<!-- bottom container (begin) -->
<div id="ewBottom" class="ewBottom">
	<!-- Bottom slot -->
	</div>
<!-- Bottom Container (End) -->
</div>
<!-- Table Container (End) -->
<?php $Page->ShowPageFooter(); ?>
<?php if (EWR_DEBUG_ENABLED) echo ewr_DebugMsg(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if (!$Page->DrillDown) { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "phprptinc/footer.php" ?>
<?php include_once "footer.php" ?>
<?php
$Page->Page_Terminate();
if (isset($OldPage)) $Page = $OldPage;
?>

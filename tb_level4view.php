<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "tb_level4info.php" ?>
<?php include_once "tb_userinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$tb_level4_view = NULL; // Initialize page object first

class ctb_level4_view extends ctb_level4 {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}";

	// Table name
	var $TableName = 'tb_level4';

	// Page object name
	var $PageObjName = 'tb_level4_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;
	var $AuditTrailOnAdd = FALSE;
	var $AuditTrailOnEdit = FALSE;
	var $AuditTrailOnDelete = FALSE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
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
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (tb_level4)
		if (!isset($GLOBALS["tb_level4"]) || get_class($GLOBALS["tb_level4"]) == "ctb_level4") {
			$GLOBALS["tb_level4"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_level4"];
		}
		$KeyUrl = "";
		if (@$_GET["level4_id"] <> "") {
			$this->RecKey["level4_id"] = $_GET["level4_id"];
			$KeyUrl .= "&amp;level4_id=" . urlencode($this->RecKey["level4_id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (tb_user)
		if (!isset($GLOBALS['tb_user'])) $GLOBALS['tb_user'] = new ctb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tb_level4', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (tb_user)
		if (!isset($UserTable)) {
			$UserTable = new ctb_user();
			$UserTableConn = Conn($UserTable->DBID);
		}

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanView()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("tb_level4list.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header
		if (@$_GET["level4_id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["level4_id"]);
		}

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Setup export options
		$this->SetupExportOptions();
		$this->level1_id->SetVisibility();
		$this->level2_id->SetVisibility();
		$this->level3_id->SetVisibility();
		$this->level4_no->SetVisibility();
		$this->level4_nama->SetVisibility();
		$this->saldo_awal->SetVisibility();
		$this->jurnal->SetVisibility();
		$this->jurnal_kode->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $tb_level4;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tb_level4);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["level4_id"] <> "") {
				$this->level4_id->setQueryStringValue($_GET["level4_id"]);
				$this->RecKey["level4_id"] = $this->level4_id->QueryStringValue;
			} elseif (@$_POST["level4_id"] <> "") {
				$this->level4_id->setFormValue($_POST["level4_id"]);
				$this->RecKey["level4_id"] = $this->level4_id->FormValue;
			} else {
				$sReturnUrl = "tb_level4list.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "tb_level4list.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "tb_level4list.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "',caption:'" . $addcaption . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Copy
		$item = &$option->Add("copy");
		$copycaption = ew_HtmlTitle($Language->Phrase("ViewPageCopyLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->CopyUrl) . "',caption:'" . $copycaption . "'});\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->CanAdd());

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_AddQueryStringToUrl($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderByList())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		if ($this->AuditTrailOnView) $this->WriteAuditTrailOnView($row);
		$this->level4_id->setDbValue($rs->fields('level4_id'));
		$this->level1_id->setDbValue($rs->fields('level1_id'));
		if (array_key_exists('EV__level1_id', $rs->fields)) {
			$this->level1_id->VirtualValue = $rs->fields('EV__level1_id'); // Set up virtual field value
		} else {
			$this->level1_id->VirtualValue = ""; // Clear value
		}
		$this->level2_id->setDbValue($rs->fields('level2_id'));
		if (array_key_exists('EV__level2_id', $rs->fields)) {
			$this->level2_id->VirtualValue = $rs->fields('EV__level2_id'); // Set up virtual field value
		} else {
			$this->level2_id->VirtualValue = ""; // Clear value
		}
		$this->level3_id->setDbValue($rs->fields('level3_id'));
		if (array_key_exists('EV__level3_id', $rs->fields)) {
			$this->level3_id->VirtualValue = $rs->fields('EV__level3_id'); // Set up virtual field value
		} else {
			$this->level3_id->VirtualValue = ""; // Clear value
		}
		$this->level4_no->setDbValue($rs->fields('level4_no'));
		$this->level4_nama->setDbValue($rs->fields('level4_nama'));
		$this->saldo_awal->setDbValue($rs->fields('saldo_awal'));
		$this->saldo->setDbValue($rs->fields('saldo'));
		$this->jurnal->setDbValue($rs->fields('jurnal'));
		$this->jurnal_kode->setDbValue($rs->fields('jurnal_kode'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->level4_id->DbValue = $row['level4_id'];
		$this->level1_id->DbValue = $row['level1_id'];
		$this->level2_id->DbValue = $row['level2_id'];
		$this->level3_id->DbValue = $row['level3_id'];
		$this->level4_no->DbValue = $row['level4_no'];
		$this->level4_nama->DbValue = $row['level4_nama'];
		$this->saldo_awal->DbValue = $row['saldo_awal'];
		$this->saldo->DbValue = $row['saldo'];
		$this->jurnal->DbValue = $row['jurnal'];
		$this->jurnal_kode->DbValue = $row['jurnal_kode'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// level4_id
		// level1_id
		// level2_id
		// level3_id
		// level4_no
		// level4_nama
		// saldo_awal
		// saldo
		// jurnal
		// jurnal_kode

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// level1_id
		if ($this->level1_id->VirtualValue <> "") {
			$this->level1_id->ViewValue = $this->level1_id->VirtualValue;
		} else {
			$this->level1_id->ViewValue = $this->level1_id->CurrentValue;
		if (strval($this->level1_id->CurrentValue) <> "") {
			$sFilterWrk = "`level1_id`" . ew_SearchString("=", $this->level1_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `level1_id`, `level1_no` AS `DispFld`, `level1_nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tb_level1`";
		$sWhereWrk = "";
		$this->level1_id->LookupFilters = array("dx1" => '`level1_no`', "dx2" => '`level1_nama`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->level1_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->level1_id->ViewValue = $this->level1_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->level1_id->ViewValue = $this->level1_id->CurrentValue;
			}
		} else {
			$this->level1_id->ViewValue = NULL;
		}
		}
		$this->level1_id->ViewCustomAttributes = "";

		// level2_id
		if ($this->level2_id->VirtualValue <> "") {
			$this->level2_id->ViewValue = $this->level2_id->VirtualValue;
		} else {
			$this->level2_id->ViewValue = $this->level2_id->CurrentValue;
		if (strval($this->level2_id->CurrentValue) <> "") {
			$sFilterWrk = "`level2_id`" . ew_SearchString("=", $this->level2_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `level2_id`, `level2_no` AS `DispFld`, `level2_nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tb_level2`";
		$sWhereWrk = "";
		$this->level2_id->LookupFilters = array("dx1" => '`level2_no`', "dx2" => '`level2_nama`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->level2_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->level2_id->ViewValue = $this->level2_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->level2_id->ViewValue = $this->level2_id->CurrentValue;
			}
		} else {
			$this->level2_id->ViewValue = NULL;
		}
		}
		$this->level2_id->ViewCustomAttributes = "";

		// level3_id
		if ($this->level3_id->VirtualValue <> "") {
			$this->level3_id->ViewValue = $this->level3_id->VirtualValue;
		} else {
			$this->level3_id->ViewValue = $this->level3_id->CurrentValue;
		if (strval($this->level3_id->CurrentValue) <> "") {
			$sFilterWrk = "`level3_id`" . ew_SearchString("=", $this->level3_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `level3_id`, `level3_no` AS `DispFld`, `level3_nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tb_level3`";
		$sWhereWrk = "";
		$this->level3_id->LookupFilters = array("dx1" => '`level3_no`', "dx2" => '`level3_nama`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->level3_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->level3_id->ViewValue = $this->level3_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->level3_id->ViewValue = $this->level3_id->CurrentValue;
			}
		} else {
			$this->level3_id->ViewValue = NULL;
		}
		}
		$this->level3_id->ViewCustomAttributes = "";

		// level4_no
		$this->level4_no->ViewValue = $this->level4_no->CurrentValue;
		$this->level4_no->ViewCustomAttributes = "";

		// level4_nama
		$this->level4_nama->ViewValue = $this->level4_nama->CurrentValue;
		$this->level4_nama->ViewCustomAttributes = "";

		// saldo_awal
		$this->saldo_awal->ViewValue = $this->saldo_awal->CurrentValue;
		$this->saldo_awal->ViewValue = ew_FormatNumber($this->saldo_awal->ViewValue, 0, -2, -2, -1);
		$this->saldo_awal->CellCssStyle .= "text-align: right;";
		$this->saldo_awal->ViewCustomAttributes = "";

		// jurnal
		if (strval($this->jurnal->CurrentValue) <> "") {
			$this->jurnal->ViewValue = $this->jurnal->OptionCaption($this->jurnal->CurrentValue);
		} else {
			$this->jurnal->ViewValue = NULL;
		}
		$this->jurnal->ViewCustomAttributes = "";

		// jurnal_kode
		if (strval($this->jurnal_kode->CurrentValue) <> "") {
			$this->jurnal_kode->ViewValue = $this->jurnal_kode->OptionCaption($this->jurnal_kode->CurrentValue);
		} else {
			$this->jurnal_kode->ViewValue = NULL;
		}
		$this->jurnal_kode->ViewCustomAttributes = "";

			// level1_id
			$this->level1_id->LinkCustomAttributes = "";
			$this->level1_id->HrefValue = "";
			$this->level1_id->TooltipValue = "";

			// level2_id
			$this->level2_id->LinkCustomAttributes = "";
			$this->level2_id->HrefValue = "";
			$this->level2_id->TooltipValue = "";

			// level3_id
			$this->level3_id->LinkCustomAttributes = "";
			$this->level3_id->HrefValue = "";
			$this->level3_id->TooltipValue = "";

			// level4_no
			$this->level4_no->LinkCustomAttributes = "";
			$this->level4_no->HrefValue = "";
			$this->level4_no->TooltipValue = "";

			// level4_nama
			$this->level4_nama->LinkCustomAttributes = "";
			$this->level4_nama->HrefValue = "";
			$this->level4_nama->TooltipValue = "";

			// saldo_awal
			$this->saldo_awal->LinkCustomAttributes = "";
			$this->saldo_awal->HrefValue = "";
			$this->saldo_awal->TooltipValue = "";

			// jurnal
			$this->jurnal->LinkCustomAttributes = "";
			$this->jurnal->HrefValue = "";
			$this->jurnal->TooltipValue = "";

			// jurnal_kode
			$this->jurnal_kode->LinkCustomAttributes = "";
			$this->jurnal_kode->HrefValue = "";
			$this->jurnal_kode->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = TRUE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = TRUE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_tb_level4\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_tb_level4',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.ftb_level4view,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = TRUE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = TRUE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;
		$this->SetUpStartRec(); // Set up start record position

		// Set the last record to display
		if ($this->DisplayRecs <= 0) {
			$this->StopRec = $this->TotalRecs;
		} else {
			$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
		}
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "v");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "view");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		if ($this->Export == "email") {
			echo $this->ExportEmail($Doc->Text);
		} else {
			$Doc->Export();
		}
	}

	// Export email
	function ExportEmail($EmailContent) {
		global $gTmpImages, $Language;
		$sSender = @$_POST["sender"];
		$sRecipient = @$_POST["recipient"];
		$sCc = @$_POST["cc"];
		$sBcc = @$_POST["bcc"];
		$sContentType = @$_POST["contenttype"];

		// Subject
		$sSubject = ew_StripSlashes(@$_POST["subject"]);
		$sEmailSubject = $sSubject;

		// Message
		$sContent = ew_StripSlashes(@$_POST["message"]);
		$sEmailMessage = $sContent;

		// Check sender
		if ($sSender == "") {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterSenderEmail") . "</p>";
		}
		if (!ew_CheckEmail($sSender)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperSenderEmail") . "</p>";
		}

		// Check recipient
		if (!ew_CheckEmailList($sRecipient, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperRecipientEmail") . "</p>";
		}

		// Check cc
		if (!ew_CheckEmailList($sCc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperCcEmail") . "</p>";
		}

		// Check bcc
		if (!ew_CheckEmailList($sBcc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperBccEmail") . "</p>";
		}

		// Check email sent count
		if (!isset($_SESSION[EW_EXPORT_EMAIL_COUNTER]))
			$_SESSION[EW_EXPORT_EMAIL_COUNTER] = 0;
		if (intval($_SESSION[EW_EXPORT_EMAIL_COUNTER]) > EW_MAX_EMAIL_SENT_COUNT) {
			return "<p class=\"text-danger\">" . $Language->Phrase("ExceedMaxEmailExport") . "</p>";
		}

		// Send email
		$Email = new cEmail();
		$Email->Sender = $sSender; // Sender
		$Email->Recipient = $sRecipient; // Recipient
		$Email->Cc = $sCc; // Cc
		$Email->Bcc = $sBcc; // Bcc
		$Email->Subject = $sEmailSubject; // Subject
		$Email->Format = ($sContentType == "url") ? "text" : "html";
		if ($sEmailMessage <> "") {
			$sEmailMessage = ew_RemoveXSS($sEmailMessage);
			$sEmailMessage .= ($sContentType == "url") ? "\r\n\r\n" : "<br><br>";
		}
		if ($sContentType == "url") {
			$sUrl = ew_ConvertFullUrl(ew_CurrentPage() . "?" . $this->ExportQueryString());
			$sEmailMessage .= $sUrl; // Send URL only
		} else {
			foreach ($gTmpImages as $tmpimage)
				$Email->AddEmbeddedImage($tmpimage);
			$sEmailMessage .= ew_CleanEmailContent($EmailContent); // Send HTML
		}
		$Email->Content = $sEmailMessage; // Content
		$EventArgs = array();
		if ($this->Recordset) {
			$this->RecCnt = $this->StartRec - 1;
			$this->Recordset->MoveFirst();
			if ($this->StartRec > 1)
				$this->Recordset->Move($this->StartRec - 1);
			$EventArgs["rs"] = &$this->Recordset;
		}
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $EventArgs))
			$bEmailSent = $Email->Send();

		// Check email sent status
		if ($bEmailSent) {

			// Update email sent count
			$_SESSION[EW_EXPORT_EMAIL_COUNTER]++;

			// Sent email success
			return "<p class=\"text-success\">" . $Language->Phrase("SendEmailSuccess") . "</p>"; // Set up success message
		} else {

			// Sent email failure
			return "<p class=\"text-danger\">" . $Email->SendErrDescription . "</p>";
		}
	}

	// Export QueryString
	function ExportQueryString() {

		// Initialize
		$sQry = "export=html";

		// Add record key QueryString
		$sQry .= "&" . substr($this->KeyUrl("", ""), 1);
		return $sQry;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_level4list.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'tb_level4';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

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

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tb_level4_view)) $tb_level4_view = new ctb_level4_view();

// Page init
$tb_level4_view->Page_Init();

// Page main
$tb_level4_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_level4_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($tb_level4->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = ftb_level4view = new ew_Form("ftb_level4view", "view");

// Form_CustomValidate event
ftb_level4view.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftb_level4view.ValidateRequired = true;
<?php } else { ?>
ftb_level4view.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftb_level4view.Lists["x_level1_id"] = {"LinkField":"x_level1_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_level1_no","x_level1_nama","",""],"ParentFields":[],"ChildFields":["x_level2_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tb_level1"};
ftb_level4view.Lists["x_level2_id"] = {"LinkField":"x_level2_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_level2_no","x_level2_nama","",""],"ParentFields":[],"ChildFields":["x_level3_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tb_level2"};
ftb_level4view.Lists["x_level3_id"] = {"LinkField":"x_level3_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_level3_no","x_level3_nama","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tb_level3"};
ftb_level4view.Lists["x_jurnal"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftb_level4view.Lists["x_jurnal"].Options = <?php echo json_encode($tb_level4->jurnal->Options()) ?>;
ftb_level4view.Lists["x_jurnal_kode"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftb_level4view.Lists["x_jurnal_kode"].Options = <?php echo json_encode($tb_level4->jurnal_kode->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($tb_level4->Export == "") { ?>
<div class="ewToolbar">
<?php if (!$tb_level4_view->IsModal) { ?>
<?php if ($tb_level4->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php } ?>
<?php $tb_level4_view->ExportOptions->Render("body") ?>
<?php
	foreach ($tb_level4_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$tb_level4_view->IsModal) { ?>
<?php if ($tb_level4->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $tb_level4_view->ShowPageHeader(); ?>
<?php
$tb_level4_view->ShowMessage();
?>
<form name="ftb_level4view" id="ftb_level4view" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_level4_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_level4_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_level4">
<?php if ($tb_level4_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($tb_level4->level1_id->Visible) { // level1_id ?>
	<tr id="r_level1_id">
		<td><span id="elh_tb_level4_level1_id"><?php echo $tb_level4->level1_id->FldCaption() ?></span></td>
		<td data-name="level1_id"<?php echo $tb_level4->level1_id->CellAttributes() ?>>
<span id="el_tb_level4_level1_id">
<span<?php echo $tb_level4->level1_id->ViewAttributes() ?>>
<?php echo $tb_level4->level1_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_level4->level2_id->Visible) { // level2_id ?>
	<tr id="r_level2_id">
		<td><span id="elh_tb_level4_level2_id"><?php echo $tb_level4->level2_id->FldCaption() ?></span></td>
		<td data-name="level2_id"<?php echo $tb_level4->level2_id->CellAttributes() ?>>
<span id="el_tb_level4_level2_id">
<span<?php echo $tb_level4->level2_id->ViewAttributes() ?>>
<?php echo $tb_level4->level2_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_level4->level3_id->Visible) { // level3_id ?>
	<tr id="r_level3_id">
		<td><span id="elh_tb_level4_level3_id"><?php echo $tb_level4->level3_id->FldCaption() ?></span></td>
		<td data-name="level3_id"<?php echo $tb_level4->level3_id->CellAttributes() ?>>
<span id="el_tb_level4_level3_id">
<span<?php echo $tb_level4->level3_id->ViewAttributes() ?>>
<?php echo $tb_level4->level3_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_level4->level4_no->Visible) { // level4_no ?>
	<tr id="r_level4_no">
		<td><span id="elh_tb_level4_level4_no"><?php echo $tb_level4->level4_no->FldCaption() ?></span></td>
		<td data-name="level4_no"<?php echo $tb_level4->level4_no->CellAttributes() ?>>
<span id="el_tb_level4_level4_no">
<span<?php echo $tb_level4->level4_no->ViewAttributes() ?>>
<?php echo $tb_level4->level4_no->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_level4->level4_nama->Visible) { // level4_nama ?>
	<tr id="r_level4_nama">
		<td><span id="elh_tb_level4_level4_nama"><?php echo $tb_level4->level4_nama->FldCaption() ?></span></td>
		<td data-name="level4_nama"<?php echo $tb_level4->level4_nama->CellAttributes() ?>>
<span id="el_tb_level4_level4_nama">
<span<?php echo $tb_level4->level4_nama->ViewAttributes() ?>>
<?php echo $tb_level4->level4_nama->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_level4->saldo_awal->Visible) { // saldo_awal ?>
	<tr id="r_saldo_awal">
		<td><span id="elh_tb_level4_saldo_awal"><?php echo $tb_level4->saldo_awal->FldCaption() ?></span></td>
		<td data-name="saldo_awal"<?php echo $tb_level4->saldo_awal->CellAttributes() ?>>
<span id="el_tb_level4_saldo_awal">
<span<?php echo $tb_level4->saldo_awal->ViewAttributes() ?>>
<?php echo $tb_level4->saldo_awal->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_level4->jurnal->Visible) { // jurnal ?>
	<tr id="r_jurnal">
		<td><span id="elh_tb_level4_jurnal"><?php echo $tb_level4->jurnal->FldCaption() ?></span></td>
		<td data-name="jurnal"<?php echo $tb_level4->jurnal->CellAttributes() ?>>
<span id="el_tb_level4_jurnal">
<span<?php echo $tb_level4->jurnal->ViewAttributes() ?>>
<?php echo $tb_level4->jurnal->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_level4->jurnal_kode->Visible) { // jurnal_kode ?>
	<tr id="r_jurnal_kode">
		<td><span id="elh_tb_level4_jurnal_kode"><?php echo $tb_level4->jurnal_kode->FldCaption() ?></span></td>
		<td data-name="jurnal_kode"<?php echo $tb_level4->jurnal_kode->CellAttributes() ?>>
<span id="el_tb_level4_jurnal_kode">
<span<?php echo $tb_level4->jurnal_kode->ViewAttributes() ?>>
<?php echo $tb_level4->jurnal_kode->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php if ($tb_level4->Export == "") { ?>
<script type="text/javascript">
ftb_level4view.Init();
</script>
<?php } ?>
<?php
$tb_level4_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($tb_level4->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$tb_level4_view->Page_Terminate();
?>

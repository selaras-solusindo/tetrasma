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

$tb_level4_edit = NULL; // Initialize page object first

class ctb_level4_edit extends ctb_level4 {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}";

	// Table name
	var $TableName = 'tb_level4';

	// Page object name
	var $PageObjName = 'tb_level4_edit';

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
	var $AuditTrailOnAdd = FALSE;
	var $AuditTrailOnEdit = TRUE;
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

		// Table object (tb_user)
		if (!isset($GLOBALS['tb_user'])) $GLOBALS['tb_user'] = new ctb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("tb_level4list.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load key from QueryString
		if (@$_GET["level4_id"] <> "") {
			$this->level4_id->setQueryStringValue($_GET["level4_id"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->level4_id->CurrentValue == "") {
			$this->Page_Terminate("tb_level4list.php"); // Invalid key, return to list
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("tb_level4list.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "tb_level4list.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->level1_id->FldIsDetailKey) {
			$this->level1_id->setFormValue($objForm->GetValue("x_level1_id"));
		}
		if (!$this->level2_id->FldIsDetailKey) {
			$this->level2_id->setFormValue($objForm->GetValue("x_level2_id"));
		}
		if (!$this->level3_id->FldIsDetailKey) {
			$this->level3_id->setFormValue($objForm->GetValue("x_level3_id"));
		}
		if (!$this->level4_no->FldIsDetailKey) {
			$this->level4_no->setFormValue($objForm->GetValue("x_level4_no"));
		}
		if (!$this->level4_nama->FldIsDetailKey) {
			$this->level4_nama->setFormValue($objForm->GetValue("x_level4_nama"));
		}
		if (!$this->saldo_awal->FldIsDetailKey) {
			$this->saldo_awal->setFormValue($objForm->GetValue("x_saldo_awal"));
		}
		if (!$this->jurnal->FldIsDetailKey) {
			$this->jurnal->setFormValue($objForm->GetValue("x_jurnal"));
		}
		if (!$this->jurnal_kode->FldIsDetailKey) {
			$this->jurnal_kode->setFormValue($objForm->GetValue("x_jurnal_kode"));
		}
		if (!$this->level4_id->FldIsDetailKey)
			$this->level4_id->setFormValue($objForm->GetValue("x_level4_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->level4_id->CurrentValue = $this->level4_id->FormValue;
		$this->level1_id->CurrentValue = $this->level1_id->FormValue;
		$this->level2_id->CurrentValue = $this->level2_id->FormValue;
		$this->level3_id->CurrentValue = $this->level3_id->FormValue;
		$this->level4_no->CurrentValue = $this->level4_no->FormValue;
		$this->level4_nama->CurrentValue = $this->level4_nama->FormValue;
		$this->saldo_awal->CurrentValue = $this->saldo_awal->FormValue;
		$this->jurnal->CurrentValue = $this->jurnal->FormValue;
		$this->jurnal_kode->CurrentValue = $this->jurnal_kode->FormValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// level1_id
			$this->level1_id->EditAttrs["class"] = "form-control";
			$this->level1_id->EditCustomAttributes = "";
			$this->level1_id->EditValue = ew_HtmlEncode($this->level1_id->CurrentValue);
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
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->level1_id->EditValue = $this->level1_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->level1_id->EditValue = ew_HtmlEncode($this->level1_id->CurrentValue);
				}
			} else {
				$this->level1_id->EditValue = NULL;
			}
			$this->level1_id->PlaceHolder = ew_RemoveHtml($this->level1_id->FldCaption());

			// level2_id
			$this->level2_id->EditAttrs["class"] = "form-control";
			$this->level2_id->EditCustomAttributes = "";
			$this->level2_id->EditValue = ew_HtmlEncode($this->level2_id->CurrentValue);
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
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->level2_id->EditValue = $this->level2_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->level2_id->EditValue = ew_HtmlEncode($this->level2_id->CurrentValue);
				}
			} else {
				$this->level2_id->EditValue = NULL;
			}
			$this->level2_id->PlaceHolder = ew_RemoveHtml($this->level2_id->FldCaption());

			// level3_id
			$this->level3_id->EditAttrs["class"] = "form-control";
			$this->level3_id->EditCustomAttributes = "";
			$this->level3_id->EditValue = ew_HtmlEncode($this->level3_id->CurrentValue);
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
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->level3_id->EditValue = $this->level3_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->level3_id->EditValue = ew_HtmlEncode($this->level3_id->CurrentValue);
				}
			} else {
				$this->level3_id->EditValue = NULL;
			}
			$this->level3_id->PlaceHolder = ew_RemoveHtml($this->level3_id->FldCaption());

			// level4_no
			$this->level4_no->EditAttrs["class"] = "form-control";
			$this->level4_no->EditCustomAttributes = "";
			$this->level4_no->EditValue = ew_HtmlEncode($this->level4_no->CurrentValue);
			$this->level4_no->PlaceHolder = ew_RemoveHtml($this->level4_no->FldCaption());

			// level4_nama
			$this->level4_nama->EditAttrs["class"] = "form-control";
			$this->level4_nama->EditCustomAttributes = "";
			$this->level4_nama->EditValue = ew_HtmlEncode($this->level4_nama->CurrentValue);
			$this->level4_nama->PlaceHolder = ew_RemoveHtml($this->level4_nama->FldCaption());

			// saldo_awal
			$this->saldo_awal->EditAttrs["class"] = "form-control";
			$this->saldo_awal->EditCustomAttributes = "";
			$this->saldo_awal->EditValue = ew_HtmlEncode($this->saldo_awal->CurrentValue);
			$this->saldo_awal->PlaceHolder = ew_RemoveHtml($this->saldo_awal->FldCaption());

			// jurnal
			$this->jurnal->EditCustomAttributes = "";
			$this->jurnal->EditValue = $this->jurnal->Options(FALSE);

			// jurnal_kode
			$this->jurnal_kode->EditCustomAttributes = "";
			$this->jurnal_kode->EditValue = $this->jurnal_kode->Options(FALSE);

			// Edit refer script
			// level1_id

			$this->level1_id->LinkCustomAttributes = "";
			$this->level1_id->HrefValue = "";

			// level2_id
			$this->level2_id->LinkCustomAttributes = "";
			$this->level2_id->HrefValue = "";

			// level3_id
			$this->level3_id->LinkCustomAttributes = "";
			$this->level3_id->HrefValue = "";

			// level4_no
			$this->level4_no->LinkCustomAttributes = "";
			$this->level4_no->HrefValue = "";

			// level4_nama
			$this->level4_nama->LinkCustomAttributes = "";
			$this->level4_nama->HrefValue = "";

			// saldo_awal
			$this->saldo_awal->LinkCustomAttributes = "";
			$this->saldo_awal->HrefValue = "";

			// jurnal
			$this->jurnal->LinkCustomAttributes = "";
			$this->jurnal->HrefValue = "";

			// jurnal_kode
			$this->jurnal_kode->LinkCustomAttributes = "";
			$this->jurnal_kode->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->level1_id->FldIsDetailKey && !is_null($this->level1_id->FormValue) && $this->level1_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->level1_id->FldCaption(), $this->level1_id->ReqErrMsg));
		}
		if (!$this->level2_id->FldIsDetailKey && !is_null($this->level2_id->FormValue) && $this->level2_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->level2_id->FldCaption(), $this->level2_id->ReqErrMsg));
		}
		if (!$this->level3_id->FldIsDetailKey && !is_null($this->level3_id->FormValue) && $this->level3_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->level3_id->FldCaption(), $this->level3_id->ReqErrMsg));
		}
		if (!$this->level4_no->FldIsDetailKey && !is_null($this->level4_no->FormValue) && $this->level4_no->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->level4_no->FldCaption(), $this->level4_no->ReqErrMsg));
		}
		if (!$this->level4_nama->FldIsDetailKey && !is_null($this->level4_nama->FormValue) && $this->level4_nama->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->level4_nama->FldCaption(), $this->level4_nama->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->saldo_awal->FormValue)) {
			ew_AddMessage($gsFormError, $this->saldo_awal->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// level1_id
			$this->level1_id->SetDbValueDef($rsnew, $this->level1_id->CurrentValue, 0, $this->level1_id->ReadOnly);

			// level2_id
			$this->level2_id->SetDbValueDef($rsnew, $this->level2_id->CurrentValue, 0, $this->level2_id->ReadOnly);

			// level3_id
			$this->level3_id->SetDbValueDef($rsnew, $this->level3_id->CurrentValue, 0, $this->level3_id->ReadOnly);

			// level4_no
			$this->level4_no->SetDbValueDef($rsnew, $this->level4_no->CurrentValue, "", $this->level4_no->ReadOnly);

			// level4_nama
			$this->level4_nama->SetDbValueDef($rsnew, $this->level4_nama->CurrentValue, "", $this->level4_nama->ReadOnly);

			// saldo_awal
			$this->saldo_awal->SetDbValueDef($rsnew, $this->saldo_awal->CurrentValue, NULL, $this->saldo_awal->ReadOnly);

			// jurnal
			$this->jurnal->SetDbValueDef($rsnew, $this->jurnal->CurrentValue, NULL, $this->jurnal->ReadOnly);

			// jurnal_kode
			$this->jurnal_kode->SetDbValueDef($rsnew, $this->jurnal_kode->CurrentValue, NULL, $this->jurnal_kode->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		if ($EditRow) {
			$this->WriteAuditTrailOnEdit($rsold, $rsnew);
		}
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_level4list.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_level1_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `level1_id` AS `LinkFld`, `level1_no` AS `DispFld`, `level1_nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tb_level1`";
			$sWhereWrk = "{filter}";
			$this->level1_id->LookupFilters = array("dx1" => '`level1_no`', "dx2" => '`level1_nama`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`level1_id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->level1_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_level2_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `level2_id` AS `LinkFld`, `level2_no` AS `DispFld`, `level2_nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tb_level2`";
			$sWhereWrk = "{filter}";
			$this->level2_id->LookupFilters = array("dx1" => '`level2_no`', "dx2" => '`level2_nama`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`level2_id` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`level1_id` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->level2_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_level3_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `level3_id` AS `LinkFld`, `level3_no` AS `DispFld`, `level3_nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tb_level3`";
			$sWhereWrk = "{filter}";
			$this->level3_id->LookupFilters = array("dx1" => '`level3_no`', "dx2" => '`level3_nama`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`level3_id` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`level2_id` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->level3_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_level1_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `level1_id`, `level1_no` AS `DispFld`, `level1_nama` AS `Disp2Fld` FROM `tb_level1`";
			$sWhereWrk = "`level1_no` LIKE '{query_value}%' OR CONCAT(`level1_no`,'" . ew_ValueSeparator(1, $this->level1_id) . "',`level1_nama`) LIKE '{query_value}%'";
			$this->level1_id->LookupFilters = array("dx1" => '`level1_no`', "dx2" => '`level1_nama`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->level1_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_level2_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `level2_id`, `level2_no` AS `DispFld`, `level2_nama` AS `Disp2Fld` FROM `tb_level2`";
			$sWhereWrk = "(`level2_no` LIKE '{query_value}%' OR CONCAT(`level2_no`,'" . ew_ValueSeparator(1, $this->level2_id) . "',`level2_nama`) LIKE '{query_value}%') AND ({filter})";
			$this->level2_id->LookupFilters = array("dx1" => '`level2_no`', "dx2" => '`level2_nama`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f1" => "`level1_id` IN ({filter_value})", "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->level2_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_level3_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `level3_id`, `level3_no` AS `DispFld`, `level3_nama` AS `Disp2Fld` FROM `tb_level3`";
			$sWhereWrk = "(`level3_no` LIKE '{query_value}%' OR CONCAT(`level3_no`,'" . ew_ValueSeparator(1, $this->level3_id) . "',`level3_nama`) LIKE '{query_value}%') AND ({filter})";
			$this->level3_id->LookupFilters = array("dx1" => '`level3_no`', "dx2" => '`level3_nama`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f1" => "`level2_id` IN ({filter_value})", "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->level3_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'tb_level4';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'tb_level4';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['level4_id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserName();
		foreach (array_keys($rsnew) as $fldname) {
			if ($this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_DATE) { // DateTime field
					$modified = (ew_FormatDateTime($rsold[$fldname], 0) <> ew_FormatDateTime($rsnew[$fldname], 0));
				} else {
					$modified = !ew_CompareValue($rsold[$fldname], $rsnew[$fldname]);
				}
				if ($modified) {
					if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") { // Password Field
						$oldvalue = $Language->Phrase("PasswordMask");
						$newvalue = $Language->Phrase("PasswordMask");
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) { // Memo field
						if (EW_AUDIT_TRAIL_TO_DATABASE) {
							$oldvalue = $rsold[$fldname];
							$newvalue = $rsnew[$fldname];
						} else {
							$oldvalue = "[MEMO]";
							$newvalue = "[MEMO]";
						}
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) { // XML field
						$oldvalue = "[XML]";
						$newvalue = "[XML]";
					} else {
						$oldvalue = $rsold[$fldname];
						$newvalue = $rsnew[$fldname];
					}
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
			}
		}
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tb_level4_edit)) $tb_level4_edit = new ctb_level4_edit();

// Page init
$tb_level4_edit->Page_Init();

// Page main
$tb_level4_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_level4_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ftb_level4edit = new ew_Form("ftb_level4edit", "edit");

// Validate form
ftb_level4edit.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_level1_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_level4->level1_id->FldCaption(), $tb_level4->level1_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_level2_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_level4->level2_id->FldCaption(), $tb_level4->level2_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_level3_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_level4->level3_id->FldCaption(), $tb_level4->level3_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_level4_no");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_level4->level4_no->FldCaption(), $tb_level4->level4_no->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_level4_nama");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_level4->level4_nama->FldCaption(), $tb_level4->level4_nama->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_saldo_awal");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_level4->saldo_awal->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
ftb_level4edit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftb_level4edit.ValidateRequired = true;
<?php } else { ?>
ftb_level4edit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftb_level4edit.Lists["x_level1_id"] = {"LinkField":"x_level1_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_level1_no","x_level1_nama","",""],"ParentFields":[],"ChildFields":["x_level2_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tb_level1"};
ftb_level4edit.Lists["x_level2_id"] = {"LinkField":"x_level2_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_level2_no","x_level2_nama","",""],"ParentFields":["x_level1_id"],"ChildFields":["x_level3_id"],"FilterFields":["x_level1_id"],"Options":[],"Template":"","LinkTable":"tb_level2"};
ftb_level4edit.Lists["x_level3_id"] = {"LinkField":"x_level3_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_level3_no","x_level3_nama","",""],"ParentFields":["x_level2_id"],"ChildFields":[],"FilterFields":["x_level2_id"],"Options":[],"Template":"","LinkTable":"tb_level3"};
ftb_level4edit.Lists["x_jurnal"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftb_level4edit.Lists["x_jurnal"].Options = <?php echo json_encode($tb_level4->jurnal->Options()) ?>;
ftb_level4edit.Lists["x_jurnal_kode"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftb_level4edit.Lists["x_jurnal_kode"].Options = <?php echo json_encode($tb_level4->jurnal_kode->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$tb_level4_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $tb_level4_edit->ShowPageHeader(); ?>
<?php
$tb_level4_edit->ShowMessage();
?>
<form name="ftb_level4edit" id="ftb_level4edit" class="<?php echo $tb_level4_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_level4_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_level4_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_level4">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($tb_level4_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($tb_level4->level1_id->Visible) { // level1_id ?>
	<div id="r_level1_id" class="form-group">
		<label id="elh_tb_level4_level1_id" class="col-sm-2 control-label ewLabel"><?php echo $tb_level4->level1_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_level4->level1_id->CellAttributes() ?>>
<span id="el_tb_level4_level1_id">
<?php
$wrkonchange = trim("ew_UpdateOpt.call(this); " . @$tb_level4->level1_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_level4->level1_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_level1_id" style="white-space: nowrap; z-index: 8980">
	<input type="text" name="sv_x_level1_id" id="sv_x_level1_id" value="<?php echo $tb_level4->level1_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($tb_level4->level1_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_level4->level1_id->getPlaceHolder()) ?>"<?php echo $tb_level4->level1_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_level4" data-field="x_level1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_level4->level1_id->DisplayValueSeparatorAttribute() ?>" name="x_level1_id" id="x_level1_id" value="<?php echo ew_HtmlEncode($tb_level4->level1_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_level1_id" id="q_x_level1_id" value="<?php echo $tb_level4->level1_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ftb_level4edit.CreateAutoSuggest({"id":"x_level1_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_level4->level1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_level1_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x_level1_id" id="s_x_level1_id" value="<?php echo $tb_level4->level1_id->LookupFilterQuery(false) ?>">
</span>
<?php echo $tb_level4->level1_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_level4->level2_id->Visible) { // level2_id ?>
	<div id="r_level2_id" class="form-group">
		<label id="elh_tb_level4_level2_id" class="col-sm-2 control-label ewLabel"><?php echo $tb_level4->level2_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_level4->level2_id->CellAttributes() ?>>
<span id="el_tb_level4_level2_id">
<?php
$wrkonchange = trim("ew_UpdateOpt.call(this); " . @$tb_level4->level2_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_level4->level2_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_level2_id" style="white-space: nowrap; z-index: 8970">
	<input type="text" name="sv_x_level2_id" id="sv_x_level2_id" value="<?php echo $tb_level4->level2_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($tb_level4->level2_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_level4->level2_id->getPlaceHolder()) ?>"<?php echo $tb_level4->level2_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_level4" data-field="x_level2_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_level4->level2_id->DisplayValueSeparatorAttribute() ?>" name="x_level2_id" id="x_level2_id" value="<?php echo ew_HtmlEncode($tb_level4->level2_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_level2_id" id="q_x_level2_id" value="<?php echo $tb_level4->level2_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ftb_level4edit.CreateAutoSuggest({"id":"x_level2_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_level4->level2_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_level2_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x_level2_id" id="s_x_level2_id" value="<?php echo $tb_level4->level2_id->LookupFilterQuery(false) ?>">
</span>
<?php echo $tb_level4->level2_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_level4->level3_id->Visible) { // level3_id ?>
	<div id="r_level3_id" class="form-group">
		<label id="elh_tb_level4_level3_id" class="col-sm-2 control-label ewLabel"><?php echo $tb_level4->level3_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_level4->level3_id->CellAttributes() ?>>
<span id="el_tb_level4_level3_id">
<?php
$wrkonchange = trim(" " . @$tb_level4->level3_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_level4->level3_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_level3_id" style="white-space: nowrap; z-index: 8960">
	<input type="text" name="sv_x_level3_id" id="sv_x_level3_id" value="<?php echo $tb_level4->level3_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($tb_level4->level3_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_level4->level3_id->getPlaceHolder()) ?>"<?php echo $tb_level4->level3_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_level4" data-field="x_level3_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_level4->level3_id->DisplayValueSeparatorAttribute() ?>" name="x_level3_id" id="x_level3_id" value="<?php echo ew_HtmlEncode($tb_level4->level3_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_level3_id" id="q_x_level3_id" value="<?php echo $tb_level4->level3_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ftb_level4edit.CreateAutoSuggest({"id":"x_level3_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_level4->level3_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_level3_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x_level3_id" id="s_x_level3_id" value="<?php echo $tb_level4->level3_id->LookupFilterQuery(false) ?>">
</span>
<?php echo $tb_level4->level3_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_level4->level4_no->Visible) { // level4_no ?>
	<div id="r_level4_no" class="form-group">
		<label id="elh_tb_level4_level4_no" for="x_level4_no" class="col-sm-2 control-label ewLabel"><?php echo $tb_level4->level4_no->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_level4->level4_no->CellAttributes() ?>>
<span id="el_tb_level4_level4_no">
<input type="text" data-table="tb_level4" data-field="x_level4_no" name="x_level4_no" id="x_level4_no" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($tb_level4->level4_no->getPlaceHolder()) ?>" value="<?php echo $tb_level4->level4_no->EditValue ?>"<?php echo $tb_level4->level4_no->EditAttributes() ?>>
</span>
<?php echo $tb_level4->level4_no->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_level4->level4_nama->Visible) { // level4_nama ?>
	<div id="r_level4_nama" class="form-group">
		<label id="elh_tb_level4_level4_nama" for="x_level4_nama" class="col-sm-2 control-label ewLabel"><?php echo $tb_level4->level4_nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_level4->level4_nama->CellAttributes() ?>>
<span id="el_tb_level4_level4_nama">
<input type="text" data-table="tb_level4" data-field="x_level4_nama" name="x_level4_nama" id="x_level4_nama" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tb_level4->level4_nama->getPlaceHolder()) ?>" value="<?php echo $tb_level4->level4_nama->EditValue ?>"<?php echo $tb_level4->level4_nama->EditAttributes() ?>>
</span>
<?php echo $tb_level4->level4_nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_level4->saldo_awal->Visible) { // saldo_awal ?>
	<div id="r_saldo_awal" class="form-group">
		<label id="elh_tb_level4_saldo_awal" for="x_saldo_awal" class="col-sm-2 control-label ewLabel"><?php echo $tb_level4->saldo_awal->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tb_level4->saldo_awal->CellAttributes() ?>>
<span id="el_tb_level4_saldo_awal">
<input type="text" data-table="tb_level4" data-field="x_saldo_awal" name="x_saldo_awal" id="x_saldo_awal" size="30" placeholder="<?php echo ew_HtmlEncode($tb_level4->saldo_awal->getPlaceHolder()) ?>" value="<?php echo $tb_level4->saldo_awal->EditValue ?>"<?php echo $tb_level4->saldo_awal->EditAttributes() ?>>
</span>
<?php echo $tb_level4->saldo_awal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_level4->jurnal->Visible) { // jurnal ?>
	<div id="r_jurnal" class="form-group">
		<label id="elh_tb_level4_jurnal" class="col-sm-2 control-label ewLabel"><?php echo $tb_level4->jurnal->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tb_level4->jurnal->CellAttributes() ?>>
<span id="el_tb_level4_jurnal">
<div id="tp_x_jurnal" class="ewTemplate"><input type="radio" data-table="tb_level4" data-field="x_jurnal" data-value-separator="<?php echo $tb_level4->jurnal->DisplayValueSeparatorAttribute() ?>" name="x_jurnal" id="x_jurnal" value="{value}"<?php echo $tb_level4->jurnal->EditAttributes() ?>></div>
<div id="dsl_x_jurnal" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $tb_level4->jurnal->RadioButtonListHtml(FALSE, "x_jurnal") ?>
</div></div>
</span>
<?php echo $tb_level4->jurnal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_level4->jurnal_kode->Visible) { // jurnal_kode ?>
	<div id="r_jurnal_kode" class="form-group">
		<label id="elh_tb_level4_jurnal_kode" class="col-sm-2 control-label ewLabel"><?php echo $tb_level4->jurnal_kode->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tb_level4->jurnal_kode->CellAttributes() ?>>
<span id="el_tb_level4_jurnal_kode">
<div id="tp_x_jurnal_kode" class="ewTemplate"><input type="radio" data-table="tb_level4" data-field="x_jurnal_kode" data-value-separator="<?php echo $tb_level4->jurnal_kode->DisplayValueSeparatorAttribute() ?>" name="x_jurnal_kode" id="x_jurnal_kode" value="{value}"<?php echo $tb_level4->jurnal_kode->EditAttributes() ?>></div>
<div id="dsl_x_jurnal_kode" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $tb_level4->jurnal_kode->RadioButtonListHtml(FALSE, "x_jurnal_kode") ?>
</div></div>
</span>
<?php echo $tb_level4->jurnal_kode->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="tb_level4" data-field="x_level4_id" name="x_level4_id" id="x_level4_id" value="<?php echo ew_HtmlEncode($tb_level4->level4_id->CurrentValue) ?>">
<?php if (!$tb_level4_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tb_level4_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ftb_level4edit.Init();
</script>
<?php
$tb_level4_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

$(document).ready(function() {

	// Kondisi saat Form di-load
	if($('input[name=x_jurnal]:radio:checked').val()=="1"){
		$('#r_jurnal_kode').show();
	} else {
		$('#r_jurnal_kode').hide();
	}

	// Kondisi saat Radio Button diklik
	$('input[name=x_jurnal]:radio').click(function(){
		if($(this).attr("value")=="0"){
			$('#x_jurnal_kode').val('');
			$('#r_jurnal_kode').hide();
		} else {
			$('#r_jurnal_kode').show();
			$('#x_jurnal_kode').focus();
		}
	});
});
</script>
<?php include_once "footer.php" ?>
<?php
$tb_level4_edit->Page_Terminate();
?>

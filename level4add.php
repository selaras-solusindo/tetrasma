<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "level4info.php" ?>
<?php include_once "tb_userinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$level4_add = NULL; // Initialize page object first

class clevel4_add extends clevel4 {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}";

	// Table name
	var $TableName = 'level4';

	// Page object name
	var $PageObjName = 'level4_add';

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
	var $AuditTrailOnAdd = TRUE;
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

		// Table object (level4)
		if (!isset($GLOBALS["level4"]) || get_class($GLOBALS["level4"]) == "clevel4") {
			$GLOBALS["level4"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["level4"];
		}

		// Table object (tb_user)
		if (!isset($GLOBALS['tb_user'])) $GLOBALS['tb_user'] = new ctb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'level4', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("level4list.php"));
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
		global $EW_EXPORT, $level4;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($level4);
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

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

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["level4_id"] != "") {
				$this->level4_id->setQueryStringValue($_GET["level4_id"]);
				$this->setKey("level4_id", $this->level4_id->CurrentValue); // Set up key
			} else {
				$this->setKey("level4_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("level4list.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "level4list.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "level4view.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->level1_id->CurrentValue = NULL;
		$this->level1_id->OldValue = $this->level1_id->CurrentValue;
		$this->level2_id->CurrentValue = NULL;
		$this->level2_id->OldValue = $this->level2_id->CurrentValue;
		$this->level3_id->CurrentValue = NULL;
		$this->level3_id->OldValue = $this->level3_id->CurrentValue;
		$this->level4_no->CurrentValue = NULL;
		$this->level4_no->OldValue = $this->level4_no->CurrentValue;
		$this->level4_nama->CurrentValue = NULL;
		$this->level4_nama->OldValue = $this->level4_nama->CurrentValue;
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
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->level1_id->CurrentValue = $this->level1_id->FormValue;
		$this->level2_id->CurrentValue = $this->level2_id->FormValue;
		$this->level3_id->CurrentValue = $this->level3_id->FormValue;
		$this->level4_no->CurrentValue = $this->level4_no->FormValue;
		$this->level4_nama->CurrentValue = $this->level4_nama->FormValue;
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
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("level4_id")) <> "")
			$this->level4_id->CurrentValue = $this->getKey("level4_id"); // level4_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// level1_id
		if ($this->level1_id->VirtualValue <> "") {
			$this->level1_id->ViewValue = $this->level1_id->VirtualValue;
		} else {
			$this->level1_id->ViewValue = $this->level1_id->CurrentValue;
		if (strval($this->level1_id->CurrentValue) <> "") {
			$sFilterWrk = "`level1_id`" . ew_SearchString("=", $this->level1_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `level1_id`, `level1_no` AS `DispFld`, `level1_nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `level1`";
		$sWhereWrk = "";
		$this->level1_id->LookupFilters = array("dx1" => "`level1_no`", "dx2" => "`level1_nama`");
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
		$sSqlWrk = "SELECT `level2_id`, `level2_no` AS `DispFld`, `level2_nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `level2`";
		$sWhereWrk = "";
		$this->level2_id->LookupFilters = array("dx1" => "`level2_no`", "dx2" => "`level2_nama`");
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
		$sSqlWrk = "SELECT `level3_id`, `level3_no` AS `DispFld`, `level3_nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `level3`";
		$sWhereWrk = "";
		$this->level3_id->LookupFilters = array("dx1" => "`level3_no`", "dx2" => "`level3_nama`");
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// level1_id
			$this->level1_id->EditAttrs["class"] = "form-control";
			$this->level1_id->EditCustomAttributes = "";
			$this->level1_id->EditValue = ew_HtmlEncode($this->level1_id->CurrentValue);
			if (strval($this->level1_id->CurrentValue) <> "") {
				$sFilterWrk = "`level1_id`" . ew_SearchString("=", $this->level1_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `level1_id`, `level1_no` AS `DispFld`, `level1_nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `level1`";
			$sWhereWrk = "";
			$this->level1_id->LookupFilters = array("dx1" => "`level1_no`", "dx2" => "`level1_nama`");
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
			$sSqlWrk = "SELECT `level2_id`, `level2_no` AS `DispFld`, `level2_nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `level2`";
			$sWhereWrk = "";
			$this->level2_id->LookupFilters = array("dx1" => "`level2_no`", "dx2" => "`level2_nama`");
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
			$sSqlWrk = "SELECT `level3_id`, `level3_no` AS `DispFld`, `level3_nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `level3`";
			$sWhereWrk = "";
			$this->level3_id->LookupFilters = array("dx1" => "`level3_no`", "dx2" => "`level3_nama`");
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

			// Add refer script
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// level1_id
		$this->level1_id->SetDbValueDef($rsnew, $this->level1_id->CurrentValue, 0, FALSE);

		// level2_id
		$this->level2_id->SetDbValueDef($rsnew, $this->level2_id->CurrentValue, 0, FALSE);

		// level3_id
		$this->level3_id->SetDbValueDef($rsnew, $this->level3_id->CurrentValue, 0, FALSE);

		// level4_no
		$this->level4_no->SetDbValueDef($rsnew, $this->level4_no->CurrentValue, "", FALSE);

		// level4_nama
		$this->level4_nama->SetDbValueDef($rsnew, $this->level4_nama->CurrentValue, "", FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->level4_id->setDbValue($conn->Insert_ID());
				$rsnew['level4_id'] = $this->level4_id->DbValue;
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
			$this->WriteAuditTrailOnAdd($rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("level4list.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_level1_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `level1_id` AS `LinkFld`, `level1_no` AS `DispFld`, `level1_nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `level1`";
			$sWhereWrk = "{filter}";
			$this->level1_id->LookupFilters = array("dx1" => "`level1_no`", "dx2" => "`level1_nama`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`level1_id` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->level1_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_level2_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `level2_id` AS `LinkFld`, `level2_no` AS `DispFld`, `level2_nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `level2`";
			$sWhereWrk = "{filter}";
			$this->level2_id->LookupFilters = array("dx1" => "`level2_no`", "dx2" => "`level2_nama`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`level2_id` = {filter_value}", "t0" => "3", "fn0" => "", "f1" => "`level1_id` IN ({filter_value})", "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->level2_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_level3_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `level3_id` AS `LinkFld`, `level3_no` AS `DispFld`, `level3_nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `level3`";
			$sWhereWrk = "{filter}";
			$this->level3_id->LookupFilters = array("dx1" => "`level3_no`", "dx2" => "`level3_nama`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`level3_id` = {filter_value}", "t0" => "3", "fn0" => "", "f1" => "`level2_id` IN ({filter_value})", "t1" => "3", "fn1" => "");
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
			$sSqlWrk = "SELECT `level1_id`, `level1_no` AS `DispFld`, `level1_nama` AS `Disp2Fld` FROM `level1`";
			$sWhereWrk = "`level1_no` LIKE '{query_value}%' OR CONCAT(`level1_no`,'" . ew_ValueSeparator(1, $this->level1_id) . "',`level1_nama`) LIKE '{query_value}%'";
			$this->level1_id->LookupFilters = array("dx1" => "`level1_no`", "dx2" => "`level1_nama`");
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
			$sSqlWrk = "SELECT `level2_id`, `level2_no` AS `DispFld`, `level2_nama` AS `Disp2Fld` FROM `level2`";
			$sWhereWrk = "(`level2_no` LIKE '{query_value}%' OR CONCAT(`level2_no`,'" . ew_ValueSeparator(1, $this->level2_id) . "',`level2_nama`) LIKE '{query_value}%') AND ({filter})";
			$this->level2_id->LookupFilters = array("dx1" => "`level2_no`", "dx2" => "`level2_nama`");
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
			$sSqlWrk = "SELECT `level3_id`, `level3_no` AS `DispFld`, `level3_nama` AS `Disp2Fld` FROM `level3`";
			$sWhereWrk = "(`level3_no` LIKE '{query_value}%' OR CONCAT(`level3_no`,'" . ew_ValueSeparator(1, $this->level3_id) . "',`level3_nama`) LIKE '{query_value}%') AND ({filter})";
			$this->level3_id->LookupFilters = array("dx1" => "`level3_no`", "dx2" => "`level3_nama`");
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
		$table = 'level4';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'level4';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['level4_id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserName();
		foreach (array_keys($rs) as $fldname) {
			if ($this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$newvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$newvalue = $rs[$fldname];
					else
						$newvalue = "[MEMO]"; // Memo Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$newvalue = "[XML]"; // XML Field
				} else {
					$newvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
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
if (!isset($level4_add)) $level4_add = new clevel4_add();

// Page init
$level4_add->Page_Init();

// Page main
$level4_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$level4_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = flevel4add = new ew_Form("flevel4add", "add");

// Validate form
flevel4add.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $level4->level1_id->FldCaption(), $level4->level1_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_level2_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $level4->level2_id->FldCaption(), $level4->level2_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_level3_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $level4->level3_id->FldCaption(), $level4->level3_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_level4_no");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $level4->level4_no->FldCaption(), $level4->level4_no->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_level4_nama");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $level4->level4_nama->FldCaption(), $level4->level4_nama->ReqErrMsg)) ?>");

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
flevel4add.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
flevel4add.ValidateRequired = true;
<?php } else { ?>
flevel4add.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
flevel4add.Lists["x_level1_id"] = {"LinkField":"x_level1_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_level1_no","x_level1_nama","",""],"ParentFields":[],"ChildFields":["x_level2_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"level1"};
flevel4add.Lists["x_level2_id"] = {"LinkField":"x_level2_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_level2_no","x_level2_nama","",""],"ParentFields":["x_level1_id"],"ChildFields":["x_level3_id"],"FilterFields":["x_level1_id"],"Options":[],"Template":"","LinkTable":"level2"};
flevel4add.Lists["x_level3_id"] = {"LinkField":"x_level3_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_level3_no","x_level3_nama","",""],"ParentFields":["x_level2_id"],"ChildFields":[],"FilterFields":["x_level2_id"],"Options":[],"Template":"","LinkTable":"level3"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$level4_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $level4_add->ShowPageHeader(); ?>
<?php
$level4_add->ShowMessage();
?>
<form name="flevel4add" id="flevel4add" class="<?php echo $level4_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($level4_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $level4_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="level4">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($level4_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($level4->level1_id->Visible) { // level1_id ?>
	<div id="r_level1_id" class="form-group">
		<label id="elh_level4_level1_id" class="col-sm-2 control-label ewLabel"><?php echo $level4->level1_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $level4->level1_id->CellAttributes() ?>>
<span id="el_level4_level1_id">
<?php $level4->level1_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$level4->level1_id->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_level1_id"><?php echo (strval($level4->level1_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $level4->level1_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($level4->level1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_level1_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="level4" data-field="x_level1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $level4->level1_id->DisplayValueSeparatorAttribute() ?>" name="x_level1_id" id="x_level1_id" value="<?php echo $level4->level1_id->CurrentValue ?>"<?php echo $level4->level1_id->EditAttributes() ?>>
<input type="hidden" name="s_x_level1_id" id="s_x_level1_id" value="<?php echo $level4->level1_id->LookupFilterQuery() ?>">
</span>
<?php echo $level4->level1_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($level4->level2_id->Visible) { // level2_id ?>
	<div id="r_level2_id" class="form-group">
		<label id="elh_level4_level2_id" class="col-sm-2 control-label ewLabel"><?php echo $level4->level2_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $level4->level2_id->CellAttributes() ?>>
<span id="el_level4_level2_id">
<?php $level4->level2_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$level4->level2_id->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_level2_id"><?php echo (strval($level4->level2_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $level4->level2_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($level4->level2_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_level2_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="level4" data-field="x_level2_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $level4->level2_id->DisplayValueSeparatorAttribute() ?>" name="x_level2_id" id="x_level2_id" value="<?php echo $level4->level2_id->CurrentValue ?>"<?php echo $level4->level2_id->EditAttributes() ?>>
<input type="hidden" name="s_x_level2_id" id="s_x_level2_id" value="<?php echo $level4->level2_id->LookupFilterQuery() ?>">
</span>
<?php echo $level4->level2_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($level4->level3_id->Visible) { // level3_id ?>
	<div id="r_level3_id" class="form-group">
		<label id="elh_level4_level3_id" class="col-sm-2 control-label ewLabel"><?php echo $level4->level3_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $level4->level3_id->CellAttributes() ?>>
<span id="el_level4_level3_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_level3_id"><?php echo (strval($level4->level3_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $level4->level3_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($level4->level3_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_level3_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="level4" data-field="x_level3_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $level4->level3_id->DisplayValueSeparatorAttribute() ?>" name="x_level3_id" id="x_level3_id" value="<?php echo $level4->level3_id->CurrentValue ?>"<?php echo $level4->level3_id->EditAttributes() ?>>
<input type="hidden" name="s_x_level3_id" id="s_x_level3_id" value="<?php echo $level4->level3_id->LookupFilterQuery() ?>">
</span>
<?php echo $level4->level3_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($level4->level4_no->Visible) { // level4_no ?>
	<div id="r_level4_no" class="form-group">
		<label id="elh_level4_level4_no" for="x_level4_no" class="col-sm-2 control-label ewLabel"><?php echo $level4->level4_no->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $level4->level4_no->CellAttributes() ?>>
<span id="el_level4_level4_no">
<input type="text" data-table="level4" data-field="x_level4_no" name="x_level4_no" id="x_level4_no" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($level4->level4_no->getPlaceHolder()) ?>" value="<?php echo $level4->level4_no->EditValue ?>"<?php echo $level4->level4_no->EditAttributes() ?>>
</span>
<?php echo $level4->level4_no->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($level4->level4_nama->Visible) { // level4_nama ?>
	<div id="r_level4_nama" class="form-group">
		<label id="elh_level4_level4_nama" for="x_level4_nama" class="col-sm-2 control-label ewLabel"><?php echo $level4->level4_nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $level4->level4_nama->CellAttributes() ?>>
<span id="el_level4_level4_nama">
<input type="text" data-table="level4" data-field="x_level4_nama" name="x_level4_nama" id="x_level4_nama" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($level4->level4_nama->getPlaceHolder()) ?>" value="<?php echo $level4->level4_nama->EditValue ?>"<?php echo $level4->level4_nama->EditAttributes() ?>>
</span>
<?php echo $level4->level4_nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$level4_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $level4_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
flevel4add.Init();
</script>
<?php
$level4_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$level4_add->Page_Terminate();
?>

<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "tb_level3info.php" ?>
<?php include_once "tb_userinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$tb_level3_add = NULL; // Initialize page object first

class ctb_level3_add extends ctb_level3 {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}";

	// Table name
	var $TableName = 'tb_level3';

	// Page object name
	var $PageObjName = 'tb_level3_add';

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

		// Table object (tb_level3)
		if (!isset($GLOBALS["tb_level3"]) || get_class($GLOBALS["tb_level3"]) == "ctb_level3") {
			$GLOBALS["tb_level3"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_level3"];
		}

		// Table object (tb_user)
		if (!isset($GLOBALS['tb_user'])) $GLOBALS['tb_user'] = new ctb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tb_level3', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("tb_level3list.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->level1_id->SetVisibility();
		$this->level2_id->SetVisibility();
		$this->level3_no->SetVisibility();
		$this->level3_nama->SetVisibility();

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
		global $EW_EXPORT, $tb_level3;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tb_level3);
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
			if (@$_GET["level3_id"] != "") {
				$this->level3_id->setQueryStringValue($_GET["level3_id"]);
				$this->setKey("level3_id", $this->level3_id->CurrentValue); // Set up key
			} else {
				$this->setKey("level3_id", ""); // Clear key
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
					$this->Page_Terminate("tb_level3list.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tb_level3list.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "tb_level3view.php")
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
		$this->level3_no->CurrentValue = NULL;
		$this->level3_no->OldValue = $this->level3_no->CurrentValue;
		$this->level3_nama->CurrentValue = NULL;
		$this->level3_nama->OldValue = $this->level3_nama->CurrentValue;
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
		if (!$this->level3_no->FldIsDetailKey) {
			$this->level3_no->setFormValue($objForm->GetValue("x_level3_no"));
		}
		if (!$this->level3_nama->FldIsDetailKey) {
			$this->level3_nama->setFormValue($objForm->GetValue("x_level3_nama"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->level1_id->CurrentValue = $this->level1_id->FormValue;
		$this->level2_id->CurrentValue = $this->level2_id->FormValue;
		$this->level3_no->CurrentValue = $this->level3_no->FormValue;
		$this->level3_nama->CurrentValue = $this->level3_nama->FormValue;
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
		$this->level3_id->setDbValue($rs->fields('level3_id'));
		$this->level1_id->setDbValue($rs->fields('level1_id'));
		$this->level2_id->setDbValue($rs->fields('level2_id'));
		if (array_key_exists('EV__level2_id', $rs->fields)) {
			$this->level2_id->VirtualValue = $rs->fields('EV__level2_id'); // Set up virtual field value
		} else {
			$this->level2_id->VirtualValue = ""; // Clear value
		}
		$this->level3_no->setDbValue($rs->fields('level3_no'));
		$this->level3_nama->setDbValue($rs->fields('level3_nama'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->level3_id->DbValue = $row['level3_id'];
		$this->level1_id->DbValue = $row['level1_id'];
		$this->level2_id->DbValue = $row['level2_id'];
		$this->level3_no->DbValue = $row['level3_no'];
		$this->level3_nama->DbValue = $row['level3_nama'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("level3_id")) <> "")
			$this->level3_id->CurrentValue = $this->getKey("level3_id"); // level3_id
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
		// level3_id
		// level1_id
		// level2_id
		// level3_no
		// level3_nama

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// level1_id
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

		// level3_no
		$this->level3_no->ViewValue = $this->level3_no->CurrentValue;
		$this->level3_no->ViewCustomAttributes = "";

		// level3_nama
		$this->level3_nama->ViewValue = $this->level3_nama->CurrentValue;
		$this->level3_nama->ViewCustomAttributes = "";

			// level1_id
			$this->level1_id->LinkCustomAttributes = "";
			$this->level1_id->HrefValue = "";
			$this->level1_id->TooltipValue = "";

			// level2_id
			$this->level2_id->LinkCustomAttributes = "";
			$this->level2_id->HrefValue = "";
			$this->level2_id->TooltipValue = "";

			// level3_no
			$this->level3_no->LinkCustomAttributes = "";
			$this->level3_no->HrefValue = "";
			$this->level3_no->TooltipValue = "";

			// level3_nama
			$this->level3_nama->LinkCustomAttributes = "";
			$this->level3_nama->HrefValue = "";
			$this->level3_nama->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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

			// level3_no
			$this->level3_no->EditAttrs["class"] = "form-control";
			$this->level3_no->EditCustomAttributes = "";
			$this->level3_no->EditValue = ew_HtmlEncode($this->level3_no->CurrentValue);
			$this->level3_no->PlaceHolder = ew_RemoveHtml($this->level3_no->FldCaption());

			// level3_nama
			$this->level3_nama->EditAttrs["class"] = "form-control";
			$this->level3_nama->EditCustomAttributes = "";
			$this->level3_nama->EditValue = ew_HtmlEncode($this->level3_nama->CurrentValue);
			$this->level3_nama->PlaceHolder = ew_RemoveHtml($this->level3_nama->FldCaption());

			// Add refer script
			// level1_id

			$this->level1_id->LinkCustomAttributes = "";
			$this->level1_id->HrefValue = "";

			// level2_id
			$this->level2_id->LinkCustomAttributes = "";
			$this->level2_id->HrefValue = "";

			// level3_no
			$this->level3_no->LinkCustomAttributes = "";
			$this->level3_no->HrefValue = "";

			// level3_nama
			$this->level3_nama->LinkCustomAttributes = "";
			$this->level3_nama->HrefValue = "";
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
		if (!ew_CheckInteger($this->level1_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->level1_id->FldErrMsg());
		}
		if (!$this->level2_id->FldIsDetailKey && !is_null($this->level2_id->FormValue) && $this->level2_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->level2_id->FldCaption(), $this->level2_id->ReqErrMsg));
		}
		if (!$this->level3_no->FldIsDetailKey && !is_null($this->level3_no->FormValue) && $this->level3_no->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->level3_no->FldCaption(), $this->level3_no->ReqErrMsg));
		}
		if (!$this->level3_nama->FldIsDetailKey && !is_null($this->level3_nama->FormValue) && $this->level3_nama->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->level3_nama->FldCaption(), $this->level3_nama->ReqErrMsg));
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

		// level3_no
		$this->level3_no->SetDbValueDef($rsnew, $this->level3_no->CurrentValue, "", FALSE);

		// level3_nama
		$this->level3_nama->SetDbValueDef($rsnew, $this->level3_nama->CurrentValue, "", FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->level3_id->setDbValue($conn->Insert_ID());
				$rsnew['level3_id'] = $this->level3_id->DbValue;
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_level3list.php"), "", $this->TableVar, TRUE);
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
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'tb_level3';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'tb_level3';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['level3_id'];

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
if (!isset($tb_level3_add)) $tb_level3_add = new ctb_level3_add();

// Page init
$tb_level3_add->Page_Init();

// Page main
$tb_level3_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_level3_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ftb_level3add = new ew_Form("ftb_level3add", "add");

// Validate form
ftb_level3add.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_level3->level1_id->FldCaption(), $tb_level3->level1_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_level1_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_level3->level1_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_level2_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_level3->level2_id->FldCaption(), $tb_level3->level2_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_level3_no");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_level3->level3_no->FldCaption(), $tb_level3->level3_no->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_level3_nama");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_level3->level3_nama->FldCaption(), $tb_level3->level3_nama->ReqErrMsg)) ?>");

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
ftb_level3add.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftb_level3add.ValidateRequired = true;
<?php } else { ?>
ftb_level3add.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftb_level3add.Lists["x_level1_id"] = {"LinkField":"x_level1_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_level1_no","x_level1_nama","",""],"ParentFields":[],"ChildFields":["x_level2_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tb_level1"};
ftb_level3add.Lists["x_level2_id"] = {"LinkField":"x_level2_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_level2_no","x_level2_nama","",""],"ParentFields":["x_level1_id"],"ChildFields":[],"FilterFields":["x_level1_id"],"Options":[],"Template":"","LinkTable":"tb_level2"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$tb_level3_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $tb_level3_add->ShowPageHeader(); ?>
<?php
$tb_level3_add->ShowMessage();
?>
<form name="ftb_level3add" id="ftb_level3add" class="<?php echo $tb_level3_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_level3_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_level3_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_level3">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($tb_level3_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($tb_level3->level1_id->Visible) { // level1_id ?>
	<div id="r_level1_id" class="form-group">
		<label id="elh_tb_level3_level1_id" class="col-sm-2 control-label ewLabel"><?php echo $tb_level3->level1_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_level3->level1_id->CellAttributes() ?>>
<span id="el_tb_level3_level1_id">
<?php
$wrkonchange = trim("ew_UpdateOpt.call(this); " . @$tb_level3->level1_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_level3->level1_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_level1_id" style="white-space: nowrap; z-index: 8980">
	<input type="text" name="sv_x_level1_id" id="sv_x_level1_id" value="<?php echo $tb_level3->level1_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($tb_level3->level1_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_level3->level1_id->getPlaceHolder()) ?>"<?php echo $tb_level3->level1_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_level3" data-field="x_level1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_level3->level1_id->DisplayValueSeparatorAttribute() ?>" name="x_level1_id" id="x_level1_id" value="<?php echo ew_HtmlEncode($tb_level3->level1_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_level1_id" id="q_x_level1_id" value="<?php echo $tb_level3->level1_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ftb_level3add.CreateAutoSuggest({"id":"x_level1_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_level3->level1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_level1_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x_level1_id" id="s_x_level1_id" value="<?php echo $tb_level3->level1_id->LookupFilterQuery(false) ?>">
</span>
<?php echo $tb_level3->level1_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_level3->level2_id->Visible) { // level2_id ?>
	<div id="r_level2_id" class="form-group">
		<label id="elh_tb_level3_level2_id" class="col-sm-2 control-label ewLabel"><?php echo $tb_level3->level2_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_level3->level2_id->CellAttributes() ?>>
<span id="el_tb_level3_level2_id">
<?php
$wrkonchange = trim(" " . @$tb_level3->level2_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_level3->level2_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_level2_id" style="white-space: nowrap; z-index: 8970">
	<input type="text" name="sv_x_level2_id" id="sv_x_level2_id" value="<?php echo $tb_level3->level2_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($tb_level3->level2_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_level3->level2_id->getPlaceHolder()) ?>"<?php echo $tb_level3->level2_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_level3" data-field="x_level2_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_level3->level2_id->DisplayValueSeparatorAttribute() ?>" name="x_level2_id" id="x_level2_id" value="<?php echo ew_HtmlEncode($tb_level3->level2_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_level2_id" id="q_x_level2_id" value="<?php echo $tb_level3->level2_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ftb_level3add.CreateAutoSuggest({"id":"x_level2_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_level3->level2_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_level2_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x_level2_id" id="s_x_level2_id" value="<?php echo $tb_level3->level2_id->LookupFilterQuery(false) ?>">
</span>
<?php echo $tb_level3->level2_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_level3->level3_no->Visible) { // level3_no ?>
	<div id="r_level3_no" class="form-group">
		<label id="elh_tb_level3_level3_no" for="x_level3_no" class="col-sm-2 control-label ewLabel"><?php echo $tb_level3->level3_no->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_level3->level3_no->CellAttributes() ?>>
<span id="el_tb_level3_level3_no">
<input type="text" data-table="tb_level3" data-field="x_level3_no" name="x_level3_no" id="x_level3_no" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($tb_level3->level3_no->getPlaceHolder()) ?>" value="<?php echo $tb_level3->level3_no->EditValue ?>"<?php echo $tb_level3->level3_no->EditAttributes() ?>>
</span>
<?php echo $tb_level3->level3_no->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_level3->level3_nama->Visible) { // level3_nama ?>
	<div id="r_level3_nama" class="form-group">
		<label id="elh_tb_level3_level3_nama" for="x_level3_nama" class="col-sm-2 control-label ewLabel"><?php echo $tb_level3->level3_nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_level3->level3_nama->CellAttributes() ?>>
<span id="el_tb_level3_level3_nama">
<input type="text" data-table="tb_level3" data-field="x_level3_nama" name="x_level3_nama" id="x_level3_nama" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tb_level3->level3_nama->getPlaceHolder()) ?>" value="<?php echo $tb_level3->level3_nama->EditValue ?>"<?php echo $tb_level3->level3_nama->EditAttributes() ?>>
</span>
<?php echo $tb_level3->level3_nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$tb_level3_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tb_level3_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ftb_level3add.Init();
</script>
<?php
$tb_level3_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tb_level3_add->Page_Terminate();
?>

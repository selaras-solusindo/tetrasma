<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "tb_detailminfo.php" ?>
<?php include_once "tb_userinfo.php" ?>
<?php include_once "tb_jurnalminfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$tb_detailm_add = NULL; // Initialize page object first

class ctb_detailm_add extends ctb_detailm {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}";

	// Table name
	var $TableName = 'tb_detailm';

	// Page object name
	var $PageObjName = 'tb_detailm_add';

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

		// Table object (tb_detailm)
		if (!isset($GLOBALS["tb_detailm"]) || get_class($GLOBALS["tb_detailm"]) == "ctb_detailm") {
			$GLOBALS["tb_detailm"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_detailm"];
		}

		// Table object (tb_user)
		if (!isset($GLOBALS['tb_user'])) $GLOBALS['tb_user'] = new ctb_user();

		// Table object (tb_jurnalm)
		if (!isset($GLOBALS['tb_jurnalm'])) $GLOBALS['tb_jurnalm'] = new ctb_jurnalm();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tb_detailm', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("tb_detailmlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->akunm_id->SetVisibility();
		$this->nilaim_debet->SetVisibility();
		$this->nilaim_kredit->SetVisibility();

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
		global $EW_EXPORT, $tb_detailm;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tb_detailm);
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

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["detailm_id"] != "") {
				$this->detailm_id->setQueryStringValue($_GET["detailm_id"]);
				$this->setKey("detailm_id", $this->detailm_id->CurrentValue); // Set up key
			} else {
				$this->setKey("detailm_id", ""); // Clear key
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
					$this->Page_Terminate("tb_detailmlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tb_detailmlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "tb_detailmview.php")
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
		$this->akunm_id->CurrentValue = NULL;
		$this->akunm_id->OldValue = $this->akunm_id->CurrentValue;
		$this->nilaim_debet->CurrentValue = 0;
		$this->nilaim_kredit->CurrentValue = 0;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->akunm_id->FldIsDetailKey) {
			$this->akunm_id->setFormValue($objForm->GetValue("x_akunm_id"));
		}
		if (!$this->nilaim_debet->FldIsDetailKey) {
			$this->nilaim_debet->setFormValue($objForm->GetValue("x_nilaim_debet"));
		}
		if (!$this->nilaim_kredit->FldIsDetailKey) {
			$this->nilaim_kredit->setFormValue($objForm->GetValue("x_nilaim_kredit"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->akunm_id->CurrentValue = $this->akunm_id->FormValue;
		$this->nilaim_debet->CurrentValue = $this->nilaim_debet->FormValue;
		$this->nilaim_kredit->CurrentValue = $this->nilaim_kredit->FormValue;
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
		$this->detailm_id->setDbValue($rs->fields('detailm_id'));
		$this->jurnalm_id->setDbValue($rs->fields('jurnalm_id'));
		$this->akunm_id->setDbValue($rs->fields('akunm_id'));
		if (array_key_exists('EV__akunm_id', $rs->fields)) {
			$this->akunm_id->VirtualValue = $rs->fields('EV__akunm_id'); // Set up virtual field value
		} else {
			$this->akunm_id->VirtualValue = ""; // Clear value
		}
		$this->nilaim_debet->setDbValue($rs->fields('nilaim_debet'));
		$this->nilaim_kredit->setDbValue($rs->fields('nilaim_kredit'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->detailm_id->DbValue = $row['detailm_id'];
		$this->jurnalm_id->DbValue = $row['jurnalm_id'];
		$this->akunm_id->DbValue = $row['akunm_id'];
		$this->nilaim_debet->DbValue = $row['nilaim_debet'];
		$this->nilaim_kredit->DbValue = $row['nilaim_kredit'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("detailm_id")) <> "")
			$this->detailm_id->CurrentValue = $this->getKey("detailm_id"); // detailm_id
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
		// detailm_id
		// jurnalm_id
		// akunm_id
		// nilaim_debet
		// nilaim_kredit

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// detailm_id
		$this->detailm_id->ViewValue = $this->detailm_id->CurrentValue;
		$this->detailm_id->ViewCustomAttributes = "";

		// jurnalm_id
		$this->jurnalm_id->ViewValue = $this->jurnalm_id->CurrentValue;
		$this->jurnalm_id->ViewCustomAttributes = "";

		// akunm_id
		if ($this->akunm_id->VirtualValue <> "") {
			$this->akunm_id->ViewValue = $this->akunm_id->VirtualValue;
		} else {
			$this->akunm_id->ViewValue = $this->akunm_id->CurrentValue;
		if (strval($this->akunm_id->CurrentValue) <> "") {
			$sFilterWrk = "`level4_id`" . ew_SearchString("=", $this->akunm_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `level4_id`, `no_nama_akun` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `view_akun_jurnal`";
		$sWhereWrk = "";
		$this->akunm_id->LookupFilters = array("dx1" => '`no_nama_akun`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->akunm_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->akunm_id->ViewValue = $this->akunm_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->akunm_id->ViewValue = $this->akunm_id->CurrentValue;
			}
		} else {
			$this->akunm_id->ViewValue = NULL;
		}
		}
		$this->akunm_id->ViewCustomAttributes = "";

		// nilaim_debet
		$this->nilaim_debet->ViewValue = $this->nilaim_debet->CurrentValue;
		$this->nilaim_debet->ViewValue = ew_FormatNumber($this->nilaim_debet->ViewValue, 0, -2, -2, -1);
		$this->nilaim_debet->CellCssStyle .= "text-align: right;";
		$this->nilaim_debet->ViewCustomAttributes = "";

		// nilaim_kredit
		$this->nilaim_kredit->ViewValue = $this->nilaim_kredit->CurrentValue;
		$this->nilaim_kredit->ViewValue = ew_FormatNumber($this->nilaim_kredit->ViewValue, 0, -2, -2, -1);
		$this->nilaim_kredit->CellCssStyle .= "text-align: right;";
		$this->nilaim_kredit->ViewCustomAttributes = "";

			// akunm_id
			$this->akunm_id->LinkCustomAttributes = "";
			$this->akunm_id->HrefValue = "";
			$this->akunm_id->TooltipValue = "";

			// nilaim_debet
			$this->nilaim_debet->LinkCustomAttributes = "";
			$this->nilaim_debet->HrefValue = "";
			$this->nilaim_debet->TooltipValue = "";

			// nilaim_kredit
			$this->nilaim_kredit->LinkCustomAttributes = "";
			$this->nilaim_kredit->HrefValue = "";
			$this->nilaim_kredit->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// akunm_id
			$this->akunm_id->EditAttrs["class"] = "form-control";
			$this->akunm_id->EditCustomAttributes = "";
			$this->akunm_id->EditValue = ew_HtmlEncode($this->akunm_id->CurrentValue);
			if (strval($this->akunm_id->CurrentValue) <> "") {
				$sFilterWrk = "`level4_id`" . ew_SearchString("=", $this->akunm_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `level4_id`, `no_nama_akun` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `view_akun_jurnal`";
			$sWhereWrk = "";
			$this->akunm_id->LookupFilters = array("dx1" => '`no_nama_akun`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->akunm_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->akunm_id->EditValue = $this->akunm_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->akunm_id->EditValue = ew_HtmlEncode($this->akunm_id->CurrentValue);
				}
			} else {
				$this->akunm_id->EditValue = NULL;
			}
			$this->akunm_id->PlaceHolder = ew_RemoveHtml($this->akunm_id->FldCaption());

			// nilaim_debet
			$this->nilaim_debet->EditAttrs["class"] = "form-control";
			$this->nilaim_debet->EditCustomAttributes = "";
			$this->nilaim_debet->EditValue = ew_HtmlEncode($this->nilaim_debet->CurrentValue);
			$this->nilaim_debet->PlaceHolder = ew_RemoveHtml($this->nilaim_debet->FldCaption());

			// nilaim_kredit
			$this->nilaim_kredit->EditAttrs["class"] = "form-control";
			$this->nilaim_kredit->EditCustomAttributes = "";
			$this->nilaim_kredit->EditValue = ew_HtmlEncode($this->nilaim_kredit->CurrentValue);
			$this->nilaim_kredit->PlaceHolder = ew_RemoveHtml($this->nilaim_kredit->FldCaption());

			// Add refer script
			// akunm_id

			$this->akunm_id->LinkCustomAttributes = "";
			$this->akunm_id->HrefValue = "";

			// nilaim_debet
			$this->nilaim_debet->LinkCustomAttributes = "";
			$this->nilaim_debet->HrefValue = "";

			// nilaim_kredit
			$this->nilaim_kredit->LinkCustomAttributes = "";
			$this->nilaim_kredit->HrefValue = "";
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
		if (!$this->akunm_id->FldIsDetailKey && !is_null($this->akunm_id->FormValue) && $this->akunm_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->akunm_id->FldCaption(), $this->akunm_id->ReqErrMsg));
		}
		if (!$this->nilaim_debet->FldIsDetailKey && !is_null($this->nilaim_debet->FormValue) && $this->nilaim_debet->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nilaim_debet->FldCaption(), $this->nilaim_debet->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->nilaim_debet->FormValue)) {
			ew_AddMessage($gsFormError, $this->nilaim_debet->FldErrMsg());
		}
		if (!$this->nilaim_kredit->FldIsDetailKey && !is_null($this->nilaim_kredit->FormValue) && $this->nilaim_kredit->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nilaim_kredit->FldCaption(), $this->nilaim_kredit->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->nilaim_kredit->FormValue)) {
			ew_AddMessage($gsFormError, $this->nilaim_kredit->FldErrMsg());
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

		// akunm_id
		$this->akunm_id->SetDbValueDef($rsnew, $this->akunm_id->CurrentValue, 0, FALSE);

		// nilaim_debet
		$this->nilaim_debet->SetDbValueDef($rsnew, $this->nilaim_debet->CurrentValue, 0, FALSE);

		// nilaim_kredit
		$this->nilaim_kredit->SetDbValueDef($rsnew, $this->nilaim_kredit->CurrentValue, 0, FALSE);

		// jurnalm_id
		if ($this->jurnalm_id->getSessionValue() <> "") {
			$rsnew['jurnalm_id'] = $this->jurnalm_id->getSessionValue();
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->detailm_id->setDbValue($conn->Insert_ID());
				$rsnew['detailm_id'] = $this->detailm_id->DbValue;
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

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "tb_jurnalm") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_jurnalm_id"] <> "") {
					$GLOBALS["tb_jurnalm"]->jurnalm_id->setQueryStringValue($_GET["fk_jurnalm_id"]);
					$this->jurnalm_id->setQueryStringValue($GLOBALS["tb_jurnalm"]->jurnalm_id->QueryStringValue);
					$this->jurnalm_id->setSessionValue($this->jurnalm_id->QueryStringValue);
					if (!is_numeric($GLOBALS["tb_jurnalm"]->jurnalm_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "tb_jurnalm") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_jurnalm_id"] <> "") {
					$GLOBALS["tb_jurnalm"]->jurnalm_id->setFormValue($_POST["fk_jurnalm_id"]);
					$this->jurnalm_id->setFormValue($GLOBALS["tb_jurnalm"]->jurnalm_id->FormValue);
					$this->jurnalm_id->setSessionValue($this->jurnalm_id->FormValue);
					if (!is_numeric($GLOBALS["tb_jurnalm"]->jurnalm_id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "tb_jurnalm") {
				if ($this->jurnalm_id->CurrentValue == "") $this->jurnalm_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_detailmlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_akunm_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `level4_id` AS `LinkFld`, `no_nama_akun` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `view_akun_jurnal`";
			$sWhereWrk = "{filter}";
			$this->akunm_id->LookupFilters = array("dx1" => '`no_nama_akun`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`level4_id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->akunm_id, $sWhereWrk); // Call Lookup selecting
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
		case "x_akunm_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `level4_id`, `no_nama_akun` AS `DispFld` FROM `view_akun_jurnal`";
			$sWhereWrk = "`no_nama_akun` LIKE '{query_value}%'";
			$this->akunm_id->LookupFilters = array("dx1" => '`no_nama_akun`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->akunm_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'tb_detailm';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'tb_detailm';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['detailm_id'];

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
if (!isset($tb_detailm_add)) $tb_detailm_add = new ctb_detailm_add();

// Page init
$tb_detailm_add->Page_Init();

// Page main
$tb_detailm_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_detailm_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ftb_detailmadd = new ew_Form("ftb_detailmadd", "add");

// Validate form
ftb_detailmadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_akunm_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_detailm->akunm_id->FldCaption(), $tb_detailm->akunm_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nilaim_debet");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_detailm->nilaim_debet->FldCaption(), $tb_detailm->nilaim_debet->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nilaim_debet");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_detailm->nilaim_debet->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_nilaim_kredit");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_detailm->nilaim_kredit->FldCaption(), $tb_detailm->nilaim_kredit->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nilaim_kredit");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_detailm->nilaim_kredit->FldErrMsg()) ?>");

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
ftb_detailmadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftb_detailmadd.ValidateRequired = true;
<?php } else { ?>
ftb_detailmadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftb_detailmadd.Lists["x_akunm_id"] = {"LinkField":"x_level4_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_nama_akun","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"view_akun_jurnal"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$tb_detailm_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $tb_detailm_add->ShowPageHeader(); ?>
<?php
$tb_detailm_add->ShowMessage();
?>
<form name="ftb_detailmadd" id="ftb_detailmadd" class="<?php echo $tb_detailm_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_detailm_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_detailm_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_detailm">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($tb_detailm_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($tb_detailm->getCurrentMasterTable() == "tb_jurnalm") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="tb_jurnalm">
<input type="hidden" name="fk_jurnalm_id" value="<?php echo $tb_detailm->jurnalm_id->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($tb_detailm->akunm_id->Visible) { // akunm_id ?>
	<div id="r_akunm_id" class="form-group">
		<label id="elh_tb_detailm_akunm_id" class="col-sm-2 control-label ewLabel"><?php echo $tb_detailm->akunm_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_detailm->akunm_id->CellAttributes() ?>>
<span id="el_tb_detailm_akunm_id">
<?php
$wrkonchange = trim(" " . @$tb_detailm->akunm_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_detailm->akunm_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_akunm_id" style="white-space: nowrap; z-index: 8970">
	<input type="text" name="sv_x_akunm_id" id="sv_x_akunm_id" value="<?php echo $tb_detailm->akunm_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detailm->akunm_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_detailm->akunm_id->getPlaceHolder()) ?>"<?php echo $tb_detailm->akunm_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_detailm" data-field="x_akunm_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_detailm->akunm_id->DisplayValueSeparatorAttribute() ?>" name="x_akunm_id" id="x_akunm_id" value="<?php echo ew_HtmlEncode($tb_detailm->akunm_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_akunm_id" id="q_x_akunm_id" value="<?php echo $tb_detailm->akunm_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ftb_detailmadd.CreateAutoSuggest({"id":"x_akunm_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_detailm->akunm_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_akunm_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x_akunm_id" id="s_x_akunm_id" value="<?php echo $tb_detailm->akunm_id->LookupFilterQuery(false) ?>">
</span>
<?php echo $tb_detailm->akunm_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_detailm->nilaim_debet->Visible) { // nilaim_debet ?>
	<div id="r_nilaim_debet" class="form-group">
		<label id="elh_tb_detailm_nilaim_debet" for="x_nilaim_debet" class="col-sm-2 control-label ewLabel"><?php echo $tb_detailm->nilaim_debet->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_detailm->nilaim_debet->CellAttributes() ?>>
<span id="el_tb_detailm_nilaim_debet">
<input type="text" data-table="tb_detailm" data-field="x_nilaim_debet" name="x_nilaim_debet" id="x_nilaim_debet" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detailm->nilaim_debet->getPlaceHolder()) ?>" value="<?php echo $tb_detailm->nilaim_debet->EditValue ?>"<?php echo $tb_detailm->nilaim_debet->EditAttributes() ?>>
</span>
<?php echo $tb_detailm->nilaim_debet->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_detailm->nilaim_kredit->Visible) { // nilaim_kredit ?>
	<div id="r_nilaim_kredit" class="form-group">
		<label id="elh_tb_detailm_nilaim_kredit" for="x_nilaim_kredit" class="col-sm-2 control-label ewLabel"><?php echo $tb_detailm->nilaim_kredit->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_detailm->nilaim_kredit->CellAttributes() ?>>
<span id="el_tb_detailm_nilaim_kredit">
<input type="text" data-table="tb_detailm" data-field="x_nilaim_kredit" name="x_nilaim_kredit" id="x_nilaim_kredit" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detailm->nilaim_kredit->getPlaceHolder()) ?>" value="<?php echo $tb_detailm->nilaim_kredit->EditValue ?>"<?php echo $tb_detailm->nilaim_kredit->EditAttributes() ?>>
</span>
<?php echo $tb_detailm->nilaim_kredit->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (strval($tb_detailm->jurnalm_id->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_jurnalm_id" id="x_jurnalm_id" value="<?php echo ew_HtmlEncode(strval($tb_detailm->jurnalm_id->getSessionValue())) ?>">
<?php } ?>
<?php if (!$tb_detailm_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tb_detailm_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ftb_detailmadd.Init();
</script>
<?php
$tb_detailm_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tb_detailm_add->Page_Terminate();
?>

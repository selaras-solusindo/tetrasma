<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "tb_jurnalminfo.php" ?>
<?php include_once "tb_userinfo.php" ?>
<?php include_once "tb_detailmgridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$tb_jurnalm_add = NULL; // Initialize page object first

class ctb_jurnalm_add extends ctb_jurnalm {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}";

	// Table name
	var $TableName = 'tb_jurnalm';

	// Page object name
	var $PageObjName = 'tb_jurnalm_add';

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

		// Table object (tb_jurnalm)
		if (!isset($GLOBALS["tb_jurnalm"]) || get_class($GLOBALS["tb_jurnalm"]) == "ctb_jurnalm") {
			$GLOBALS["tb_jurnalm"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_jurnalm"];
		}

		// Table object (tb_user)
		if (!isset($GLOBALS['tb_user'])) $GLOBALS['tb_user'] = new ctb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tb_jurnalm', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("tb_jurnalmlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->no_buktim->SetVisibility();
		$this->tglm->SetVisibility();
		$this->ketm->SetVisibility();

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

			// Process auto fill for detail table 'tb_detailm'
			if (@$_POST["grid"] == "ftb_detailmgrid") {
				if (!isset($GLOBALS["tb_detailm_grid"])) $GLOBALS["tb_detailm_grid"] = new ctb_detailm_grid;
				$GLOBALS["tb_detailm_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $tb_jurnalm;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tb_jurnalm);
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
			if (@$_GET["jurnalm_id"] != "") {
				$this->jurnalm_id->setQueryStringValue($_GET["jurnalm_id"]);
				$this->setKey("jurnalm_id", $this->jurnalm_id->CurrentValue); // Set up key
			} else {
				$this->setKey("jurnalm_id", ""); // Clear key
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

		// Set up detail parameters
		$this->SetUpDetailParms();

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
					$this->Page_Terminate("tb_jurnalmlist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tb_jurnalmlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "tb_jurnalmview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		$this->no_buktim->CurrentValue = NULL;
		$this->no_buktim->OldValue = $this->no_buktim->CurrentValue;
		$this->tglm->CurrentValue = NULL;
		$this->tglm->OldValue = $this->tglm->CurrentValue;
		$this->ketm->CurrentValue = NULL;
		$this->ketm->OldValue = $this->ketm->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->no_buktim->FldIsDetailKey) {
			$this->no_buktim->setFormValue($objForm->GetValue("x_no_buktim"));
		}
		if (!$this->tglm->FldIsDetailKey) {
			$this->tglm->setFormValue($objForm->GetValue("x_tglm"));
			$this->tglm->CurrentValue = ew_UnFormatDateTime($this->tglm->CurrentValue, 7);
		}
		if (!$this->ketm->FldIsDetailKey) {
			$this->ketm->setFormValue($objForm->GetValue("x_ketm"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->no_buktim->CurrentValue = $this->no_buktim->FormValue;
		$this->tglm->CurrentValue = $this->tglm->FormValue;
		$this->tglm->CurrentValue = ew_UnFormatDateTime($this->tglm->CurrentValue, 7);
		$this->ketm->CurrentValue = $this->ketm->FormValue;
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
		$this->jurnalm_id->setDbValue($rs->fields('jurnalm_id'));
		$this->no_buktim->setDbValue($rs->fields('no_buktim'));
		$this->tglm->setDbValue($rs->fields('tglm'));
		$this->ketm->setDbValue($rs->fields('ketm'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->jurnalm_id->DbValue = $row['jurnalm_id'];
		$this->no_buktim->DbValue = $row['no_buktim'];
		$this->tglm->DbValue = $row['tglm'];
		$this->ketm->DbValue = $row['ketm'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("jurnalm_id")) <> "")
			$this->jurnalm_id->CurrentValue = $this->getKey("jurnalm_id"); // jurnalm_id
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
		// jurnalm_id
		// no_buktim
		// tglm
		// ketm

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// jurnalm_id
		$this->jurnalm_id->ViewValue = $this->jurnalm_id->CurrentValue;
		$this->jurnalm_id->ViewCustomAttributes = "";

		// no_buktim
		$this->no_buktim->ViewValue = $this->no_buktim->CurrentValue;
		$this->no_buktim->ViewCustomAttributes = "";

		// tglm
		$this->tglm->ViewValue = $this->tglm->CurrentValue;
		$this->tglm->ViewValue = ew_FormatDateTime($this->tglm->ViewValue, 7);
		$this->tglm->ViewCustomAttributes = "";

		// ketm
		$this->ketm->ViewValue = $this->ketm->CurrentValue;
		$this->ketm->ViewCustomAttributes = "";

			// no_buktim
			$this->no_buktim->LinkCustomAttributes = "";
			$this->no_buktim->HrefValue = "";
			$this->no_buktim->TooltipValue = "";

			// tglm
			$this->tglm->LinkCustomAttributes = "";
			$this->tglm->HrefValue = "";
			$this->tglm->TooltipValue = "";

			// ketm
			$this->ketm->LinkCustomAttributes = "";
			$this->ketm->HrefValue = "";
			$this->ketm->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// no_buktim
			$this->no_buktim->EditAttrs["class"] = "form-control";
			$this->no_buktim->EditCustomAttributes = "";
			$this->no_buktim->EditValue = ew_HtmlEncode($this->no_buktim->CurrentValue);
			$this->no_buktim->PlaceHolder = ew_RemoveHtml($this->no_buktim->FldCaption());

			// tglm
			$this->tglm->EditAttrs["class"] = "form-control";
			$this->tglm->EditCustomAttributes = "";
			$this->tglm->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tglm->CurrentValue, 7));
			$this->tglm->PlaceHolder = ew_RemoveHtml($this->tglm->FldCaption());

			// ketm
			$this->ketm->EditAttrs["class"] = "form-control";
			$this->ketm->EditCustomAttributes = "";
			$this->ketm->EditValue = ew_HtmlEncode($this->ketm->CurrentValue);
			$this->ketm->PlaceHolder = ew_RemoveHtml($this->ketm->FldCaption());

			// Add refer script
			// no_buktim

			$this->no_buktim->LinkCustomAttributes = "";
			$this->no_buktim->HrefValue = "";

			// tglm
			$this->tglm->LinkCustomAttributes = "";
			$this->tglm->HrefValue = "";

			// ketm
			$this->ketm->LinkCustomAttributes = "";
			$this->ketm->HrefValue = "";
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
		if (!$this->no_buktim->FldIsDetailKey && !is_null($this->no_buktim->FormValue) && $this->no_buktim->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->no_buktim->FldCaption(), $this->no_buktim->ReqErrMsg));
		}
		if (!$this->tglm->FldIsDetailKey && !is_null($this->tglm->FormValue) && $this->tglm->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tglm->FldCaption(), $this->tglm->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->tglm->FormValue)) {
			ew_AddMessage($gsFormError, $this->tglm->FldErrMsg());
		}
		if (!$this->ketm->FldIsDetailKey && !is_null($this->ketm->FormValue) && $this->ketm->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ketm->FldCaption(), $this->ketm->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("tb_detailm", $DetailTblVar) && $GLOBALS["tb_detailm"]->DetailAdd) {
			if (!isset($GLOBALS["tb_detailm_grid"])) $GLOBALS["tb_detailm_grid"] = new ctb_detailm_grid(); // get detail page object
			$GLOBALS["tb_detailm_grid"]->ValidateGridForm();
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

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// no_buktim
		$this->no_buktim->SetDbValueDef($rsnew, $this->no_buktim->CurrentValue, "", FALSE);

		// tglm
		$this->tglm->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tglm->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// ketm
		$this->ketm->SetDbValueDef($rsnew, $this->ketm->CurrentValue, "", FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->jurnalm_id->setDbValue($conn->Insert_ID());
				$rsnew['jurnalm_id'] = $this->jurnalm_id->DbValue;
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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("tb_detailm", $DetailTblVar) && $GLOBALS["tb_detailm"]->DetailAdd) {
				$GLOBALS["tb_detailm"]->jurnalm_id->setSessionValue($this->jurnalm_id->CurrentValue); // Set master key
				if (!isset($GLOBALS["tb_detailm_grid"])) $GLOBALS["tb_detailm_grid"] = new ctb_detailm_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "tb_detailm"); // Load user level of detail table
				$AddRow = $GLOBALS["tb_detailm_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["tb_detailm"]->jurnalm_id->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
			$this->WriteAuditTrailOnAdd($rsnew);
		}
		return $AddRow;
	}

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("tb_detailm", $DetailTblVar)) {
				if (!isset($GLOBALS["tb_detailm_grid"]))
					$GLOBALS["tb_detailm_grid"] = new ctb_detailm_grid;
				if ($GLOBALS["tb_detailm_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["tb_detailm_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["tb_detailm_grid"]->CurrentMode = "add";
					$GLOBALS["tb_detailm_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["tb_detailm_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["tb_detailm_grid"]->setStartRecordNumber(1);
					$GLOBALS["tb_detailm_grid"]->jurnalm_id->FldIsDetailKey = TRUE;
					$GLOBALS["tb_detailm_grid"]->jurnalm_id->CurrentValue = $this->jurnalm_id->CurrentValue;
					$GLOBALS["tb_detailm_grid"]->jurnalm_id->setSessionValue($GLOBALS["tb_detailm_grid"]->jurnalm_id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_jurnalmlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
		$table = 'tb_jurnalm';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'tb_jurnalm';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['jurnalm_id'];

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
if (!isset($tb_jurnalm_add)) $tb_jurnalm_add = new ctb_jurnalm_add();

// Page init
$tb_jurnalm_add->Page_Init();

// Page main
$tb_jurnalm_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_jurnalm_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ftb_jurnalmadd = new ew_Form("ftb_jurnalmadd", "add");

// Validate form
ftb_jurnalmadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_no_buktim");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_jurnalm->no_buktim->FldCaption(), $tb_jurnalm->no_buktim->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tglm");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_jurnalm->tglm->FldCaption(), $tb_jurnalm->tglm->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tglm");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_jurnalm->tglm->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_ketm");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_jurnalm->ketm->FldCaption(), $tb_jurnalm->ketm->ReqErrMsg)) ?>");

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
ftb_jurnalmadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	if(debet_total != kredit_total) {
 		alert('saldo belum balance');
 		return false;
 	}
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftb_jurnalmadd.ValidateRequired = true;
<?php } else { ?>
ftb_jurnalmadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$tb_jurnalm_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $tb_jurnalm_add->ShowPageHeader(); ?>
<?php
$tb_jurnalm_add->ShowMessage();
?>
<form name="ftb_jurnalmadd" id="ftb_jurnalmadd" class="<?php echo $tb_jurnalm_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_jurnalm_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_jurnalm_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_jurnalm">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($tb_jurnalm_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($tb_jurnalm->no_buktim->Visible) { // no_buktim ?>
	<div id="r_no_buktim" class="form-group">
		<label id="elh_tb_jurnalm_no_buktim" for="x_no_buktim" class="col-sm-2 control-label ewLabel"><?php echo $tb_jurnalm->no_buktim->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_jurnalm->no_buktim->CellAttributes() ?>>
<span id="el_tb_jurnalm_no_buktim">
<input type="text" data-table="tb_jurnalm" data-field="x_no_buktim" name="x_no_buktim" id="x_no_buktim" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($tb_jurnalm->no_buktim->getPlaceHolder()) ?>" value="<?php echo $tb_jurnalm->no_buktim->EditValue ?>"<?php echo $tb_jurnalm->no_buktim->EditAttributes() ?>>
</span>
<?php echo $tb_jurnalm->no_buktim->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jurnalm->tglm->Visible) { // tglm ?>
	<div id="r_tglm" class="form-group">
		<label id="elh_tb_jurnalm_tglm" for="x_tglm" class="col-sm-2 control-label ewLabel"><?php echo $tb_jurnalm->tglm->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_jurnalm->tglm->CellAttributes() ?>>
<span id="el_tb_jurnalm_tglm">
<input type="text" data-table="tb_jurnalm" data-field="x_tglm" data-format="7" name="x_tglm" id="x_tglm" placeholder="<?php echo ew_HtmlEncode($tb_jurnalm->tglm->getPlaceHolder()) ?>" value="<?php echo $tb_jurnalm->tglm->EditValue ?>"<?php echo $tb_jurnalm->tglm->EditAttributes() ?>>
<?php if (!$tb_jurnalm->tglm->ReadOnly && !$tb_jurnalm->tglm->Disabled && !isset($tb_jurnalm->tglm->EditAttrs["readonly"]) && !isset($tb_jurnalm->tglm->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ftb_jurnalmadd", "x_tglm", 7);
</script>
<?php } ?>
</span>
<?php echo $tb_jurnalm->tglm->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jurnalm->ketm->Visible) { // ketm ?>
	<div id="r_ketm" class="form-group">
		<label id="elh_tb_jurnalm_ketm" for="x_ketm" class="col-sm-2 control-label ewLabel"><?php echo $tb_jurnalm->ketm->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_jurnalm->ketm->CellAttributes() ?>>
<span id="el_tb_jurnalm_ketm">
<textarea data-table="tb_jurnalm" data-field="x_ketm" name="x_ketm" id="x_ketm" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($tb_jurnalm->ketm->getPlaceHolder()) ?>"<?php echo $tb_jurnalm->ketm->EditAttributes() ?>><?php echo $tb_jurnalm->ketm->EditValue ?></textarea>
</span>
<?php echo $tb_jurnalm->ketm->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("tb_detailm", explode(",", $tb_jurnalm->getCurrentDetailTable())) && $tb_detailm->DetailAdd) {
?>
<?php if ($tb_jurnalm->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("tb_detailm", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "tb_detailmgrid.php" ?>
<?php } ?>
<?php if (!$tb_jurnalm_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tb_jurnalm_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ftb_jurnalmadd.Init();
</script>
<?php
$tb_jurnalm_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");
// isi tanggal jurnal memorial ostosmastis tanggal hari ini

$("#x_tglm").val("<?php echo date('d/m/Y'); ?>");

function debet_onchange(event) {
	var elm_name = $(event.target).val();
	debet_new = parseInt(elm_name);
	if(isNaN(debet_old)) debet_old = 0;
	if(isNaN(debet_new)) debet_new = 0;
	debet_total = debet_total - debet_old + debet_new;
	alert('debet : '+debet_total);
}

function debet_onfocus(event) {
	var elm_name = $(event.target).val();
	debet_old = parseInt(elm_name);
}

function kredit_onchange(event) {
	var elm_name = $(event.target).val();
	kredit_new = parseInt(elm_name);
	if(isNaN(kredit_old)) kredit_old = 0;
	if(isNaN(kredit_new)) kredit_new = 0;
	kredit_total = kredit_total - kredit_old + kredit_new;
	alert('kredit : '+kredit_total);
}

function kredit_onfocus(event) {
	var elm_name = $(event.target).val();
	kredit_old = parseInt(elm_name);
}
</script>
<?php include_once "footer.php" ?>
<?php
$tb_jurnalm_add->Page_Terminate();
?>

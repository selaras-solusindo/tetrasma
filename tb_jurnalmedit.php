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

$tb_jurnalm_edit = NULL; // Initialize page object first

class ctb_jurnalm_edit extends ctb_jurnalm {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}";

	// Table name
	var $TableName = 'tb_jurnalm';

	// Page object name
	var $PageObjName = 'tb_jurnalm_edit';

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

		// Table object (tb_jurnalm)
		if (!isset($GLOBALS["tb_jurnalm"]) || get_class($GLOBALS["tb_jurnalm"]) == "ctb_jurnalm") {
			$GLOBALS["tb_jurnalm"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_jurnalm"];
		}

		// Table object (tb_user)
		if (!isset($GLOBALS['tb_user'])) $GLOBALS['tb_user'] = new ctb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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
		$this->jurnalm_id->SetVisibility();
		$this->jurnalm_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
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
		if (@$_GET["jurnalm_id"] <> "") {
			$this->jurnalm_id->setQueryStringValue($_GET["jurnalm_id"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Set up detail parameters
			$this->SetUpDetailParms();
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->jurnalm_id->CurrentValue == "") {
			$this->Page_Terminate("tb_jurnalmlist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("tb_jurnalmlist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			Case "U": // Update
				if ($this->getCurrentDetailTable() <> "") // Master/detail edit
					$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
				else
					$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "tb_jurnalmlist.php")
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

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		if (!$this->jurnalm_id->FldIsDetailKey)
			$this->jurnalm_id->setFormValue($objForm->GetValue("x_jurnalm_id"));
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
		$this->LoadRow();
		$this->jurnalm_id->CurrentValue = $this->jurnalm_id->FormValue;
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

			// jurnalm_id
			$this->jurnalm_id->LinkCustomAttributes = "";
			$this->jurnalm_id->HrefValue = "";
			$this->jurnalm_id->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// jurnalm_id
			$this->jurnalm_id->EditAttrs["class"] = "form-control";
			$this->jurnalm_id->EditCustomAttributes = "";
			$this->jurnalm_id->EditValue = $this->jurnalm_id->CurrentValue;
			$this->jurnalm_id->ViewCustomAttributes = "";

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

			// Edit refer script
			// jurnalm_id

			$this->jurnalm_id->LinkCustomAttributes = "";
			$this->jurnalm_id->HrefValue = "";

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
		if (in_array("tb_detailm", $DetailTblVar) && $GLOBALS["tb_detailm"]->DetailEdit) {
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// no_buktim
			$this->no_buktim->SetDbValueDef($rsnew, $this->no_buktim->CurrentValue, "", $this->no_buktim->ReadOnly);

			// tglm
			$this->tglm->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tglm->CurrentValue, 7), ew_CurrentDate(), $this->tglm->ReadOnly);

			// ketm
			$this->ketm->SetDbValueDef($rsnew, $this->ketm->CurrentValue, "", $this->ketm->ReadOnly);

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

				// Update detail records
				$DetailTblVar = explode(",", $this->getCurrentDetailTable());
				if ($EditRow) {
					if (in_array("tb_detailm", $DetailTblVar) && $GLOBALS["tb_detailm"]->DetailEdit) {
						if (!isset($GLOBALS["tb_detailm_grid"])) $GLOBALS["tb_detailm_grid"] = new ctb_detailm_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "tb_detailm"); // Load user level of detail table
						$EditRow = $GLOBALS["tb_detailm_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
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
				if ($GLOBALS["tb_detailm_grid"]->DetailEdit) {
					$GLOBALS["tb_detailm_grid"]->CurrentMode = "edit";
					$GLOBALS["tb_detailm_grid"]->CurrentAction = "gridedit";

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
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'tb_jurnalm';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['jurnalm_id'];

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
if (!isset($tb_jurnalm_edit)) $tb_jurnalm_edit = new ctb_jurnalm_edit();

// Page init
$tb_jurnalm_edit->Page_Init();

// Page main
$tb_jurnalm_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_jurnalm_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ftb_jurnalmedit = new ew_Form("ftb_jurnalmedit", "edit");

// Validate form
ftb_jurnalmedit.Validate = function() {
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
ftb_jurnalmedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftb_jurnalmedit.ValidateRequired = true;
<?php } else { ?>
ftb_jurnalmedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$tb_jurnalm_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $tb_jurnalm_edit->ShowPageHeader(); ?>
<?php
$tb_jurnalm_edit->ShowMessage();
?>
<form name="ftb_jurnalmedit" id="ftb_jurnalmedit" class="<?php echo $tb_jurnalm_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_jurnalm_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_jurnalm_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_jurnalm">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($tb_jurnalm_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($tb_jurnalm->jurnalm_id->Visible) { // jurnalm_id ?>
	<div id="r_jurnalm_id" class="form-group">
		<label id="elh_tb_jurnalm_jurnalm_id" class="col-sm-2 control-label ewLabel"><?php echo $tb_jurnalm->jurnalm_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tb_jurnalm->jurnalm_id->CellAttributes() ?>>
<span id="el_tb_jurnalm_jurnalm_id">
<span<?php echo $tb_jurnalm->jurnalm_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_jurnalm->jurnalm_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="tb_jurnalm" data-field="x_jurnalm_id" name="x_jurnalm_id" id="x_jurnalm_id" value="<?php echo ew_HtmlEncode($tb_jurnalm->jurnalm_id->CurrentValue) ?>">
<?php echo $tb_jurnalm->jurnalm_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
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
ew_CreateCalendar("ftb_jurnalmedit", "x_tglm", 7);
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
	if (in_array("tb_detailm", explode(",", $tb_jurnalm->getCurrentDetailTable())) && $tb_detailm->DetailEdit) {
?>
<?php if ($tb_jurnalm->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("tb_detailm", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "tb_detailmgrid.php" ?>
<?php } ?>
<?php if (!$tb_jurnalm_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tb_jurnalm_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ftb_jurnalmedit.Init();
</script>
<?php
$tb_jurnalm_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tb_jurnalm_edit->Page_Terminate();
?>

<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "tb_detailinfo.php" ?>
<?php include_once "tb_userinfo.php" ?>
<?php include_once "tb_jurnalinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$tb_detail_edit = NULL; // Initialize page object first

class ctb_detail_edit extends ctb_detail {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}";

	// Table name
	var $TableName = 'tb_detail';

	// Page object name
	var $PageObjName = 'tb_detail_edit';

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

		// Table object (tb_detail)
		if (!isset($GLOBALS["tb_detail"]) || get_class($GLOBALS["tb_detail"]) == "ctb_detail") {
			$GLOBALS["tb_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_detail"];
		}

		// Table object (tb_user)
		if (!isset($GLOBALS['tb_user'])) $GLOBALS['tb_user'] = new ctb_user();

		// Table object (tb_jurnal)
		if (!isset($GLOBALS['tb_jurnal'])) $GLOBALS['tb_jurnal'] = new ctb_jurnal();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tb_detail', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("tb_detaillist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->akun_id->SetVisibility();
		$this->nilai->SetVisibility();
		$this->anggota_id->SetVisibility();

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
		global $EW_EXPORT, $tb_detail;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tb_detail);
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
		if (@$_GET["detail_id"] <> "") {
			$this->detail_id->setQueryStringValue($_GET["detail_id"]);
		}

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->detail_id->CurrentValue == "") {
			$this->Page_Terminate("tb_detaillist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("tb_detaillist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "tb_detaillist.php")
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
		if (!$this->akun_id->FldIsDetailKey) {
			$this->akun_id->setFormValue($objForm->GetValue("x_akun_id"));
		}
		if (!$this->nilai->FldIsDetailKey) {
			$this->nilai->setFormValue($objForm->GetValue("x_nilai"));
		}
		if (!$this->anggota_id->FldIsDetailKey) {
			$this->anggota_id->setFormValue($objForm->GetValue("x_anggota_id"));
		}
		if (!$this->detail_id->FldIsDetailKey)
			$this->detail_id->setFormValue($objForm->GetValue("x_detail_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->detail_id->CurrentValue = $this->detail_id->FormValue;
		$this->akun_id->CurrentValue = $this->akun_id->FormValue;
		$this->nilai->CurrentValue = $this->nilai->FormValue;
		$this->anggota_id->CurrentValue = $this->anggota_id->FormValue;
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
		$this->detail_id->setDbValue($rs->fields('detail_id'));
		$this->jurnal_id->setDbValue($rs->fields('jurnal_id'));
		$this->akun_id->setDbValue($rs->fields('akun_id'));
		if (array_key_exists('EV__akun_id', $rs->fields)) {
			$this->akun_id->VirtualValue = $rs->fields('EV__akun_id'); // Set up virtual field value
		} else {
			$this->akun_id->VirtualValue = ""; // Clear value
		}
		$this->nilai->setDbValue($rs->fields('nilai'));
		$this->anggota_id->setDbValue($rs->fields('anggota_id'));
		if (array_key_exists('EV__anggota_id', $rs->fields)) {
			$this->anggota_id->VirtualValue = $rs->fields('EV__anggota_id'); // Set up virtual field value
		} else {
			$this->anggota_id->VirtualValue = ""; // Clear value
		}
		$this->dk->setDbValue($rs->fields('dk'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->detail_id->DbValue = $row['detail_id'];
		$this->jurnal_id->DbValue = $row['jurnal_id'];
		$this->akun_id->DbValue = $row['akun_id'];
		$this->nilai->DbValue = $row['nilai'];
		$this->anggota_id->DbValue = $row['anggota_id'];
		$this->dk->DbValue = $row['dk'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// detail_id
		// jurnal_id
		// akun_id
		// nilai
		// anggota_id
		// dk

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// detail_id
		$this->detail_id->ViewValue = $this->detail_id->CurrentValue;
		$this->detail_id->ViewCustomAttributes = "";

		// jurnal_id
		$this->jurnal_id->ViewValue = $this->jurnal_id->CurrentValue;
		$this->jurnal_id->ViewCustomAttributes = "";

		// akun_id
		if ($this->akun_id->VirtualValue <> "") {
			$this->akun_id->ViewValue = $this->akun_id->VirtualValue;
		} else {
			$this->akun_id->ViewValue = $this->akun_id->CurrentValue;
		if (strval($this->akun_id->CurrentValue) <> "") {
			$sFilterWrk = "`level4_id`" . ew_SearchString("=", $this->akun_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `level4_id`, `no_nama_akun` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `view_akun_jurnal`";
		$sWhereWrk = "";
		$this->akun_id->LookupFilters = array("dx1" => '`no_nama_akun`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->akun_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->akun_id->ViewValue = $this->akun_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->akun_id->ViewValue = $this->akun_id->CurrentValue;
			}
		} else {
			$this->akun_id->ViewValue = NULL;
		}
		}
		$this->akun_id->ViewCustomAttributes = "";

		// nilai
		$this->nilai->ViewValue = $this->nilai->CurrentValue;
		$this->nilai->ViewValue = ew_FormatNumber($this->nilai->ViewValue, 0, -2, -2, -1);
		$this->nilai->CellCssStyle .= "text-align: right;";
		$this->nilai->ViewCustomAttributes = "";

		// anggota_id
		if ($this->anggota_id->VirtualValue <> "") {
			$this->anggota_id->ViewValue = $this->anggota_id->VirtualValue;
		} else {
			$this->anggota_id->ViewValue = $this->anggota_id->CurrentValue;
		if (strval($this->anggota_id->CurrentValue) <> "") {
			$sFilterWrk = "`anggota_id`" . ew_SearchString("=", $this->anggota_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `anggota_id`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tb_anggota`";
		$sWhereWrk = "";
		$this->anggota_id->LookupFilters = array("dx1" => '`nama`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->anggota_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->anggota_id->ViewValue = $this->anggota_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->anggota_id->ViewValue = $this->anggota_id->CurrentValue;
			}
		} else {
			$this->anggota_id->ViewValue = NULL;
		}
		}
		$this->anggota_id->ViewCustomAttributes = "";

			// akun_id
			$this->akun_id->LinkCustomAttributes = "";
			$this->akun_id->HrefValue = "";
			$this->akun_id->TooltipValue = "";

			// nilai
			$this->nilai->LinkCustomAttributes = "";
			$this->nilai->HrefValue = "";
			$this->nilai->TooltipValue = "";

			// anggota_id
			$this->anggota_id->LinkCustomAttributes = "";
			$this->anggota_id->HrefValue = "";
			$this->anggota_id->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// akun_id
			$this->akun_id->EditAttrs["class"] = "form-control";
			$this->akun_id->EditCustomAttributes = "";
			$this->akun_id->EditValue = ew_HtmlEncode($this->akun_id->CurrentValue);
			if (strval($this->akun_id->CurrentValue) <> "") {
				$sFilterWrk = "`level4_id`" . ew_SearchString("=", $this->akun_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `level4_id`, `no_nama_akun` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `view_akun_jurnal`";
			$sWhereWrk = "";
			$this->akun_id->LookupFilters = array("dx1" => '`no_nama_akun`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->akun_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->akun_id->EditValue = $this->akun_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->akun_id->EditValue = ew_HtmlEncode($this->akun_id->CurrentValue);
				}
			} else {
				$this->akun_id->EditValue = NULL;
			}
			$this->akun_id->PlaceHolder = ew_RemoveHtml($this->akun_id->FldCaption());

			// nilai
			$this->nilai->EditAttrs["class"] = "form-control";
			$this->nilai->EditCustomAttributes = "";
			$this->nilai->EditValue = ew_HtmlEncode($this->nilai->CurrentValue);
			$this->nilai->PlaceHolder = ew_RemoveHtml($this->nilai->FldCaption());

			// anggota_id
			$this->anggota_id->EditAttrs["class"] = "form-control";
			$this->anggota_id->EditCustomAttributes = "";
			$this->anggota_id->EditValue = ew_HtmlEncode($this->anggota_id->CurrentValue);
			if (strval($this->anggota_id->CurrentValue) <> "") {
				$sFilterWrk = "`anggota_id`" . ew_SearchString("=", $this->anggota_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `anggota_id`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tb_anggota`";
			$sWhereWrk = "";
			$this->anggota_id->LookupFilters = array("dx1" => '`nama`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->anggota_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->anggota_id->EditValue = $this->anggota_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->anggota_id->EditValue = ew_HtmlEncode($this->anggota_id->CurrentValue);
				}
			} else {
				$this->anggota_id->EditValue = NULL;
			}
			$this->anggota_id->PlaceHolder = ew_RemoveHtml($this->anggota_id->FldCaption());

			// Edit refer script
			// akun_id

			$this->akun_id->LinkCustomAttributes = "";
			$this->akun_id->HrefValue = "";

			// nilai
			$this->nilai->LinkCustomAttributes = "";
			$this->nilai->HrefValue = "";

			// anggota_id
			$this->anggota_id->LinkCustomAttributes = "";
			$this->anggota_id->HrefValue = "";
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
		if (!$this->akun_id->FldIsDetailKey && !is_null($this->akun_id->FormValue) && $this->akun_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->akun_id->FldCaption(), $this->akun_id->ReqErrMsg));
		}
		if (!$this->nilai->FldIsDetailKey && !is_null($this->nilai->FormValue) && $this->nilai->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nilai->FldCaption(), $this->nilai->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->nilai->FormValue)) {
			ew_AddMessage($gsFormError, $this->nilai->FldErrMsg());
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

			// akun_id
			$this->akun_id->SetDbValueDef($rsnew, $this->akun_id->CurrentValue, 0, $this->akun_id->ReadOnly);

			// nilai
			$this->nilai->SetDbValueDef($rsnew, $this->nilai->CurrentValue, 0, $this->nilai->ReadOnly);

			// anggota_id
			$this->anggota_id->SetDbValueDef($rsnew, $this->anggota_id->CurrentValue, NULL, $this->anggota_id->ReadOnly);

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
			if ($sMasterTblVar == "tb_jurnal") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_jurnal_id"] <> "") {
					$GLOBALS["tb_jurnal"]->jurnal_id->setQueryStringValue($_GET["fk_jurnal_id"]);
					$this->jurnal_id->setQueryStringValue($GLOBALS["tb_jurnal"]->jurnal_id->QueryStringValue);
					$this->jurnal_id->setSessionValue($this->jurnal_id->QueryStringValue);
					if (!is_numeric($GLOBALS["tb_jurnal"]->jurnal_id->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "tb_jurnal") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_jurnal_id"] <> "") {
					$GLOBALS["tb_jurnal"]->jurnal_id->setFormValue($_POST["fk_jurnal_id"]);
					$this->jurnal_id->setFormValue($GLOBALS["tb_jurnal"]->jurnal_id->FormValue);
					$this->jurnal_id->setSessionValue($this->jurnal_id->FormValue);
					if (!is_numeric($GLOBALS["tb_jurnal"]->jurnal_id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);
			$this->setSessionWhere($this->GetDetailFilter());

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "tb_jurnal") {
				if ($this->jurnal_id->CurrentValue == "") $this->jurnal_id->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_detaillist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_akun_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `level4_id` AS `LinkFld`, `no_nama_akun` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `view_akun_jurnal`";
			$sWhereWrk = "{filter}";
			$this->akun_id->LookupFilters = array("dx1" => '`no_nama_akun`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`level4_id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->akun_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_anggota_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `anggota_id` AS `LinkFld`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tb_anggota`";
			$sWhereWrk = "{filter}";
			$this->anggota_id->LookupFilters = array("dx1" => '`nama`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`anggota_id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->anggota_id, $sWhereWrk); // Call Lookup selecting
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
		case "x_akun_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `level4_id`, `no_nama_akun` AS `DispFld` FROM `view_akun_jurnal`";
			$sWhereWrk = "`no_nama_akun` LIKE '{query_value}%'";
			$this->akun_id->LookupFilters = array("dx1" => '`no_nama_akun`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->akun_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_anggota_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `anggota_id`, `nama` AS `DispFld` FROM `tb_anggota`";
			$sWhereWrk = "`nama` LIKE '{query_value}%'";
			$this->anggota_id->LookupFilters = array("dx1" => '`nama`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->anggota_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'tb_detail';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'tb_detail';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['detail_id'];

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
if (!isset($tb_detail_edit)) $tb_detail_edit = new ctb_detail_edit();

// Page init
$tb_detail_edit->Page_Init();

// Page main
$tb_detail_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_detail_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ftb_detailedit = new ew_Form("ftb_detailedit", "edit");

// Validate form
ftb_detailedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_akun_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_detail->akun_id->FldCaption(), $tb_detail->akun_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nilai");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_detail->nilai->FldCaption(), $tb_detail->nilai->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nilai");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_detail->nilai->FldErrMsg()) ?>");

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
ftb_detailedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftb_detailedit.ValidateRequired = true;
<?php } else { ?>
ftb_detailedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftb_detailedit.Lists["x_akun_id"] = {"LinkField":"x_level4_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_nama_akun","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"view_akun_jurnal"};
ftb_detailedit.Lists["x_anggota_id"] = {"LinkField":"x_anggota_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tb_anggota"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$tb_detail_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $tb_detail_edit->ShowPageHeader(); ?>
<?php
$tb_detail_edit->ShowMessage();
?>
<form name="ftb_detailedit" id="ftb_detailedit" class="<?php echo $tb_detail_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_detail_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_detail_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_detail">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($tb_detail_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($tb_detail->getCurrentMasterTable() == "tb_jurnal") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="tb_jurnal">
<input type="hidden" name="fk_jurnal_id" value="<?php echo $tb_detail->jurnal_id->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($tb_detail->akun_id->Visible) { // akun_id ?>
	<div id="r_akun_id" class="form-group">
		<label id="elh_tb_detail_akun_id" class="col-sm-2 control-label ewLabel"><?php echo $tb_detail->akun_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_detail->akun_id->CellAttributes() ?>>
<span id="el_tb_detail_akun_id">
<?php
$wrkonchange = trim(" " . @$tb_detail->akun_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_detail->akun_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_akun_id" style="white-space: nowrap; z-index: 8970">
	<input type="text" name="sv_x_akun_id" id="sv_x_akun_id" value="<?php echo $tb_detail->akun_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->akun_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_detail->akun_id->getPlaceHolder()) ?>"<?php echo $tb_detail->akun_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_akun_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_detail->akun_id->DisplayValueSeparatorAttribute() ?>" name="x_akun_id" id="x_akun_id" value="<?php echo ew_HtmlEncode($tb_detail->akun_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_akun_id" id="q_x_akun_id" value="<?php echo $tb_detail->akun_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ftb_detailedit.CreateAutoSuggest({"id":"x_akun_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_detail->akun_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_akun_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x_akun_id" id="s_x_akun_id" value="<?php echo $tb_detail->akun_id->LookupFilterQuery(false) ?>">
</span>
<?php echo $tb_detail->akun_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_detail->nilai->Visible) { // nilai ?>
	<div id="r_nilai" class="form-group">
		<label id="elh_tb_detail_nilai" for="x_nilai" class="col-sm-2 control-label ewLabel"><?php echo $tb_detail->nilai->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_detail->nilai->CellAttributes() ?>>
<span id="el_tb_detail_nilai">
<input type="text" data-table="tb_detail" data-field="x_nilai" name="x_nilai" id="x_nilai" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->nilai->getPlaceHolder()) ?>" value="<?php echo $tb_detail->nilai->EditValue ?>"<?php echo $tb_detail->nilai->EditAttributes() ?>>
</span>
<?php echo $tb_detail->nilai->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_detail->anggota_id->Visible) { // anggota_id ?>
	<div id="r_anggota_id" class="form-group">
		<label id="elh_tb_detail_anggota_id" class="col-sm-2 control-label ewLabel"><?php echo $tb_detail->anggota_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tb_detail->anggota_id->CellAttributes() ?>>
<span id="el_tb_detail_anggota_id">
<?php
$wrkonchange = trim(" " . @$tb_detail->anggota_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_detail->anggota_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_anggota_id" style="white-space: nowrap; z-index: 8950">
	<input type="text" name="sv_x_anggota_id" id="sv_x_anggota_id" value="<?php echo $tb_detail->anggota_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->anggota_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_detail->anggota_id->getPlaceHolder()) ?>"<?php echo $tb_detail->anggota_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_anggota_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_detail->anggota_id->DisplayValueSeparatorAttribute() ?>" name="x_anggota_id" id="x_anggota_id" value="<?php echo ew_HtmlEncode($tb_detail->anggota_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_anggota_id" id="q_x_anggota_id" value="<?php echo $tb_detail->anggota_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ftb_detailedit.CreateAutoSuggest({"id":"x_anggota_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_detail->anggota_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_anggota_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x_anggota_id" id="s_x_anggota_id" value="<?php echo $tb_detail->anggota_id->LookupFilterQuery(false) ?>">
</span>
<?php echo $tb_detail->anggota_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="tb_detail" data-field="x_detail_id" name="x_detail_id" id="x_detail_id" value="<?php echo ew_HtmlEncode($tb_detail->detail_id->CurrentValue) ?>">
<?php if (!$tb_detail_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tb_detail_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ftb_detailedit.Init();
</script>
<?php
$tb_detail_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tb_detail_edit->Page_Terminate();
?>

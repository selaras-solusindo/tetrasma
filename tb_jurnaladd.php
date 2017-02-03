<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "tb_jurnalinfo.php" ?>
<?php include_once "tb_userinfo.php" ?>
<?php include_once "tb_detailgridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$tb_jurnal_add = NULL; // Initialize page object first

class ctb_jurnal_add extends ctb_jurnal {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}";

	// Table name
	var $TableName = 'tb_jurnal';

	// Page object name
	var $PageObjName = 'tb_jurnal_add';

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

		// Table object (tb_jurnal)
		if (!isset($GLOBALS["tb_jurnal"]) || get_class($GLOBALS["tb_jurnal"]) == "ctb_jurnal") {
			$GLOBALS["tb_jurnal"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_jurnal"];
		}

		// Table object (tb_user)
		if (!isset($GLOBALS['tb_user'])) $GLOBALS['tb_user'] = new ctb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tb_jurnal', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("tb_jurnallist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->akun_id->SetVisibility();
		$this->jenis_jurnal->SetVisibility();
		$this->no_bukti->SetVisibility();
		$this->tgl->SetVisibility();
		$this->ket->SetVisibility();
		$this->nilai->SetVisibility();

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

			// Process auto fill for detail table 'tb_detail'
			if (@$_POST["grid"] == "ftb_detailgrid") {
				if (!isset($GLOBALS["tb_detail_grid"])) $GLOBALS["tb_detail_grid"] = new ctb_detail_grid;
				$GLOBALS["tb_detail_grid"]->Page_Init();
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
		global $EW_EXPORT, $tb_jurnal;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tb_jurnal);
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
			if (@$_GET["jurnal_id"] != "") {
				$this->jurnal_id->setQueryStringValue($_GET["jurnal_id"]);
				$this->setKey("jurnal_id", $this->jurnal_id->CurrentValue); // Set up key
			} else {
				$this->setKey("jurnal_id", ""); // Clear key
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
					$this->Page_Terminate("tb_jurnallist.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "tb_jurnallist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "tb_jurnalview.php")
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
		$this->akun_id->CurrentValue = NULL;
		$this->akun_id->OldValue = $this->akun_id->CurrentValue;
		$this->jenis_jurnal->CurrentValue = NULL;
		$this->jenis_jurnal->OldValue = $this->jenis_jurnal->CurrentValue;
		$this->no_bukti->CurrentValue = NULL;
		$this->no_bukti->OldValue = $this->no_bukti->CurrentValue;
		$this->tgl->CurrentValue = NULL;
		$this->tgl->OldValue = $this->tgl->CurrentValue;
		$this->ket->CurrentValue = NULL;
		$this->ket->OldValue = $this->ket->CurrentValue;
		$this->nilai->CurrentValue = 0;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->akun_id->FldIsDetailKey) {
			$this->akun_id->setFormValue($objForm->GetValue("x_akun_id"));
		}
		if (!$this->jenis_jurnal->FldIsDetailKey) {
			$this->jenis_jurnal->setFormValue($objForm->GetValue("x_jenis_jurnal"));
		}
		if (!$this->no_bukti->FldIsDetailKey) {
			$this->no_bukti->setFormValue($objForm->GetValue("x_no_bukti"));
		}
		if (!$this->tgl->FldIsDetailKey) {
			$this->tgl->setFormValue($objForm->GetValue("x_tgl"));
			$this->tgl->CurrentValue = ew_UnFormatDateTime($this->tgl->CurrentValue, 7);
		}
		if (!$this->ket->FldIsDetailKey) {
			$this->ket->setFormValue($objForm->GetValue("x_ket"));
		}
		if (!$this->nilai->FldIsDetailKey) {
			$this->nilai->setFormValue($objForm->GetValue("x_nilai"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->akun_id->CurrentValue = $this->akun_id->FormValue;
		$this->jenis_jurnal->CurrentValue = $this->jenis_jurnal->FormValue;
		$this->no_bukti->CurrentValue = $this->no_bukti->FormValue;
		$this->tgl->CurrentValue = $this->tgl->FormValue;
		$this->tgl->CurrentValue = ew_UnFormatDateTime($this->tgl->CurrentValue, 7);
		$this->ket->CurrentValue = $this->ket->FormValue;
		$this->nilai->CurrentValue = $this->nilai->FormValue;
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
		$this->jurnal_id->setDbValue($rs->fields('jurnal_id'));
		$this->akun_id->setDbValue($rs->fields('akun_id'));
		if (array_key_exists('EV__akun_id', $rs->fields)) {
			$this->akun_id->VirtualValue = $rs->fields('EV__akun_id'); // Set up virtual field value
		} else {
			$this->akun_id->VirtualValue = ""; // Clear value
		}
		$this->jenis_jurnal->setDbValue($rs->fields('jenis_jurnal'));
		$this->no_bukti->setDbValue($rs->fields('no_bukti'));
		$this->tgl->setDbValue($rs->fields('tgl'));
		$this->ket->setDbValue($rs->fields('ket'));
		$this->nilai->setDbValue($rs->fields('nilai'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->jurnal_id->DbValue = $row['jurnal_id'];
		$this->akun_id->DbValue = $row['akun_id'];
		$this->jenis_jurnal->DbValue = $row['jenis_jurnal'];
		$this->no_bukti->DbValue = $row['no_bukti'];
		$this->tgl->DbValue = $row['tgl'];
		$this->ket->DbValue = $row['ket'];
		$this->nilai->DbValue = $row['nilai'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("jurnal_id")) <> "")
			$this->jurnal_id->CurrentValue = $this->getKey("jurnal_id"); // jurnal_id
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
		// jurnal_id
		// akun_id
		// jenis_jurnal
		// no_bukti
		// tgl
		// ket
		// nilai

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// jurnal_id
		$this->jurnal_id->ViewValue = $this->jurnal_id->CurrentValue;
		$this->jurnal_id->ViewCustomAttributes = "";

		// akun_id
		if ($this->akun_id->VirtualValue <> "") {
			$this->akun_id->ViewValue = $this->akun_id->VirtualValue;
		} else {
		if (strval($this->akun_id->CurrentValue) <> "") {
			$sFilterWrk = "`level4_id`" . ew_SearchString("=", $this->akun_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `level4_id`, `no_nama_akun` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `view_akun_jurnal`";
		$sWhereWrk = "";
		$this->akun_id->LookupFilters = array("dx1" => '`no_nama_akun`');
		$lookuptblfilter = "`jurnal` = 1";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
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

		// jenis_jurnal
		if (strval($this->jenis_jurnal->CurrentValue) <> "") {
			$this->jenis_jurnal->ViewValue = $this->jenis_jurnal->OptionCaption($this->jenis_jurnal->CurrentValue);
		} else {
			$this->jenis_jurnal->ViewValue = NULL;
		}
		$this->jenis_jurnal->ViewCustomAttributes = "";

		// no_bukti
		$this->no_bukti->ViewValue = $this->no_bukti->CurrentValue;
		$this->no_bukti->ViewCustomAttributes = "";

		// tgl
		$this->tgl->ViewValue = $this->tgl->CurrentValue;
		$this->tgl->ViewValue = ew_FormatDateTime($this->tgl->ViewValue, 7);
		$this->tgl->ViewCustomAttributes = "";

		// ket
		$this->ket->ViewValue = $this->ket->CurrentValue;
		$this->ket->ViewCustomAttributes = "";

		// nilai
		$this->nilai->ViewValue = $this->nilai->CurrentValue;
		$this->nilai->ViewValue = ew_FormatNumber($this->nilai->ViewValue, 0, -2, -2, -1);
		$this->nilai->CellCssStyle .= "text-align: right;";
		$this->nilai->ViewCustomAttributes = "";

			// akun_id
			$this->akun_id->LinkCustomAttributes = "";
			$this->akun_id->HrefValue = "";
			$this->akun_id->TooltipValue = "";

			// jenis_jurnal
			$this->jenis_jurnal->LinkCustomAttributes = "";
			$this->jenis_jurnal->HrefValue = "";
			$this->jenis_jurnal->TooltipValue = "";

			// no_bukti
			$this->no_bukti->LinkCustomAttributes = "";
			$this->no_bukti->HrefValue = "";
			$this->no_bukti->TooltipValue = "";

			// tgl
			$this->tgl->LinkCustomAttributes = "";
			$this->tgl->HrefValue = "";
			$this->tgl->TooltipValue = "";

			// ket
			$this->ket->LinkCustomAttributes = "";
			$this->ket->HrefValue = "";
			$this->ket->TooltipValue = "";

			// nilai
			$this->nilai->LinkCustomAttributes = "";
			$this->nilai->HrefValue = "";
			$this->nilai->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// akun_id
			$this->akun_id->EditCustomAttributes = "";
			if (trim(strval($this->akun_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`level4_id`" . ew_SearchString("=", $this->akun_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `level4_id`, `no_nama_akun` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `view_akun_jurnal`";
			$sWhereWrk = "";
			$this->akun_id->LookupFilters = array("dx1" => '`no_nama_akun`');
			$lookuptblfilter = "`jurnal` = 1";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->akun_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->akun_id->ViewValue = $this->akun_id->DisplayValue($arwrk);
			} else {
				$this->akun_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->akun_id->EditValue = $arwrk;

			// jenis_jurnal
			$this->jenis_jurnal->EditAttrs["class"] = "form-control";
			$this->jenis_jurnal->EditCustomAttributes = "";
			$this->jenis_jurnal->EditValue = $this->jenis_jurnal->Options(TRUE);

			// no_bukti
			$this->no_bukti->EditAttrs["class"] = "form-control";
			$this->no_bukti->EditCustomAttributes = "";
			$this->no_bukti->EditValue = ew_HtmlEncode($this->no_bukti->CurrentValue);
			$this->no_bukti->PlaceHolder = ew_RemoveHtml($this->no_bukti->FldCaption());

			// tgl
			$this->tgl->EditAttrs["class"] = "form-control";
			$this->tgl->EditCustomAttributes = "";
			$this->tgl->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl->CurrentValue, 7));
			$this->tgl->PlaceHolder = ew_RemoveHtml($this->tgl->FldCaption());

			// ket
			$this->ket->EditAttrs["class"] = "form-control";
			$this->ket->EditCustomAttributes = "";
			$this->ket->EditValue = ew_HtmlEncode($this->ket->CurrentValue);
			$this->ket->PlaceHolder = ew_RemoveHtml($this->ket->FldCaption());

			// nilai
			$this->nilai->EditAttrs["class"] = "form-control";
			$this->nilai->EditCustomAttributes = "";
			$this->nilai->EditValue = ew_HtmlEncode($this->nilai->CurrentValue);
			$this->nilai->PlaceHolder = ew_RemoveHtml($this->nilai->FldCaption());

			// Add refer script
			// akun_id

			$this->akun_id->LinkCustomAttributes = "";
			$this->akun_id->HrefValue = "";

			// jenis_jurnal
			$this->jenis_jurnal->LinkCustomAttributes = "";
			$this->jenis_jurnal->HrefValue = "";

			// no_bukti
			$this->no_bukti->LinkCustomAttributes = "";
			$this->no_bukti->HrefValue = "";

			// tgl
			$this->tgl->LinkCustomAttributes = "";
			$this->tgl->HrefValue = "";

			// ket
			$this->ket->LinkCustomAttributes = "";
			$this->ket->HrefValue = "";

			// nilai
			$this->nilai->LinkCustomAttributes = "";
			$this->nilai->HrefValue = "";
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
		if (!$this->jenis_jurnal->FldIsDetailKey && !is_null($this->jenis_jurnal->FormValue) && $this->jenis_jurnal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->jenis_jurnal->FldCaption(), $this->jenis_jurnal->ReqErrMsg));
		}
		if (!$this->no_bukti->FldIsDetailKey && !is_null($this->no_bukti->FormValue) && $this->no_bukti->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->no_bukti->FldCaption(), $this->no_bukti->ReqErrMsg));
		}
		if (!$this->tgl->FldIsDetailKey && !is_null($this->tgl->FormValue) && $this->tgl->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tgl->FldCaption(), $this->tgl->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->tgl->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl->FldErrMsg());
		}
		if (!$this->ket->FldIsDetailKey && !is_null($this->ket->FormValue) && $this->ket->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ket->FldCaption(), $this->ket->ReqErrMsg));
		}
		if (!$this->nilai->FldIsDetailKey && !is_null($this->nilai->FormValue) && $this->nilai->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nilai->FldCaption(), $this->nilai->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->nilai->FormValue)) {
			ew_AddMessage($gsFormError, $this->nilai->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("tb_detail", $DetailTblVar) && $GLOBALS["tb_detail"]->DetailAdd) {
			if (!isset($GLOBALS["tb_detail_grid"])) $GLOBALS["tb_detail_grid"] = new ctb_detail_grid(); // get detail page object
			$GLOBALS["tb_detail_grid"]->ValidateGridForm();
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

		// akun_id
		$this->akun_id->SetDbValueDef($rsnew, $this->akun_id->CurrentValue, 0, FALSE);

		// jenis_jurnal
		$this->jenis_jurnal->SetDbValueDef($rsnew, $this->jenis_jurnal->CurrentValue, "", FALSE);

		// no_bukti
		$this->no_bukti->SetDbValueDef($rsnew, $this->no_bukti->CurrentValue, "", FALSE);

		// tgl
		$this->tgl->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// ket
		$this->ket->SetDbValueDef($rsnew, $this->ket->CurrentValue, "", FALSE);

		// nilai
		$this->nilai->SetDbValueDef($rsnew, $this->nilai->CurrentValue, 0, strval($this->nilai->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->jurnal_id->setDbValue($conn->Insert_ID());
				$rsnew['jurnal_id'] = $this->jurnal_id->DbValue;
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
			if (in_array("tb_detail", $DetailTblVar) && $GLOBALS["tb_detail"]->DetailAdd) {
				$GLOBALS["tb_detail"]->jurnal_id->setSessionValue($this->jurnal_id->CurrentValue); // Set master key
				if (!isset($GLOBALS["tb_detail_grid"])) $GLOBALS["tb_detail_grid"] = new ctb_detail_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "tb_detail"); // Load user level of detail table
				$AddRow = $GLOBALS["tb_detail_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["tb_detail"]->jurnal_id->setSessionValue(""); // Clear master key if insert failed
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
			if (in_array("tb_detail", $DetailTblVar)) {
				if (!isset($GLOBALS["tb_detail_grid"]))
					$GLOBALS["tb_detail_grid"] = new ctb_detail_grid;
				if ($GLOBALS["tb_detail_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["tb_detail_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["tb_detail_grid"]->CurrentMode = "add";
					$GLOBALS["tb_detail_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["tb_detail_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["tb_detail_grid"]->setStartRecordNumber(1);
					$GLOBALS["tb_detail_grid"]->jurnal_id->FldIsDetailKey = TRUE;
					$GLOBALS["tb_detail_grid"]->jurnal_id->CurrentValue = $this->jurnal_id->CurrentValue;
					$GLOBALS["tb_detail_grid"]->jurnal_id->setSessionValue($GLOBALS["tb_detail_grid"]->jurnal_id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_jurnallist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
			$lookuptblfilter = "`jurnal` = 1";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`level4_id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->akun_id, $sWhereWrk); // Call Lookup selecting
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
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'tb_jurnal';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'tb_jurnal';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['jurnal_id'];

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
if (!isset($tb_jurnal_add)) $tb_jurnal_add = new ctb_jurnal_add();

// Page init
$tb_jurnal_add->Page_Init();

// Page main
$tb_jurnal_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_jurnal_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ftb_jurnaladd = new ew_Form("ftb_jurnaladd", "add");

// Validate form
ftb_jurnaladd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_jurnal->akun_id->FldCaption(), $tb_jurnal->akun_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jenis_jurnal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_jurnal->jenis_jurnal->FldCaption(), $tb_jurnal->jenis_jurnal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_no_bukti");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_jurnal->no_bukti->FldCaption(), $tb_jurnal->no_bukti->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tgl");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_jurnal->tgl->FldCaption(), $tb_jurnal->tgl->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tgl");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_jurnal->tgl->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_ket");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_jurnal->ket->FldCaption(), $tb_jurnal->ket->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nilai");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_jurnal->nilai->FldCaption(), $tb_jurnal->nilai->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nilai");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_jurnal->nilai->FldErrMsg()) ?>");

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
ftb_jurnaladd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftb_jurnaladd.ValidateRequired = true;
<?php } else { ?>
ftb_jurnaladd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftb_jurnaladd.Lists["x_akun_id"] = {"LinkField":"x_level4_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_nama_akun","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"view_akun_jurnal"};
ftb_jurnaladd.Lists["x_jenis_jurnal"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftb_jurnaladd.Lists["x_jenis_jurnal"].Options = <?php echo json_encode($tb_jurnal->jenis_jurnal->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$tb_jurnal_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $tb_jurnal_add->ShowPageHeader(); ?>
<?php
$tb_jurnal_add->ShowMessage();
?>
<form name="ftb_jurnaladd" id="ftb_jurnaladd" class="<?php echo $tb_jurnal_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_jurnal_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_jurnal_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_jurnal">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($tb_jurnal_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($tb_jurnal->akun_id->Visible) { // akun_id ?>
	<div id="r_akun_id" class="form-group">
		<label id="elh_tb_jurnal_akun_id" for="x_akun_id" class="col-sm-2 control-label ewLabel"><?php echo $tb_jurnal->akun_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_jurnal->akun_id->CellAttributes() ?>>
<span id="el_tb_jurnal_akun_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_akun_id"><?php echo (strval($tb_jurnal->akun_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $tb_jurnal->akun_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_jurnal->akun_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_akun_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="tb_jurnal" data-field="x_akun_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_jurnal->akun_id->DisplayValueSeparatorAttribute() ?>" name="x_akun_id" id="x_akun_id" value="<?php echo $tb_jurnal->akun_id->CurrentValue ?>"<?php echo $tb_jurnal->akun_id->EditAttributes() ?>>
<input type="hidden" name="s_x_akun_id" id="s_x_akun_id" value="<?php echo $tb_jurnal->akun_id->LookupFilterQuery() ?>">
</span>
<?php echo $tb_jurnal->akun_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jurnal->jenis_jurnal->Visible) { // jenis_jurnal ?>
	<div id="r_jenis_jurnal" class="form-group">
		<label id="elh_tb_jurnal_jenis_jurnal" for="x_jenis_jurnal" class="col-sm-2 control-label ewLabel"><?php echo $tb_jurnal->jenis_jurnal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_jurnal->jenis_jurnal->CellAttributes() ?>>
<span id="el_tb_jurnal_jenis_jurnal">
<select data-table="tb_jurnal" data-field="x_jenis_jurnal" data-value-separator="<?php echo $tb_jurnal->jenis_jurnal->DisplayValueSeparatorAttribute() ?>" id="x_jenis_jurnal" name="x_jenis_jurnal"<?php echo $tb_jurnal->jenis_jurnal->EditAttributes() ?>>
<?php echo $tb_jurnal->jenis_jurnal->SelectOptionListHtml("x_jenis_jurnal") ?>
</select>
</span>
<?php echo $tb_jurnal->jenis_jurnal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jurnal->no_bukti->Visible) { // no_bukti ?>
	<div id="r_no_bukti" class="form-group">
		<label id="elh_tb_jurnal_no_bukti" for="x_no_bukti" class="col-sm-2 control-label ewLabel"><?php echo $tb_jurnal->no_bukti->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_jurnal->no_bukti->CellAttributes() ?>>
<span id="el_tb_jurnal_no_bukti">
<input type="text" data-table="tb_jurnal" data-field="x_no_bukti" name="x_no_bukti" id="x_no_bukti" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($tb_jurnal->no_bukti->getPlaceHolder()) ?>" value="<?php echo $tb_jurnal->no_bukti->EditValue ?>"<?php echo $tb_jurnal->no_bukti->EditAttributes() ?>>
</span>
<?php echo $tb_jurnal->no_bukti->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jurnal->tgl->Visible) { // tgl ?>
	<div id="r_tgl" class="form-group">
		<label id="elh_tb_jurnal_tgl" for="x_tgl" class="col-sm-2 control-label ewLabel"><?php echo $tb_jurnal->tgl->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_jurnal->tgl->CellAttributes() ?>>
<span id="el_tb_jurnal_tgl">
<input type="text" data-table="tb_jurnal" data-field="x_tgl" data-format="7" name="x_tgl" id="x_tgl" placeholder="<?php echo ew_HtmlEncode($tb_jurnal->tgl->getPlaceHolder()) ?>" value="<?php echo $tb_jurnal->tgl->EditValue ?>"<?php echo $tb_jurnal->tgl->EditAttributes() ?>>
<?php if (!$tb_jurnal->tgl->ReadOnly && !$tb_jurnal->tgl->Disabled && !isset($tb_jurnal->tgl->EditAttrs["readonly"]) && !isset($tb_jurnal->tgl->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ftb_jurnaladd", "x_tgl", 7);
</script>
<?php } ?>
</span>
<?php echo $tb_jurnal->tgl->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jurnal->ket->Visible) { // ket ?>
	<div id="r_ket" class="form-group">
		<label id="elh_tb_jurnal_ket" for="x_ket" class="col-sm-2 control-label ewLabel"><?php echo $tb_jurnal->ket->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_jurnal->ket->CellAttributes() ?>>
<span id="el_tb_jurnal_ket">
<textarea data-table="tb_jurnal" data-field="x_ket" name="x_ket" id="x_ket" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($tb_jurnal->ket->getPlaceHolder()) ?>"<?php echo $tb_jurnal->ket->EditAttributes() ?>><?php echo $tb_jurnal->ket->EditValue ?></textarea>
</span>
<?php echo $tb_jurnal->ket->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jurnal->nilai->Visible) { // nilai ?>
	<div id="r_nilai" class="form-group">
		<label id="elh_tb_jurnal_nilai" for="x_nilai" class="col-sm-2 control-label ewLabel"><?php echo $tb_jurnal->nilai->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_jurnal->nilai->CellAttributes() ?>>
<span id="el_tb_jurnal_nilai">
<input type="text" data-table="tb_jurnal" data-field="x_nilai" name="x_nilai" id="x_nilai" size="30" placeholder="<?php echo ew_HtmlEncode($tb_jurnal->nilai->getPlaceHolder()) ?>" value="<?php echo $tb_jurnal->nilai->EditValue ?>"<?php echo $tb_jurnal->nilai->EditAttributes() ?>>
</span>
<?php echo $tb_jurnal->nilai->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("tb_detail", explode(",", $tb_jurnal->getCurrentDetailTable())) && $tb_detail->DetailAdd) {
?>
<?php if ($tb_jurnal->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("tb_detail", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "tb_detailgrid.php" ?>
<?php } ?>
<?php if (!$tb_jurnal_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tb_jurnal_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ftb_jurnaladd.Init();
</script>
<?php
$tb_jurnal_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");
//function MyEvent(event) {
//	 var elm_name = $(event.target).attr('name');
//	 alert(elm_name);alert("x");
//}

$("#x_tgl").val("<?php echo date('d/m/Y');?>");
$("#x_akun_id").change(function() {
	jurnal_kode = "";
	$("#x_jenis_jurnal").val("");
	$("#x_no_bukti").val("");
	if (this.value!="") { //alert("kosong"); 
		ambil_jurnal_kode(this.value);
	}
	else {

		//$("#x_jenis_jurnal").val("");
		//$("#x_no_bukti").val("");

	}
});
$("#x_jenis_jurnal").change(function() { // Assume Field1 is a text input

	//$("#x_jenis_jurnal").val("");
	$("#x_no_bukti").val("");
	if (this.value!="") {
		ambil_no_bukti(jurnal_kode+this.value);
	}

	//else
		//$("#x_no_bukti").val("");

	/*if (this.value == "KM" || this.value == "KK" || this.value == "BM" || this.value == "BK") {
		ambil_no_bukti(this.value);
	}
	else {
		$("#x_no_bukti").val("");
	}*/
});
var ajaxku;
var ajax_jurnal_kode;

function ambil_jurnal_kode(akun_id) {
	ajax_jurnal_kode = buatajax();
	var url="ambiljurnalkode.php";
	url=url+"?q="+akun_id;
	url=url+"&sid="+Math.random();
	ajax_jurnal_kode.onreadystatechange=stateChanged_jurnal_kode;
	ajax_jurnal_kode.open("GET",url,true);
	ajax_jurnal_kode.send(null);
}

function ambil_no_bukti(kode) {
	ajaxku = buatajax();
	var url="ambildata.php";
	url=url+"?q="+kode;
	url=url+"&sid="+Math.random();
	ajaxku.onreadystatechange=stateChanged;
	ajaxku.open("GET",url,true);
	ajaxku.send(null);
}

function ambildata(nip) {
	ajaxku = buatajax();
	var url="ambildata.php";
	url=url+"?q="+nip;
	url=url+"&sid="+Math.random();
	ajaxku.onreadystatechange=stateChanged;
	ajaxku.open("GET",url,true);
	ajaxku.send(null);
}

function buatajax() {
	if (window.XMLHttpRequest) {
		return new XMLHttpRequest();
	}
	if (window.ActiveXObject) {
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	return null;
}

function stateChanged() {
	var data;
	if (ajaxku.readyState==4) {
		data=ajaxku.responseText;
		if(data.length>0) {
			$("#x_no_bukti").val(data);

			//$(this).fields("no_bukti").value(data); // Set value to FieldA
			//document.getElementById("x_no_bukti").value = data

		}
		else {
			$("#x_no_bukti").val("");

			//$(this).fields("no_bukti").value("");
			//document.getElementById("x_no_bukti").value = "";

		}
	}
}

function stateChanged_jurnal_kode() {
	var data;
	if (ajax_jurnal_kode.readyState==4) {
		data=ajax_jurnal_kode.responseText;
		if(data.length>0) {
			jurnal_kode = data;
		}
		else {
			jurnal_kode = "";
		}
	}

	//alert(jurnal_kode);
}

function myfunction(rowindex) {
	var form = this.form;
	var total_detail = 0;
	for (i = 1; i <= rowindex; i++) {
		var nilai = form.elements["x"+i+"_nilai"];
		total_detail += parseInt(nilai.value);
	}

	//alert(total_detail);
}
</script>
<?php include_once "footer.php" ?>
<?php
$tb_jurnal_add->Page_Terminate();
?>

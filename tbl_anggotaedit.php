<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "tbl_anggotainfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$tbl_anggota_edit = NULL; // Initialize page object first

class ctbl_anggota_edit extends ctbl_anggota {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}";

	// Table name
	var $TableName = 'tbl_anggota';

	// Page object name
	var $PageObjName = 'tbl_anggota_edit';

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
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (tbl_anggota)
		if (!isset($GLOBALS["tbl_anggota"]) || get_class($GLOBALS["tbl_anggota"]) == "ctbl_anggota") {
			$GLOBALS["tbl_anggota"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_anggota"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_anggota', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("tbl_anggotalist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->no_anggota->SetVisibility();
		$this->nama->SetVisibility();
		$this->tgl_masuk->SetVisibility();
		$this->alamat->SetVisibility();
		$this->kota->SetVisibility();
		$this->no_telp->SetVisibility();
		$this->pekerjaan->SetVisibility();
		$this->jns_pengenal->SetVisibility();
		$this->no_pengenal->SetVisibility();

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
		global $EW_EXPORT, $tbl_anggota;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tbl_anggota);
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
		if (@$_GET["anggota_id"] <> "") {
			$this->anggota_id->setQueryStringValue($_GET["anggota_id"]);
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->anggota_id->CurrentValue == "") {
			$this->Page_Terminate("tbl_anggotalist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("tbl_anggotalist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "tbl_anggotalist.php")
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
		if (!$this->no_anggota->FldIsDetailKey) {
			$this->no_anggota->setFormValue($objForm->GetValue("x_no_anggota"));
		}
		if (!$this->nama->FldIsDetailKey) {
			$this->nama->setFormValue($objForm->GetValue("x_nama"));
		}
		if (!$this->tgl_masuk->FldIsDetailKey) {
			$this->tgl_masuk->setFormValue($objForm->GetValue("x_tgl_masuk"));
			$this->tgl_masuk->CurrentValue = ew_UnFormatDateTime($this->tgl_masuk->CurrentValue, 0);
		}
		if (!$this->alamat->FldIsDetailKey) {
			$this->alamat->setFormValue($objForm->GetValue("x_alamat"));
		}
		if (!$this->kota->FldIsDetailKey) {
			$this->kota->setFormValue($objForm->GetValue("x_kota"));
		}
		if (!$this->no_telp->FldIsDetailKey) {
			$this->no_telp->setFormValue($objForm->GetValue("x_no_telp"));
		}
		if (!$this->pekerjaan->FldIsDetailKey) {
			$this->pekerjaan->setFormValue($objForm->GetValue("x_pekerjaan"));
		}
		if (!$this->jns_pengenal->FldIsDetailKey) {
			$this->jns_pengenal->setFormValue($objForm->GetValue("x_jns_pengenal"));
		}
		if (!$this->no_pengenal->FldIsDetailKey) {
			$this->no_pengenal->setFormValue($objForm->GetValue("x_no_pengenal"));
		}
		if (!$this->anggota_id->FldIsDetailKey)
			$this->anggota_id->setFormValue($objForm->GetValue("x_anggota_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->anggota_id->CurrentValue = $this->anggota_id->FormValue;
		$this->no_anggota->CurrentValue = $this->no_anggota->FormValue;
		$this->nama->CurrentValue = $this->nama->FormValue;
		$this->tgl_masuk->CurrentValue = $this->tgl_masuk->FormValue;
		$this->tgl_masuk->CurrentValue = ew_UnFormatDateTime($this->tgl_masuk->CurrentValue, 0);
		$this->alamat->CurrentValue = $this->alamat->FormValue;
		$this->kota->CurrentValue = $this->kota->FormValue;
		$this->no_telp->CurrentValue = $this->no_telp->FormValue;
		$this->pekerjaan->CurrentValue = $this->pekerjaan->FormValue;
		$this->jns_pengenal->CurrentValue = $this->jns_pengenal->FormValue;
		$this->no_pengenal->CurrentValue = $this->no_pengenal->FormValue;
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
		$this->anggota_id->setDbValue($rs->fields('anggota_id'));
		$this->no_anggota->setDbValue($rs->fields('no_anggota'));
		$this->nama->setDbValue($rs->fields('nama'));
		$this->tgl_masuk->setDbValue($rs->fields('tgl_masuk'));
		$this->alamat->setDbValue($rs->fields('alamat'));
		$this->kota->setDbValue($rs->fields('kota'));
		$this->no_telp->setDbValue($rs->fields('no_telp'));
		$this->pekerjaan->setDbValue($rs->fields('pekerjaan'));
		$this->jns_pengenal->setDbValue($rs->fields('jns_pengenal'));
		$this->no_pengenal->setDbValue($rs->fields('no_pengenal'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->anggota_id->DbValue = $row['anggota_id'];
		$this->no_anggota->DbValue = $row['no_anggota'];
		$this->nama->DbValue = $row['nama'];
		$this->tgl_masuk->DbValue = $row['tgl_masuk'];
		$this->alamat->DbValue = $row['alamat'];
		$this->kota->DbValue = $row['kota'];
		$this->no_telp->DbValue = $row['no_telp'];
		$this->pekerjaan->DbValue = $row['pekerjaan'];
		$this->jns_pengenal->DbValue = $row['jns_pengenal'];
		$this->no_pengenal->DbValue = $row['no_pengenal'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// anggota_id
		// no_anggota
		// nama
		// tgl_masuk
		// alamat
		// kota
		// no_telp
		// pekerjaan
		// jns_pengenal
		// no_pengenal

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// no_anggota
		$this->no_anggota->ViewValue = $this->no_anggota->CurrentValue;
		$this->no_anggota->ViewCustomAttributes = "";

		// nama
		$this->nama->ViewValue = $this->nama->CurrentValue;
		$this->nama->ViewCustomAttributes = "";

		// tgl_masuk
		$this->tgl_masuk->ViewValue = $this->tgl_masuk->CurrentValue;
		$this->tgl_masuk->ViewValue = ew_FormatDateTime($this->tgl_masuk->ViewValue, 0);
		$this->tgl_masuk->ViewCustomAttributes = "";

		// alamat
		$this->alamat->ViewValue = $this->alamat->CurrentValue;
		$this->alamat->ViewCustomAttributes = "";

		// kota
		$this->kota->ViewValue = $this->kota->CurrentValue;
		$this->kota->ViewCustomAttributes = "";

		// no_telp
		$this->no_telp->ViewValue = $this->no_telp->CurrentValue;
		$this->no_telp->ViewCustomAttributes = "";

		// pekerjaan
		$this->pekerjaan->ViewValue = $this->pekerjaan->CurrentValue;
		$this->pekerjaan->ViewCustomAttributes = "";

		// jns_pengenal
		$this->jns_pengenal->ViewValue = $this->jns_pengenal->CurrentValue;
		$this->jns_pengenal->ViewCustomAttributes = "";

		// no_pengenal
		$this->no_pengenal->ViewValue = $this->no_pengenal->CurrentValue;
		$this->no_pengenal->ViewCustomAttributes = "";

			// no_anggota
			$this->no_anggota->LinkCustomAttributes = "";
			$this->no_anggota->HrefValue = "";
			$this->no_anggota->TooltipValue = "";

			// nama
			$this->nama->LinkCustomAttributes = "";
			$this->nama->HrefValue = "";
			$this->nama->TooltipValue = "";

			// tgl_masuk
			$this->tgl_masuk->LinkCustomAttributes = "";
			$this->tgl_masuk->HrefValue = "";
			$this->tgl_masuk->TooltipValue = "";

			// alamat
			$this->alamat->LinkCustomAttributes = "";
			$this->alamat->HrefValue = "";
			$this->alamat->TooltipValue = "";

			// kota
			$this->kota->LinkCustomAttributes = "";
			$this->kota->HrefValue = "";
			$this->kota->TooltipValue = "";

			// no_telp
			$this->no_telp->LinkCustomAttributes = "";
			$this->no_telp->HrefValue = "";
			$this->no_telp->TooltipValue = "";

			// pekerjaan
			$this->pekerjaan->LinkCustomAttributes = "";
			$this->pekerjaan->HrefValue = "";
			$this->pekerjaan->TooltipValue = "";

			// jns_pengenal
			$this->jns_pengenal->LinkCustomAttributes = "";
			$this->jns_pengenal->HrefValue = "";
			$this->jns_pengenal->TooltipValue = "";

			// no_pengenal
			$this->no_pengenal->LinkCustomAttributes = "";
			$this->no_pengenal->HrefValue = "";
			$this->no_pengenal->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// no_anggota
			$this->no_anggota->EditAttrs["class"] = "form-control";
			$this->no_anggota->EditCustomAttributes = "";
			$this->no_anggota->EditValue = ew_HtmlEncode($this->no_anggota->CurrentValue);
			$this->no_anggota->PlaceHolder = ew_RemoveHtml($this->no_anggota->FldCaption());

			// nama
			$this->nama->EditAttrs["class"] = "form-control";
			$this->nama->EditCustomAttributes = "";
			$this->nama->EditValue = ew_HtmlEncode($this->nama->CurrentValue);
			$this->nama->PlaceHolder = ew_RemoveHtml($this->nama->FldCaption());

			// tgl_masuk
			$this->tgl_masuk->EditAttrs["class"] = "form-control";
			$this->tgl_masuk->EditCustomAttributes = "";
			$this->tgl_masuk->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_masuk->CurrentValue, 8));
			$this->tgl_masuk->PlaceHolder = ew_RemoveHtml($this->tgl_masuk->FldCaption());

			// alamat
			$this->alamat->EditAttrs["class"] = "form-control";
			$this->alamat->EditCustomAttributes = "";
			$this->alamat->EditValue = ew_HtmlEncode($this->alamat->CurrentValue);
			$this->alamat->PlaceHolder = ew_RemoveHtml($this->alamat->FldCaption());

			// kota
			$this->kota->EditAttrs["class"] = "form-control";
			$this->kota->EditCustomAttributes = "";
			$this->kota->EditValue = ew_HtmlEncode($this->kota->CurrentValue);
			$this->kota->PlaceHolder = ew_RemoveHtml($this->kota->FldCaption());

			// no_telp
			$this->no_telp->EditAttrs["class"] = "form-control";
			$this->no_telp->EditCustomAttributes = "";
			$this->no_telp->EditValue = ew_HtmlEncode($this->no_telp->CurrentValue);
			$this->no_telp->PlaceHolder = ew_RemoveHtml($this->no_telp->FldCaption());

			// pekerjaan
			$this->pekerjaan->EditAttrs["class"] = "form-control";
			$this->pekerjaan->EditCustomAttributes = "";
			$this->pekerjaan->EditValue = ew_HtmlEncode($this->pekerjaan->CurrentValue);
			$this->pekerjaan->PlaceHolder = ew_RemoveHtml($this->pekerjaan->FldCaption());

			// jns_pengenal
			$this->jns_pengenal->EditAttrs["class"] = "form-control";
			$this->jns_pengenal->EditCustomAttributes = "";
			$this->jns_pengenal->EditValue = ew_HtmlEncode($this->jns_pengenal->CurrentValue);
			$this->jns_pengenal->PlaceHolder = ew_RemoveHtml($this->jns_pengenal->FldCaption());

			// no_pengenal
			$this->no_pengenal->EditAttrs["class"] = "form-control";
			$this->no_pengenal->EditCustomAttributes = "";
			$this->no_pengenal->EditValue = ew_HtmlEncode($this->no_pengenal->CurrentValue);
			$this->no_pengenal->PlaceHolder = ew_RemoveHtml($this->no_pengenal->FldCaption());

			// Edit refer script
			// no_anggota

			$this->no_anggota->LinkCustomAttributes = "";
			$this->no_anggota->HrefValue = "";

			// nama
			$this->nama->LinkCustomAttributes = "";
			$this->nama->HrefValue = "";

			// tgl_masuk
			$this->tgl_masuk->LinkCustomAttributes = "";
			$this->tgl_masuk->HrefValue = "";

			// alamat
			$this->alamat->LinkCustomAttributes = "";
			$this->alamat->HrefValue = "";

			// kota
			$this->kota->LinkCustomAttributes = "";
			$this->kota->HrefValue = "";

			// no_telp
			$this->no_telp->LinkCustomAttributes = "";
			$this->no_telp->HrefValue = "";

			// pekerjaan
			$this->pekerjaan->LinkCustomAttributes = "";
			$this->pekerjaan->HrefValue = "";

			// jns_pengenal
			$this->jns_pengenal->LinkCustomAttributes = "";
			$this->jns_pengenal->HrefValue = "";

			// no_pengenal
			$this->no_pengenal->LinkCustomAttributes = "";
			$this->no_pengenal->HrefValue = "";
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
		if (!ew_CheckDateDef($this->tgl_masuk->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_masuk->FldErrMsg());
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

			// no_anggota
			$this->no_anggota->SetDbValueDef($rsnew, $this->no_anggota->CurrentValue, NULL, $this->no_anggota->ReadOnly);

			// nama
			$this->nama->SetDbValueDef($rsnew, $this->nama->CurrentValue, NULL, $this->nama->ReadOnly);

			// tgl_masuk
			$this->tgl_masuk->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_masuk->CurrentValue, 0), NULL, $this->tgl_masuk->ReadOnly);

			// alamat
			$this->alamat->SetDbValueDef($rsnew, $this->alamat->CurrentValue, NULL, $this->alamat->ReadOnly);

			// kota
			$this->kota->SetDbValueDef($rsnew, $this->kota->CurrentValue, NULL, $this->kota->ReadOnly);

			// no_telp
			$this->no_telp->SetDbValueDef($rsnew, $this->no_telp->CurrentValue, NULL, $this->no_telp->ReadOnly);

			// pekerjaan
			$this->pekerjaan->SetDbValueDef($rsnew, $this->pekerjaan->CurrentValue, NULL, $this->pekerjaan->ReadOnly);

			// jns_pengenal
			$this->jns_pengenal->SetDbValueDef($rsnew, $this->jns_pengenal->CurrentValue, NULL, $this->jns_pengenal->ReadOnly);

			// no_pengenal
			$this->no_pengenal->SetDbValueDef($rsnew, $this->no_pengenal->CurrentValue, NULL, $this->no_pengenal->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tbl_anggotalist.php"), "", $this->TableVar, TRUE);
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
		$table = 'tbl_anggota';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'tbl_anggota';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['anggota_id'];

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
if (!isset($tbl_anggota_edit)) $tbl_anggota_edit = new ctbl_anggota_edit();

// Page init
$tbl_anggota_edit->Page_Init();

// Page main
$tbl_anggota_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_anggota_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ftbl_anggotaedit = new ew_Form("ftbl_anggotaedit", "edit");

// Validate form
ftbl_anggotaedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tgl_masuk");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_anggota->tgl_masuk->FldErrMsg()) ?>");

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
ftbl_anggotaedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_anggotaedit.ValidateRequired = true;
<?php } else { ?>
ftbl_anggotaedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$tbl_anggota_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $tbl_anggota_edit->ShowPageHeader(); ?>
<?php
$tbl_anggota_edit->ShowMessage();
?>
<form name="ftbl_anggotaedit" id="ftbl_anggotaedit" class="<?php echo $tbl_anggota_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tbl_anggota_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tbl_anggota_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tbl_anggota">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($tbl_anggota_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($tbl_anggota->no_anggota->Visible) { // no_anggota ?>
	<div id="r_no_anggota" class="form-group">
		<label id="elh_tbl_anggota_no_anggota" for="x_no_anggota" class="col-sm-2 control-label ewLabel"><?php echo $tbl_anggota->no_anggota->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tbl_anggota->no_anggota->CellAttributes() ?>>
<span id="el_tbl_anggota_no_anggota">
<input type="text" data-table="tbl_anggota" data-field="x_no_anggota" name="x_no_anggota" id="x_no_anggota" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($tbl_anggota->no_anggota->getPlaceHolder()) ?>" value="<?php echo $tbl_anggota->no_anggota->EditValue ?>"<?php echo $tbl_anggota->no_anggota->EditAttributes() ?>>
</span>
<?php echo $tbl_anggota->no_anggota->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tbl_anggota->nama->Visible) { // nama ?>
	<div id="r_nama" class="form-group">
		<label id="elh_tbl_anggota_nama" for="x_nama" class="col-sm-2 control-label ewLabel"><?php echo $tbl_anggota->nama->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tbl_anggota->nama->CellAttributes() ?>>
<span id="el_tbl_anggota_nama">
<input type="text" data-table="tbl_anggota" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($tbl_anggota->nama->getPlaceHolder()) ?>" value="<?php echo $tbl_anggota->nama->EditValue ?>"<?php echo $tbl_anggota->nama->EditAttributes() ?>>
</span>
<?php echo $tbl_anggota->nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tbl_anggota->tgl_masuk->Visible) { // tgl_masuk ?>
	<div id="r_tgl_masuk" class="form-group">
		<label id="elh_tbl_anggota_tgl_masuk" for="x_tgl_masuk" class="col-sm-2 control-label ewLabel"><?php echo $tbl_anggota->tgl_masuk->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tbl_anggota->tgl_masuk->CellAttributes() ?>>
<span id="el_tbl_anggota_tgl_masuk">
<input type="text" data-table="tbl_anggota" data-field="x_tgl_masuk" name="x_tgl_masuk" id="x_tgl_masuk" placeholder="<?php echo ew_HtmlEncode($tbl_anggota->tgl_masuk->getPlaceHolder()) ?>" value="<?php echo $tbl_anggota->tgl_masuk->EditValue ?>"<?php echo $tbl_anggota->tgl_masuk->EditAttributes() ?>>
</span>
<?php echo $tbl_anggota->tgl_masuk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tbl_anggota->alamat->Visible) { // alamat ?>
	<div id="r_alamat" class="form-group">
		<label id="elh_tbl_anggota_alamat" for="x_alamat" class="col-sm-2 control-label ewLabel"><?php echo $tbl_anggota->alamat->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tbl_anggota->alamat->CellAttributes() ?>>
<span id="el_tbl_anggota_alamat">
<input type="text" data-table="tbl_anggota" data-field="x_alamat" name="x_alamat" id="x_alamat" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tbl_anggota->alamat->getPlaceHolder()) ?>" value="<?php echo $tbl_anggota->alamat->EditValue ?>"<?php echo $tbl_anggota->alamat->EditAttributes() ?>>
</span>
<?php echo $tbl_anggota->alamat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tbl_anggota->kota->Visible) { // kota ?>
	<div id="r_kota" class="form-group">
		<label id="elh_tbl_anggota_kota" for="x_kota" class="col-sm-2 control-label ewLabel"><?php echo $tbl_anggota->kota->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tbl_anggota->kota->CellAttributes() ?>>
<span id="el_tbl_anggota_kota">
<input type="text" data-table="tbl_anggota" data-field="x_kota" name="x_kota" id="x_kota" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($tbl_anggota->kota->getPlaceHolder()) ?>" value="<?php echo $tbl_anggota->kota->EditValue ?>"<?php echo $tbl_anggota->kota->EditAttributes() ?>>
</span>
<?php echo $tbl_anggota->kota->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tbl_anggota->no_telp->Visible) { // no_telp ?>
	<div id="r_no_telp" class="form-group">
		<label id="elh_tbl_anggota_no_telp" for="x_no_telp" class="col-sm-2 control-label ewLabel"><?php echo $tbl_anggota->no_telp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tbl_anggota->no_telp->CellAttributes() ?>>
<span id="el_tbl_anggota_no_telp">
<input type="text" data-table="tbl_anggota" data-field="x_no_telp" name="x_no_telp" id="x_no_telp" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($tbl_anggota->no_telp->getPlaceHolder()) ?>" value="<?php echo $tbl_anggota->no_telp->EditValue ?>"<?php echo $tbl_anggota->no_telp->EditAttributes() ?>>
</span>
<?php echo $tbl_anggota->no_telp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tbl_anggota->pekerjaan->Visible) { // pekerjaan ?>
	<div id="r_pekerjaan" class="form-group">
		<label id="elh_tbl_anggota_pekerjaan" for="x_pekerjaan" class="col-sm-2 control-label ewLabel"><?php echo $tbl_anggota->pekerjaan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tbl_anggota->pekerjaan->CellAttributes() ?>>
<span id="el_tbl_anggota_pekerjaan">
<input type="text" data-table="tbl_anggota" data-field="x_pekerjaan" name="x_pekerjaan" id="x_pekerjaan" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($tbl_anggota->pekerjaan->getPlaceHolder()) ?>" value="<?php echo $tbl_anggota->pekerjaan->EditValue ?>"<?php echo $tbl_anggota->pekerjaan->EditAttributes() ?>>
</span>
<?php echo $tbl_anggota->pekerjaan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tbl_anggota->jns_pengenal->Visible) { // jns_pengenal ?>
	<div id="r_jns_pengenal" class="form-group">
		<label id="elh_tbl_anggota_jns_pengenal" for="x_jns_pengenal" class="col-sm-2 control-label ewLabel"><?php echo $tbl_anggota->jns_pengenal->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tbl_anggota->jns_pengenal->CellAttributes() ?>>
<span id="el_tbl_anggota_jns_pengenal">
<input type="text" data-table="tbl_anggota" data-field="x_jns_pengenal" name="x_jns_pengenal" id="x_jns_pengenal" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($tbl_anggota->jns_pengenal->getPlaceHolder()) ?>" value="<?php echo $tbl_anggota->jns_pengenal->EditValue ?>"<?php echo $tbl_anggota->jns_pengenal->EditAttributes() ?>>
</span>
<?php echo $tbl_anggota->jns_pengenal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tbl_anggota->no_pengenal->Visible) { // no_pengenal ?>
	<div id="r_no_pengenal" class="form-group">
		<label id="elh_tbl_anggota_no_pengenal" for="x_no_pengenal" class="col-sm-2 control-label ewLabel"><?php echo $tbl_anggota->no_pengenal->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tbl_anggota->no_pengenal->CellAttributes() ?>>
<span id="el_tbl_anggota_no_pengenal">
<input type="text" data-table="tbl_anggota" data-field="x_no_pengenal" name="x_no_pengenal" id="x_no_pengenal" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tbl_anggota->no_pengenal->getPlaceHolder()) ?>" value="<?php echo $tbl_anggota->no_pengenal->EditValue ?>"<?php echo $tbl_anggota->no_pengenal->EditAttributes() ?>>
</span>
<?php echo $tbl_anggota->no_pengenal->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="tbl_anggota" data-field="x_anggota_id" name="x_anggota_id" id="x_anggota_id" value="<?php echo ew_HtmlEncode($tbl_anggota->anggota_id->CurrentValue) ?>">
<?php if (!$tbl_anggota_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tbl_anggota_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ftbl_anggotaedit.Init();
</script>
<?php
$tbl_anggota_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_anggota_edit->Page_Terminate();
?>

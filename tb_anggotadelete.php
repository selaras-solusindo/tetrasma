<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "tb_anggotainfo.php" ?>
<?php include_once "tb_userinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$tb_anggota_delete = NULL; // Initialize page object first

class ctb_anggota_delete extends ctb_anggota {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}";

	// Table name
	var $TableName = 'tb_anggota';

	// Page object name
	var $PageObjName = 'tb_anggota_delete';

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
	var $AuditTrailOnEdit = FALSE;
	var $AuditTrailOnDelete = TRUE;
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

		// Table object (tb_anggota)
		if (!isset($GLOBALS["tb_anggota"]) || get_class($GLOBALS["tb_anggota"]) == "ctb_anggota") {
			$GLOBALS["tb_anggota"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_anggota"];
		}

		// Table object (tb_user)
		if (!isset($GLOBALS['tb_user'])) $GLOBALS['tb_user'] = new ctb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tb_anggota', TRUE);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("tb_anggotalist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
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
		global $EW_EXPORT, $tb_anggota;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tb_anggota);
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
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("tb_anggotalist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in tb_anggota class, tb_anggotainfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("tb_anggotalist.php"); // Return to list
			}
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
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();
		if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteBegin")); // Batch delete begin

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['anggota_id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
			if ($DeleteRows) {
				foreach ($rsold as $row)
					$this->WriteAuditTrailOnDelete($row);
			}
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
			$conn->RollbackTrans(); // Rollback changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteRollback")); // Batch delete rollback
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_anggotalist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
		$table = 'tb_anggota';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 'tb_anggota';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['anggota_id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$curUser = CurrentUserName();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$oldvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$oldvalue = $rs[$fldname];
					else
						$oldvalue = "[MEMO]"; // Memo field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$oldvalue = "[XML]"; // XML field
				} else {
					$oldvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $curUser, "D", $table, $fldname, $key, $oldvalue, "");
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tb_anggota_delete)) $tb_anggota_delete = new ctb_anggota_delete();

// Page init
$tb_anggota_delete->Page_Init();

// Page main
$tb_anggota_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_anggota_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ftb_anggotadelete = new ew_Form("ftb_anggotadelete", "delete");

// Form_CustomValidate event
ftb_anggotadelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftb_anggotadelete.ValidateRequired = true;
<?php } else { ?>
ftb_anggotadelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $tb_anggota_delete->ShowPageHeader(); ?>
<?php
$tb_anggota_delete->ShowMessage();
?>
<form name="ftb_anggotadelete" id="ftb_anggotadelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_anggota_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_anggota_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_anggota">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($tb_anggota_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $tb_anggota->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($tb_anggota->no_anggota->Visible) { // no_anggota ?>
		<th><span id="elh_tb_anggota_no_anggota" class="tb_anggota_no_anggota"><?php echo $tb_anggota->no_anggota->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_anggota->nama->Visible) { // nama ?>
		<th><span id="elh_tb_anggota_nama" class="tb_anggota_nama"><?php echo $tb_anggota->nama->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_anggota->tgl_masuk->Visible) { // tgl_masuk ?>
		<th><span id="elh_tb_anggota_tgl_masuk" class="tb_anggota_tgl_masuk"><?php echo $tb_anggota->tgl_masuk->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_anggota->alamat->Visible) { // alamat ?>
		<th><span id="elh_tb_anggota_alamat" class="tb_anggota_alamat"><?php echo $tb_anggota->alamat->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_anggota->kota->Visible) { // kota ?>
		<th><span id="elh_tb_anggota_kota" class="tb_anggota_kota"><?php echo $tb_anggota->kota->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_anggota->no_telp->Visible) { // no_telp ?>
		<th><span id="elh_tb_anggota_no_telp" class="tb_anggota_no_telp"><?php echo $tb_anggota->no_telp->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_anggota->pekerjaan->Visible) { // pekerjaan ?>
		<th><span id="elh_tb_anggota_pekerjaan" class="tb_anggota_pekerjaan"><?php echo $tb_anggota->pekerjaan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_anggota->jns_pengenal->Visible) { // jns_pengenal ?>
		<th><span id="elh_tb_anggota_jns_pengenal" class="tb_anggota_jns_pengenal"><?php echo $tb_anggota->jns_pengenal->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_anggota->no_pengenal->Visible) { // no_pengenal ?>
		<th><span id="elh_tb_anggota_no_pengenal" class="tb_anggota_no_pengenal"><?php echo $tb_anggota->no_pengenal->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$tb_anggota_delete->RecCnt = 0;
$i = 0;
while (!$tb_anggota_delete->Recordset->EOF) {
	$tb_anggota_delete->RecCnt++;
	$tb_anggota_delete->RowCnt++;

	// Set row properties
	$tb_anggota->ResetAttrs();
	$tb_anggota->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$tb_anggota_delete->LoadRowValues($tb_anggota_delete->Recordset);

	// Render row
	$tb_anggota_delete->RenderRow();
?>
	<tr<?php echo $tb_anggota->RowAttributes() ?>>
<?php if ($tb_anggota->no_anggota->Visible) { // no_anggota ?>
		<td<?php echo $tb_anggota->no_anggota->CellAttributes() ?>>
<span id="el<?php echo $tb_anggota_delete->RowCnt ?>_tb_anggota_no_anggota" class="tb_anggota_no_anggota">
<span<?php echo $tb_anggota->no_anggota->ViewAttributes() ?>>
<?php echo $tb_anggota->no_anggota->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_anggota->nama->Visible) { // nama ?>
		<td<?php echo $tb_anggota->nama->CellAttributes() ?>>
<span id="el<?php echo $tb_anggota_delete->RowCnt ?>_tb_anggota_nama" class="tb_anggota_nama">
<span<?php echo $tb_anggota->nama->ViewAttributes() ?>>
<?php echo $tb_anggota->nama->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_anggota->tgl_masuk->Visible) { // tgl_masuk ?>
		<td<?php echo $tb_anggota->tgl_masuk->CellAttributes() ?>>
<span id="el<?php echo $tb_anggota_delete->RowCnt ?>_tb_anggota_tgl_masuk" class="tb_anggota_tgl_masuk">
<span<?php echo $tb_anggota->tgl_masuk->ViewAttributes() ?>>
<?php echo $tb_anggota->tgl_masuk->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_anggota->alamat->Visible) { // alamat ?>
		<td<?php echo $tb_anggota->alamat->CellAttributes() ?>>
<span id="el<?php echo $tb_anggota_delete->RowCnt ?>_tb_anggota_alamat" class="tb_anggota_alamat">
<span<?php echo $tb_anggota->alamat->ViewAttributes() ?>>
<?php echo $tb_anggota->alamat->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_anggota->kota->Visible) { // kota ?>
		<td<?php echo $tb_anggota->kota->CellAttributes() ?>>
<span id="el<?php echo $tb_anggota_delete->RowCnt ?>_tb_anggota_kota" class="tb_anggota_kota">
<span<?php echo $tb_anggota->kota->ViewAttributes() ?>>
<?php echo $tb_anggota->kota->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_anggota->no_telp->Visible) { // no_telp ?>
		<td<?php echo $tb_anggota->no_telp->CellAttributes() ?>>
<span id="el<?php echo $tb_anggota_delete->RowCnt ?>_tb_anggota_no_telp" class="tb_anggota_no_telp">
<span<?php echo $tb_anggota->no_telp->ViewAttributes() ?>>
<?php echo $tb_anggota->no_telp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_anggota->pekerjaan->Visible) { // pekerjaan ?>
		<td<?php echo $tb_anggota->pekerjaan->CellAttributes() ?>>
<span id="el<?php echo $tb_anggota_delete->RowCnt ?>_tb_anggota_pekerjaan" class="tb_anggota_pekerjaan">
<span<?php echo $tb_anggota->pekerjaan->ViewAttributes() ?>>
<?php echo $tb_anggota->pekerjaan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_anggota->jns_pengenal->Visible) { // jns_pengenal ?>
		<td<?php echo $tb_anggota->jns_pengenal->CellAttributes() ?>>
<span id="el<?php echo $tb_anggota_delete->RowCnt ?>_tb_anggota_jns_pengenal" class="tb_anggota_jns_pengenal">
<span<?php echo $tb_anggota->jns_pengenal->ViewAttributes() ?>>
<?php echo $tb_anggota->jns_pengenal->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_anggota->no_pengenal->Visible) { // no_pengenal ?>
		<td<?php echo $tb_anggota->no_pengenal->CellAttributes() ?>>
<span id="el<?php echo $tb_anggota_delete->RowCnt ?>_tb_anggota_no_pengenal" class="tb_anggota_no_pengenal">
<span<?php echo $tb_anggota->no_pengenal->ViewAttributes() ?>>
<?php echo $tb_anggota->no_pengenal->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$tb_anggota_delete->Recordset->MoveNext();
}
$tb_anggota_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tb_anggota_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ftb_anggotadelete.Init();
</script>
<?php
$tb_anggota_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tb_anggota_delete->Page_Terminate();
?>

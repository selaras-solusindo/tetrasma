<?php include_once "tb_userinfo.php" ?>
<?php

// Create page object
if (!isset($tb_detailm_grid)) $tb_detailm_grid = new ctb_detailm_grid();

// Page init
$tb_detailm_grid->Page_Init();

// Page main
$tb_detailm_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_detailm_grid->Page_Render();
?>
<?php if ($tb_detailm->Export == "") { ?>
<script type="text/javascript">

// Form object
var ftb_detailmgrid = new ew_Form("ftb_detailmgrid", "grid");
ftb_detailmgrid.FormKeyCountName = '<?php echo $tb_detailm_grid->FormKeyCountName ?>';

// Validate form
ftb_detailmgrid.Validate = function() {
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
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
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
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ftb_detailmgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "akunm_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nilaim_debet", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nilaim_kredit", false)) return false;
	return true;
}

// Form_CustomValidate event
ftb_detailmgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftb_detailmgrid.ValidateRequired = true;
<?php } else { ?>
ftb_detailmgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftb_detailmgrid.Lists["x_akunm_id"] = {"LinkField":"x_level4_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_nama_akun","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"view_akun_jurnal"};

// Form object for search
</script>
<?php } ?>
<?php
if ($tb_detailm->CurrentAction == "gridadd") {
	if ($tb_detailm->CurrentMode == "copy") {
		$bSelectLimit = $tb_detailm_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$tb_detailm_grid->TotalRecs = $tb_detailm->SelectRecordCount();
			$tb_detailm_grid->Recordset = $tb_detailm_grid->LoadRecordset($tb_detailm_grid->StartRec-1, $tb_detailm_grid->DisplayRecs);
		} else {
			if ($tb_detailm_grid->Recordset = $tb_detailm_grid->LoadRecordset())
				$tb_detailm_grid->TotalRecs = $tb_detailm_grid->Recordset->RecordCount();
		}
		$tb_detailm_grid->StartRec = 1;
		$tb_detailm_grid->DisplayRecs = $tb_detailm_grid->TotalRecs;
	} else {
		$tb_detailm->CurrentFilter = "0=1";
		$tb_detailm_grid->StartRec = 1;
		$tb_detailm_grid->DisplayRecs = $tb_detailm->GridAddRowCount;
	}
	$tb_detailm_grid->TotalRecs = $tb_detailm_grid->DisplayRecs;
	$tb_detailm_grid->StopRec = $tb_detailm_grid->DisplayRecs;
} else {
	$bSelectLimit = $tb_detailm_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($tb_detailm_grid->TotalRecs <= 0)
			$tb_detailm_grid->TotalRecs = $tb_detailm->SelectRecordCount();
	} else {
		if (!$tb_detailm_grid->Recordset && ($tb_detailm_grid->Recordset = $tb_detailm_grid->LoadRecordset()))
			$tb_detailm_grid->TotalRecs = $tb_detailm_grid->Recordset->RecordCount();
	}
	$tb_detailm_grid->StartRec = 1;
	$tb_detailm_grid->DisplayRecs = $tb_detailm_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$tb_detailm_grid->Recordset = $tb_detailm_grid->LoadRecordset($tb_detailm_grid->StartRec-1, $tb_detailm_grid->DisplayRecs);

	// Set no record found message
	if ($tb_detailm->CurrentAction == "" && $tb_detailm_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$tb_detailm_grid->setWarningMessage(ew_DeniedMsg());
		if ($tb_detailm_grid->SearchWhere == "0=101")
			$tb_detailm_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$tb_detailm_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$tb_detailm_grid->RenderOtherOptions();
?>
<?php $tb_detailm_grid->ShowPageHeader(); ?>
<?php
$tb_detailm_grid->ShowMessage();
?>
<?php if ($tb_detailm_grid->TotalRecs > 0 || $tb_detailm->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid tb_detailm">
<div id="ftb_detailmgrid" class="ewForm form-inline">
<div id="gmp_tb_detailm" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_tb_detailmgrid" class="table ewTable">
<?php echo $tb_detailm->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$tb_detailm_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$tb_detailm_grid->RenderListOptions();

// Render list options (header, left)
$tb_detailm_grid->ListOptions->Render("header", "left");
?>
<?php if ($tb_detailm->akunm_id->Visible) { // akunm_id ?>
	<?php if ($tb_detailm->SortUrl($tb_detailm->akunm_id) == "") { ?>
		<th data-name="akunm_id"><div id="elh_tb_detailm_akunm_id" class="tb_detailm_akunm_id"><div class="ewTableHeaderCaption"><?php echo $tb_detailm->akunm_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="akunm_id"><div><div id="elh_tb_detailm_akunm_id" class="tb_detailm_akunm_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_detailm->akunm_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_detailm->akunm_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_detailm->akunm_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tb_detailm->nilaim_debet->Visible) { // nilaim_debet ?>
	<?php if ($tb_detailm->SortUrl($tb_detailm->nilaim_debet) == "") { ?>
		<th data-name="nilaim_debet"><div id="elh_tb_detailm_nilaim_debet" class="tb_detailm_nilaim_debet"><div class="ewTableHeaderCaption"><?php echo $tb_detailm->nilaim_debet->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nilaim_debet"><div><div id="elh_tb_detailm_nilaim_debet" class="tb_detailm_nilaim_debet">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_detailm->nilaim_debet->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_detailm->nilaim_debet->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_detailm->nilaim_debet->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tb_detailm->nilaim_kredit->Visible) { // nilaim_kredit ?>
	<?php if ($tb_detailm->SortUrl($tb_detailm->nilaim_kredit) == "") { ?>
		<th data-name="nilaim_kredit"><div id="elh_tb_detailm_nilaim_kredit" class="tb_detailm_nilaim_kredit"><div class="ewTableHeaderCaption"><?php echo $tb_detailm->nilaim_kredit->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nilaim_kredit"><div><div id="elh_tb_detailm_nilaim_kredit" class="tb_detailm_nilaim_kredit">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_detailm->nilaim_kredit->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_detailm->nilaim_kredit->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_detailm->nilaim_kredit->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$tb_detailm_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$tb_detailm_grid->StartRec = 1;
$tb_detailm_grid->StopRec = $tb_detailm_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($tb_detailm_grid->FormKeyCountName) && ($tb_detailm->CurrentAction == "gridadd" || $tb_detailm->CurrentAction == "gridedit" || $tb_detailm->CurrentAction == "F")) {
		$tb_detailm_grid->KeyCount = $objForm->GetValue($tb_detailm_grid->FormKeyCountName);
		$tb_detailm_grid->StopRec = $tb_detailm_grid->StartRec + $tb_detailm_grid->KeyCount - 1;
	}
}
$tb_detailm_grid->RecCnt = $tb_detailm_grid->StartRec - 1;
if ($tb_detailm_grid->Recordset && !$tb_detailm_grid->Recordset->EOF) {
	$tb_detailm_grid->Recordset->MoveFirst();
	$bSelectLimit = $tb_detailm_grid->UseSelectLimit;
	if (!$bSelectLimit && $tb_detailm_grid->StartRec > 1)
		$tb_detailm_grid->Recordset->Move($tb_detailm_grid->StartRec - 1);
} elseif (!$tb_detailm->AllowAddDeleteRow && $tb_detailm_grid->StopRec == 0) {
	$tb_detailm_grid->StopRec = $tb_detailm->GridAddRowCount;
}

// Initialize aggregate
$tb_detailm->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tb_detailm->ResetAttrs();
$tb_detailm_grid->RenderRow();
if ($tb_detailm->CurrentAction == "gridadd")
	$tb_detailm_grid->RowIndex = 0;
if ($tb_detailm->CurrentAction == "gridedit")
	$tb_detailm_grid->RowIndex = 0;
while ($tb_detailm_grid->RecCnt < $tb_detailm_grid->StopRec) {
	$tb_detailm_grid->RecCnt++;
	if (intval($tb_detailm_grid->RecCnt) >= intval($tb_detailm_grid->StartRec)) {
		$tb_detailm_grid->RowCnt++;
		if ($tb_detailm->CurrentAction == "gridadd" || $tb_detailm->CurrentAction == "gridedit" || $tb_detailm->CurrentAction == "F") {
			$tb_detailm_grid->RowIndex++;
			$objForm->Index = $tb_detailm_grid->RowIndex;
			if ($objForm->HasValue($tb_detailm_grid->FormActionName))
				$tb_detailm_grid->RowAction = strval($objForm->GetValue($tb_detailm_grid->FormActionName));
			elseif ($tb_detailm->CurrentAction == "gridadd")
				$tb_detailm_grid->RowAction = "insert";
			else
				$tb_detailm_grid->RowAction = "";
		}

		// Set up key count
		$tb_detailm_grid->KeyCount = $tb_detailm_grid->RowIndex;

		// Init row class and style
		$tb_detailm->ResetAttrs();
		$tb_detailm->CssClass = "";
		if ($tb_detailm->CurrentAction == "gridadd") {
			if ($tb_detailm->CurrentMode == "copy") {
				$tb_detailm_grid->LoadRowValues($tb_detailm_grid->Recordset); // Load row values
				$tb_detailm_grid->SetRecordKey($tb_detailm_grid->RowOldKey, $tb_detailm_grid->Recordset); // Set old record key
			} else {
				$tb_detailm_grid->LoadDefaultValues(); // Load default values
				$tb_detailm_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$tb_detailm_grid->LoadRowValues($tb_detailm_grid->Recordset); // Load row values
		}
		$tb_detailm->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($tb_detailm->CurrentAction == "gridadd") // Grid add
			$tb_detailm->RowType = EW_ROWTYPE_ADD; // Render add
		if ($tb_detailm->CurrentAction == "gridadd" && $tb_detailm->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$tb_detailm_grid->RestoreCurrentRowFormValues($tb_detailm_grid->RowIndex); // Restore form values
		if ($tb_detailm->CurrentAction == "gridedit") { // Grid edit
			if ($tb_detailm->EventCancelled) {
				$tb_detailm_grid->RestoreCurrentRowFormValues($tb_detailm_grid->RowIndex); // Restore form values
			}
			if ($tb_detailm_grid->RowAction == "insert")
				$tb_detailm->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$tb_detailm->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($tb_detailm->CurrentAction == "gridedit" && ($tb_detailm->RowType == EW_ROWTYPE_EDIT || $tb_detailm->RowType == EW_ROWTYPE_ADD) && $tb_detailm->EventCancelled) // Update failed
			$tb_detailm_grid->RestoreCurrentRowFormValues($tb_detailm_grid->RowIndex); // Restore form values
		if ($tb_detailm->RowType == EW_ROWTYPE_EDIT) // Edit row
			$tb_detailm_grid->EditRowCnt++;
		if ($tb_detailm->CurrentAction == "F") // Confirm row
			$tb_detailm_grid->RestoreCurrentRowFormValues($tb_detailm_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$tb_detailm->RowAttrs = array_merge($tb_detailm->RowAttrs, array('data-rowindex'=>$tb_detailm_grid->RowCnt, 'id'=>'r' . $tb_detailm_grid->RowCnt . '_tb_detailm', 'data-rowtype'=>$tb_detailm->RowType));

		// Render row
		$tb_detailm_grid->RenderRow();

		// Render list options
		$tb_detailm_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($tb_detailm_grid->RowAction <> "delete" && $tb_detailm_grid->RowAction <> "insertdelete" && !($tb_detailm_grid->RowAction == "insert" && $tb_detailm->CurrentAction == "F" && $tb_detailm_grid->EmptyRow())) {
?>
	<tr<?php echo $tb_detailm->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tb_detailm_grid->ListOptions->Render("body", "left", $tb_detailm_grid->RowCnt);
?>
	<?php if ($tb_detailm->akunm_id->Visible) { // akunm_id ?>
		<td data-name="akunm_id"<?php echo $tb_detailm->akunm_id->CellAttributes() ?>>
<?php if ($tb_detailm->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_detailm_grid->RowCnt ?>_tb_detailm_akunm_id" class="form-group tb_detailm_akunm_id">
<?php
$wrkonchange = trim(" " . @$tb_detailm->akunm_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_detailm->akunm_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" style="white-space: nowrap; z-index: <?php echo (9000 - $tb_detailm_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" id="sv_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo $tb_detailm->akunm_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detailm->akunm_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_detailm->akunm_id->getPlaceHolder()) ?>"<?php echo $tb_detailm->akunm_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_detailm" data-field="x_akunm_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_detailm->akunm_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" id="x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($tb_detailm->akunm_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" id="q_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo $tb_detailm->akunm_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ftb_detailmgrid.CreateAutoSuggest({"id":"x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_detailm->akunm_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" id="s_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo $tb_detailm->akunm_id->LookupFilterQuery(false) ?>">
</span>
<input type="hidden" data-table="tb_detailm" data-field="x_akunm_id" name="o<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" id="o<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($tb_detailm->akunm_id->OldValue) ?>">
<?php } ?>
<?php if ($tb_detailm->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_detailm_grid->RowCnt ?>_tb_detailm_akunm_id" class="form-group tb_detailm_akunm_id">
<?php
$wrkonchange = trim(" " . @$tb_detailm->akunm_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_detailm->akunm_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" style="white-space: nowrap; z-index: <?php echo (9000 - $tb_detailm_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" id="sv_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo $tb_detailm->akunm_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detailm->akunm_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_detailm->akunm_id->getPlaceHolder()) ?>"<?php echo $tb_detailm->akunm_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_detailm" data-field="x_akunm_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_detailm->akunm_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" id="x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($tb_detailm->akunm_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" id="q_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo $tb_detailm->akunm_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ftb_detailmgrid.CreateAutoSuggest({"id":"x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_detailm->akunm_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" id="s_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo $tb_detailm->akunm_id->LookupFilterQuery(false) ?>">
</span>
<?php } ?>
<?php if ($tb_detailm->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_detailm_grid->RowCnt ?>_tb_detailm_akunm_id" class="tb_detailm_akunm_id">
<span<?php echo $tb_detailm->akunm_id->ViewAttributes() ?>>
<?php echo $tb_detailm->akunm_id->ListViewValue() ?></span>
</span>
<?php if ($tb_detailm->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tb_detailm" data-field="x_akunm_id" name="x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" id="x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($tb_detailm->akunm_id->FormValue) ?>">
<input type="hidden" data-table="tb_detailm" data-field="x_akunm_id" name="o<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" id="o<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($tb_detailm->akunm_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tb_detailm" data-field="x_akunm_id" name="ftb_detailmgrid$x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" id="ftb_detailmgrid$x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($tb_detailm->akunm_id->FormValue) ?>">
<input type="hidden" data-table="tb_detailm" data-field="x_akunm_id" name="ftb_detailmgrid$o<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" id="ftb_detailmgrid$o<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($tb_detailm->akunm_id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $tb_detailm_grid->PageObjName . "_row_" . $tb_detailm_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($tb_detailm->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="tb_detailm" data-field="x_detailm_id" name="x<?php echo $tb_detailm_grid->RowIndex ?>_detailm_id" id="x<?php echo $tb_detailm_grid->RowIndex ?>_detailm_id" value="<?php echo ew_HtmlEncode($tb_detailm->detailm_id->CurrentValue) ?>">
<input type="hidden" data-table="tb_detailm" data-field="x_detailm_id" name="o<?php echo $tb_detailm_grid->RowIndex ?>_detailm_id" id="o<?php echo $tb_detailm_grid->RowIndex ?>_detailm_id" value="<?php echo ew_HtmlEncode($tb_detailm->detailm_id->OldValue) ?>">
<?php } ?>
<?php if ($tb_detailm->RowType == EW_ROWTYPE_EDIT || $tb_detailm->CurrentMode == "edit") { ?>
<input type="hidden" data-table="tb_detailm" data-field="x_detailm_id" name="x<?php echo $tb_detailm_grid->RowIndex ?>_detailm_id" id="x<?php echo $tb_detailm_grid->RowIndex ?>_detailm_id" value="<?php echo ew_HtmlEncode($tb_detailm->detailm_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($tb_detailm->nilaim_debet->Visible) { // nilaim_debet ?>
		<td data-name="nilaim_debet"<?php echo $tb_detailm->nilaim_debet->CellAttributes() ?>>
<?php if ($tb_detailm->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_detailm_grid->RowCnt ?>_tb_detailm_nilaim_debet" class="form-group tb_detailm_nilaim_debet">
<input type="text" data-table="tb_detailm" data-field="x_nilaim_debet" name="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" id="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detailm->nilaim_debet->getPlaceHolder()) ?>" value="<?php echo $tb_detailm->nilaim_debet->EditValue ?>"<?php echo $tb_detailm->nilaim_debet->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_detailm" data-field="x_nilaim_debet" name="o<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" id="o<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" value="<?php echo ew_HtmlEncode($tb_detailm->nilaim_debet->OldValue) ?>">
<?php } ?>
<?php if ($tb_detailm->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_detailm_grid->RowCnt ?>_tb_detailm_nilaim_debet" class="form-group tb_detailm_nilaim_debet">
<input type="text" data-table="tb_detailm" data-field="x_nilaim_debet" name="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" id="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detailm->nilaim_debet->getPlaceHolder()) ?>" value="<?php echo $tb_detailm->nilaim_debet->EditValue ?>"<?php echo $tb_detailm->nilaim_debet->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tb_detailm->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_detailm_grid->RowCnt ?>_tb_detailm_nilaim_debet" class="tb_detailm_nilaim_debet">
<span<?php echo $tb_detailm->nilaim_debet->ViewAttributes() ?>>
<?php echo $tb_detailm->nilaim_debet->ListViewValue() ?></span>
</span>
<?php if ($tb_detailm->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tb_detailm" data-field="x_nilaim_debet" name="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" id="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" value="<?php echo ew_HtmlEncode($tb_detailm->nilaim_debet->FormValue) ?>">
<input type="hidden" data-table="tb_detailm" data-field="x_nilaim_debet" name="o<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" id="o<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" value="<?php echo ew_HtmlEncode($tb_detailm->nilaim_debet->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tb_detailm" data-field="x_nilaim_debet" name="ftb_detailmgrid$x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" id="ftb_detailmgrid$x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" value="<?php echo ew_HtmlEncode($tb_detailm->nilaim_debet->FormValue) ?>">
<input type="hidden" data-table="tb_detailm" data-field="x_nilaim_debet" name="ftb_detailmgrid$o<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" id="ftb_detailmgrid$o<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" value="<?php echo ew_HtmlEncode($tb_detailm->nilaim_debet->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tb_detailm->nilaim_kredit->Visible) { // nilaim_kredit ?>
		<td data-name="nilaim_kredit"<?php echo $tb_detailm->nilaim_kredit->CellAttributes() ?>>
<?php if ($tb_detailm->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_detailm_grid->RowCnt ?>_tb_detailm_nilaim_kredit" class="form-group tb_detailm_nilaim_kredit">
<input type="text" data-table="tb_detailm" data-field="x_nilaim_kredit" name="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" id="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detailm->nilaim_kredit->getPlaceHolder()) ?>" value="<?php echo $tb_detailm->nilaim_kredit->EditValue ?>"<?php echo $tb_detailm->nilaim_kredit->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_detailm" data-field="x_nilaim_kredit" name="o<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" id="o<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" value="<?php echo ew_HtmlEncode($tb_detailm->nilaim_kredit->OldValue) ?>">
<?php } ?>
<?php if ($tb_detailm->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_detailm_grid->RowCnt ?>_tb_detailm_nilaim_kredit" class="form-group tb_detailm_nilaim_kredit">
<input type="text" data-table="tb_detailm" data-field="x_nilaim_kredit" name="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" id="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detailm->nilaim_kredit->getPlaceHolder()) ?>" value="<?php echo $tb_detailm->nilaim_kredit->EditValue ?>"<?php echo $tb_detailm->nilaim_kredit->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tb_detailm->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_detailm_grid->RowCnt ?>_tb_detailm_nilaim_kredit" class="tb_detailm_nilaim_kredit">
<span<?php echo $tb_detailm->nilaim_kredit->ViewAttributes() ?>>
<?php echo $tb_detailm->nilaim_kredit->ListViewValue() ?></span>
</span>
<?php if ($tb_detailm->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tb_detailm" data-field="x_nilaim_kredit" name="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" id="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" value="<?php echo ew_HtmlEncode($tb_detailm->nilaim_kredit->FormValue) ?>">
<input type="hidden" data-table="tb_detailm" data-field="x_nilaim_kredit" name="o<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" id="o<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" value="<?php echo ew_HtmlEncode($tb_detailm->nilaim_kredit->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tb_detailm" data-field="x_nilaim_kredit" name="ftb_detailmgrid$x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" id="ftb_detailmgrid$x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" value="<?php echo ew_HtmlEncode($tb_detailm->nilaim_kredit->FormValue) ?>">
<input type="hidden" data-table="tb_detailm" data-field="x_nilaim_kredit" name="ftb_detailmgrid$o<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" id="ftb_detailmgrid$o<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" value="<?php echo ew_HtmlEncode($tb_detailm->nilaim_kredit->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tb_detailm_grid->ListOptions->Render("body", "right", $tb_detailm_grid->RowCnt);
?>
	</tr>
<?php if ($tb_detailm->RowType == EW_ROWTYPE_ADD || $tb_detailm->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ftb_detailmgrid.UpdateOpts(<?php echo $tb_detailm_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($tb_detailm->CurrentAction <> "gridadd" || $tb_detailm->CurrentMode == "copy")
		if (!$tb_detailm_grid->Recordset->EOF) $tb_detailm_grid->Recordset->MoveNext();
}
?>
<?php
	if ($tb_detailm->CurrentMode == "add" || $tb_detailm->CurrentMode == "copy" || $tb_detailm->CurrentMode == "edit") {
		$tb_detailm_grid->RowIndex = '$rowindex$';
		$tb_detailm_grid->LoadDefaultValues();

		// Set row properties
		$tb_detailm->ResetAttrs();
		$tb_detailm->RowAttrs = array_merge($tb_detailm->RowAttrs, array('data-rowindex'=>$tb_detailm_grid->RowIndex, 'id'=>'r0_tb_detailm', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($tb_detailm->RowAttrs["class"], "ewTemplate");
		$tb_detailm->RowType = EW_ROWTYPE_ADD;

		// Render row
		$tb_detailm_grid->RenderRow();

		// Render list options
		$tb_detailm_grid->RenderListOptions();
		$tb_detailm_grid->StartRowCnt = 0;
?>
	<tr<?php echo $tb_detailm->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tb_detailm_grid->ListOptions->Render("body", "left", $tb_detailm_grid->RowIndex);
?>
	<?php if ($tb_detailm->akunm_id->Visible) { // akunm_id ?>
		<td data-name="akunm_id">
<?php if ($tb_detailm->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_detailm_akunm_id" class="form-group tb_detailm_akunm_id">
<?php
$wrkonchange = trim(" " . @$tb_detailm->akunm_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_detailm->akunm_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" style="white-space: nowrap; z-index: <?php echo (9000 - $tb_detailm_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" id="sv_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo $tb_detailm->akunm_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detailm->akunm_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_detailm->akunm_id->getPlaceHolder()) ?>"<?php echo $tb_detailm->akunm_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_detailm" data-field="x_akunm_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_detailm->akunm_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" id="x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($tb_detailm->akunm_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" id="q_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo $tb_detailm->akunm_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ftb_detailmgrid.CreateAutoSuggest({"id":"x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_detailm->akunm_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" id="s_x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo $tb_detailm->akunm_id->LookupFilterQuery(false) ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_tb_detailm_akunm_id" class="form-group tb_detailm_akunm_id">
<span<?php echo $tb_detailm->akunm_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_detailm->akunm_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_detailm" data-field="x_akunm_id" name="x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" id="x<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($tb_detailm->akunm_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_detailm" data-field="x_akunm_id" name="o<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" id="o<?php echo $tb_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($tb_detailm->akunm_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tb_detailm->nilaim_debet->Visible) { // nilaim_debet ?>
		<td data-name="nilaim_debet">
<?php if ($tb_detailm->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_detailm_nilaim_debet" class="form-group tb_detailm_nilaim_debet">
<input type="text" data-table="tb_detailm" data-field="x_nilaim_debet" name="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" id="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detailm->nilaim_debet->getPlaceHolder()) ?>" value="<?php echo $tb_detailm->nilaim_debet->EditValue ?>"<?php echo $tb_detailm->nilaim_debet->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tb_detailm_nilaim_debet" class="form-group tb_detailm_nilaim_debet">
<span<?php echo $tb_detailm->nilaim_debet->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_detailm->nilaim_debet->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_detailm" data-field="x_nilaim_debet" name="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" id="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" value="<?php echo ew_HtmlEncode($tb_detailm->nilaim_debet->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_detailm" data-field="x_nilaim_debet" name="o<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" id="o<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_debet" value="<?php echo ew_HtmlEncode($tb_detailm->nilaim_debet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tb_detailm->nilaim_kredit->Visible) { // nilaim_kredit ?>
		<td data-name="nilaim_kredit">
<?php if ($tb_detailm->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_detailm_nilaim_kredit" class="form-group tb_detailm_nilaim_kredit">
<input type="text" data-table="tb_detailm" data-field="x_nilaim_kredit" name="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" id="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detailm->nilaim_kredit->getPlaceHolder()) ?>" value="<?php echo $tb_detailm->nilaim_kredit->EditValue ?>"<?php echo $tb_detailm->nilaim_kredit->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tb_detailm_nilaim_kredit" class="form-group tb_detailm_nilaim_kredit">
<span<?php echo $tb_detailm->nilaim_kredit->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_detailm->nilaim_kredit->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_detailm" data-field="x_nilaim_kredit" name="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" id="x<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" value="<?php echo ew_HtmlEncode($tb_detailm->nilaim_kredit->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_detailm" data-field="x_nilaim_kredit" name="o<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" id="o<?php echo $tb_detailm_grid->RowIndex ?>_nilaim_kredit" value="<?php echo ew_HtmlEncode($tb_detailm->nilaim_kredit->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tb_detailm_grid->ListOptions->Render("body", "right", $tb_detailm_grid->RowCnt);
?>
<script type="text/javascript">
ftb_detailmgrid.UpdateOpts(<?php echo $tb_detailm_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($tb_detailm->CurrentMode == "add" || $tb_detailm->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $tb_detailm_grid->FormKeyCountName ?>" id="<?php echo $tb_detailm_grid->FormKeyCountName ?>" value="<?php echo $tb_detailm_grid->KeyCount ?>">
<?php echo $tb_detailm_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tb_detailm->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $tb_detailm_grid->FormKeyCountName ?>" id="<?php echo $tb_detailm_grid->FormKeyCountName ?>" value="<?php echo $tb_detailm_grid->KeyCount ?>">
<?php echo $tb_detailm_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tb_detailm->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ftb_detailmgrid">
</div>
<?php

// Close recordset
if ($tb_detailm_grid->Recordset)
	$tb_detailm_grid->Recordset->Close();
?>
<?php if ($tb_detailm_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($tb_detailm_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($tb_detailm_grid->TotalRecs == 0 && $tb_detailm->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tb_detailm_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($tb_detailm->Export == "") { ?>
<script type="text/javascript">
ftb_detailmgrid.Init();
</script>
<?php } ?>
<?php
$tb_detailm_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$tb_detailm_grid->Page_Terminate();
?>

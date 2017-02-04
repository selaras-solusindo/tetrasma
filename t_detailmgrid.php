<?php include_once "t_userinfo.php" ?>
<?php

// Create page object
if (!isset($t_detailm_grid)) $t_detailm_grid = new ct_detailm_grid();

// Page init
$t_detailm_grid->Page_Init();

// Page main
$t_detailm_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_detailm_grid->Page_Render();
?>
<?php if ($t_detailm->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft_detailmgrid = new ew_Form("ft_detailmgrid", "grid");
ft_detailmgrid.FormKeyCountName = '<?php echo $t_detailm_grid->FormKeyCountName ?>';

// Validate form
ft_detailmgrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_detailm->akunm_id->FldCaption(), $t_detailm->akunm_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nilaim_debet");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_detailm->nilaim_debet->FldCaption(), $t_detailm->nilaim_debet->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nilaim_debet");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_detailm->nilaim_debet->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_nilaim_kredit");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_detailm->nilaim_kredit->FldCaption(), $t_detailm->nilaim_kredit->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nilaim_kredit");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_detailm->nilaim_kredit->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft_detailmgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "akunm_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nilaim_debet", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nilaim_kredit", false)) return false;
	return true;
}

// Form_CustomValidate event
ft_detailmgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_detailmgrid.ValidateRequired = true;
<?php } else { ?>
ft_detailmgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_detailmgrid.Lists["x_akunm_id"] = {"LinkField":"x_level4_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_nama_akun","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"v_akun_jurnal"};

// Form object for search
</script>
<?php } ?>
<?php
if ($t_detailm->CurrentAction == "gridadd") {
	if ($t_detailm->CurrentMode == "copy") {
		$bSelectLimit = $t_detailm_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t_detailm_grid->TotalRecs = $t_detailm->SelectRecordCount();
			$t_detailm_grid->Recordset = $t_detailm_grid->LoadRecordset($t_detailm_grid->StartRec-1, $t_detailm_grid->DisplayRecs);
		} else {
			if ($t_detailm_grid->Recordset = $t_detailm_grid->LoadRecordset())
				$t_detailm_grid->TotalRecs = $t_detailm_grid->Recordset->RecordCount();
		}
		$t_detailm_grid->StartRec = 1;
		$t_detailm_grid->DisplayRecs = $t_detailm_grid->TotalRecs;
	} else {
		$t_detailm->CurrentFilter = "0=1";
		$t_detailm_grid->StartRec = 1;
		$t_detailm_grid->DisplayRecs = $t_detailm->GridAddRowCount;
	}
	$t_detailm_grid->TotalRecs = $t_detailm_grid->DisplayRecs;
	$t_detailm_grid->StopRec = $t_detailm_grid->DisplayRecs;
} else {
	$bSelectLimit = $t_detailm_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t_detailm_grid->TotalRecs <= 0)
			$t_detailm_grid->TotalRecs = $t_detailm->SelectRecordCount();
	} else {
		if (!$t_detailm_grid->Recordset && ($t_detailm_grid->Recordset = $t_detailm_grid->LoadRecordset()))
			$t_detailm_grid->TotalRecs = $t_detailm_grid->Recordset->RecordCount();
	}
	$t_detailm_grid->StartRec = 1;
	$t_detailm_grid->DisplayRecs = $t_detailm_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t_detailm_grid->Recordset = $t_detailm_grid->LoadRecordset($t_detailm_grid->StartRec-1, $t_detailm_grid->DisplayRecs);

	// Set no record found message
	if ($t_detailm->CurrentAction == "" && $t_detailm_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$t_detailm_grid->setWarningMessage(ew_DeniedMsg());
		if ($t_detailm_grid->SearchWhere == "0=101")
			$t_detailm_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t_detailm_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t_detailm_grid->RenderOtherOptions();
?>
<?php $t_detailm_grid->ShowPageHeader(); ?>
<?php
$t_detailm_grid->ShowMessage();
?>
<?php if ($t_detailm_grid->TotalRecs > 0 || $t_detailm->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t_detailm">
<div id="ft_detailmgrid" class="ewForm form-inline">
<div id="gmp_t_detailm" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_t_detailmgrid" class="table ewTable">
<?php echo $t_detailm->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t_detailm_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t_detailm_grid->RenderListOptions();

// Render list options (header, left)
$t_detailm_grid->ListOptions->Render("header", "left");
?>
<?php if ($t_detailm->akunm_id->Visible) { // akunm_id ?>
	<?php if ($t_detailm->SortUrl($t_detailm->akunm_id) == "") { ?>
		<th data-name="akunm_id"><div id="elh_t_detailm_akunm_id" class="t_detailm_akunm_id"><div class="ewTableHeaderCaption"><?php echo $t_detailm->akunm_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="akunm_id"><div><div id="elh_t_detailm_akunm_id" class="t_detailm_akunm_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_detailm->akunm_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_detailm->akunm_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_detailm->akunm_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_detailm->nilaim_debet->Visible) { // nilaim_debet ?>
	<?php if ($t_detailm->SortUrl($t_detailm->nilaim_debet) == "") { ?>
		<th data-name="nilaim_debet"><div id="elh_t_detailm_nilaim_debet" class="t_detailm_nilaim_debet"><div class="ewTableHeaderCaption"><?php echo $t_detailm->nilaim_debet->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nilaim_debet"><div><div id="elh_t_detailm_nilaim_debet" class="t_detailm_nilaim_debet">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_detailm->nilaim_debet->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_detailm->nilaim_debet->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_detailm->nilaim_debet->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_detailm->nilaim_kredit->Visible) { // nilaim_kredit ?>
	<?php if ($t_detailm->SortUrl($t_detailm->nilaim_kredit) == "") { ?>
		<th data-name="nilaim_kredit"><div id="elh_t_detailm_nilaim_kredit" class="t_detailm_nilaim_kredit"><div class="ewTableHeaderCaption"><?php echo $t_detailm->nilaim_kredit->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nilaim_kredit"><div><div id="elh_t_detailm_nilaim_kredit" class="t_detailm_nilaim_kredit">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_detailm->nilaim_kredit->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_detailm->nilaim_kredit->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_detailm->nilaim_kredit->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t_detailm_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t_detailm_grid->StartRec = 1;
$t_detailm_grid->StopRec = $t_detailm_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t_detailm_grid->FormKeyCountName) && ($t_detailm->CurrentAction == "gridadd" || $t_detailm->CurrentAction == "gridedit" || $t_detailm->CurrentAction == "F")) {
		$t_detailm_grid->KeyCount = $objForm->GetValue($t_detailm_grid->FormKeyCountName);
		$t_detailm_grid->StopRec = $t_detailm_grid->StartRec + $t_detailm_grid->KeyCount - 1;
	}
}
$t_detailm_grid->RecCnt = $t_detailm_grid->StartRec - 1;
if ($t_detailm_grid->Recordset && !$t_detailm_grid->Recordset->EOF) {
	$t_detailm_grid->Recordset->MoveFirst();
	$bSelectLimit = $t_detailm_grid->UseSelectLimit;
	if (!$bSelectLimit && $t_detailm_grid->StartRec > 1)
		$t_detailm_grid->Recordset->Move($t_detailm_grid->StartRec - 1);
} elseif (!$t_detailm->AllowAddDeleteRow && $t_detailm_grid->StopRec == 0) {
	$t_detailm_grid->StopRec = $t_detailm->GridAddRowCount;
}

// Initialize aggregate
$t_detailm->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t_detailm->ResetAttrs();
$t_detailm_grid->RenderRow();
if ($t_detailm->CurrentAction == "gridadd")
	$t_detailm_grid->RowIndex = 0;
if ($t_detailm->CurrentAction == "gridedit")
	$t_detailm_grid->RowIndex = 0;
while ($t_detailm_grid->RecCnt < $t_detailm_grid->StopRec) {
	$t_detailm_grid->RecCnt++;
	if (intval($t_detailm_grid->RecCnt) >= intval($t_detailm_grid->StartRec)) {
		$t_detailm_grid->RowCnt++;
		if ($t_detailm->CurrentAction == "gridadd" || $t_detailm->CurrentAction == "gridedit" || $t_detailm->CurrentAction == "F") {
			$t_detailm_grid->RowIndex++;
			$objForm->Index = $t_detailm_grid->RowIndex;
			if ($objForm->HasValue($t_detailm_grid->FormActionName))
				$t_detailm_grid->RowAction = strval($objForm->GetValue($t_detailm_grid->FormActionName));
			elseif ($t_detailm->CurrentAction == "gridadd")
				$t_detailm_grid->RowAction = "insert";
			else
				$t_detailm_grid->RowAction = "";
		}

		// Set up key count
		$t_detailm_grid->KeyCount = $t_detailm_grid->RowIndex;

		// Init row class and style
		$t_detailm->ResetAttrs();
		$t_detailm->CssClass = "";
		if ($t_detailm->CurrentAction == "gridadd") {
			if ($t_detailm->CurrentMode == "copy") {
				$t_detailm_grid->LoadRowValues($t_detailm_grid->Recordset); // Load row values
				$t_detailm_grid->SetRecordKey($t_detailm_grid->RowOldKey, $t_detailm_grid->Recordset); // Set old record key
			} else {
				$t_detailm_grid->LoadDefaultValues(); // Load default values
				$t_detailm_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t_detailm_grid->LoadRowValues($t_detailm_grid->Recordset); // Load row values
		}
		$t_detailm->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t_detailm->CurrentAction == "gridadd") // Grid add
			$t_detailm->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t_detailm->CurrentAction == "gridadd" && $t_detailm->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t_detailm_grid->RestoreCurrentRowFormValues($t_detailm_grid->RowIndex); // Restore form values
		if ($t_detailm->CurrentAction == "gridedit") { // Grid edit
			if ($t_detailm->EventCancelled) {
				$t_detailm_grid->RestoreCurrentRowFormValues($t_detailm_grid->RowIndex); // Restore form values
			}
			if ($t_detailm_grid->RowAction == "insert")
				$t_detailm->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t_detailm->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t_detailm->CurrentAction == "gridedit" && ($t_detailm->RowType == EW_ROWTYPE_EDIT || $t_detailm->RowType == EW_ROWTYPE_ADD) && $t_detailm->EventCancelled) // Update failed
			$t_detailm_grid->RestoreCurrentRowFormValues($t_detailm_grid->RowIndex); // Restore form values
		if ($t_detailm->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t_detailm_grid->EditRowCnt++;
		if ($t_detailm->CurrentAction == "F") // Confirm row
			$t_detailm_grid->RestoreCurrentRowFormValues($t_detailm_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t_detailm->RowAttrs = array_merge($t_detailm->RowAttrs, array('data-rowindex'=>$t_detailm_grid->RowCnt, 'id'=>'r' . $t_detailm_grid->RowCnt . '_t_detailm', 'data-rowtype'=>$t_detailm->RowType));

		// Render row
		$t_detailm_grid->RenderRow();

		// Render list options
		$t_detailm_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t_detailm_grid->RowAction <> "delete" && $t_detailm_grid->RowAction <> "insertdelete" && !($t_detailm_grid->RowAction == "insert" && $t_detailm->CurrentAction == "F" && $t_detailm_grid->EmptyRow())) {
?>
	<tr<?php echo $t_detailm->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_detailm_grid->ListOptions->Render("body", "left", $t_detailm_grid->RowCnt);
?>
	<?php if ($t_detailm->akunm_id->Visible) { // akunm_id ?>
		<td data-name="akunm_id"<?php echo $t_detailm->akunm_id->CellAttributes() ?>>
<?php if ($t_detailm->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_detailm_grid->RowCnt ?>_t_detailm_akunm_id" class="form-group t_detailm_akunm_id">
<?php
$wrkonchange = trim(" " . @$t_detailm->akunm_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t_detailm->akunm_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t_detailm_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" id="sv_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo $t_detailm->akunm_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t_detailm->akunm_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t_detailm->akunm_id->getPlaceHolder()) ?>"<?php echo $t_detailm->akunm_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detailm" data-field="x_akunm_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_detailm->akunm_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" id="x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($t_detailm->akunm_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" id="q_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo $t_detailm->akunm_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft_detailmgrid.CreateAutoSuggest({"id":"x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_detailm->akunm_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" id="s_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo $t_detailm->akunm_id->LookupFilterQuery(false) ?>">
</span>
<input type="hidden" data-table="t_detailm" data-field="x_akunm_id" name="o<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" id="o<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($t_detailm->akunm_id->OldValue) ?>">
<?php } ?>
<?php if ($t_detailm->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_detailm_grid->RowCnt ?>_t_detailm_akunm_id" class="form-group t_detailm_akunm_id">
<?php
$wrkonchange = trim(" " . @$t_detailm->akunm_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t_detailm->akunm_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t_detailm_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" id="sv_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo $t_detailm->akunm_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t_detailm->akunm_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t_detailm->akunm_id->getPlaceHolder()) ?>"<?php echo $t_detailm->akunm_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detailm" data-field="x_akunm_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_detailm->akunm_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" id="x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($t_detailm->akunm_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" id="q_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo $t_detailm->akunm_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft_detailmgrid.CreateAutoSuggest({"id":"x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_detailm->akunm_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" id="s_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo $t_detailm->akunm_id->LookupFilterQuery(false) ?>">
</span>
<?php } ?>
<?php if ($t_detailm->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_detailm_grid->RowCnt ?>_t_detailm_akunm_id" class="t_detailm_akunm_id">
<span<?php echo $t_detailm->akunm_id->ViewAttributes() ?>>
<?php echo $t_detailm->akunm_id->ListViewValue() ?></span>
</span>
<?php if ($t_detailm->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_detailm" data-field="x_akunm_id" name="x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" id="x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($t_detailm->akunm_id->FormValue) ?>">
<input type="hidden" data-table="t_detailm" data-field="x_akunm_id" name="o<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" id="o<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($t_detailm->akunm_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_detailm" data-field="x_akunm_id" name="ft_detailmgrid$x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" id="ft_detailmgrid$x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($t_detailm->akunm_id->FormValue) ?>">
<input type="hidden" data-table="t_detailm" data-field="x_akunm_id" name="ft_detailmgrid$o<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" id="ft_detailmgrid$o<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($t_detailm->akunm_id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $t_detailm_grid->PageObjName . "_row_" . $t_detailm_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t_detailm->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t_detailm" data-field="x_detailm_id" name="x<?php echo $t_detailm_grid->RowIndex ?>_detailm_id" id="x<?php echo $t_detailm_grid->RowIndex ?>_detailm_id" value="<?php echo ew_HtmlEncode($t_detailm->detailm_id->CurrentValue) ?>">
<input type="hidden" data-table="t_detailm" data-field="x_detailm_id" name="o<?php echo $t_detailm_grid->RowIndex ?>_detailm_id" id="o<?php echo $t_detailm_grid->RowIndex ?>_detailm_id" value="<?php echo ew_HtmlEncode($t_detailm->detailm_id->OldValue) ?>">
<?php } ?>
<?php if ($t_detailm->RowType == EW_ROWTYPE_EDIT || $t_detailm->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t_detailm" data-field="x_detailm_id" name="x<?php echo $t_detailm_grid->RowIndex ?>_detailm_id" id="x<?php echo $t_detailm_grid->RowIndex ?>_detailm_id" value="<?php echo ew_HtmlEncode($t_detailm->detailm_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t_detailm->nilaim_debet->Visible) { // nilaim_debet ?>
		<td data-name="nilaim_debet"<?php echo $t_detailm->nilaim_debet->CellAttributes() ?>>
<?php if ($t_detailm->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_detailm_grid->RowCnt ?>_t_detailm_nilaim_debet" class="form-group t_detailm_nilaim_debet">
<input type="text" data-table="t_detailm" data-field="x_nilaim_debet" name="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" id="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" size="30" placeholder="<?php echo ew_HtmlEncode($t_detailm->nilaim_debet->getPlaceHolder()) ?>" value="<?php echo $t_detailm->nilaim_debet->EditValue ?>"<?php echo $t_detailm->nilaim_debet->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detailm" data-field="x_nilaim_debet" name="o<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" id="o<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" value="<?php echo ew_HtmlEncode($t_detailm->nilaim_debet->OldValue) ?>">
<?php } ?>
<?php if ($t_detailm->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_detailm_grid->RowCnt ?>_t_detailm_nilaim_debet" class="form-group t_detailm_nilaim_debet">
<input type="text" data-table="t_detailm" data-field="x_nilaim_debet" name="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" id="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" size="30" placeholder="<?php echo ew_HtmlEncode($t_detailm->nilaim_debet->getPlaceHolder()) ?>" value="<?php echo $t_detailm->nilaim_debet->EditValue ?>"<?php echo $t_detailm->nilaim_debet->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_detailm->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_detailm_grid->RowCnt ?>_t_detailm_nilaim_debet" class="t_detailm_nilaim_debet">
<span<?php echo $t_detailm->nilaim_debet->ViewAttributes() ?>>
<?php echo $t_detailm->nilaim_debet->ListViewValue() ?></span>
</span>
<?php if ($t_detailm->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_detailm" data-field="x_nilaim_debet" name="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" id="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" value="<?php echo ew_HtmlEncode($t_detailm->nilaim_debet->FormValue) ?>">
<input type="hidden" data-table="t_detailm" data-field="x_nilaim_debet" name="o<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" id="o<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" value="<?php echo ew_HtmlEncode($t_detailm->nilaim_debet->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_detailm" data-field="x_nilaim_debet" name="ft_detailmgrid$x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" id="ft_detailmgrid$x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" value="<?php echo ew_HtmlEncode($t_detailm->nilaim_debet->FormValue) ?>">
<input type="hidden" data-table="t_detailm" data-field="x_nilaim_debet" name="ft_detailmgrid$o<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" id="ft_detailmgrid$o<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" value="<?php echo ew_HtmlEncode($t_detailm->nilaim_debet->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_detailm->nilaim_kredit->Visible) { // nilaim_kredit ?>
		<td data-name="nilaim_kredit"<?php echo $t_detailm->nilaim_kredit->CellAttributes() ?>>
<?php if ($t_detailm->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_detailm_grid->RowCnt ?>_t_detailm_nilaim_kredit" class="form-group t_detailm_nilaim_kredit">
<input type="text" data-table="t_detailm" data-field="x_nilaim_kredit" name="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" id="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" size="30" placeholder="<?php echo ew_HtmlEncode($t_detailm->nilaim_kredit->getPlaceHolder()) ?>" value="<?php echo $t_detailm->nilaim_kredit->EditValue ?>"<?php echo $t_detailm->nilaim_kredit->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detailm" data-field="x_nilaim_kredit" name="o<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" id="o<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" value="<?php echo ew_HtmlEncode($t_detailm->nilaim_kredit->OldValue) ?>">
<?php } ?>
<?php if ($t_detailm->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_detailm_grid->RowCnt ?>_t_detailm_nilaim_kredit" class="form-group t_detailm_nilaim_kredit">
<input type="text" data-table="t_detailm" data-field="x_nilaim_kredit" name="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" id="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" size="30" placeholder="<?php echo ew_HtmlEncode($t_detailm->nilaim_kredit->getPlaceHolder()) ?>" value="<?php echo $t_detailm->nilaim_kredit->EditValue ?>"<?php echo $t_detailm->nilaim_kredit->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_detailm->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_detailm_grid->RowCnt ?>_t_detailm_nilaim_kredit" class="t_detailm_nilaim_kredit">
<span<?php echo $t_detailm->nilaim_kredit->ViewAttributes() ?>>
<?php echo $t_detailm->nilaim_kredit->ListViewValue() ?></span>
</span>
<?php if ($t_detailm->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_detailm" data-field="x_nilaim_kredit" name="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" id="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" value="<?php echo ew_HtmlEncode($t_detailm->nilaim_kredit->FormValue) ?>">
<input type="hidden" data-table="t_detailm" data-field="x_nilaim_kredit" name="o<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" id="o<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" value="<?php echo ew_HtmlEncode($t_detailm->nilaim_kredit->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_detailm" data-field="x_nilaim_kredit" name="ft_detailmgrid$x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" id="ft_detailmgrid$x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" value="<?php echo ew_HtmlEncode($t_detailm->nilaim_kredit->FormValue) ?>">
<input type="hidden" data-table="t_detailm" data-field="x_nilaim_kredit" name="ft_detailmgrid$o<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" id="ft_detailmgrid$o<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" value="<?php echo ew_HtmlEncode($t_detailm->nilaim_kredit->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_detailm_grid->ListOptions->Render("body", "right", $t_detailm_grid->RowCnt);
?>
	</tr>
<?php if ($t_detailm->RowType == EW_ROWTYPE_ADD || $t_detailm->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft_detailmgrid.UpdateOpts(<?php echo $t_detailm_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t_detailm->CurrentAction <> "gridadd" || $t_detailm->CurrentMode == "copy")
		if (!$t_detailm_grid->Recordset->EOF) $t_detailm_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t_detailm->CurrentMode == "add" || $t_detailm->CurrentMode == "copy" || $t_detailm->CurrentMode == "edit") {
		$t_detailm_grid->RowIndex = '$rowindex$';
		$t_detailm_grid->LoadDefaultValues();

		// Set row properties
		$t_detailm->ResetAttrs();
		$t_detailm->RowAttrs = array_merge($t_detailm->RowAttrs, array('data-rowindex'=>$t_detailm_grid->RowIndex, 'id'=>'r0_t_detailm', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t_detailm->RowAttrs["class"], "ewTemplate");
		$t_detailm->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t_detailm_grid->RenderRow();

		// Render list options
		$t_detailm_grid->RenderListOptions();
		$t_detailm_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t_detailm->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_detailm_grid->ListOptions->Render("body", "left", $t_detailm_grid->RowIndex);
?>
	<?php if ($t_detailm->akunm_id->Visible) { // akunm_id ?>
		<td data-name="akunm_id">
<?php if ($t_detailm->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_detailm_akunm_id" class="form-group t_detailm_akunm_id">
<?php
$wrkonchange = trim(" " . @$t_detailm->akunm_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t_detailm->akunm_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t_detailm_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" id="sv_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo $t_detailm->akunm_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t_detailm->akunm_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t_detailm->akunm_id->getPlaceHolder()) ?>"<?php echo $t_detailm->akunm_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detailm" data-field="x_akunm_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_detailm->akunm_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" id="x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($t_detailm->akunm_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" id="q_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo $t_detailm->akunm_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft_detailmgrid.CreateAutoSuggest({"id":"x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_detailm->akunm_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" id="s_x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo $t_detailm->akunm_id->LookupFilterQuery(false) ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_t_detailm_akunm_id" class="form-group t_detailm_akunm_id">
<span<?php echo $t_detailm->akunm_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_detailm->akunm_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_detailm" data-field="x_akunm_id" name="x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" id="x<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($t_detailm->akunm_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_detailm" data-field="x_akunm_id" name="o<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" id="o<?php echo $t_detailm_grid->RowIndex ?>_akunm_id" value="<?php echo ew_HtmlEncode($t_detailm->akunm_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_detailm->nilaim_debet->Visible) { // nilaim_debet ?>
		<td data-name="nilaim_debet">
<?php if ($t_detailm->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_detailm_nilaim_debet" class="form-group t_detailm_nilaim_debet">
<input type="text" data-table="t_detailm" data-field="x_nilaim_debet" name="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" id="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" size="30" placeholder="<?php echo ew_HtmlEncode($t_detailm->nilaim_debet->getPlaceHolder()) ?>" value="<?php echo $t_detailm->nilaim_debet->EditValue ?>"<?php echo $t_detailm->nilaim_debet->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_detailm_nilaim_debet" class="form-group t_detailm_nilaim_debet">
<span<?php echo $t_detailm->nilaim_debet->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_detailm->nilaim_debet->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_detailm" data-field="x_nilaim_debet" name="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" id="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" value="<?php echo ew_HtmlEncode($t_detailm->nilaim_debet->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_detailm" data-field="x_nilaim_debet" name="o<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" id="o<?php echo $t_detailm_grid->RowIndex ?>_nilaim_debet" value="<?php echo ew_HtmlEncode($t_detailm->nilaim_debet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_detailm->nilaim_kredit->Visible) { // nilaim_kredit ?>
		<td data-name="nilaim_kredit">
<?php if ($t_detailm->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_detailm_nilaim_kredit" class="form-group t_detailm_nilaim_kredit">
<input type="text" data-table="t_detailm" data-field="x_nilaim_kredit" name="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" id="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" size="30" placeholder="<?php echo ew_HtmlEncode($t_detailm->nilaim_kredit->getPlaceHolder()) ?>" value="<?php echo $t_detailm->nilaim_kredit->EditValue ?>"<?php echo $t_detailm->nilaim_kredit->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_detailm_nilaim_kredit" class="form-group t_detailm_nilaim_kredit">
<span<?php echo $t_detailm->nilaim_kredit->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_detailm->nilaim_kredit->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_detailm" data-field="x_nilaim_kredit" name="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" id="x<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" value="<?php echo ew_HtmlEncode($t_detailm->nilaim_kredit->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_detailm" data-field="x_nilaim_kredit" name="o<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" id="o<?php echo $t_detailm_grid->RowIndex ?>_nilaim_kredit" value="<?php echo ew_HtmlEncode($t_detailm->nilaim_kredit->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_detailm_grid->ListOptions->Render("body", "right", $t_detailm_grid->RowCnt);
?>
<script type="text/javascript">
ft_detailmgrid.UpdateOpts(<?php echo $t_detailm_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t_detailm->CurrentMode == "add" || $t_detailm->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t_detailm_grid->FormKeyCountName ?>" id="<?php echo $t_detailm_grid->FormKeyCountName ?>" value="<?php echo $t_detailm_grid->KeyCount ?>">
<?php echo $t_detailm_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t_detailm->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t_detailm_grid->FormKeyCountName ?>" id="<?php echo $t_detailm_grid->FormKeyCountName ?>" value="<?php echo $t_detailm_grid->KeyCount ?>">
<?php echo $t_detailm_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t_detailm->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft_detailmgrid">
</div>
<?php

// Close recordset
if ($t_detailm_grid->Recordset)
	$t_detailm_grid->Recordset->Close();
?>
<?php if ($t_detailm_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($t_detailm_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t_detailm_grid->TotalRecs == 0 && $t_detailm->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t_detailm_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t_detailm->Export == "") { ?>
<script type="text/javascript">
ft_detailmgrid.Init();
</script>
<?php } ?>
<?php
$t_detailm_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$t_detailm_grid->Page_Terminate();
?>

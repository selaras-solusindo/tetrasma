<?php include_once "t_userinfo.php" ?>
<?php

// Create page object
if (!isset($t_detail_grid)) $t_detail_grid = new ct_detail_grid();

// Page init
$t_detail_grid->Page_Init();

// Page main
$t_detail_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_detail_grid->Page_Render();
?>
<?php if ($t_detail->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft_detailgrid = new ew_Form("ft_detailgrid", "grid");
ft_detailgrid.FormKeyCountName = '<?php echo $t_detail_grid->FormKeyCountName ?>';

// Validate form
ft_detailgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_akun_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_detail->akun_id->FldCaption(), $t_detail->akun_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nilai");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_detail->nilai->FldCaption(), $t_detail->nilai->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nilai");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_detail->nilai->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft_detailgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "akun_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nilai", false)) return false;
	if (ew_ValueChanged(fobj, infix, "anggota_id", false)) return false;
	return true;
}

// Form_CustomValidate event
ft_detailgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_detailgrid.ValidateRequired = true;
<?php } else { ?>
ft_detailgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_detailgrid.Lists["x_akun_id"] = {"LinkField":"x_level4_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_nama_akun","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"v_akun_jurnal"};
ft_detailgrid.Lists["x_anggota_id"] = {"LinkField":"x_anggota_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t_anggota"};

// Form object for search
</script>
<?php } ?>
<?php
if ($t_detail->CurrentAction == "gridadd") {
	if ($t_detail->CurrentMode == "copy") {
		$bSelectLimit = $t_detail_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t_detail_grid->TotalRecs = $t_detail->SelectRecordCount();
			$t_detail_grid->Recordset = $t_detail_grid->LoadRecordset($t_detail_grid->StartRec-1, $t_detail_grid->DisplayRecs);
		} else {
			if ($t_detail_grid->Recordset = $t_detail_grid->LoadRecordset())
				$t_detail_grid->TotalRecs = $t_detail_grid->Recordset->RecordCount();
		}
		$t_detail_grid->StartRec = 1;
		$t_detail_grid->DisplayRecs = $t_detail_grid->TotalRecs;
	} else {
		$t_detail->CurrentFilter = "0=1";
		$t_detail_grid->StartRec = 1;
		$t_detail_grid->DisplayRecs = $t_detail->GridAddRowCount;
	}
	$t_detail_grid->TotalRecs = $t_detail_grid->DisplayRecs;
	$t_detail_grid->StopRec = $t_detail_grid->DisplayRecs;
} else {
	$bSelectLimit = $t_detail_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t_detail_grid->TotalRecs <= 0)
			$t_detail_grid->TotalRecs = $t_detail->SelectRecordCount();
	} else {
		if (!$t_detail_grid->Recordset && ($t_detail_grid->Recordset = $t_detail_grid->LoadRecordset()))
			$t_detail_grid->TotalRecs = $t_detail_grid->Recordset->RecordCount();
	}
	$t_detail_grid->StartRec = 1;
	$t_detail_grid->DisplayRecs = $t_detail_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t_detail_grid->Recordset = $t_detail_grid->LoadRecordset($t_detail_grid->StartRec-1, $t_detail_grid->DisplayRecs);

	// Set no record found message
	if ($t_detail->CurrentAction == "" && $t_detail_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$t_detail_grid->setWarningMessage(ew_DeniedMsg());
		if ($t_detail_grid->SearchWhere == "0=101")
			$t_detail_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t_detail_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t_detail_grid->RenderOtherOptions();
?>
<?php $t_detail_grid->ShowPageHeader(); ?>
<?php
$t_detail_grid->ShowMessage();
?>
<?php if ($t_detail_grid->TotalRecs > 0 || $t_detail->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t_detail">
<div id="ft_detailgrid" class="ewForm form-inline">
<div id="gmp_t_detail" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_t_detailgrid" class="table ewTable">
<?php echo $t_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t_detail_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t_detail_grid->RenderListOptions();

// Render list options (header, left)
$t_detail_grid->ListOptions->Render("header", "left");
?>
<?php if ($t_detail->akun_id->Visible) { // akun_id ?>
	<?php if ($t_detail->SortUrl($t_detail->akun_id) == "") { ?>
		<th data-name="akun_id"><div id="elh_t_detail_akun_id" class="t_detail_akun_id"><div class="ewTableHeaderCaption"><?php echo $t_detail->akun_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="akun_id"><div><div id="elh_t_detail_akun_id" class="t_detail_akun_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_detail->akun_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_detail->akun_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_detail->akun_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_detail->nilai->Visible) { // nilai ?>
	<?php if ($t_detail->SortUrl($t_detail->nilai) == "") { ?>
		<th data-name="nilai"><div id="elh_t_detail_nilai" class="t_detail_nilai"><div class="ewTableHeaderCaption"><?php echo $t_detail->nilai->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nilai"><div><div id="elh_t_detail_nilai" class="t_detail_nilai">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_detail->nilai->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_detail->nilai->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_detail->nilai->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_detail->anggota_id->Visible) { // anggota_id ?>
	<?php if ($t_detail->SortUrl($t_detail->anggota_id) == "") { ?>
		<th data-name="anggota_id"><div id="elh_t_detail_anggota_id" class="t_detail_anggota_id"><div class="ewTableHeaderCaption"><?php echo $t_detail->anggota_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="anggota_id"><div><div id="elh_t_detail_anggota_id" class="t_detail_anggota_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_detail->anggota_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_detail->anggota_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_detail->anggota_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t_detail_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t_detail_grid->StartRec = 1;
$t_detail_grid->StopRec = $t_detail_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t_detail_grid->FormKeyCountName) && ($t_detail->CurrentAction == "gridadd" || $t_detail->CurrentAction == "gridedit" || $t_detail->CurrentAction == "F")) {
		$t_detail_grid->KeyCount = $objForm->GetValue($t_detail_grid->FormKeyCountName);
		$t_detail_grid->StopRec = $t_detail_grid->StartRec + $t_detail_grid->KeyCount - 1;
	}
}
$t_detail_grid->RecCnt = $t_detail_grid->StartRec - 1;
if ($t_detail_grid->Recordset && !$t_detail_grid->Recordset->EOF) {
	$t_detail_grid->Recordset->MoveFirst();
	$bSelectLimit = $t_detail_grid->UseSelectLimit;
	if (!$bSelectLimit && $t_detail_grid->StartRec > 1)
		$t_detail_grid->Recordset->Move($t_detail_grid->StartRec - 1);
} elseif (!$t_detail->AllowAddDeleteRow && $t_detail_grid->StopRec == 0) {
	$t_detail_grid->StopRec = $t_detail->GridAddRowCount;
}

// Initialize aggregate
$t_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t_detail->ResetAttrs();
$t_detail_grid->RenderRow();
if ($t_detail->CurrentAction == "gridadd")
	$t_detail_grid->RowIndex = 0;
if ($t_detail->CurrentAction == "gridedit")
	$t_detail_grid->RowIndex = 0;
while ($t_detail_grid->RecCnt < $t_detail_grid->StopRec) {
	$t_detail_grid->RecCnt++;
	if (intval($t_detail_grid->RecCnt) >= intval($t_detail_grid->StartRec)) {
		$t_detail_grid->RowCnt++;
		if ($t_detail->CurrentAction == "gridadd" || $t_detail->CurrentAction == "gridedit" || $t_detail->CurrentAction == "F") {
			$t_detail_grid->RowIndex++;
			$objForm->Index = $t_detail_grid->RowIndex;
			if ($objForm->HasValue($t_detail_grid->FormActionName))
				$t_detail_grid->RowAction = strval($objForm->GetValue($t_detail_grid->FormActionName));
			elseif ($t_detail->CurrentAction == "gridadd")
				$t_detail_grid->RowAction = "insert";
			else
				$t_detail_grid->RowAction = "";
		}

		// Set up key count
		$t_detail_grid->KeyCount = $t_detail_grid->RowIndex;

		// Init row class and style
		$t_detail->ResetAttrs();
		$t_detail->CssClass = "";
		if ($t_detail->CurrentAction == "gridadd") {
			if ($t_detail->CurrentMode == "copy") {
				$t_detail_grid->LoadRowValues($t_detail_grid->Recordset); // Load row values
				$t_detail_grid->SetRecordKey($t_detail_grid->RowOldKey, $t_detail_grid->Recordset); // Set old record key
			} else {
				$t_detail_grid->LoadDefaultValues(); // Load default values
				$t_detail_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t_detail_grid->LoadRowValues($t_detail_grid->Recordset); // Load row values
		}
		$t_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t_detail->CurrentAction == "gridadd") // Grid add
			$t_detail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t_detail->CurrentAction == "gridadd" && $t_detail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t_detail_grid->RestoreCurrentRowFormValues($t_detail_grid->RowIndex); // Restore form values
		if ($t_detail->CurrentAction == "gridedit") { // Grid edit
			if ($t_detail->EventCancelled) {
				$t_detail_grid->RestoreCurrentRowFormValues($t_detail_grid->RowIndex); // Restore form values
			}
			if ($t_detail_grid->RowAction == "insert")
				$t_detail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t_detail->CurrentAction == "gridedit" && ($t_detail->RowType == EW_ROWTYPE_EDIT || $t_detail->RowType == EW_ROWTYPE_ADD) && $t_detail->EventCancelled) // Update failed
			$t_detail_grid->RestoreCurrentRowFormValues($t_detail_grid->RowIndex); // Restore form values
		if ($t_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t_detail_grid->EditRowCnt++;
		if ($t_detail->CurrentAction == "F") // Confirm row
			$t_detail_grid->RestoreCurrentRowFormValues($t_detail_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t_detail->RowAttrs = array_merge($t_detail->RowAttrs, array('data-rowindex'=>$t_detail_grid->RowCnt, 'id'=>'r' . $t_detail_grid->RowCnt . '_t_detail', 'data-rowtype'=>$t_detail->RowType));

		// Render row
		$t_detail_grid->RenderRow();

		// Render list options
		$t_detail_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t_detail_grid->RowAction <> "delete" && $t_detail_grid->RowAction <> "insertdelete" && !($t_detail_grid->RowAction == "insert" && $t_detail->CurrentAction == "F" && $t_detail_grid->EmptyRow())) {
?>
	<tr<?php echo $t_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_detail_grid->ListOptions->Render("body", "left", $t_detail_grid->RowCnt);
?>
	<?php if ($t_detail->akun_id->Visible) { // akun_id ?>
		<td data-name="akun_id"<?php echo $t_detail->akun_id->CellAttributes() ?>>
<?php if ($t_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_detail_grid->RowCnt ?>_t_detail_akun_id" class="form-group t_detail_akun_id">
<?php
$wrkonchange = trim(" " . @$t_detail->akun_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t_detail->akun_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t_detail_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" id="sv_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" value="<?php echo $t_detail->akun_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->akun_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t_detail->akun_id->getPlaceHolder()) ?>"<?php echo $t_detail->akun_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detail" data-field="x_akun_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_detail->akun_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_detail_grid->RowIndex ?>_akun_id" id="x<?php echo $t_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($t_detail->akun_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" id="q_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" value="<?php echo $t_detail->akun_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft_detailgrid.CreateAutoSuggest({"id":"x<?php echo $t_detail_grid->RowIndex ?>_akun_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_detail->akun_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_detail_grid->RowIndex ?>_akun_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" id="s_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" value="<?php echo $t_detail->akun_id->LookupFilterQuery(false) ?>">
</span>
<input type="hidden" data-table="t_detail" data-field="x_akun_id" name="o<?php echo $t_detail_grid->RowIndex ?>_akun_id" id="o<?php echo $t_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($t_detail->akun_id->OldValue) ?>">
<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_detail_grid->RowCnt ?>_t_detail_akun_id" class="form-group t_detail_akun_id">
<?php
$wrkonchange = trim(" " . @$t_detail->akun_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t_detail->akun_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t_detail_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" id="sv_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" value="<?php echo $t_detail->akun_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->akun_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t_detail->akun_id->getPlaceHolder()) ?>"<?php echo $t_detail->akun_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detail" data-field="x_akun_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_detail->akun_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_detail_grid->RowIndex ?>_akun_id" id="x<?php echo $t_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($t_detail->akun_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" id="q_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" value="<?php echo $t_detail->akun_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft_detailgrid.CreateAutoSuggest({"id":"x<?php echo $t_detail_grid->RowIndex ?>_akun_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_detail->akun_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_detail_grid->RowIndex ?>_akun_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" id="s_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" value="<?php echo $t_detail->akun_id->LookupFilterQuery(false) ?>">
</span>
<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_detail_grid->RowCnt ?>_t_detail_akun_id" class="t_detail_akun_id">
<span<?php echo $t_detail->akun_id->ViewAttributes() ?>>
<?php echo $t_detail->akun_id->ListViewValue() ?></span>
</span>
<?php if ($t_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_detail" data-field="x_akun_id" name="x<?php echo $t_detail_grid->RowIndex ?>_akun_id" id="x<?php echo $t_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($t_detail->akun_id->FormValue) ?>">
<input type="hidden" data-table="t_detail" data-field="x_akun_id" name="o<?php echo $t_detail_grid->RowIndex ?>_akun_id" id="o<?php echo $t_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($t_detail->akun_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_detail" data-field="x_akun_id" name="ft_detailgrid$x<?php echo $t_detail_grid->RowIndex ?>_akun_id" id="ft_detailgrid$x<?php echo $t_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($t_detail->akun_id->FormValue) ?>">
<input type="hidden" data-table="t_detail" data-field="x_akun_id" name="ft_detailgrid$o<?php echo $t_detail_grid->RowIndex ?>_akun_id" id="ft_detailgrid$o<?php echo $t_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($t_detail->akun_id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $t_detail_grid->PageObjName . "_row_" . $t_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t_detail" data-field="x_detail_id" name="x<?php echo $t_detail_grid->RowIndex ?>_detail_id" id="x<?php echo $t_detail_grid->RowIndex ?>_detail_id" value="<?php echo ew_HtmlEncode($t_detail->detail_id->CurrentValue) ?>">
<input type="hidden" data-table="t_detail" data-field="x_detail_id" name="o<?php echo $t_detail_grid->RowIndex ?>_detail_id" id="o<?php echo $t_detail_grid->RowIndex ?>_detail_id" value="<?php echo ew_HtmlEncode($t_detail->detail_id->OldValue) ?>">
<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_EDIT || $t_detail->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t_detail" data-field="x_detail_id" name="x<?php echo $t_detail_grid->RowIndex ?>_detail_id" id="x<?php echo $t_detail_grid->RowIndex ?>_detail_id" value="<?php echo ew_HtmlEncode($t_detail->detail_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t_detail->nilai->Visible) { // nilai ?>
		<td data-name="nilai"<?php echo $t_detail->nilai->CellAttributes() ?>>
<?php if ($t_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_detail_grid->RowCnt ?>_t_detail_nilai" class="form-group t_detail_nilai">
<input type="text" data-table="t_detail" data-field="x_nilai" name="x<?php echo $t_detail_grid->RowIndex ?>_nilai" id="x<?php echo $t_detail_grid->RowIndex ?>_nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->nilai->getPlaceHolder()) ?>" value="<?php echo $t_detail->nilai->EditValue ?>"<?php echo $t_detail->nilai->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detail" data-field="x_nilai" name="o<?php echo $t_detail_grid->RowIndex ?>_nilai" id="o<?php echo $t_detail_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($t_detail->nilai->OldValue) ?>">
<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_detail_grid->RowCnt ?>_t_detail_nilai" class="form-group t_detail_nilai">
<input type="text" data-table="t_detail" data-field="x_nilai" name="x<?php echo $t_detail_grid->RowIndex ?>_nilai" id="x<?php echo $t_detail_grid->RowIndex ?>_nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->nilai->getPlaceHolder()) ?>" value="<?php echo $t_detail->nilai->EditValue ?>"<?php echo $t_detail->nilai->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_detail_grid->RowCnt ?>_t_detail_nilai" class="t_detail_nilai">
<span<?php echo $t_detail->nilai->ViewAttributes() ?>>
<?php echo $t_detail->nilai->ListViewValue() ?></span>
</span>
<?php if ($t_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_detail" data-field="x_nilai" name="x<?php echo $t_detail_grid->RowIndex ?>_nilai" id="x<?php echo $t_detail_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($t_detail->nilai->FormValue) ?>">
<input type="hidden" data-table="t_detail" data-field="x_nilai" name="o<?php echo $t_detail_grid->RowIndex ?>_nilai" id="o<?php echo $t_detail_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($t_detail->nilai->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_detail" data-field="x_nilai" name="ft_detailgrid$x<?php echo $t_detail_grid->RowIndex ?>_nilai" id="ft_detailgrid$x<?php echo $t_detail_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($t_detail->nilai->FormValue) ?>">
<input type="hidden" data-table="t_detail" data-field="x_nilai" name="ft_detailgrid$o<?php echo $t_detail_grid->RowIndex ?>_nilai" id="ft_detailgrid$o<?php echo $t_detail_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($t_detail->nilai->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_detail->anggota_id->Visible) { // anggota_id ?>
		<td data-name="anggota_id"<?php echo $t_detail->anggota_id->CellAttributes() ?>>
<?php if ($t_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_detail_grid->RowCnt ?>_t_detail_anggota_id" class="form-group t_detail_anggota_id">
<?php
$wrkonchange = trim(" " . @$t_detail->anggota_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t_detail->anggota_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t_detail_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" id="sv_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $t_detail->anggota_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->anggota_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t_detail->anggota_id->getPlaceHolder()) ?>"<?php echo $t_detail->anggota_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detail" data-field="x_anggota_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_detail->anggota_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" id="x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($t_detail->anggota_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" id="q_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $t_detail->anggota_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft_detailgrid.CreateAutoSuggest({"id":"x<?php echo $t_detail_grid->RowIndex ?>_anggota_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_detail->anggota_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_detail_grid->RowIndex ?>_anggota_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" id="s_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $t_detail->anggota_id->LookupFilterQuery(false) ?>">
</span>
<input type="hidden" data-table="t_detail" data-field="x_anggota_id" name="o<?php echo $t_detail_grid->RowIndex ?>_anggota_id" id="o<?php echo $t_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($t_detail->anggota_id->OldValue) ?>">
<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_detail_grid->RowCnt ?>_t_detail_anggota_id" class="form-group t_detail_anggota_id">
<?php
$wrkonchange = trim(" " . @$t_detail->anggota_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t_detail->anggota_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t_detail_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" id="sv_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $t_detail->anggota_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->anggota_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t_detail->anggota_id->getPlaceHolder()) ?>"<?php echo $t_detail->anggota_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detail" data-field="x_anggota_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_detail->anggota_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" id="x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($t_detail->anggota_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" id="q_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $t_detail->anggota_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft_detailgrid.CreateAutoSuggest({"id":"x<?php echo $t_detail_grid->RowIndex ?>_anggota_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_detail->anggota_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_detail_grid->RowIndex ?>_anggota_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" id="s_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $t_detail->anggota_id->LookupFilterQuery(false) ?>">
</span>
<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_detail_grid->RowCnt ?>_t_detail_anggota_id" class="t_detail_anggota_id">
<span<?php echo $t_detail->anggota_id->ViewAttributes() ?>>
<?php echo $t_detail->anggota_id->ListViewValue() ?></span>
</span>
<?php if ($t_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_detail" data-field="x_anggota_id" name="x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" id="x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($t_detail->anggota_id->FormValue) ?>">
<input type="hidden" data-table="t_detail" data-field="x_anggota_id" name="o<?php echo $t_detail_grid->RowIndex ?>_anggota_id" id="o<?php echo $t_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($t_detail->anggota_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_detail" data-field="x_anggota_id" name="ft_detailgrid$x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" id="ft_detailgrid$x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($t_detail->anggota_id->FormValue) ?>">
<input type="hidden" data-table="t_detail" data-field="x_anggota_id" name="ft_detailgrid$o<?php echo $t_detail_grid->RowIndex ?>_anggota_id" id="ft_detailgrid$o<?php echo $t_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($t_detail->anggota_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_detail_grid->ListOptions->Render("body", "right", $t_detail_grid->RowCnt);
?>
	</tr>
<?php if ($t_detail->RowType == EW_ROWTYPE_ADD || $t_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft_detailgrid.UpdateOpts(<?php echo $t_detail_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t_detail->CurrentAction <> "gridadd" || $t_detail->CurrentMode == "copy")
		if (!$t_detail_grid->Recordset->EOF) $t_detail_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t_detail->CurrentMode == "add" || $t_detail->CurrentMode == "copy" || $t_detail->CurrentMode == "edit") {
		$t_detail_grid->RowIndex = '$rowindex$';
		$t_detail_grid->LoadDefaultValues();

		// Set row properties
		$t_detail->ResetAttrs();
		$t_detail->RowAttrs = array_merge($t_detail->RowAttrs, array('data-rowindex'=>$t_detail_grid->RowIndex, 'id'=>'r0_t_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t_detail->RowAttrs["class"], "ewTemplate");
		$t_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t_detail_grid->RenderRow();

		// Render list options
		$t_detail_grid->RenderListOptions();
		$t_detail_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_detail_grid->ListOptions->Render("body", "left", $t_detail_grid->RowIndex);
?>
	<?php if ($t_detail->akun_id->Visible) { // akun_id ?>
		<td data-name="akun_id">
<?php if ($t_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_detail_akun_id" class="form-group t_detail_akun_id">
<?php
$wrkonchange = trim(" " . @$t_detail->akun_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t_detail->akun_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t_detail_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" id="sv_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" value="<?php echo $t_detail->akun_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->akun_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t_detail->akun_id->getPlaceHolder()) ?>"<?php echo $t_detail->akun_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detail" data-field="x_akun_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_detail->akun_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_detail_grid->RowIndex ?>_akun_id" id="x<?php echo $t_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($t_detail->akun_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" id="q_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" value="<?php echo $t_detail->akun_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft_detailgrid.CreateAutoSuggest({"id":"x<?php echo $t_detail_grid->RowIndex ?>_akun_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_detail->akun_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_detail_grid->RowIndex ?>_akun_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" id="s_x<?php echo $t_detail_grid->RowIndex ?>_akun_id" value="<?php echo $t_detail->akun_id->LookupFilterQuery(false) ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_t_detail_akun_id" class="form-group t_detail_akun_id">
<span<?php echo $t_detail->akun_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_detail->akun_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_detail" data-field="x_akun_id" name="x<?php echo $t_detail_grid->RowIndex ?>_akun_id" id="x<?php echo $t_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($t_detail->akun_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_detail" data-field="x_akun_id" name="o<?php echo $t_detail_grid->RowIndex ?>_akun_id" id="o<?php echo $t_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($t_detail->akun_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_detail->nilai->Visible) { // nilai ?>
		<td data-name="nilai">
<?php if ($t_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_detail_nilai" class="form-group t_detail_nilai">
<input type="text" data-table="t_detail" data-field="x_nilai" name="x<?php echo $t_detail_grid->RowIndex ?>_nilai" id="x<?php echo $t_detail_grid->RowIndex ?>_nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->nilai->getPlaceHolder()) ?>" value="<?php echo $t_detail->nilai->EditValue ?>"<?php echo $t_detail->nilai->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_detail_nilai" class="form-group t_detail_nilai">
<span<?php echo $t_detail->nilai->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_detail->nilai->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_detail" data-field="x_nilai" name="x<?php echo $t_detail_grid->RowIndex ?>_nilai" id="x<?php echo $t_detail_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($t_detail->nilai->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_detail" data-field="x_nilai" name="o<?php echo $t_detail_grid->RowIndex ?>_nilai" id="o<?php echo $t_detail_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($t_detail->nilai->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_detail->anggota_id->Visible) { // anggota_id ?>
		<td data-name="anggota_id">
<?php if ($t_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_detail_anggota_id" class="form-group t_detail_anggota_id">
<?php
$wrkonchange = trim(" " . @$t_detail->anggota_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t_detail->anggota_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t_detail_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" id="sv_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $t_detail->anggota_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->anggota_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t_detail->anggota_id->getPlaceHolder()) ?>"<?php echo $t_detail->anggota_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detail" data-field="x_anggota_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_detail->anggota_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" id="x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($t_detail->anggota_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" id="q_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $t_detail->anggota_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft_detailgrid.CreateAutoSuggest({"id":"x<?php echo $t_detail_grid->RowIndex ?>_anggota_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_detail->anggota_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_detail_grid->RowIndex ?>_anggota_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" id="s_x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $t_detail->anggota_id->LookupFilterQuery(false) ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_t_detail_anggota_id" class="form-group t_detail_anggota_id">
<span<?php echo $t_detail->anggota_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_detail->anggota_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_detail" data-field="x_anggota_id" name="x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" id="x<?php echo $t_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($t_detail->anggota_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_detail" data-field="x_anggota_id" name="o<?php echo $t_detail_grid->RowIndex ?>_anggota_id" id="o<?php echo $t_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($t_detail->anggota_id->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_detail_grid->ListOptions->Render("body", "right", $t_detail_grid->RowCnt);
?>
<script type="text/javascript">
ft_detailgrid.UpdateOpts(<?php echo $t_detail_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t_detail->CurrentMode == "add" || $t_detail->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t_detail_grid->FormKeyCountName ?>" id="<?php echo $t_detail_grid->FormKeyCountName ?>" value="<?php echo $t_detail_grid->KeyCount ?>">
<?php echo $t_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t_detail_grid->FormKeyCountName ?>" id="<?php echo $t_detail_grid->FormKeyCountName ?>" value="<?php echo $t_detail_grid->KeyCount ?>">
<?php echo $t_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t_detail->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft_detailgrid">
</div>
<?php

// Close recordset
if ($t_detail_grid->Recordset)
	$t_detail_grid->Recordset->Close();
?>
<?php if ($t_detail_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($t_detail_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t_detail_grid->TotalRecs == 0 && $t_detail->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t_detail_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t_detail->Export == "") { ?>
<script type="text/javascript">
ft_detailgrid.Init();
</script>
<?php } ?>
<?php
$t_detail_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$t_detail_grid->Page_Terminate();
?>

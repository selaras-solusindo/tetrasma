<?php

// jurnalm_id
// no_buktim
// tglm
// ketm

?>
<?php if ($t_jurnalm->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $t_jurnalm->TableCaption() ?></h4> -->
<table id="tbl_t_jurnalmmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $t_jurnalm->TableCustomInnerHtml ?>
	<tbody>
<?php if ($t_jurnalm->jurnalm_id->Visible) { // jurnalm_id ?>
		<tr id="r_jurnalm_id">
			<td><?php echo $t_jurnalm->jurnalm_id->FldCaption() ?></td>
			<td<?php echo $t_jurnalm->jurnalm_id->CellAttributes() ?>>
<span id="el_t_jurnalm_jurnalm_id">
<span<?php echo $t_jurnalm->jurnalm_id->ViewAttributes() ?>>
<?php echo $t_jurnalm->jurnalm_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_jurnalm->no_buktim->Visible) { // no_buktim ?>
		<tr id="r_no_buktim">
			<td><?php echo $t_jurnalm->no_buktim->FldCaption() ?></td>
			<td<?php echo $t_jurnalm->no_buktim->CellAttributes() ?>>
<span id="el_t_jurnalm_no_buktim">
<span<?php echo $t_jurnalm->no_buktim->ViewAttributes() ?>>
<?php echo $t_jurnalm->no_buktim->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_jurnalm->tglm->Visible) { // tglm ?>
		<tr id="r_tglm">
			<td><?php echo $t_jurnalm->tglm->FldCaption() ?></td>
			<td<?php echo $t_jurnalm->tglm->CellAttributes() ?>>
<span id="el_t_jurnalm_tglm">
<span<?php echo $t_jurnalm->tglm->ViewAttributes() ?>>
<?php echo $t_jurnalm->tglm->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_jurnalm->ketm->Visible) { // ketm ?>
		<tr id="r_ketm">
			<td><?php echo $t_jurnalm->ketm->FldCaption() ?></td>
			<td<?php echo $t_jurnalm->ketm->CellAttributes() ?>>
<span id="el_t_jurnalm_ketm">
<span<?php echo $t_jurnalm->ketm->ViewAttributes() ?>>
<?php echo $t_jurnalm->ketm->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>

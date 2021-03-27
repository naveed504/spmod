<style type="text/css">
	
.mrg_custom_1
{
	margin-bottom:10px !important;
}
</style>

<div id="overlay_customize_invoice">
	<div class="col-sm-12 padd_right_input inner_invoice_sidebar">
		<div class="col-sm-12 customize_ur_invoice padd_left_input">
			<div class="pull-left col-xs-10 p-xs-0">Customize your Sale Quotation</div>
			<div class="pull-right col-xs-2"><button type="button" id="indexpage_icon" class="close pull-right modal_invoice_close modal_invoice11">×</button></div>
			<div class="clear10"></div>
		</div>
		<div class="col-sm-12 padd_left_input">
		
			<h4>Fields</h4>
		</div>
		<!-- <div class="col-sm-12 padd_left_input">
			<div class="bg">
				<div class="chiller_cb">
					<input id="cog_slide_01" class="qo-setting-save-d" qo-attr-name="sq_number" type="checkbox" <?php //echo $getQoSettings[0]['sq_number'] ? 'checked' : '' ?>  />
					<label for="cog_slide_01">Sale Quotation no</label>
					<span></span>
				</div>
			</div>
		</div> -->
		<div class="col-sm-12 padd_left_input">
			<div class="bg">
				<div class="chiller_cb">
					<input id="id_discounttype" class="qo-setting-save-d" qo-attr-name="discounttype" type="checkbox" <?php echo $getQoSettings[0]['discounttype'] ? 'checked' : '' ?>  />
					<label for="id_discounttype">Discount type</label>
					<span></span>
				</div>
			</div>
		</div>
		<div class="clear10"></div>
		<div class="col-sm-12 padd_left_input">
			<div class="bg">
				<div class="chiller_cb">
					<input id="id_currency" class="qo-setting-save-d" qo-attr-name="currency" type="checkbox" <?php echo $getQoSettings[0]['currency'] ? 'checked' : '' ?>  />
					<label for="id_currency">Qoute currency</label>
					<span></span>
				</div>
			</div>
		</div>
		<div class="col-sm-12 padd_left_input">
			<div class="bg">
				<div class="chiller_cb">
					<input id="id_terms" class="qo-setting-save-d" qo-attr-name="terms" type="checkbox" <?php echo $getQoSettings[0]['terms'] ? 'checked' : '' ?>  />
					<label for="id_terms">Terms</label>
					<span></span>
				</div>
			</div>
		</div>
		<div class="col-sm-12 padd_left_input">
			<div class="bg">
				<div class="chiller_cb">
					<input id="id_sku" class="qo-setting-save-d" qo-attr-name="sku" type="checkbox" <?php echo $getQoSettings[0]['sku'] ? 'checked' : '' ?>  />
					<label for="id_sku">SKU</label>
					<span></span>
				</div>
			</div>
		</div>
		<div class="col-sm-12 padd_left_input">
			<div class="bg">
				<div class="chiller_cb">
					<input id="id_shipping_fee" class="qo-setting-save-d" qo-attr-name="shipping_fee" type="checkbox" <?php echo $getQoSettings[0]['shipping_fee'] ? 'checked' : '' ?>  />
					<label for="id_shipping_fee">Shipping Fee</label>
					<span></span>
				</div>
			</div>
		</div>
		<?php 
			$crewHide = (!empty($getQoSettings[0]['crew']) ? '' : 'hide-d');
			$custom_2 = (!empty($getQoSettings[0]['custom_2']) ? '' : 'hide-d');
			$custom_3 = (!empty($getQoSettings[0]['custom_3']) ? '' : 'hide-d');
			$custom_4 = (!empty($getQoSettings[0]['custom_4']) ? '' : 'hide-d');
			$custom   = (!empty($getQoSettings[0]['custom']) ? '' : 'hide-d');
		?>
		<!-- -- 1st input-- -->
		<div class="add-input-d">	
			<!-- <div class="clear10 hide-d"></div> -->
			<div class="col-sm-12 input_checkbox_inline p0 show-hide-input-d mrg_custom_1 <?php echo $crewHide; ?>">
				<div class="col-sm-1 col-xs-1 bg padd_left_input">
					<div class="chiller_cb">
						<input id="cog_slide_006_new" class="qo-setting-save-d" qo-attr-name="crew" type="checkbox" <?php echo $getQoSettings[0]['crew'] ? 'checked' : '' ?>  />
						<label for="cog_slide_006_new">&nbsp;</label>
						<span></span>
					</div>
				</div>
				<div class="col-sm-9 col-xs-12 padd_left_input place-main-s">
					<input type="text" class="form-control qo-field-crew-d my-place-s" placeholder="Custom Field" name="" value="<?php echo $getQoSettings[0]['crew_field'] ? $getQoSettings[0]['crew_field'] : '' ?>" qo-attr-name="crew" />
				<!-- <div class="clear10 <?php //echo $crewHide; ?>"></div> -->
				</div>
			</div>
			
		<!-- --custom field 2 start-- -->
			<div class="col-sm-12 input_checkbox_inline p0 show-hide-input-d mrg_custom_1 <?php echo $custom_2; ?>">
				<div class="col-sm-1 col-xs-1 bg padd_left_input">
					<div class="chiller_cb">
						<input id="cog_slide_009_new" class="qo-setting-save-d" qo-attr-name="custom2" type="checkbox" <?php echo $getQoSettings[0]['custom_2'] ? 'checked' : '' ?>  />
						<label for="cog_slide_009_new">&nbsp;</label>
						<span></span>
					</div>
				</div>
				<div class="col-sm-9 col-xs-12 padd_left_input rel place-main-s">
					<input type="text" class="form-control qo-field-custom2-d my-place-s" placeholder="Custom Field" name="" value="<?php echo $getQoSettings[0]['custom_field_2'] ? $getQoSettings[0]['custom_field_2'] : '' ?>" qo-attr-name="custom2" />
					<!-- <span class="fa fa-trash input-trach-s input-del-d"></span>	 -->
				<!-- <div class="clear10 <?php //echo $custom_2; ?>"></div> -->
				</div>
			</div>
			
			<!-- --custom field 3 start-- -->
			<div class="col-sm-12 input_checkbox_inline p0 show-hide-input-d mrg_custom_1 <?php echo $custom_3; ?>">
				<div class="col-sm-1 col-xs-1 bg padd_left_input">
					<div class="chiller_cb">
						<input id="cog_slide_0010_new" class="qo-setting-save-d" qo-attr-name="custom3" type="checkbox" <?php echo $getQoSettings[0]['custom_3'] ? 'checked' : '' ?>  />
						<label for="cog_slide_0010_new">&nbsp;</label>
						<span></span>
					</div>
				</div>
				<div class="col-sm-9 col-xs-12 padd_left_input place-main-s">
					<input type="text" class="form-control qo-field-custom3-d my-place-s" placeholder="Custom Field" name="" value="<?php echo $getQoSettings[0]['custom_field_3'] ? $getQoSettings[0]['custom_field_3'] : '' ?>" qo-attr-name="custom3" />
				<!-- <div class="clear10 <?php //echo $custom_3; ?>"></div> -->	
				</div>
			</div>
			<div class="clearfix"></div>
			<!-- --custom field 4 end-- -->
			<div class="col-sm-12 input_checkbox_inline p0 show-hide-input-d mrg_custom_1 <?php echo $custom; ?>">
				<div class="col-sm-1 col-xs-1 bg padd_left_input">
					<div class="chiller_cb">
						<input id="cog_slide_0012_new" class="qo-setting-save-d" qo-attr-name="custom_field" type="checkbox" <?php echo $getQoSettings[0]['custom'] ? 'checked' : '' ?>  />
						<label for="cog_slide_0012_new">&nbsp;</label>
						<span></span>
					</div>
				</div>
				<div class="col-sm-9 col-xs-12 padd_left_input place-main-s">
					<input type="text" class="form-control qo-field-custom_field-d my-place-s" placeholder="Custom Field" name="" value="<?php echo $getQoSettings[0]['custom_field'] ? $getQoSettings[0]['custom_field'] : '' ?>" qo-attr-name="custom_field" />
				<!-- <div class="clear10 <?php //echo $custom; ?>"></div> -->		
				</div>
			</div>
		</div>
		<!-- --add another inputs--	 -->
		<div class="clear10 hide-d"></div>
		<div class="col-sm-12 padd_left_input hide-show-another-d">
			<i class="fa fa-plus plus_icon_add"></i>
			<a href="#" class="add_another_text add-another-field-d">Add another field</a>
			<div class="clear10"></div>
		</div>


		<!-- --custom field 4 end-- -->
		<!-- <div class="clear10"></div> -->
		<!-- <div class="col-sm-12 padd_left_input add-another-block-d" style="display:<?php //echo $getQoSettings[0]['custom'] ? 'none' : '';?>">
			<i class="fa fa-plus plus_icon_add"></i>
			<a href="#" class="add_another_text add-another-field-d" qo-attr-name="custom_field">Add another field</a>
			<div class="clear10"></div>
		</div> -->
		<!-- <div class="col-sm-12 input_checkbox_inline p0 custome-field-show-d hide-d" style="display:<?php //echo $getQoSettings[0]['custom'] ? 'block' : '';?>">
			<div class="col-sm-1 col-xs-12 bg padd_left_input">
				<div class="chiller_cb">
					<input id="qo_custom_field_d" class="qo-setting-save-d" qo-attr-name="custom_field" type="checkbox" <?php //echo $getQoSettings[0]['custom'] ? 'checked' : '' ?> />
					<label for="qo_custom_field_d">&nbsp;</label>
					<span></span>
				</div>
			</div>
			<div class="col-sm-9 col-xs-12 padd_left_input">
				<input type="text" class="form-control qo-field-custom_field-d" name="custome_field" qo-attr-name="custom_field" value="<?php //echo $getQoSettings[0]['custom_field'] ? $getQoSettings[0]['custom_field'] : '' ?>" />
			</div>
		</div> -->
		<div class="clear20"></div>
	</div>
	<div class="clear20"> </div>
</div>
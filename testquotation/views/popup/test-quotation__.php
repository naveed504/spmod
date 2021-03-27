<style>
    .quo-tax-s span{display: inherit !important;}
    .vat-tax-s span{display: inherit !important;}
</style>

  $("#quotation_sorting tbody tr input").prop("disabled",true);
    // $('#quotation_sorting tbody tr').click(function (){
    // $(this).siblings().removeClass('active');
    // if($(this).siblings().find('input.sh').val() == '' && $(this).siblings().find('input.am').val() == ''){
    // $(this).siblings().find('input').prop('disabled', true);
    // }
    // $(this).addClass("active");
    // $('tr.active').find('input').removeAttr('disabled');
    // })
 
<form action="<?php echo base_url().'save-test-form';?>" method="post"  autocomplete="off" class="railway-font-s" enctype="multipart/form-data" id="modeification">
<div class="modal modal_pop_journal p0" id="quotation_pop_d">
    <div class="modal-dialog width_modal_journal height100-s">
        <div class="modal-content quotation_container height100-s">
            <div class="modal-header journal_modal_header">
                <div class="pull-left">
                    <div class="dropdown invoice_icon_drop">
                        <button type="button" class="btn btn-primary dropdown-toggle invoice_tbl_btn" data-toggle="dropdown">
                            <img src="<?php echo base_url() ;?>public/admin/images/history_icon.png" class="history_icon" alt="">
                        </button>
                        <div class="dropdown-menu invoicetop_dropdown_box">
                            <div class="col-sm-12 pr-0">
                                <h4> Recent Sales Quotation</h4>
                                <div class="invoice_topleft_table">
                                    <table width="100%" border="0" cellspacing="2" cellpadding="2">
                                      <tbody id="showdata">
                                          
                                      </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                
                <h4 class="modal-title journal_pop_hdg pull-left" >Sales Quotation#
                    <span id="sequence_no_d">
                 <?php if(isset($result[0]['quotation_index_id'])){ echo $result[0]['quotation_index_id']; }else{
                   echo  $get__quotation_no_ ;
                 } ?>
                    </span>
                </h4>
              


                <div id="button_invoice_popup">
                    <button type="button" class="close pull-righ close_account_modal cancl-popup-d">
                        <img src="<?php echo base_url() ;?>public/admin/images/cancel_try.png">
                    </button>

                    <button type="button" class="close pull-right" module_name="" data-module="Sale Quotation Page" id="help_sign">
                        <img src="">
                    </button>
                    <button type="button" class="close pull-right" id="customize_fields_qo_d">
                        <img src="<?php echo base_url().'public/admin/'; ?>images/cog_try.png" />
                    </button>
                 
                </div>
            </div>

                   

            <div class="modal-body over_flowscroll invoice_modal_label modal-body-padding-s">
                <div class="add-lock-s ">
                <div class="invocie_box_bgtop">
                    <div class="col-sm-12 p-xs-0">
                        
                            <div class="col-sm-3 padd_left_input p0 p-xs-15 auto-w-s">
                                <label>Customer</label>
                              
                                        <div class="custom-selector-s get_cus_id_d">
                                           
                                            <div class="selectize-custom place-main-s">
                                                <input type="text" placeholder="Select Customer" name="cus_name" class="" value="<?php if(isset($result[0]['cus_name'])){ echo $result[0]['cus_name']; } ?>"  />
                                               
                                            </div>
                                           
                                        </div>
                   
                            </div>

                             <input type="hidden" name="quotation_index_id" value="<?php if(isset($result[0]['quotation_index_id'])){ echo $result[0]['quotation_index_id']; } ?>">
                             <input type="hidden" name="trx_id" value="<?php if(isset($result[0]['quotation_index_id'])){ echo $result[0]['quotation_index_id']; } ?>">
                              <input type="hidden" name="quotation_index_id" value="<?php if(isset($result[0]['quotation_index_id'])){ echo $result[0]['quotation_index_id']; } ?>">

                <div class="col-sm-3 required-field-s clr-both">
    <label>Email</label>
    <div class="form-group place-main-s main-error-s">
        <input type="text" name="email" id="email_d" class="form-control my-place-s email-d" placeholder="Email (Seprate emails with a comma)" value="<?php if(isset($result[0]['email'])){ echo $result[0]['email']; } ?>">
        <div class="padd_right_input pull-right">
            <div class="form-check pull-right">
                
                <div class="dropdown text-right">
                    <button type="button" class="btn btn-primary dropdown-toggle invoice_bcc_btn cc_bcc_qoutation mar-top_s" data-toggle="dropdown">
                    <span class="cc-d">cc</span> / <span class="bcc-d">bcc</span>
                    </button>
                    <div class="dropdown-menu bcc_dropdown_box">
                        <div class="col-sm-12 place-main-s">
                            <div class="form-group">
                                <label>Cc </label>
                                <input type="text" name="email_cc" value="" class="form-control my-place-s email_cc_d" placeholder="Email (Seprate emails with a comma)">
                            </div>
                        </div>
                        <div class="col-sm-12 place-main-s">
                            <div class="form-group">
                                <label>Bcc </label>
                                <input type="text" name="email_bcc" value="" class="form-control my-place-s email_bcc_d" placeholder="Email (Seprate emails with a comma)">
                            </div>
                        </div>
                        <div class="clear5"></div>
                        <div class="col-sm-6">
                            <a href="#" class="btn pull-left btn_save btn_focus_colr_black_s ccBc_cancel_d">Cancel</a>
                        </div>
                        <div class="col-sm-6"><a href="#" class="btn pull-right btn_save btn_focus_colr_black_s ccBc_cancel_d">Done</a></div>
                        <div class="clear20"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                            <div class="col-sm-2 send_later_text_s p0">
                                <div class="clear10 visible-xs hidden-sm"></div>
                                <div class="col-xs-6 padd_left_input send_later_align">
                                    <label class="hide-xs-s">&nbsp;</label>
                                    <div class=" " id="send_later">
                                        <input id="qoutation_qbo_01" name="send_later" value="1" type="checkbox" ><label for="qoutation_qbo_01">Send later</label>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                           
                              
                            <!-- ERROR MESSAGE SHOW -->
                            <?php $this->load->view('pages/error-message-box'); ?>
                            <?php $this->load->view('pages/error-message-box-copy'); ?>
                            <!-- ERROR MESSAGE SHOW -->
                            <div class="clear20 hid-xs-s"></div>
                            <div class="col-sm-2 padd_left_input">
                                <div class="form-group" style="height: 170px;">
                                    <label>Biling address </label>
                                    <textarea name="billing_address" id="billing_address_d" class="form-control textarea_credit text-area-s"><?php if(isset($result[0]['billing_address'])){ echo $result[0]['billing_address']; } ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-2 padd_left_input">
                                 <div class="form-group">
                                    <label>Sale Quotation Date </label>
                                    <div class="ui calendar datepicker_new" id="quotation_date_d">
                                        <div class="ui input left icon">
                                            <input class="date_as_od_std_d" name="quo_date" type="text" value="<?php if(isset($result[0]['quo_date'])){ echo $result[0]['quo_date']; } ?>" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group bootstrap_select currency-attr-d drop-hit-s" style="display:">
                                    <label>Quote Currency</label>
                                    <select name="quo_currency" id="currency_d" class="form-control selectpicker cus-lines-s">

                                   
                                        <div class="form-check pull-right">
                                             <option><?php if(isset($result[0]['quo_currency'])){ echo $result[0]['quo_currency']; }else{
                                            echo " Select Currency";
                                        } ?></option>
                                        <option data-rate="" curr-default-id="" value="usd">USD</option>
                                        <option data-rate="" curr-default-id="" value="pkr">PKR</option>
                                        <option data-rate="" curr-default-id="" value="lbr">LBR</option>
                                   
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" id="lbp_curr_rate_d" def-curr-id="" value="">
                            <div class="col-sm-2 padd_left_input">
                                <div class="form-group">
                                    <label>Expiration Date </label>
                         <div class="ui calendar datepicker_new" id="quotation_expiry_date_d">
                                        <div class="ui input left icon">
                                            <input type="text" class="date_as_od_std_d"  name="exp_date" value="<?php if(isset($result[0]['exp_date'])){ echo $result[0]['exp_date']; } ?>">
                                        </div>
                                    </div>
                                </div>
                              
                                <div class="form-group bootstrap_select drop-hit-s discounttype-attr-d" style=" ">
                                    <label>Discount Type</label>
                                    <select name="discount_type" id="discount_total_d" class="form-control selectpicker cus-lines-s">
                                        <option><?php if(isset($result[0]['discount_type'])){ echo $result[0]['discount_type']; }else{
                                            echo " Select Discount";
                                        } ?></option>
                                       
                                        <option value="inlie-discount" >In-line Discount</option>
                                        <option value="discount-on-total" >Discount on totals</option>   
                                    </select>
                                </div>
                            </div>
                            <!-- shipping fee from setting hide show -->
                          
                            <div class="col-sm-2 padd_left_input shipping_fee-attr-d ">
                                <div class="form-group">
                                    <label>Shipping Fee</label>
                                    <input type="text" name="shipping_fee" class="form-control" value="<?php if(isset($result[0]['shipping_fee'])){ echo $result[0]['shipping_fee']; } ?>">
                                </div>
                            </div>
                            <!-- //shipping fields start -->
                            <div class="col-sm-2 padd_left_input" >
                                <div class="form-group">
                                    <label>Shipping Address </label>
                                    <input type="text" name="shipping_address" placeholder="Shipping address" class="form-control my-place-s" value="<?php if(isset($result[0]['shipping_address'])){ echo $result[0]['shipping_address']; } ?>">
                                </div>
                            </div>
                            <div class="col-sm-2 padd_left_input">
                                <div class="form-group">
                                    <label>Ship Via </label>
                                    <input type="text" name="ship_via" placeholder="Ship via" class="form-control my-place-s" value="<?php if(isset($result[0]['ship_via'])){ echo $result[0]['ship_via']; } ?>">
                                </div>
                            </div>
                            <!-- shipping fields end -->
                          
                           <!-- //..............terms -->
                          <div class="col-sm-2 padd_left_input terms-attr-d ">
                           <div class="form-group">
                              <label>Terms</label>
                              
                              <select name="terms" id="" class="form-control selectpicker cus-lines-s">
                                        <option value="" ><?php if(isset($result[0]['ship_via'])){ echo $result[0]['ship_via']; } ?></option>
                                        <option value="net 5" >Net 5</option>
                                        <option value="net 10" >Net 10</option>   
                                    </select>
                           </div>
                        </div>
                           <!-- ................ -->
                          
                           
                            <div class="col-sm-2 padd_left_input qo-field-custom2-d custom2-attr-d" style="display:">
                                <div class="form-group">
                                    <label>Setting</label>
                                    <input type="text" name="setting" class="form-control" value="<?php if(isset($result[0]['setting'])){ echo $result[0]['setting']; } ?>">
                                </div>
                            </div>
                            <div class="col-sm-2 padd_left_input qo-field-crew-d crew-attr-d" style="">
                                <div class="form-group">
                                    <label>Custom 2</label>
                                    <input type="text" name="custom_2" class="form-control" value="<?php if(isset($result[0]['custom_2'])){ echo $result[0]['custom_2']; } ?>">
                                </div>
                            </div>
                            <!-- --custom field 2-- -->
                          
                            <!-- --custom field 3-- -->
                           
                    </div>
                    <div class="clearfix"></div>
                </div>
              
              
   <div class="col-sm-12">
    <div class="clear10"></div>
    <div class="clear10"></div>
    <div class="bottom_area_invoice">
        <div class="table_main">
            <div class="form-group pull-right amounts_tbl_select drop-hit-s">
                <div class="col-xs-5 col-sm-4 p0 p-xs-15">
                    <label class="lbl_normal3">Amounts are</label>
                </div>
                <div class="line2-s"></div>
                <div class="col-xs-7 col-sm-8 padd_right_input bootstrap_select tax-bg pl-0-xs-s ">
                    <select name="tax_type" class="form-control selectpicker" id="tax_type_d">
                       <option><?php if(isset($result[0]['tax_type'])){ echo $result[0]['tax_type']; }else{
                                            echo " Select Amounts";
                                        } ?></option>
                            <option value="inclusive">Inclusve Tax</option>
                            <option value="excllusive">Exclusive Tax</option>
                       
                    </select>
                </div>
            </div>
            <div class="clear10"></div>
            <div class="h-xs-300">
                <table width="100%" class="table table-wid table-bordered table_add_new_row invoice_row_input resizable_quotation quotation-table-clear-d quotation_table_d recur_row_input w-xs-1170 show_quot" id="quotation_sorting" >
                    <thead>
                        <tr>
                            <th width="3%" class="" align="center" valign="middle" class="text-center">&nbsp;</th>
                            <th width="3%" align="center" valign="middle" class="text-center">#</th>
                          <th width="17%" class="text-left" valign="middle">Product/Service</th>
                            <th width="24%" class="sku-d " align="center" valign="middle">SKU</th>
                            <th width="24%" class="" align="center" valign="middle">Description</th>
                            <th width="10%" class="" align="center" valign="middle">QTY</th>
                            <th width="10%" class="" align="center" valign="middle">Unit Price</th>
                            <th width="10%" class="dis_type_d hide-d" align="center" valign="middle">Discount Type</th>
                            <th width="10%" class="dis_type_d hide-d" align="center" valign="middle">Discount</th>
                            <th width="10%" class="tax_type_d hide-d" align="center" valign="middle">Tax</th>
                            <th width="10%" class="" align="center" valign="middle">Amount(<span class="currency_symbol_d">LBP</span>)</th>
                            <th width="3%" class="" align="center" valign="middle"></th>
                        </tr>
                    </thead>
                    <tbody class="auto-w-s" class="show_quot">

                      

                      


<?php 


if(isset($detail)){

                      for($i=0; $i<count($detail); $i++){?>
                        <tr class="statuscheck new_r" id="1">
                           
                         
                            <td align="center" valign="middle" class="add_movable text-center padding_end" id="add_more">
                                <img src="<?php echo base_url() ;?>public/admin/images/toggle.png" />
                            </td>
                            <td align="center" valign="middle" class="padding_end">
                            </td>
                    <td>
                        <select name="product__id_" id="showproducts" class="form-control selectpicker cus-lines-s">
                                        
                                       
                                    </select>
                            </td>
                                <input type="hidden" name="p_quotation_id[]" class="form-control des_d tableInput sh" value="<?php if(isset($detail[$i]['p_quotation_id'])){ echo $detail[$i]['p_quotation_id'];}?>">
                               
                         
                            <td class="text-left show_des_d selector-text-s move-up-down-row-d" valign="middle">
                                <input type="text" name="description[]" class="form-control des_d tableInput sh" value="<?php if(isset($detail[$i]['description'])){ echo $detail[$i]['description'];}?>">
                               
                            </td>
                            <td class='show_inline_vat_d move-up-down-row-d vat_type_d'>
                               
                          <input name="qty[]" class="form-control qty_d on_hover_tooltip1 tableInput" type="text" id="qty_d" value="<?php if(isset($detail[$i]['qty'])){ echo $detail[$i]['qty'];}?>"> 
                                
                               
                            </td>
                         
                            <td class="text-left show_rate_d move-up-down-row-d recur_row_input" valign="middle">
                               
                                <input name="rate[]" class="form-control rate_d tableInput" id="rate_d"
                                value="<?php if(isset($detail[$i]['rate'])){ echo $detail[$i]['rate'];}?>" type="text" >
                               
                            </td>
                           
                            
                            
                            <td class="text-left show_tax_d  tax_d tax_type_d hide-d" valign="middle">
                                <select name="tax[]" class="form-control selectpicker" id="tax_d">
                                    <option><?php if(isset($detail[$i]['tax'])){ echo $detail[$i]['tax']; }else{
                                            echo " Select Tax";
                                        } ?></option>
                                  
                                  
                            <option value="10">10 %</option>
                            <option value="15">15 %</option>

                           </select>
                            </td>
                            <td class="text-left show_amount_d move-up-down-row-d last_td_tooltip_s" valign="middle">
                               
                                <input name="amount[]" class="form-control amount_d tableInput am" type="text"  value="<?php if(isset($detail[$i]['amount'])){ echo $detail[$i]['amount'];}?>" >
                               
                            </td>
                            <td align="center" valign="middle" class="padding_end">
                                <button type="button" class="del no-del quo-del-d" id="<?php if(isset($detail[$i]['p_quotation_id'])){ echo $detail[$i]['p_quotation_id'];}?>">
               <img src='<?php echo base_url() ;?>public/admin/images/delete_qbo.png'>
                                </button>
                            </td>
                        </tr> 
<?php }}else{ ?>
          

                     
                         <tr class="statuscheck new_r" id="1">
                            
                           
                            <td align="center" valign="middle" class="add_movable text-center padding_end" id="add_more">
                                 <img src="<?php echo base_url() ;?>public/admin/images/toggle.png" />
                            </td>
                            <td align="center" valign="middle" class="padding_end">
                            </td>
                       <td>
                           <select name="product__id_" id="showproducts" class="form-control selectpicker cus-lines-s" >
                                        
                                       
                                    </select>
                                </td>
                            <td class="text-left show_des_d selector-text-s move-up-down-row-d" valign="middle">
                                <input type="text" name="description[]" class="form-control des_d tableInput sh">
                               
                            </td>
                            <td class="text-left show_qty_d move-up-down-row-d recur_row_input" valign="middle">
                               
                                <input name="qty[]" class="form-control  qty_d on_hover_tooltip1 tableInput" id="qty_d" type="text" >
                               
                            </td>
                            <td class="text-left show_rate_d move-up-down-row-d recur_row_input" valign="middle">
                               
                                <input name="rate[]" class="form-control rate_d tableInput"  id="rate_d" type="text" >
                               
                            </td>
                           <td class="text-left show_tax_d tax_d tax_type_d hide-d" valign="middle">
                                <select name="tax[]" class="form-control selectpicker" id="tax_d">
                                     <option>Select Option</option>
                            <option value="10">10 %</option>
                            <option value="15">15 %</option>
                           </select>
                            </td>
                            <td class="text-left show_amount_d move-up-down-row-d last_td_tooltip_s" valign="middle">
                               
                                <input name="amount[]" class="form-control amount_d tableInput am" type="text"  >
                               
                            </td>
                            <td align="center" valign="middle" class="padding_end">
                                <button type="button" class="del no-del quo-del-d">
                                    <img src='<?php echo base_url() ;?>public/admin/images/delete_qbo.png'>
                                </button>
                            </td>
                        </tr>
<?php }?>






  
                 
                     

                        
                   
                   
                    </tbody>
                </table>
            </div>
        </div>
        
      <tr>
  <span id="show_sub_totsasal_d"></span>
                                         
</tr>
        <div class="clearfix"></div>

</div>
                            <!-- <div class="col-sm-2 p0 text-right">
                                <img class="tax_slide_onclick_credit" src="<?php //echo base_url() ;?>public/admin/images/total_up_down.png">
                            </div> -->
 <div class="clear20"></div>

    <button type="button" class="btn pull-left btn_cancel_form add_line_onclick inv-subtotal1">Add line</button>
    <button type="button" data-attr="clear" class="btn pull-left btn_cancel_form quotation-clear-d">Clear All Line</button>
    <button type="button" class="btn pull-left btn_cancel_form quotation-subtotal-d inv-subtotal">Add Subtotal</button>
    <div class="clear10"></div>


                            <div class="col-xs-12 col-sm-4 col-sm-push-8 invoice_label_colorright padd_right_input credit_total_main p-xs-0 mt-xs mt-lg-40" id="subtotal_qoutation">
                                <div class="col-sm-6 col-xs-6 text-left invoice_label_colorright invoice_label_colorright_font">Subtotal</div>
                                
                                <div class="col-sm-6 col-xs-6 text-right invoice_label_colorright invoice_label_colorright_font p0 ">
                                    <span class="currency_symbol_d"></span>&nbsp; 
                                    <span class="show_sub_total_d">
                                        </span>
                                </div>
                                <input type="hidden" class="sub_total_d" value="" >
                                <div class="clear10"></div>

                                <div class="toggle_tax_main_credit">
                                    <div class="col-sm-12 slide_down_credit p0 hide-d" id="show_hide_inline_dis_d">
                                        <!-- <div class="col-sm-6 col-xs-9 discount_d_flex discount-width p0 cus-width wid-114 drop-hit-s">
                                            <div class="line3-s"></div>
                                            <div class="form-group">
                                                <select id="calcu_disc_type_d" name="sales_discount" class="form-control selectpicker cal_discount-d">
                                                    <option value="1" >Discount percent</option>
                                                    <option value="2" >Discount value</option>
                                                </select>
                                                <input type="text" data-per-flag="" name="sales_discount_val" class="form-control text-right discount_val_d" value="">
                                            </div>
                                        </div> -->
                                        <div class="col-sm-2"></div>
                                       
                                        <div class="col-xs-3 col-sm-4 text-right padd_right_input p-xs-0">
                                            <input type="text" data-discountP="" name="subtotal_discount" id="total_with_dis_d" value="" class="form-control hide_dis_input_d" readonly="readonly">
                                            <input type="text" name="subtotal_discount" id="value_dis_d" value="" class="form-control hide-d h_s_dis_d"> 
                                        </div>
                                    </div>
                                    <div class="clear10 hide-d discount_label_d"></div>
                                     <div class="col-sm-12 slide_up_credit p0 hide-d discount_label_d">
                                        <div class="col-sm-6 col-xs-6 text-right">
                                           Inline Discount Percent
                                        </div>
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-4 col-xs-6 text-right padd_right_input pr-0">
                                            <input type="text" id="inline_dis_percent_d" name="subtotal_discount1" value="" class="form-control" placeholder="0.00" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="clear10 hide-d discount_label_d"></div>
                                    <div class="col-sm-12 slide_up_credit p0 hide-d discount_label_d">
                                        <div class="col-xs-6 col-sm-6 text-right">
                                           Inline Discount Amount
                                        </div>
                                        <div class="col-sm-2"></div>
                                        <div class="col-xs-6 col-sm-4 text-right padd_right_input pr-0">
                                            <input type="text" id="inline_dis_amount_d" name="subtotal_discount1" class="form-control" placeholder="0.00" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="clear10 vat_d"></div>
                                    <div class="col-sm-12 slide_up_credit p0 vat_d">
                                        <div class="col-sm-6 col-xs-6 text-right">
                                           VAT
                                        </div>
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-4 col-xs-6 text-right padd_right_input pr-0">
                                            <input type="text" name="subtotal_discount13" value="" id="toto_vat"
                                            class="form-control vat_total_d" placeholder="0.00" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="clear10 lbp_vat_equi_d"></div>
                                    <div class="col-sm-12 slide_up_credit p0 lbp_vat_equi_d">
                                        <div class="col-xs-6 col-sm-6 text-right">
                                           Vat Equivalent in  
                                        </div>
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-4 col-xs-6 text-right padd_right_input pr-0">
                                            <input type="text" name="subtotal_discount3" id="lbp_vat_equ_d" value="" class="form-control" placeholder="0.00" readonly="readonly">
                                        </div>
                                    </div>
                                </div>
                                <div class="clear10"></div>
                                <hr>
                                <div class="clearfix"></div>
                                <div class="col-sm-6 col-xs-6 text-left invoice_label_colorright invoice_label_colorright_font">Total Amount</div>
                                <div class="col-sm-6 col-xs-6 text-right invoice_label_colorright_font p0 " >
                                    <span class="currency_symbol_d"></span>&nbsp;<span class="show_gtotal_d"></span>
                                </div>
                                <input type="hidden" id="total_withoutComa_d" value="" />
                                <input type="hidden" id="previous-url-d" value="" />
                                <div class="clear10"></div>
                                <hr>
                                <hr>
                                <!-- amount in lbp -->
                                <div class="total-lbp-d">
                                    <div class="clear10"></div>
                                    <div class="clearfix"></div>
                                    <div class="col-sm-6 col-xs-6 text-left invoice_label_colorright invoice_label_colorright_font">Total Amount()</div>
                                    <div class="col-sm-6 col-xs-6 text-right invoice_label_colorright_font p0 show_gtotal_lbp_d"></div>
                                    <div class="clear10"></div>
                                    <hr>
                                    <hr>
                                    <input type="hidden" name="total" id="hidden-total-d" value="">
                                    <div class="clear10"></div>
                                </div>

                            </div>
                             <div class="col-sm-8 col-sm-pull-4  invoice_margin_bottom padd_left_input clr-both p-xs-0">
   
    <div class="col-sm-8 p0 clr-both">
        <div class="clear5"></div>
        <label class="message_label">Message displayed to client </label>
        <div class="clear5"></div>
        <div class="form-group">
            <textarea name="msg_client" class="form-control textarae_h_invoice" rows="5" id="comment" placeholder=""><?php if(isset($result[0]['msg_client'])){ echo $result[0]['msg_client']; } ?></textarea>
        </div>
    </div>
    <div class="col-sm-8 p0">
        <div class="clear5"></div>
        <label class="message_label">Memo </label>
        <div class="clear5"></div>
        <div class="form-group">
            <textarea name="memo" class="form-control textarae_h_invoice" rows="5" id="memo" placeholder=""><?php if(isset($result[0]['memo'])){ echo $result[0]['memo']; } ?></textarea>
        </div>
    </div>
    <div class="col-sm-8 p0_res p-xs-0">
        <div class="clear5"></div>
        <div class="form-group">

      
            <input class="input--style-1" type="file" placeholder="" name="upload_Files[]" multiple>
            <center>
                <a href="#" class="onclick_exist_sidebar_quotation">Show existing</a>
            </center>
        </div>
    </div>
</div> 
                           
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="clear30"></div>
                    <div class="clear30"></div>
                    
                </div>
            </div>
            <div class="modal-footer modal_invoice_footer set-modal-height-s ">
            



            <input type="hidden" name="copy_sale_quotation" id="capy-sale-d" value="">    
            <div class="col-sm-4 col-md-4 col-lg-3 col-xs-6 account_new_import line-hit p-xs-0">
            <div class="input-group input-group-s pull-right">
               
                       
                               
            </div>
            <input type="submit" name="submit"    class="btn btn-primary" >


           <?php if(isset($result[0]['quotation_index_id'])){?>
            <input type="button" value="Print" id="<?php echo $result[0]['quotation_index_id'];?>" class="btn btn-info print_doc_d"> 
           <!--  <a href="<?php echo base_url()?>generate-pdf-quot/<?php echo $result[0]['quotation_index_id'];?>"  value="<?php echo $result[0]['quotation_index_id'];?>" class="btn btn-info">Print</a> -->
           <input type="button" class="btn btn-primary send_email" value="Save &amp; Send"  >
           

           <?php }?>

        <!-- <input type="submit" name="pdf_id" class="btn btn-primary print_doc_d__" value="<?php if(isset($result[0]['quotation_index_id'])){echo $result[0]['quotation_index_id']; }?>"> -->
           <!--  <button type="submit" class="btn pull-right btn_modal_save action-save-d" action-attribute="save">Save</button> -->
        </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

        <input type="hidden" name="tax_rate" value="" class="tax_rate">
   
        <input type="hidden" name="tax_rate" value="0" class="tax_rate">
   
</form>
<!-- load save and send -->     
<?php //$this->load->view('popup/make-recurring'); ?>
<?php $this->load->view('popup/save-send');
$this->load->view('popup/print'); ?>
<script type="text/javascript"> 

     $("#quotation_sorting tbody input").prop("disabled",true);
    $('#quotation_sorting tbody tr').click(function (){
    $(this).siblings().removeClass('active');
    if($(this).siblings().find('input.sh').val() == '' && $(this).siblings().find('input.am').val() == ''){
    $(this).siblings().find('input').prop('disabled', true);
    }
    $(this).addClass("active");
    $('tr.active').find('input').removeAttr('disabled');
    })
 
    var fixHelperModified = function(e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function(index) {
            $(this).width($originals.eq(index).width());
        });
        return $helper;
    },
    updateIndex = function(e, ui) {
        $('td.index', ui.item.parent()).each(function(i) {
            $(this).html(i + 1);
        });
    };
    $(".quotation_table_d tbody").sortable({
        helper: fixHelperModified,
        stop: updateIndex,
        handle: '.add_movable'
    }).disableSelection(); 
</script>
<style>
.arrow_box_purchase_open .bootstrap-select button{
        width: 114px;
    }
    .arrow_box_purchase_open {
        left: 110px;   
}
.arrow_box_purchase_open:before {
    left: -20px !important;
}
.status_box{
    width: 135px;
    float: left;
    margin-right: 10px;
}
.print-s {
  background-color: green;
  color: black;
  padding: 5px;
}
.print-s {
  visibility: hidden;
}
.print-s:after {
  content:'Print'; 
  visibility: visible;
  display: block;
  position: absolute;
  padding: 5px;
  top: 2px;
}
</style><!-- 


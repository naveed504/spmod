<style>
    .quo-tax-s span{display: inherit !important;}
    .vat-tax-s span{display: inherit !important;}
</style>
<?php $lockForm = (!empty($linked_invoice[0]['so_index_id']) ? 'lock-form-s' : '');

if(isset($listQuotationTableData[0]['quotation_status']) && !empty($listQuotationTableData[0]['quotation_status']))
{
    if($listQuotationTableData[0]['quotation_status']==2)
    {
        $lockForm = 'lock-form-s';
    }
    else
    {
        $lockForm ='';
    }    
}
// print_r($getSiSettings);
// exit;
?>
<form method="post" id="quotation_form_d" autocomplete="off" class="railway-font-s">
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
                                        <?php if(!empty($recentQuotation)){
                                        foreach($recentQuotation as $list){
                                        if($list['quotation_date'] !='0000-00-00 00:00:00' )
                                        {    
                                            $quo_date = str_replace('/', '-', $list['quotation_date']);
                                            $quo_date = date("m-d-Y", strtotime($quo_date));
                                        }
                                        else
                                        {
                                            $quo_date ="";
                                        }
                                        if($list['quotation_status'] ==2)
                                        {
                                            $quotation_status ='Deleted';
                                        }
                                        else
                                        {
                                            $quotation_status='';
                                        } 
                                        //echo"helo ".CommaVal($list['SUM(amount)']); 
                                        ?>
                                        <tr class="quotation_update_d" data-type="edit" id="<?php echo $list['sales_quotation_index_id']; ?>">
                                            <td width="28%">Sales Quotation#. <?php echo $list['document_no']; ?></td>
                                            <td width="19%"><?php if(!empty($quo_date)){ echo $quo_date;} ?></td>
                                            <td width="24%"><?php if(!empty($list['symbol'])){ echo $list['symbol'];} ?>&nbsp;<?php echo number_format($list['SUM(amount)'],2); ?></td>
                                            <td width="20%"><?php echo $list['dispaly_name']; ?></td>
                                            <td width="9%"><?php echo $quotation_status; ?></td>
                                        </tr>
                                    <?php } } //exit;  ?>
                                    <tr>
                                        <!-- <td colspan="4"><a href="">View More</a></td> -->
                                    </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <h4 class="modal-title journal_pop_hdg pull-left" >Sales Quotation#
                    <span id="sequence_no_d">
                    <?php
                    if(!empty($update_id) && isset($listQuotationTableData[0]['document_no']))
                    {
                        echo $listQuotationTableData[0]['document_no'];
                    }else{
                        echo $document_no;
                    }
                    ?>
                    </span>
                </h4>
               
                <div id="button_invoice_popup">
                    <button type="button" class="close pull-righ close_account_modal cancl-popup-d">
                        <img src="<?php echo base_url() ;?>public/admin/images/cancel_try.png">
                    </button>

                    <button type="button" class="close pull-right" module_name="<?php if(isset($module_id)){ echo $module_id; }else{ echo"no-id"; }?>" data-module="Sale Quotation Page" id="help_sign">
                        <img src="<?php echo base_url() ;?>public/admin/images/question_try.png">
                    </button>
                    <button type="button" class="close pull-right" id="customize_fields_qo_d">
                        <img src="<?php echo base_url().'public/admin/'; ?>images/cog_try.png" />
                    </button>
                    <?php 
                        if(isset($favourites) && !empty($favourites))
                            {  ?>
                                <div class="pull-right close" id="">
                                <img class="star-d star-yellow-d" data-fav-id="1" data-message="Sale Quotation" data-url="salesquotation" src="<?php echo base_url().'public/admin/'; ?>images/star-yellow.png" />
                             </div>
                         <?php }else{ ?>        
                            <div class="pull-right close" id="">
                                <img class="star-d star-balck-d" data-fav-link="link" data-fav-id="1" data-message="Sale Quotation" data-url="salesquotation" src="<?php echo base_url().'public/admin/'; ?>images/star2.png" />
                            </div>
                     <?php } ?>
                </div>
            </div>
            <div class="modal-body over_flowscroll invoice_modal_label modal-body-padding-s">
                <div class="add-lock-s <?php echo $lockForm; ?>">
                <div class="invocie_box_bgtop">
                    <div class="col-sm-12 p-xs-0">
                        <div class="clear20"></div>
                            <div class="col-sm-3 padd_left_input p0 p-xs-15 auto-w-s">
                                <label>Customer</label>
                                <?php //echo"<pre>";print_r($listQuotationTableData); ?>
                                        <div class="custom-selector-s get_cus_id_d">
                                            <?php $qtCustId = (empty($copy_sq_id) && !empty($listQuotationTableData[0]['customer_id']) ? $listQuotationTableData[0]['customer_id'] : ''); ?>
                                            <div class="selectize-custom place-main-s">
                                                <input type="text" placeholder="Select Customer" name="ven_id___" class="select_input qt-cust-d my-place-s" value="<?php echo $qtCustId; ?>" search-selector />
                                                <div class="caret-selectize-option hid-show-cart-d qt-cust-d">
                                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                                </div>
                                                <div class="selector-attr-hid-val-d">
                                                    <input type="hidden" name="vendor_id[]" class="vendor_id-d" value="<?php echo $qtCustId; ?>" />
                                                </div>
                                            </div>
                                            <div class="visible-selectize-options show_cust_d min-wid2 hide-d visible-selectize-options-parent" attr-height="210" style="max-height: 210px;overflow: auto;">
                                                <div class="child_options_list select-option-s quo_add_new_d" style="background: #ECEEF1" attr-id="add_new">
                                                    <p class="paragraph_left"><i style="color:#2CA01C" class="fa fa-plus"></i>&nbsp;Add New<span class="cus_text_d"></span></p>
                                                    <div class="clear0"></div>
                                                </div>
                                               <!--  <div class="child_options_list select-option-s quo-get-op2"></div> -->
                                                <?php if(!empty($listCustomer)){ $cnt =3;
                                                    foreach($listCustomer as $customer){ ?>
                                                    <div class="child_options_list green-hover get-customer-detail-d quo-get-op<?php echo $cnt; ?> select-option-s green-hover select-styling2" attr-id="<?php echo $customer['customer_index_id']; ?>" attr-name="vendor_id">
                                                        <p class="search-d green-hover select-drop">
                                                            <?php echo $customer['company']; ?>
                                                        </p>
                                                        <div class="clear0"></div>
                                                    </div>
                                                <?php $cnt++; } } ?>
                                            </div>
                                        </div>
                                        <div class="clear5"></div>
                                        <div class="onclick_image_change">
                                            <img class="pending_image" src="<?php echo base_url() ;?>public/admin/images/open.png" />
                                            <img class="accept_image" src="<?php echo base_url() ;?>public/admin/images/accepted.png" />
                                            <img class="closed_image" src="<?php echo base_url() ;?>public/admin/images/closed.png" />
                                            <img class="reject_image" src="<?php echo base_url() ;?>public/admin/images/rejected.png" />
                                        </div>
                                        <a id="verfied_hover_qoutation" href="#" class="make_recurring_slide_3 btn_open_close">
                                            <span class="pending_text append_estimate_status_d">Pending</span>
                                            <span class="accepted_text">Accepted</span>
                                            <span class="closed_text">Closed</span>
                                            <span class="rejected_text">Rejected</span>
                                            <span class="caret"></span></a>
                                        <div class="arrow_box_purchase_open" style="display: none;">
                                            <div class="status_box">
                                                <label>Estimate Status</label>
                                                <div class="bootstrap_select">
                                                    <select name="estimate_status" class="form-control selectpicker" id="estimate_status_d">
                                                        <option value="1" <?php if(!empty($listQuotationTableData[0]['estimate_status'])){ if($listQuotationTableData[0]['estimate_status']==1){ echo"selected"; } } ?> class="pending_click_img" attr-class="pending_click_img">Pending</option>
                                                        <option value="2" <?php if(!empty($listQuotationTableData[0]['estimate_status'])){ if($listQuotationTableData[0]['estimate_status']==2){ echo"selected"; } } ?> class="accept_click_img" attr-class="accept_click_img">Accepted</option>
                                                        <option value="3" <?php if(!empty($listQuotationTableData[0]['estimate_status'])){ if($listQuotationTableData[0]['estimate_status']==3){ echo"selected"; } } ?> class="close_click_img" attr-class="close_click_img">Closed</option>
                                                        <option value="4" <?php if(!empty($listQuotationTableData[0]['estimate_status'])){ if($listQuotationTableData[0]['estimate_status']==4){ echo"selected"; } } ?> class="reject_click_img" attr-class="reject_click_img">Rejected</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php
                                            $estimate_by = (!empty($listQuotationTableData[0]['estimate_by']) ? $listQuotationTableData[0]['estimate_by'] : '');
                                            $estimate_date = (!empty($listQuotationTableData[0]['estimate_date']) ? $listQuotationTableData[0]['estimate_date'] : '');
                                            ?>
                                            <div class="status_box pending_display_none">
                                                <label>By</label>
                                                <input type="text" value="<?php echo $estimate_by; ?>" name="estimate_by" class="form-control" />
                                            </div>
                                            
                                            <div class="status_box pending_display_none">
                                                <label>Date</label>
                                                <div class="ui calendar datepicker_new" id="purchase_order_d">
                                                    <div class="ui input left icon">
                                                        <input name="estimate_date" value="<?php echo $estimate_date; ?>" class="date_as_od_std_d" type="text" placeholder="Date">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="qoutation_qbo_content" class="selectize_popup_onclick show-add-cus-d" style="display: none;">
                                            <h3>New Customer </h3>
                                            <label><span>*</span>Company Name</label>
                                            <input type="text" name="vendor" id="customer_name_d" class="form-control" placeholder="">
                                            <div class="clear10"></div>
                                            <div class="col-sm-6 p0">
                                                <a href="#" class="po_details_customer_d">+ Detail</a>
                                                <!-- <a href="#" class="detail_customer customer-pop-d">+ Detail</a> -->
                                            </div>
                                            <div class="col-sm-6 p0">
                                                <button type="button" class="btn btn_term_save pull-right save_customer_d">Save</button>
                                            </div>
                                            <div class="clear10"></div>
                                        </div>
                                    <div class="clear5"></div>
                                    <?php
                                        $counter = "";
                                        $invoiceDate = (!empty($linked_invoice[0]['created_at']) ? $linked_invoice[0]['created_at'] : '');
                                        $invoiceId = (!empty($linked_invoice[0]['so_index_id']) ? $linked_invoice[0]['so_index_id'] : '');
                                        if($invoiceDate)
                                        {    
                                            //$quotation = str_replace('/', '-', $this->input->post('quotation_date'));
                                            $counter =1;
                                            $invoiceDate = date("m-d-Y", strtotime($invoiceDate));
                                        }
                                    ?>
                                    <?php if(!empty($linked_invoice)){ ?>
                                    <a id="linked-quo-d" href="#" class="make_recurring_slide_3 btn_open_close unlock-form-ele-s">
                                        <span class="linked-quo-clr-s"><?php echo $counter; ?> Linked Invoice</span>
                                        <span class="caret"></span></a>
                                    <div class="toggle-quo-link-s unlock-form-ele-s" style="display: none;">
                                        <div class="container max-box-pop-s">
                                            <div class="row">
                                                <div class="col-xs-3">Type</div>
                                                <div class="col-xs-5">Date</div>
                                                <div class="col-xs-4">Amount</div>
                                            </div>
                                            <div class="row data mt-15">
                                                <div class="col-xs-3"><a href="<?php echo base_url('saleorder?trxid='.$invoiceId) ?>">Invoice</a></div>
                                                <div class="col-xs-5"><?php echo $invoiceDate; ?></div>
                                                <div class="col-xs-4 show_gtotal_d"><?php if(!empty($listQuotationUpdate[0]['SUM(amount)'])){ echo number_format((float)$listQuotationUpdate[0]['SUM(amount)'], 2, '.', '');}else{ echo "0.00";} ?></div>
                                            </div>
                                            <!-- <?php //}else{ ?>
                                             <div class="row data mt-15">
                                                <div class="col-xs-12 text-center"><span>No record Found</span></div>
                                            </div> 
                                            <?php //} ?> -->    
                                      </div>    
                                    </div>
                                    <?php } ?>
                                    <input type="hidden" name="invoiceId" id="invoice-id-d" value="<?php echo $invoiceId; ?>">
                            </div>
                            <div class="col-sm-3 required-field-s clr-both">
                                <label>Email</label>
                                <div class="form-group place-main-s main-error-s">
                                    <input type="text" name="email" id="email_d" class="form-control my-place-s email-d" placeholder="Email (Seprate emails with a comma)" value="<?php if(empty($copy_sq_id) && isset($listQuotationUpdate[0]['email']) && !empty($listQuotationUpdate[0]['email'])){ echo $listQuotationUpdate[0]['email'];} ?>">
                                    <div class="padd_right_input pull-right">
                                        <div class="form-check pull-right">
<?php 
$ccCount = '';
$bccCount = '';
$emailCc = (empty($copy_sq_id) && isset($listQuotationUpdate[0]['email_cc']) && !empty($listQuotationUpdate[0]['email_cc'])) ? $listQuotationUpdate[0]['email_cc'] : ''; 
if(!empty($emailCc))
{
    $ccImplode = explode(",",$emailCc);
    $ccCount = count($ccImplode);
    if($ccCount>0)
    {
        $ccCount = 'Cc('.$ccCount.')';
    }else{
        $ccCount = 'Cc';
    }    
}else{
    $ccCount = 'Cc';
}

$emailBcc = (empty($copy_sq_id) && isset($listQuotationUpdate[0]['email_bcc']) && !empty($listQuotationUpdate[0]['email_bcc'])) ? $listQuotationUpdate[0]['email_bcc'] : ''; 
if(!empty($emailBcc))
{
    $bccImplode = explode(",",$emailBcc);
    $bccCount = count($bccImplode);
    if($bccCount>0)
    {
        $bccCount = 'Bcc('.$bccCount.')';
    }else{
        $bccCount = 'Bcc';
    }    
}else{
    $bccCount = 'Bcc';
}
?>                                            
<div class="dropdown text-right">
    <button type="button" class="btn btn-primary dropdown-toggle invoice_bcc_btn cc_bcc_qoutation mar-top_s" data-toggle="dropdown">
        <span class="cc-d"><?php echo $ccCount; ?></span>
        /
        <span class="bcc-d"><?php echo $bccCount; ?></span>
    </button>
    <div class="dropdown-menu bcc_dropdown_box">
        <div class="col-sm-12 place-main-s">
            <div class="form-group">
                <label>Cc </label>
                <input type="text" name="email_cc" value="<?php echo $emailCc; ?>" class="form-control my-place-s email_cc_d" placeholder="Email (Seprate emails with a comma)">
            </div>
        </div>
        <div class="col-sm-12 place-main-s">
            <div class="form-group">
                <label>Bcc </label>
                <input type="text" name="email_bcc" value="<?php echo $emailBcc; ?>" class="form-control my-place-s email_bcc_d" placeholder="Email (Seprate emails with a comma)">
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
                                  <!--   <div class="clear5"></div>
                                    <div class="col-sm-8 p0">
                                        <div class="form-check">
                                            <input id="chk01" type="checkbox"><label for="chk01"></label>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-sm-2 send_later_text_s p0">
                                <div class="clear10 visible-xs hidden-sm"></div>
                                <div class="col-xs-6 padd_left_input send_later_align">
                                    <label class="hide-xs-s">&nbsp;</label>
                                    <div class=" " id="send_later">
                                        <input id="qoutation_qbo_01" name="send_later" value="1" type="checkbox" <?php if(!empty($listQuotationUpdate[0]['send_later'])){ if($listQuotationUpdate[0]['send_later']==1){ echo "checked";} } ?>><label for="qoutation_qbo_01">Send later</label>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            if(isset($listQuotationTableData[0]['quotation_status']) && !empty($listQuotationTableData[0]['quotation_status']))
                            { 
                                if($listQuotationTableData[0]['quotation_status']==2)
                                {
                            ?>
                                <div class="del-text-s unlock-form-ele-s dele-img"><img src='<?php echo base_url() ;?>public/admin/images/deleted.png' ></div>
                                <div class="tol-s unlock-form-ele-s">This quotation has been deleted. Editing is not allowed <span class="angle-s"></span></div>
                            <?php } } ?>
                            <div class="col-sm-4 right_balance_label pull-right lbp-amout-pos-s">
                                <p class="amount_span">Amount </p>
                                <h3 class="f-36">
                                <span class="currency_symbol_d"></span>&nbsp;
                                <span class="show_gtotal_d amount_hit_s">
                                <?php if(!empty($listQuotationUpdate[0]['SUM(amount)'])){ echo number_format((float)$listQuotationUpdate[0]['SUM(amount)'], 2, '.', '');}else{ echo "0.00";} ?></span>
                                </h3> 
                            </div>
                            <!-- ERROR MESSAGE SHOW -->
                            <?php $this->load->view('pages/error-message-box'); ?>
                            <?php $this->load->view('pages/error-message-box-copy'); ?>
                            <!-- ERROR MESSAGE SHOW -->
                            <div class="clear20 hid-xs-s"></div>
                            <div class="col-sm-2 padd_left_input">
                                <div class="form-group" style="height: 170px;">
                                    <label>Biling address </label>
                                    <textarea name="billing_address" id="billing_address_d" class="form-control textarea_credit text-area-s"><?php if(isset($listQuotationUpdate[0]['billing_address']) && !empty($listQuotationUpdate[0]['billing_address'])){ echo $listQuotationUpdate[0]['billing_address'];} ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-2 padd_left_input">
                                <div class="form-group">
                                    <label>Sale Quotation Date </label>
                                    <div class="ui calendar datepicker_new" id="quotation_date_d">
                                        <div class="ui input left icon">
                                            <input class="date_as_od_std_d" name="quotation_date" value="<?php if(!empty($listQuotationUpdate[0]['quotation_date'])){ if($listQuotationUpdate[0]['quotation_date'] != '0000-00-00 00:00:00'){ echo $listQuotationUpdate[0]['quotation_date'];}}else{ echo date("Y-m-d");} ?>" type="text" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group bootstrap_select currency-attr-d drop-hit-s" style="display:<?php echo $getSiSettings[0]['currency'] ? '' : 'none' ?>">
                                    <label>Quote Currency</label>
                                    <select name="currency_id" id="currency_d" class="form-control selectpicker cus-lines-s">

                                    <?php $lbpRate=1;$deft_curr_id=''; //echo"<pre>";print_r($currency);
                                    if(!empty($currency)){  
                                    foreach($currency as $list){
                                      if($list['currency_default_index_id']==6){
                                        $lbpRate = $list['rate']; $deft_curr_id = $list['currency_default_index_id'];}  ?>
                                        <option data-rate="<?php echo $list['rate']; ?>" curr-default-id="<?php echo $list['currency_default_index_id']; ?>" value="<?php echo $list['currency_default_index_id']; ?>"<?php if(empty($listQuotationUpdate[0]['currency_default_index_id'])){ if($list['default_currency']==1){ echo"selected";}}else{ if($list['currency_default_index_id']==$listQuotationUpdate[0]['currency_default_index_id']){ echo"selected";} } ?> ><?php echo $list['currency_name']; ?></option>
                                    <?php } } ?>    
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" id="lbp_curr_rate_d" def-curr-id="<?php echo $deft_curr_id; ?>" value="<?php echo $lbpRate; ?>">
                            <div class="col-sm-2 padd_left_input">
                                <div class="form-group">
                                    <label>Expiration Date </label>
                                    <div class="ui calendar datepicker_new" id="quotation_expiry_date_d">
                                        <div class="ui input left icon">
                                            <input class="date_as_od_std_d" id="so_exp_date_d" name="expiration_date" value="<?php if(!empty($listQuotationUpdate[0]['expiration_date'])){ if($listQuotationUpdate[0]['expiration_date'] != '0000-00-00 00:00:00'){ echo $listQuotationUpdate[0]['expiration_date'];}} ?>" type="text">
                                        </div>
                                    </div>
                                </div>
                                <?php //echo"<pre>";print_r($listQuotationUpdate); ?>
                                <div class="form-group bootstrap_select drop-hit-s discounttype-attr-d" style="display:<?php echo $getSiSettings[0]['discounttype'] ? '' : 'none' ?>">
                                    <label>Discount Type</label>
                                    <select name="discount_inline_total" id="discount_total_d" class="form-control selectpicker cus-lines-s">
                                        <option value="">Select discount</option>
                                        <option value="1" <?php if(!empty($listQuotationUpdate[0]['discount_inline_total'])){ if($listQuotationUpdate[0]['discount_inline_total']==1){ echo"selected"; } } ?>>In-line Discount</option>
                                        <option value="2" <?php if(!empty($listQuotationUpdate[0]['discount_inline_total'])){ if($listQuotationUpdate[0]['discount_inline_total']==2){ echo"selected"; } } ?>>Discount on totals</option>   
                                    </select>
                                </div>
                            </div>
                            <!-- shipping fee from setting hide show -->
                            <?php $shippingFee = !empty($getSiSettings[0]['shipping_fee']) || !empty($getSiSettings[0]['shipping_fields']) ? '' : 'hide-d'; ?>
                            <div class="col-sm-2 padd_left_input shipping_fee-attr-d <?php echo $shippingFee; ?>">
                                <div class="form-group">
                                    <label>Shipping Fee</label>
                                    <input type="text" name="shipping_fee" class="form-control" value="<?php if(isset($listQuotationUpdate[0]['shipping_fee']) && $listQuotationUpdate[0]['shipping_fee']>0){ echo $listQuotationUpdate[0]['shipping_fee']; } ?>">
                                </div>
                            </div>
                            <!-- //shipping fields start -->
                            <div class="col-sm-2 padd_left_input" style="display:<?php echo $getSiSettings[0]['shipping_fields'] ? '' : 'none' ?>">
                                <div class="form-group">
                                    <label>Shipping Address </label>
                                    <input type="text" name="custom_shipping_address" placeholder="Shipping address" class="form-control my-place-s" value="<?php if(isset($listQuotationUpdate[0]['custom_shipping_address'])){ echo $listQuotationUpdate[0]['custom_shipping_address']; } ?>">
                                </div>
                            </div>
                            <div class="col-sm-2 padd_left_input" style="display:<?php echo $getSiSettings[0]['shipping_fields'] ? '' : 'none' ?>">
                                <div class="form-group">
                                    <label>Ship Via </label>
                                    <input type="text" name="custom_ship_via" placeholder="Ship via" class="form-control my-place-s" value="<?php if(isset($listQuotationUpdate[0]['custom_ship_via'])){ echo $listQuotationUpdate[0]['custom_ship_via']; } ?>">
                                </div>
                            </div>
                            <!-- shipping fields end -->
                            <?php $transactionType = get_branch_permissions($this->session->userdata('user_index_id'));  
                            //echo"helo";print_r($listQuotationUpdate[0]['transaction_type']);exit;
                            if(isset($transactionType['can_access_branch']) && $transactionType['can_access_branch'] ==1)
                            { ?>
                            <!-- <div class="col-sm-2 padd_left_input">
                                <div class="form-group bootstrap_select drop-hit-s">
                                    <label>Transaction Type</label>
                                    <select name="transaction_type" id="transaction_type_d" class="form-control selectpicker cus-lines-s">
                                        <option value="1" <?php //if(isset($listQuotationUpdate[0]['transaction_type'])){ if($listQuotationUpdate[0]['transaction_type']==1){ echo"selected"; } } ?>>ON</option>
                                        <option value="0" <?php //if(isset($listQuotationUpdate[0]['transaction_type'])){ if($listQuotationUpdate[0]['transaction_type']==0){ echo"selected"; } } ?>>OFF</option>   
                                    </select>
                                </div>
                            </div> -->
                            <?php } ?>    
                           <!-- //..............terms -->
                          <div class="col-sm-2 padd_left_input terms-attr-d <?php echo $getSiSettings[0]['terms'] ? '' : 'hide-d' ?>">
                           <div class="form-group">
                              <label>Terms</label>
                               <?php
                                $defaultTerms = '';
                                if(isset($getTerms) && !empty($getTerms))
                                {
                                    foreach($getTerms as $key => $term)
                                    {
                                        if($term['make_default'] == 1)
                                        {
                                            $defaultTerms = $term['term_index_id'];
                                        }
                                    }
                                }    
                                ?>
                              <div class="custom-selector-s">
                                 <?php $soTerms = (isset($listQuotationUpdate[0]['term_id']) && $listQuotationUpdate[0]['term_id']) ? $listQuotationUpdate[0]['term_id'] : $defaultTerms; ?>
                                 <div class="selectize-custom">
                                    <input type="text" name="term_id_" class="select_input sqo-terms-d" placeholder="Select Term" value="<?php echo $soTerms;?>" search-selector />
                                    <div class="caret-selectize-option caret-show-s sqo-terms-d">
                                       <i class="fa fa-caret-down" aria-hidden="true"></i>
                                    </div>
                                    <div class="selector-attr-hid-val-d">
                                       <input type="hidden" name="sqo_term" class="sqo_term-d" value="<?php echo $soTerms;?>" />
                                    </div>
                                 </div>
                                 <div class="visible-selectize-options append_terms_option_d" attr-height="200">
                                    <div class="child_options_list select-option-s add-new-term-ddd" style="background: #ECEEF1" attr-id="add_new">
                                       <!-- search-d -->
                                       <p class="paragraph_left"><i style="color:#2CA01C" class="fa fa-plus"></i>&nbsp;Add New 
                                          <span class="search-word-app-d cus_text_s"></span>
                                       </p>
                                       <div class="clear0"></div>
                                    </div>
                                    <?php if(isset($getTerms) && !empty($getTerms)){
                                       foreach ($getTerms as $key => $term)
                                       {
                                       $id = $term['term_index_id'];
                                       $day_field = $term['day_field'];
                                       $due_by_certain_day_of_month = $term['due_by_certain_day_of_month'];
                                       $term_name = $term['name'];
                                       ?>
                                    <div class="child_options_list green-hover select-option-s quo-get-op" attr-month="<?php echo $due_by_certain_day_of_month;?>" attr-day-field="<?php echo $day_field;?>" attr-id="<?php echo $id; ?>" attr-name="sqo_term">
                                       <p class="paragraph_left search-d green-hover">
                                          <?php echo $term_name; ?>
                                       </p>
                                       <div class="clear0"></div>
                                    </div>
                                    <?php } } ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                           <!-- ................ -->
                            <?php 
                            if(isset($quotation_no[0]['quotation_no']) && empty($update_id))
                            {
                                $quotationNo = $quotation_no[0]['quotation_no']+1;
                            }
                            else if(isset($listQuotationUpdate[0]['quotation_no']))
                            { 
                                $quotationNo = $listQuotationUpdate[0]['quotation_no']; 
                            }
                            else
                            {
                                $quotationNo =1;
                            } 
                            ?>
                            <div class="col-sm-2 padd_left_input sq_number-attr-d" style="display:none;<?php //echo $getSiSettings[0]['sq_number'] ? '' : 'none' ?>">
                                <div class="form-group">
                                    <!-- <label>Sale Quotation No </label> -->
                                    <input type="hidden" name="quotation_no" class="form-control quotation_no_d" value="<?php echo $quotationNo;  ?>">
                                </div>
                            </div>

                            <div class="col-sm-2 padd_left_input qo-field-custom2-d custom2-attr-d" style="display:<?php echo $getSiSettings[0]['custom'] ? '' : 'none' ?>">
                                <div class="form-group">
                                    <label><?php echo $getSiSettings[0]['custom_field'] ? $getSiSettings[0]['custom_field'] : 'Custom 1' ?></label>
                                    <input type="text" name="custom_field1" class="form-control" value="<?php if(isset($listQuotationUpdate[0]['custom_field1'])){ echo $listQuotationUpdate[0]['custom_field1']; } ?>">
                                </div>
                            </div>
                            <div class="col-sm-2 padd_left_input qo-field-crew-d crew-attr-d" style="display:<?php echo $getSiSettings[0]['custom_2'] ? '' : 'none' ?>">
                                <div class="form-group">
                                    <label><?php echo $getSiSettings[0]['custom'] ? $getSiSettings[0]['custom_field_2'] : 'Custom 2' ?></label>
                                    <input type="text" name="custom_field2" class="form-control" value="<?php if(isset($listQuotationUpdate[0]['custom_field2'])){ echo $listQuotationUpdate[0]['custom_field2']; } ?>">
                                </div>
                            </div>
                            <!-- --custom field 2-- -->
                            <div class="col-sm-2 padd_left_input qo-field-custom3-d custom3-attr-d" style="display:<?php echo $getSiSettings[0]['custom_3'] ? '' : 'none' ?>">
                                <div class="form-group">
                                    <label><?php echo $getSiSettings[0]['custom_field_3'] ? $getSiSettings[0]['custom_field_3'] : 'Custom 3 ' ?></label>
                                    <input type="text" name="custom_field3" class="form-control" value="<?php if(isset($listQuotationUpdate[0]['custom_field3'])){ echo $listQuotationUpdate[0]['custom_field3']; } ?>">
                                </div>
                            </div>
                            <!-- --custom field 3-- -->
                            <div class="col-sm-2 padd_left_input  qo-field-custom_field-d custom_field-attr-d" style="display:<?php echo $getSiSettings[0]['custom_4'] ? '' : 'none' ?>">
                                <div class="form-group">
                                    <label><?php echo $getSiSettings[0]['custom_field_3'] ? $getSiSettings[0]['custom_field_4'] : 'Custom 4' ?></label>
                                    <input type="text" name="custom_field4" class="form-control" value="<?php if(isset($listQuotationUpdate[0]['custom_field4'])){ echo $listQuotationUpdate[0]['custom_field4']; } ?>">
                                </div>
                            </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php $skuCheck = isset($getSiSettings[0]['sku']) ? $getSiSettings[0]['sku'] : 0; ?>
                <input type="hidden" value="<?php echo $skuCheck; ?>" class="sku-check-d">
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
                        <?php foreach($tax_type as $taxTyp):?>
				            <option <?php if(isset($listQuotationTableData[0]['tax_type']) && $listQuotationTableData[0]['tax_type']  == $taxTyp['tax_type_index_id'])echo 'selected="selected"'?> value="<?php echo $taxTyp['tax_type_index_id']; ?>"><?php echo $taxTyp['tax_type_name']; ?>
				            </option>
			            <?php endforeach;?>
                    </select>
                </div>
			</div>
			<div class="clear10"></div>
            <div class="h-xs-300">
                <table width="100%" class="table table-wid table-bordered table_add_new_row invoice_row_input resizable_quotation quotation-table-clear-d quotation_table_d recur_row_input w-xs-1170" id="quotation_sorting">
                    <thead>
                        <tr>
                            <th width="3%" class="" align="center" valign="middle" class="text-center">&nbsp;</th>
                            <th width="3%" align="center" valign="middle" class="text-center">#</th>
                            <th width="17%" class="text-left" valign="middle">Product/Service</th>
                            <th width="24%" class="sku-d <?php echo $getSiSettings[0]['sku'] ? '' : 'hide-d' ?>" align="center" valign="middle">SKU</th>
                            <th width="24%" class="" align="center" valign="middle">Description</th>
                            <th width="10%" class="" align="center" valign="middle">QTY</th>
                            <th width="10%" class="" align="center" valign="middle">Unit Price</th>
                            <th width="10%" class="dis_type_d hide-d" align="center" valign="middle">Discount Type</th>
                            <th width="10%" class="dis_type_d hide-d" align="center" valign="middle">Discount</th>
                            <th width="10%" class="vat_type_d" align="center" valign="middle">VAT</th>
                            <th width="10%" class="tax_type_d hide-d" align="center" valign="middle">Tax</th>
                            <th width="10%" class="" align="center" valign="middle">Amount(<span class="currency_symbol_d">LBP</span>)</th>
                            <th width="3%" class="" align="center" valign="middle"></th>
                        </tr>
                    </thead>
                    <tbody class="auto-w-s">
                        <?php  //echo"<pre>";print_r($recentQuotation);
                        $index = 0;
                        $count = 1;
                        for($i = 1; $i<=$quotationsRows; $i++){
                         ?>
                        <tr>
                            <?php 
                            $default_rate = isset($listQuotationTableData[$index]['default_rate']) ? $listQuotationTableData[$index]['default_rate'] : '' ;
                            $istax = isset($listQuotationTableData[$index]['istax']) ? $listQuotationTableData[$index]['istax'] : '1' ;  
                            ?>
                            <input type="hidden" data-ratefor-total="" data-outof-scope="" name="default_rate[]" class="default_rate_d" data_istax='<?php echo $istax; ?>' value="<?php echo $default_rate; ?>">
                            <input type="hidden" name="" class="real_amount_d" value="">
                            <input type="hidden" name="update_table_id[]" value="<?php echo isset($listQuotationTableData[$index]['quotation_product_index_id']) ? $listQuotationTableData[$index]['quotation_product_index_id'] : '' ; ?>">
                            <td align="center" valign="middle" class="add_movable text-center padding_end">
                                <img src="<?php echo base_url() ;?>public/admin/images/toggle.png" />
                            </td>
                            <td align="center" valign="middle" class="padding_end"><?php echo $count;?>
                            </td>
                            <td class="selector-text-s quo-product-d">
                                <?php $qtProId = isset($listQuotationTableData[$index]['product_id']) ? $listQuotationTableData[$index]['product_id'] : ''; ?>
                                <div class="custom-selector-s hide-show-pro-sel-d hide-d">
                                    <div class="selectize-custom">
                                        <input type="text" name="product__id_" class="select_input qt-prod-d hide-d tableInput" value="<?php echo $qtProId; ?>" search-selector />
                                        <div class="caret-selectize-option qt-prod-d remove_text_d hide-d">
                                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                                        </div>
                                        <div class="selector-attr-hid-val-d">
                                            <input type="hidden" name="product_id[]" class="product_id-d" value="<?php echo $qtProId; ?>" />
                                        </div>
                                    </div>
                                    <div class="visible-selectize-options min-wid append-selectize-pro-d hide-d" attr-height="200">
                                        <div class="child_options_list select-styling select-option-s" style="background: #ECEEF1" attr-id="add_new">
                                            <p class="paragraph_left"><i class="fa fa-plus"></i>&nbsp;Add New</p>
                                            <div class="clear0"></div>
                                        </div>
                                        <?php if(!empty($product_details)){
                                            foreach($product_details as $product){ ?>
                                            <div class="child_options_list select-option-s get_pro_id comon-pro-d" attr-id="<?php echo trim($product['ps_id']); ?>" attr-name="product_id" >
                                               <p class="paragraph_left search-d select-drop"><?php echo trim($product['ps_name']); ?></p><p class="paragraph_right select-drop"><?php echo trim($product['cat_name']); ?></p>
                                                <div class="clear0"></div>
                                            </div>
                                        <?php } } ?>
                                    </div>
                                </div>
                                <span><?php //echo trim($qtProId); ?></span> 
                            </td>
                            <td class="text-left sku-d <?php echo $getSiSettings[0]['sku'] ? '' : 'hide-d' ?>" valign="middle">
                                <input name="sku[]" class="form-control sku-d" class="form-control sku_d tableInput" readonly value="<?php echo isset($listQuotationTableData[$index]['sku']) ? $listQuotationTableData[$index]['sku'] : '' ; ?>">
                                <span><?php echo isset($listQuotationTableData[$index]['sku']) ? $listQuotationTableData[$index]['sku'] : '' ; ?></span>
                            </td>
                            <td class="text-left show_des_d selector-text-s move-up-down-row-d" valign="middle">
                                <input name="description[]" class="form-control des_d tableInput" type="text" value="<?php echo isset($listQuotationTableData[$index]['description']) ? $listQuotationTableData[$index]['description'] : '' ; ?>">
                                <span><?php echo isset($listQuotationTableData[$index]['description']) ? $listQuotationTableData[$index]['description'] : '' ; ?></span>
                            </td>
                            <td class="text-left show_qty_d move-up-down-row-d recur_row_input" valign="middle">
                                <?php $qty = isset($listQuotationTableData[$index]['qty']) ? $listQuotationTableData[$index]['qty'] : '' ; ?>
                                <input name="qty[]" class="form-control qty_d on_hover_tooltip1 tableInput" type="text" value="<?php echo $qty ? decimelVal($qty) : ''; ?>">
                                <span><?php echo $qty ? number_format($qty,2) : ''; ?>
                                </span>
                            </td>
                            <td class="text-left show_rate_d move-up-down-row-d recur_row_input" valign="middle">
                                <?php $rate = isset($listQuotationTableData[$index]['rate']) ? $listQuotationTableData[$index]['rate'] : '' ; ?>
                                <input name="rate[]" class="form-control rate_d tableInput" type="text" value="<?php echo $rate ? decimelVal($rate) : ''; ?>">
                                <span> 
                                    <?php echo $rate ? number_format($rate,2) : ''; ?>
                                </span>
                            </td>
                            <td class='show_inline_disc_d dis_type_d hide-d'>
                                <?php $selected = "";
                                if(!empty($listQuotationTableData[$index]['inline_discount_type']))
                                { 
                                    if($listQuotationTableData[$index]['inline_discount_type']==1){$selected = "Percentage"; }
                                    else if($listQuotationTableData[$index]['inline_discount_type']==2){$selected = "Amount";} 
                                    else{$selected = "";}
                                }
                                ?>
                                <select name="inline_discount_type[]" class="form-control discount-d hide-d quo-tax-s show_select_d selectpicker inlinespan<?php echo $count; ?>">
                                    <option>Select type</option>
                                    <option value="1" <?php if(!empty($listQuotationTableData[$index]['inline_discount_type'])){ if($listQuotationTableData[$index]['inline_discount_type']==1){ echo"selected"; } } ?>>Percentage</option>
                                    <option value="2" <?php if(!empty($listQuotationTableData[$index]['inline_discount_type'])){ if($listQuotationTableData[$index]['inline_discount_type']==2){ echo"selected"; } } ?>>Amount</option>
                                </select>
                                <span><?php echo $selected; ?></span>
                                <?php unset($selected); ?>
                            </td>
                            <td class="text-left show_discount_d move-up-down-row-d recur_row_input dis_type_d hide-d" valign="middle">
                                <?php $discount = isset($listQuotationTableData[$index]['discount']) ? $listQuotationTableData[$index]['discount'] : '' ; ?>
                                <input name="discount[]" class="form-control discount_d tableInput" type="text" readonly="" value="<?php echo $discount ? decimelVal($discount) : ''; ?>">
                                <span> 
                                    <?php echo $discount ? number_format($discount,2) : ''; ?>
                                </span>
                            </td>
                            
                            <td class='show_inline_vat_d move-up-down-row-d vat_type_d'>
                                <select name="vat_rate[]" class="form-control hide-d vat-tax-s vat-tax-d show_vat_d selectpicker">
                                    <option value="0">Select type</option>
                                    <?php
                                    // echo'defaultVatRate';
                                    // print_r($defaultVatRate);

                                    $vatRegistered = isset($vat_profile[0]['register']) && $vat_profile[0]['register']==1 ? 1 :0;
                                    if(!empty($vatRates) && $vatRegistered == 1)
                                    {
                                        $vatName = '';
                                        $selected ='';

                                    foreach($vatRates as $vat){ 
                                        if(isset($vat['vat_rates_index_id']) && !empty($vat['vat_rates_index_id']) && isset($listQuotationTableData) && !empty($listQuotationTableData))
                                        { if($vat['vat_rates_index_id'] == $listQuotationTableData[$index]['vat_rates_index_id'] )
                                            {
                                                $selected = "selected"; 
                                                $vatName = $vat['name'];
                                            } 
                                        }else if(isset($vat['vat_rates_index_id']) && !empty($vat['vat_rates_index_id']) && isset($defaultVatRate) && !empty($defaultVatRate)){
                                            if($vat['vat_rates_index_id'] == $defaultVatRate['vat_rates_index_id'] )
                                            {
                                                $selected = "selected"; 
                                                // $vatName = $vat['name'];
                                            } 
                                        }
                                        ?>
                                        <option <?php echo $selected ?> data-vat="<?php echo $vat['sale_purchase_rate']; ?>" value="<?php echo $vat['vat_rates_index_id']; ?>"><?php echo $vat['name']; ?></option>
                                    <?php $selected =''; } } ?>
                                </select>
                                <span class="vat_span"><?php echo isset($vatName) && !empty($vatName) ? $vatName : '';
                                unset($vatName); ?></span>
                            </td>
                            <td class="text-left show_tax_d tax_type_d hide-d" valign="middle">
                               <?php 
                               $dataTaxType = 0;
                               $tax = isset($listQuotationTableData[$index]['tax']) ? $listQuotationTableData[$index]['tax'] : '' ;
                               $dataTaxType = isset($listQuotationTableData[$index]['sq_data_type']) ? $listQuotationTableData[$index]['sq_data_type'] : '' ;
                                if($dataTaxType==1)
                                {
                                    $dataTaxType =2;
                                } 
                                else if($dataTaxType==2)
                                {
                                    $dataTaxType =1;
                                }
                                else
                                {
                                    $dataTaxType = $dataTaxType;
                                } 

                                ?>
                                <input name="tax[]" class="form-control tax_d tableInput" data-tax-type="<?php echo $dataTaxType; ?>" type="text" readonly="" value="<?php echo $tax ? decimelVal($tax) : ''; ?>">
                                <span><?php echo $tax ? number_format($tax,2) : ''; ?></span> 
                            </td>
                            <td class="text-left show_amount_d move-up-down-row-d last_td_tooltip_s" valign="middle">
                                <?php $amount = isset($listQuotationTableData[$index]['amount']) ? $listQuotationTableData[$index]['amount'] : '' ; ?>
                                <input name="amount[]" class="form-control amount_d tableInput" type="text" value="<?php echo $amount ? decimelVal($amount) : ''; ?>">
                                <span><?php echo $amount ? number_format($amount,2) : ''; ?></span>
                            </td>
                            <td align="center" valign="middle" class="padding_end">
                                <button type="button" class="del no-del quo-del-d">
                                    <img src='<?php echo base_url() ;?>public/admin/images/delete_qbo.png'>
                                </button>
                            </td>
                        </tr>    
                    <?php $index++; $count++; } ?>
                    <input type="hidden" id="simple_get" value="">
                    <input type="hidden" class="quotation_update_d" data-type="" id="update_id_d" name="update_id" value="<?php if(!empty($update_id)){ echo $update_id;} ?>">   
                    </tbody>
                </table>
            </div>
        </div>
        <?php $def_currency_id = (isset($currency_default_id->currency_default_index_id) && !empty($currency_default_id->currency_default_index_id) ? $currency_default_id->currency_default_index_id : ''); 
        ?>
        <input type="hidden" value="" id="cur_curnt_rate_d">
        <input type="hidden" value="" id="cur_prev_rate_d">
        <input type="hidden" value="<?php echo $def_currency_id; ?>" id="default_currency_id">
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
                                        <?php if(!empty($listQuotationUpdate[0]['SUM(amount)'])){ echo number_format((float)$listQuotationUpdate[0]['SUM(amount)'], 2, '.', '');}else{ echo "0.00";} ?></span>
                                </div>
                                <input type="hidden" class="sub_total_d" value="<?php if(!empty($listQuotationUpdate[0]['SUM(amount)'])){ echo $listQuotationUpdate[0]['SUM(amount)'];}else{ echo "0.00";} ?>" >
                                <div class="clear10"></div>

                                <div class="toggle_tax_main_credit">
                                    <div class="col-sm-12 slide_down_credit p0 hide-d" id="show_hide_inline_dis_d">
                                        <div class="col-sm-6 col-xs-9 discount_d_flex discount-width p0 cus-width wid-114 drop-hit-s">
                                            <div class="line3-s"></div>
                                            <div class="form-group">
                                                <select id="calcu_disc_type_d" name="sales_discount" class="form-control selectpicker cal_discount-d">
                                                    <option value="1" <?php if(!empty($listQuotationUpdate[0]['sales_discount'])){ if($listQuotationUpdate[0]['sales_discount']==1){ echo"selected"; } } ?>>Discount percent</option>
                                                    <option value="2" <?php if(!empty($listQuotationUpdate[0]['sales_discount'])){ if($listQuotationUpdate[0]['sales_discount']==2){ echo"selected"; } } ?>>Discount value</option>
                                                </select>
                                                <input type="text" data-per-flag="" name="sales_discount_val" class="form-control text-right discount_val_d" value="<?php if(isset($listQuotationUpdate[0]['sales_discount_val']) && !empty($listQuotationUpdate[0]['sales_discount_val'])){ echo $listQuotationUpdate[0]['sales_discount_val'];} ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-2"></div>
                                        <?php $subtotal_discount = (!empty($listQuotationUpdate[0]['subtotal_discount']) ? $listQuotationUpdate[0]['subtotal_discount'] : ''); ?>
                                        <div class="col-xs-3 col-sm-4 text-right padd_right_input p-xs-0">
                                            <input type="text" data-discountP="<?php echo number_format((float)$subtotal_discount, 2, '.', ''); ?>" name="subtotal_discount" id="total_with_dis_d" value="<?php echo number_format((float)$subtotal_discount, 2, '.', ''); ?>" class="form-control hide_dis_input_d" readonly="readonly">
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
                                            <input type="text" id="inline_dis_amount_d" name="subtotal_discount1" value="" class="form-control" placeholder="0.00" readonly="readonly">
                                        </div>
                                    </div>
									<div class="clear10 vat_d"></div>
                                    <div class="col-sm-12 slide_up_credit p0 vat_d">
                                        <div class="col-sm-6 col-xs-6 text-right">
                                           VAT
                                        </div>
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-4 col-xs-6 text-right padd_right_input pr-0">
                                            <input type="text" name="subtotal_discount13" value="" class="form-control vat_total_d" placeholder="0.00" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="clear10 lbp_vat_equi_d"></div>
                                    <div class="col-sm-12 slide_up_credit p0 lbp_vat_equi_d">
                                        <div class="col-xs-6 col-sm-6 text-right">
                                           Vat Equivalent in <?php echo $currency_default_id->symbol?> 
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
                                <div class="col-sm-6 col-xs-6 text-right invoice_label_colorright_font p0 ">
                                    <span class="currency_symbol_d"></span>&nbsp;<span class="show_gtotal_d"><?php if(!empty($listQuotationUpdate[0]['SUM(amount)'])){ echo decimelVal($listQuotationUpdate[0]['SUM(amount)']);}else{ echo "0.00";} ?></span>
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
                                    <div class="col-sm-6 col-xs-6 text-left invoice_label_colorright invoice_label_colorright_font">Total Amount(<?php echo $currency_default_id->symbol?>)</div>
                                    <div class="col-sm-6 col-xs-6 text-right invoice_label_colorright_font p0 show_gtotal_lbp_d"></div>
                                    <div class="clear10"></div>
                                    <hr>
                                    <hr>
                                    <input type="hidden" name="total" id="hidden-total-d" value="<?php if(!empty($listQuotationUpdate[0]['SUM(amount)'])){ echo $listQuotationUpdate[0]['SUM(amount)'];} ?>">
                                    <div class="clear10"></div>
                                </div>

                            </div>
                             <div class="col-sm-8 col-sm-pull-4  invoice_margin_bottom padd_left_input clr-both p-xs-0">
   
    <div class="col-sm-8 p0 clr-both">
        <div class="clear5"></div>
        <label class="message_label">Message displayed to client </label>
        <div class="clear5"></div>
        <div class="form-group">
            <textarea name="msg_display_client" class="form-control textarae_h_invoice" rows="5" id="comment" placeholder=""><?php if(isset($listQuotationUpdate[0]['msg_display_client']) && !empty($listQuotationUpdate[0]['msg_display_client'])){ echo $listQuotationUpdate[0]['msg_display_client'];} ?></textarea>
        </div>
    </div>
    <div class="col-sm-8 p0">
        <div class="clear5"></div>
        <label class="message_label">Memo </label>
        <div class="clear5"></div>
        <div class="form-group">
            <textarea name="memo" class="form-control textarae_h_invoice" rows="5" id="memo" placeholder=""><?php if(isset($listQuotationUpdate[0]['memo']) && !empty($listQuotationUpdate[0]['memo'])){ echo $listQuotationUpdate[0]['memo'];} ?></textarea>
        </div>
    </div>
    <div class="col-sm-8 p0_res p-xs-0">
        <div class="clear5"></div>
        <div class="form-group">

        <div class="file-upload p0_res p-xs-0">
            <div class="col-sm-12 p0">
                <button class="file-upload-btn pull-left" type="button" onclick="$('.file-upload-input').trigger( 'click' )">
                    <label><b><i class="fa fa-fw fa-paperclip"></i> Attachments</b> </label> <span class="maxsize_file">Maxmimum size 300 KB</span> </button>
            </div>
            <div class="clear5"></div>
            <input type="hidden" class="directory-path-d" name="dir_path" value="uploads/quotation/" />
            <div class="image-upload-wrap image_upload_vendor_wrappp img-drag-detuct-d">
                <div class="file-content-d">
                    <?php if(!empty($attachements)){ ?>
                        <?php foreach($attachements as $attch){
                            if(empty($attch['attached_file'])){continue;}?>
                            <div class="remove-imd-d" style="display: flex; align-items: center;padding: 0px 0px 0px 20px; height: 25px;">
                                <div class="chiller_cb">
                                    <input name="attachments" id="vat_2" class="attach-checkbox-d" value="" type="checkbox">
                                    <label for="vat_2">&nbsp;</label>
                                    <span></span>
                                </div>
                                <span class="attach-email-s">Attach to email</span>
                                <a href="<?php echo base_url('uploads/quotation/'.$attch['attached_file']); ?>" target="_blank" class="attachment-a-s" style="font-size:13px; margin: 0px 5px 0px 20px;word-break: break-word; float: left;"><?php echo $attch['actual_file_name']; ?></a>
                                <span class="file-size-s">(19.5)</span>
                                <a class="atta-file-s" style="float: left;margin-right: 5px;">
                                    <img src="<?php echo base_url('public/admin/images/attach_cross.png'); ?>"/>
                                </a>
                            </div>
                        <?php } } ?>
                    <?php //endif; ?>
                </div>
               <input class="file-upload-input checkbox-img-d" name="attached_file" id="atta_file_names_d" type="file" multiple="multiple" />
                <div class="drag-text">
                    <h3>Drag/Drop files here or click the icon</h3>
                </div>
                <svg class="svg-progress-bar-30-right progress-bar-load-d hide-d" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200">
                <circle class="path-progress-bar" stroke-width="10" stroke-miterlimit="10" class="cls-1 path" cx="100" cy="100" r="94" /></svg>
            </div>
        </div>
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
            <div class="modal-footer modal_invoice_footer set-modal-height-s <?php echo $lockForm; ?>">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xs-7 p-xs-0 hide-xs-s">
                    <button type="button" class="btn pull-left cancl-popup-d btn_focus_colr_white_s">Cancel</button>
                    <button type="button" class="btn pull-left quotation-clear-d btn_focus_colr_white_s">Clear</button>
                </div>

<div class="col-sm-5 col-md-5 col-lg-6 col-xs-6 text-center making_print_portion">
    <ul class="footer_drop">
        <li>
            <a href="#" class="make_recurring_slide_1">
                <button type="submit" class="action-save-d print-s" action-attribute="print">Print</button>
            </a>
        </li>
        <!-- qoutation_recurring_slide -->
        <li><a href="#" class="test-slide qoutation_recurring_slide p-1-1" data-toggle="modal" data-target="#quotation_qbo_recurring">Make Recurring</a></li>
        <?php if(isset($update_id) && !empty($update_id)){ ?>
        <li>
            <div class="dropup "> <a href="#" class="make_recurring_slide_2 dropdown-toggle" data-toggle="dropdown">More </a>
                <ul class="dropdown-menu cus-drop-posi-s">
                    <li><a href="#" id="copy-sq-d">Copy</a></li>
                    <li><a href="#" id="delete-sq-d" data-sq-id="<?php echo $update_id ?>">Delete</a></li>
                    <li><a href="#">Audit history</a></li>
                </ul>
            </div>
        </li>
        <?php } ?>
        <li>
            <div class="dropup "> <a href="#" class="make_recurring_slide_2 dropdown-toggle" data-toggle="dropdown">Customize </a>
                <ul class="dropdown-menu cus-drop-posi-s">
                    <?php
                        $currentStyleUrl = '';
                        $latestStyleUrl = base_url() . "invoice-template?formtype={$templates[0]['form_type']}&formid={$templates[0]['encrypted_id']}";
                        $currentTemplateId = '';
                        foreach ($templates as $index => $item) {
                            $formTemplateUrl = base_url() . "invoice-template?formtype={$item['form_type']}&formid={$item['encrypted_id']}";
                            if($item['is_default']){
                                // for styling
                                $icon = "<i class='fa fa-check text-success'></i>";
                                $listItemClass = 'default_list_item-s';
                                
                                $currentStyleUrl = $formTemplateUrl;
                                $currentTemplateId = $item['encrypted_id'];
                                // base_url() . "invoice-template?formtype={$item['form_type']}&formid={$item['encrypted_id']}";
                            }
                            else{
                                $icon = '';
                                $listItemClass = '';

                                if($index == count($templates)-1){
                                    if("" == $currentStyleUrl){
                                        $currentStyleUrl = $latestStyleUrl;
                                        $currentTemplateId = $item['encrypted_id'];
                                    }
                                }
                            }
                            echo "
                                <li class='form_template_container-d " . $listItemClass . "'>
                                    <a href='javascript::void();'class='select_template-d ' data-id='{$item['encrypted_id']}' data-url='{$formTemplateUrl}' >" . 
                                        $icon .
                                        "<span>" . $item['des_invoice_name'] . "</span>" . 
                                    "</a>
                                </li>
                            ";
                        }
                    ?>
                    <input type='hidden' name='selected_template_id' class='selected_template_id-d' value='<?php echo $currentTemplateId; ?>' />
                    <li><a href='<?php echo $currentStyleUrl; ?>' class='edit_current_form_style-d'>Edit Current</a></li>
                    <li><a href='<?php echo base_url() . "invoice-template?formtype=".$templates[0]['form_type']; ?>' class='add_new_style-d'>New Style</a></li>
                </ul>
            </div>
        </li>
    </ul>
</div>

            <input type="hidden" name="copy_sale_quotation" id="capy-sale-d" value="">    
            <div class="col-sm-4 col-md-4 col-lg-3 col-xs-6 account_new_import line-hit p-xs-0">
            <div class="input-group input-group-s pull-right">
                <?php 
                        switch ($module_flag) {
                            case 2:
                            ?>
                                <div>
                                <button class="btn btn-primary action-save-d change-save-close xs-style-btn" id="save-close-d" type="submit" action-attribute="save_close" attr-id="2" attr-module="sales">Save &amp; Close</button>
                                </div>
                                <div class="dropdown import_dropdown">
                                <span class="input-group-addon dropdown-toggle" data-toggle="dropdown"><span class="fa fa-caret-down"></span></span>
                                <ul class="dropdown-menu p0">
                                <li id="append-savenew-d" class="jv-save-cls-s">
                                <button class="jv-save-cls-s action-save-d change-add_new" action-attribute="save_add_new" id="add_new_d" type="submit" attr-id="4" attr-module="sales">Save &amp; Add New
                                </button>
                                </li>
                                <li id="append-save-send-d" class="jv-save-cls-s">
                                <button class="jv-save-cls-s action-save-d change-save-send" id="save-send-d" action-attribute="save_send" type="submit" attr-id="3" attr-module="sales">Save &amp; Send
                                </button>
                                </li>
                                </ul>
                                </div>
                                <?php
                                break;
                            case 3:
                            ?>
                                <div>
                                <button class="btn btn-primary action-save-d change-save-close xs-style-btn" id="save-close-d" type="submit" action-attribute="save_send" attr-id="3" attr-module="sales">Save &amp; Send</button>
                                </div>
                                <div class="dropdown import_dropdown">
                                <span class="input-group-addon dropdown-toggle" data-toggle="dropdown"><span class="fa fa-caret-down"></span></span>
                                <ul class="dropdown-menu p0">
                                <li id="append-savenew-d" class="jv-save-cls-s">
                                <button class="jv-save-cls-s action-save-d change-add_new" action-attribute="save_add_new" id="add_new_d" type="submit" attr-id="4" attr-module="sales">Save &amp; Add New
                                </button>
                                </li>
                                <li id="append-save-send-d" class="jv-save-cls-s">
                                <button class="jv-save-cls-s action-save-d change-save-send" id="save-send-d" action-attribute="save_close" type="submit" attr-id="2" attr-module="sales">Save &amp; Close
                                </button>
                                </li>
                                </ul>
                                </div>
                                <?php
                                break;
                            case 4:
                            ?>
                                <div>
                                    <button class="btn btn-primary action-save-d change-save-close xs-style-btn" id="save-close-d" type="submit" action-attribute="save_add_new" attr-id="4" attr-module="sales">Save &amp; Add New</button>
                                </div>
                                <div class="dropdown import_dropdown">
                                    <span class="input-group-addon dropdown-toggle" data-toggle="dropdown"><span class="fa fa-caret-down"></span></span>
                                    <ul class="dropdown-menu p0">
                                        <li id="append-savenew-d" class="jv-save-cls-s">
                                            <button class="jv-save-cls-s action-save-d change-add_new" action-attribute="save_close" id="add_new_d" type="submit" attr-id="2" attr-module="sales">Save &amp; Close
                                        </button>
                                        </li>
                                        <li id="append-save-send-d" class="jv-save-cls-s">
                                            <button class="jv-save-cls-s action-save-d change-save-send" id="save-send-d" action-attribute="save_send" type="submit" attr-id="3" attr-module="sales">Save &amp; Send
                                        </button>
                                        </li>
                                    </ul>
                                </div>
                                <?php
                                break;
                            default:
                            # code...
                            break;
                        }
                        ?>
            </div>
            <button type="submit" class="btn pull-right btn_modal_save action-save-d" action-attribute="save">Save</button>
        </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<?php
    $vatRegistered = isset($vat_profile[0]['register']) && $vat_profile[0]['register']==1 ? 1 :0;
    if(isset($defaultVatRate['sale_purchase_rate']) && count($defaultVatRate)>0 && $vatRegistered==1 ){ ?>
        <input type="hidden" name="tax_rate" value="<?php echo $defaultVatRate['sale_purchase_rate']; ?>" class="tax_rate">
    <?php }else{ ?>
        <input type="hidden" name="tax_rate" value="0" class="tax_rate">
    <?php } 
?>
</form>

<!-- load save and send -->     
<?php //$this->load->view('popup/make-recurring'); ?>
<?php $this->load->view('popup/save-send');
$this->load->view('popup/print'); ?>  
<script type="text/javascript">
    //drag and drop
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
<div id="new_vendor_content_d"></div>
<div class="modal right fade salepopup_product_inforamtion_d" id="salepopup_product_inforamtion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2"></div> -->

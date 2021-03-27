function SaveTestRecurring(){
        $company_id=$this->session->userdata('company_id');
        $branch_id=$this->session->userdata('branch_id');
        $user_index_id=$this->session->userdata('user_index_id');
        $rec_quotation_date = $this->input->post('rec_quotation_date');
        $customer_id = $this->input->post('rec_customer_id');
        $customer_id =$customer_id[0];
        $checkquarter = manageQuarterLocking($rec_quotation_date);

            if ($checkquarter != 'unlock' || empty($checkquarter)) {
            throughOutputJSON(0, 'Changes are not allowed quarter is locked!', false);
            }
            if (!empty($_POST['product_id'])) {
            $product_id = array_filter($_POST['product_id']);
            }
            if (empty($product_id)) {
            throughOutputJSON(0, 'Please enter at least one line item!', false);
            exit;
            }
               $this->form_validation->set_rules('rec_email', 'email', 'trim|required');
            if ($this->form_validation->run() == true) {

 $quotation_recurrancedata = array(
        'company_id' =>$company_id,
        'branch_id' => $branch_id,
        'customer_id' => 1,
        'document_no' => 2,
        'currency_default_index_id' => $this->input->post('rec_currency_id'),
        'quotation_no' => 5,
        'rec_temp_name' => $this->input->post('qt_rec_temp_name'),
        'schedule_type' => $this->input->post('qt_rec_schedule_type'),
        'rec_create' => $this->input->post('qt_rec_create_days'),
        'rec_reminder' => $this->input->post('qt_rec_remind_days'),
        'email' => $this->input->post('rec_email'),
        'rec_interval' => $this->input->post('qt_rec_time_interval_type'),
        'daily_days' => $this->input->post('qt_rec_time_interval_days'),
        'interval_weaks_every' => $this->input->post('rec_time_interval_weaks_every'),
        'interval_month_day_every_month' => $this->input->post('interval_month_day_every_month'),
        'interval_month_day_of_weak' =>  $this->input->post('interval_month_day_of_weak'),
        'wekly_total_day' => $this->input->post('qt_rec_time_interval_weak_day'),
        'wekly_day_name' => $this->input->post('qt_rec_time_interval_month_day'),
        'monthly_on' => $this->input->post('qt_rec_time_interval_month_day_no'),
        'yearly_month_name' => $this->input->post('time_interval_year_month'),
        'year_month_no' => $this->input->post('interval_year_month_day_no'),
        'qt_rec_end_status' => $this->input->post('qt_rec_end_status'),
        'occurrences' => $this->input->post('end_st_occurrences'),
        'rec_billing_addres' => $this->input->post('qt_rec_billing_address'),
        'rec_quotation_date' => date("Y-m-d", strtotime($this->input->post('rec_quotation_date'))),
        'rec_expire_date' => $this->input->post('rec_expire_date'),
        'rec_crew_no' => $this->input->post('rec_crew_no'),
        'acct_type' => $this->input->post('account_type'),
        'message' => $this->input->post('message'),
        'memo' => $this->input->post('memo'),
        'tax_type' => $this->input->post('tax_type'),
        'discount_inline_total' =>$this->input->post('discount_inline_total') ,
        'discount_type' =>$this->input->post('discount_type')  ,
        'discount_val' => $this->input->post('discount_val'),
        'rec_custom_field1' => $this->input->post('rec_custom_field1'),
        'rec_custom_field2' => $this->input->post('rec_custom_field2'),
        'rec_custom_field3' => $this->input->post('rec_custom_field3'),
        'rec_custom_field4' => $this->input->post('rec_custom_field4'),
        'rec_shipping_fee' =>  $this->input->post('rec_shipping_fee'),
        'created_by' => $this->session->userdata('user_index_id'),
        'created_at' => date('Y-m-d H:i:s'),
    );
    $result=$this->SalesQuotationModel->save_recurring_quotation($quotation_recurrancedata);
    if($result){

    }












    <div class="modal modal_pop_journal p0 quo-content-d" id="quotation_qbo_recurring">
    <div class="modal-dialog width_modal_journal height100-s">
        <div class="modal-content qout_recur_qbo_container height100-s">
            <form  id="" autocomplete="off" method="post" action="<?php echo base_url().'save-test-recurring-quotation';?>">
               
                <div class="modal-header journal_modal_header">
                        <div class="pull-left">
                            <div class="dropdown invoice_icon_drop">
                                <button type="button" class="btn btn-primary dropdown-toggle invoice_tbl_btn" data-toggle="dropdown">
                                    <img src="<?php echo base_url() ;?>public/admin/images/history_icon.png" class="history_icon" alt="">
                                </button>
                                <div class="dropdown-menu invoicetop_dropdown_box">
                                    <div class="col-sm-12">
                                        <h4> Recent Sale Quotation</h4>
                                        <div class="invoice_topleft_table">
                                            <table width="100%" border="0" cellspacing="2" cellpadding="2">
                                           
                                            <tr class="quotation_update_d" data-type="edit" id="">
                                                <td width="28%">Sales Quotation#. </td>
                                                <td width="19%"></td>
                                                <td width="24%"></td>
                                                <td width="20%"></td>
                                                <td width="9%"></td>
                                            </tr>
                                           
                                            </table>
                                            </div>
                                        </div>
                                        <div class="clear5"></div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="modal-title journal_pop_hdg pull-left">
                                Sale Quotation
                            </h4>
                            <div id="button_invoice_popup">
                                <button type="button" class="close pull-righ close_account_modal cancel_confirm_d cancel-rec-popup-d">
                                    <img src="<?php echo base_url() ;?>public/admin/images/cancel_try.png">
                                </button>
                                <button type="button" class="close pull-right" id="help_section_slide">
                                    <img src="<?php echo base_url() ;?>public/admin/images/question_try.png">
                                </button>
                            </div>
                        </div>
                        <!-- Modal body -->
                <div class="modal-body over_flowscroll p0">
                <div class="invocie_box_bgtop p-15">
                <div class="col-sm-12 p-xs-0">
                    <h3 class="recuring_inv_hd9 p-xs-15">Recurring Sale Quotation</h3>
                </div>
                <div class="clear20"></div>
                <div class="col-sm-12 p0">
                <!-- <form id="new_Account"> -->
                    <?php //echo "<pre>";print_array($listRecQuotationUpdate); ?>
                    <div class="col-sm-2 col-md-2 p0 p-xs-0">
                        <div class="form-group">
                            <label>Template Name </label>
                            <input type="text"  name="qt_rec_temp_name" id="temp_name_d" class="form-control" placeholder="" value="">
                        </div>
                    </div>
                   
                    <div class="col-sm-2 col-xs-12 p-xs-0">
                        <div class="form-group schedule_select bootstrap_select drop-hit-s">
                            <label>Type</label>
                            <select  name="qt_rec_schedule_type" id='rec_schedule_type_d' class="form-control selectpicker cus-lines-s">
                                <option value="1" class="transfer_schedule" >Schedule</option>
                                <option value="2"  class="transfer_reminder">Reminder</option>
                                <option value="3"  class="transfer_unschedule">UnScheduled</option>
                            </select>
                        </div>
                    </div>
                   
                    <div class="col-sm-3 col-xs-12 padd_left_input schedule_content p-xs-0">
                        <div class="display_flex_expense flex-mrg-s mt-xs-0 form-group">
                            <label>Create </label>
                            <input type="text" name="qt_rec_create_days" value="" class="form-control" placeholder="">
                          
                        </div>
                    </div>
                  
                    <div class="col-sm-4  col-xs-12 padd_left_input reminder_content hide-d p-xs-0">
                        <div class="display_flex_expense flex-mrg-s mt-xs-0 form-group">
                            <label>Remind</label> 
                            <input type="text" name="qt_rec_remind_days" value="" class="form-control" placeholder="">
                            <label>days before the transaction date </label>
                        </div>
                    </div>
                    <div class="col-sm-3  col-xs-12 padd_left_input Unscheduled_content hide-d p-xs-0">
                        <div class="display_flex_expense flex-mrg-s mt-xs-0 form-group">
                            <label>Unscheduled transactions don’t have timetables; you use them as needed from the Recurring Transactions list. </label>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-3 padd_left_input form-group p-xs-0">
                       <label>Customer</label>
                       <div class="custom-selector-s rec_get_cus_id_d">
                       
                        <div class="selectize-custom place-main-s">
                            <input type="text" placeholder="Select Customer" name="customer_id_" class="select_input rec-qt-cust-d my-place-s" value="" search-selector />
                            <div class="caret-selectize-option rec-qt-cust-d">
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </div>
                            <div class="selector-attr-hid-val-d">
                                <input type="hidden" name="rec_customer_id[]" class="rec_customer_id-d" value="2" />
                            </div>
                        </div>
                        <div class="visible-selectize-options show_cust_d visible-selectize-options-parent" attr-height="210" style="max-height: 210px;overflow: auto;">
                           <!--  <div class="child_options_list select-option-s" style="background: #ECEEF1" attr-id="add_new">
                                <p class="paragraph_left quo_add_new_d"><i style="color:#2CA01C" class="fa fa-plus"></i>&nbsp;Add New<span class="cus_text_d"></span></p>
                                <div class="clear0"></div>
                            </div> -->
                           
                                <div class="child_options_list rec_cus_d green-hover quo-get-op select-option-s" attr-id="" attr-name="rec_customer_id">
                                    <p class="paragraph_left search-d green-hover">
                                       
                                    </p>
                                    <div class="clear0"></div>
                                </div>
                          
                        </div>
                    </div>
                            <div id="quotation_recurring_content" class="selectize_popup_onclick show_rec_add_cust_d show-add-cus-d" style="display: none;">
                                <h3>New Customer </h3>
                                <label><span>*</span>Name</label>
                                <input type="text" name="customer" id="rec_customer_name_d" class="form-control" placeholder="">
                                <div class="clear10"></div>
                                <div class="col-sm-6 p0">
                                    <a href="#" class="detail_customer po_details_customer_d">+ Detail</a>
                                </div>
                                <div class="col-sm-6 p0">
                                    <button type="button" class="btn btn_term_save pull-right save_rec_customer_d">Save</button>
                                </div>
                                <div class="clear10"></div>
                            </div>
                        </div>
                        <div class="col-sm-3 place-main-s mb-xs-20 p-xs-0">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="rec_email" id="rec_email_d" class="form-control my-place-s" placeholder="Email" value="">
                                <div class="clear5"></div>
                                <div class="col-sm-8 p0">
                                </div>
                                <div class="col-sm-4 p0">
                                    <div class="form-check pull-right">
                                        <div class="dropdown text-right">
                                            <button type="button" class="btn btn-primary dropdown-toggle invoice_bcc_btn show_rec_bcc_btn" data-toggle="dropdown">
                                                Cc/Bc
                                            </button>
                                            <!-- .................popup...................... -->
                                            <div class="dropdown-menu rec_bcc_dropdown_box bcc_dropdown_box">
                                                <div class="col-sm-12 ">
                                                    <div class="form-group place-main-s">
                                                        <label>Cc </label>
                                                        <input type="text" class="form-control my-place-s" id="cc_email" name="cc_email" placeholder="Email (Seprate emails with a comma) ">
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group place-main-s">
                                                        <label>Bcc </label>
                                                        <input type="text" class="form-control my-place-s" id="bcc_email" name="bcc_email " placeholder="Email (Seprate emails with a comma) ">
                                                    </div>
                                                </div>

                                                <div class="clear5"></div>
                                                <div class="col-sm-6">
                                                    <a href="#" class="btn pull-left btn_focus_colr_black_s ccBc_cancel_d btn_save">Cancel</a>
                                                </div>
                                                <div class="col-sm-6"><a href="#" class="btn pull-right btn_save btn_focus_colr_black_s  ccBc_cancel_d save_customer_email_d">Done</a></div>
                                                <div class="clear20"></div>
                                            </div>
                                            <!-- End popup.......................... -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                        <div class="clearfix"></div>
                        <div class="unscheuled_hide display_flex_expense">
                            <!--<hr class="recurring_separator">-->
                            <div class="bootstrap_select mr-1 drop-hit-s w-xs-100">
                                <label>Interval</label>
                                <select name="qt_rec_time_interval_type" class="form-control selectpicker cus-lines-s rec_interval_d" id="rec-interval-daily-d">
                                    <option value="1" class="daily_value_onclick">Daily</option>
                                    <option value="2"  class="weekly_value_onclick">weekly</option>
                                     <option value="3"  class="monthly_value_onclick">Monthly</option>
                                    <option value="4" class="yearly_value_onclick">Yearly</option> 
                                </select>
                            </div>
                           
                            <div class="daily_value_content w-xs-100">
                                <label class="hid-xs-s">&nbsp; </label>
                                <div class="display_flex_expense">
                                    <label>every</label>
                                    <input name="qt_rec_time_interval_days"   type="text" class="form-control">
                                    <div class="clear5"></div>
                                    <label>day(s)</label>
                                </div>
                            </div>
                          
                            <div class="weekly_value_content w-xs-100 hide-d">
                                <label class="hid-xs-s">&nbsp; </label>
                                <div class="display_flex_expense">
                                    <label>every</label>
                                    <input type="text"  name="rec_time_interval_weaks_every" class="form-control">
                                    <div class="clear5"></div>
                                    <label>week(s)</label>
                                    <label>&nbsp; on &nbsp; </label>
                                   
                                    <div class="bootstrap_select">
                                        <select name="qt_rec_time_interval_weak_day"  class="form-control selectpicker interval_weak_day_d">
                                            <option value="">Select Days</option>
                                            <option value="sunday">Sunday</option>
                                            <option value="monday">Monday</option>
                                            <option value="tuesday">Tuesday</option>
                                            <option value="wednesday">Wednesday</option>
                                            <option value="thrusday">Thrusday</option>
                                            <option value="friday">Friday</option>
                                            <option value="saturday">Saturday</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="monthly_value_content w-xs-100 hide-d">
                                <label class="hid-xs-s">&nbsp; </label>
                                <div class="display_flex_expense">
                                    <label>on &nbsp; </label>
                                    <div class="bootstrap_select mb-xs-20">
                                        <select name="qt_rec_time_interval_month_day"  class="form-control selectpicker">
                                            <option value="1"  class="days_onclick_number">day</option>
                                            <option value="2"  class="weekly_name_onclick">first</option>
                                            <option value="3"  class="weekly_name_onclick">second</option>
                                            <option value="4"  class="weekly_name_onclick">third</option>
                                            <option value="5" class="weekly_name_onclick">four</option>
                                            <option value="6"  class="weekly_name_onclick">last</option>
                                        </select>
                                    </div>
                                    <div class="bootstrap_select days_option_onclick mb-xs-20 ">
                                        <select name="qt_rec_time_interval_month_day_no" class="form-control selectpicker">
                                       
                                            <option value="">month day no</option>
                                            <option value="sunday">sunday</option>
                                            <option value="monday">monday</option>
                                            <option value="tuesday">tuesday</option>
                                            <option value="wednesday">wednesday</option>

                                        </select>
                                    </div>
                                 
                                    <div class="bootstrap_select week_option_onclick">
                                        <select name="interval_month_day_of_weak" class="form-control selectpicker">
                                            <option  >Select option</option>
                                            <option value="1">Monday</option>
                                            <option value="2">Tuesday</option>
                                            <option value="3">Wednesday</option>
                                            <option value="4">Thrusday</option>
                                            <option value="5">Friday</option>
                                            <option value="6">Saturday</option>
                                        </select>
                                    </div>

                                   
                                    <label>of every</label>
                                    <input type="text"  name="interval_month_day_every_month" class="form-control">
                                    <div class="clear5"></div>
                                    <label>month(s)</label>
                                </div>
                            </div>
                            <div class="yearly_value_content w-xs-100 hide-d">
                                <label class="hid-xs-s">&nbsp; </label>
                                <div class="display_flex_expense">
                                    <label>on &nbsp; </label>
                                    <div class="bootstrap_select mb-xs-20">
                                        <select name="time_interval_year_month" class="form-control selectpicker" id="months_type">
                                         
                                        <option value="1">Jan</option>
                                        <option value="2">Feb</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        
                                        </select>
                                    </div>
                                    <div class="bootstrap_select mb-xs-20">
                                        <select name="interval_year_month_day_no" class="form-control selectpicker">
                                      
                                            <option value="1">1st</option>
                                            <option value="2">2nd</option>
                                            <option value="3">3rd</option>
                                            <option value="4">4th</option>
                                            <option value="5">5th</option>
                                            <option value="6">6th</option>
                                            <option value="7">7th</option>
                                            <option value="8">8th</option>
                                       
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="start_date_unschedule w-xs-100 p-xs-0">
                                <div class="form-group place-main-s w-xs-100">
                                    <label>Start Date</label>
                                     <div class="ui calendar datepicker_new" id="rec_qut_date_d">
                                    <div class="ui input left icon">
<!--                                         qt_rec_start_date
 -->                  <input class="my-place-s" type="text" name="start_date" placeholder="Date">
                                    </div>
                                </div>
                                   <!--  <div class="ui calendar datepicker_new" id="rec_stdate_d">
                                        <div class="ui input left icon">
                                            <input class="my-place-s" type="text" name="qt_rec_start_date" placeholder="Date" value="">
                                        </div>
                                    </div> -->
                                </div>
                                     
                                <div class="bootstrap_select mr-1 ml-1 w-xs-100 p-xs-0">
                                    <div class="form-group drop-hit-s">
                                        <label>End</label>
                                        <select name="qt_rec_end_status" class="form-control selectpicker cus-lines-s end_status_d">
                                       
                                        <option class="" value=""  class="end_none_show">None</option>
                                        <option value="by">By</option>
                                        <option value="after">after</option>

                                         
                                        </select>
                                    </div>
                                </div>
                               <!--  <div class="end_value_content hide-d w-xs-100 p-xs-0">
                                    <div class="form-group">
                                        <label>Start End Date</label>
                                        <div class="ui calendar datepicker_new" id="rec_enddate_d">
                                            <div class="ui input left icon">
                                                <input class="" name="qt_rec_end_st_strt_date" type="text" placeholder="Date">
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                
                                <div class="end_value_occurr hide-d w-xs-100 p-xs-0 mb-xs-20">
                                    <label class="hid-xs-s">&nbsp; </label>
                                    <div class="clearfix"></div>
                                    <input type="text" name="end_st_occurrences"  class="form-control float-left">
                                    <label class="float-left">occurrences</label>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="clear10"></div>
                        <div class="col-sm-2 padd_left_input p-xs-0">
                            <div class="form-group">
                                <label>Biling address </label>
                                <textarea name="qt_rec_billing_address" id="rec_billing_address_d" class="form-control textarea_credit text-area-s"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-2 padd_left_input p-xs-0">
                            <div class="form-group place-main-s">
                                <label>Sale Quotation Date </label>
                                 <div class="ui calendar datepicker_new" id="rec_expire_date_d">
                                        <div class="ui input left icon my-place-s">
                                            <input class="my-place-s" type="text" name="rec_quotation_date" placeholder="Date" id="rec_qut_date_d">
                                        </div>
                                    </div>
                               
                            </div>
                            <div class=" padd_left_input bootstrap_select currency-attr-d">
                                <div class="form-group bootstrap_select drop-hit-s">
                                    <label>Sale Currency</label>
                                    <select name="rec_currency_id" id="rec_currency_d" class="form-control selectpicker cus-lines-s">
                                      <option value="pak">Pak</option>
                                      <option value="usd">USD</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" id="rec_lbp_curr_rate_d" rec-def-curr-id="" name="" data-sq-rec-flag="">
                            </div>
                            <div class="col-sm-2 padd_left_input p-xs-0">
                                <div class="form-group place-main-s">
                                    <label>Expiration Date </label>
                                    <div class="ui calendar datepicker_new" id="rec_expire_date_d_r">
                                        <div class="ui input left icon my-place-s">
                                            <input class="my-place-s" type="date" name="rec_expire_date" placeholder="Date" id="rec_so_exp_date_d_r" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group bootstrap_select drop-hit-s discounttype-attr-d" >
                                    <label>Discount Type</label>
                                    <select name="discount_inline_total" id="rec_discount_total_d" class="form-control selectpicker cus-lines-s">
                                        <option value="">Select discount</option>
                                        <option value="1">In-line Discount</option>
                                        <option value="2" >Discount on totals</option>   
                                    </select>
                                </div>
                            </div>
                            
                           <!-- //.......terms............ -->
                           <!-- //..............terms -->
                          <div class="col-sm-2 padd_left_input show_trm-d terms-attr-d ">
                           <div class="form-group">
                              <label>Terms</label>
                              
                              <div class="custom-selector-s">
                               
                                 <div class="selectize-custom">
                                    <input type="text" name="so_term_id_" class="select_input rec_sqo-terms-d" placeholder="Select Term"  search-selector />
                                    <div class="caret-selectize-option caret-show-s rec_sqo-terms-d">
                                       <i class="fa fa-caret-down" aria-hidden="true"></i>
                                    </div>
                                    <div class="selector-attr-hid-val-d">
                                       <input type="hidden" name="rec_sqo_term" class="rec_sqo_terms-d"  />
                                    </div>
                                 </div>
                                 <div class="visible-selectize-options rec_append_terms_option_d" attr-height="200">
                                    <div class="child_options_list select-option-s" style="background: #ECEEF1" attr-id="add_new">
                                      
                                       <p class="paragraph_left rec_add-new-term-ddd"><i style="color:#2CA01C" class="fa fa-plus"></i>&nbsp;Add New 
                                          <span class="search-word-app-d cus_text_s"></span>
                                       </p>
                                       <div class="clear0"></div>
                                    </div>
                                   
                                    <div class="child_options_list green-hover select-option-s quo-get-op" attr-month="" attr-day-field="" attr-id="" attr-name="rec_sqo_term">
                                       <p class="paragraph_left search-d green-hover">
                                         
                                       </p>
                                       <div class="clear0"></div>
                                    </div>
                                   
                                 </div>
                              </div>
                           </div>
                        </div>
                        <input type="hidden" name="pppp" value="<?php if(isset($detail[0]['product_id'])){ echo $detail[0]['product_id'];}?>">
                           <!-- ................ -->
                <!--             <div class="col-sm-2 p-xs-0 padd_left_input qo-field-crew-d crew-attr-d" style="display:">
                                <div class="form-group">
                                    <label></label>
                                    <input type="text" name="rec_custom_field1" class="form-control" value="">
                                </div>
                            </div>
                            <div class="col-sm-2 p-xs-0 padd_left_input qo-field-custom2-d custom2-attr-d" style="display:">
                                <div class="form-group">
                                    <label></label>
                                    <input type="text" name="rec_custom_field2" class="form-control" value="">
                                </div>
                            </div>
                                                  <div class="col-sm-2 p-xs-0 padd_left_input qo-field-custom3-d custom3-attr-d" style="display:">
                                <div class="sq-custom-f-s form-group">
                                    <label></label>
                                    <input type="text" name="rec_custom_field3" class="form-control" value="">
                                </div>
                            </div>
                          
                            <div class="col-sm-2 p-xs-0 padd_left_input  qo-field-custom_field-d custom_field-attr-d" style="display:">
                                <div class="sq-custom-f-s form-group">
                                    <label></label>
                                    <input type="text" name="rec_custom_field4" class="form-control" value="">
                                </div>
                            </div> -->
                            <!-- shipping fee from setting hide show -->
                            <div class="col-sm-2 padd_left_input shipping_fee-attr-d ">
                                <div class="sq-custom-f-s form-group">
                                    <label>Shipping Fee</label>
                                    <input type="text" name="rec_shipping_fee" class="form-control" >
                                </div>
                            </div>
                           
                            <div class="clearfix"></div>
                                    <?php $this->load->view('pages/error-message-box'); ?>
                     
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clear20"></div>
                <div class="bottom_area_invoice p-15">
                   <div class="table_main">
                     <div class="form-group pull-right amounts_tbl_select drop-hit-s">
                         <div class="col-xs-5 col-sm-4 p0 p-xs-15">
                           <label class="lbl_normal3 ">Amounts are</label>
                       </div>
                       <div class="line2-s"></div>
                       <div class="col-xs-7 col-sm-8 padd_right_input bootstrap_select tax-bg pl-0-xs-s ">
                        <select name="tax_type" class="form-control selectpicker" id="rec_tax_type_d">
                            <option value="2" >Exclusive of Tax</option>
                            <option value="1" >Inclusive of Tax</option>
                            <option value="3" >Out of scope of Tax</option>
                        </select>
                    </div>
                </div>
                <div class="clear10"></div>
                <div class="h-xs-300">

                    <input type="hidden" class="rec_quotation_update_d" data-type="" id="update_id_d" name="update_id" value="">
                    <table width="100%" class="table table-bordered table_add_new_row table_recuring_d w-xs-1170 recur_row_input" id="table_recuring_sorting_d" >
                        <thead>
                            <tr>
                                <th width="3%" class="" align="center" valign="middle" class="text-center">&nbsp;</th>
                                <th width="3%" align="center" valign="middle" class="text-center">#</th>
                                <th width="13%" class="text-left" valign="middle">Product/Service</th>
                                <th width="24%" class="sku-d rec_sku-d" align="center" valign="middle">SKU</th>
                                <th width="28%" class="" align="center" valign="middle">Description</th>
                                <th width="10%" class="" align="center" valign="middle">QTY</th>
                                <th width="10%" class="" align="center" valign="middle">Unit Price</th>
                                <th width="10%" class="rec_dis_type_d hide-d" align="center" valign="middle">Discount Type</th>
                                <th width="10%" class="rec_dis_type_d hide-d" align="center" valign="middle">Discount</th>
                                <th width="10%" class="vat_type_d rec_vat_type_d hide-d" align="center" valign="middle">VAT</th>
                                <th width="10%" class="tax_type_d rec_tax_type_d hide-d" align="center" valign="middle">Tax</th>
                                <th width="10%" class="" align="center" valign="middle">Amount(<span class="rec_currency_symbol_d">LBP</span>)</th>
                                <th width="3%" class="" align="center" valign="middle"></th>
                            </tr>
                        </thead>
                        <tbody class="auto-w-s">
                      
                               <tr>
                                <input type="hidden" class="rec_real_amount_d" value=""> 
                              
                                <input type="hidden" data-ratefor-total="" data-outof-scope="" name="default_rate[]" class="default_rate_d rec_default_rate_d" value="" data_istax='1'>
                                <input type="hidden" name="update_table_id[]" value="">
                                <input type="hidden" id="simple_get" value="">
                                <td align="center" valign="middle" class="add_movable text-center padding_end">
                                    <img src="<?php echo base_url() ;?>public/admin/images/toggle.png" />
                                </td>
                                <td align="center" valign="middle" class="padding_end"></td>

                                <td class="selector-text-s rec_quo-product-d td-slectorz-span-fnd-d">
                               
                                <div class="custom-selector-s hide-d">
                                    <div class="selectize-custom">
                                        <input type="text" name="product_id_" class="select_input rec-qt-prod-d hide-d" value="" search-selector />
                                        <div class="caret-selectize-option caret-show-hide-d rec-qt-prod-d hide-d">
                                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                                        </div>
                                        <div class="selector-attr-hid-val-d">
                                            <input type="hidden" name="product_id[]" class="product_id-d" value="" />
                                        </div>
                                    </div>
                                    <div class="visible-selectize-options min-wid append-selectize-pro-d hide-d" attr-height="200">
                                        <div class="child_options_list select-option-s" style="background: #ECEEF1" attr-id="add_new">
                                            <p class="paragraph_left"><i class="fa fa-plus"></i>&nbsp;Add New</p>
                                            <div class="clear0"></div>
                                        </div>
                                       
                                                <div class="child_options_list select-styling select-option-s comon-pro-d rec_get_pro_id" attr-id="" attr-name="product_id" >
                                                    <p class="paragraph_left search-d select-drop"></p><p class="paragraph_right select-drop"></p>
                                                    <div class="clear0"></div>
                                                </div>
                                         
                                        </div>
                                    </div>
                                    <span></span>
                                </td>
                                <td class="text-left sku-d rec_sku-d " valign="middle">
                                    <input name="rec_sku[]" class="form-control sku-d re_sku-d" readonly value="">
                                    <span></span>
                                </td>
                                <td class="text-left show_rec_des_d show_des_d selector-text-s move-up-down-row-d" valign="middle">
                                        <input name="description[]" class="form-control rec_des_d des_d" type="text" value="">
                                        <span></span>
                                    </td>
                                    <td class="text-left show_rec_qty_d show_qty_d move-up-down-row-d recur_row_input" valign="middle">
                                        <input name="qty[]" class="form-control rec_qty_d qty_d on_hover_tooltip1" type="text" value="">
                                        <span>

                                    </span>
                                </td>
                                <td class="text-left show_rec_rate_d show_rate_d move-up-down-row-d recur_row_input" valign="middle">
                                    <input name="rate[]" class="form-control rec_rate_d rate_d" type="text" value="">
                                    <span> 
                                       
                                    </span>
                                </td>
                                <td class="rec_show_inline_disc_d show_inline_disc_d rec_dis_type_d hide-d">
                                    <div class="bootstrap_select">
                                        <select name="rec_inline_discount_type[]" class="form-control hide-d quo-tax-s rec_show_select_d show_select_d selectpicker rec_inlinespan">
                                            <option value="">Select type</option>
                                            <option value="1" >Percentage</option>
                                            <option value="2" >Amount</option>
                                        </select>
                                        <span></span>
                                    </div> 
                                </td>
                                <td class="text-left show_rec_discount_d show_discount_d rec_dis_type_d hide-d move-up-down-row-d recur_row_input" valign="middle">
                                    <input name="discount[]" class="form-control rec_discount_d discount_d" type="text" value="">
                                    <span></span>
                                </td>
                                <td class='show_inline_vat_d hide-d move-up-down-row-d rec_vat_type_d vat_type_d'>
                                    <select name="vat_rate[]" class="form-control hide-d vat-tax-s rec_vat-tax-d vat-tax-d rec_show_vat_d show_vat_d selectpicker">
                                        <option value='0'>Select type</option>
                                      
                                            <option  data-vat="" value=""></option>
                                       
                                    </select>
                                    <span class="rec_vat_span vat_span"></span>
                                </td>
                                <td class="text-left rec_show_tax_d show_tax_d tax_type_d rec_tax_type_d hide-d" valign="middle">
                                  
                                    <input name="tax[]" class="form-control rec_tax_d tax_d" type="text" readonly="" data-tax-type="" value="">
                                    <span></span> 
                                </td>
                                <td class="text-left recur_row_input show_rec_amount_d show_amount_d move-up-down-row-d last_td_tooltip_s" valign="middle">
                                    <input name="amount[]" class="form-control rec_amount_d amount_d" type="text" value="">
                                    <span></span>
                                </td>
                                <td align="center" valign="middle" class="padding_end">
                                    <button type="button" class="del no-del rec_del_d">
                                        <img src='<?php echo base_url() ;?>public/admin/images/delete_qbo.png'>
                                    </button>
                                </td>
                            </tr> 
                           
                        </tbody>
                    </table>
                </div>
            </div>  
            <input type="hidden" value="" id="rec_cur_curnt_rate_d">
            <input type="hidden" value="" id="rec_cur_prev_rate_d">
            <div class="clear20"></div>
             <button type="button" class="btn pull-left btn_cancel_form add_recur_line_onclick ">Add line</button>
                <button type="button" class="btn pull-left btn_cancel_form rec-quotation-clear-d">Clear All Line</button>
                <button type="button" class="btn pull-left btn_cancel_form inv-subtotal quot_recur_subtotal_d">Add Sub Total</button>
                <div class="clear10"></div>
            <div class="invoice_column_reverse">
             <div class="col-sm-8 p0 invoice_margin_bottom">
                <div class="clear20"></div>
               
                <!-- ....................................... -->
            
                <div class="col-sm-8 p0">
                    <div class="clear5"></div>
                    <label class="message_label">Message displayed to client.</label>
                    <div class="clear5"></div>
                    <div class="form-group">
                        <textarea  name="message" class="form-control textarae_h_invoice" rows="5" id="rec_comment" placeholder=""></textarea>
                    </div>
                </div>
                <div class="col-sm-8 p0">
                    <div class="clear5"></div>
                    <label class="message_label">Memo </label>
                    <div class="clear5"></div>

                    <div class="form-group">
                        <textarea name="memo" class="form-control textarae_h_invoice" rows="5" id="rec_memo" placeholder=""></textarea>
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
                                <div class="rec-file-content-d">
                                   
                                        <div class="remove-imd-d" style="display: flex; align-items: center;padding: 0px 0px 0px 20px; height: 25px;">
                                            <div class="chiller_cb">
                                                <input name="attachments" id="vat_2" class="attach-checkbox-d" value="" type="checkbox">
                                                <label for="vat_2">&nbsp;</label>
                                                <span></span>
                                            </div>
                                            <span class="attach-email-s">Attach to email</span>
                                            <a href="" target="_blank" class="attachment-a-s" style="font-size:13px; margin: 0px 5px 0px 20px;word-break: break-word; float: left;"></a>
                                            <span class="file-size-s">(19.5)</span>
                                            <a class="atta-file-s" style="float: left;margin-right: 5px;">
                                                <img src="<?php echo base_url('public/admin/images/attach_cross.png'); ?>"/>
                                            </a>
                                        </div>
                                 
                                </div>
                                <input class="file-upload-input checkbox-img-d" name="atta_file_names_d" id="rec_atta_file_names_d" type="file" multiple="multiple" />
                                <div class="drag-text">
                                    <h3>Drag/Drop files here or click the icon</h3>
                                </div>
                                <svg class="svg-progress-bar-30-right progress-bar-load-d hide-d" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200">
                                  <circle class="path-progress-bar" stroke-width="10" stroke-miterlimit="10" class="cls-1 path" cx="100" cy="100" r="94" /></svg>
                              </div>
                          </div>
                      </div>
                      <div class="clear20"></div>
                       <div class="clear30"></div>
    <div class="clear30"></div>
                  </div>
              </div>
                <div class="col-xs-12 col-md-4 col-sm-4 pull-right invoice_label_colorright padd_right_input credit_total_main p-xs-0 mt-xs mt-lg-40">
                    <div class="col-sm-6 col-xs-6 text-left invoice_label_colorright invoice_label_colorright_font">Subtotal</div>
                    <div class="col-sm-6 col-xs-6 text-right invoice_label_colorright invoice_label_colorright_font p0 ">
                        <span class="rec_currency_symbol_d"></span>&nbsp; 
                        <span class="rec_show_sub_total_d">
                          
                                
                            </span>
                    </div>
                    <input type="hidden" class="rec_sub_total_d" value="" >
                    <div class="clear10"></div>
                    <div class="toggle_tax_main_recurring">
                    <div class="clear10"></div>
                        <div class="col-sm-12 slide_up_credit p0 hide-d" id="rec_show_hide_inline_dis_d" >
                            <div class="col-sm-6 col-xs-9 discount_d_flex discount-width p0 cus-width wid-114 drop-hit-s">
                                <div class="line3-s"></div>
                                <div class="form-group">
                                    <select name="discount_type" class="form-control selectpicker cal_rec_discount_d">
                                        <option value="1" >Discount percent</option>
                                        <option value="2" >Discount value</option>
                                    </select>
                                    <input type="text" name="discount_val" class="form-control text-right discount_rec_val_d" data-per-flag="" value="">
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                           
                            <div class="col-xs-3 col-sm-4 text-right padd_right_input p-xs-0">
                                <input type="text" name="subtotal_discount" id="rec_total_with_dis_d" value="" class="form-control rec_hide_dis_input_d" readonly="readonly">
                                <input type="text" name="subtotal_discount" id="rec_value_dis_d" value="" class="form-control hide-d rec_h_s_dis_d"> 
                            </div>
                        </div>
                        <div class="clear10 hide-d rec_discount_label_d hide-d"></div>
                         <div class="col-sm-12 slide_up_credit p0 rec_discount_label_d hide-d">
                            <div class="col-sm-6 col-xs-6 text-right">
                               Inline Discount Percent
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4 col-xs-6 pr-0 text-right padd_right_input">
                                <input type="text" id="rec_inline_dis_percent_d" name="" value="" class="form-control" placeholder="0.00" readonly="readonly">
                            </div>
                        </div>
                        <div class="clear10 rec_discount_label_d hide-d"></div>
                        <div class="col-sm-12 slide_up_credit p0 rec_discount_label_d hide-d">
                            <div class="col-sm-6 col-xs-6 text-right">
                               Inline Discount Amount
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4 col-xs-6 pr-0 text-right padd_right_input">
                                <input type="text" id="rec_inline_dis_amount_d" name="" value="" class="form-control" placeholder="0.00" readonly="readonly">
                            </div>
                        </div>
                        <!-- </div> -->
                        <div class="clear10 rec_vat_d"></div>
                        <div class="col-sm-12 slide_up_credit p0  rec_vat_d">
                            <div class="col-sm-6 col-xs-6 text-right invoice_label_colorright_font">
                             VAT
                         </div>
                         <div class="col-sm-2"></div>
                         <div class="col-sm-4 col-xs-6 text-right padd_right_input pr-0">
                            <input type="text" name="subtotal_discount1" value="" id="rec_vat_total_d" class="form-control" placeholder="0.00" >
                        </div>
                    </div>
                    <div class="clear10 lbp_rec_vat_equi_d"></div>
                    <div class="col-sm-12 slide_up_credit p0 lbp_rec_vat_equi_d">
                        <div class="col-sm-6 col-xs-6 text-right invoice_label_colorright_font">
                        Vat Equivalent in LBP
                     </div>
                     <div class="col-sm-2"></div>
                     <div class="col-sm-4 col-xs-6 pr-0 text-right padd_right_input">
                       <input type="text" name="subtotal_discount3" value="" id="lbp_rec_vat_equ_d" class="form-control" placeholder="0.00" readonly="readonly">
                   </div>
               </div>
               <!-- <div class="clear10 rec_discount_label_d hide-d"></div>
               <div class="col-sm-12 slide_up_credit p0 hide-d rec_discount_label_d hide-d">
                <div class="col-sm-6 text-right invoice_label_colorright_font">
                 Discount Label
             </div>
             <div class="col-sm-2"></div>
             <div class="col-sm-4 text-right padd_right_input">
                <input type="text" name="subtotal_discount13" value="" class="form-control" placeholder="0.00" readonly="readonly">
            </div> -->
        <!-- </div> -->

    </div>

    <div class="clear10"></div>
    <hr>
    <div class="clearfix"></div>
    <div class="col-sm-6 col-xs-6 text-left invoice_label_colorright invoice_label_colorright_font">Total Amount</div>
    <div class="col-sm-6 col-xs-6 text-right invoice_label_colorright_font p0 ">
        <span class="rec_currency_symbol_d"></span>&nbsp;<span class="rec_show_gtotal_d"></span>
    </div>
        <div class="clear10"></div>
            <input type="hidden" id="rec_total_withoutComa_d" value="" />
            <hr>
                <div class="rec-total-lbp-d">
                    <div class="clear10"></div>
                    <div class="clearfix"></div>
                    <div class="col-sm-6 col-xs-6 text-left invoice_label_colorright invoice_label_colorright_font">Total Amount(LBP)</div>
                    <div class="col-sm-6 col-xs-6 text-right invoice_label_colorright_font p0 show_rec_gtotal_lbp_d"></div>
                    <div class="clear10"></div>
                    <hr>
                    <input type="hidden" name="total" id="rec-hidden-total-d" value="">
                    <div class="clear10"></div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="modal-footer modal_invoice_footer set-modal-height-s h-xs-50">
    <div class="col-sm-3 col-xs-7">
        <button type="button" class="btn pull-left btn_modal_cancel valid rec_modal_dismiss" data-dismiss="modal" aria-invalid="false">Cancel</button>
        <!-- <button  class="btn pull-left recuring-cancel-d btn_focus_colr_white_s">Cancel</button> -->
        <button  class="btn pull-left recuring-clear-btn-d btn_modal_clear  btn_focus_colr_white_s">Clear</button>
    </div>
    <div class="col-sm-4 col-xs-5  pull-right">
        <button type="submit" class="btn btn_save_template quot_rec_save_btn_d">Save Template</button>
    </div>
    <div class="clearfix"></div>
</div>
</div>
</div>
</div>

        <input type="hidden" name="tax_rate" value="" class="tax_rate">
    
        <input type="hidden" name="tax_rate" value="0" class="tax_rate">
   
</form>
</div>
</div>
</div>
<div id="new_customer_content_d"></div>
<!-- <script src="public/admin/js/quotation_recuring.js"></script> -->
<div id="new_customer_content_d"></div>
<div class="modal right fade salepopup_product_inforamtion_d" id="salepopup_product_inforamtion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2"></div>

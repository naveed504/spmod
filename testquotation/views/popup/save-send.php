<?php
    $templateNature = (isset($templateNature) && ('' != $templateNature) )? $templateNature : 'Quotation';
    $messageBody = "Dear customer!
    Please review the {$templateNature}.  Feel free to contact us if you have any questions.We look forward to working with you.

Thanks for your business!";
?>
<form id="email-send-attach-form-d">
    <div class="modal" id="save-send-open-d">
        <div class="modal-dialog modal_dialog_new">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header modal_close">
                    <h4 class="modal-title modal_acount_email">Send email</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                        <div class="col-md-6">
                            <div class="col-sm-12 padd_left_input">
                                <div class="form-group place-main-s">
                                    <label class="label_clr_popup">Email To</label>
                                    <!-- input_disable -->
                                    <input type="email" name="email" class="form-control my-place-s" id="customer_email" value="" readonly="">
                                </div>
                                <div class="form-group place-main-s email-cc-d hide-d">
                                    <label class="label_clr_popup">Email Cc</label>
                                    <input type="email" name="emailbcc" id="email-bcc" value="" class="form-control my-place-s" readonly="">
                                </div>
                                <div class="form-group place-main-s email-bcc-d hide-d">
                                    <label class="label_clr_popup">Email Bcc</label>
                                    <input type="email" name="emailcc" id="email-cc" value="" class="form-control my-place-s" readonly="">
                                </div>
                            </div>
                            
                            <div class="clearfix"></div>
                            <div class="col-sm-12 padd_left_input">
                                <div class="form-group place-main-s">
                                    <label class="label_clr_popup">Subject</label>
                                    <?php
//                                        $email_subject = isset($account_setting['email_subject']) && !empty($account_setting['email_subject']) ? $account_setting['email_subject'] : ''; 
//                                        $sub = strstr($email_subject, 'from', true);
//                                        $subj = $sub.'from '.$company_name;
                                        
                                        $subject = isset($email_setting['em_standard_settings'])?$email_setting['em_standard_settings']['email_subject']:'';
                                        $quotation_no = isset($update_id)?$update_id:'';
                                        if(!empty($quotation_no)){ 
                                            $quot_subject = str_replace('[Order Number]', 'SQ#'.$update_id, $subject);
                                        }else{
                                            $quot_subject = str_replace('[Order Number]', 'SQ# ', $subject);
                                        }
                                    ?>
                                    <input type="text" name="subject" id="email_subject" class="form-control my-place-s" 
                                            value="" placeholder="Enter Subject">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-12 col-xs-12 padd_left_input">
                                <div class="form-group place-main-s">
                                    <label class="label_clr_popup">Message</label>
                                    <textarea rows="" name="message" id="email_msg" cols="" class="text_area_width form-control my-place-s " placeholder="Enter Message Body"><?php if(isset($email_setting['em_standard_settings']['message_to_customer_textarea'])){ echo $email_setting['em_standard_settings']['message_to_customer_textarea']; }else{ echo $messageBody; }?>
                                </textarea>
                                </div>
                                <input type="hidden" name="trx_id" id="trx_id-d" value="">
                                <input type="hidden" name="module_name" id="module-name-d" value="">
                                <input type="hidden" name="template_id" id="template_id" value="">
                                <input type="hidden" name="from_email" id="from-email" value="">
                                <input type="hidden" name="from_name" id="from-name" value="">
                            </div>
                        </div>
                        <div id="attach-imag-email-send-d" class="hide-d">

                        </div>    
                        <div class="col-sm-6">
                            <?php /* ?>
                            <img src="<?php echo base_url() ;?>public/admin/images/raseed.png" class="img-responsive">
                            <?php */
                            $file = '';
                                $css = 'width:100%; height: 324px;';
                                if( isset($printPreviewFileUrl) && '' != $printPreviewFileUrl ){
                                    $fileUrl = $printPreviewFileUrl;
                                    $file = $printPreviewFileUrl;
                                }
                                else {
                                    $fileUrl = "";
                                }
                            ?>
                            <iframe id='printPreviewContainer-d' src="<?php echo $fileUrl; ?>" style="<?php echo $css; ?>"></iframe>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12">
                            <div class="separator"></div>
                        </div>
                        <div class="clear20"></div>
                        <div class="col-sm-12 p0">
                            <div class="col-sm-4 col-xs-4">
                                <button type="button" class="btn pull-left btn_cancel_form btn_cancel_width" data-dismiss="modal">Cancel</button>
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-6 col-xs-8 input_new_import">
                                <div class=" pull-right ">
                                    <div class="arrow_box_invoice_saved" style="display: none;">
                                        <button type="button" class="close pull-right close_invoice_modal">×</button>
                                        <ul>
                                            <h3><span><i class="fa fa-check-circle" aria-hidden="true"></i></span> Invoice xxx Saved</h3>
                                        </ul>
                                    </div>
                                    <button type="button" class="btn pull-right btn_cancel_form btn_cancel_width send-customer-email-attach-d">Send and close</button>
                                    <a class="btn pull-right btn_cancel_form btn_cancel_width"  href="#" id="onclick_invoice_download" download target="_blank" style="padding-top: 6px;">Print</a>
                                    <!--<button type="button" class="btn pull-right btn_cancel_form btn_cancel_width" id="onclick_invoice_open">Print</button>-->
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</form>
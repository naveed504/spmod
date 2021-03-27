<?php
    $templateNature = (isset($templateNature) && ('' != $templateNature) )? $templateNature : 'Quotation';
?>
<form id="email-send-attach-form-d">
    <div class="modal" id="print-d">
        <div class="modal-dialog modal_dialog_new">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header modal_close print_close">
                    <!-- <h4 class="modal-title modal_acount_email">Print</h4> -->
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                        <div class="col-sm-12">
                            <?php /* ?>
                            <img src="<?php echo base_url() ;?>public/admin/images/raseed.png" class="img-responsive">
                            <?php */
                                $css = 'width:100%; height: 505px;';
                                if( isset($printPreviewFileUrl) && '' != $printPreviewFileUrl ){
                                    $fileUrl = $printPreviewFileUrl;
                                }
                                else {
                                    $fileUrl = "";
                                }
                            ?>
                                <iframe id='print-preview-d' type="application/pdf" src="<?php echo $fileUrl; ?>" style="<?php echo $css; ?>"></iframe>
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
                                    <!-- <button type="button" class="btn pull-right btn_cancel_form btn_cancel_width send-customer-email-attach-d">Save and close</button> -->
                                    <button type="button" onclick='printDiv();' class="btn pull-right btn_cancel_form btn_cancel_width" id="onclick_invoice_open">Print</button>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
function printDiv() 
{
    $("#print-preview-d").get(0).contentWindow.print();
}
</script>
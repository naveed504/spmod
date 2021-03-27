<?php $this->load->view('popup/test-quotation'); ?>
<?php $this->load->view('popup/make-recurring'); ?>
<?php $this->load->view('popup/confirm-modal'); ?>
<!-- //......................... -->
<div id="add_new_term_content"></div>
<!-- ----------------------popup message html start------------------------- -->   
 <div id="success_modal_d" class="modal fade bg_tr_inc_pop6" role="dialog" aria-hidden="true" style="display: none;z-index:9999;top:12px;">
    <div class="modal-dialog bg_tr_inc_pop6 message-show-s">
        <div class="modal-content inv_save_btn_bdr">
            <div class="modal-header hdr_modal_act_pop16">
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body p0">
                <div class="arrow_box_invoice_saved9" style="">
                    <ul>
                        <h3>
                            <span>
                                <i class="fa fa-check-circle" aria-hidden="true"></i>
                            </span>
                            <span class="show-success-pop-d"></span>
                        </h3>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal show-confirm-model-d" id="close_confirm_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="inventory_links">
                    <p class="confirm_box_text_d"></p>
                </div>
                <div class="Clearfix"></div>
                <div class="modal_footer">
                    <button type="button" class="btn btn_no_cross pull-left cancel_d">No</button>
                    <button type="button" data-attr="close_form" class="btn btn_yes_cross pull-right confirm-rec-yes-d confirm-yes-d">Yes</button>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clear10"></div>
        </div>
    </div>
</div>

<div id='activeTemplateContainer-d' class='hide-d'>
    <?php
        if(null != $templateHtmlObj){
            $templateHtml = $templateHtmlObj['template_html'];
            // $templateHtml = htmlspecialchars($templateHtml, ENT_HTML5, ENT_NOQUOTES);
            // $templateHtml = str_replace("&amp;hellip;", "&hellip;", $templateHtml);
            
            echo $templateHtml ;
        }
    ?>
</div>



<div id='activeEmailTemplateContainer-d' class='hide-d'>
    <?php
        if(null != $templateHtmlObj){
            $templateHtml = $templateHtmlObj['email_html'];
            // $templateHtml = htmlspecialchars($templateHtml, ENT_HTML5, ENT_NOQUOTES);
            // $templateHtml = str_replace("&amp;hellip;", "&hellip;", $templateHtml);
            
            echo $templateHtml ;
        }
    ?>
</div>


<div class='exchange-rates-container-d hide-d'>
    <?php
        //  put exchange rates in hidden fields
        if(!empty($active_exchange_rate)){
            $usd_exchange_rate=0;
            $euro_exchange_rate=0;
            $lbp_exchange_rate=0;
            foreach($active_exchange_rate as $exhange_rate){
                if($exhange_rate['short_name']  == "USD"){
                    $usd_exchange_rate=$exhange_rate['rate'];
                }
                else if($exhange_rate['short_name']  == "EUR"){
                    $euro_exchange_rate=$exhange_rate['rate'];
                }
                else if($exhange_rate['short_name']  == "LBP"){
                    $lbp_exchange_rate=$exhange_rate['rate'];
                }
            }
        }
    ?>
    <input type="hidden" name="usd_exchange_rate" class="usd_exchange_rate" id="usd_exchange_rate" value="<?=$usd_exchange_rate?>" />
    <input type="hidden" name="euro_exchange_rate" class="euro_exchange_rate" id="euro_exchange_rate" value="<?=$euro_exchange_rate?>" />
    <input type="hidden" name="lbp_exchange_rate" class="lbp_exchange_rate" id="lbp_exchange_rate" value="<?=$lbp_exchange_rate?>" />
    <input type="hidden" name="selected_exchange_rate" class="selected_exchange_rate" id="selected_exchange_rate" value="<?=$lbp_exchange_rate?>">
</div>
var product_details = '';
var allData = ''; // all variables data from load time
$(document).ready(function() {

    var detect_td_index = '';
    var def_grid_del = 1;
    var def_grid_len = 2;
    var def_grid_clear = 2;
    var append = true;
    var action_save_event = '';
    var currency_rate = 0;
    var currency_default_id = "";
    var Grand_total = 0;
    var tax_rate = 0;
    var cusName = '';
    var cusDetail = '';
    var previousUrl = '';
    var custval='';
    var count = [];
    var default_currency='';
    quo_id = location.search.split('trxid=')[1];
    rectrxid = location.search.split('rectrxid=')[1];



    ///////////////////////////////////////////////////////////////////////////////////////////////
   
    //////////////////////////////////////////////////////////////////////////////////////////////



    
    function loadQuotationPopup(update_id = '', dat_typ = '', quo_id = '', copy_sq_id = '') {
        // debugger


      
        $.ajax({
            type: "POST",
            url: baseUrl + 'test-load-sales-quotation-popup',
            data: {
                id: 'no-robot',
                'update_id': update_id,
                'dat_typ': dat_typ,
                'quo_id': quo_id,
                'copy_sq_id': copy_sq_id
            },
            beforeSend: function() {
                $('.load-progress-bar').show();
            },
            success: function(response) {
                // console.log(response.data.currency);
                // var c = response.data.currency;
                // $.each(c, function(key, obj) {
                //     default_currency = obj.currency_default_index_id; // should be 'foo' following by 'bar'
                // });
                allData = response.data;
                var referrer = document.referrer;

                var myString = referrer.split("/").pop();
                $('.popup-append').html(response.data.quotation_popup_html);
                $('#quotation_pop_d').slideDown(600);
                $('#previous-url-d').val(myString);
                previousUrl = $("#previous-url-d").val();
                tax_rate = $('.tax_rate').val();
                //selector
                param = {
                    focus_: false
                };
                $('.qt-cust-d').selectorz(param);
                $('.qt-prod-d').selectorz(param);
                $('.rec-qt-prod-d').selectorz(param);
                $('.sqo-terms-d').selectorz(param);
                $('.rec_sqo-terms-d').selectorz(param);
                // disable currency change on update
                // if(update_id){
                //     $('#currency_d').attr('disabled', 'disabled');
                // }
                // else{
                //     $('#currency_d').trigger("change"); // trigger the change event
                // }
                edit_val_cus = $('input.qt-cust-d').val();
                if (edit_val_cus) {
                    $('input.qt-cust-d').parent('.selectize-custom').next('.visible-selectize-options').find('[attr-id=' + edit_val_cus + ']').addClass("selector-select");
                    selected_acc = $('input.qt-cust-d').parent('.selectize-custom').next('.visible-selectize-options').find('[attr-id=' + edit_val_cus + '] > .search-d').text();
                    $('input.qt-cust-d').val($.trim(selected_acc));
                }
                dragDropGridrows(".quotation_ertable_d tbody", '.quotatieron_table_d > tbody > tr');
                validate_form_($('#test_quotation_form_d'),{
                    ven_id___:{
                        required:true
                    },
                    email:{
                        required:true
                    },
                    "rate[]":{
                        required:true
                    },
                    "qty[]":{
                        number:true
                    },
                     "amount[]": {
                        number: true
                    },
                    "discount[]": {
                        number: true
                    }
                }, validateQuotation, false, true);


                
                // validate_form_($('#quotation_form_d'), {
                //     ven_id___: {
                //         required: true
                //     },

                //     email: {
                //         required: true
                //     },
                //     "rate[]": {
                //         number: true
                //     },
                //     "qty[]": {
                //         number: true
                //     },
                //     "amount[]": {
                //         number: true
                //     },
                //     "discount[]": {
                //         number: true
                //     }
                // }, validateQuotation, false, true);
                // //validate recurring
                // validate_form_($('#rec_sq_form_d'), {
                //     customer_id_: {
                //         required: true
                //     },
                //     "qty[]": {
                //         number: true
                //     },
                //     "rate[]": {
                //         number: true
                //     },
                //     "amount[]": {
                //         number: true
                //     }
                // }, validateReSqQuotation, false, true);
                loadQuoProducts();
                defaultScript();
                sq_status_options();
                recDefaultScript();
                loaddata();
                dropdaown_data();
                selectizerUpwardDownward('.ree');
                $('#capy-sale-d').val(copy_sq_id);
                if (copy_sq_id) {
                    $(".show_error_message_copy_d").html('This is a copy of a Sales Quotation. Revise as needed and save the Quotation once done.');
                    $(".error_sq_box_copy_d").removeClass("hide-d");
                    return false;
                }
                var discount_type = $('#discount_total_d').children("option:selected").val();
                if (discount_type == 1) {
                    $('body').find('.dis_type_d').removeClass('hide-d');
                } else {
                    $('body').find('.dis_type_d').addClass('hide-d');
                }
            },
            complete: function(data) {
                $('.load-progress-bar').hide();
            }
        });
    }

    if (!rectrxid) {
        loadQuotationPopup(update_id = '', dat_typ = '', quo_id, copy_sq_id = '');
    }

        function loaddata(){
        $.ajax({
                    type: 'ajax',
                     url: baseUrl + 'get-quotation-data',
                    async: false,
                    dataType: 'json',
                    success: function(data){
                        var html = '';
                        var i;
                            for(i=0; i<data.length; i++){
                            html +='<tr class="quotation_update_d item-edit" >'+
                            '<td>'+data[i].quotation_index_id+'</td>'+
                            '<td>'+data[i].cus_name+'</td>'+
                            '<td>'+data[i].created_at+'</td>'+
                            '<td>'+
                            '<input type="hidden" class="item-edit" id="'+data[i].quotation_index_id+'">'+
                            '</td>'+
                            '</tr>';
                            }

                        $('#showdata').html(html);

                    },
                    error: function(){
                        alert('Could not get Data from Database');
                    }
                });
    }

     function dropdaown_data(){
        $.ajax({
            type:'ajax',
            url:baseUrl + 'get-dropdown-data',
            async: false,
            dataType:'json',
            success:function(data){
            var html='';
            var i;
            html+='<option>Selectet Options </option>';
            for(i=0; i<data.length; i++){
            html+='<option value="'+data[i].name+'" id="'+data[i].pservices_index_id+'">'+ data[i].name +'</option>';
            }

            $('#showproducts').append(html);
            }
            })
            }

    var i=1 ;
            $('body').on('click','#add_more',function(){
       i++;
             $.ajax({
            type:'ajax',
            url:baseUrl + 'get-dropdown-data',
            async: false,
            dataType:'json',
            success:function(data){
            var html='';
            var d='';
            html+='<option>Selectet Options </option>';
            for(d=0; d<data.length; d++){
            html+='<option value="" id="'+data[d].pservices_index_id+'">'+ data[d].name +'</option>';
            }
          
            var firs_d='<tr class="statuscheck new_r" id="'+i+'"><td align="center" valign="middle" class="add_movable text-center padding_end" id="add_more"><img src="'+ baseUrl + 'public/admin/images/toggle.png" ></td><td align="center" valign="middle" class="padding_end"></td><td><select name="product__id_" id="showproducts" class="form-control selectpicker cus-lines-s ">'+html+'</select></td><input type="hidden" name="pservices_index_id[]" class="pro_name" id="pro_name" ><td class="text-left show_des_d selector-text-s move-up-down-row-d" valign="middle"><input type="text" name="description[]" class="form-control des_d tableInput sh"></td><td class="text-left show_qty_d move-up-down-row-d recur_row_input" valign="middle"><input name="qty[]" class="form-control  qty_d on_hover_tooltip1 tableInput" id="qty_d" type="text" ></td><td class="text-left show_rate_d move-up-down-row-d recur_row_input" valign="middle"><input name="rate[]" class="form-control rate_d tableInput"  id="rate_d" type="text" ></td><td class="text-left show_tax_d tax_d tax_type_d hide-d" valign="middle"><select name="tax[]" class="form-control selectpicker" id="tax_d"><option>Select Option</option><option value="10">10 %</option><option value="15">15 %</option></select></td><td class="text-left show_amount_d move-up-down-row-d last_td_tooltip_s" valign="middle"><input name="amount[]" class="form-control amount_d tableInput am" type="text"></td><td align="center" valign="middle" class="padding_end"><button type="button" class="del no-del quo-del-d delet_row" id="'+i+'" ><img src="'+ baseUrl +'public/admin/images/delete_qbo.png"></button></td></tr>';
            $('.show_quot').append(firs_d);
            }
            });
            })
 $('body').on('click','.item-edit', function(){
                var quotation_index_id= $(this).find(".item-edit").attr('id');
                $.ajax({
                type: 'ajax',
                method: 'get',
                url: baseUrl +'display-single-record',
                data: {quotation_index_id: quotation_index_id},
                async: false,
                dataType: 'json',
                success: function(data){
                   // console.log(data.all_products_name);
                    var html='';
                    var i;
                    html+='<option>Selectet Options </option>';
                    for(i=0; i<data.all_products_name.length; i++){
                    html+='<option value="'+data.all_products_name[i].name+'" id="'+data.all_products_name[i].pservices_index_id+'">'+ data.all_products_name[i].name +'</option>';
                    }
                    // console.log(html);
               $('.popup-append').html(data.test_quotation_data);
               loaddata();
               $('body tbody #showproducts').append(html);
               $('#quotation_pop_d').slideDown(600);
                },
                error: function(){
                    alert('Could not Edit Data');
                }
            });
                return false;

    });








 $('#quotation_sorting tbody tr').find('input').prop("disabled",true);

 $('body').on('click','#quotation_sorting tbody tr',function(){
 if($(this).closest('tr').find("input").prop('disabled',false)){
 $(this).closest('tr').find("input").addClass("active");
 }
 if($(this).closest('tr').siblings().find("input.sh").val()=='' && $(this).closest('tr').siblings().find("input.am").val()==''){
  $(this).closest('tr').siblings().find("input").prop('disabled',true);
  $(this).closest('tr').siblings().find("input").removeClass("active");
 }

 })


        $('body').on('click', '.delet_row', function(){
        $(this).closest('tr').remove();
        });    
        $('body').on('change', '#showproducts', function(){
            var id = $(this).children(":selected").attr("id");
            var this__=$(this);
                $.ajax({
                type:'post',
                url: baseUrl+ 'show-all-products-name-dropdown',
                data:{id:id },
                async:false,
                dataType: 'json',
                success:function(data){
                    this__.closest('tr').find('.des_d').val(data.product_detail[0]['sale_description']);
                    this__.closest('tr').find('.rate_d').val(data.product_detail[0]['rate']);
                    this__.closest('tr').find('.qty_d').val(data.product_detail[0]['qty']);
                    this__.closest('tr').find('.pro_name').val(data.product_detail[0]['pservices_index_id']);

                },
            })
        });



$('body').on('change','#quotation_sorting tbody tr #tax_d',function(){
    var sum = 0;
    $(".quotation_table_d tbody tr").each(function(){
    var res=$(this).find('#tax_d').children(':selected').val();
    sum +=parseInt(res);
}); 
$('body').find('#toto_vat').val(sum);
})



$('body').on('change','#quotation_sorting tbody tr #tax_d',function(){
        var tax = $(this).children(":selected").val();
        var rate= $('#rate_d').val();
        var qnty= $('#qty_d').val();


        myCalFunction();
        });
        $('body').on('change','tbody tr #rate_d' ,function(){
        var qnty1=$('#qty_d').val();
        var tax1 = $('#tax_d').children(":selected").val();
        var rate1=$(this).val();
        myCalFunction();
        });
        $('body').on('change','tbody tr #qty_d',function(){
        var qnty2= $(this).val();
        var tax2 = $('#tax_d').children(":selected").val();
        var rate2= $('#rate_d').val();
        myCalFunction();
        });
  


function myCalFunction(){
    var total=0;
    var subtotal=0;
    $('.quotation_table_d tr').each(function(){

        var qnty= $(this).find('#qty_d').val();
        var tax = $(this).find('#tax_d').children(":selected").val();
        var rate= $(this).find('#rate_d').val();
        if(qnty !== '' && rate !==''){
            var result1=qnty*rate;
            var result2=qnty*tax*rate/100;
            var final_result=result1+result2;
            $(this).find('.amount_d').val(final_result);
            if($.isNumeric(final_result)){
            total += parseInt(final_result);
            }
            if($.isNumeric(result1)){
                subtotal +=parseInt(result1);
            }
        }
    }); 
  
    $('.show_sub_total_d').text(subtotal);
    $('.show_gtotal_d').text(total);
}




$('body').on('click','.print_doc_d', function(){
     var id=$(this).attr('id');

       
    $.ajax({
                type: 'ajax',
                method: 'get',
                url: baseUrl +'generate-pdf-quot',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){
                  console.log(data.data.printPreviewFileUrl); 
                   $("#print-d").modal('show');
                   $('#print-preview-d').attr('src', data.data.printPreviewFileUrl);
                   }
            });
    
})

$('body').on('click','.send_email',function(){
    var formdata=$('#modeification').serialize();
    $.ajax({
        type:'post',
        url:baseUrl + 'send-email-n',
        data:formdata,
        success:function(){
            console.log("ok email send");
        }

    });

})
    $('body').on('click', '.send-customer-email-attach-d', function() {
        var previousUrl = $("#previous-url-d").val();
        var mailFormData = $("#email-send-attach-form-d").serialize();
        
        $.ajax({
            type: "POST",
            url: baseUrl + 'send-sales-customer-email',
            data: mailFormData,
            beforeSend: function() {
                $('.load-progress-bar').show();
            },
            success: function(response) {
                AjaxSuccessResMsg(response);
                if (response.status == 'OK') {
                    $(".show-success-pop-d").html(response.message);
                    $("#success_modal_d").modal('show');
                    $('#quotation_pop_d').modal('hide');

                    window.location.href= baseUrl+'dashboard';
                   // window.location.href = baseUrl + previousUrl;
                    //window.history.back();
                }
            },
            complete: function(data) {
                $('.load-progress-bar').hide();
            }
        });
    });

    function validateReSqQuotation() {
        var quotationRecurFormData = new FormData($("#rec_sq_form_d")[0]);
        var tax_type = $('#tax_type_d').children("option:selected").val();
        if (tax_type == 1) {
            var duplicatetype = 2;
            quotationRecurFormData.append("duplicatetype", duplicatetype);
        } else if (tax_type == 2) {
            var duplicatetype = 1;
            quotationRecurFormData.append("duplicatetype", duplicatetype);
        }
        if ($('.rec_attached_file').length) {
            $.each($('.rec_attached_file'), function(k) {
                quotationRecurFormData.append("attached_file[]", $(this).val());
            });
            $.each($('.rec_actual_file_name'), function(k) {
                quotationRecurFormData.append("actual_file_name[]", $(this).val());
            });
        }
        if ($('.rec_tax_d').length) {
            $.each($('.rec_tax_d'), function(k) {
                quotationRecurFormData.append("data_tax_type[]", $(this).attr('data-tax-type'));
            });
        }
        $.ajax({
            type: "POST",
            url: baseUrl + 'rec-salequotation-save',
            data: quotationRecurFormData,
            beforeSend: function() {
                $('.load-progress-bar').show();
            },
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                AjaxSuccessResMsg(response);
                if (response.status == 'OK') {
                    $(".show-success-pop-d").html(response.message);
                    $("#success_modal_d").modal('show');
                    setTimeout(function() {
                        $('#success_modal_d').modal('hide');
                    }, 1000);
                    setTimeout(function() {
                        window.location.href = baseUrl + 'dashboard';
                    }, 1000);
                    // if(response.data.lastInsertedId)
                    // {
                    //   loadRerecurQuotationPopup(response.data.lastInsertedId, 'edit');
                    // }
                } else if (response.status == 'ERROR') {
                    $(".show_error_message_d").html(response.message);
                    $("#quotation_qbo_recurring").modal('show');
                    $(".error_caution_box").removeClass("hide-d");
                    setTimeout(function() {
                        $('.error_caution_box').addClass('hide-d');
                    }, 10000);
                    return false;
                }
            },
            complete: function(data) {
                $('.load-progress-bar').hide();
            }
        });
    }

    function validateQuotation() {
        // debugger
        dat_typ = $(".quotation_update_d").attr('data-type');
        update_id = '';
        if (dat_typ == 'edit') {
            update_id = $("#update_id_d").val();
        }
        var quotationFormData = new FormData($("#test_quotation_form_d")[0]);
        quotationFormData.append("save_type", actionSaveEvent);
        //alert(actionSaveEvent);
        if ($('.attached_file').length) {
            $.each($('.attached_file'), function(k) {
                quotationFormData.append("attached_file[]", $(this).val());
            });
            $.each($('.actual_file_name'), function(k) {
                quotationFormData.append("actual_file_name[]", $(this).val());
            });
        }
        $('input[type="checkbox"]').each(function() {
            if ($(this).is(":checked")) {
                quotationFormData.append("attach_imags[]", $(this).val());
            }
        });
        if ($('.tax_d').length) {
            $.each($('.tax_d'), function(k) {
                quotationFormData.append("data_tax_type[]", $(this).attr('data-tax-type'));
            });
        }
        if($('.default_rate_d').length)
        {
            $.each($('.default_rate_d'), function(k)
            {
              quotationFormData.append("istax[]",  $(this).attr('data_istax'));
            });
        }

        // Exchange Rates
        quotationFormData.append("usd_exchange_rate",  $('.usd_exchange_rate').val());
        quotationFormData.append("euro_exchange_rate",  $('.euro_exchange_rate').val());
        quotationFormData.append("lbp_exchange_rate",  $('.lbp_exchange_rate').val());
        quotationFormData.append("selected_exchange_rate",  $('.selected_exchange_rate').val());
        
        quotationFormData.append("selected_template_id",  $('.selected_template_id-d').val());
        
        // get updated HTML to be sent to PHP for PDF creation
        shouldGetPDF = (actionSaveEvent == 'save_send') || (actionSaveEvent == 'print') ? true : false;
        var updatedTemplate = getPdfTemplateHtml(shouldGetPDF);
        quotationFormData.append("updated_html_string", updatedTemplate);
        
        $.ajax({
            type: "POST",
            url: baseUrl + 'test-save-sales-quotation',
            data: quotationFormData,
            dataType: 'json',
            beforeSend: function() {
                $('.load-progress-bar').show();
            },
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                console.log(response.data);
                if (response.status == 'OK') {
                    if (response.data.save_type == 'save') {
                        if (response.data.lastInsertedId) {
                            var href = new URL(baseUrl + 'salesquotation?trxid=' + response.data.lastInsertedId);
                            href.searchParams.set('trxid', response.data.lastInsertedId);
                            href.toString();
                            history.pushState(null, null, href.toString());
                            loadQuotationPopup(update_id = response.data.lastInsertedId, dat_typ = 'edit');
                        }
                        $(".show-success-pop-d").html(response.message);
                        $("#success_modal_d").modal({
                        backdrop: 'static',
                        keyboard: false
                        });
                        setTimeout(function() {
                            $("#success_modal_d").modal('hide');;
                        }, 3000);
                    }
                    if (response.data.save_type == 'save_close') {
                        $('#quotation_pop_d').modal('hide');
                        window.location.href = baseUrl + previousUrl;
                        //window.history.back();
                        // setTimeout( function(){$("#success_modal_d").modal('hide')}, 6000 );
                        return false;
                    }
                    if (response.data.save_type == 'save_add_new') {
                        quo_id = "";
                        // $(".show-success-pop-d").html(response.message);
                        // $("#success_modal_d").modal('show');

                        var href = new URL(baseUrl + 'salesquotation');
                        href.toString();
                        history.pushState(null, null, href.toString());
                        loadQuotationPopup(update_id = '', dat_typ = '', quo_id = '');
                        setTimeout( function(){ $(".show-success-pop-d").html(response.message);
                        $("#success_modal_d").modal({
                        backdrop: 'static',
                        keyboard: false
                        }); }, 4000 );
                        setTimeout( function(){$("#success_modal_d").modal('hide');;}, 7000 );
                    }

                    if (response.data.save_type == 'save_send') 
                    {
                        if(response.data.lastInsertedId)
                        {
                            var href = new URL(baseUrl + 'salesquotation?trxid=' + response.data.lastInsertedId);
                            href.searchParams.set('trxid', response.data.lastInsertedId);
                            href.toString();
                            history.pushState(null, null, href.toString());
                            $('body').find('.quotation_update_d').val(response.data.lastInsertedId);
                        }    
                        
                        let lastId = (response.data.trxId !=='' && response.data.trxId !=='undefined') ? response.data.trxId : response.data.lastInsertedId;
                        $(document).find('#trx_id-d').val(lastId); // current trx_id
                        if(shouldGetPDF){
                            $('#printPreviewContainer-d').attr('src', response.data.printPreviewFileUrl);
                        }
                        
                        $('#onclick_invoice_download').attr('href',response.data.printPreviewFileUrl);
                        $.each(response.data.emailimages, function(k, v) {
                            $("#attach-imag-email-send-d").append('<input type="hidden" name="file_name[]"  value=' + v.attach_imges + ' />');
                        });
                        
                        // setup email properties and content
                        if( $("input[name='attachment_url']").length < 1 ){
                            $("#attach-imag-email-send-d").append('<input type="hidden" name="attachment_url"  value="' + response.data.printPreviewFileUrl + '" />');
                        }
                        $("input[name='attachment_url']").val(response.data.printPreviewFileUrl);
                        
                        setupSenderInfoInSendForm(); // setup fromName and fromEmail

                        $('#module-name-d').val( response.data.module_name );
                        
                        if (response.data.emailArray['email']) {
                            $("#customer_email").val(response.data.emailArray['email']);
                        }
                        if (response.data.emailArray['email_cc']) {
                            $('.email-cc-d').removeClass('hide-d');
                            $("#email-cc").val(response.data.emailArray['email_cc']);
                        }
                        if (response.data.emailArray['email_bcc']) {
                            $('.email-bcc-d').removeClass('hide-d');
                            $("#email-bcc").val(response.data.emailArray['email_bcc']);
                        }
                        $('body').find('#email_subject').val(response.data.subject);
                        $('body').find('#email_msg').val(response.data.body);
                        $('body').find('#template_id').val(response.data.selected_template_id);
                        $("#save-send-open-d").modal('show');

                    }
                    if (response.data.save_type == 'print') 
                    {
                        if(response.data.lastInsertedId)
                        {
                            var href = new URL(baseUrl + 'salesquotation?trxid=' + response.data.lastInsertedId);
                            href.searchParams.set('trxid', response.data.lastInsertedId);
                            href.toString();
                            history.pushState(null, null, href.toString());
                            $('body').find('.quotation_update_d').val(response.data.lastInsertedId);
                        }    
                        let lastId = (response.data.trxId !=='' && response.data.trxId !=='undefined') ? response.data.trxId : response.data.lastInsertedId;
                        $(document).find('#trx_id-d').val(lastId); // current trx_id
                        if(shouldGetPDF){
                            $('#print-preview-d').attr('src', response.data.printPreviewFileUrl);
                        }
                        $.each(response.data.emailimages, function(k, v) {
                            $("#attach-imag-email-send-d").append('<input type="hidden" name="file_name[]"  value=' + v.attach_imges + ' />');
                        });
                        // setup email properties and content
                        if( $("input[name='attachment_url']").length < 1 ){
                            $("#attach-imag-email-send-d").append('<input type="hidden" name="attachment_url"  value="' + response.data.printPreviewFileUrl + '" />');
                        }
                        $("input[name='attachment_url']").val(response.data.printPreviewFileUrl);
                        //setupSenderInfoInSendForm(); // setup fromName and fromEmail
                        $('#module-name-d').val( response.data.module_name );
                        $("#print-d").modal('show');
                    }
                } else if (response.status == 'ERROR') {
                    $(".show_error_message_d").html(response.message);
                    $(".error_caution_box").removeClass("hide-d");
                    $("#save-send-open-d").modal('hide'); // hide send email popup
                    $("#print-d").modal('hide');
                    return false;
                }
            },
            complete: function(data) {
                $('.load-progress-bar').hide();
            }
        });
    }

    // $('body').on('click', '.quotation_update_d', function() {
    //     dat_typ = $(this).attr('data-type');
    //     update_id = '';
    //     if (dat_typ == 'edit') {
    //         update_id = $(this).attr('id');
    //         var href = new URL(baseUrl + 'salesquotation?trxid=' + update_id);
    //         href.searchParams.set('trxid', update_id);
    //         href.toString();
    //         history.pushState(null, null, href.toString());
    //     }
    //     loadQuotationPopup(update_id, dat_typ);
    // });

  //   $('body').on('click', '.get-customer-detail-d', function() {
  //       $('.hide-show-pro-sel-d').addClass('hide-d');
  //       var customer_id = $(this).attr('attr-id');
        // //var customer_id = $(".vendor_id-d").val();
  //       if (customer_id.length > 0) {
  //           $.ajax({
  //               type: "POST",
  //               url: baseUrl + 'vendor-sales-detail',
  //               data: {
  //                   customer_id: customer_id
  //               },
  //               success: function(response) {
  //                   AjaxSuccessResMsg(response);
  //                   if (response.data) {
  //                       if (response.status == 'OK') {
  //                           $('#email_d').val(response.data[0].email);
        //                  var term= '';
        //              if (response.data[0].term != 'undefined')
        //              {
        //                  term = response.data[0].term;
        //                  if(term==0)
  //                           {
  //                               term = response.data.term[0].term_index_id;
  //                           }
        //              }
                                        
        //                  $('input.sqo_term-d').val(term);
        //                  edit_pi_terms_d = $('input.sqo-terms-d').val(term);

        //                  if(edit_pi_terms_d)
        //                  {
        //                   selectedSlectorz('input.sqo-terms-d');
        //                  }
        //                  append_expir_date();
  //                           var billing_address = response.data[0].billing_address;
  //                           var bill_city_town = response.data[0].bill_city_town;
  //                           var bill_state = response.data[0].bill_state;
  //                           var bill_country = response.data[0].bill_country;
  //                           if (billing_address == 'undefined' || billing_address == null || billing_address == '') {
  //                               var billing_address = "";
  //                           }
  //                           if (bill_city_town == 'undefined' || bill_city_town == null || bill_city_town == '') {
  //                               var bill_city_town = "";
  //                           }
  //                           if (bill_state == 'undefined' || bill_state == null || bill_state == '') {
  //                               var bill_state = "";
  //                           }
  //                           if (bill_country == 'undefined' || bill_country == null || bill_country == '') {
  //                               var bill_country = "";
  //                           }
  //                           $('#billing_address_d').val(billing_address + ' ' + bill_city_town + ' ' + bill_state + ' ' + bill_country);
  //                           return false;
  //                       }
  //                   }
  //               },
  //           });
  //       } else {
  //           return false;
  //       }
  //   });


    // $('body').on('click', '.rec_get_cus_id_d', function() {
    //     //  debugger
    //     $('.hide-show-pro-sel-d').addClass('hide-d');
    //     var rec_cus_id = $(".rec_customer_id-d").val();
    //     var customer_id = ''
    //     if(rec_cus_id == null || rec_cus_id =='' || rec_cus_id == undefined){
    //         customer_id = custval;
    //     }else{
    //         $(".vendor_id-d").val(rec_cus_id);
    //         customer_id = rec_cus_id;
    //     }
    //     //var customer_id = $(".vendor_id-d").val();
    //     if (customer_id.length > 0) {
    //         $.ajax({
    //             type: "POST",
    //             url: baseUrl + 'vendor-sales-detail',
    //             data: {
    //                 customer_id: customer_id
    //             },
    //             success: function(response) {
    //                 // console.log(response);
    //                 AjaxSuccessResMsg(response);
    //                 if (response.data) {
    //                     if (response.status == 'OK') {
    //                         $('.rec_cus_d').each(function (e, obj) {
    //                             $(this).removeClass('selector-select');
    //                             if ($(this).attr('attr-id') == response.data[0]['customer_index_id']) {
    //                                 $(this).addClass('selector-select');
    //                                 $('.rec_get_cus_id_d').val(response.data[0]['customer_index_id']);
    //                                 $('input[name="customer_id_"]').val($.trim($(this).find('p').text()));
    //                                 $('#temp_name_d').val(response.data[0].dispaly_name);
    //                                 //set the customer email if exists
    //                                 // if (response.data['customer_email'] !== false || response.data['customer_email']!=='') {
    //                                 //     $('input[name="email"]').val(response.data['customer_email']);  
    //                                 // }
    //                             }
    //                         });
    //                         if (response.data[0].email != 'undefined' && response.data[0].email != ''){
    //                             $('#rec_email_d').val(response.data[0].email);
    //                         }else{
    //                             var email = $('#email_d').val();
    //                             $('#rec_email_d').val(email);
    //                         }

    //                          var term= '';
    //                         if (response.data[0].term != 'undefined' && response.data[0].term != '' && response.data[0].term != 0)
    //                         {
    //                             term = response.data[0].term;
    //                             $('input.rec_sqo_term-d').val(term);
    //                             edit_pi_terms_d = $('input.rec_sqo-terms-d').val(term);
    
    //                             if(edit_pi_terms_d)
    //                             {
    //                                 selectedSlectorz('input.rec_sqo-terms-d');
    //                             }
    //                         }
                                        

    //                         append_expir_date();
                            
    //                         var billing_address = response.data[0].billing_address;
    //                         var bill_city_town = response.data[0].bill_city_town;
    //                         var bill_state = response.data[0].bill_state;
    //                         var bill_country = response.data[0].bill_country;
    //                         if (billing_address == 'undefined' || billing_address == null || billing_address == '') {
    //                             var billing_address = "";
    //                         }

    //                         if (bill_city_town == 'undefined' || bill_city_town == null || bill_city_town == '') {
    //                             var bill_city_town = "";
    //                         }

    //                         if (bill_state == 'undefined' || bill_state == null || bill_state == '') {
    //                             var bill_state = "";
    //                         }

    //                         if (bill_country == 'undefined' || bill_country == null || bill_country == '') {
    //                             var bill_country = "";
    //                         }

    //                         $('#billing_address_d').val(billing_address + ' ' + bill_city_town + ' ' + bill_state + ' ' + bill_country);
    //                         return false;
    //                     }
    //                 }
    //             },
    //         });
    //     } else {
    //         return false;
    //     }
    // });

    //SQ settings
    //quotation customise fields
    // $('body').on('click', '#customize_fields_qo_d', function() {
    //     $.ajax({
    //         type: "POST",
    //         url: baseUrl + 'customize-field-sq',
    //         data: {
    //             id: 'no-robot'
    //         },
    //         beforeSend: function() {},
    //         success: function(res) {
    //             if (res.data) {
    //                 $('.sidebar-pop-app-footer-d').html(res.data);
    //                 $("#overlay_customize_invoice").animate({
    //                     width: "toggle"
    //                 });
    //                 $('#overlay_customize_invoice').css({
    //                     display: 'block'
    //                 });
    //                 showHideAnotherField();
    //             }
    //         },
    //         complete: function(data) {
    //             //$('.load-progress-bar').hide();
    //         }
    //     });
    // });

    // $('body').on('click', '#indexpage_icon', function() {
    //     $('#overlay_customize_invoice').hide();
    // });
    // $('body').on('click', '.qo-setting-save-d', function() {
    //     field_active = 0;
    //     qo_sett_attr = $(this).attr("qo-attr-name");
    //     qo_field_vale = $('.qo-field-' + qo_sett_attr + "-d").val();
    //     if ($(this).prop('checked') == true) {
    //         field_active = 1;
    //         $('.' + qo_sett_attr + '-attr-d').show();
    //     } else {
    //         $('.' + qo_sett_attr + '-attr-d').hide();
    //     }
    //     qoSettings(qo_sett_attr, qo_field_vale, field_active);
    // });

    // $('body').on('blur', '.qo-field-crew-d , .qo-field-custom_field-d,.qo-field-custom2-d,.qo-field-custom3-d', function() {
    //     field_active = 0;
    //     if ($(this).hasClass('qo-field-crew-d')) {
    //         if ($("#cog_slide_006_new").prop('checked') == true) {
    //             field_active = 1;
    //         }
    //     }
    //     //custom field 2
    //     if ($(this).hasClass('qo-field-custom2-d')) {
    //         if ($("#cog_slide_009_new").prop('checked') == true) {
    //             field_active = 1;
    //         }
    //     }
    //     //custom field 3
    //     if ($(this).hasClass('qo-field-custom3-d')) {
    //         if ($("#cog_slide_0010_new").prop('checked') == true) {
    //           field_active = 1;
    //         }
    //     }

    //     if ($(this).hasClass('qo-field-custom_field-d')) {
    //         if ($("#cog_slide_0012_new").prop('checked') == true) {
    //           field_active = 1;
    //         }
    //     }

    //     qo_sett_attr = $(this).attr("qo-attr-name");
    //     qo_field_vale = $(this).val();
    //     $('.' + qo_sett_attr + '-attr-d').find('label').text(qo_field_vale);
    //     //reset label values! - Muneeb Faruqi
    //     if ($('.crew-attr-d').find('label').text() === '') {
    //         $('.crew-attr-d').find('label').text('Custom 1');
    //     }
    //     if ($('.custom2-attr-d').find('label').text() === '') {
    //         $('.custom2-attr-d').find('label').text('Custom 2');
    //     }
    //     if ($('.custom3-attr-d').find('label').text() === '') {
    //         $('.custom3-attr-d').find('label').text('Custom 3');
    //     }
    //     if ($('.custom_field-attr-d').find('label').text() === '') {
    //         $('.custom_field-attr-d').find('label').text('Custom 4');
    //     }
    //     qoSettings(qo_sett_attr, qo_field_vale, field_active);
    // });

    function qoSettings(qo_sett_attr, qo_field_vale, field_active) {
        if (qo_sett_attr) {
            $.ajax({
                type: "POST",
                url: baseUrl + 'sq-Settings',
                data: {
                    'column_name': qo_sett_attr,
                    'field': qo_field_vale,
                    'field_active': field_active
                },
                success: function(res) {
                    //console.log(res);
                },
            });
        }
    }

    $('body').on('click', '.qo-setting-save-d', function() {
        var this__ = $(this);
        if (this__.find('input[type=checkbox]').is(':checked') == false) {
            this__.closest('.show-hide-input-d').addClass('hide-d');
            //this__.parent('div').parent('div').find('.show-hide-input-d').addClass('hide-d');
        }
        showHideAnotherField();
    });
    $('body').on('click', '#id_sku', function() {
        var this__ = $(this);
        if(this__.is(':checked')){
            $('body').find('.sku-d').removeClass('hide-d');
            $('body').find('.sku-check-d').val(1);
        }else{
            $('body').find('.sku-d').addClass('hide-d');
            $('body').find('.sku-check-d').val(0);
        }
    });
    function showHideAnotherField() {
        var $b = $('.add-input-d .show-hide-input-d').find('input[type=checkbox]');
        var numberofInputs = $b.filter(':checked').length;
        if (numberofInputs == 4) {
            $('.hide-show-another-d').addClass('hide-d');
        } else {
            $('.hide-show-another-d').removeClass('hide-d');
        }
    }

    //click on add another field
    $('body').on('click', '.add-another-field-d', function() {
        //var lengthINput = $('.add-input-d .show-hide-input-d').length;
        $('.add-input-d .show-hide-input-d').each(function(i) {
            var this__ = $(this);
            if (this__.hasClass('hide-d')) {
                this__.removeClass('hide-d');
                this__.find('.qo-setting-save-d').prop("checked", true);
                callAddCustomField(this__);
                qo_sett_attr = this__.find('.qo-setting-save-d').attr("qo-attr-name");
                $('body').find('.qo-field-' + qo_sett_attr + "-d").show();
                return false;
            }
        });
        showHideAnotherField();
    });

    //call add fields 
    function callAddCustomField(this__) {
        qo_sett_attr = this__.find('.qo-setting-save-d').attr("qo-attr-name");
        qo_field_vale = this__.find('.qo-field-' + qo_sett_attr + "-d").val();
        field_active_ = 1;
        qoSettings(qo_sett_attr, qo_field_vale, field_active_);
    }

    //send email
    $('body').on('click', '.send-customer-email-attach-d', function() {
        var previousUrl = $("#previous-url-d").val();
        var mailFormData = $("#email-send-attach-form-d").serialize();
        
        $.ajax({
            type: "POST",
            url: baseUrl + 'send-sales-customer-email',
            data: mailFormData,
            beforeSend: function() {
                $('.load-progress-bar').show();
            },
            success: function(response) {
                AjaxSuccessResMsg(response);
                if (response.status == 'OK') {
                    $(".show-success-pop-d").html(response.message);
                    $("#success_modal_d").modal('show');
                    $('#quotation_pop_d').modal('hide');

                    window.location.href= baseUrl+'dashboard';
                   // window.location.href = baseUrl + previousUrl;
                    //window.history.back();
                }
            },
            complete: function(data) {
                $('.load-progress-bar').hide();
            }
        });
    });

    $('body').on('blur', '.qt-cust-d', function(e) {
        cusName = $('.qt-cust-d').val();
        $('#customer_name_d').val($('.qt-cust-d').val());
    });

    $('body').on('blur', '#customer_name_d', function(e) {
        cusDetail = $('#customer_name_d').val();
    });

    $('body').on('keyup', '.get_vendor_d', function() {
        var cust = $('.qt-cust-d').val();
        $('body').find('.cus_text_d').text(" " + cust);
    });

    //for customer
    $('body').on('click', '.po_details_customer_d', function() {
        if (cusDetail) {
            cusDetail = cusDetail;
        } else {
            cusDetail = $('#customer_name_d').val();
        }
        initilizeNewCustomer(cusDetail);
    });

    //cancel
    $('body').on('click', '.cancl-popup-d', function() {
        if ($("#test_quotation_form_d").isChanged()) {
            $('.confirm_box_text_d').text("Do you want to leave without saving?");
            $('.show-confirm-model-d').modal('show');
        } else {
            if(history.back()==null){
                window.location.href = baseUrl + 'dashboard';
            }else{
                window.location.href = history.back();
            }
        }
    });
    
    
    $('body').on('click', '.cancel-rec-popup-d', function() {
        if ($("#rec_sq_form_d").isChanged()) {
            $('.confirm_box_text_d').text("Do you want to leave without saving?");
            $('.show-confirm-model-d').modal('show');
        } else {
            if(history.back()==null){
                window.location.href = baseUrl + 'dashboard';
            }else{
                window.location.href = history.back();
            }
            //window.history.back();
        }
    });

    //confirm
    $('body').on('click', '.confirm-yes-d', function() {
        if ($(this).attr("data-attr") == 'clear') {
            $('#test_quotation_form_d')[0].reset();
            $('.show-confirm-model-d').modal('hide');
        } else if ($(this).attr("data-attr") == "close_form") {
            window.location.href = baseUrl + previousUrl;
            //window.history.back();
        }
    });

    $('body').on('click', '.cancel_d', function() {
        $(".confirm-yes-d").attr("data-attr", "close_form");
        $('.show-confirm-model-d').modal('hide');
    });

    //clear
    $('body').on('click', '.quotation-clear-d', function() {
        if ($("#test_quotation_form_d").isChanged()) {
            $('.confirm_box_text_d').text("Do you want to clear without saving?");
            $('.show-confirm-model-d').modal('show');
            $(".confirm-yes-d").attr("data-attr", "clear");
        } else {
            if ($(this).attr("data-attr") == 'clear') {
                return false;
            } else {
                $('#test_quotation_form_d')[0].reset();
            }
        }
    });

    //discount type inline and on total
    $('body').on('change', '#discount_total_d', function() {
        var discount_type = $(this).children("option:selected").val();
        if (discount_type == 1) {
            $('.discount_val_d').val(" ");
            $('body').find('.dis_type_d').removeClass('hide-d');
            $('body').find('#show_hide_inline_dis_d').addClass('hide-d');
            $('body').find('.discount_label_d').removeClass('hide-d');
            $('body').find('.discount_val_d').attr('data-per-flag', '');
            $.each($('.er >tbody > tr'), function() {
                $(this).closest('tr').find('.default_rate_d').attr('data-ratefor-total', '');
            });
        } else if (discount_type == 2) {
            $('body').find('.discount_d').val("");
            $('body').find('.show_discount_d > span').text("");
            $('body').find('.quo_inline_discount_d').next('span').text("");
            $('#inline_dis_percent_d').val(" ");
            $('#inline_dis_amount_d').val(" ");
            $('body').find('.discount_label_d').addClass('hide-d');
            $(".er > tbody > tr").each(function() {
                $(this).find('.discount-d option:first-child').attr("selected", "selected");
                //$('select option:first-child').attr("selected", "selected");
                $(this).find('.show_inline_disc_d > span').text(" ");
            });
            $('body').find('.dis_type_d').addClass('hide-d');
            $('body').find('#show_hide_inline_dis_d').removeClass('hide-d');
            updateTableValues();
            calculate_total();
        } else {
            $('body').find('.discount_label_d').addClass('hide-d');
            $('body').find('.discount_val_d').attr('data-per-flag', '');
            $.each($('.er >tbody > tr'), function() {
                $(this).find('.discount-d option:first-child').attr("selected", "selected");
                $(this).find('.show_inline_disc_d > span').text(" ");

                $(this).closest('tr').find('.default_rate_d').attr('data-ratefor-total', '');
            });
            $('.discount_val_d').val(0);
            $('body').find('.dis_type_d').addClass('hide-d');
            $('body').find('#show_hide_inline_dis_d').addClass('hide-d');
            $('body').find('.discount_d').val("");
            $('body').find('.show_discount_d > span').text("");
            $(".si_table_d > tbody > tr").each(function() {
                $(this).find('select option:first-child').attr("selected", "selected");
                //$('select option:first-child').attr("selected", "selected");
                $(this).find('.show_inline_disc_d > span').text(" ");
            });
            updateTableValues();
            calculate_total();
        }
    });

    // $('body').on('change','#discount_total_d',function()
    // {
    //   var discount_type = $(this).children("option:selected").val();
    //   if(discount_type==1)
    //   {
    //     $('body').find('.dis_type_d').removeClass('hide-d');
    //     $('body').find('#show_hide_inline_dis_d').addClass('hide-d');
    //     $('body').find('.discount_label_d').removeClass('hide-d');
    //   }
    //   else if(discount_type==2)
    //   {
    //     $('body').find('.discount_d').val("");
    //     $('body').find('.show_discount_d > span').text("");
    //     $('body').find('.quo_inline_discount_d').next('span').text("");
    //     $('#inline_dis_total_d').val("");
    //     $(".er > tbody > tr").each(function () 
    //     {
    //       //$(".show_select_d option:first").attr('selected','selected');
    //       $('select option:first-child').attr("selected", "selected");
    //       $(this).find('.show_inline_disc_d > span').text(" ");
    //     });
    //     //$('.show_select_d').selectpicker('refresh');
    //     //$('.selectpicker').selectpicker('refresh');
    //     $('body').find('.dis_type_d').addClass('hide-d');
    //     $('body').find('#show_hide_inline_dis_d').removeClass('hide-d');
    //     $('body').find('.discount_label_d').addClass('hide-d');
    //     updateTableValues();
    //     calculate_total();
    //   }
    //   else
    //   {
    //     $('body').find('#show_hide_inline_dis_d').addClass('hide-d');
    //   }    
    // });
    //change currency table values    
    //get product values
    $('body').on('click', '.comon-pro-d', function() {
        var this_            = $(this);
        var product_id       = this_.attr("attr-id");
        var currency_id      = $('#currency_d').children("option:selected").val();
        var tax_rate         = this_.parents('tr').find('.vat-tax-d').children("option:selected").attr('data-vat');
        tax_rate = $.isNumeric(tax_rate) ? tax_rate : $('.tax_rate').val();
        var def_currency_id  = $('#default_currency_id').val();
        var data_sq_rec_flag = $('#rec_lbp_curr_rate_d').attr('data-sq-rec-flag');    
        
        if (data_sq_rec_flag == 1) {
            var tax_type = $('#rec_tax_type_d').children("option:selected").val();
        } else {
            var tax_type = $('#tax_type_d').children("option:selected").val();
        }
        if (tax_type == 3) {
            tax_rate = 0;
        }


   
        // var vat_rate = this_.closest('tr').find('.vat-tax-d').children("option:selected").val();
        // if(vat_rate>0)
        // {
        //     tax_rate = vat_rate; 
        // }
        if (product_id.length) {
            $.ajax({
                type: "POST",
                url: baseUrl + 'sq-get-product-val',
                data: {'product_id': product_id},
                success: function(response) {
                    //console.log(response);
                    this_.parents('tr').find('.show_qty_d > span').text(1);
                    this_.parents('tr').find('.qty_d').val(1);
                    this_.parents('tr').find('.default_rate_d').attr('data_istax',response.data[0].is_tax); 
                    if (response.data[0].sale_price) 
                    {
                        var qty = 1;
                        
                        var currency_current_rate = $('#cur_curnt_rate_d').val();
                        var currency_prev_rate    = $('#cur_prev_rate_d').val();
                        var discount = this_.closest('tr').find('.discount_d').val();
                        var rte = getDispalyValuesRound(response.data[0].sale_price);

                        
                        this_.closest('tr').find('.default_rate_d').val(rte);
                        this_.closest('tr').find('.tax_d').attr('data-tax-type', tax_type);
                        this_.closest('tr').find('.show_rate_d > span').text(numberTwoDigitComaSep(rte / currency_current_rate));
                        this_.closest('tr').find('.rate_d').val(getDispalyValuesRound(rte / currency_current_rate));
                        var data_type = this_.closest('tr').find('.tax_d').attr('data-tax-type');
                        if (data_type == '') 
                        {
                            data_type = this_.closest('tr').find('.tax_d').attr('data-tax-type', tax_type);
                        }
                        var discountTypeInline = this_.closest('tr').find('.selected').attr('data-original-index');
                        if (discountTypeInline > 0) {
                            var total = tableCalculationsWithDiscount(rte, qty, this_.closest('tr'), tax_type, tax_rate, discountTypeInline, discount);
                        } else {
                            var total = tableCalculations(rte, qty, this_.closest('tr'), tax_type, tax_rate, amountAfterDiscount = false, discountTypeInline = false)
                        }
                        //set total amount on change product
                        amountOnProductChange(total, this_.closest('tr'));
                        //calculate if sq or recurring

                        if (data_sq_rec_flag == 1) {
                            setTimeout(function() {
                                rec_calculate_total(tax_type,tax_rate)
                            }, 500);
                        } else {
                            setTimeout(function() {
                                calculate_total(tax_type,tax_rate)
                            }, 500);
                        }
                        calLbpTotalEqui(tax_rate);
                    }
                    if (response.data[0].sale_description) {
                        this_.closest('tr').find('.show_des_d > span').text(response.data[0].sale_description);
                        this_.closest('tr').find('.des_d').val(response.data[0].sale_description);
                    }
                    if (response.data[0].sku) {
                        this_.closest('tr').find('.sku-d').val(response.data[0].sku);
                        this_.closest('tr').find('.sku-d > span').text(response.data[0].sku);
                    }else{
                        this_.closest('tr').find('.sku-d').val();
                        this_.closest('tr').find('.sku-d > span').text();
                    }
                },
            });
        }
        
    });

    $('body').on('click', '.er tbody tr td', function(e) {
        detect_td_index = $(this).index();
        console.log(detect_td_index,'rrrrrrrrrrrrrrrrrr');
        console.log(count);
    });

    $('body').on('change', '.re1 tr > td > input , .show_select_d, .show_vat_d ,.rec_show_select_d, .rec_show_vat_d, .table_recuring_d tr > td > input', function() {
        // debugger
        var this__ = $(this);
        var qty_d = 0;
        var rate_d = 0;
        var amt_d = 0;
        var discount_d = 0;
        var disPercent = 0;
        var rec_disPercent = 0;
        var disAmount = 0;
        var rec_disAmount = 0;
        var tax_rate         = $(this).parents('tr').find('.vat-tax-d').children("option:selected").attr('data-vat');
        tax_rate = $.isNumeric(tax_rate) ? tax_rate : $('.tax_rate').val();
        
        var taxType = $('#tax_type_d').children("option:selected").val();
        var rec_tax_typeflag = $('#rec_lbp_curr_rate_d').attr('data-sq-rec-flag');
        if (rec_tax_typeflag == 1) {
            currency_rate = $('#rec_currency_d').children("option:selected").attr('data-rate');
            var taxType = $('#rec_tax_type_d').children("option:selected").val();
        } else {
            currency_rate = $('#currency_d').children("option:selected").attr('data-rate');
            var taxType = $('#tax_type_d').children("option:selected").val();
        }
        var discountTypeInline = $(this).parents('tr').find('.selected').attr('data-original-index');
        // var disc_val = $('input.discount_d').val()
        // if(discountTypeInline == 1 && disc_val >= 100){
        //     $('input.discount_d').val(0);
        // }
        
        if ($(this).hasClass('qty_d')) {
            qty_d = $(this).val();
            if (!$.isNumeric(qty_d)) {
                $(this).val(0);
                calcTotal('qty', $(this).parents('tr'), false, discountTypeInline,false,false,false,tax_rate);
            } else if ($.isNumeric(qty_d) && $.trim(qty_d)) {
                calcTotal('qty', $(this).parents('tr'), false, discountTypeInline,false,false,false,tax_rate);
            }
        }
        if ($(this).hasClass('rate_d')) {
            $(this).parents('tr').find('.tax_d').attr('data-tax-type', taxType);
            rate_d = $(this).val();
            var def_curr_id = $('#lbp_curr_rate_d').attr('def-curr-id');
            var def_curr_rate = $('#lbp_curr_rate_d').val();
            $(this).parents('tr').find('.default_rate_d').val(rate_d * currency_rate);
            if (!$.isNumeric(rate_d)) {
                $(this).val(0);
                calcTotal('rate', $(this).parents('tr'), false, discountTypeInline,false,false,false,tax_rate);
            } else if ($.isNumeric(rate_d) && $.trim(rate_d)) {
                calcTotal('rate', $(this).parents('tr'), false, discountTypeInline,false,false,false,tax_rate);
            }
        }
        if ($(this).hasClass('discount_d') || $(this).hasClass('show_select_d') || $(this).hasClass('rec_show_select_d')) {
            
            discount_d = $(this).val();
            if (discountTypeInline > 0) {
                $(this).parents('tr').find(".discount_d").attr("readonly", false);
            } else {
                $(this).parents('tr').find(".discount_d").attr("readonly", true);
                $(this).parents('tr').find(".discount_d").val(0);
            }
            if (!$.isNumeric(discount_d)) {
                $(this).val(0);
                calcTotal('discount', $(this).parents('tr'), false, discountTypeInline,false,false,false,tax_rate);
            } else if ($.isNumeric(discount_d) && $.trim(discount_d)) {
                calcTotal('discount', $(this).parents('tr'), false, discountTypeInline,false,false,false,tax_rate);
            }
            calLbpTotalEqui();
            setTimeout(function() {
                calculate_total(false,tax_rate)
            }, 500);
            // alert("here");
            // setTimeout(function() {
                // rec_calculate_total()
            // }, 500);
        }
        if ($(this).hasClass('tax_d')) {
            tax_d = $(this).val();
            if (!$.isNumeric(tax_d)) {
                $(this).val(0);
                calcTotal('tax', $(this).parents('tr'), false, discountTypeInline,false,false,false,tax_rate);
            } else if ($.isNumeric(tax_d) && $.trim(tax_d)) {
                calcTotal('tax', $(this).parents('tr'), false, discountTypeInline,false,false,false,tax_rate);
            }
        }
        if ($(this).hasClass('amount_d')) {
            amount_d = $(this).val();
            if (!$.isNumeric(amount_d)) {
                $(this).val(0);
                calcTotal('amount', $(this).parents('tr'), false, discountTypeInline,false,false,false,tax_rate);
            } else if ($.isNumeric(amount_d) && $.trim(amount_d)) {
                calcTotal('amount', $(this).parents('tr'), false, discountTypeInline,false,false,false,tax_rate);
            }
        }
        if ($(this).hasClass('des_d')) {
            des_d = $(this).val();
            if ($.trim(des_d)) {
                calcTotal('des', $(this).parents('tr'),false,false,false,false,false,tax_rate);
            }
        }
        if ($(this).hasClass('vat-tax-d')) {
            vat_value = $(this).children("option:selected").attr('data-vat');
            if(vat_value == 'Select type' || vat_value == '' || vat_value == null ){
                this__.parents('tr').find('.show_inline_vat_d .vat_span').text("");
            }
            vat_value = $.isNumeric(vat_value) ? vat_value : $('.tax_rate').val();
            if ($.isNumeric(vat_value) && $.trim(vat_value)) {
                calcTotal('vat', $(this).parents('tr'), false, discountTypeInline,false,false,false,tax_rate);
            }
        }
        //change get discount value
        $.each($('.er > tbody > tr'), function() {
            var discount_value = $(this).find('.discount_d').val();
            var disTypeInline = $(this).find('.selected').attr('data-original-index');
            if ($.isNumeric(discount_value)) {
                if (disTypeInline == 1) {
                    disPercent += parseFloat(discount_value);
                } else if (disTypeInline == 2) {
                    disAmount += parseFloat(discount_value);
                }
            }
        });

        $.each($('.table_recuring_d > tbody > tr'), function() {

            var rec_discount_value = $(this).find('.rec_discount_d').val();
            var rec_disTypeInline = $(this).find('.selected').attr('data-original-index');
            if ($.isNumeric(rec_discount_value)) {
                if (rec_disTypeInline == 1) {
                    rec_disPercent += parseFloat(rec_discount_value);
                } else if (rec_disTypeInline == 2) {
                    rec_disAmount += parseFloat(rec_discount_value);
                }
            }
        });
        if (disPercent > 0 || disAmount > 0) {
            $('body').find('#inline_dis_percent_d').val(numberTwoDigitComaSep(disPercent));
            $('body').find('#inline_dis_amount_d').val(numberTwoDigitComaSep(disAmount));
        }
        if (rec_disPercent > 0 || rec_disAmount > 0) {  
            $('body').find('#rec_inline_dis_percent_d').val(numberTwoDigitComaSep(rec_disPercent));
            $('body').find('#rec_inline_dis_amount_d').val(numberTwoDigitComaSep(rec_disAmount));
            
        }
    });

    //currcncy change 
    $('body').on('change', '#currency_d', function() {
        currency_id = $(this).children("option:selected").val();
        currency_rate = $(this).children("option:selected").attr('data-rate');
        currency_default_id = $(this).children("option:selected").attr('curr-default-id');
        var taxType = $('#tax_type_d').children("option:selected").val();
        var prev_rate = $('#cur_curnt_rate_d').val();

        // updated selected_exchange_rate value 
        $('#selected_exchange_rate').val(currency_rate);
        
        $('#lbp_curr_rate_d').val(currency_rate);
        $('#lbp_curr_rate_d').attr('def-curr-id',currency_id);
        $('#cur_prev_rate_d').val(prev_rate);
        //currency symbol
        var curr_text = $(this).children("option:selected").text();
        if (curr_text) {
            var currency_text = curr_text.substr(0, curr_text.indexOf(' '));
            $('body').find('.currency_symbol_d').text(currency_text);
        }
        $('#cur_curnt_rate_d').val(currency_rate);
        if (currency_default_id == default_currency || taxType == 3) {
            $('body').find('.lbp_vat_equi_d').addClass('hide-d');
            $(".total-lbp-d").addClass('hide-d');
        } else {

            $('body').find('.lbp_vat_equi_d').removeClass('hide-d');
            $('body').find('.lbp_rec_vat_equi_d').removeClass('hide-d');
            $('.total-lbp-d').removeClass('hide-d');
        }
        updateCurrencyValues();
        calculate_total();
        calLbpTotalEqui();
    });

    //change tax type
    $('body').on('change', '#tax_type_d', function() {
        var taxType = $(this).children("option:selected").val();
        currency_default_id = $('#currency_d').children("option:selected").attr('curr-default-id');
        if (taxType == 3) {
            updateTableValues(taxType);
            if (currency_default_id == default_currency || taxType == 3) {
                $('.vat_total_d').val(" ");
                $('.vat_d').addClass('hide-d');
                $('body').find('.lbp_vat_equi_d').addClass('hide-d');
            } else {
                $('.vat_d').removeClass('hide-d');
                $('body').find('.lbp_vat_equi_d').removeClass('hide-d');
            }
            $('body').find('.tax_type_d').addClass('hide-d');
            $('body').find('.vat_type_d').addClass('hide-d');
        } else if (taxType == 1) {
            updateTableValues(taxType);
            //$('.vat_total_d').val(" ");    
            if (currency_default_id == default_currency) {
                $('body').find('.lbp_vat_equi_d').addClass('hide-d');
            } else {
                $('body').find('.lbp_vat_equi_d').removeClass('hide-d');
            }
            $('.vat_d').removeClass('hide-d');
            $('body').find('.tax_type_d').removeClass('hide-d');
            $('body').find('.vat_type_d').removeClass('hide-d');
        } else {
            updateTableValues(taxType);
            if (currency_default_id == default_currency) {
                $('body').find('.lbp_vat_equi_d').addClass('hide-d');
            } else {
                $('body').find('.lbp_vat_equi_d').removeClass('hide-d');
            }
            $('.vat_d').removeClass('hide-d');
            $('body').find('.tax_type_d').removeClass('hide-d');
            $('body').find('.vat_type_d').removeClass('hide-d');
        }
    });

    //changes blur to change   
    $('body').on('change', '.er tr > td > input', function() {
        //calculate total sum 
        currency_rate = $('#currency_d').children("option:selected").attr('data-rate');
        var calculated_total_sum = 0;
        var calculated_discount = 0;
        var sub_total = 0;
        var disPercent = 0;
        var disAmount = 0;
        //calculate total amount
        $.each($('.er > tbody > tr'), function() {
            //calculte total amount
            var discountTypeInline = $(this).find('.selected').attr('data-original-index');
            var get_textbox_value = $(this).find('.amount_d').val();
            if ($.isNumeric(get_textbox_value)) {
                calculated_total_sum += parseFloat(get_textbox_value);
            }
            var get_qty = $(this).find('.qty_d').val();
            var get_rate = $(this).find('.rate_d').val();
            //calculate sub total 
            if ($.isNumeric(get_qty) && $.isNumeric(get_rate)) {
                sub_total += (parseFloat(get_qty) * parseFloat(get_rate));
                $(".show_sub_total_d").html(numberTwoDigitComaSep(sub_total));
                $(".sub_total_d").html(sub_total);
            }
            //calculate total discount
            var discount_value = $(this).find('.discount_d').val();
            //calculate sub total 
            if ($.isNumeric(discount_value)) {
                if (discountTypeInline == 1) {
                    disPercent += parseFloat(discount_value);
                } else if (discountTypeInline == 2) {
                    disAmount += parseFloat(discount_value);
                }
            }
        });
        if (calculated_total_sum % 1 === 0) {
            calculated_total_sum = calculated_total_sum + '.00';
        }
        var newTotal = getDispalyValuesRound(calculated_total_sum);
        $('#total_withoutComa_d').val(newTotal);
        var totalComaSep = getDispalyValuesR(newTotal);
        if (currency_rate) {
            var lbpRate = $('body').find('#lbp_curr_rate_d').val();
            var amountInLbp = currency_rate * newTotal;
            var lbptwoDigit = getDispalyValuesRound(amountInLbp);
            var lbpComaSeprated = getDispalyValuesR(lbptwoDigit)
            $(".show_gtotal_lbp_d").html("LBP " + lbpComaSeprated);
        }
        $(".show_gtotal_d").html(numberTwoDigitComaSep(totalComaSep));
        if (disPercent > 0 || disAmount > 0) {
            $('body').find('#inline_dis_percent_d').val(numberTwoDigitComaSep(disPercent));
            $('body').find('#inline_dis_amount_d').val(numberTwoDigitComaSep(disAmount));
        }
    });

    $('body').on('keyup', '.er tr > td > input', function(event) {
        //updown event
        if (event.keyCode === 38) {
            pre_tr_a = $(this).siblings().parents('tr.active').prev('tr');
            pre_tr_a.find('td').eq(detect_td_index).click();
        }
        if (event.keyCode === 40) {

            next_tr_a = $(this).siblings().parents('tr.active').next('tr');
            //console.log(next_tr_a.find('td').eq(detect_td_index),'jjjjjjjjjjjjjjjjjjjjjjjjj');
            next_tr_a.find('td').eq(detect_td_index).click();
        }
    });

    //clear table data
    $('body').on('click', '.quotation-clear-d', function() {
        clearGridLines('.quotation-table-clear-d > tbody', def_grid_clear);
        $(".sub_total_d").html('');
        $(".show_gtotal_d").html('0.00');
        $(".show_sub_total_d").html('0.00');
        $('.sub_total_d').val(0);
        rowsNumberQuo();
    });

    $('body').on('change', '.quotation_no_d', function() {
        var quotation_no = $(this).val();
        if (!$.isNumeric(quotation_no)) {
            $("#sequence_no_d").text('');
            $(".quotation_no_d").val("");
        } else {
            $("#sequence_no_d").text(quotation_no);
        }
        $.ajax({
            type: "POST",
            url: baseUrl + 'quotation-no-check',
            data: {
                id: 'no-robot',
                'quotation_no': quotation_no
            },
            success: function(response) {
                if (response.status == 'ERROR') {
                    $('.show-success-pop-d').html(response.message);
                    $('#success_modal_d').modal('show');
                }
            },
        });
    });

    $('body').on('click', '.save_customer_d', function() {
        var name = $("#customer_name_d").val();
        $.ajax({
            type: "POST",
            url: baseUrl + 'save-new-customer',
            data: {
                'cust_comp_name': name
            },
            success: function(response) {
                if (response.status == 'OK') {
                    appendNewRecordSelectrizer('.show_cust_d', '.qt-cust-d', '.vendor_id-d', '.vendor_id', response.data[0], response.data[1]);
                    $('#qoutation_qbo_content').hide();
                    $('.cus_text_d').html("");
                }
            },
        });
    });

    function append_expir_date() {
        var term_id = $.trim($('.sqo_term-d').val());
        //alert(term_id);

        if(term_id!=0)
        {
        $.ajax(

        {
        type: "POST",
        url: baseUrl +'get-termby-id', 
        data:{'id':'no-robot', 'term_id':term_id},
        success: function(res)
        {
        if(res.data['term'][0]['day_field'] != 'undefined'){ 
        termCalculate(res.data['term'][0]['day_field'],res.data['term'][0]['due_by_certain_day_of_month'],'#so_exp_date_d');
                }
             },
         });
      }
    }

    //default script 
    
    
    
    function defaultScript() {
        sub_total = 0;
        vat_total = 0;
        quo_total = 0;
        var disPercent = 0;
        var disAmount = 0;
        default_currency = $('#default_currency_id').val();
        // alert(default_currency)
        $('.selectpicker').selectpicker('refresh');
        gendate('#quotation_date_d');
        gendate('#quotation_expiry_date_d');
        gendate('#purchase_order_d');

          rec_edit_terms_d = $('input.rec_sqo-terms-d').val();
            if(rec_edit_terms_d)
            {
            selectedSlectorz('input.rec_sqo-terms-d');
         }  
        $("#test_quotation_form_d").detectChanges();


        edit_pi_terms_d = $('input.sqo-terms-d').val();
            if(edit_pi_terms_d)
            {
            selectedSlectorz('input.sqo-terms-d');
            } 
            append_expir_date();
        //currecny and tax on load
        currency_rate = $('#currency_d').children("option:selected").attr('data-rate');
        $('#cur_curnt_rate_d').val(currency_rate);
        currency_default_id = $('#currency_d').children("option:selected").attr('curr-default-id');
        var tax_type = $('#tax_type_d').children("option:selected").val();
        var total = $("#hidden-total-d").val();
        var curr_text = $('#currency_d').children("option:selected").text();
        var discount_type = $('#discount_total_d').children("option:selected").val();
        $('div.show_select_d').hide();
        $('div.show_vat_d').hide();
        //send later form validations
        if ($('#qoutation_qbo_01').is(':checked')) 
        {
            $('#test_quotation_form_d').removeData('validator');
            $('.form-control > email-d').removeClass('error');
            $('.form-control > email-d').removeClass('required');
            validate_form_($('#test_quotation_form_d'), {ven_id___: {required: true},"quotation_no": {number: true
                },"rate[]": {number: true},"qty[]": {number: true},"amount[]": {number: true},"discount[]": {number: true} 
            },validateEmpty, false, true);
        }
        //calculate vat on total
        $.each($('.er > tbody > tr'), function() {
            var qty = $(this).find('.qty_d').val();
            var unit_price = $(this).find('.rate_d').val();
            var amount_value = $(this).find('.amount_d').val();
            var vat = $(this).find('.tax_d').val();
            var discount_value = $(this).find('.discount_d').val();
            var discountTypeInline = $(this).find('.selected').attr('data-original-index');
            //calculate subtotal on all table values 
            if (qty == null || unit_price == null) {
                sub_total = 0;
            } else if ($.isNumeric(qty) && $.isNumeric(unit_price)) {
                sub_total += (parseFloat(qty) * parseFloat(unit_price));
            }
            if (discount_value) {
                if (discountTypeInline == 1) {
                    disPercent += parseFloat(discount_value);
                } else if (discountTypeInline == 2) {
                    disAmount += parseFloat(discount_value);
                }
            }
            //calculate vat on all table values
            if (vat == null || vat == '') {
                vat_total = vat_total;
            } else if ($.isNumeric(vat_total)) {
                vat_total += parseFloat(vat);
                //lbp vat equi
                var lbpRate = $('body').find('#lbp_curr_rate_d').val();
                if (lbpRate) {
                    var vatEqui = vat_total * currency_rate;
                    var lbptwodigitval = getDispalyValuesRound(vatEqui);
                    $('body').find('#lbp_vat_equ_d').val(lbptwodigitval);
                    var LBPEqui = vat_total * currency_rate;
                    var LBPEquicomaSep = numberTwoDigitComaSep(LBPEqui);
                    if (LBPEquicomaSep % 1 === 0) {
                        LBPEquicomaSep = LBPEquicomaSep + '.00';
                    }
                    $('body').find('.show_gtotal_lbp_d').text(LBPEquicomaSep);
                }
            }
            //calculate quotation total  
            if (amount_value == null) {
                quo_total = 0;
            } else if ($.isNumeric(amount_value)) {
                quo_total += parseFloat(amount_value);
            }
            //inline discount selected
            if (discountTypeInline > 0) {
                $(this).find(".discount_d").attr("readonly", false);
            } else {
                $(this).find(".discount_d").attr("readonly", true);
                $(this).find(".discount_d").val('');
            }
        });
        //vat on load
        $('body').find('.vat_total_d').val(numberTwoDigitComaSep(vat_total));
        
        if (disPercent > 0 || disAmount > 0) {
            $('body').find('#inline_dis_percent_d').val(numberTwoDigitComaSep(disPercent));
            $('body').find('#inline_dis_amount_d').val(numberTwoDigitComaSep(disAmount));
        }
        //subtotal
        if (sub_total) {
            if (sub_total % 1 === 0) {
                sub_total = sub_total + '.00';
            }
            $('.show_sub_total_d').text(numberTwoDigitComaSep(sub_total));
            $('.sub_total_d').val(sub_total);
        }
        //quo_total
        if (quo_total) {
            if (quo_total % 1 === 0) {
                quo_total = quo_total + '.00';
            }
            $('body').find('.show_gtotal_d').text(numberTwoDigitComaSep(quo_total));
            $('#total_withoutComa_d').val(quo_total);
        }
        if (curr_text) {
            var currency_text = curr_text.substr(0, curr_text.indexOf(' '));
            $('body').find('.currency_symbol_d').text(currency_text);
        }
        if (currency_rate && total) {
            var lbpRate = $('body').find('#lbp_curr_rate_d').val();
            var amountInLbp = currency_rate * total;
            //var newTotalLBPComa = amountInLbp.toLocaleString("en");
            var lbptwoDigit = getDispalyValuesRound(amountInLbp);
            var lbpComaSep = getDispalyValuesR(lbptwoDigit);
            $(".show_gtotal_lbp_d").html("LBP " + lbpComaSep);
        }
        if (currency_default_id == default_currency) {
            $('body').find('.lbp_vat_equi_d').addClass('hide-d');
            $(".total-lbp-d").addClass('hide-d');
            $('body').find('.lbp_rec_vat_equi_d').addClass('hide-d');
            $(".rec-total-lbp-d").addClass('hide-d');
        } else if (tax_type == 3 || currency_default_id != default_currency) {
            $('body').find('.lbp_vat_equi_d').addClass('hide-d');
            $('.total-lbp-d').addClass('hide-d');
            $('body').find('.lbp_rec_vat_equi_d').addClass('hide-d');
            $(".rec-total-lbp-d").addClass('hide-d');
        } else if (tax_type == 3 || currency_default_id == default_currency) {
            $('body').find('.lbp_vat_equi_d').addClass('hide-d');
            $('.total-lbp-d').addClass('hide-d');
            $('body').find('.lbp_rec_vat_equi_d').addClass('hide-d');
            $(".rec-total-lbp-d").addClass('hide-d');
        } else if (tax_type != 3 || currency_default_id != default_currency) {
            $('body').find('.lbp_vat_equi_d').removeClass('hide-d');
            $('.total-lbp-d').removeClass('hide-d');
            $('body').find('.lbp_rec_vat_equi_d').removeClass('hide-d');
            $(".rec-total-lbp-d").removeClass('hide-d');
        }
        //tax type selected
        if (tax_type == 3) {
            $('body').find('.tax_type_d').addClass('hide-d');
            $('body').find('.vat_type_d').addClass('hide-d');
            $('body').find('.discount_label_d').addClass('hide-d');
        } else {
            $('body').find('.discount_label_d').removeClass('hide-d');
            $('body').find('.tax_type_d').removeClass('hide-d');
            $('body').find('.vat_type_d').removeClass('hide-d');
        }
        if (currency_default_id == default_currency || tax_type == 3) {
            $('body').find('.lbp_vat_equi_d').addClass('hide-d');
            $(".total-lbp-d").addClass('hide-d');
        } else {
            $('body').find('.lbp_vat_equi_d').removeClass('hide-d');
            $('.total-lbp-d').removeClass('hide-d');
        }
        if (discount_type == 1) {
            $('body').find('.discount_label_d').removeClass('hide-d');
        } else {
            $('body').find('.discount_label_d').addClass('hide-d');
        }
        $('table.er').resizableColumns();
        //selected estimate text
        // var estimate_sele = $('#estimate_status_d').children("option:selected").text();
        // if (estimate_sele) {
        //     $('.append_estimate_status_d').text(estimate_sele);
        // }
        // $('.accept_image').hide();
        // $('.closed_image').hide();
        // $('.reject_image').hide();
        // $('.pending_display_none').hide();
        // $('.accepted_text').hide();
        // $('.closed_text').hide();
        // $('.rejected_text').hide();
        $('#qoutation_qbo_content').hide();
        $('.select_input').click(function() {
            $('.visible-selectize-options').toggle();
        });
        $('.er input').hide();
        $('.re tbody tr td:nth-child(3n) .selectize-control').hide();
        $('.er tbody tr .quo_inline_discount_d').hide();
        $('.inlinespan1').on('change', function() {
            var discount_val = $('.inlinespan1').children("option:selected").val();
            var discount_type = $('.inlinespan1').children("option:selected").text();
            if (discount_val > 0) {
                $(this).siblings().parents().find('tr.active').children().find('.inlinespan1').next('span').text(discount_type);
            } else {
                $(this).siblings().parents().find('tr.active').children().find('.inlinespan1').next('span').text("");
            }
        });
        $('.inlinespan2').on('change', function() {
            var discount_vl = $('.inlinespan2').children("option:selected").val();
            var discount_typ = $('.inlinespan2').children("option:selected").text();
            if (discount_vl > 0) {
                $(this).siblings().parents().find('tr.active').children().find('.inlinespan2').next('span').text(discount_typ);
            } else {
                $(this).siblings().parents().find('tr.active').children().find('.inlinespan2').next('span').text("");
            }
        });
        //add class dropdown
        $('.cus-lines-s + .bootstrap-select button > span.caret').addClass('custom-line-s');
    }

    $('body').on('click', '.add_line_onclick', function() {
        for (l = 0; l < def_grid_len; l++) {
            //var selCount = $('.er tbody tr:last').index();
            trx_quot_row(false, false);
        }
        gridRowsNumber('.er > tbody > tr');
    });

    $(document).on('click', '.er tbody tr td', function(e) {
        $('input').removeClass('row_inp_show_icon');
        if ($(this).hasClass('inv_plus_icon')) {
            return;
        }
        $(this).closest('tr').prevAll().find('.caret-selectize-option').hide();
        $(this).closest('tr').nextAll().find('.caret-selectize-option').hide();
        // $('.er tbody input').hide();
        // $('.er tbody tr td:nth-child(3n) .selectize-control').hide();
        $('.er tbody tr td').find('span').show();
        $(this).parent().find('input').show();
        $(".re tbody tr").removeClass("active");
        $(".er tbody tr").each(function() {
            $(this).find('td:first-child').html("<img src='" + baseUrl + "public/admin/images/toggle.png'>");
        });
        var vat_value = $(this).parent().find('.vat-tax-d').children("option:selected").attr('data-vat');
        //debugger
        if(vat_value !== null && $.isNumeric(vat_value)  && vat_value !=='Select type') {
            var vat_text = $(this).parent().find('.vat-tax-d').children("option:selected").text();
            $(this).parent().find('.show_inline_vat_d .vat_span').text(vat_text);
        }
        $(this).parent().addClass("active");
        $('.hide-show-pro-sel-d').removeClass('hide-d');
        $(this).parent().find('td:nth-child(3n) .selectize-control').show();
        $(this).parent().find('div.show_select_d').show();
        $(this).parent().find('div.show_vat_d').show();
        $('.selectpicker').selectpicker('refresh');
        $(this).find('span').text($(this).find(".qt-prod-d").val());
        $(this).parent().find('.caret-selectize-option').show();
        $(this).parent().find('td span').hide();
        if ($(this).parent().is(':last-child')) {
            trx_quot_row($(this), 'input');
            gridRowsNumber('.er > tbody > tr');
        }
        $(this).parent().find("td:eq(0)").html("<img class='cursor-pointer-s inv_plus_icon' src='" + baseUrl + "public/admin/images/plus_sign_qbo.png'><input type='hidden'>");
        $(this).parents("tr").children("td:first").removeClass('inv_plus_icon');
        if ($(this).parent().is(':last-child')) {
            trx_quot_row($(this), 'input');
        }
        $(this).find('input').focus();
        if ($(this).find(".sku-d").is(":visible")){
            $('.sku-d').removeClass('hide-d');
        }
    });

    $('body').on('click', '.inv_plus_icon', function() {
        trx_quot_row($(this), 'icon');
        gridRowsNumber('.er > tbody > tr');
    });
    ////last
    $('body').on('click', '#quotation_sorting tbody tr:last', function() {
        trx_quot_row($(this), 'input');
        gridRowsNumber('.er > tbody > tr');
    });

    function trx_quot_row(this_ = '', click_check_inv = '') {
        var lastIndex = $('.er tbody tr:last').index();
        var newIndex = lastIndex + 2;
        row_selct_num = '';
        quo_row_date_picker = '';
        $('[inv-select-num]').each(function(a) {
            quo_row_date_picker = a;
            row_selct_num = a;
        });
        var vat_options = $('.vat-tax-d').html();
        row_selct_num = row_selct_num + 2;
        quo_row_date_picker = quo_row_date_picker + 1;
        //var drop_count = 0;
        $('.er tbody').append("<tr class='append_d'><input type='hidden' name='default_rate[]' class='default_rate_d' data_istax='1' value=''><td class='inv_plus_icon' align='center'></i><img src='" + baseUrl + "public/admin/images/toggle.png'></td><td align='center'></td><td class='selector-text-s quo-product-d tax-selector-d" + row_selct_num + "'><div class='custom-selector-s hide-show-pro-sel-d'><div class='selectize-custom'><input type='text' name='product_id__[]' class='select_input qt-prod-d hide-d tableInput' search-selector /><div class='caret-selectize-option caret-show-hide-d qt-prod-d hide-d'><i class='fa fa-caret-down' aria-hidden='true'></i></div><div class='selector-attr-hid-val-d'></div></div><div class='visible-selectize-options min-wid append-selectize-pro-d qt-prod-d hide-d' attr-height='200'></div></div><span class='span-taxt-d'></span></td><td class='text-left sku-d' valign='middle'><input class='form-control tableInput sku-d' name='sku[]' readonly><span></span></td><td  tab-index='1' class='show_des_d text-left selector-text-s move-up-down-row-d' valign='middle'><input autocomplete='off' class='form-control des_d tableInput' name='description[]' type='text'><span></span></td><td class='text-left show_qty_d recur_row_input'><input class='form-control qty_d tableInput' name='qty[]' type='text'><span></span></td><td class='text-left show_rate_d recur_row_input'><input class='form-control service_unit_price_d rate_d tableInput' name='rate[]' type='text'><span></span></td><td class='show_inline_disc_d dis_type_d hide-d'><select name='inline_discount_type[]' class='form-control discount-d hide-d quo-tax-s show_select_d selectpicker inlinespan" + newIndex + "'><option>Select type</option><option value='1'>Percentage</option><option value='2'>Amount</option></select><span></span></td><td class='text-left show_discount_d recur_row_input dis_type_d hide-d'><input class='form-control service_unit_price_d discount_d tableInput' name='discount[]' readonly='' type='text'><span></span></td><td class='show_inline_vat_d move-up-down-row-d vat_type_d'><select name='vat_rate[]' class='form-control hide-d vat-tax-d vat-tax-s show_vat_d selectpicker'>'" + vat_options + "'</select><span class='vat_span'></span></td><td class='text-left show_tax_d tax_type_d hide-d' valign='middle'><input name='tax[]' class='form-control tax_d tableInput' data-tax-type='' type='text' readonly value=''><span></span></td><td class='text-left show_amount_d last_td_tooltip_s last_td_tooltip_s'><input class='form-control amount_d tableInput' name='amount[]' type='text'><span></span></td><td align='center'><button type='button' class='del no-del quo-del-d'><img src='" + baseUrl + "public/admin/images/delete_qbo.png'></td></tr>");
        //selected columns
        $('.selectpicker').selectpicker('refresh');
        var discount_type = $('#discount_total_d').children("option:selected").val();
        if (discount_type == 1) {
            $('body').find('.dis_type_d').removeClass('hide-d');
        } else {
            $('body').find('.dis_type_d').addClass('hide-d');
        }
        //tax type selected
        var tax_type = $('#tax_type_d').children("option:selected").val();
        if (tax_type == 3) {
            $('body').find('.tax_type_d').addClass('hide-d');
            $('body').find('.vat_type_d').addClass('hide-d');
        } else {
            $('body').find('.tax_type_d').removeClass('hide-d');
            $('body').find('.vat_type_d').removeClass('hide-d');
        }
        if($('body').find('#id_sku').is(":checked")){
            $('body').find('.sku-d').removeClass('hide-d');
        }else{
            $('body').find('.sku-d').addClass('hide-d');
        }
        $('.er tbody tr:last-child td:eq(1)').html($('.er tbody tr').length);
        $('.inlinespan' + newIndex).on('change', function() {
            var discount_val = $(this).children("option:selected").val();
            var discount_type = $(this).children("option:selected").text();
            if (discount_val > 0) {
                $(this).siblings().parents().find('tr.active').children().find('.inlinespan' + newIndex).next('span').text(discount_type);
            } else {
                $(this).parents().find('tr.active').find('.show_select_d').next('span').text("");
                //$(this).next('span').text(" ");
            }
        });
        $('.append-selectize-pro-d').html(product_details);
        param = {
            focus_: false
        };
        $('.qt-prod-d').selectorz(param);
        if (click_check_inv == 'icon') {
            this_.parents('tr').find('input').addClass('row_inp_show_icon');
        } else if (click_check_inv == 'input') {
            $('.er tbody input').hide();
            this_.parent().find('input').show();
        }
        $('.er tbody tr:last-child td:nth-child(3n) .selectize-control').hide();
        $('.re tbody tr:last-child td.quo_inline_discount_d').hide();
    }
    //subtotal
    $('body').on('change', '.qty_d, .rate_d, .amount_d', function() {
        var current_tr = $(this).closest('tr');
        if ($(current_tr).nextAll().children().hasClass('stotal_d')) {
            var new_sub_total = 0;
            while (current_tr) {
                if ($(current_tr).prev().children().find('.amount_d').val()) {
                    current_tr = $(current_tr).prev();
                } else {
                    break;
                }
            }
            while (current_tr) {
                if ($(current_tr).children().hasClass('stotal_d')) {
                    $(current_tr).find('.stotal_d').html('Subtotal: ' + new_sub_total);
                    break;
                } else {
                    get_textbox_value = $(current_tr).children().find('.amount_d').val();
                    if (get_textbox_value == null) {
                        calculate_sub_total = 0;
                    } else if ($.isNumeric(get_textbox_value)) {
                        new_sub_total += parseFloat(get_textbox_value);
                    }
                    current_tr = $(current_tr).next();
                }
            }
        }
    });

    $('body').on('click', '.quo-del-d', function() {
        deleteGridLines($(this), 'er', def_grid_len, '.er > tbody > tr');
        gridRowsNumber('.er > tbody > tr');
        $('.er tbody tr:nth-last-child(1)').prev('tr').removeClass("last_row_border");
        calculate_subtotals();
        calLbpTotalEqui();
        calculate_total();
    });

    $('body').on('click', '.quotation-subtotal-d', function() {
        getSubtotals();
    });
    //discount
    $('body').on('change', '.cal_discount-d, .discount_val_d, .h_s_dis_d', function() {       
        calculate_sub_vat_total();
    });
    // $('body').on('click','.page-content-app',function(event)
    // {
    //   if($(event.target).hasClass('pr-cat-fld-d') || $(event.target).parent().hasClass('pr-cat-fld-d') || $(event.target).hasClass('pr-customer-d') || $(event.target).parent().hasClass('pr-customer-d'))
    //   {
    //   }else{
    //     $('.visible-selectize-options').hide();
    //   }
    // });
    
    //..............terms
    $('body').on('click','.add-new-term-ddd',function(){
        terms_integrate('add_new','','.append_terms_option_d','.sqo-terms-d','.sqo_terms-d','sqo_terms_id');
    });

    $('body').on('click','#test_quotation_form_d .append_terms_option_d .child_options_list',function()
    {
        var terms = $.trim($(this).attr('attr-day-field'));
        var monthsterms = $.trim($(this).attr('attr-month'));
        termCalculate(terms,monthsterms,'#so_exp_date_d');
    });
    //.............................
    $('body').on('click', '.quotation_container', function(e) {
        if ($(e.target).hasClass('filter-option')) {
            return;
        }
        $('.re tbody tr td:nth-child(3n) .selectize-control').hide();
        $(".er tbody tr").find('.quo_inline_discount_d').hide();
        //$('.er tbody tr td.quo_inline_discount_d').hide();
        //$('.er tbody tr td:nth-child(3n)').parent().find('.caret-selectize-option').hide();
        $('.er tbody tr td:nth-child(3n)').parents('tr').find('.caret-selectize-option').hide();
        $('.visible-selectize-options-parent').hide();
        $('.visible-selectize-options').hide();
        $('.append_terms_option_d').hide();
        $('.append-selectize-pro-d').hide();
        $('#qoutation_qbo_content').hide();
        $('.hide-show-pro-sel-d').addClass('hide-d');
        $('.er tbody input').hide();
        if(($('body').find(".sku-check-d").val()) ==1){
            $('body').find('.sku-d').removeClass('hide-d');
        }
        $(this).parent().find('select.show_select_d').hide();
        $(this).parent().find('div.show_select_d').hide();
        $(this).parent().find('select.show_vat_d').hide();
        $(this).parent().find('div.show_vat_d').hide();
        $('.er tbody tr td').find('span').show();
        if ($('.row_inp_show_icon').length) {} else {
            $('.er tbody tr td:first-child').html("<img src='" + baseUrl + "public/admin/images/toggle.png'>");
        }
        $('.er tbody tr').removeClass('active');
        $('.er tbody tr').each(function(index) {
            $(this).children('td').first().addClass('inv_plus_icon');
            $(this).children('td').first().html("<img src='" + baseUrl + "public/admin/images/toggle.png'>");
        });
    });
    //set date on term select
    $('body').on('change', '#terms-d', function() {
        var terms = $.trim($(this).find("option:selected").text());
        if ($.isNumeric(terms) && $.trim(terms)) {
            var todayDate = new Date();
            todayDate.setDate(todayDate.getDate() + parseInt(terms));
            var dd = todayDate.getDate();
            var mm = todayDate.getMonth() + 1;
            var y = todayDate.getFullYear();
            var quo_exp_date = dd + '/' + mm + '/' + y;
            document.getElementById('exp-date-d').value = quo_exp_date;
        } else {
            document.getElementById('exp-date-d').value = '';
        }
    });
$('body').on('click','.btn-m-r',function(){
                    $("#quotation_qbo_recurring_n").modal('show');
})
    
    //recurring copy data
    function recuring_append_row_copy(this_ = '', click_check_inv = '') {
        var product_id = this_[2];
        var description = this_[3];
        var qty = this_[4];
        var unit_price = this_[5];
        var tax = this_[8];
        var amount = this_[9];
        var lastIndex = $('.table_recuring_d tbody tr:last').index();
        var newIndex = lastIndex + 2;
        row_selct_num = '';
        quo_row_date_picker = '';
        $('[inv-select-num]').each(function(a) {
            quo_row_date_picker = a;
            row_selct_num = a;
        });
        var vat_options = $('.vat-tax-d').html().replace('selected=""', '');
        row_selct_num = row_selct_num + 2;
        quo_row_date_picker = quo_row_date_picker + 1;
        //var drop_count = 0;
        //$('.table_recuring_d tbody').append("<tr class='append_d'><input type='hidden' class='rec_real_amount_d' value=''><input type='hidden' data-ratefor-total='' data-outof-scope='' name='default_rate[]' class='default_rate_d' data_istax='1' value=''><input type='hidden' name='update_table_id[]' value=''><input type='hidden' id='simple_get' value=''><td align='center' valign='middle' class='add_movable text-center padding_end'><img src='" + baseUrl + "public/admin/images/toggle.png'></td><td align='center' valign='middle' class='padding_end'></td><td class='selector-text-s rec_quo-product-d td-slectorz-span-fnd-d tax-selector-d" + row_selct_num + " '><div class='custom-selector-s hide-d'><div class='selectize-custom'><input type='text' name='product_id_' class='select_input rec-qt-prod-d hide-d' value='" + product_id + "' search-selector /><div class='caret-selectize-option caret-show-hide-d rec-qt-prod-d hide-d'><i class='fa fa-caret-down' aria-hidden='true'></i></div><div class='selector-attr-hid-val-d'><input type='hidden' name='product_id[]' class='product_id-d' value='" + product_id + "' /></div></div><div class='visible-selectize-options min-wid append-selectize-pro-d hide-d' attr-height='200'></div></div><span class='span-taxt-d'></span></td><td class='text-left show_rec_des_d show_des_d selector-text-s move-up-down-row-d' valign='middle'><input name='description[]' class='form-control rec_des_d des_d' type='text' value='" + description + "'><span>" + description + "</span></td><td class='text-left show_rec_qty_d show_qty_d move-up-down-row-d recur_row_input' valign='middle'><input name='qty[]' class='form-control rec_qty_d qty_d on_hover_tooltip1' type='text' value='" + qty + "'><span>" + qty + "</span></td><td class='text-left show_rec_rate_d show_rate_d move-up-down-row-d recur_row_input' valign='middle'><input name='rate[]' class='form-control rec_rate_d rate_d' type='text' value='" + unit_price + "'><span>" + unit_price + "</span></td><td class='rec_show_inline_disc_d show_inline_disc_d rec_dis_type_d hide-d'><div class='bootstrap_select'><select name='inline_discount_type[]' class='form-control hide-d quo-tax-s rec_show_select_d show_select_d selectpicker rec_inlinespan" + newIndex + "'><option value=''>Select type</option><option value='1'>Percentage</option><option value='2'>Amount</option></select><span></span></div></td><td class='text-left show_rec_discount_d show_discount_d rec_dis_type_d hide-d move-up-down-row-d recur_row_input' valign='middle'><input name='discount[]' class='form-control rec_discount_d discount_d' type='text' value=''><span></span></td><td class='show_inline_vat_d move-up-down-row-d rec_vat_type_d vat_type_d'><select name='vat_rate[]' class='form-control hide-d vat-tax-d rec_vat-tax-d vat-tax-s show_vat_d selectpicker'>'" + vat_options + "'</select><span class='rec_vat_span vat_span'></span></td><td class='text-left rec_show_tax_d rec_tax_type_d show_tax_d tax_type_d' valign='middle'><input name='tax[]' class='form-control rec_tax_d tax_d' type='text' readonly='' data-tax-type='' value='" + tax + "'><span>" + tax + "</span></td><td class='text-left recur_row_input show_rec_amount_d show_amount_d move-up-down-row-d last_td_tooltip_s' valign='middle'><input name='amount[]' class='form-control rec_amount_d amount_d' type='text' value='" + amount + "'><span>" + amount + "</span></td><td align='center' valign='middle' class='padding_end'><button type='button' class='del no-del rec_del_d'><img src='" + baseUrl + "public/admin/images/delete_qbo.png'></button></td></tr>");
        //selected columns
        $('.rec_show_select_d').selectpicker('refresh');
        //$('.selectpicker').selectpicker('refresh');
        var discount_type = $('#rec_discount_total_d').children("option:selected").val();
        if (discount_type == 1) {
            $('body').find('.rec_dis_type_d').removeClass('hide-d');
        } else {
            $('body').find('.rec_dis_type_d').addClass('hide-d');
        }
        //tax type selected
       // var tax_type = $('#rec_tax_type_d').children("option:selected").val();
        if (tax_type == 3) {
            $('body').find('.rec_tax_type_d').addClass('hide-d');
            $('body').find('.rec_vat_type_d').addClass('hide-d');
        } else {
            $('body').find('.rec_tax_type_d').removeClass('hide-d');
            $('body').find('.rec_vat_type_d').removeClass('hide-d');
        }
        $('.table_recuring_d tbody tr:last-child td:eq(1)').html($('.table_recuring_d tbody tr').length);
        $('.rec_inlinespan' + newIndex).on('change', function() {
            var discount_val = $(this).children("option:selected").val();
            var discount_type = $(this).children("option:selected").text();
            if (discount_val > 0) {
                $(this).siblings().parents().find('tr.active').children().find('.rec_inlinespan' + newIndex).next('span').text(discount_type);
            } else {
                $(this).parents().find('tr.active').find('.show_select_d').next('span').text("");
                //$(this).next('span').text(" ");
            }
        });
        $('.append-selectize-pro-d').html(product_details);
        param = {
            focus_: false
        };
        $('.rec-qt-prod-d').selectorz(param);
        selectedSlectorz('input.rec-qt-prod-d', '.td-slectorz-span-fnd-d');
        if (click_check_inv == 'icon') {
            this_.parents('tr').find('input').addClass('row_inp_show_icon');
        } else if (click_check_inv == 'input') {
            $('.table_recuring_d tbody input').hide();
            this_.parent().find('input').show();
        }
        $('div.rec_show_select_d').hide();
        $('div.rec_show_vat_d').hide();
        $('.selectpicker').selectpicker('refresh');
        $('.table_recuring_d tbody tr:last-child td:nth-child(3n) .selectize-control').hide();
        $('.table_recuring_d tbody tr:last-child td.quo_inline_discount_d').hide();
        addDataTypeRecurring();
    }

    $('body').on('click', '.test-slide', function() {
        // var table1 = 'er';
        // var table2 = 'table_recuring_d';
        // paste_data_to_recurring(table1, table2, recuring_append_row_copy);
        // selectedSlectorz('input.rec-qt-prod-d', '.rec_quo-product-d');
        // setTimeout(function() {
        //     rec_calculate_total(1)
        // }, 500);
        // calculate_subtotals();
        $('.table_recuring_d tbody input').hide();
    });
   
    //copy table into recuuring
     
    $('body').on('click','.qoutation_recurring_slide',function()
    {
        var copy_lbpRate = $('#lbp_vat_equ_d').val();
        var email = $('#email_d').val();
        $('#rec_email_d').val(email);
        var so_exp_date_d = $('#so_exp_date_d').val();
        $('#rec_so_exp_date_d').val(so_exp_date_d);
        // var sqo_terms_d = $('.sqo-terms-d').val();
        // $('.selectpicker').selectpicker('refresh');
        // // $('.rec_sqo-terms-d').val(sqo_terms_d);
        // edit_pi_terms_d = $('input.rec_sqo-terms-d').val(sqo_terms_d);
        // if(edit_pi_terms_d)
        // {
        //     selectedSlectorz('input.rec_sqo-terms-d');
        // }
        $('#lbp_rec_vat_equ_d').prop('readonly',false);
        $('#lbp_rec_vat_equ_d').val(copy_lbpRate);
        $('#lbp_rec_vat_equ_d').prop('readonly',true);
        var copy_commment  = $('#comment').val();
        $('#rec_comment').val(copy_commment);
        var copy_memo  = $('#memo').val();
        $('#rec_memo').val(copy_memo);
        custval = $('.vendor_id-d').val();
        if(custval!='')
        {
            $('.rec_customer_id-d').val(custval);
            $('.rec_get_cus_id_d').trigger('click');
        }
        // var datatypevalue = $('.tax_d').attr('data-tax-type');
        // $('.rec_tax_d').attr('data-tax-type',datatypevalue);
        var c_tax_type = $('#tax_type_d option:selected').val();
        //$('#rec_tax_type_d option[value='+c_tax_type+']').attr("selected", "selected");
        var c_currency_id = $('#currency_d option:selected').val();
        var c_discount_id = $('#discount_total_d option:selected').val();
        $('#rec_currency_d option').each(function (e, obj) {
            if($(this).val()==c_currency_id)
            {
                $('.selectpicker').selectpicker('refresh');
                $('#rec_currency_d option[value='+c_currency_id+']').attr("selected", "selected");
            }

        });
        $('#discount_total_d option').each(function (e, obj) {

        if(c_discount_id!='')
        { 
            $('#discount_total_d option').each(function (e, obj) {
            $('.selectpicker').selectpicker('refresh');
            // $('#rec_discount_total_d option[value='+c_discount_id+']').attr("selected", "selected");
            if (c_discount_id == 1) {
                    $('body').find('.rec_dis_type_d').removeClass('hide-d');
                } else {
                    $('body').find('.rec_dis_type_d').addClass('hide-d');
                }

            });
        } 

        });       
      var table1  ='re';
      var table2  ='table_recuring_d';
      paste_data_to_recurring(table1,table2,recuring_append_row);
      selectedSlectorz('input.rec-qt-prod-d','.rec_quo-product-d');
      var email = $('#email_d').val();
      $('#rec_email_d').val(email);
    //   selectedSlectorz('input.rec_sqo-terms-d','.terms-attr-d');
    //   var email = $('#email_d').val();
    //   $('#rec_email_d').val(email);
    //   var sqo_terms_d = $('.sqo-terms-d').val();
    //   $('.selectpicker').selectpicker('refresh');
    //   // $('.rec_sqo-terms-d').val(sqo_terms_d);
    //   edit_pi_terms_d = $('input.rec_sqo-terms-d').val(sqo_terms_d);
    //   if(edit_pi_terms_d)
    //   {
    //       selectedSlectorz('input.rec_sqo-terms-d');
    //     }
        rec_calculate_total();
        // appendTaxType();
    });
    function appendTaxType()
    {
        $.each($('.er >tbody > tr'), function() {
            var taxtype = $(this).closest('tr').find('.default_rate_d').val();
            alert(tax_type);
            if(taxtype!='')
            {
                alert(tax_type);

                $(this).closest('tr').find('.rec_default_rate_d').val(taxtype);
            }    
        });
    }
    $('body').on('click', '.qoutation_recurring_slidewdwad', function() {
        var count = 0;
        var current_rec_row = $('.table_recuring_d > tbody > tr:first');
        var rec_length = $('.table_recuring_d tbody tr').length;
        $.each($('.rer > tbody > tr'), function(k) {
            var description = $(this).children().find('.des_d').val();
            var quantity = $(this).children().find('.qty_d').val();
            var rate = $(this).children().find('.rate_d').val();
            var amount = $(this).children().find('.amount_d').val();
            var prod_serv_id = $(this).children().find('.product_id-d').val();
            if (count < rec_length) {
                $(current_rec_row).children().find('.product_id-d').val(prod_serv_id);
                $(current_rec_row).children().find('.rec_des_d').val(description);
                $(current_rec_row).children().find('.rec_des_d').next('span').text(description);
                $(current_rec_row).children().find('.rec_qty_d').val(quantity);
                $(current_rec_row).children().find('.rec_qty_d').next('span').text(quantity);
                $(current_rec_row).children().find('.rec_rate_d').val(rate);
                $(current_rec_row).children().find('.rec_rate_d').next('span').text(rate);
                $(current_rec_row).children().find('.rec_amount_d').val(amount);
                $(current_rec_row).children().find('.rec_amount_d').next('span').text(amount);
                current_rec_row = $(current_rec_row).next('tr');
            } else {
                createLinesItemRecurring(prod_serv_id, description, quantity, rate, amount);
            }
            count++;
        });
        calculate_subtotals();
    });
    //invoive id
    //link quo po
    $("html").click(function(e) {
        if ($(e.target).closest('.toggle-quo-link-s').length == 0) $(".toggle-quo-link-s").addClass('hide-d');
    });

    $('body').on('click', '#linked-quo-d', function(e) {
        e.stopPropagation();
        $(".toggle-quo-link-s").removeClass('hide-d');
        $('.toggle-quo-link-s').show();
    });
    //purchase order
    $("html").click(function(e) {
        if ($(e.target).closest('.arrow_box_purchase_open').length == 0) $(".arrow_box_purchase_open").addClass('hide-d');
    });
    
    $('body').on('click', '#verfied_hover_qoutation', function(e) {
        e.stopPropagation();
        var status_Class = $('#estimate_status_d').children('option:selected').attr('attr-class');
        var status_val = $('#estimate_status_d').children('option:selected').val();
        if(status_val != 1)
        {
            $('.'+status_Class).trigger('click');
        }
        $(".arrow_box_purchase_open").removeClass('hide-d');
        $('.arrow_box_purchase_open').show();
    });

    $('body').on('click', '.pending_click_img', function() {
        $('.pending_image').show();
        $('.accept_image').hide();
        $('.closed_image').hide();
        $('.reject_image').hide();
        $('.pending_text').show();
        $('.accepted_text').hide();
        $('.closed_text').hide();
        $('.rejected_text').hide();
        $('.pending_display_none').hide();
        $('.arrow_box_purchase_open').css({
            'width': '182px'
        });
    });

    $('body').on('click', '.accept_click_img', function() {
        $('.pending_image').hide();
        $('.accept_image').show();
        $('.closed_image').hide();
        $('.reject_image').hide();
        $('.pending_text').hide();
        $('.accepted_text').show();
        $('.closed_text').hide();
        $('.rejected_text').hide();
        $('.pending_display_none').show();
        $('.arrow_box_purchase_open').css({
            'width': '460px'
        });
    });

    $('body').on('click', '.close_click_img', function() {
        $('.pending_image').hide();
        $('.accept_image').hide();
        $('.closed_image').show();
        $('.reject_image').hide();
        $('.pending_text').hide();
        $('.accepted_text').hide();
        $('.closed_text').show();
        $('.rejected_text').hide();
        $('.pending_display_none').show();
        $('.arrow_box_purchase_open').css({
            'width': '460px'
        });
    });

    $('body').on('click', '.reject_click_img', function() {
        $('.pending_image').hide();
        $('.accept_image').hide();
        $('.closed_image').hide();
        $('.reject_image').show();
        $('.pending_text').hide();
        $('.accepted_text').hide();
        $('.closed_text').hide();
        $('.rejected_text').show();
        $('.pending_display_none').show();
        $('.arrow_box_purchase_open').css({
            'width': '460px'
        });
    });

    $('body').on('click', '.atta-file-s', function() {
        $(this).parent().remove();
    });

    $('body').on('click', '.bcc_dropdown_box ,tax-dropdown-d, .bcc_dropdown_box .form-group , .bcc_dropdown_box', function(e) {
        e.stopPropagation();
    });

    $('body').on('click', '.ccBc_cancel_d', function() {
        $('.bcc_dropdown_box').hide();
    });

    $('body').on('click', '.cc_bcc_qoutation', function() {
        $('.bcc_dropdown_box').show();
    });

    $(document).on('click', 'body *', function(e) {
        if ($(this).find(".open").is(":visible")) {
            $('.bcc_dropdown_box').hide();
        }
    });

    $('body').on('click', '#qoutation_qbo_content', function(e) {
        e.stopPropagation();
    });
    
    $('body').on('click', '.tax_slide_onclick_credit', function() {
        $('.toggle_tax_main_credit').toggleClass('active');
    });
    
    $('body').on('click', '.tax-dropdown-d', function(e) {
        e.stopPropagation();
    });

    $('body').on('click', '.quo_add_new_d', function() {
        $('.show-add-cus-d').show();
    });
    //get vendor
    $('body').on('click', '.vendor_details_d', function() {
        initilizeNewVendor();
    });
    //by clicking checkbox row highlight
    $('body').on('change', 'input[name="send_later"]', function() {
        if ($(this).is(':checked')) {
            $('#test_quotation_form_d').removeData('validator');
            $('.form-control > email-d').removeClass('error');
            $('.form-control > email-d').removeClass('required');
            validate_form_($('#test_quotation_form_d'), {
                ven_id___: {
                    required: true
                },
                "quotation_no": {
                    number: true
                },
                "rate[]": {
                    number: true
                },
                "qty[]": {
                    number: true
                },
                "amount[]": {
                    number: true
                },
                "discount[]": {
                    number: true
                }
            }, validateEmpty, false, true);
        } else {
            $("#email_d").rules("add", {
                required: true,
                messages: {
                    required: "This field is required.",
                }
            });
        }
    });

    function validateEmpty() {
        return false;
    }
    //delete sale quotation
    $('body').on('click', '#delete-sq-d', function() {
        var sq_no = $('.quotation_no_d').val();
        var delete_id = $('#delete-sq-d').attr('data-sq-id');
        $('.confirm_box_text_d').text("Are you sure you want to delete sale quotation no " + delete_id + " ?");
        $('.show-confirm-model-d').modal('show');
        $('.btn_yes_cross').attr('delete-sq-d', delete_id);
        $('.btn_yes_cross').attr('id', 'confirm_delete_sq_d');
        $('.btn_yes_cross').removeClass('confirm-rec-yes-d');
        $('.btn_yes_cross').removeClass('confirm-yes-d');
        $('.btn_yes_cross').attr('data-attr', '');
    });

    $('body').on('click', '#confirm_delete_sq_d', function() {
        $('#close_confirm_modal').modal('hide');
        var sq_no = $('#confirm_delete_sq_d').attr('delete-sq-d');
        $.ajax({
            type: "POST",
            url: baseUrl + 'delete-sale-quotation',
            data: {
                id: 'no-robot',
                'delete_id': sq_no
            },
            beforeSend: function() {
                $('.load-progress-bar').show();
            },
            success: function(response) {
                if (response.status == 'OK') {
                    $(".success_modal_d").modal('hide');
                    $(".show-success-pop-d").html(response.message);
                    $("#success_modal_d").modal('show');
                    var href = new URL(baseUrl + 'salesquotation');
                    href.toString();
                    history.pushState(null, null, href.toString());
                    loadQuotationPopup(update_id = '', dat_typ = '', quo_id = '');
                    setTimeout(function() {
                        $("#success_modal_d").modal('hide')
                    }, 2000);
                } else if (response.status == 'ERROR') {
                    $(".show_error_message_d").html(response.message);
                    $(".error_caution_box").removeClass("hide-d");
                    return false;
                }
            },
            complete: function(data) {
                $('.load-progress-bar').hide();
            }
        });
    });
    //copy sale quotation showlesss
    $('body').on('click', '#copy-sq-d', function() {
        var copy_id = $('#delete-sq-d').attr('data-sq-id');
        loadQuotationPopup(update_id = copy_id, dat_typ = 'edit', quo_id = '', copy_sq_id = copy_id);
    });
    //
    function sq_status_options()
    {
        //selected estimate text
        var estimate_sele =  $('#estimate_status_d').children("option:selected").text();
        var moduleStatus  = $('#estimate_status_d').children("option:selected").val();
        if(moduleStatus==1)
        {
            $('.pending_image').show();
            $('.pending_display_none').hide();
            $('.pending_text').show();
            $('.accepted_text').hide();
            $('.closed_text').hide();
            $('.rejected_text').hide();
            $('.accept_image').hide();
            $('.closed_image').hide();
            $('.reject_image').hide();   
            $('.accepted_text').hide();
            $('.closed_text').hide();
            $('.rejected_text').hide();   
        } 
        else if(moduleStatus==2)
        {
            $('.accept_image').show();

            $('.accepted_text').show();
            $('.pending_text').hide();
            $('.closed_text').hide();
            $('.rejected_text').hide();



            $('.pending_image').hide();

            $('.pending_display_none').hide(); 
            $('.closed_image').hide();
            $('.reject_image').hide();
            $('.pending_display_none').hide();    
            $('.closed_text').hide();
            $('.rejected_text').hide();
        } 
        else if(moduleStatus==3)
        {
            $('.closed_image').show();
            $('.closed_text').show();

            $('.pending_text').hide();
            $('.accepted_text').hide();
            $('.rejected_text').hide();



            $('.accept_image').hide();
            $('.accepted_text').hide();
            $('.pending_image').hide();
            $('.pending_display_none').hide(); 
            $('.reject_image').hide();
            $('.pending_display_none').hide();   
            $('.rejected_text').hide();
        } 
        else if(moduleStatus==4)
        {
            $('.reject_image').show();
            $('.rejected_text').show();

            $('.pending_text').hide();
            $('.accepted_text').hide();
            $('.closed_text').hide();



            $('.accept_image').hide();
            $('.accepted_text').hide();
            $('.pending_image').hide();
            $('.pending_display_none').hide(); 
            $('.closed_image').hide();
            $('.pending_display_none').hide();    
            $('.closed_text').hide();
        } 
        else
        {
            $('.pending_image').hide();
            $('.pending_display_none').hide(); 
            $('.accept_image').hide();
            $('.accepted_text').hide();
            $('.closed_image').hide();
            $('.closed_text').hide();
            $('.reject_image').hide();    
            $('.rejected_text').hide();
        }
    }

    /**
     * Get updated html template to be converted in PDF in php
     * 
     * old template is already there under #activeTemplateContainer-d
     * we just get it, update its content based on various classes
     * and return updated HTML with updated values
     */
    function getPdfTemplateHtml(shouldGetPDF = true)
    {
        // setup company info (default values in template)
        setupTemplateCompanyInfo(null, '#activeTemplateContainer-d'); // setup company Information

        // setup customer Info
        var customerId = $('.vendor_id-d').val();
        var targetElm = ".get-customer-detail-d[attr-id='" + customerId + "']";
        var customerName = $(targetElm).find('p.search-d').html();
        let addressTextArea = $('#billing_address_d');
        var customerAddress = ($.trim($(addressTextArea).val()) != '' )?  $(addressTextArea).val() : $(addressTextArea).html();
        
        const customerInfo = {
            'name': customerName
            , 'address': customerAddress
        };
        setupTemplateCustomerInfo(customerInfo); // setup Customer Information

        // setup InvoiceMeta Info
        var sequenceNo = $('#sequence_no_d').html();
        var termId = $(".sqo_term-d").val();
        var targetElm = ".child_options_list[attr-id='" + termId + "']";
        var termValue = $('.append_terms_option_d').find(targetElm).find('p.search-d').html();        
        var invoiceDate = $(".date_as_od_std_d[name='quotation_date']").val();
        var expirationDate = $(".date_as_od_std_d[name='expiration_date']").val();
        const metaInfo = {
            'invoiceNature': 'Sales Quotation'
            , 'sequenceNo': sequenceNo
            , 'termValue': termValue
            , 'invoiceDate': invoiceDate
            , 'expirationDate': expirationDate
        };
        setupTemplateInvoiceMetaInfo(metaInfo);

        // setup Invoice Extra Filds like Shipping and Custom info
        var customFieldContainer = $('.crew-attr-d');
            var customTitle1 = $(customFieldContainer).find('label').html();;
            var customValue1 = $(customFieldContainer).find("input[name='custom_field1']").val();
        var customFieldContainer_2 = $('.custom2-attr-d');
            var customTitle2 = $(customFieldContainer_2).find('label').html();
            var customValue2 = $(customFieldContainer_2).find("input[name='custom_field2']").val();
        var customFieldContainer_3 = $('.custom3-attr-d');
            var customTitle3 = $(customFieldContainer_3).find('label').html();
            var customValue3 = $(customFieldContainer_3).find("input[name='custom_field3']").val();
        var customFieldContainer_4 = $('.custom4-attr-d');
            var customTitle4 = $(customFieldContainer_4).find('label').html();
            var customValue4 = $(customFieldContainer_4).find("input[name='custom_field4']").val();
        const extraInfo = {'shipDateTitle': 'Ship Date'
            // , 'shipDate': '10-02-2020'
            // , 'shipVia': 'TCS', 'shipViaTitle': 'Sent By', 'trackingID': 'anj73'
            // , 'trackingIDTitle': 'Tracking No.. .'
            , 'customTitle1': customTitle1
            , 'customValue1': customValue1
            , 'customTitle2': customTitle2
            , 'customValue2': customValue2
            , 'customTitle3': customTitle3
            , 'customValue3': customValue3
            , 'customTitle4': customTitle4
            , 'customValue4': customValue4
        };
        setupTemplateInvoiceExtrasInfo(extraInfo);

        // setup templateGrid from page Grid 
        let gridTableElm = '#quotation_sorting';
        let tableBodyContainer = '.auto-w-s.ui-sortable';
        pageGridInfo = getPageGridInfo(gridTableElm, tableBodyContainer);
        setupTemplateGrid(pageGridInfo); // update template Grid for given Info
        
        // setup Invoice Conclusion
        var currencySymbol = $('.currency_symbol_d').html();
        var subTotalAmount = $('.show_sub_total_d').html();
        let msgTextarea = $("textarea[name='msg_display_client']");
        var messageToReciever = ( $.trim($(msgTextarea).val()) != '' )?  $(msgTextarea).val() : $(msgTextarea).html();   
        var taxAmount = $('.vat_total_d').val();
        var netTotal = $('.show_gtotal_d').html();

        const conclusionInfo = {
            'messageToReciever': messageToReciever
            , 'currencySymbol': currencySymbol
            , 'subTotalAmount': subTotalAmount
            , 'showDiscountInfo': false
            , 'showDepositInfo': false
            , 'taxAmount': taxAmount
            , 'netTotal': netTotal
            // , 'discountedAmount': 0.00
            // , 'depositAmount': 0.00
            // , 'subTotalText': 'Sub-Total-Amount'
            // , 'discountedAmountText': 'Discounted Amount'
            // , 'depositAmountText': 'Deposit Amount'
            // , 'taxAmountText': 'Total TAX Amount'
            // , 'netTotalText': 'Net Total Amount'
            // , 'totalDuetext': 'Total Due'
            // , 'footerText': 'Copyright &copy anbCorp Pvt. Ltd.'
        };
        setupTemplateClosure(conclusionInfo);

        templateString = $('#activeTemplateContainer-d').html();
        // console.log(templateString);
        return templateString;
    }
    
    
    function getPdfTemplateHtml_original(shouldGetPDF = true)
    {
        var templateString = '';
        if(shouldGetPDF){
            var templateContainer = $('#activeTemplateContainer-d');
            
            // company info update
            $(templateContainer).find('.tpl_customer_country_code-d').html(''); // company Country is not set anywhere
            $(templateContainer).find('.tpl_company_city-d').html(''); // company City is not set anywhere
            $(templateContainer).find('.tpl_company_address-d').html(''); // company Address is not set anywhere
            $(templateContainer).find('.tpl_company_reg_num-d').html(''); // company Registreation # is not set anywhere

            // customer Info update
            var customerId = $('.vendor_id-d').val();
            var targetElm = ".get-customer-detail-d[attr-id='" + customerId + "']";
            $(templateContainer).find('.tpl_customer_name-d').html( $(targetElm).find('p.search-d').html() );
            $(templateContainer).find('.tpl_customer_address-d').html( $('#billing_address_d').html() );
            
            $(templateContainer).find('.tpl_customer_country_code-d').html(''); // // Customer CountryCode is not set anywhere
            $(templateContainer).find('.tpl_customer_city-d').html(''); // Customer CityCode is not set anywhere
            $(templateContainer).find('.tpl_customer_vat_reg_num-d').parent().css({'display':'none'}); // Custom VAT Reg# is not set anywhere
            
            $(templateContainer).find('.tpl_template_type-d').html('QUOTATION'); // hard coded text instead of INVOICE
            
            $(templateContainer).find('.tpl_no-d').html( $('#sequence_no_d').html() );
            
            var termId = $(".sqo-terms-d[name='sqo_term']").val();
            targetElm = ".child_options_list[attr-id='" + termId + "']";
            let termValue = $('.append_terms_option_d').find(targetElm).find('p.search-d').html();

            $(templateContainer).find('.tpl_term-d').html( termValue );
            
            // setup dates
            var dt = new Date();
            var dateToday = ('0' + dt.getDate()).slice(-2) + "/" + ('0' + dt.getMonth()+1).slice(-2) + "/" + dt.getFullYear();
            var date_due = $(".date_as_od_std_d[name='quotation_date']").val();
            $(templateContainer).find('.tpl_date-d').html(dateToday);
            $(templateContainer).find('.tpl_due_date-d').html(dateToday);
            
            $(templateContainer).find('.tpl_ship_date-d').html(dateToday); // shipDate is not set anywhere
            $(templateContainer).find('.tpl_ship_via-d').html('FedEx International'); // shipVia is not set anywhere
            $(templateContainer).find('.tpl_track_id-d').html('123456780'); // Track ID is not set anywhere
            
            // setup custom fields and their values
            var customFieldContainer = $('.crew-attr-d');
            customFieldLabel = $(customFieldContainer).find('label').html();
            customFieldValue = $(customFieldContainer).find("input[name='custom_field1']").val();
            $(templateContainer).find('.tpl_custom_field_title_1-d').html(customFieldLabel);
            $(templateContainer).find('.tpl_custom_field_value_1-d').html(customFieldValue);
            
            var customFieldContainer_2 = $('.custom2-attr-d');
            customFieldLabel_2 = $(customFieldContainer_2).find('label').html();
            customFieldValue_2 = $(customFieldContainer_2).find("input[name='custom_field2']").val();
            $(templateContainer).find('.tpl_custom_field_title_2-d').html(customFieldLabel_2);
            $(templateContainer).find('.tpl_custom_field_value_2-d').html(customFieldValue_2);
            
            var customFieldContainer_3 = $('.custom3-attr-d');
            customFieldLabel_3 = $(customFieldContainer_3).find('label').html();
            customFieldValue_3 = $(customFieldContainer_3).find("input[name='custom_field3']").val();
            $(templateContainer).find('.tpl_custom_field_title_3-d').html(customFieldLabel_3);
            $(templateContainer).find('.tpl_custom_field_value_3-d').html(customFieldValue_3);
            
            var customFieldContainer_4 = $('.custom4-attr-d');
            customFieldLabel_4 = $(customFieldContainer_4).find('label').html();
            customFieldValue_4 = $(customFieldContainer_4).find("input[name='custom_field4']").val();
            $(templateContainer).find('.tpl_custom_field_title_4-d').html(customFieldLabel_4);
            $(templateContainer).find('.tpl_custom_field_value_4-d').html(customFieldValue_4);
            
            msgTextarea = $("textarea[name='msg_display_client']");
            customerMessage = ( $.trim($(msgTextarea).val()) != '' )? $(msgTextarea).val() : 'Thank you for shopping with us';
            $(templateContainer).find('.tpl_template_message-d').html( customerMessage );
            
            var currencySymbol = $('.currency_symbol_d').html();
            $('th.tbl-content-amount-d').append(' (' + currencySymbol + ')');
            // deposit value
            $(templateContainer).find('.tpl_deposit-d').parent('.tableRow').css({'display':'none'}); // Deposit Value is not set anywhere
            
            // sub-total amount
            subTotalText = currencySymbol + ' ' + $('.show_gtotal_d.amount_hit_s').html();
            $(templateContainer).find('.tpl_sub_total-d').html(subTotalText);
            
            // tax
            if( ($.trim($('.tax_type_d option:selected').html()) != 'Out of scope of Tax') ){
                var vatAmount = currencySymbol + ' ' + $('.vat_total_d').val();
                $(templateContainer).find('.tpl_total_tax-d').html(vatAmount);
            }
            else{
                $(templateContainer).find('.tpl_total_tax-d').parent('.tableRow').css({'display':'none'});
            }

            // total
            totalAmount = currencySymbol + ' ' + $('.show_gtotal_d').html();
            $(templateContainer).find('.tpl_total-d').html(totalAmount);
            $('.tpl_discount-d').parents('.tableRow').hide();
            $(templateContainer).find('.tpl_total_due-d').html(totalAmount);

            // // handle the grid in both template and page
            // let gridTableElm = '#quotation_sorting';
            // let tableBodyContainer = '.auto-w-s.ui-sortable';
            // pageGridInfo = getPageGridInfo(gridTableElm, tableBodyContainer);
            // setupTemplateGrid(pageGridInfo); // update template Grid for given Info
            
            // $(templateContainer).find('.tpl_discount-d').html(subTotalText);
            
            templateString = templateContainer.html();
        }
        return templateString;
    }
    




});

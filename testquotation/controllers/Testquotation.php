<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//use Pdfinvoicing as Pdf;
class Testquotation extends MY_Controller {

    private $module_id = 7;
    private $moduleName;
    private $countryId=1;
    public function __construct() {
        parent::__construct();
        $this->moduleName = 'sales_quotation';
        $model_list = [
            'home/Comman_model' => 'CommonModel',
            'Test_SalesQuotation_model' => 'SalesQuotationModel',
        ];
        $this->load->model($model_list);
        $this->load->library('pdf');
    }

        public function index() {
        if ($this->session->userdata('user_index_id') != TRUE) {
        redirect('/logout');
        }
        $data['page'] = 'Manage Quotation';
        $data['load_style'] = array('bills_and_payment_popup.css', 'custom_tooltip.css', 'all_sales_product_services.css', 'allsales.css', 'custom-ps.css', 'customer_detail.css', 'progress-styling.css', 'terms.css');
        $data['load_script'] = array('test_sales_quotation.js', 'sale_purchase_common.js', 'test_sales_quotation_generic.js', 'sales_quotation_recuring.js', 'selectize.min.js', 'jQuery.resizableColumns.min.js', 'pservicesintegrate.js', 'new-customer-popup.js', 'save_flag.js', 'term-integrate.js');
        $data['body_class'] = 'hold-transition skin-blue sidebar-mini';
        $data['load_view'] = array('pages/default_load');
        $this->viewloader->backEnd($data);
        }
        public function load_products(){
        $result=$this->SalesQuotationModel->get_all_quotations();
        echo json_encode($result);  
        }
        public function get_data_of_dropdown(){
        $result=$this->SalesQuotationModel->get_all_products_name();
      
        echo json_encode($result);
        }
        public function display_single_record(){
        $data['result']=$this->SalesQuotationModel->get_single_record();
        $data['detail']=$this->SalesQuotationModel->get_detail();
        $data['all_products_name']=$this->SalesQuotationModel->get_all_products_name();
        // print_array($data,true);
        $data['test_quotation_data']=$this->load->view('popup/test-quotation', $data,true);

        echo json_encode($data);
        }
        public function show_products_name_dropdown(){
        $result['product_detail']=$this->SalesQuotationModel->get_single_products_name();
        echo json_encode($result);
        }
        public function delete_single_quotation(){
        $data['result']=$this->SalesQuotationModel->delete_quotation();
        echo json_encode($data);
        }

        public function print_document($id){
            

$result_store='<h4 align="center"> Test Quotation</h4>';
$result_store.=$this->SalesQuotationModel->generate_pdf($id);
$this->pdf->loadHtml($result_store);
$this->pdf->render();
$this->pdf->stream("Quotation.pdf" , array("Attachment"=>0));
            // echo json_encode($result);
        }

public function generate_pdf_quot(){
  $id=$this->input->get('id');
    $sales_quotation_data=$this->SalesQuotationModel->generate_pdf_f($id);
    if($sales_quotation_data){
        $sum=0;
        $subtotal=0;
        $discount=0;
        $tax=0;
        foreach($sales_quotation_data as $total){
           $sum+=$total['amount'];
           $subtotal+=$total['rate'] * $total['qty'];
            $discount+=$total['discount'];
            $tax+=$total['qty'] * $total['rate'] * $total['tax']/100;
        }
        //print_array($subtotal,true);
          $sales_product_info = array();
          foreach($sales_quotation_data as $res){
        $product_info=array(
            'date'=>$res['created_at'],
            'rate'=>$res['rate'],
            'name'=>$res['name'],
            'quantity'=>$res['qty'],
            'amount'=>$res['amount'],
            'description'=>$res['description'],
            'sku'=>'Sku 10',
        );
      array_push($sales_product_info, $product_info);

    }


$sales_quotation_info = array(
        'serial_no' => $sales_quotation_data[0]['quotation_index_id'],
        'voucher_date' => $sales_quotation_data[0]['quo_date'],
        'expiry_date' => $sales_quotation_data[0]['exp_date'],
        'terms' => $sales_quotation_data[0]['terms'],
        'contact_info' => array(
        'email' => $sales_quotation_data[0]['email'],
        'email_cc' => 'cuscc@gmail.com',
        'email_bcc' => 'cusbcc@gmail.com'
        ),
        'display_msg' => $sales_quotation_data[0]['msg_client'],
        'memo' => $sales_quotation_data[0]['memo'],
        'billing_address' => $sales_quotation_data[0]['billing_address'],
        'shipping_date' => $sales_quotation_data[0]['quo_date'],
        'ship_via' => $sales_quotation_data[0]['ship_via'],
        'tracking_no' =>'45',
        'custom_fields' => array(
        'custom_field1','custom_field2','custom_field3','custom_field4',
        
        ),
        'product_info' => $sales_product_info,
        'discount' => $discount,
        'tax' => $tax,
        'sub_total' => $subtotal,
        'deposit' => '34',
        'total' => $sum,
        'total_due' => '84392',
        'currency_symbol' => 'pkr',
       
    );





    $company_info=array(
    'name' => 'Bright LCSS',
    'email' => 'spiro@leadconcept.com',
    'phone' => '+961 (1) 455 266',
    'fax' => '+961 (1) 526 323',
    'website' => 'www.octobite.com',
    'address' => 'Al Mustaqbla Building 5th Floor',
    'city' => 'Ashrafieh Sq. Beirut',
    'tax_type' => 'No',
    'code' => '04040411',
    'reg_no' => '16254'

        );
       
       $customer_info = array(
            'salutaion' => array(
                'title' => '',
                'first_name' => '',
                'middle_name' => '',
                'last_name' => '',
                'dispaly_name' => ''
            ),
            'contact_info' => array(
                'phone' => '',
                'mobile' => '',
                'email' => '',
                'fax' => '',
                'website' => '',
            ),
            'billing_info' => array(
                'address' => '',
                'city_town' => '',
                'state' => '',
                'zip_code' => '',
                'country' => ''
            ),
            'shipping_info' => array(
                'address' => '',
                'city_town' => '',
                'state' => '',
                'zip_code' => '',
                'country' => ''
            ),
            'vat_no' => ''
        );
        $selected_template_id='SU53bUlSMGJjcGZDbCt5SmNNeXBpUT09';
        $last_id=$id;
       // print_array($sales_quotation_info,true);
         $file_name = modules::run('pdfinvoicing/pdfinvoicing/index',encrypt_decrypt($selected_template_id, 'd'), $last_id,'sales_quotation',$sales_quotation_info,$company_info,$customer_info);
         // print_array($file_name);
        $data['printPreviewFileUrl'] = $file_name; 
        $data['trxId'] = $last_id;   
        $file_name;      
         $message = 'Sales Quotaion Updated successfully'; 
         logGenerate('SALESQUOTATION', array($message), $message);
        throughOutputJSON(1, $message, $data);
      
    }

   
}
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

}


public function save_test_form(){
 $id=$this->input->post('quotation_index_id');
 $p_quotation_id=$this->input->post('p_quotation_id');
$this->form_validation->set_rules('cus_name','Customer Name','trim|required');
$this->form_validation->set_rules('email','Customer Email ');
$this->form_validation->set_rules('quo_date','Quotation Date Detail');
$this->form_validation->set_rules('exp_date','Exp Date');
$this->form_validation->set_rules('billing_address','Exp Date');
$this->form_validation->set_rules('shipping_fee','Exp Date');
$this->form_validation->set_rules('shipping_address','Exp Date');
$this->form_validation->set_rules('ship_via','Exp Date');
$this->form_validation->set_rules('quo_currency','Exp Date');
$this->form_validation->set_rules('discount_type','Exp Date');
$this->form_validation->set_rules('terms','Exp Date');
$this->form_validation->set_rules('setting','Exp Date');
$this->form_validation->set_rules('custom_2','Exp Date');
$this->form_validation->set_rules('tax_type','Exp Date');
$this->form_validation->set_rules('msg_client','Exp Date');
$this->form_validation->set_rules('memo','Exp Date');
$this->form_validation->set_rules('email_cc','Exp Date');
$this->form_validation->set_rules('email_bcc','Exp Date');

////////////////////////////////////////////////////////////////////////
$this->form_validation->set_rules('description[]','Exp Date');
$this->form_validation->set_rules('product__id_[]','Exp Date');
$this->form_validation->set_rules('rate[]','Exp Date');
$this->form_validation->set_rules('tax[]','Exp Date');
$this->form_validation->set_rules('amount[]','Exp Date');
$this->form_validation->set_rules('qty[]','Exp Date');
$this->form_validation->set_rules('p_quotation_id[]','Exp Date');
$this->form_validation->set_rules('pservices_index_id[]','Exp Date');
if($this->form_validation->run()){
        $data['cus_name']=$this->input->post('cus_name');
        $data['email']=$this->input->post('email');
        $data['quo_date']=$this->input->post('quo_date');
        $data['exp_date']=$this->input->post('exp_date');
        $data['billing_address']=$this->input->post('billing_address');
        $data['shipping_address']=$this->input->post('shipping_address');
        $data['shipping_fee']=$this->input->post('shipping_fee');
        $data['ship_via']=$this->input->post('ship_via');
        $data['quo_currency']=$this->input->post('quo_currency');
        $data['discount_type']=$this->input->post('discount_type');
        $data['terms']=$this->input->post('terms');
        $data['setting']=$this->input->post('setting');
        $data['custom_2']=$this->input->post('custom_2');
        $data['terms']=$this->input->post('terms');
        $data['tax_type']=$this->input->post('tax_type');
        $data['msg_client']=$this->input->post('msg_client');
        $data['memo']=$this->input->post('memo');
       if(!is_null($id) && $this->SalesQuotationModel->id_exists($id)){
       $get_last_insert_id=$this->SalesQuotationModel->update_record_quotation($id, $data);
       }
       else{
            $get_last_insert_id=$this->SalesQuotationModel->save_quotation($data);
        }


 if($get_last_insert_id){
    if(isset($_FILES['upload_Files']['name'])){
          $filesCount = count($_FILES['upload_Files']['name']);
              for($i = 0; $i < $filesCount; $i++){
                $_FILES['upload_File']['name'] = $_FILES['upload_Files']['name'][$i];
                $_FILES['upload_File']['type'] = $_FILES['upload_Files']['type'][$i];
                $_FILES['upload_File']['tmp_name'] = $_FILES['upload_Files']['tmp_name'][$i];
                $_FILES['upload_File']['error'] = $_FILES['upload_Files']['error'][$i];
                $_FILES['upload_File']['size'] = $_FILES['upload_Files']['size'][$i];
                $uploadPath = 'uploads/attachments/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png';                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('upload_File')){
                    $fileData = $this->upload->data();
                    $uploadData[$i]['upload_Files'] = $fileData['file_name'];
                    $uploadData[$i]['test_quotation_no'] =$get_last_insert_id;
                    $uploadData[$i]['created_at'] = date("Y-m-d");
                }
              }           
          
              if(!empty($uploadData)){
                            if(!is_null($get_last_insert_id) && $this->SalesQuotationModel
                            ->id_exists_files($get_last_insert_id)){
                            for($i=0; $i<count($_FILES['upload_Files']['name']);$i++){
                            $batch=array('upload_Files'=>$_FILES['upload_Files']['name'][$i],
                            'created_at'=>date("Y-m-d"),
                            'test_quotation_no'=>$get_last_insert_id);
                            $result=$this->db->update('test_attachment', $batch, array('test_quotation_no'=>$get_last_insert_id) );
                            }
                            }else{
                            $insert = $this->SalesQuotationModel->insertimages($uploadData);
                            }

                }

  }}
        if($get_last_insert_id){
            $p_quotation_id=$this->input->post('p_quotation_id[]');
            $description=$this->input->post('description[]');
            $rate=$this->input->post('rate[]');
            $tax=$this->input->post('tax[]');
            $qty=$this->input->post('qty[]');
            $product__id_=$this->input->post('product__id_[]');
            $amount=$this->input->post('amount[]');
            $pservices_index_id=$this->input->post('pservices_index_id[]');
            $pro_id=$get_last_insert_id;
                for ($i=0; $i < count($description); $i++){ 
                    $orders[] = array( 
                    'description' => $description[$i],
                    'rate' => $rate[$i],
                    'tax' => $tax[$i],
                    'qty' => $qty[$i],
                    'amount' => $amount[$i],
                    'product__id_' => $product__id_[$i],
                    'pservices_index_id'=>$pservices_index_id[$i],
                    'test_quotation_id' => $get_last_insert_id
                    );
                } 
 

            if(!is_null($id) && $this->SalesQuotationModel->id_exists_quo($id)){
                for($i=0; $i<count($description);$i++){
                    $batch=array(
                    'description' => $description[$i],
                    'rate' => $rate[$i],
                    'tax' => $tax[$i],
                    'qty' => $qty[$i],
                    'product__id_' => $product__id_[$i],
                    'amount' => $amount[$i],
                     'pservices_index_id'=>$pservices_index_id[$i],
                    'p_quotation_id' => $p_quotation_id[$i]

                    );
                  
                    $this->db->where('p_quotation_id',$p_quotation_id[$i]);
                    $get_last_insert_id_quo=$this->db->update('test_quotation_product',$batch);
                }
            }else{
            $get_last_insert_id_quo=$this->SalesQuotationModel->add_quotation_pro($orders);
            }
        }

        $this->session->set_flashdata('insert',' Quotation Created successfully');
        redirect('Testquotation/index');
    }
        else{
        echo "sorry please fill all the fields";
        }
}


public function send_email(){
   if ($this->input->is_ajax_request() && get_current_user_id() && get_current_user_id() == $this->session->userdata('user_index_id')) 
        {
  $postedData = $this->input->post();
 // print_array($postedData,true);

          
    $account_setting = $this->CommonModel->get('account_setting_sales_messages',array('company_id'=>$this->session->userdata('company_id')));
            $account_setting = $account_setting[0];
            $use_setting = isset($account_setting['heading_name']) && !empty($account_setting['heading_name']) ? $account_setting['heading_name'] : intval(0);
            $email_heading_dear = isset($account_setting['heading_dear']) && !empty($account_setting['heading_dear']) ? $account_setting['heading_dear'] : intval(0);

            if($email_heading_dear == 1){
            $email_heading_dear = 'Dear';
            }elseif($email_heading_dear == 2){
            $email_heading_dear = 'To';
            }else{
            $email_heading_dear = '';
            }
            $email_greetings_name = '';
            $allNames = array(
                    '1'=>'[First][Last]',
                    '2'=>'[Title][Last]',
                    '3'=>'[First]',
                    '4'=>'[Full Name]',
                    '5'=>'[Compnay name]',
                    '6'=>'[Display name]'
            );

            foreach ($allNames as $key => $list) 
            {
                if($use_setting == $key)
                {
                    $email_greetings_name = $list;
                    
                }
            }
            $postedData=array(
                'message'=>'Hello Sir',
                'subject'=>'Email message body',
                'trx_id'=>$postedData['trx_id'],
                'email'=>$postedData['email'],
                'emailcc'=>$postedData['email'],
                'emailbcc'=>$postedData['email_bcc'],
                'attachment_url'=>'https://storage.googleapis.com/spiro-365-file-storage/public/frontend/pdfFiles/1/sales_quotation-103.pdf'

            );


             if(!empty($email_heading_dear) && !empty($email_greetings_name)){
                $email_greetings_name = $email_heading_dear.' '.$email_greetings_name;
                $test = str_replace($email_greetings_name,'',$postedData['message']);
                $postedData['message'] = $test;
            }
            $trxId = $this->input->post('quotation_index_id');
            $entries = $this->SalesQuotationModel->getTransactionEntries($trxId);
            $basicInfo = $this->SalesQuotationModel->getBasicTransactionInfo($trxId);
              $dbData = ['basicInfo' => $basicInfo, 'entries' => $entries];
                $extraInfo = ['moduleName' =>'sales_quotation', 'invoiceNature' => 'Sales Quotation'];
                $this->load->helper('template_scrapper_helper'); // email template scrapper
            $templates = getDbTemplates(); // get templates from db

             

            $updatedHTML = updatePredefinedTemplateHTML($templates['emailTemplateHTML'], $postedData, $dbData, $extraInfo);
            //print_array($updatedHTML,true);   
            //exit();
            // validate email field
                           
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            if ($this->form_validation->run() == true) {
                // determine a few email properties
                $from['name'] = $basicInfo['companyName'];
                $from['email'] = $basicInfo['companyEmail'];
                $moduleName = $this->moduleName;

                 $urlArray = explode('/', $postedData['attachment_url']);

                 $attachmentName = end($urlArray);
                // save email log in db and send it to given email address

               //print_array($urlArray,true);

                $this->load->helper('email_helper');
                
                sendEmailToUsers(
                          $postedData['email']
                        , $postedData['subject']
                        , $updatedHTML
                        , $moduleName
                        , $postedData['attachment_url']
                        , $attachmentName
                        , null
                        , $from
                        , $postedData['emailcc']
                        , $postedData['emailbcc']

                );

            } else {
                throughOutputJSON(0, 'Customer Email not found!', $this->form_validation->error_array());
            }

        }


}




    public function loadQuotationPopup() {
     
        if ($this->input->is_ajax_request() && get_current_user_id() && get_current_user_id() == $this->session->userdata('user_index_id') //&& get_module_permissions(7)['can_view'] == '1'
        ) 
        {
            $company_id = $this->session->userdata('company_id');
            $branch_id  = $this->session->userdata('branch_id');
            $data['getSiSettings'] = $this->CommonModel->get('sales_qo_settings', array('company_id' => $company_id));
            if(empty($data['getSiSettings']))
            {
                $data['getSiSettings'] = $this->setFieldSetting();
            }
            $data['getTerms'] = $this->CommonModel->get('term', array('status' => 1,'company_id' => $company_id));
            
            $company_check = array(
                'company_id' => $company_id
            );
            $data['get__quotation_no_']=$this->SalesQuotationModel->count_q_rows();
            // print_array($ress,true);
            $data['all_products_name']=$this->SalesQuotationModel->get_all_products_name();
            $data['getTaxType'] = $this->CommonModel->get('tax_type');
            $data['tax_type'] = $this->CommonModel->get('tax_type', false, '*', false, false, 'arrangeOrder');
            $data['listCustomer'] = $this->CommonModel->get('customer', $company_check, '*', false, array('dispaly_name' => 'ASC', 'company' => 'ASC'));
            $email_setting = $this->CommonModel->get('cfs_settings' ,array('company_id' => $company_id)
                , 'email_head_settings' // fields
                , 1 // limit
                , array('created_at' => 'DESC') // orderBy clause
            );
            $data['email_setting'] = json_decode($email_setting[0]['email_head_settings'],true);

            if (isset($_POST['update_id']) && !empty($_POST['dat_typ']) || !empty($_POST['quo_id'])) {
                if (isset($_POST['quo_id']) && !empty($_POST['quo_id'])) {
                    $_POST['update_id'] = $_POST['quo_id'];
                }

                $data['listQuotationUpdate'] = $this->SalesQuotationModel->quotation_sum($_POST['update_id']);
                $data['listQuotationUpdate'] = $this->SalesQuotationModel->quotation_sum($_POST['update_id']);
                if ($data['listQuotationUpdate'][0]['ref_id'] && !empty($data['listQuotationUpdate'][0]['ref_id'])) {
                    $ref_id = $data['listQuotationUpdate'][0]['ref_id'];
                    $data['linked_invoice'] = $this->CommonModel->get('so_head', array('so_index_id' => $ref_id));
                }
                $data['listQuotationTableData'] = $this->CommonModel->join1('sales_quotation', 'sales_quotation_product_detail', 'sales_quotation_index_id', 'sales_quotation_index_id', 'left', '*', array('sales_quotation.sales_quotation_index_id' => $_POST['update_id']), false, false, false, false, array('sales_quotation_product_detail.sequence_no' => 'sequence_no'));
                $data['attachements'] = $this->CommonModel->join1('sales_quotation', 'sales_quotation_attachment', 'sales_quotation_index_id', 'sales_quotation_index_id', 'left', '*', array('sales_quotation.sales_quotation_index_id' => $_POST['update_id']));
                $data['update_id'] = $_POST['update_id'];

                // determine if its a copy of existing salesquotation 
                if (isset($_POST['copy_sq_id']) && !empty($_POST['copy_sq_id'])) {
                    $data['copy_sq_id'] = $_POST['copy_sq_id'];
                    $data['listQuotationTableData'][0]['estimate_status'] = 1;
                    $data['linked_invoice'] = null;
                    $data['invoiceId'] = null;
                } else {
                    $data['copy_sq_id'] = '';
                }
            }
            $data['favourites'] = $this->CommonModel->get('favourites', array('company_id' => $company_id, 'module_id' => 1));
            $data['product_details'] = $this->CommonModel->join1('ps_product_services', 'ps_category', 'category_id', 'category_index_id', 'left', 'ps_product_services.name as ps_name,ps_product_services.pservices_index_id as ps_id,ps_category.name as cat_name', array('ps_product_services.is_active' => 1,'ps_product_services.company_id'=>$company_id));
            $data['quotationsRows'] = (isset($data['listQuotationTableData']) && !empty($data['listQuotationTableData']) && count($data['listQuotationTableData']) > 2) ? count($data['listQuotationTableData']) : 2;
            $data['quotation_no'] = $this->CommonModel->getMax('sales_quotation', false, 'sales_quotation_index_id');
            $data['currency'] = $this->CommonModel->join2('currency', 'currency_details', 'currency_default', 'currency.currency_index_id', 'currency_details.currency_index_id', 'currency.currency_default_index_id', 'currency_default.currency_default_index_id', 'INNER', 'INNER', '*', array('currency.company_id' => $company_id, 'currency.status' => 1, 'currency_details.currency_status' => 1));
            $data['recentQuotation'] = $this->SalesQuotationModel->quotation_sum();
            $data['vat_profile'] = $this->CommonModel->vat_profile(1);
            $data['currency_default_id'] = get_the_dafault_currency();
            // print_array($data['currency_default_id'],true);
            $where =  array("company_id" => $company_id,'country_id'=>$this->countryId , 'is_sale_purchase'=>1 ,'is_active'=>1,'effective_date_start <='=> date('Y-m-d') );
            $defaultVatRate = $this->CommonModel->join1('vat_rates', 'vat_rate_history', 'vat_rates_index_id', 'vat_rate_id', 'left', '*', $where,false,false,false,false,array('effective_date_start' => 'DESC'));
            // print_array($data['vat_profile'],true);
            if(isset($defaultVatRate[0]['sale_purchase_rate']) && !empty($defaultVatRate[0]['sale_purchase_rate']))
            {
                $data['defaultVatRate'] = $defaultVatRate[0];
            }else{
                $data['defaultVatRate'] = '';
            }    
            // print_array($data['defaultVatRate'],true);

            $where =  array("company_id" => $company_id,'country_id'=>$this->countryId,'is_active'=>1, 'is_sale_purchase'=>1 );
            $vatRates = $this->CommonModel->join1('vat_rates' , 'vat_rate_history' , 'vat_rates_index_id' , 'vat_rate_id' , 'LEFT' , "*" , $where,false,false,false,false,array('effective_date_start' => 'DESC'));
            if(isset($vatRates[0]) && !empty($vatRates[0])){
                // unset($vatRates[0]);
                $data['vatRates'] = $vatRates;
            }else{
                $data['vatRates'] = '';
            }
            
            // print_array($vatRates,true);
            //Help Sign Data
            $data['module_id'] = $this->module_id;

            $data['rec_data'] = $this->loadRecurQuotationPopup();
            //Muneeb Added
            $module_flag = $this->CommonModel->get('form_setting', array(
                'module_name' => 'sales',
                'user_id' => get_current_user_id() ? get_current_user_id() : $this->session->userdata('user_index_id')
            ));
            if ($module_flag) {
                $data['module_flag'] = $module_flag[0]['save_flag'];
            } else {
                $data['module_flag'] = 2;
            }
            // print_array($data['listQuotationUpdate'][0],true);
            // load Exchagne rates for notable currencies
            $data['active_exchange_rate'] = getAllExchRate($company_id);
            // print_r($data['module_flag']);
            // die();
            // load quotation template html from db
            $formType = 'quotation';
            $formTemplates = getEncryptedFormTemplatesByType($formType);
            // print_array($formTemplates,true);
            $data['templates'] = $formTemplates;
            $data['templateHtmlObj'] = (false != $formTemplates) ? $formTemplates[0] : null;

            // print_array($data['templates'][1], true);
            $data['document_no'] = getDocumentNumber('sales_quotation', 'document_no');
            //echo"<pre>";print_r($data['document_no']);exit;
            $data['quotation_popup_html'] = $this->load->view('popup/test-quotation', $data, true);
            throughOutputJSON(1, 'Loaded...', $data);
        } else {
            exit('No direct script access allowed');
        }
          
    }

    //customize field
    public function customizeFieldSq() {
        if ($this->input->is_ajax_request() && get_current_user_id() && get_current_user_id() == $this->session->userdata('user_index_id')) {
            $company_id = $this->session->userdata('company_id');
            $data['getQoSettings'] = $this->CommonModel->get('sales_qo_settings', array('company_id' => $company_id));
            $data['customize'] = $this->load->view('popup/customize-sq', $data, true);
            throughOutputJSON(1, 'Loaded...', $data['customize']);
        }
    }
    public function setFieldSetting()
    {
        $company_id = $this->session->userdata('company_id');
        $branch_id  = $this->session->userdata('branch_id');
        $SaveArray  = array(
            'company_id' => $company_id, 
            'branch_id' => $branch_id, 
            'currency' => intval(1),
            'discounttype' => intval(0), 
            'sq_number' => intval(0), 
            'terms' => intval(1), 
            'sku' => intval(0), 
            'shipping_fee' => intval(1), 
        );
        $this->CommonModel->save('sales_qo_settings',$SaveArray);
        return $this->CommonModel->get('sales_qo_settings', array('company_id' => $company_id));
    }
    //so settings save/update
    public function sqSettings() {
        if ($this->input->is_ajax_request() && get_current_user_id() && get_current_user_id() == $this->session->userdata('user_index_id')) {
            //print_array($_POST);exit; 
            $company_id = $this->session->userdata('company_id');
            $branch_id  = $this->session->userdata('branch_id');
            if ($_POST['column_name'] == "currency" || $_POST['column_name'] == "sq_number" || $_POST['column_name'] == "discounttype" || $_POST['column_name'] == "terms") {
                $qoSettings = array($_POST['column_name'] => $_POST['field_active'], 'updated_at' => date('Y-m-d H:i:s'));
               
            }
            if ($_POST['column_name'] == "crew") {
                $crew = isset($_POST['field']) && $_POST['field'] ? $_POST['field'] : '';
                $qoSettings = array('crew' => $_POST['field_active'], 'crew_field' => $crew, 'updated_at' => date('Y-m-d H:i:s'));
            }
            if ($_POST['column_name'] == "custom_field") {
                $custom1 = isset($_POST['field']) && $_POST['field'] ? $_POST['field'] : '';
                $qoSettings = array('custom' => $_POST['field_active'], 'custom_field' => $custom1, 'updated_at' => date('Y-m-d H:i:s'));
            }
            if ($_POST['column_name'] == "custom2") {
                $custom2 = isset($_POST['field']) && $_POST['field'] ? $_POST['field'] : '';
                $qoSettings = array('custom_2' => $_POST['field_active'], 'custom_field_2' => $custom2, 'updated_at' => date('Y-m-d H:i:s'));
            }
            if ($_POST['column_name'] == "custom3") {
                $custom3 = isset($_POST['field']) && $_POST['field'] ? $_POST['field'] : '';
                $qoSettings = array('custom_3' => $_POST['field_active'], 'custom_field_3' => $custom3, 'updated_at' => date('Y-m-d H:i:s'));
            }
            if ($_POST['column_name'] == "custom4") {
                $custom4 = isset($_POST['field']) && $_POST['field'] ? $_POST['field'] : '';
                $qoSettings = array('custom_4' => $_POST['field_active'], 'custom_field_4' => $custom4, 'updated_at' => date('Y-m-d H:i:s'));
            }
            if ($_POST['column_name'] == "shipping_fee") {
                $shipping_fee = isset($_POST['field_active']) && $_POST['field_active'] ? $_POST['field_active'] : '';
                $qoSettings = array('shipping_fee' => $_POST['field_active'], 'shipping_fee' => $shipping_fee, 'updated_at' => date('Y-m-d H:i:s'));
            }
            if ($_POST['column_name'] == "sku") {
                $sku = isset($_POST['field_active']) && $_POST['field_active'] ? $_POST['field_active'] : '0';
                $qoSettings = array('sku' => $sku, 'updated_at' => date('Y-m-d H:i:s'));
            }

            //echo"<pre>";print_r($qoSettings);exit;
            
            $where = array('company_id' => $company_id);
            $update = $this->CommonModel->update('sales_qo_settings', $where, $qoSettings);
            // print_array($company_id);
        } else {
            exit('No direct script access allowed');
        }
    }

    function emailAttachImages($img) {
        for ($i = 0; $i < count($img); $i++) {
            $image[] = array(
                'attach_imges' => $img[$i],
            );
        }
        return $image;
    }

    public function SaveQuotation() {
        // echo"<pre>";print_r($_POST);exit;
        if ($this->input->is_ajax_request() && get_current_user_id() && get_current_user_id() == $this->session->userdata('user_index_id')) {
            //$userBranches = get_branch_permissions($this->session->userdata('user_index_id'));
            $company_id = $this->session->userdata('company_id');
            $branch_id  = $this->session->userdata('branch_id');
            $quo_date   = $this->input->post('quotation_date');
            $expri_date = $this->input->post('expiration_date');
            $invoiceId  = $this->input->post('invoiceId');

            $checkquarter = manageQuarterLocking($quo_date);
            if ($checkquarter != 'unlock' || empty($checkquarter)) {
                throughOutputJSON(0, 'Changes are not allowed quarter is locked!', false);
            }
            if (isset($invoiceId) && !empty($invoiceId)) {
                throughOutputJSON(0, 'This Quotation is linked and can not be updated!', false);
            }
            checkExpirationDate($expri_date,$quo_date,'quotation');
            // if(!empty($expri_date) && !empty($quo_date))
            // {    
            //  if($expri_date < $quo_date)
            //  {
            //      throughOutputJSON(0,'Expiration date could not be less than quotation date!',false);
            //  }
            // }
            $product_id = array_filter($_POST['product_id']);
            if (empty($product_id)) {
                throughOutputJSON(0, 'Please enter at least one line item!', false);
            }
            $this->form_validation->set_rules('vendor_id[]', 'Customer', 'trim|required');
            //$this->form_validation->set_rules('email', 'Email', 'trim|required');

            $copy_sale_quotation = $this->input->post('copy_sale_quotation');
            if (isset($copy_sale_quotation) && !empty($copy_sale_quotation)) {
                $update_id = '';
            } else {
                $update_id = $this->input->post('update_id');
            }
            $save_type = $this->input->post('save_type');
            $save_type = (!empty($save_type) ? $save_type : '');
            $tablecount = 0;
            $quotation_no = 0;
            if ($this->form_validation->run() == true) {
                if (!empty($this->input->post('quotation_no'))) {
                    $quotation_no = $this->input->post('quotation_no');
                } else {
                    $quotation = $this->CommonModel->getMax('sales_quotation', false, 'quotation_no');
                    $quotation_no = ((int) $quotation[0]['quotation_no'] + 1);
                }
                if (!empty($this->input->post('quotation_date'))) {
                    $quotation = str_replace('/', '-', $this->input->post('quotation_date'));
                    $quotation_date = date("Y-m-d", strtotime($quotation));
                } else {
                    $quotation_date = "";
                }
                if (!empty($this->input->post('expiration_date'))) {
                    $expiration = str_replace('/', '-', $this->input->post('expiration_date'));
                    $expiration_date = date("Y-m-d", strtotime($expiration));
                } else {
                    $expiration_date = "1970-01-01 00:00:00";
                }
                $quotation_no = (!empty($quotation_no) ? $quotation_no : 1);
                $quotation_status = $this->input->post('quotation_status');
                $customer_id = $this->input->post('vendor_id');
                $term_id = $this->input->post('sqo_term');
                if (!empty($term_id)) {
                    $term_id = $term_id[0];
                } else {
                    $term_id = 0;
                }
                //subtotal discount
                $discount_type = $this->input->post('sales_discount');
                $sales_discount_val = $this->input->post('sales_discount_val');
                $total = $this->input->post('total');
                if ($discount_type == 1 && $total > 0 && $sales_discount_val > 0) {
                    $subtotal_discount = ($total * $sales_discount_val) / 100;
                } else if ($discount_type == 2 && $total > 0 && $sales_discount_val > 0) {
                    $subtotal_discount = ($total - $sales_discount_val);
                } else {
                    $subtotal_discount = 0;
                }
                $checkUpdatedRow = [];
                if ($update_id) {
                    $dataId = $this->CommonModel->get('sales_quotation_product_detail', array('sales_quotation_index_id' => $update_id), 'quotation_product_index_id');
                    if (!empty($dataId)) {
                        foreach ($dataId as $quo) {
                            $checkUpdatedRow[$quo['quotation_product_index_id']] = $quo['quotation_product_index_id'];
                        }
                    }
                }
                // $transactionType = $this->input->post('transaction_type');
                // if (isset($transactionType) && $transactionType > 0) {
                //     $transactionType = 1;
                // } else {
                    $transactionType = intval(0);
                //}
                $document_no = getDocumentNumber('sales_quotation', 'document_no');
                $QuotationData = array(
                    'customer_id' => $customer_id[0],
                    'company_id' => $company_id,
                    'branch_id' => $branch_id,
                    'document_no' => $document_no,
                    'currency_default_index_id' => $this->input->post('currency_id'),
                    'usd_exchange_rate' => floatval($this->input->post('usd_exchange_rate')),
                    'euro_exchange_rate' => floatval($this->input->post('euro_exchange_rate')),
                    'lbp_exchange_rate' => floatval($this->input->post('lbp_exchange_rate')),
                    'selected_exchange_rate' => floatval($this->input->post('selected_exchange_rate')),
                    'quotation_status' => 1,
                    'estimate_status' => $this->input->post('estimate_status'),
                    'estimate_by' => $this->input->post('estimate_by'),
                    'estimate_date' => $this->input->post('estimate_date'),
                    'email' => $this->input->post('email'),
                    'email_cc' => $this->input->post('email_cc'),
                    'email_bcc' => $this->input->post('email_bcc'),
                    'send_later' => $this->input->post('send_later'),
                    'online_payment' => $this->input->post('online_payment'),
                    'billing_address' => $this->input->post('billing_address'),
                    'quotation_date' => $quotation_date,
                    'expiration_date' => $expiration_date,
                    'quotation_no' => isset($quotation_no) ? intval($quotation_no) : intval(0),
                    'crew' => $this->input->post('crew'),
                    'msg_display_client' => $this->input->post('msg_display_client'),
                    'memo' => $this->input->post('memo'),
                    'tax_type' => $this->input->post('tax_type'),
                    'discount_inline_total' => floatval($this->input->post('discount_inline_total')),
                    'sales_tax_rate' => $this->input->post('sales_tax_rate'),
                    'sales_discount' => $this->input->post('sales_discount'),
                    'sales_discount_val' => floatval($sales_discount_val),
                    'subtotal_discount' => $subtotal_discount,
                    'custom_shipping_address' => $this->input->post('custom_shipping_address'),
                    'custom_ship_via' => $this->input->post('custom_ship_via'),
                    'custom_field1' => $this->input->post('custom_field1'),
                    'custom_field2' => $this->input->post('custom_field2'),
                    'custom_field3' => $this->input->post('custom_field3'),
                    'custom_field4' => $this->input->post('custom_field4'),
                    'shipping_fee' => floatval($this->input->post('shipping_fee')),
                    'transaction_type' => $transactionType,
                    'term_id' => $term_id,
                    'created_by' => $this->session->userdata('user_index_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                // echo"<pre>";print_r($QuotationData);exit;
                if (isset($update_id) && !empty($update_id)) {
                    unset($QuotationData['document_no']);
                    unset($QuotationData['created_at']);
                    $where = array('branch_id' => $branch_id,'company_id'=>$company_id, 'sales_quotation_index_id' => $update_id);
                    $this->CommonModel->update('sales_quotation', $where, $QuotationData);
                } else {
                    unset($QuotationData['updated_at']);
                    $Save = $this->CommonModel->save('sales_quotation', $QuotationData);
                    // echo $this->db->last_query();
                    // die();
                    $lastInsertedId = $Save['last_id'];
                }
                // echo $lastInsertedId;exit;  sales_quotation_product_detail
                if (!empty($lastInsertedId) || isset($update_id)) {
                    $lastInsertedId = (!empty($lastInsertedId) ? $lastInsertedId : '');
                    $quotation_status = $this->input->post('quotation_status');
                    for ($i = 0; $i < count($_POST['product_id']); $i++) {
                        $update_table_ids = (!empty($_POST['update_table_id'][$i]) ? $_POST['update_table_id'][$i] : '');
                        $attached_files = (!empty($_POST['attached_file'][$i]) ? $_POST['attached_file'][$i] : '');
                        $actual_file_names = (!empty($_POST['actual_file_name'][$i]) ? $_POST['actual_file_name'][$i] : '');
                        $data_tax_type = (!empty($_POST['data_tax_type'][$i]) ? $_POST['data_tax_type'][$i] : '');
                        if (empty($_POST['product_id'][$i]) || empty($_POST['qty'][$i])) {
                            continue;
                        }
                        $quotationTableData[] = array(
                            'product_id' => $_POST['product_id'][$i],
                            'update_table_id' => $update_table_ids,
                            'description' => $_POST['description'][$i],
                            'sku' => $_POST['sku'][$i],
                            'qty' => $_POST['qty'][$i],
                            'rate' => $_POST['rate'][$i],
                            'default_rate' => $_POST['default_rate'][$i],
                            'discount' => $_POST['discount'][$i],
                            'inline_discount_type' => $_POST['inline_discount_type'][$i] == 'Select type' ? 0 : $_POST['inline_discount_type'][$i],
                            'discount' => $_POST['discount'][$i],
                            'tax' => $_POST['tax'][$i],
                            'amount' => $_POST['amount'][$i],
                            'istax' => $_POST['istax'][$i],
                            'sq_data_type' => $_POST['data_tax_type'][$i],
                            'vat_rates_index_id' => $_POST['vat_rate'][$i],
                            'created_by' => $this->session->userdata('user_index_id'),
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        );
                    }
                    //print_array($quotationTableData);
                    //attachements  
                    if (isset($_POST['attached_file']) && $_POST['attached_file']) {
                        $index_id = (!empty($update_id) ? $update_id : $lastInsertedId);
                        Salesquotation::sqAttachments($_POST['attached_file'], $_POST['actual_file_name'], $index_id);
                    }
                    // print_array($quotationTableData,true);
                    $totalQty = 0;
                    $totalAmount = 0;
                    $Rowcount = 1;
                    foreach ($quotationTableData as $list) {
                        $index_id = (!empty($update_id) ? $update_id : $lastInsertedId);
                        $update_table_id = (!empty($list['update_table_id']) ? $list['update_table_id'] : '');
                        $qty = (int) $list['qty'];
                        $rate = (float) $list['rate'];
                        $discount = (float) $list['discount'];
                        $current_rate = $this->input->post('current_curr_rate');
                        $current_curr_rate = (!empty($current_rate) ? $current_rate : 1);
                        if ($discount > 0) {
                            $actual = $qty * $rate;
                            $actualAmount = ($actual - $discount) * $current_curr_rate;
                        } else {
                            $actualAmount = ($qty * $rate) * $current_curr_rate;
                        }
                        $totalQty += $qty;
                        $totalAmount += (floatval($actualAmount));
                        $amount = (floatval($list['amount']));
                        $QuotationProductData = array(
                            'sales_quotation_index_id' => $index_id,
                            'sequence_no' => $Rowcount,
                            //'quotation_status' => $this->input->post('quotation_status'),
                            'product_id' => $list['product_id'],
                            'sku' => $list['sku'],
                            'description' => $list['description'],
                            'qty' => $list['qty'],
                            'rate' => $list['rate'],
                            'default_rate' => $list['default_rate'],
                            'discount' => $list['discount'] ? $list['discount'] : 0,
                            'inline_discount_type' => $list['inline_discount_type'],
                            'tax' => $list['tax'],
                            'amount' => $list['amount'],
                            'istax' => $list['istax'],
                            'sq_data_type' => isset($list['sq_data_type']) ? intval($list['sq_data_type']) : intval(0),
                            'vat_rates_index_id' => isset($list['vat_rates_index_id']) ? intval($list['vat_rates_index_id']) : intval(0),
                            'created_by' => $this->session->userdata('user_index_id'),
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        );
                        if (!empty($QuotationProductData)) {
                            if (isset($update_id) && !empty($update_id)) {
                                if (empty($update_table_id)) {
                                    unset($QuotationProductData['updated_at']);
                                    $this->CommonModel->save('sales_quotation_product_detail', $QuotationProductData);
                                }
                                unset($checkUpdatedRow[$update_table_id]);
                                unset($QuotationProductData['created_at']);
                                unset($QuotationProductData['sales_quotation_index_id']);
                                unset($QuotationProductData['created_by']);
                                $where = array('created_by' => get_current_user_id(), 'sales_quotation_index_id' => $update_id, 'quotation_product_index_id' => $update_table_id);
                                $this->CommonModel->update('sales_quotation_product_detail', $where, $QuotationProductData);
                            } else {
                                unset($QuotationProductData['updated_at']);
                                $Save = $this->CommonModel->save('sales_quotation_product_detail', $QuotationProductData);
                            }
                        }
                        $Rowcount++;
                    }
                    $emailArray = array(
                        'email' => $this->input->post('email'),
                        'email_cc' => $this->input->post('email_cc'),
                        'email_bcc' => $this->input->post('email_bcc'),
                    );
                    $images = "";
                    if (isset($_POST['attached_file'])) {
                        $images = $this->emailAttachImages($_POST['attached_file']);
                    }


                    if (!isset($Save) && !empty($update_id)) {

                        if ($checkUpdatedRow) {
                            foreach ($checkUpdatedRow as $delExtra) {
                                $this->CommonModel->delete('sales_quotation_product_detail', array('quotation_product_index_id' => $delExtra));
                            }
                        }
                        $message = "Sales Quotation updated successfully!";
                        $data['update_id'] = $update_id;
                        $data['save_type'] = $save_type;
                        $data['emailArray'] = $emailArray;
                        $data['emailimages'] = $images;
                    } else {
                        if ($Save) {
                            $message = "Sales Quotation Created successfully!";
                            $data['lastInsertedId'] = $lastInsertedId;
                            $data['save_type'] = $save_type;
                            $data['emailArray'] = $emailArray;
                            $data['emailimages'] = $images;
                        } else {
                            $statusCode = 0;
                            $data = false;
                            $message = 'There is something went wrong 1st. Please try again later!';
                            throughOutputJSON(0, $message, false);
                        }
                    }
                    if( ('save_send' == $data['save_type']) || ('print' == $data['save_type']) ) {
                        //get($table,$where = false,$fields = '*',$limit = false,$order=false, $group_by=false,$like=false)
                        $last_id = isset($update_id) && !empty($update_id) ? $update_id:$lastInsertedId;
                        $where = array(
                            'form_type' => 'quotation',
                            'company_id' => $this->session->userdata('company_id')
                        );
                        $email_setting = $this->CommonModel->get('cfs_settings' ,array('company_id' => $company_id)
                            , 'email_head_settings' // fields
                            , 1 // limit
                            , array('created_at' => 'DESC') // orderBy clause
                        );
                        
                            $data['email_setting'] = json_decode($email_setting[0]['email_head_settings'],true);
                            $subject = '';
                            // print_array($data['email_setting'],true);
                            $account_setting = $this->CommonModel->get('account_setting_sales_messages',array('company_id'=>$this->session->userdata('company_id')));
                            $account_setting = $account_setting[0];
                            $account_setting_general = $this->CommonModel->get('account_setting_company',array('company_id'=>$this->session->userdata('company_id')));
    //                        $data['company_logo'] = $account_setting_general[0]['company_logo'];
                            $company_name = $account_setting_general[0]['company_name'];
                            $emailTextMessage = account_message('quotation');//isset($account_setting['email_message']) && !empty($account_setting['email_message']) ? str_replace('System Company Name',$company_name,$account_setting['email_message']) : "Here's your invoice! We appreciate your prompt payment. Thanks for your business!";  
                            if(isset($account_setting['email_subject']))
                            {
                                $email_subject = isset($account_setting['email_subject']) && !empty($account_setting['email_subject']) ? $account_setting['email_subject'] : ''; 
                                $sub = strstr($email_subject, 'from', true);
                                $subj = $sub.'from '.$company_name;
                                $this->load->helper('common_helper');
                                $res = preg_replace('/[^a-zA-Z0-9_ -]/s','',$subj);
                                $subject = setSubject($res,$last_id,'SQ#');
                                // print_array($subj);exit();
                            } 
                            // print_array($account_setting['heading_name'],true);
                            $use_setting = isset($account_setting['heading_name']) && !empty($account_setting['heading_name']) ? $account_setting['heading_name'] : intval(0);
                            $email_heading_dear = isset($account_setting['heading_dear']) && !empty($account_setting['heading_dear']) ? $account_setting['heading_dear'] : intval(0);
                            if($email_heading_dear == 1){
                                $email_heading_dear = 'Dear';
                            }elseif($email_heading_dear == 2){
                                $email_heading_dear = 'To';
                            }else{
                                $email_heading_dear = '';
                            }
                            $email_greetings_name = '';
                            $allNames = array(
                                    '1'=>'[First][Last]',
                                    '2'=>'[Title][Last]',
                                    '3'=>'[First]',
                                    '4'=>'[Full Name]',
                                    '5'=>'[Compnay name]',
                                    '6'=>'[Display name]'
                            );
                            foreach ($allNames as $key => $list) 
                            {
                                if($use_setting == $key)
                                {
                                    $email_greetings_name = $list;
                                }
                            }
                            // exit;
                            if(!empty($email_heading_dear) && !empty($email_greetings_name)){
                                $email_greetings_name = $email_heading_dear.' '.$email_greetings_name;
                            }
                            if(!empty($email_greetings_name)){
                                $emailTextMessage = $email_greetings_name."\n".$emailTextMessage;
                            }

                            // print_array($emailTextMessage,true);
                            $data['subject'] = $subject;  
                            $data['body'] = $emailTextMessage;
                            $selected_template_id = $this->input->post('selected_template_id');
                            // echo'selected_template_id';
                            // print_array($_POST,true);
                            $data['selected_template_id'] = $selected_template_id;
                            $where = array(
                                'sales_quotation.sales_quotation_index_id' => !empty($update_id) ? $update_id : $lastInsertedId,
                                'sales_quotation.company_id' => $this->session->userdata('company_id'),
                            );
                            //$join['join_table'], $join['join_condition'], $join['join_type']
                            $joins = array(
                                array(
                                    'join_table' => 'sales_quotation_product_detail',
                                    'join_condition' => 'sales_quotation.sales_quotation_index_id = sales_quotation_product_detail.sales_quotation_index_id',
                                    'join_type' => 'LEFT'
                                )
                            );

                            $sales_quotation_data = $this->CommonModel->get_v2('sales_quotation', $where, $joins, '*');
                            $total = $deposit = 0;
                            if ($sales_quotation_data) {
                                $sales_product_info = array();
                                $discount = $sub_total = $tax = 0;
                                foreach ($sales_quotation_data as $sales_quotation) {
                                    $where = array(
                                        'pservices_index_id' => $sales_quotation['product_id'],
                                        'company_id' => $company_id
                                    );
                                    $product = $this->CommonModel->get('ps_product_services', $where, 'name');
                                    $product_info = array(
                                        'date' => strtotime($sales_quotation['created_at']) > strtotime($sales_quotation['updated_at']) ? $sales_quotation['created_at'] : $sales_quotation['updated_at'],
                                        'name' => ($product) ? $product[0]['name'] : '' ,
                                        'sku' => $sales_quotation['sku'],
                                        'description' => $sales_quotation['description'],
                                        'quantity' => $sales_quotation['qty'],
                                        'rate' => $sales_quotation['rate'],
                                        'amount' => $sales_quotation['amount'],
                                    );
                                    //first check if there is any kind of inline tax
                                    $discount_amount = $tax_amount = 0;
                                    $amount = $sales_quotation['amount'];
                                    if($sales_quotation['inline_discount_type']==1){
                                        $discount_amount = $amount -  discount_inline(1, $sales_quotation['discount'],$sales_quotation['amount']);
                                    }elseif($sales_quotation['inline_discount_type']==2){
                                        $discount_amount = $amount - discount_inline(2, $sales_quotation['discount'],$sales_quotation['amount']);
                                    }
                                    if($sales_quotation['tax_type']==1){
                                        if($sales_quotation['sq_data_type']==1){
                                            $tax_amount = tax_type_one($sales_quotation['qty'], $sales_quotation['rate'], $sales_quotation['istax'], $tax_rate=11);
                                        }elseif($sales_quotation['sq_data_type']==2){
                                            $tax_amount = tax_type_two($sales_quotation['qty'], $sales_quotation['rate'], $sales_quotation['istax'], $tax_rate=11);
                                        }
                                    }elseif($sales_quotation['tax_type']==2){
                                        if($sales_quotation['sq_data_type']==1){
                                            $tax_amount = tax_type_one($sales_quotation['qty'], $sales_quotation['rate'], $sales_quotation['istax'], $tax_rate=11);
                                        }elseif($sales_quotation['sq_data_type']==2){
                                            $tax_amount = tax_type_two($sales_quotation['qty'], $sales_quotation['rate'], $sales_quotation['istax'], $tax_rate=11);
                                        }
                                    }elseif($sales_quotation['tax_type']==3){
                                        $default_out_of_scope_rate = $sales_quotation['rate'];
                                        $default_out_of_scope_rate = $default_out_of_scope_rate / $sales_quotation['selected_exchange_rate'];
                                        $tax_amount = tax_type_one($sales_quotation['qty'], $default_out_of_scope_rate, $sales_quotation['istax']);
                                        $out_of_scope_rate = $sales_quotation['rate'];
                                        if ($sales_quotation['sq_data_type'] == 1) {
                                            if (isTax == 1) {
                                                $out_of_scope_rate = $default_out_of_scope_rate - $tax_amount;
                                            } else {
                                                $out_of_scope_rate = $default_out_of_scope_rate;
                                            }
                                            if ($sales_quotation['inline_discount_type'] > 0) {
                                                $amount = $discount_amount = out_of_scope_discount($sales_quotation['inline_discount_type'], $sales_quotation['discount'], $out_of_scope_rate);
                                            }
                                        }
                                        if ($sales_quotation['sq_data_type'] == 2) {
                                            $amount = $default_out_of_scope_rate;
                                        }
                                    }
                                    $tax += $tax_amount;
                                    $discount += $discount_amount;
                                    $sub_total += $amount;
                                    array_push($sales_product_info, $product_info);
                                }
                                $where = array(
                                    'term_index_id' => $sales_quotation_data[0]['term_id'],
                                    'company_id' => $company_id
                                );
                                $terms_info = $this->CommonModel->get_v2('term', $where, '', 'name');
                                $where = array(
                                    'currency_default_index_id' => $sales_quotation_data[0]['currency_default_index_id']
                                );
                                $currency_info = $this->CommonModel->get_v2('currency_default', $where, '', 'symbol');
                                //check if there is discount on totals then calculate that separately here...
                                if($sales_quotation_data[0]['discount_inline_total']==1){
                                    $discount = discount_on_total(1, $sales_quotation_data[0]['sales_discount_val'],$sub_total);
                                }elseif($sales_quotation_data[0]['discount_inline_total']==2){
                                    $discount = discount_on_total(2, $sales_quotation_data[0]['sales_discount_val'],$sub_total);
                                }
                                $sales_quotation_info = array(
                                    'serial_no' => $sales_quotation_data[0]['sales_quotation_index_id'],
                                    'voucher_date' => $sales_quotation_data[0]['quotation_date'],
                                    'expiry_date' => $sales_quotation_data[0]['expiration_date'],
                                    'terms' => ($terms_info && sizeof($terms_info) > 0) ? $terms_info[0]['name'] : '',
                                    'contact_info' => array(
                                        'email' => $sales_quotation_data[0]['email'],
                                        'email_cc' => $sales_quotation_data[0]['email_cc'],
                                        'email_bcc' => $sales_quotation_data[0]['email_bcc']
                                    ),
                                    'display_msg' => $sales_quotation_data[0]['msg_display_client'],
                                    'memo' => $sales_quotation_data[0]['memo'],
                                    'billing_address' => $sales_quotation_data[0]['billing_address'],
                                    'shipping_date' => $sales_quotation_data[0]['quotation_date'],
                                    'ship_via' => isset($sales_quotation_data[0]['ship_via']) ? $sales_quotation_data[0]['ship_via'] : '',
                                    'tracking_no' => isset($sales_quotation_data[0]['tracking_no']) ? $sales_quotation_data[0]['tracking_no'] : '',
                                    'custom_fields' => array(
                                        $sales_quotation_data[0]['custom_field1'],
                                        $sales_quotation_data[0]['custom_field2'],
                                        $sales_quotation_data[0]['custom_field3'],
                                        $sales_quotation_data[0]['custom_field4'],
                                    ),
                                    'product_info' => $sales_product_info,
                                    'discount' =>   $discount,
                                    'tax' => $tax,
                                    'sub_total' => $sub_total - ($tax - $discount),
                                    'deposit' => $deposit,
                                    'total' => ($sub_total) - ($discount + $deposit),
                                    'total_due' => ($sub_total) - ($discount + $deposit),
                                    'currency_symbol' => $currency_info ? $currency_info[0]['symbol'] : '',
                                );
                                $where = array(
                                    'company.company_index_id' => $this->session->userdata('company_id')
                                );
                                $joins = array(
                                    array(
                                        'join_table' => 'account_setting_company',
                                        'join_condition' => 'account_setting_company.company_id = company.company_index_id',
                                        'join_type' => 'LEFT'
                                    )
                                );
                                $company_data = $this->CommonModel->get_v2('company', $where, $joins, '*');
                                if ($company_data) {
                                    $company_info = array(
                                        'name' => $company_data[0]['company_name'],
                                        'email' => $company_data[0]['company_email'],
                                        'phone' => $company_data[0]['company_phone'],
                                        'fax' => $company_data[0]['company_fax'],
                                        'website' => $company_data[0]['company_website'],
                                        'address' => $company_data[0]['company_address'],
                                        'city' => $company_data[0]['company_city'],
                                        'tax_type' => $company_data[0]['company_taxes_type'],
                                        'code' => $company_data[0]['company_code'],
                                        'reg_no' => $company_data[0]['company_fiscal_number']
                                    );
                                } else {
                                    $company_info = array(
                                        'name' => '',
                                        'email' => '',
                                        'phone' => '',
                                        'fax' => '',
                                        'website' => '',
                                        'address' => '',
                                        'city' => '',
                                        'code' => ''
                                    );
                                }
                                $where = array(
                                    'customer.customer_index_id' => $sales_quotation_data[0]['customer_id']
                                );
                                $joins = array(
                                    array(
                                        'join_table' => 'customer_address',
                                        'join_condition' => 'customer_address.customer_id = customer.customer_index_id',
                                        'join_type' => 'LEFT'
                                    ),
                                    array(
                                        'join_table' => 'customer_tax',
                                        'join_condition' => 'customer_tax.customer_id = customer.customer_index_id',
                                        'join_type' => 'LEFT'
                                    )
                                );
                                $customer_data = $this->CommonModel->get_v2('customer', $where, $joins, '*');
                                if ($customer_data) {
                                    $customer_info = array(
                                        'salutaion' => array(
                                            'title' => $customer_data[0]['title'],
                                            'first_name' => $customer_data[0]['first_name'],
                                            'middle_name' => $customer_data[0]['middle_name'],
                                            'last_name' => $customer_data[0]['last_name'],
                                            'dispaly_name' => $customer_data[0]['dispaly_name']
                                        ),
                                        'contact_info' => array(
                                            'phone' => $customer_data[0]['phone'],
                                            'mobile' => $customer_data[0]['mobile'],
                                            'email' => $customer_data[0]['email'],
                                            'fax' => $customer_data[0]['fax'],
                                            'website' => $customer_data[0]['website'],
                                        ),
                                        'billing_info' => array(
                                            'address' => $customer_data[0]['billing_address'],
                                            'city_town' => $customer_data[0]['bill_city_town'],
                                            'state' => $customer_data[0]['bill_state'],
                                            'zip_code' => $customer_data[0]['bill_zip_code'],
                                            'country' => $customer_data[0]['bill_country']
                                        ),
                                        'shipping_info' => array(
                                            'address' => $customer_data[0]['ship_address'],
                                            'city_town' => $customer_data[0]['ship_city_town'],
                                            'state' => $customer_data[0]['ship_state'],
                                            'zip_code' => $customer_data[0]['ship_zip_code'],
                                            'country' => $customer_data[0]['ship_country']
                                        ),
                                        'vat_no' => $customer_data[0]['vat']
                                    );
                                } else {
                                    $customer_info = array(
                                        'salutaion' => array(
                                            'title' => '',
                                            'first_name' => '',
                                            'middle_name' => '',
                                            'last_name' => '',
                                            'dispaly_name' => ''
                                        ),
                                        'contact_info' => array(
                                            'phone' => '',
                                            'mobile' => '',
                                            'email' => '',
                                            'fax' => '',
                                            'website' => '',
                                        ),
                                        'billing_info' => array(
                                            'address' => '',
                                            'city_town' => '',
                                            'state' => '',
                                            'zip_code' => '',
                                            'country' => ''
                                        ),
                                        'shipping_info' => array(
                                            'address' => '',
                                            'city_town' => '',
                                            'state' => '',
                                            'zip_code' => '',
                                            'country' => ''
                                        ),
                                        'vat_no' => ''
                                    );
                                }
                                
                                $file_name = modules::run('pdfinvoicing/pdfinvoicing/index', encrypt_decrypt($selected_template_id, 'd'), $last_id,'sales_quotation',$sales_quotation_info,$company_info,$customer_info);
                            } else {
                                throughOutputJSON(0, 'No Sales Quotation data found, please try again.', false);
                            }
                            
                            $message = 'Sales Quotaion Updated successfully';
                            $data['printPreviewFileUrl'] = $file_name; //return this file name from your PDF invoicing controller...
                            $data['trxId'] = $last_id; // using it for sending email
                        
                    }
                    
                    
                    logGenerate('SALESQUOTATION', array($message), $message);
                    throughOutputJSON(1, $message, $data);
                    
                } else {
                    throughOutputJSON(0, 'Please try again in a few minutes!', false);
                }
            } else {
                throughOutputJSON(0, 'Please select customer!', $this->form_validation->error_array());
            }
        } else {
            exit('No direct script access allowed');
        }
    }
    //get product values
    public function getProduct() {
        if ($this->input->is_ajax_request() && get_current_user_id() && get_current_user_id() == $this->session->userdata('user_index_id')) {
            $company_id = $this->session->userdata('company_id');

            $product_id = $_POST['product_id'];
            if (isset($product_id) && !empty($product_id)) {
                $data = $this->CommonModel->get('ps_product_services', array('pservices_index_id' => $product_id, 'company_id' => $company_id, 'is_sale' => 1, 'is_active' => 1));
                throughOutputJSON(1, 'Loaded...', $data);
            } else {
                throughOutputJSON(0, 'There is something wrong.please try again!', false);
            }
        } else {
            exit('No direct script access allowed');
        }
    }

    /**
     * Send Email to customer
     */
    public function sendCustomerEmail() {
        if ($this->input->is_ajax_request() && get_current_user_id() && get_current_user_id() == $this->session->userdata('user_index_id')) 
        {
            $postedData = $this->input->post(); // get all posted data in a variable
            //print_array($_POST,true);
            //$abc = str_replace (' ' , '\r\n', $_POST['message']);
            //echo $abc;exit();
            $account_setting = $this->CommonModel->get('account_setting_sales_messages',array('company_id'=>$this->session->userdata('company_id')));
            $account_setting = $account_setting[0];
            $use_setting = isset($account_setting['heading_name']) && !empty($account_setting['heading_name']) ? $account_setting['heading_name'] : intval(0);

            $email_heading_dear = isset($account_setting['heading_dear']) && !empty($account_setting['heading_dear']) ? $account_setting['heading_dear'] : intval(0);
            if($email_heading_dear == 1){
                $email_heading_dear = 'Dear';
            }elseif($email_heading_dear == 2){
                $email_heading_dear = 'To';
            }else{
                $email_heading_dear = '';
            }
            $email_greetings_name = '';
            $allNames = array(
                    '1'=>'[First][Last]',
                    '2'=>'[Title][Last]',
                    '3'=>'[First]',
                    '4'=>'[Full Name]',
                    '5'=>'[Compnay name]',
                    '6'=>'[Display name]'
            );
            foreach ($allNames as $key => $list) 
            {
                if($use_setting == $key)
                {
                    $email_greetings_name = $list;
                }
            }
            // exit;
            if(!empty($email_heading_dear) && !empty($email_greetings_name)){
                $email_greetings_name = $email_heading_dear.' '.$email_greetings_name;
                $test = str_replace($email_greetings_name,'',$postedData['message']);
                $postedData['message'] = $test;
            }
            // print_array($test,true);
            // if(!empty($email_greetings_name)){
            //     $emailTextMessage = $email_greetings_name."\n".$emailTextMessage;
            // }
            
            // print_array($postedData,true);
            $trxId = $this->input->post('trx_id');
            $basicInfo = $this->SalesQuotationModel->getBasicTransactionInfo($trxId);
            $entries = $this->SalesQuotationModel->getTransactionEntries($trxId);
            $dbData = ['basicInfo' => $basicInfo, 'entries' => $entries];
            $extraInfo = ['moduleName' => $this->moduleName, 'invoiceNature' => 'Sales Quotation'];

            $this->load->helper('template_scrapper_helper'); // email template scrapper
            $templates = getDbTemplates(); // get templates from db
            
            $updatedHTML = updatePredefinedTemplateHTML($templates['emailTemplateHTML'], $postedData, $dbData, $extraInfo);
            //exit();
            // validate email field
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            if ($this->form_validation->run() == true) {
                // determine a few email properties
                $from['name'] = $basicInfo['companyName'];
                $from['email'] = $basicInfo['companyEmail'];
                $moduleName = $this->moduleName;
                $urlArray = explode('/', $postedData['attachment_url']);
                $attachmentName = end($urlArray);
                // save email log in db and send it to given email address
                $this->load->helper('email_helper');
                
                sendEmailToUsers(
                        $postedData['email']
                        , $postedData['subject']
                        , $updatedHTML
                        , $moduleName
                        , $postedData['attachment_url']
                        , $attachmentName
                        , null
                        , $from
                        , $postedData['emailcc']
                        , $postedData['emailbcc']
                );

            } else {
                throughOutputJSON(0, 'Customer Email not found!', $this->form_validation->error_array());
            }
        } else {
            exit('No direct script access allowed');
        }

        
    }

    public function quotationNoCheck() {
        if ($this->input->is_ajax_request() && get_current_user_id() && get_current_user_id() == $this->session->userdata('user_index_id')) {
            $company_id = $this->session->userdata('company_id');

            $quotation_no = $_POST['quotation_no'];
            if (isset($quotation_no) && !empty($quotation_no)) {
                $checkSequenceExist = $this->CommonModel->get('sales_quotation', array('quotation_no' => $quotation_no, 'company_id' => $company_id));
                if ($checkSequenceExist) {
                    throughOutputJSON(0, 'Sales Quotation number already exist.Try another!', false);
                }
            } else {
                throughOutputJSON(0, 'There is something wrong.please try again!', false);
            }
        } else {
            exit('No direct script access allowed');
        }
    }

    //load product
    public function loadQuoProducts() {
        if ($this->input->is_ajax_request() && get_current_user_id() && get_current_user_id() == $this->session->userdata('user_index_id')) {
            $company_id  = $this->session->userdata('company_id');
            $productData = $this->CommonModel->join1('ps_product_services', 'ps_category', 'category_id', 'category_index_id', 'left', 'ps_product_services.name as ps_name,ps_product_services.pservices_index_id as ps_id,ps_category.name as cat_name', array('ps_product_services.is_active' => 1,'ps_product_services.company_id'=>$company_id));
            $html = '';
            if ($productData) {
                $html .= '<div class="selector-add-new-back-s child_options_list select-option-s green-hover add_ps_newpopbtn_d" attr-id="add_new" attr-name="product_id">';
                $html .= '<p class="paragraph_left">';
                $html .= "<i class='fa fa-plus selector-add-new-icon'></i>Add new &nbsp;<span class='cus_text_d'></span>";
                $html .= '<div class="search-word-app-d black-s">&nbsp;&nbsp;</div></p>';
                $html .= '<div class="clear0"></div>';
                $html .= '</div>';
                foreach ($productData as $res) {
                    $html .= '<div class="child_options_list select-option-s green-hover select-styling comon-pro-d get_pro_id" attr-id="' . $res['ps_id'] . '" attr-name="product_id" >';
                    $html .= '<p class="search-d green-hover select-drop">';
                    $html .= trim($res['ps_name']);
                    $html .= '</p>';
                    $html .= '<p class="green-hover select-drop">&nbsp;';
                    if (!empty($res['cat_name'])) {
                        $html .= '(' . $res['cat_name'] . ')';
                    }
                    $html .= '</p>';
                    $html .= '<div class="clear0"></div>';
                    $html .= '</div>';
                }
            }
            //return $html;
            echo $html;
            exit;
        } else {
            exit('No direct script access allowed');
        }
    }

    public function addCustomer() {
        if ($this->input->is_ajax_request() && get_current_user_id() && get_current_user_id() == $this->session->userdata('user_index_id')) {
            $this->form_validation->set_rules('customer', 'Customer', 'trim|required');
            if ($this->form_validation->run() == true) {
                $customer = array(
                    'user_id' => $this->session->userdata('user_index_id'),
                    'dispaly_name' => $this->input->post('customer'),
                    'created_at' => date('Y-m-d H:i:s'),
                );
                $Save = $this->CommonModel->save('customer', $customer);
                $last_id = $Save['last_id'];
                if ($Save) {
                    $data = $this->CommonModel->get('customer', array('customer_index_id' => $last_id));
                    $data['company'] = (!empty($data[0]['dispaly_name']) ? $data[0]['dispaly_name'] : '');
                    $message = "Customer Created successfully!";
                    logGenerate('Customer', array($message), 'Customer Created successfully!');
                    throughOutputJSON(1, 'Customer Created successfully!', $data);
                } else {
                    throughOutputJSON(0, 'Please try again in a few minutes!', false);
                }
            } else {
                throughOutputJSON(0, 'Please select customer!', $this->form_validation->error_array());
            }
        } else {
            exit('No direct script access allowed');
        }
    }

    public function customerDetail() {
        if ($this->input->is_ajax_request() && get_current_user_id() && get_current_user_id() == $this->session->userdata('user_index_id')) {
            if ($_POST['customer_id']) {
                $company_id = $this->session->userdata('company_id');
                $data = $this->CommonModel->join1('customer', 'customer_address', 'customer_index_id', 'customer_id', 'left', '*', array('customer_index_id' => $_POST['customer_id'], 'company_id' => $company_id));
                $where = array('status'=>1,'company_id'=>$company_id,'make_default'=>1);
                $data['term'] = $this->CommonModel->get('term',$where);
                throughOutputJSON(1, 'Loaded...', $data);
            }
        } else {
            exit('No direct script access allowed');
        }
    }

    public function uploadAttachment() {
        if (isset($_FILES['atta_file_names_d']['name'][0])) {
            $upload = uploadMultipleAttachment('atta_file_names_d', $_FILES, $this->input->post('path'));
            if ($upload) {
                echo json_encode(array('success' => $upload));
                exit;
            }
        } else {
            throughOutputJSON(0, 'Please try again in a few minutes!', false);
        }
    }

    //usman code recurring
    public function loadOnlyRecPopup() {
        if ($this->input->is_ajax_request() && get_current_user_id() && get_current_user_id() == $this->session->userdata('user_index_id')) {
            $company_id = $this->session->userdata('company_id');
            $data['getSiSettings'] = $this->CommonModel->get('sales_qo_settings', array('company_id' => $company_id));
            $data['vat_profile'] = $this->CommonModel->vat_profile(1);
            $data['load_style'] = array('bills_and_payment_popup.css', 'custom_tooltip.css', 'all_sales_product_services.css', 'allsales.css', 'custom-ps.css', 'customer_detail.css', 'progress-styling.css');
        
            $data['load_script'] = array('test_sales_recurring_quotation.js','test_sales_quotation','sales_quotation_generic.js', 'selectize.min.js','jQuery.resizableColumns.min.js', 'pservicesintegrate.js', 'new-customer-popup.js');
            $data['listCustomer'] = $this->CommonModel->get('customer', false, '*', false, array('dispaly_name' => 'ASC'));
            $data['quotation_no'] = $this->CommonModel->getMax('sales_quotation_recurring', false, 'quotation_no');
            $data['getTerms'] = $this->CommonModel->get('term', array('status' => 1,'company_id' => $company_id));
            if (isset($_POST['update_id']) && !empty($_POST['dat_typ']) || !empty($_POST['rec_quo_id'])) {
                if (isset($_POST['rec_quo_id']) && !empty($_POST['rec_quo_id'])) {
                    $_POST['update_id'] = $_POST['rec_quo_id'];
                }
                $data['listRecQuotationUpdate'] = $this->CommonModel->get('sales_quotation_recurring', array('sales_quotation_recurring.sales_quotation_index_id' => $_POST['update_id']));

                $data['listRecQuotation'] = $this->SalesQuotationModel->quotation_rec_sum('sales_quotation_recurring', 'sales_quotation_recurring_product', 'customer', $_POST['update_id']);

                $data['listQuotationTableData'] = $this->CommonModel->join1('sales_quotation_recurring', 'sales_quotation_recurring_product', 'sales_quotation_index_id', 'sales_quotation_index_id', 'left', '*', array('sales_quotation_recurring.sales_quotation_index_id' => $_POST['update_id']), false, false, false, false, array('sales_quotation_recurring_product.sequence_no' => 'sequence_no'));
                $data['attach'] = $this->CommonModel->join1('sales_quotation_recurring', 'sales_quotation_recurring_attachment', 'sales_quotation_indexid', 'sales_quotation_index_id', 'left', '*', array('sales_quotation_recurring.sales_quotation_index_id' => $_POST['update_id']));
                $data['update_id'] = $_POST['update_id'];
            }
            $data['recentQuotation'] = $this->SalesQuotationModel->quotation_sum();
            $data['currency'] = $this->CommonModel->join2('currency', 'currency_details', 'currency_default', 'currency.currency_index_id', 'currency_details.currency_index_id', 'currency.currency_default_index_id', 'currency_default.currency_default_index_id', 'INNER', 'INNER', '*', array('currency.company_id' => $this->session->userdata('company_id'), 'currency.status' => 1, 'currency_details.currency_status' => 1));
            $data['product_details'] = $this->CommonModel->join1('ps_product_services', 'ps_category', 'category_id', 'category_index_id', 'left', 'ps_product_services.name as ps_name,ps_product_services.pservices_index_id as ps_id,ps_category.name as cat_name', array('ps_product_services.is_active' => 1,'company_id'=>$company_id));
            $data['quotationsRows'] = (isset($data['listQuotationTableData']) && !empty($data['listQuotationTableData']) && count($data['listQuotationTableData']) > 2) ? count($data['listQuotationTableData']) : 2;
            $data['quotation_no'] = $this->CommonModel->getMax('sales_quotation_recurring', false, 'quotation_no');

            $data['listRecQuotation'] = $this->SalesQuotationModel->quotation_rec_sum('sales_quotation_recurring', 'sales_quotation_recurring_product', 'customer', false);
            $data['rec_quotation'] = $this->load->view('popup/test-make-recurring', $data, true);
            throughOutputJSON(1, 'Loaded...', $data['rec_quotation']);
        } else {
            exit('No direct script access allowed');
        }
    }
    public function loadRecurQuotationPopup(){
        $company_id = $this->session->userdata('company_id');
        //$data['quotation_no'] =   $this->CommonModel->getMax('sales_quotation_recurring',false,'quotation_no');
        $data['getTerms'] = $this->CommonModel->get('term', array('status' => 1,'company_id' => $company_id));
        if (isset($_POST['update_id']) && !empty($_POST['dat_typ'])) {
            $data['rec_listRecQuotationUpdate'] = $this->CommonModel->get('sales_quotation_recurring', array('sales_quotation_recurring.sales_quotation_index_id' => $_POST['update_id']));

            $data['rec_listRecQuotation'] = $this->SalesQuotationModel->quotation_rec_sum('sales_quotation_recurring', 'sales_quotation_recurring_product', 'customer', $_POST['update_id']);
            $data['rec_listQuotationTableData'] = $this->CommonModel->join1('sales_quotation_recurring', 'sales_quotation_recurring_product', 'sales_quotation_index_id', 'sales_quotation_index_id', 'left', '*', array('sales_quotation_recurring.sales_quotation_index_id' => $_POST['update_id']), false, false, false, false, array('sales_quotation_recurring_product.sequence_no' => 'sequence_no'));

            $data['attach'] = $this->CommonModel->join1('sales_quotation_recurring', 'sales_quotation_recurring_attachment', 'sales_quotation_index_id', 'sales_quotation_index_id', 'left', '*', array('sales_quotation_recurring.sales_quotation_index_id' => $_POST['update_id']));
            $data['update_id'] = $_POST['update_id'];
        }
        $data['recentQuotation'] = $this->SalesQuotationModel->quotation_sum();
        $data['rec_quotationsRows'] = (isset($data['rec_listQuotationTableData']) && !empty($data['rec_listQuotationTableData']) && count($data['rec_listQuotationTableData']) > 2) ? count($data['rec_listQuotationTableData']) : 2;
        $data['quotation_no'] = $this->CommonModel->getMax('sales_quotation_recurring', false, 'quotation_no');
        $data['vat_profile'] = $this->CommonModel->vat_profile(1);
        $data['rec_listRecQuotation'] = $this->SalesQuotationModel->quotation_rec_sum('sales_quotation_recurring', 'sales_quotation_recurring_product', 'customer', false);
        return $data;
    }

    public function SaveRecuringQuotation() {
        // print_array($_POST);exit;
        if ($this->input->is_ajax_request() && get_current_user_id() && get_current_user_id() == $this->session->userdata('user_index_id')) {
            $company_id = $this->session->userdata('company_id');
            $branch_id = $this->session->userdata('branch_id');
            $rec_quotation_date = $this->input->post('rec_quotation_date');
            $rec_expire_date = $this->input->post('rec_expire_date');
            $update_id = $this->input->post('update_id');
            $customer_id = $this->input->post('rec_customer_id');
            $customer_id = $customer_id[0];
            $checkquarter = manageQuarterLocking($rec_quotation_date);
            if ($checkquarter != 'unlock' || empty($checkquarter)) {
                throughOutputJSON(0, 'Changes are not allowed quarter is locked!', false);
            }
            // echo $customer_id; exit;
            if (!empty($_POST['product_id'])) {
                $product_id = array_filter($_POST['product_id']);
            }
            if (empty($product_id)) {
                throughOutputJSON(0, 'Please enter at least one line item!', false);
                exit;
            }
            //$this->form_validation->set_rules('rec-customer_id[]', 'Customer', 'trim|required');
            $this->form_validation->set_rules('rec_email', 'email', 'trim|required');
            if ($this->form_validation->run() == true) {
                if (empty($this->input->post('quotation_no'))) {
                    $sequence = $this->CommonModel->getMax('sales_quotation_recurring', false, 'quotation_no');
                    $quotation_no = (int) $sequence[0]['quotation_no'] + 1;
                } else {
                    $quotation_no = $this->input->post('quotation_no');
                    $sequence = $this->CommonModel->get('sales_quotation_recurring', array('quotation_no' => $quotation_no), '*');
                    if (!empty($sequence) && count($sequence) > 0 && empty($update_id)) {
                        throughOutputJSON(0, 'Sale Quotation number already exist.Try another!', false);
                        exit;
                    }
                }
                $rec_sqo_term = $this->input->post('rec_sqo_term');
                $qt_rec_start_date = str_replace('/', '-', $this->input->post('qt_rec_start_date'));
                $qt_rec_start_date = (!empty($qt_rec_start_date) ? date("Y-m-d", strtotime($qt_rec_start_date)) : '0000-00-00 00:00:00');

                $qt_rec_end_st_strt_date = str_replace('/', '-', $this->input->post('qt_rec_end_st_strt_date'));
                $qt_rec_end_st_strt_date = (!empty($qt_rec_end_st_strt_date) ? date("Y-m-d", strtotime($qt_rec_end_st_strt_date)) : '0000-00-00 00:00:00');

                $rec_quotation_date = str_replace('/', '-', $this->input->post('rec_quotation_date'));
                $rec_quotation_date = (!empty($rec_quotation_date) ? date("Y-m-d", strtotime($rec_quotation_date)) : '0000-00-00 00:00:00');

                $rec_expire_date = str_replace('/', '-', $this->input->post('rec_expire_date'));
                $rec_expire_date = (!empty($rec_expire_date) ? date("Y-m-d", strtotime($rec_expire_date)) : '0000-00-00 00:00:00');
                //subtotal discount
                $discount_type = $this->input->post('discount_type');
                $discount_val = $this->input->post('discount_val');
                $total = $this->input->post('total');
                if ($discount_type == 1 && $total > 0 && $discount_val > 0) {
                    $subtotal_discount = ($total * $discount_val) / 100;
                } else if ($discount_type == 2 && $total > 0 && $discount_val > 0) {
                    $subtotal_discount = ($total - $discount_val);
                } else {
                    $subtotal_discount = 0;
                }
                $checkUpdatedRow = [];
                if ($update_id) {
                    $dataId = $this->CommonModel->get('sales_quotation_recurring_product', array('sales_quotation_index_id' => $update_id));
                    if(!empty($dataId)){
                        foreach ($dataId as $quo) {
                            $checkUpdatedRow[$quo['sales_quotation_product_index_id']] = $quo['sales_quotation_product_index_id'];
                        }
                    }

                }
                $valuediscount = $_POST['discount'];

                $tdiscount = 0;

                foreach ($valuediscount as $cdiscount) {
                    if (($cdiscount > 0)) {
                        $tdiscount = $tdiscount + $cdiscount;
                    }
                }
                // die();
                $interval_weaks_every = $this->input->post('rec_time_interval_weaks_every');
                $interval_month_day_every_month = $this->input->post('interval_month_day_every_month');
                $interval_month_day_of_weak = $this->input->post('interval_month_day_of_weak');
                $rec_shipping_fee = $this->input->post('rec_shipping_fee');
                $tax_type = $this->input->post('tax_type');
                $discount_inline_total = $this->input->post('discount_inline_total');
                // $sales_tax_rate = $this->input->post('sales_tax_rate');
                // $transactionType = $this->input->post('rec_transaction_type');
                // if (isset($transactionType) && $transactionType > 0) {
                //     $transactionType = 1;
                // } else {
                    $transactionType = intval(0);
                // }
                $document_no = getDocumentNumber('sales_quotation_recurring', 'document_no');
                $QuotationRecurData = array(
                    'company_id' => $this->session->userdata('company_id'),
                    'branch_id' => $branch_id,
                    'customer_id' => $customer_id,
                    'document_no' => intval($document_no),
                    'currency_default_index_id' => $this->input->post('rec_currency_id'),
                    'quotation_no' => $quotation_no,
                    'rec_temp_name' => $this->input->post('qt_rec_temp_name'),
                    'schedule_type' => $this->input->post('qt_rec_schedule_type'),
                    'rec_create' => $this->input->post('qt_rec_create_days'),
                    'rec_reminder' => $this->input->post('qt_rec_remind_days'),
                    'email' => $this->input->post('rec_email'),
                    'rec_interval' => $this->input->post('qt_rec_time_interval_type'),
                    'daily_days' => $this->input->post('qt_rec_time_interval_days'),
                    'interval_weaks_every' => isset($interval_weaks_every) ? intval($interval_weaks_every) : intval(0),
                    'interval_month_day_every_month' => isset($interval_month_day_every_month) ? intval($interval_month_day_every_month) : intval(0),
                    'interval_month_day_of_weak' => isset($interval_month_day_of_weak) ? intval($interval_month_day_of_weak) : intval(0),
                    'recur_start_date' => $qt_rec_start_date,
                    'wekly_total_day' => $this->input->post('qt_rec_time_interval_weak_day'),
                    'wekly_day_name' => $this->input->post('qt_rec_time_interval_month_day'),
                    'monthly_on' => $this->input->post('qt_rec_time_interval_month_day_no'),
                    'yearly_month_name' => $this->input->post('time_interval_year_month'),
                    'year_month_no' => $this->input->post('interval_year_month_day_no'),
                    'qt_rec_end_status' => $this->input->post('qt_rec_end_status'),
                    'end_status_strt_date' => $qt_rec_end_st_strt_date,
                    'occurrences' => $this->input->post('end_st_occurrences'),
                    'rec_billing_addres' => $this->input->post('qt_rec_billing_address'),
                    'rec_quotation_date' => $rec_quotation_date,
                    'rec_expire_date' => $rec_expire_date,
                    'rec_crew_no' => $this->input->post('rec_crew_no'),
                    'acct_type' => $this->input->post('account_type'),
                    'message' => $this->input->post('message'),
                    'memo' => $this->input->post('memo'),
                    'tax_type' => isset($tax_type) ? intval($tax_type) : intval(0),
                    'discount_inline_total' => isset($discount_inline_total) ? intval($discount_inline_total) : intval(0),
                    'sales_tax_rate' => isset($sales_tax_rate) ? floatval($sales_tax_rate) : floatval(0),
                    'discount_type' => isset($discount_type) ? intval($discount_type) : intval(0),
                    'discount_val' => isset($tdiscount) ? floatval($tdiscount) : floatval(0),
                    'rec_term_id' => isset($rec_sqo_term[0]) ? intval($rec_sqo_term[0]) : intval(0),
                    'subtotal_discount' => isset($subtotal_discount) ? floatval($subtotal_discount) : floatval(0),
                    'rec_custom_field1' => $this->input->post('rec_custom_field1'),
                    'transaction_type' => $transactionType,
                    'rec_custom_field2' => $this->input->post('rec_custom_field2'),
                    'rec_custom_field3' => $this->input->post('rec_custom_field3'),
                    'rec_custom_field4' => $this->input->post('rec_custom_field4'),
                    'rec_shipping_fee' => isset($rec_shipping_fee) ? floatval($rec_shipping_fee) : floatval(0),
                    'created_by' => $this->session->userdata('user_index_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                );
                //echo"helo<pre>";print_r($QuotationRecurData);exit;
                if (isset($update_id) && !empty($update_id)) {
                    unset($QuotationRecurData['document_no']);
                    unset($QuotationRecurData['created_at']);
                    $where = array('sales_quotation_index_id' => $update_id);
                    $this->CommonModel->update('sales_quotation_recurring', $where, $QuotationRecurData);
                } else {
                    $Save = $this->CommonModel->save('sales_quotation_recurring', $QuotationRecurData);
                    // print_array($Save,true);
                    $lastInsertedId = $Save['last_id'];
                }

                if (!empty($lastInsertedId) || isset($update_id)) {
                    $lastInsertedId = (!empty($lastInsertedId) ? $lastInsertedId : '');
                    $quotation_status = $this->input->post('quotation_status');
                    for ($i = 0; $i < count($_POST['product_id']); $i++) {
                        $update_table_ids = (!empty($_POST['update_table_id'][$i]) ? $_POST['update_table_id'][$i] : '');
                        $attached_files = (!empty($_POST['attached_file'][$i]) ? $_POST['attached_file'][$i] : '');
                        $actual_file_names = (!empty($_POST['actual_file_name'][$i]) ? $_POST['actual_file_name'][$i] : '');
                        $data_tax_type = (!empty($_POST['data_tax_type'][$i]) ? $_POST['data_tax_type'][$i] : '');
                        $rec_sku = (!empty($_POST['rec-sku'][$i]) ? $_POST['rec-sku'][$i] : '');
                        if (empty($_POST['product_id'][$i]) || empty($_POST['qty'][$i])) {
                            continue;
                        }
                        $squenceNo = $this->input->post('squenceNo');
                        $seq_no = $i + 1;
                        $quotationTableData[] = array(
                            'product_id' => $_POST['product_id'][$i],
                            'sku' => $rec_sku,
                            'sequence_no' => $seq_no,
                            'update_table_id' => $update_table_ids,
                            'description' => $_POST['description'][$i],
                            'qty' => $_POST['qty'][$i],
                            'rate' => $_POST['rate'][$i],
                            'inline_discount_type' => $_POST['rec_inline_discount_type'][$i],
                            'discount' => $_POST['discount'][$i],
                            'tax' => $_POST['tax'][$i],
                            'amount' => $_POST['amount'][$i],
                            'default_rate' => $_POST['default_rate'][$i],
                            'data_tax_type' => $data_tax_type,
                            'created_by' => $this->session->userdata('user_index_id'),
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        );
                    }
                    //attachements  
                    if (isset($_POST['attached_file']) && $_POST['attached_file']) {
                        $index_id = (!empty($update_id) ? $update_id : $lastInsertedId);
                        Salesquotation::sqAttachments($_POST['attached_file'], $_POST['actual_file_name'], $index_id, $recurring = 'recurring');
                    }
                    $totalQty = 0;
                    $totalAmount = 0;
                    if (!empty($quotationTableData) && count($quotationTableData) > 0) {
                        foreach ($quotationTableData as $data) {
                            $update_table_id = (!empty($data['update_table_id']) ? $data['update_table_id'] : '');
                            $index_id = (!empty($update_id) ? $update_id : $lastInsertedId);
                            $qty = (int) $data['qty'];
                            $rate = (float) $data['rate'];
                            $discount = (float) $data['discount'];
                            if ($discount > 0) {
                                $actual = $qty * $rate;
                                $actualAmount = ($actual - $discount);
                            } else {
                                $actualAmount = $qty * $rate;
                            }
                            $totalQty += $qty;
                            $totalAmount += $actualAmount;
                            // if($actualAmount != $data['amount'])
                            //  {                                                   
                            //  throughOutputJSON(0,'The amount you have entered is not valid!',false); exit;
                            //  }   
                            $QuotationProductData = array(
                                'sales_quotation_index_id' => $index_id,
                                'product_id' => $data['product_id'],
                                'sku' => $data['sku'],
                                'sequence_no' => isset($data['sequence_no']) ? intval($data['sequence_no']) : intval(0),
                                'description' => $data['description'],
                                'qty' => isset($data['qty']) ? intval($data['qty']) : intval(0),
                                'rate' => isset($data['rate']) ? floatval($data['rate']) : floatval(0),
                                'inline_discount_type' => isset($data['inline_discount_type']) ? intval($data['inline_discount_type']) : intval(0),
                                'discount' => isset($data['discount']) ? floatval($data['discount']) : floatval(0),
                                'tax' => isset($data['tax']) ? floatval($data['tax']) : floatval(0),
                                'amount' => isset($data['amount']) ? floatval($data['amount']) : floatval(0),
                                'default_rate' => isset($data['default_rate']) ? floatval($data['default_rate']) : floatval(0),
                                'rec_data_type' => isset($data['data_tax_type']) ? intval($data['data_tax_type']) : intval(0),
                                'created_by' => $this->session->userdata('user_index_id'),
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                            );
                            ///print_array($data['update_table_id']);
                            if (!empty($QuotationProductData)) {
                                if (isset($update_id) && !empty($update_id)) {
                                    $update_table_id = (!empty($data['update_table_id']) ? $data['update_table_id'] : '');
                                    if (empty($update_table_id)) {
                                        unset($QuotationProductData['updated_at']);
                                        $this->CommonModel->save('sales_quotation_recurring_product', $QuotationProductData);
                                    }
                                    unset($checkUpdatedRow[$update_table_id]);
                                    unset($QuotationProductData['created_at']);
                                    unset($QuotationProductData['sales_quotation_index_id']);
                                    unset($QuotationProductData['created_by']);
                                    $where = array('created_by' => get_current_user_id(), 'sales_quotation_index_id' => $update_id, 'sales_quotation_product_index_id' => $update_table_id);
                                    $this->CommonModel->update('sales_quotation_recurring_product', $where, $QuotationProductData);
                                } else {
                                    unset($QuotationProductData['updated_at']);
                                    $Save = $this->CommonModel->save('sales_quotation_recurring_product', $QuotationProductData);
                                }
                            }
                        }
                    }

                    if (empty($update_id)) {
                        if ($Save) {
                            $message = "Sale Quotation recurring Created successfully!";
                            logGenerate('SALEQUOTATION', array($message), 'Sale Quotation Created successfully!');
                            $data['lastInsertedId'] = $lastInsertedId;
                            $data['save_type'] = '';
                            throughOutputJSON(1, 'Sale Quotation recurring Created successfully!', $data);
                        } else {
                            throughOutputJSON(0, 'There is something went wrong 1st. Please try again later!', false);
                        }
                    }
                    if (!isset($Save) && !empty($update_id)) {
                        if ($checkUpdatedRow) {
                            foreach ($checkUpdatedRow as $delExtra) {
                                $this->CommonModel->delete('sales_quotation_recurring_product', array('sales_quotation_product_index_id' => $delExtra));
                            }
                        }
                        $message = "Sale Quotation recurring updated successfully!";
                        logGenerate('SALEQUOTATION', array($message), 'Sale Quotation updated successfully!');
                        $data['update_id'] = $update_id;
                        $data['save_type'] = '';

                        throughOutputJSON(1, "Sale Quotation recurring updated successfully!", $data);
                    }
                } else {
                    throughOutputJSON(0, 'There is something went wrong 3nd. Please try again later!', false);
                }
            } else {
                throughOutputJSON(0, 'Please select customer!', $this->form_validation->error_array());
            }
        } else {
            exit('No direct script access allowed');
        }
    }

    public function saveRecurCustomer() {
        ///print_array($_POST);exit;
        if ($this->input->is_ajax_request() && get_current_user_id() && get_current_user_id() == $this->session->userdata('user_index_id')) {

            $this->form_validation->set_rules('customer', 'Customer', 'trim|required');
            if ($this->form_validation->run() == true) {
                $customer = array(
                    'user_id' => $this->session->userdata('user_index_id'),
                    'dispaly_name' => $this->input->post('customer'),
                    'created_at' => date('Y-m-d H:i:s'),
                );
                //print_array($customer); exit;
                $Save = $this->CommonModel->save('customer', $customer);
                if ($Save) {
                    $last_id = $Save['last_id'];
                    $data = $this->CommonModel->get('customer', array('customer_index_id' => $last_id));
                    $data['company'] = (!empty($data[0]['dispaly_name']) ? $data[0]['dispaly_name'] : '');
                    $message = "Customer Created successfully!";
                    logGenerate('Customer', array($message), 'Customer Created successfully!');
                    throughOutputJSON(1, 'Customer Created successfully!', $data);
                } else {
                    throughOutputJSON(0, 'Please try again in a few minutes!', false);
                }
            } else {
                throughOutputJSON(0, 'Please select customer!', $this->form_validation->error_array());
            }
        } else {
            exit('No direct script access allowed');
        }
    }

    public function checkRecuringQuotNo() {
        if ($this->input->is_ajax_request() && get_current_user_id() && get_current_user_id() == $this->session->userdata('user_index_id')) {
            $quotation_no = $_POST['quotation_no'];
            $checkSequenceExist = $this->CommonModel->get('sales_quotation_recurring', array('quotation_no' => $quotation_no));
            if ($checkSequenceExist) {
                throughOutputJSON(0, 'Quotation number already exist.Try another!', false);
            }
        } else {
            exit('No direct script access allowed');
        }
    }

    public function     sqAttachments($file, $actual_file, $lastInsertedId, $recurring = false) {
        $i = 0;
        foreach ($file as $fl) {
            $saveAttach = array
                (
                'sales_quotation_index_id' => $lastInsertedId,
                'attached_file' => $fl,
                'actual_file_name' => $actual_file[$i],
                'created_by' => get_current_user_id(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            if ($recurring == 'recurring') {
                $saveVerify = $this->CommonModel->save('sales_quotation_recurring_attachment', $saveAttach);
            } else {
                $saveVerify = $this->CommonModel->save('sales_quotation_attachment', $saveAttach);
            }
            if ($saveVerify) {
                
            } else {
                throughOutputJSON(0, 'There is something went wrong while saving attachment.', false);
            }
            $i++;
        }
    }

    //delete sale quotation
    public function deleteSaleQuotation() {
        if ($this->input->is_ajax_request() && get_current_user_id() && get_current_user_id() == $this->session->userdata('user_index_id')) {
            $delete_id = $_POST['delete_id'];
            if ($delete_id) {
                $company_id = $this->session->userdata('company_id');
                $deleteArray = array(
                    'company_id' => $company_id,
                    'quotation_status' => 2,
                    'created_by' => $this->session->userdata('user_index_id'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $where = array('company_id' => $company_id, 'sales_quotation_index_id' => $delete_id);
                $status = $this->CommonModel->update('sales_quotation', $where, $deleteArray);
                if ($status) {
                    $message = "Sale quotation deleted successfully";
                    logGenerate('SALEQUOTATION', array($message), 'Sale quotation deleted successfully!');
                    throughOutputJSON(1, 'Sale quotation deleted successfully!', false);
                } else {
                    throughOutputJSON(0, 'There is something went wrong please try adain.', false);
                }
            }
        }
    }

}

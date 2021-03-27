<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Sales_quo_save extends CI_Model {

    public function __construct() 
	{
        parent::__construct();
    }


 
	public function custom_quo()
	{
		$this->db->select('qon.sales_quotation_index_id AS qid,qp.product_id,ps.category_id,ps_category.name AS cat_name,ps.name AS ps_name,qon.customer_id,qon.email,qon.email_cc,qon.email_bcc,qon.send_later,qon.online_payment,qon.billing_address,qon.quotation_date,qon.expiration_date,qon.quotation_no,qon.crew,qon.msg_display_client,qon.memo,qon.sales_tax_rate,qon.sales_discount,qon.sales_discount_val,qon.created_by,qon.created_at,qon.updated_at,qp.quotation_product_index_id,qp.description,qp.qty,qp.rate,qp.tax,qp.amount,qp.created_by AS created_by1,qp.created_at AS created_at1,qp.updated_at AS updated_at1');
		$this->db->from('quotation_on AS qon');

		$this->db->join('quotation_product_on AS qp', 'qp.sales_quotation_index_id = qon.sales_quotation_index_id','INNER');

		$this->db->join('ps_product_services AS ps', 'ps.pservices_index_id = qp.product_id','left');

		$this->db->join('ps_category', 'ps_category.category_index_id = ps.category_id','left');
		$query = $this->db->get();
        if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
        else
		{
		    return 0;
		}

	}
	
	function getMax($table,$where = false,$field)
    {
        $this->db->select_max($field)->from($table);
        if($where)
		{
            $this->db->where($where);
        }
        $query = $this->db->get();
        if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
    }
	
	function quotation_sum($update_id=false)
    {
        $this->db->select('customer.customer_index_id,customer.dispaly_name,sales_quotation.*,sales_quotation_product_detail.*,SUM(amount),currency_default.currency_default_index_id,currency_default.symbol');
        $this->db->from('sales_quotation');
        $this->db->join('sales_quotation_product_detail', 'sales_quotation_product_detail.sales_quotation_index_id = sales_quotation.sales_quotation_index_id', 'INNER');

        $this->db->join('customer', 'customer.customer_index_id = sales_quotation.customer_id', 'LEFT');
        $this->db->join('currency_default', 'currency_default.currency_default_index_id = sales_quotation.currency_default_index_id', 'LEFT');
        if($update_id)
        {	
        	$this->db->where('sales_quotation_product_detail.sales_quotation_index_id',$update_id);
    	}
       $this->db->where('sales_quotation.company_id',$this->session->userdata('company_id'));
        $this->db->order_by('sales_quotation_product_detail.sales_quotation_index_id desc');
        $this->db->group_by('sales_quotation_product_detail.sales_quotation_index_id');
        $query = $this->db->get();
		 // echo $this->db->last_query();
        if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
        else
		{
		    return 0;
		}
    }
    function quotation_rec_sum($table1, $table2, $table3, $update_id=false)
    {
        $this->db->select($table1.'.*,'.$table2.'.*,SUM(amount),'.$table3.'.customer_index_id,'.$table3.'.dispaly_name');
        $this->db->from($table1);
        $this->db->join($table2, $table2.'.sales_quotation_index_id = '.$table1.'.sales_quotation_index_id', 'INNER');

        $this->db->join($table3, $table3.'.customer_index_id = '.$table1.'.customer_id', 'LEFT');
        if(!empty($update_id))
        {	
        	$this->db->where($table2.'.sales_quotation_index_id',$update_id);
    	}
        $this->db->order_by($table2.'.sales_quotation_product_index_id desc');
        $this->db->group_by($table2.'.sales_quotation_index_id');
        $query = $this->db->get();
        if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
        else
		{
		    return 0;
		}
    }

    /**
     * Get Basic Info against a transaction
     * 
     * @param $trxId Module Transaction ID
     * 
     * @return Array[][] $basicInfo from various tables
     */
    function getBasicTransactionInfo($trxId)
    {
        $where = [
            'MainTable.sales_quotation_index_id' => $trxId
            , 
        ];
        $joins = [
            // company info
            [
                'join_table' => 'company AS Company',
                'join_condition' => 'MainTable.company_id = Company.company_index_id',
                'join_type' => 'LEFT'
            ],
            [
                'join_table' => 'account_setting_company AS companyInfo',
                'join_condition' => 'MainTable.company_id = companyInfo.company_id',
                'join_type' => 'LEFT'
            ],
            // customer info
            [
                'join_table' => 'customer AS Recipient',
                'join_condition' => 'MainTable.customer_id = Recipient.customer_index_id',
                'join_type' => 'LEFT'
            ],
            [
                'join_table' => 'customer_address AS RecipientAddress',
                'join_condition' => 'MainTable.customer_id = RecipientAddress.customer_id',
                'join_type' => 'LEFT'
            ],
            // terms
            [
                'join_table' => 'term AS term',
                'join_condition' => 'MainTable.term_id = term.term_index_id',
                'join_type' => 'LEFT'
            ],
            // currency
            [
                'join_table' => 'currency_default AS currency',
                'join_condition' => 'MainTable.currency_default_index_id = currency.currency_default_index_id',
                'join_type' => 'LEFT'
            ],
        ];
        // $fields = 'MainTable.*, Company.*, companyInfo.*, Recipient.*, RecipientAddress.*, ';
        
        $fields = "
            MainTable.sales_quotation_index_id AS modelId, MainTable.expiration_date AS expirationDate, 

            companyInfo.company_id AS companyId, companyInfo.company_name AS companyName, companyInfo.company_email AS companyEmail,
            companyInfo.company_address AS companyAddress, companyInfo.company_city AS companyCity,

            Recipient.customer_index_id AS customerId, Recipient.dispaly_name AS recipientDisplayName, , Recipient.company AS RecipientCompany,
            Recipient.first_name AS recipientFirstName, Recipient.last_name AS recipientLastName,
            RecipientAddress.billing_address AS billingAddress, RecipientAddress.bill_city_town AS billingCityTown,
            RecipientAddress.bill_state AS billingState, RecipientAddress.bill_zip_code AS billingZipCode,
            
            term.name AS TermValue, 
            
            currency.short_name AS currencyShortName,
            currency.currency_default_index_id AS currencyId
        ";
        $queryData = $this->CommonModel->get_v2('sales_quotation AS MainTable', $where, $joins, $fields );
        // print_array($this->db->last_query(), true);
        
        if(!$queryData){
            throughOutputJSON(0,'Database Error. No Record Found!', false);
        }
        return $queryData[0];
    }
    
    /**
     * get records from details table against given transaction ID
     * 
     * @param $trxId Module Transaction ID
     * 
     * @return Array[][] $entriesArray
     */
    function getTransactionEntries($trxId)
    {
        // Product Details
        $query = "
            SELECT
                product.name AS productName
                , entries.description AS productDescription
                , entries.inline_discount_type AS inlineDiscountType
                , entries.discount AS inlineDiscountValue
                , entries.rate AS unitRate
                , entries.qty AS productQnty
                , entries.amount AS productTotalAmount
                , entries.tax AS productTaxAmount
                , entries.updated_at AS productUpdateTime
            FROM sales_quotation_product_detail AS entries
                RIGHT JOIN ps_product_services AS product
                ON entries.product_id = product.pservices_index_id
            WHERE entries.sales_quotation_index_id = {$trxId}
        ";
        $queryResult = $this->db->query($query);
        if($queryResult->num_rows() <= 0){
            throughOutputJSON(0,'Database Error. No Entries Found!', false);
        }
        return $queryResult->result_array(); // all quotation product entries
    }
	
}
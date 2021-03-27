<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Comman_model extends CI_Model {

    public function __construct() 
	{
        parent::__construct();
    }
	
    function save($table,$data)
	{
		$this->db->db_debug = false;
        $this->db->insert($table, $data);
		if ($this->db->insert_id() > 0)
		{
            return array("last_id" => $this->db->insert_id(), "flag" => true);
        }
		else
		{
			if($table == 'coa')
			{
				return $error = $this->db->error();
			}
            return FALSE;
        }
    }

	function userLogin($table,$where)
    {
        $this->db->select()->from($table)->where($where);
        $result = $this->db->get();
        if($result->num_rows() == 1)
		{
			return $result->result_array();
		}
        else
		{
			return FALSE;
		}
    }
	public function custom_quo()
	{
		$this->db->select('qon.quotation_index_id AS qid,qp.product_id,ps.category_id,ps_category.name AS cat_name,ps.name AS ps_name,qon.customer_id,qon.email,qon.email_cc,qon.email_bcc,qon.send_later,qon.online_payment,qon.billing_address,qon.quotation_date,qon.expiration_date,qon.quotation_no,qon.crew,qon.msg_display_client,qon.memo,qon.sales_tax_rate,qon.sales_discount,qon.sales_discount_val,qon.created_by,qon.created_at,qon.updated_at,qp.quotation_product_index_id,qp.description,qp.qty,qp.rate,qp.tax,qp.amount,qp.created_by AS created_by1,qp.created_at AS created_at1,qp.updated_at AS updated_at1');
		$this->db->from('quotation_on AS qon');

		$this->db->join('quotation_product_on AS qp', 'qp.quotation_index_id = qon.quotation_index_id','INNER');

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
	function update($table,$where,$data)
    {
        $this->db->update($table, $data, $where);
        if ($this->db->affected_rows() == 1)
		{
			return true;
		}
        else if ($this->db->affected_rows() == 0)
		{
			return false;
		}
		else
		{
			return -1;
		}
    }
	
	function get($table,$where = false,$fields = '*',$limit = false,$order=false)
    {
        $this->db->select($fields)->from($table);
        if($where)
		{
            $this->db->where($where);
        }
		if($limit)
		{
			$this->db->limit($limit);
		}
        if($order)
		{
            foreach ($order as $key => $value)
			{
				$this->db->order_by($key,$value);
            }
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
	
	
	function getLike($table ,$where ,$fields = '*',$keyword = false,$sKeyword = false,$order=false)
    {
		$this->db->select($fields)->from($table);
		if($where)
		{
            $this->db->where($where);
        }
		if($keyword && $sKeyword)
		{
			$this->db->group_start();
		}
		if($keyword)
		{
			$this->db->like($keyword);
		}
        if($sKeyword)
		{
			
            foreach ($sKeyword as $key => $value)
			{
                $this->db->or_like($key,$value);
            }
        }
		if($keyword && $sKeyword)
		{
			$this->db->group_end();
		}
		
        if($order)
		{
            foreach ($order as $key => $value)
			{
                $this->db->order_by($key,$value);
            }
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
	
	
	public function join1($table1 , $table2 , $col1 , $col2 , $join , $field = "*" , $where = false , $keyword =false , $sKeyword =false , $per_page = false , $start_from = false , $order = false)
	{
        $this->db->select($field);
        $this->db->from($table1);
        $this->db->join($table2, "$table1.$col1 = $table2.$col2" , $join);
        
        if($where)
		{
            $this->db->where($where);
        }
		if($keyword && $sKeyword)
		{
			$this->db->group_start();
		}
		if($keyword)
		{
			$this->db->like($keyword);
		}
        if($sKeyword)
		{
			
            foreach ($sKeyword as $key => $value)
			{
                $this->db->or_like($key,$value);
            }
        }
		if($keyword && $sKeyword)
		{
			$this->db->group_end();
		}	

		if($per_page || $start_from)
		{
          $this->db->limit($per_page, $start_from);
        }

        if($order)
		{
            foreach ($order as $key => $value)
			{
                $this->db->order_by($key,$value);
            }
        }
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
	
	
	
	public function join2($table1 , $table2 , $table3 ,$col1 , $col2 , $col2a , $col3 , $join1 , $join2 , $field = "*" , $where = false , $keyword =false , $sKeyword =false , $per_page = false , $start_from = false , $order = false)
	{
        $this->db->select($field);
        $this->db->from($table1);
        $this->db->join($table2, "$col1 = $col2" , $join1);
        $this->db->join($table3, "$col2a = $col3" , $join2);
        
        if($where)
		{
            $this->db->where($where);
        }
		if($keyword && $sKeyword)
		{
			$this->db->group_start();
		}
		if($keyword)
		{
			$this->db->like($keyword);
		}
        if($sKeyword)
		{
			
            foreach ($sKeyword as $key => $value)
			{
                $this->db->or_like($key,$value);
            }
        }
		if($keyword && $sKeyword)
		{
			$this->db->group_end();
		}	

		if($per_page || $start_from)
		{
          $this->db->limit($per_page, $start_from);
        }

        if($order)
		{
            foreach ($order as $key => $value)
			{
                $this->db->order_by($key,$value);
            }
        }
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
	
	//adnna
	function quotation_sum($update_id=false)
    {

        $this->db->select('quotation.*,quotation_product_detail.*,SUM(amount)');
        $this->db->from('quotation');
        $this->db->join('quotation_product_detail', 'quotation_product_detail.quotation_index_id = quotation.quotation_index_id', 'INNER');

        $this->db->join('customer', 'customer.customer_index_id = quotation.customer_id', 'LEFT');
        if($update_id)
        {	
        	$this->db->where('quotation_product_detail.quotation_index_id',$update_id);
    	}
        $this->db->order_by('quotation_product_detail.quotation_product_index_id desc');
        $this->db->group_by('quotation_product_detail.quotation_index_id');
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
	function delete($table,$where)
	{
    	$this->db->where($where)->delete($table);
        //echo $this->db->last_query();die;
        if ($this->db->affected_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
    }
	
	
}
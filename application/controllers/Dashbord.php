<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashbord extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$userdata = $this->session->userdata('data');
		$userid = $userdata->id;
		if (!isset($userid)) {
			redirect('user/login');
		}
	}
	public function index()
	{
		$this->template->rander("Dashbord/index");
	}
	public function usertheme()
	{
		$result['country'] = $this->db->get('country')->result();
		$this->template->rander("Dashbord/openmodal", $result);
	}
	public function selectstate()
	{
		$country_id = $this->input->post('country');
		$result['status'] = 0;
		$select_sql = $this->db->from('state')->where('country_id', $country_id)->get()->result();

		$statelist = '<select name="state" id="state" class="custom-select">';
		foreach ($select_sql as $key => $row) {
			$statelist .= '<option value="' . $row->id . '">' . $row->name . '</option>';
		}
		$statelist .= '</select>';
		$result['status'] = 1;
		$result['list'] = $statelist;
		echo json_encode($result);
		exit();
	}
	public function selectcity()
	{
		$city_id = $this->input->post('state');
		$result['status'] = 0;
		$select_sql = $this->db->from('city')->where('state_id', $city_id)->get()->result();

		$citylist = '<select name="city" id="city" class="custom-select">';
		foreach ($select_sql as $key => $row) {
			$citylist .= '<option value="' . $row->id . '">' . $row->name . '</option>';
		}
		$citylist .= '</select>';
		$result['status'] = 1;
		$result['list'] = $citylist;
		echo json_encode($result);
		exit();
	}
	public function insertdata()
	{
		$update_id = $this->input->post('hid');
		$data = array();
		$result['status'] = 0;
		$result['msg'] = "insert Unsuccessful";
		$data['name'] = $this->input->post('fname');
		$data['contact'] = $this->input->post('contect');
		$data['email'] = $this->input->post('email');
		$data['password'] = $this->input->post('password') != '' ? md5($this->input->post('password')) : '';
		$data['gender'] = $this->input->post('gender');
		$data['country'] = $this->input->post('country');
		$data['state'] = $this->input->post('state');
		$data['city'] = $this->input->post('city');
		$data['status'] = 1;

		//file upload
		$config['upload_path'] = FCPATH . 'uploads';
		if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['overwrite'] = TRUE;
		$config['encrypt_name'] = TRUE;
		$config['remove_spaces'] = TRUE;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('fileupload')) {
			$errors = $this->upload->display_errors();
		} else {
			$image_data = $this->upload->data();
			$data['image'] = $image_data['file_name'];
		}

		// set photo name in database 		


		// send mail
		$to_name = $data['name'];
		$to_mail = $data['email'];
		ini_set('SMTP', "gmail.com");
		ini_set('smtp_port', "25");
		ini_set('sendmail_from', $to_mail);
		$this->load->library('email');

		$this->load->library('email');
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'ssl://smtp.gmail.com';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user']    = 'rupalamohit1176@gmail.com';
		$config['smtp_pass']    = 'mohit@1176';
		$config['charset']    = 'utf-8';
		$config['newline']    = "\r\n";
		$config['mailtype'] = 'text'; // or html
		$config['validation'] = TRUE; // bool whether to validate email or not
		$this->email->initialize($config);

		$this->email->set_newline("\r\n");

		$from_email = "rupalamohit@gmail.com";
		$to_email = $to_mail;
		//Load email library
		$this->load->library('email');
		$this->load->library('session');
		$this->email->from($from_email, 'Mohit Patel');
		$this->email->to($to_email, $to_name);
		$this->email->subject('palladium Hub');
		$this->email->message(' The email send using codeigniter library!!!!!');
		//Send mail
		if ($this->email->send())
			$this->session->set_flashdata("email_sent", "Congragulation Email Send Successfully.");
		else
			show_error($this->email->print_debugger());
		$this->session->set_flashdata("email_sent", "You have encountered an error");
		// $this->load->view('contact_email_form');
		if ($update_id == '') {
			$this->load->model('User_model');
			$user = $this->User_model->insert($data);
			$result['status'] = 1;
			$result['msg'] = "insert Successful";
			$result['list'] = $user;
		} else {
			if ($data['password'] == '') {
				unset($data['password']);
			}

			$this->load->model('User_model');
			$user = $this->User_model->update($data, $update_id);
			$result['status'] = 1;
			$result['msg'] = "Update Successful";
			$result['list'] = $user;
		}
		echo json_encode($result);
		exit();
	}
	public function userlist()
	{
		$data = array();
		$requestData = $this->input->post();
		$sql = $this->db->select('user.*, country.name AS country_name, state.name AS state_name, city.name AS city_name')
			->from('user')
			->join('country', 'country.id = user.country', 'left')
			->join('state', 'state.id = user.state', 'left')
			->join('city', 'city.id = user.city', 'left');
		if (isset($requestData['search']['value']) && $requestData['search']['value'] != '') {
			$search = $requestData['search']['value'];

			$sql = $this->db->like('user.name', $search);
			$this->db->or_like('user.gender',  $search);
			$this->db->or_like('user.contact',  $search);
			$this->db->or_like('user.email',  $search);
			$this->db->or_like('country.name',  $search);
			$this->db->or_like('state.name',  $search);
			$this->db->or_like('city.name',  $search);
		}
		$columns = array(
			0 => 'user.id',
			1 => 'user.name',
			2 => 'user.contact',
			3 => 'user.email',
			4 => 'user.password',
			5 => 'user.gender',
			6 => 'country.name',
			7 => 'state.name',
			8 => 'city.name',
			9 => 'user.Hobbies',
			10 => 'user.image',
			11 => 'user.created_at',
			12 => 'user.updated_at'
		);

		$order_by = '';
		if (isset($requestData['order'][0]['column']) && $requestData['order'][0]['column'] != '') {
			if (isset($requestData['order'][0]['dir']) && $requestData['order'][0]['dir'] != '') {
				$order_by = $columns[$requestData['order'][0]['column']];
				$dir = $requestData['order'][0]['dir'];
				$sql = $this->db->order_by($order_by, $dir);
			} else {
				$sql = $this->db->order_by($order_by, "DESC");
			}
		} else {
			$sql = $this->db->order_by('user.id', "DESC");
		}
		$query = $this->db->query('SELECT * FROM user');
		$count = $query->num_rows();
		$totalData = 0;
		$totalFiltered = 0;
		if ($count > 0) {
			$totalData = $count;
			$totalFiltered = $count;
		}
		if (isset($requestData['start']) && $requestData['start'] != '' && isset($requestData['length']) && $requestData['length'] != '') {
			$sql = $this->db->limit($requestData['length'], $requestData['start']);
		}
		$datalist = $sql->get()->result();
		foreach ($datalist as $key => $row) {
			$temp['id'] = $row->id;
			$temp['name'] = $row->name;
			$temp['contact'] = $row->contact;
			$temp['email'] = $row->email;
			$temp['password'] = $row->password;
			$temp['gender'] = $row->gender;
			$temp['country_name'] = $row->country_name;
			$temp['state_name'] = $row->state_name;
			$temp['city_name'] = $row->city_name;
			$statusclass = '';
			if ($row->status == 1) {
				$statusclass = 'checked';
			}
			$img = '<img src="http://localhost/CodeIgniter_demo/uploads/' . $row->image . '" class="img-thumbnail" width="300"/>';
			$temp['image'] = $img;
			$temp['status'] = '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
				  <input type="checkbox" class="custom-control-input statusswitch" ' . $statusclass . ' data-id="' . $row->id . '">
				  <label class="custom-control-label" for="customSwitch1"></label></div>';
			$temp['creaded_at'] = $row->created_at;
			$temp['update_at'] = $row->updated_at;
			$action = "<input type='button' value='Delete' class='btn btn-danger btn-sm' onclick='delData(" . $row->id . ")'>";
			$action .= '<input type="button" value="Edit" class="btn btn-info btn-sm"  onclick="editData(' . $row->id . ')">';
			$temp['action'] = $action;
			$data[] = $temp;
		}
		$json_data = array(
			"draw" => intval($requestData['draw']),
			"recordsTotal" => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data" => $data,
		);
		echo json_encode($json_data);
		exit();
	}

	public function deleteuser()
	{
		$delete_id = $this->input->post('id');
		$result['status'] = 0;
		$result['msg'] = "delete Unsuccessful ! ";

		$delete_sql = 	$this->db->query("delete from user where id='" . $delete_id . "'");
		if ($delete_sql) {
			$result['status'] = 1;
			$result['msg'] = "delete Successful ! ";
		}
		echo json_encode($result);
		exit();
	}
	public function edituser()
	{
		$edit_id = $this->input->post('id');
		$data = $this->input->post();
		$responsearray = array();
		$responsearray['status'] = 0;
		$edit_sql = $this->db->query("select * from user where id='" . $edit_id . "'")->row();
		if ($edit_sql) {
			$responsearray = array();
			$responsearray['status'] = 1;
			$responsearray['list'] = $edit_sql;
		}
		echo json_encode($responsearray);
		exit();
	}
	public function changestatus()
	{
		$data = $this->input->post();
		$status = array('status' => $data['status']);
		$this->db->where('id', $data['id']);
		$this->db->update('user', $status);
	}
}

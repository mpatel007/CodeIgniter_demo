<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function index()
	{
		$this->load->view('Signin');
	}
	public function register()
	{
		$result['country'] = $this->db->get('country')->result();
		$this->load->view('Signup', $result);
	}
	public function forgotpassword()
	{
		$this->load->view('forgotpassword');
	}
	public function login()
	{
		$this->load->view('Signin');
	}
	public function themeload()
	{
		$this->load->view('layout/index');
	}
	public function newpassword($tokens)
	{
		$data['tokens'] = $tokens;
		$this->load->view('newpassword', $data);
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

	public function insertData()
	{
		$data = array();
		$result['status'] = 0;
		$result['msg'] = "insert Unsuccessful";
		// $this->input->post('test');
		$data['name'] = $this->input->post('fname');
		$data['contect'] = $this->input->post('contect');
		// $this->load->library('form_validation');
		// $this->load->helper('form');
		// $emailunique = $this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[user.email]');
		// 	if($emailunique==true){
		// 		echo "success";
		// 	}else{
		// 		$this->index();
		// 		die();md5()
		// 	}
		$data['email'] = $this->input->post('email');
		$data['password'] = md5($this->input->post('password'));
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
		}
		// set photo name in database 		
		$data['image'] = $image_data['file_name'];
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

		$this->load->model('User_model');
		$user = $this->User_model->insert($data);
		if($user > 0) {
			$result['status'] = 1;
			$result['msg'] = "insert Successful";
			$result['list'] = $user;
		}
		echo json_encode($result);
		exit();
		return $result;
	}
	public function emailcheck()
	{
		$email  = $this->input->get_post('email');
		$checkemail = $this->db->from('user')->where('email', $email)->get()->result();
		if (count($checkemail) > 0) {
			echo json_encode(FALSE);
		} else {
			echo json_encode(true);
		}
	}
	public function forgotpasswordemailcheck()
	{
		$email  = $this->input->get_post('email');
		$checkemail = $this->db->from('user')->where('email', $email)->get()->result();
		if (count($checkemail) > 0) {
			echo json_encode(true);
		} else {
			echo json_encode(FALSE);
		}
	}
	public function newpasswordset()
	{
		$print['status'] = 0;
		$print['msg'] = "Url is expired.Please request for new Url.";
		$newpass = $this->input->post();
		$this->db->where('tokens', $newpass['tokens']);
		$this->db->update('user', array('password' => md5($newpass['password']), 'tokens' => ''));
		if ($this->db->affected_rows() > 0) {
			$print['status'] = 1;
			$print['msg'] = "Success! Your Password has been changed !!!!";
		}
		echo json_encode($print);
		exit();
	}
   // THI SIS LOGIN CODE
	public function process()
	{
		$print['status'] = 0;
		$print['msg'] = "invalid name or password";
		$user = $this->input->post('email');
		$pass = md5($this->input->post('password'));
		$array = array('email' => $user, 'password' => $pass, 'status' => 1);
		$checkemailpass	= $this->db->from('user')->where($array)->get()->row();
		if ($checkemailpass == true) {
			$this->load->library('session');
			$this->session->set_userdata(['data' => $checkemailpass]);
			$print['status'] = 1;
			$print['msg'] = " login successfully";
			// $this->session->sess_destroy($checkemailpass);
		}
		echo json_encode($print);
		exit();
	}

	public function forgotpasswordd()
	{
		$print['status'] = 0;
		$print['msg'] = "Unsuccessfully Change";
		$email = $this->input->post('email');
		$data =  $this->input->post();
		$array = array('email' => $email);
		$checkemail	= $this->db->from('user')->where($array)->get()->row();
		if ($checkemail == true) {

			$to_name = $checkemail->name;
			$to_mail = $data['email'];
			ini_set('SMTP', "gmail.com");
			ini_set('smtp_port', "25");
			ini_set('sendmail_from', $to_mail);
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
			$this->load->helper('string');
			//get random string
			$random = random_string('alnum', 16);
			$this->db->where('id', $checkemail->id);
			$this->db->update('user', array('tokens' => $random));
			$this->email->message('We sending you this email because you requested a password reset. Click on this link to create new Password: 
			"http://localhost/CodeIgniter_demo/index.php/user/newpassword/' . $random . '"');
			// $this->load->view('contact_email_form');
		}
	}

	public function logout()
	{
		$user_data = $this->session->all_userdata();
		$this->session->unset_userdata($user_data);
		$this->session->sess_destroy();
		redirect('user/login');
	}
}



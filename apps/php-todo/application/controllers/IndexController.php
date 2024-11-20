<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IndexController extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Main_model');
	}

	public function index() {
		$data['title'] = "Todolist by Jose Purba";
		$data['todos'] = $this->Main_model->get_todos();
		$this->load->view('index',$data);
	}

	public function insert() {
		if (!$this->input->is_ajax_request()) {
			exit('not allowed');
			return false;
		}
		$todoname = array('name'=>$this->input->post('todo'),'status'=>0);
		$insert_id = $this->Main_model->insert($todoname);
		$this->find_todo($insert_id);
	}

	public function done() {
		if (!$this->input->is_ajax_request()) {
			exit('not allowed');
			return false;
		}
		$id = $this->input->post('id');
		$data = array(
					'status'	=> 1,
					'done_at'	=> date("Y-m-d H:i:s"),
				);
		$this->Main_model->update($data,$id);
	}

	public function edit() {
		if (!$this->input->is_ajax_request()) {
			exit('not allowed');
			return false;
		}
		$id = $this->input->post('id');
		$todo = $this->Main_model->find_todo($id);
		echo json_encode($todo);
	}

	public function update() {
		if (!$this->input->is_ajax_request()) {
			exit('not allowed');
			return false;
		}
		$id = $this->input->post('id');
		$data = array(
					'name'	=> $this->input->post('todo'),
				);
		$this->Main_model->update($data,$id);
		$this->find_todo($id);
	}

	public function find_todo($id) {
		$todo = $this->Main_model->find_todo($id);
		echo json_encode($todo);
	}

	public function countTodos() {
		$todo = $this->Main_model->get_todos();
		echo json_encode($todo);
	}

}

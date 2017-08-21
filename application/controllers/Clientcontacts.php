<?php

class Clientcontacts extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('ajax');
		$this->load->model('clientcontacts_model');
	}

	// --------------------------------------------------------------------

	function index()
	{
		/**
		 * This controller is only used from the clients controller, and so is called directly.
		 * If anyone access it directly, let's just move them over to clients.
		 */
		redirect('clients/');
	}

	// --------------------------------------------------------------------

	function add()
	{
		$this->_validation_client_contact(); // validation info for id, first_name, last_name, email, phone

		if ($this->form_validation->run() == FALSE)
		{
			if (isAjax())
			{
				echo $this->lang->line('clients_new_contact_fail');
			}
			else
			{
				$cid = (int) $this->input->post('client_id');
				$data['client_id'] = ($cid) ? $cid : $this->uri->segment(3);
				$data['page_title'] = $this->lang->line('clients_add_contact');
				$this->load->view('clientcontacts/add', $data);
			}
		}
		else
		{
			$client_id = $this->clientcontacts_model->addClientContact(
																		$this->input->post('client_id'), 
																		$this->input->post('first_name'), 
																		$this->input->post('last_name'), 
																		$this->input->post('email'), 
																		$this->input->post('phone'),
																		$this->input->post('title')
																	);

			if (isAjax())
			{
				echo $client_id;
			}
			else
			{
				$this->session->set_flashdata('clientContact', (int) $this->input->post('client_id'));
				redirect('clients/');
			}
		}
	}

	// --------------------------------------------------------------------

	function edit()
	{
		$rules['id'] = 'trim|required|numeric';
		$fields['id'] = 'id';

		$this->_validation_client_contact(); // validation info for first_name, last_name, email, phone

		$data['id'] = (int) $this->uri->segment(3, $this->input->post('id'));

		if ($this->form_validation->run() == FALSE)
		{
			$data['clientContactData'] = $this->clientcontacts_model->getContactInfo($data['id']);
			$data['page_title'] = $this->lang->line('clients_edit_contact');
			$this->load->view('clientcontacts/edit', $data);
		}
		else
		{
			$this->clientcontacts_model->editClientContact(
															$this->input->post('id'), 
															$this->input->post('client_id'),
															$this->input->post('first_name'),
															$this->input->post('last_name'), 
															$this->input->post('email'), 
															$this->input->post('phone'),
															$this->input->post('title')
														);

			$this->session->set_flashdata('message', $this->lang->line('clients_edited_contact_info'));
			$this->session->set_flashdata('clientEdit', $this->input->post('client_id'));
			redirect('clients/');
		}
	}

	// --------------------------------------------------------------------

	function delete()
	{
		$id = ($this->input->post('id')) ? (int) $this->input->post('id') : $this->uri->segment(3);

		if ($this->clientcontacts_model->deleteClientContact($id))
		{
			if (isAjax())
			{
				return $id;
			}
			else
			{
				$this->session->set_flashdata('clientContact', $id);
				redirect('clients/');
			}
		}
		else
		{
			$this->session->set_flashdata('message', $this->lang->line('clients_contact_delete_fail'));
			redirect('clients/');
		}
	}

	// --------------------------------------------------------------------

	function _validation_client_contact()
	{
        $rules = array(
            array(
                'field' => 'client_id',
                'label' => $this->lang->line('clients_id'),
                'rules' => 'trim|required|numeric'
            ),
            array(
                'field' => 'first_name',
                'label' => $this->lang->line('clients_first_name'),
                'rules' => 'trim|required|max_length[25]'
            ),
            array(
                'field' => 'last_name',
                'label' => $this->lang->line('clients_last_name'),
                'rules' => 'trim|required|max_length[25]'
            ),
            array(
                'field' => 'email',
                'label' => $this->lang->line('clients_email'),
                'rules' => 'trim|required|max_length[127]|valid_email'
            ),
            array(
                'field' => 'phone',
                'label' => $this->lang->line('clients_phone'),
                'rules' => 'trim|max_length[20]'
            ),
            array(
                'field' => 'title',
                'label' => $this->lang->line('clients_title'),
                'rules' => 'trim'
            )
        );
		$this->form_validation->set_rules($rules);

		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
	}

}
?>

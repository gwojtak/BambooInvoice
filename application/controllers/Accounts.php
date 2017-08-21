<?php

class Accounts extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('clientcontacts_model');
	}

	// --------------------------------------------------------------------

	function index($message = '')
	{
		$this->load->library('form_validation');

		$data['accounts'] = $this->clientcontacts_model->get_admin_contacts();

		$data['page_title'] = $this->lang->line('menu_accounts');
		$data['message'] = $message;

		$client_contact_validation = array(
			array(
				'field'   => 'username',
				'label'   => 'lang:login_username',
				'rules'   => 'required|max_length[127]|valid_email'
			),
			array(
				'field'   => 'first_name',
				'label'   => 'lang:clients_first_name',
				'rules'   => 'trim|htmlspecialchars|required|max_length[25]'
			),
			array(
				'field'   => 'last_name',
				'label'   => 'lang:clients_last_name',
				'rules'   => 'trim|htmlspecialchars|required|max_length[25]'
			), 
			array(
				'field'   => 'login_password',
				'label'   => 'lang:login_password',
				'rules'   => 'required|max_length[25]'
			),
			array(
				'field'   => 'login_password_confirm',
				'label'   => 'lang:login_password_confirm',
				'rules'   => 'matches[login_password]'
			),
		);

		$this->form_validation->set_rules($client_contact_validation);

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('accounts/index', $data);
		}
		else
		{
			$client_id = $this->clientcontacts_model->addClientContact(
																		0, 
																		$this->input->post('first_name'), 
																		$this->input->post('last_name'), 
																		$this->input->post('username'), 
																		$this->input->post('phone'),
																		$this->input->post('title'),
																		1 // turn on login access
																	);

			// normally clients don't get passwords, so we need to manually set it now
			$this->clientcontacts_model->password_change($client_id, $this->input->post('login_password'));

			redirect('accounts');
		}
	}

	// --------------------------------------------------------------------

	function delete()
	{
		$id = ($this->input->get_post('id')) ? (int) $this->input->get_post('id') : $this->uri->segment(3);

		if ($this->clientcontacts_model->deleteClientContact($id))
		{
			$this->index($this->lang->line('accounts_admin_account_delete_success'));
		}
		else
		{
			$this->index($this->lang->line('accounts_admin_account_delete_fail'));
		}
	}

	// --------------------------------------------------------------------

	function _validation()
	{
        $rules = array(
            array(
                'field' => 'clientName',
                'label' => $this->lang->line('clients_name'),
                'rules' => 'trim|required|max_length[75]|htmlspecialchars'
            ),
            array(
                'field' => 'website',
                'label' => $this->lang->line('clients_website'),
                'rules' => 'trim|htmlspecialchars|max_length[150]'
            ),
            array(
                'field' => 'address1',
                'label' => $this->lang->line('clients_address1'),
                'rules' => 'trim|htmlspecialchars|max_length[100]'
            ),
            array(
                'field' => 'address2',
                'label' => $this->lang->line('clients_address2'),
                'rules' => 'trim|htmlspecialchars|max_length[100]'
            ),
            array(
                'field' => 'city',
                'label' => $this->lang->line('clients_city'),
                'rules' => 'trim|htmlspecialchars|max_length[50]'
            ),
            array(
                'field' => 'province',
                'label' => $this->lang->line('clients_province'),
                'rules' => 'trim|htmlspecialchars|max_length[25]'
            ),
            array(
                'field' => 'country',
                'label' => $this->lang->line('clients_country'),
                'rules' => 'trim|htmlspecialchars|max_length[25]'
            ),
            array(
                'field' => 'postal_code',
                'label' => $this->lang->line('clients_postal'),
                'rules' => 'trim|htmlspecialchars|max_length[10]'
            ),
            array(
                'field' => 'tax_status',
                'label' => $this->lang->line('invoice_tax_status'),
                'rules' => 'trim|htmlspecialchars|exact_length[1]|numeric|required'
            )
        );

        $this->form_validation->set_rules($rules);

		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
	}

	// --------------------------------------------------------------------

	function _validation_client_contact()
	{
        $rules = array(
            array(
                'field' => 'client_id',
                'label' => $this->lang->line('clients_id'),
                'rules' => 'trim|required|htmlspecialchars|numeric'
            ),
            array(
                'field' => 'first_name',
                'label' => $this->lang->line('clients_first_name'),
                'rules' => 'trim|required|htmlspecialchars|max_length[25]'
            ),
            array(
                'field' => 'last_name',
                'label' => $this->lang->line('clients_last_name'),
                'rules' => 'trim|required|htmlspecialchars|max_length[25]'
            ),
            array(
                'field' => 'email',
                'label' => $this->lang->line('clients_email'),
                'rules' => 'trim|required|htmlspecialchars|max_length[127]|valid_email'
            ),
            array(
                'field' => 'phone',
                'label' => $this->lang->line('clients_phone'),
                'rules' => 'trim|htmlspecialchars|max_length[20]'
            ),
            array(
                'field' => 'title',
                'label' => $this->lang->line('clients_title'),
                'rules' => 'trim|htmlspecialchars'
            )
        );

		$this->form_validation->set_rules($rules);

		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
	}
}
?>

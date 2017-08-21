<?php

class Settings extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('logo', 'file', 'form', 'path'));
		$this->load->model('settings_model');
	}

	// --------------------------------------------------------------------

	function index()
	{
		$this->_validation(); // Load the validation rules and fields

		$data['extraHeadContent'] = "<script type=\"text/javascript\" src=\"". base_url()."js/glider.js\"></script>\n";
		$data['extraHeadContent'] .= "<script type=\"text/javascript\" src=\"". base_url()."js/settings.js\"></script>\n";
		$data['extraHeadContent'] .= "<link type=\"text/css\" rel=\"stylesheet\" href=\"". base_url()."css/settings.css\" />\n";

		$data['company_logo'] = get_logo($this->settings_model->get_setting('logo'));

		if ( ! $this->form_validation->run())
		{
			// if company_name was submitted, but we're here in the failed validation statement, then it means there were errors
			if ($this->input->post('company_name'))
			{
				$data['message'] = $this->lang->line('settings_modify_fail');
			}
			else
			{
				$data['message'] = $this->session->flashdata('status');
			}

			// grab existing prefs
			$data['row'] = $this->db->get('settings')->row();
			$data['page_title'] = $this->lang->line('menu_settings');
			$this->load->view('settings/index', $data);
		}
		else
		{
			$save_invoices = ($this->input->post('save_invoices') == 'y') ? 'y' : 'n';

			$data = array(
							'company_name' => $this->input->post('company_name'),
							'address1' => $this->input->post('address1'),
							'address2' => $this->input->post('address2'),
							'city' => $this->input->post('city'),
							'province' => $this->input->post('province'),
							'country' => $this->input->post('country'),
							'postal_code' => $this->input->post('postal_code'),
							'website' => $this->input->post('website'),
							'primary_contact' => $this->input->post('primary_contact'),
							'primary_contact_email' => $this->input->post('primary_contact_email'),
							'invoice_note_default' => $this->input->post('invoice_note_default'),
							'currency_type' => $this->input->post('currency_type'),
							'currency_symbol' => $this->input->post('currency_symbol'),
							'days_payment_due' => (int) $this->input->post('days_payment_due'),
							'tax_code' => $this->input->post('tax_code'),
							'tax1_desc' => $this->input->post('tax1_desc'),
							'tax1_rate' => $this->input->post('tax1_rate'),
							'tax2_desc' => $this->input->post('tax2_desc'),
							'tax2_rate' => $this->input->post('tax2_rate'),
							'save_invoices' => $save_invoices,
							'display_branding' => $this->input->post('display_branding'),
							'new_version_autocheck' => $this->input->post('new_version_autocheck')
						);

			// Euro has conversion issues in DOMPDF, this is a fix for it
			$data['currency_symbol'] = ($data['currency_symbol'] == '€') ? '&#0128;' : $data['currency_symbol'];

			// Logo uploading
			$config['upload_path'] 		= './img/logo/';
			$config['allowed_types'] 	= 'gif|jpg';
			$config['max_size'] 		= '500'; 
			$config['max_width'] 		= '900';
			$config['max_height'] 		= '200'; // these are WAY more then someone should need for a logo

			$this->load->library('upload', $config);

			$extra_message = '';

			if ($this->upload->do_upload())
			{
				$logo_data = $this->upload->data();

				// add the logo into the settings update
				$data['logo'] = $logo_data['file_name'];
				$data['logo_pdf'] = $logo_data['file_name'];
			}

			$extra_message .= ($this->input->post('userfile') != '') ? $this->upload->display_errors('<br />') : '';

			// run the update
			$update_settings = $this->settings_model->update_settings($data);

			if ($this->db->affected_rows() == 1 OR $update_settings === TRUE)
			{
				$this->load->model('clientcontacts_model');

				// was the email address changed, and if so, be sure this isn't the demo, and also
				// update the login email

				if ($this->input->post('primary_contact_email') != '' && $this->settings_model->get_setting('demo_flag') != 'y')
				{
					$this->clientcontacts_model->email_change(1, $this->input->post('primary_contact_email'));
				}

				// was the password getting changed, and if so, be sure this isn't the demo
				if ($this->input->post('password') != '' && $this->input->post('password') == $this->input->post('password_confirm') && $this->settings_model->get_setting('demo_flag') != 'y')
				{
					$this->clientcontacts_model->password_change(1, $this->input->post('password'));
				}

				$this->session->set_flashdata('status', $this->lang->line('settings_modify_success') . ' ' . $extra_message);
			}
			else
			{
				$this->session->set_flashdata('status', $this->lang->line('settings_modify_fail') . ' ' . $extra_message);
			}

			// running a redirect here instead of loading a view because glider.js seems to freeze without the reload
			redirect('settings');
		}
	}

	// --------------------------------------------------------------------

	function _validation()
	{
        $rules = array(
            array(
                'field' => 'company_name',
                'label' => $this->lang->line('settings_company_name'),
                'rules' => "trim|max_length[75]"
            ),
            array(
                'field' => 'address1',
                'label' => $this->lang->line('clients_address1'),
                'rules' => "trim|max_length[100]"
            ),
            array(
                'field' => 'address2',
                'label' => $this->lang->line('clients_address2'),
                'rules' => "trim|max_length[100]"
            ),
            array(
                'field' => 'city',
                'label' => $this->lang->line('clients_city'),
                'rules' => "trim|max_length[50]"
            ),
            array(
                'field' => 'province',
                'label' => $this->lang->line('cients_province'),
                'rules' => "trim|max_length[25]"
            ),
            array(
                'field' => 'country',
                'label' => $this->lang->line('clients_country'),
                'rules' => "trim|max_length[25]"
            ),
            array(
                'field' => 'postal_code',
                'label' => $this->lang->line('clients_postal'),
                'rules' => "trim|max_length[10]"
            ),
            array(
                'field' => 'website',
                'label' => $this->lang->line('clients_website'),
                'rules' => "trim|max_length[150]"
            ),
            array(
                'field' => 'primary_contact',
                'label' => $this->lang->line('settings_primary_contact'),
                'rules' => "trim|required|max_length[75]"
            ),
            array(
                'field' => 'primary_contact_email',
                'label' => $this->lang->line('settings_primary_email'),
                'rules' => "trim|required|max_length[50]|valid_email"
            ),
            array(
                'field' => 'password',
                'label' => $this->lang->line('login_password'),
                'rules' => "min_length[4]|max_length[50]|alpha_dash"
            ),
            array(
                'field' => 'password_confirm',
                'label' => $this->lang->line('login_password_confirm'),
                'rules' => "matches[password]"
            ),
            array(
                'field' => 'logo',
                'label' => $this->lang->line('settings_logo'),
                'rules' => "trim|max_length[50]"
            ),
            array(
                'field' => 'invoice_note_default',
                'label' => $this->lang->line('invoice_default_note'),
                'rules' => "trim|max_length[2000]"
            ),
            array(
                'field' => 'currency_type',
                'label' => $this->lang->line('settings_currency_type'),
                'rules' => "trim|max_length[20]"
            ),
            array(
                'field' => 'currency_symbol',
                'label' => $this->lang->line('settings_currency_symbol'),
                'rules' => "ltrim|max_length[9]"
            ),
            array(
                'field' => 'days_payment_due',
                'label' => $this->lang->line('settings_payment_days'),
                'rules' => "trim|numeric|max_length[3]"
            ),
            array(
                'field' => 'tax_code',
                'label' => $this->lang->line('settings_tax_code'),
                'rules' => "trim|max_length[50]"
            ),
            array(
                'field' => 'tax1_desc',
                'label' => $this->lang->line('settings_tax1_description'),
                'rules' => "trim|max_length[50]"
            ),
            array(
                'field' => 'tax1_rate',
                'label' => $this->lang->line('settings_tax1_rate'),
                'rules' => "trim|max_length[6]"
            ),
            array(
                'field' => 'tax2_desc',
                'label' => $this->lang->line('settings_tax2_description'),
                'rules' => "trim|max_length[50]"
            ),
            array(
                'field' => 'tax2_rate',
                'label' => $this->lang->line('settings_tax2_rate'),
                'rules' => "trim|max_length[6]"
            ),
            array(
                'field' => 'save_invoices',
                'label' => $this->lang->line('settings_save_invoices'),
                'rules' => "trim|alpha|max_length[1]"
            ),
            array(
                'field' => 'display_branding',
                'label' => $this->lang->line('settings_display_branding'),
                'rules' => "trim|alpha|max_length[1]"
            ),
            array(
                'field' => 'new_version_autocheck',
                'label' => $this->lang->line('utilities_automatic_version_check'),
                'rules' => "trim|alpha|max_length[1]"
            )
        );
                
		$this->form_validation->set_rules($rules);

		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
	}
}
?>

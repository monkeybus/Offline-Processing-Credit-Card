<?php
class ControllerPaymentOfflineCC extends Controller {
	private $error = array();
	 
	public function index() { 
		$this->load->language('payment/offline_cc');

        $this->document->title = $this->language->get('heading_title');
        
        $this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {

            $this->load->model('setting/setting');
            
            $this->model_setting_setting->editSetting('offline_cc', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect(HTTPS_SERVER . 'index.php?token=' . $this->session->data['token'] . '&route=extension/payment');
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['heading_description'] = $this->language->get('heading_description');		

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
				
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_currency'] = $this->language->get('entry_currency');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_list'] = $this->language->get('button_list');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_update'] = $this->language->get('button_update');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		//$this->data['error'] = $this->error['message'];
		//$this->data['error_email'] = $this->error['email'];

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_payment'),
      		'separator' => ' :: '
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=payment/offline_cc&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);

        $this->data['action'] = HTTPS_SERVER . 'index.php?token=' . $this->session->data['token'] . '&route=payment/offline_cc';

		$this->data['cancel'] = HTTPS_SERVER . 'index.php?token=' . $this->session->data['token'] . '&route=extension/payment';
		
		if (isset($this->request->post['offline_cc_status'])) {
			$this->data['offline_cc_status'] = $this->request->post['offline_cc_status'];
		} else {
			$this->data['offline_cc_status'] = $this->config->get('offline_cc_status');
		}
		
		if (isset($this->request->post['offline_cc_geo_zone_id'])) {
			$this->data['offline_cc_geo_zone_id'] = $this->request->post['offline_cc_geo_zone_id'];
		} else {
			$this->data['offline_cc_geo_zone_id'] = $this->config->get('offline_cc_geo_zone_id'); 
		} 
		
		if (isset($this->request->post['offline_cc_sort_order'])) {
			$this->data['offline_cc_sort_order'] = $this->request->post['offline_cc_sort_order'];
		} else {
			$this->data['offline_cc_sort_order'] = $this->config->get('offline_cc_sort_order');
		}

		$this->load->model('localisation/geo_zone');
										
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
								
		$this->id       = 'content';
		$this->template = 'payment/offline_cc.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	function validate() {

		if (!$this->user->hasPermission('modify', 'payment/offline_cc')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
				
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}

}
?>
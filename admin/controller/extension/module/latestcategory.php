<?php
class ControllerExtensionModulelatestcategory extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/latestcategory');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');
		$this->load->model('catalog/category');


		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$cat_ids='';
			if($this->request->post['category_id']){
				foreach ($this->request->post['category_id'] as $key => $value) {
					if(isset($value)){
						$cat_ids.=$value.',';
					}	
				}
			}

			$cat_ids = rtrim($cat_ids,',');
			$this->request->post['category_id'] = $cat_ids;

			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule2('latestcategory', $this->request->post);
			} else {
				$this->model_setting_module->editModule2($this->request->get['module_id'], $this->request->post,'latestcategory');
			}

			$this->cache->delete('product');

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}

		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/latestcategory', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/latestcategory', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/latestcategory', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/latestcategory', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}
		
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['position'])) {
			$data['position'] = $this->request->post['position'];
		} elseif (!empty($module_info)) {
			$data['position'] = $module_info['position'];
		} else {
			$data['position'] = '';
		}

		if (isset($this->request->post['category_id'])) {
			$data['category_ids'] = $this->request->post['category_id'];
		} elseif (!empty($module_info)) {
			$data['category_ids'] = explode(',', $module_info['category_id']);
		} else {
			$data['category_ids'] = '';
		}

		if (isset($this->request->post['layout_id'])) {
			$data['layout_id'] = $this->request->post['layout_id'];
		} elseif (!empty($module_info)) {
			$data['layout_id'] = $module_info['layout_id'];
		} else {
			$data['layout_id'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($module_info)) {
			$data['sort_order'] = $module_info['sort_order'];
		} else {
			$data['sort_order'] = 5;
		}

		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($module_info)) {
			$data['width'] = $module_info['width'];
		} else {
			$data['width'] = 200;
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($module_info)) {
			$data['height'] = $module_info['height'];
		} else {
			$data['height'] = 200;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}


		//echo "<pre>";print_r($data['modules']);exit;

		$this->load->model('design/layout');
		
		$data['layouts'] = $this->model_design_layout->getLayouts();

		$this->load->model('setting/store');
		$data['stores'] = $this->model_setting_store->getStores();

		/* Show category lists to the admin panel */

		$data['categories'] = array();
					
		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {	
			$data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'],
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/latestcategory', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/latestcategory')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (isset($this->request->post['latestcategory_module'])) {
			foreach ($this->request->post['latestcategory_module'] as $key => $value) {
				if (!$value['image_width'] || !$value['image_height']) {
					$this->error['image'][$key] = $this->language->get('error_image');
				}
			}
		}		
				
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
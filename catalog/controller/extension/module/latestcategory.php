<?php
class ControllerExtensionModuleLatestcategory extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/latestcategory');
		//print_r($setting);exit;
		$this->load->model('extension/module/latestcategory');

		$this->load->model('tool/image');

		$data['latestcategorys'] = array();
		$results = $this->model_extension_module_latestcategory->getLatestCategory($setting['category_id']);
		//echo "<pre>";print_r($setting);exit;
		if ($results) {
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}

				$data['latestcategorys'][] = array(
					'thumb'       => $image,
					'name'        => $result['name'],
					'href'        => $this->url->link('product/category', 'path=' . $result['category_id'])
				);
			}
			return $this->load->view('extension/module/latestcategory', $data);
		}
	}
}

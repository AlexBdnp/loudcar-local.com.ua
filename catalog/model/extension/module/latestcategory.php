<?php
class ModelExtensionModuleLatestcategory extends Model {
	public function getLatestCategory($category_ids) {
		$category_ids= explode(',', $category_ids);
		$data['LatestCategory']=array();
		foreach ($category_ids as $key => $category_id) {
			$result ='';
			$result = $this->getCategory($category_id);
		if($result){
			$data['LatestCategory'][] = array(
				'name' => $result['name'],
				'image' => $result['image'],
				'category_id' => $result['category_id']
			);
		}
		}
		return $data['LatestCategory'];
	}

	public function getCategory($category_id,$limit=1){
		$sql = "SELECT p.product_id,p.image,cd.name,cd.category_id FROM " . DB_PREFIX . "product p  ";
		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) ";
		$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";
		$sql .= " LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = p2c.category_id)";		
		$sql .= " WHERE p.status = '1' AND p2c.category_id = '".$category_id."'AND p.date_available <= NOW() AND p.quantity > 0 AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'"; 
		$sql .= " GROUP BY p.product_id  ORDER BY RAND() LIMIT " . (int)$limit;
		$query = $this->db->query($sql);
		return $query->row;
	}
}
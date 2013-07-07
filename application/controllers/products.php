<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Catalog_MenuItem');
		$this->load->model('Product');
	}

	public function index()
	{
		$menuitems['catalog_menuitems'] = $this->Catalog_MenuItem->get_catalog_menuitems();
		$this->load->view('catalog', $menuitems);

		//$this->load->view('selected');
	}

	public function show($categoryid)
	{
		$menuitems['catalog_menuitems'] = $this->Catalog_MenuItem->get_catalog_menuitems();
		$menuitems['products'] = $this->Product->get_products($categoryid);
		$products['selected_category'] = $this->Catalog_MenuItem->get_catalog_menuitem($categoryid);

		// $products['subcats'] = array();
		// foreach ($this->Catalog_MenuItem->get_children_items($categoryid) as $subcat) {
		// 	$products['subcats'][serialize($subcat)] = $this->Product->get_products($subcat->id);
		// }

		$this->load->view('catalog', $menuitems);
		// $this->load->view('products/show', $products);

		// $this->load->view('selected');
	}

	public function edit($productid)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['title'] = 'Update a product';

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('article', 'Article', 'required');
		$this->form_validation->set_rules('cost', 'Cost', 'required');

		$menuitems['catalog_menuitems'] = $this->Catalog_MenuItem->get_catalog_menuitems();
		$obj = $this->Product->get_product($productid);

		$product['product'] = $obj;
		$product['category'] = $this->Catalog_MenuItem->get_catalog_menuitem($obj->catalog_menuitem_id);

		$this->load->view('catalog_menu', $menuitems);
		
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('products/edit', $product);
		}
		else
		{
			$this->Product->update_product($productid);
			$this->load->view('products/updated', $product);
		}
	}

	public function create($categoryid)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['title'] = 'Create a new product';
		
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('article', 'Article', 'required');
		$this->form_validation->set_rules('cost', 'Cost', 'required');
		
		$products['selected_category'] = $this->Catalog_MenuItem->get_catalog_menuitem($categoryid);
		$menuitems['catalog_menuitems'] = $this->Catalog_MenuItem->get_catalog_menuitems();
		$this->load->view('catalog_menu', $menuitems);
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('products/create', $products);
		}
		else
		{
			$this->Product->set_product($categoryid);
			$this->load->view('products/created', $products);
		}
	}

	public function select()
	{
		$id = $this->input->get('id');

		// echo $this->Product->select_product($id);

		$this->output->set_content_type('application/json')->set_output(
			json_encode(
				$this->Product->select_product($id)
			)
		);		
	}

	public function get_cart() {
	  if (isset($_COOKIE['cart'])) {
	   $cart = $_COOKIE['cart'];
	   $a = get_object_vars(json_decode($cart));
	   $summ_cost = 0;

	   echo '<div class="count" style="display:block">'.count($a).'</div>
	   <div class="window">
	    <div class="window-top"></div>
	    <div class="cart_header_h1">Ваша корзина</div>
	    <div class="cart_header_count">позиций: <span>'.count($a).'</span></div>
	     <div class="cf"></div>
	    <div class="cart_list">';
	    
	    foreach ($this->Product->get_cart_products($cart) as $item) {
	    	$summ_cost += $item->cost * $a[$item->id];
	     echo '<div class="cart_list_item" data-id='.$item->id.'>
	       <div class="cart_list_item_name">
	        <span class="c-articul">'.$item->article.'</span>
	        <span class="c-name">'.$item->name.'</span>
	       </div>
	       <div class="cart_list_item_count">
	        <span class="c-plus">+</span>
	        <span class="c-number">'.$a[$item->id].'</span>
	        <span class="c-minus">-</span>
	       </div>
	       <div class="cart_list_item_count_cost">'.number_format($item->cost * $a[$item->id], 2).' руб</div>
	       <div class="cart_list_item_remove"></div>
	      </div>
	      ';
	    }

	    echo '</div>
	    <div class="cart_item_cost">
	     <div class="cart_item_cart button">
	      Оформить заказ
	     </div>
	     <div class="cart_item_cart_name">
	      Итого:
	     </div>       
	  <div class="cart_item_cart_cost">'.number_format($summ_cost, 2).' руб</div>
	    </div>
	    
	     <div class="cf"></div>
	     
	    <div class="cart_footer_buy">Продолжить покупки</div>
	    <div class="cart_footer_clear">Очистить корзину</div>
	   </div>';
	 }
	}
		
		// if(isset($_COOKIE['cart']))
		// {
		// 	$cart = $_COOKIE['cart'];

		// 	foreach ($this->Product->get_cart_products($cart) as $item) {
		// 		echo '<div class="cart_list_item">
		// 				<div class="cart_list_item_name">
		// 					<span class="c-articul">'.$item->article.'</span>
		// 					<span class="c-name">'.$item->name.'</span>
		// 				</div>
		// 				<div class="cart_list_item_count">
		// 					<span class="c-plus">+</span>
		// 					<span class="c-number">222</span>
		// 					<span class="c-minus">-</span>
		// 				</div>
		// 				<div class="cart_list_item_count_cost">'.number_format($item->cost, 2).' руб</div>
		// 				<div class="cart_list_item_remove"></div>
		// 			</div>
		// 			';
		// 	}
		// }
		// else {
		// 	echo "В конзинке ничего нет";
		// }

}
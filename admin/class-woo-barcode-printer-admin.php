<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/shakirmengrani
 * @since      1.0.0
 *
 * @package    Woo_Barcode_Printer
 * @subpackage Woo_Barcode_Printer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Barcode_Printer
 * @subpackage Woo_Barcode_Printer/admin
 * @author     Shakir Mengrani <shakirmengrani@gmail.com>
 */
class Woo_Barcode_Printer_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->load_dependencies();
	}
	
	private function load_dependencies(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) .  'admin/class-woo-barcode-printer-settings.php';
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Barcode_Printer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Barcode_Printer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-barcode-printer-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Barcode_Printer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Barcode_Printer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name . '-file-saver', plugin_dir_url( __FILE__ ) . 'js/FileSaver.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-dom-to-image', plugin_dir_url( __FILE__ ) . 'js/dom-to-image.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-barcode', plugin_dir_url( __FILE__ ) . 'js/jquery-barcode.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-barcode-printer-admin.js', array( 'jquery', 'jquery-ui-autocomplete' ), $this->version, false );

	}

	public function wbp_get_product(){
		global $wpdb, $table_prefix;
		$keyword = isset($_POST["keyword"]) ? strtolower($_POST["keyword"]) : "";
		$search_results = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT posts.ID, posts.post_title
				FROM " . $table_prefix . "posts AS posts
				WHERE posts.post_type = 'product'
					AND posts.post_status = 'publish'
					AND ( LOWER(posts.post_title) LIKE '%{$keyword}%' );"
			)
		);
		
		$products = [];
		// Loop over search results to get products from their IDs
		foreach ( $search_results as $result ) {
			$tmpProd = wc_get_product( $result->ID );
			$products[] = array(
				"id" => $result->ID,
				"name" => $result->post_title,
				"sku" => $tmpProd->get_sku()
			);
		}
		header("Content-Type: application/json");
		echo json_encode($products, true); //returning this value but still shows 0
		wp_die();
	}

}

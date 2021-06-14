<?php
/**
 * The admin-specific settings of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Barcode_Printer
 * @subpackage Woo_Barcode_Printer/admin
 * @author     Shakir Mengrani <shakirmengrani@gmail.com>
 */
class Woo_Barcode_Printer_Settings {

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
	}

	public function setup_plugin_options_menu() {
		//Add the menu to the Plugins set of menu items
		add_plugins_page(
			'Woo Barcode Printer', 					// The title to be displayed in the browser window for this page.
			'Woo Barcode Printer',					// The text to be displayed for this menu item
			'manage_options',					// Which type of users can see this menu item
			'wbp_options',			// The unique ID - that is, the slug - for this menu item
			array( $this, 'render_settings_page_content')				// The name of the function to call when rendering this menu's page
		);
	}

    public function render_settings_page_content($arg = ''){
        ?>
		<div class="wrap" id="app">
			<div class="row">
				<div class="col-25ptg p-all-10px">
					<input type="text" class="fullWidth" name="productName" placeholder="Enter Product Name / SKU" />
				</div>
				<div class="col-25ptg p-all-10px">
					<input type="number" class="fullWidth" name="textSize" min="8" max="16" value="8" />
				</div>
				<div class="col-25ptg p-all-10px">
					<button name="generateBtn" class="primaryBtn fullWidth">Generate</button>
				</div>
				<div class="centerItem col-25ptg p-all-10px">
					<button name="downloadBtn" class="primaryBtn fullWidth">Save</button>
				</div>
			</div>
			<div id="barcodeContainer" class="row col-100ptg"></div>
		</div>
        <?php
    }
}
<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/shakirmengrani
 * @since      1.0.0
 *
 * @package    Woo_Barcode_Printer
 * @subpackage Woo_Barcode_Printer/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woo_Barcode_Printer
 * @subpackage Woo_Barcode_Printer/includes
 * @author     Shakir Mengrani <shakirmengrani@gmail.com>
 */
class Woo_Barcode_Printer_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woo-barcode-printer',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

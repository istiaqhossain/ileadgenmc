<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com/
 * @since      1.0.0
 *
 * @package    Ileadgenmc
 * @subpackage Ileadgenmc/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ileadgenmc
 * @subpackage Ileadgenmc/public
 * @author     Md Istiaq Hossain <md.istiaqhossain1990@gmail.com>
 */
class Ileadgenmc_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		// Add Footer Content
		add_action( 'wp_footer', array($this,'footer_content') );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ileadgenmc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ileadgenmc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ileadgenmc-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ileadgenmc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ileadgenmc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		/**
		 * Localization Array
		 */
		$localization_array = array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'email_unverified' => __('That email seems to be invalid.','ileadgenmc'),
			'email_subscribed' => __('Check your inbox to confirm your email and start getting exclusive offers.','ileadgenmc'),
			'other_errors' => __('Opps. Something went wrong!','ileadgenmc'),
			'localstorage' => strtolower( str_replace(' ', '-', get_bloginfo() ) ) . '-ileadgenmc-localstorage-key',
		);

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ileadgenmc-public.js', array( 'jquery' ), $this->version, true );
		
		wp_localize_script( $this->plugin_name, 'ileadgenmc', $localization_array );

		wp_enqueue_script( $this->plugin_name );

	}

	public function footer_content(){
		$html = '';
		$html .= '<div class="ileadgenmc--hellobar--wrapper">';
			$html .= '<div class="hellobar--form">';
				$html .= '<div class="hellobar--form--upper">';
					$html .= '<p>';
						$html .= __('Enter your email to get the latest offers and discounts.','ileadgenmc');
					$html .= '</p>';
					$html .= '<form>';
					$html .= '<input type="email" name="email" placeholder="'.__('Your Email','ileadgenmc').'">';
					$html .= '<button type="submit">'.__('Get it now','ileadgenmc').'</button>';
					$html .= '</form>';
				$html .= '</div>';
				$html .= '<div class="hellobar--form--lower">';
					$html .= '<p>';
					$html .= '</p>';
				$html .= '</div>';
			$html .= '</div>';
		$html .= '</div>';
		$html .= '<div class="ileadgenmc--hellobar--action">';
			$html .= '<span>';
			$html .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Layer_1" x="0px" y="0px" viewBox="0 0 511.999 511.999" style="enable-background:new 0 0 511.999 511.999;" xml:space="preserve"> <g> <g> <path d="M460.997,186.026L285.211,11.947C278.384,5.12,268.144,0,257.904,0h-1.707c-10.24,0-20.48,3.413-29.014,11.947 L51.397,186.026c-15.36,15.36-15.36,40.96,0,56.32l35.84,35.84c15.36,15.36,42.667,15.36,56.32,0l46.08-46.08v238.933 c0,22.186,17.067,40.96,37.547,40.96h49.494c22.186,0,40.96-18.773,40.96-40.96V230.4l47.787,49.493 c15.36,15.36,40.96,15.36,56.32,0l35.84-35.84C476.357,226.987,476.357,203.093,460.997,186.026z M437.104,218.453l-35.84,35.84 c-3.413,3.413-5.12,3.413-6.827,0l-76.8-78.507c-5.12-5.12-11.947-6.827-18.774-3.413c-6.827,3.413-10.24,8.534-10.24,15.36 V471.04c0,1.706-3.413,6.827-6.827,6.827h-49.493c-3.413,0-3.413-3.413-3.413-6.827V191.147c0-6.827-3.413-13.653-10.24-15.36 c-1.707-1.707-5.12-1.707-6.827-1.707c-5.12,0-8.534,1.707-11.946,5.12l-80.214,75.093c-1.706,1.707-6.827,1.707-8.533,0 l-35.84-35.84c-1.706-1.707-1.706-5.12,0-8.534L251.077,35.84c1.707-1.706,3.413-1.706,3.413-1.706h1.707 c1.707,0,3.413,0,3.413,1.706l175.786,175.787C438.811,213.334,438.811,216.746,437.104,218.453z"></path> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>';
			$html .= '</span>';
		$html .= '</div>';


		echo $html;
	}

}

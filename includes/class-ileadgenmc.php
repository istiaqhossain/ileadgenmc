<?php
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com/
 * @since      1.0.0
 *
 * @package    Ileadgenmc
 * @subpackage Ileadgenmc/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Ileadgenmc
 * @subpackage Ileadgenmc/includes
 * @author     Md Istiaq Hossain <md.istiaqhossain1990@gmail.com>
 */
class Ileadgenmc {

	protected $api_key = '';
	
	protected $list_id = '';

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ileadgenmc_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'ileadgenmc';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();


		add_action( 'wp_ajax_ileadgenmc_new_subscriber', array($this,'ileadgenmc_new_subscriber_request') );
		add_action( 'wp_ajax_nopriv_ileadgenmc_new_subscriber', array($this,'ileadgenmc_new_subscriber_request') );

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ileadgenmc_Loader. Orchestrates the hooks of the plugin.
	 * - Ileadgenmc_i18n. Defines internationalization functionality.
	 * - Ileadgenmc_Admin. Defines all hooks for the admin area.
	 * - Ileadgenmc_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ileadgenmc-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ileadgenmc-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ileadgenmc-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ileadgenmc-public.php';

		$this->loader = new Ileadgenmc_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ileadgenmc_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ileadgenmc_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Ileadgenmc_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ileadgenmc_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Ileadgenmc_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public function mc_curl_connect( $url, $request_type, $data = array() ) {
		
		if( $request_type == 'GET' )
			$url .= '?' . http_build_query($data);
	 
		$mch = curl_init();
		$headers = array(
			'Content-Type: application/json',
			'Authorization: Basic '.base64_encode( 'user:'. $this->api_key )
		);
		
		curl_setopt($mch, CURLOPT_URL, $url );
		curl_setopt($mch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($mch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
		curl_setopt($mch, CURLOPT_RETURNTRANSFER, true); // do not echo the result, write it into variable
		curl_setopt($mch, CURLOPT_CUSTOMREQUEST, $request_type); // according to MailChimp API: POST/GET/PATCH/PUT/DELETE
		curl_setopt($mch, CURLOPT_TIMEOUT, 10);
		curl_setopt($mch, CURLOPT_SSL_VERIFYPEER, false); // certificate verification for TLS/SSL connection
	 
		if( $request_type != 'GET' ) {
			curl_setopt($mch, CURLOPT_POST, true);
			curl_setopt($mch, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
		}
	 
		return curl_exec($mch);
	}

	public function mc_curl_get_lists(){
		$data = array(
			'fields' => 'lists',
		);

		$url = 'https://' . substr($this->api_key,strpos($this->api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/';

		$result = json_decode( $this->mc_curl_connect( $url, 'GET', $data) );

		$data = [];

		foreach( $result->lists as $key => $list ){
			$data[$key] = array(
				'id' => $list->id,
				'web_id' => $list->web_id,
				'name' => $list->name,
			);
		}
		
		return $data;
	}

	// TODO: 
	
	public function mc_curl_add_subscriber($subscriber,$list_id){
		$subscriber_id = md5( strtolower( $subscriber ) );

		$data = array(
			'email_address' => $subscriber,
			'status'        => 'subscribed',
		);

		$url = 'https://' . substr($this->api_key,strpos($this->api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/'.$list_id.'/members/'.$subscriber_id;

		$result = json_decode( $this->mc_curl_connect( $url, 'PUT', $data) );

		if( is_object($result) && $result->status == 'subscribed'){
			return 'Subscribed';
		}else{
			return 'Unsubscribed';
		}
	}
	
	public function ileadgenmc_new_subscriber_request(){
		
		if($_REQUEST['action'] == 'ileadgenmc_new_subscriber'){

			$data['requested_email'] = $_REQUEST['email'];

			$validator = new EmailValidator();
			$data['validation_email'] = $validator->isValid($data['requested_email'], new RFCValidation()); //true

			if($data['validation_email']){
				$data['connection_status'] = ( count($this->mc_curl_get_lists()) > 0 ) ? 'Connected' : 'Not Connected';
				
				if (!empty($this->list_id)) {
					$data['list_id'] = $this->list_id;
					
					$data['subscriber_status'] = $this->mc_curl_add_subscriber($data['requested_email'],$this->list_id);
				
				}
			}
			
			wp_send_json( $data );

		}

		die();
	}

}

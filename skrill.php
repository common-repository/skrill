<?php
/**
 * Plugin Name:         Skrill
 * Plugin URI:          http://agilesolutionspk.com/pay-by-skrill/
 * Description:         It is a Wordpress Plugin that displays pay by skrill button on any page or post via shortcode.
 * Author:              agilesolutionspk.com
 * Author URI:          http://www.agilesolutionspk.com
 * License: 			GPLv2 or later
 * Version:             1.0.0
 * Requires at least:   3.3
 * Tested up to:        3.4
 *
 */

 /*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

require_once 'class_settings_api.php';

if ( !class_exists( 'Skrill_Simple' )){
	class Skrill_Simple{
		private $settings_api;
		
		function __construct() {
			add_action( 'admin_menu', array(&$this, 'addAdminPage') );
			add_shortcode( 'skrill_simple', array(&$this, 'show_button') );
			add_action( 'admin_init', array(&$this, 'admin_init') );
		}
		function addAdminPage() {
			add_menu_page('Skrill', 'Skrill', 'edit_pages', 'Skrill_Simple', array(&$this, 'showHelp'), plugins_url('img/skrill_icon.png',__FILE__ ));
			add_submenu_page('Skrill_Simple', 'Options', 'Options', 'edit_pages', 'skrill_simple_options', array(&$this, 'options'));
		}
		function admin_init(){
			$this->init_settings();
		}
		function showHelp(){
			?>
				<h1>Skrill Plugin Help</h1>
				Here is shortcode <br><br>
				[skrill_simple amount="2.00" label="Book" description="Romeo and Juliet" ] <br><br>
				amount is the amount that you want to charge including shipping etc <br>
				
			<?php
		}
		function show_button($atts, $content = null ){
			wp_enqueue_style('skrill_simple_stylesheet', plugins_url('css/style.css', __FILE__));
			extract( shortcode_atts( array(
			  'amount' => '0',
			  'label' => 'Test Item',
			  'description' => 'Description of Test Item',
			  ), $atts ) 
			);
			$pay_to_email = $this->my_get_option('pay_to_email','skrill_simple_settings','');
			$notify_email = $this->my_get_option('notify_email','skrill_simple_settings','');
			$language	  = $this->my_get_option('language','skrill_simple_settings','');
			$currency	  = $this->my_get_option('currency','skrill_simple_settings','');
			
			if(empty($pay_to_email)){
				echo "Please Save settings in Skrill plugin";
				return;
			}
			$x ='<div class="skrill">';
			$x .='<form action="https://www.moneybookers.com/app/payment.pl" method="post" target="_blank">';
			$x .='<input type="hidden" name="pay_to_email" value="'.$pay_to_email.'">';
			$x .='<input type="hidden" name="status_url" value="'.$notify_email.'">'; 
			$x .='<input type="hidden" name="language" value="'.$language.'">';
			$x .='<input type="hidden" name="amount" value="'.$amount.'">';
			$x .='<input type="hidden" name="currency" value="'.$currency.'">';
			$x .='<input type="hidden" name="detail1_description" value="'.$label.'">';
			$x .='<input type="hidden" name="detail1_text" value="'.$description.'">';
			$x .='<input style="background: url(\''.plugins_url('img/skrill_chkout.gif', __FILE__).'\') no-repeat top left;width: 110px;height:52px;" type="submit" value="">';
			$x .='</form>';
			$x .='</div>';
			return $x;
		}
		function options(){
			echo '<div class="wrap">';
			settings_errors();

			$this->settings_api->show_navigation();
			$this->settings_api->show_forms();

			echo '</div>';
		}
		function my_get_option( $option, $section, $default = '' ) {
			$options = get_option( $section );
			if ( isset( $options[$option] ) ) {
				return $options[$option];
			}
			return $default;
		}
		function init_settings(){
			$sections = array(
				array(
					'id' => 'skrill_simple_settings',
					'title' => __( 'Skrill Settings', 'skrill_simple' )
				)
			);

			$fields = array(
				'skrill_simple_settings' => array(
					array(
						'name' => 'pay_to_email',
						'label' => __( 'Pay to Email', 'skrill_simple' ),
						'desc' => __( 'This is the Seller email address registred on Skrill for receiving payment', 'skrill_simple' ),
						'type' => 'text',
						'default' => ''
					),
					array(
						'name' => 'notify_email',
						'label' => __( 'Notify Email', 'skrill_simple' ),
						'desc' => __( 'Seller Email address where Skrill will notify on receiving payment', 'skrill_simple' ),
						'type' => 'text',
						'default' => ''
					),
					array(
						'name' => 'currency',
						'label' => __( 'Currency', 'skrill_simple' ),
						'desc' => __( 'Three letter currency code e.g USD EUR', 'skrill_simple' ),
						'type' => 'text',
						'default' => 'USD'
					),
					array(
						'name' => 'language',
						'label' => __( 'Language', 'skrill_simple' ),
						'desc' => __( 'Two letter language code e.g EN', 'skrill_simple' ),
						'type' => 'text',
						'default' => 'EN'
					)
				)
			);

			 $this->settings_api = new WeDevs_Settings_API;
			//set sections and fields
			$this->settings_api->set_sections( $sections );
			$this->settings_api->set_fields( $fields );

			//initialize them
			$this->settings_api->admin_init();

		}
	} //class ends
} //if class ends

$skrill = new Skrill_Simple();
?>

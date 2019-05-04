<?php if (!defined('ABSPATH')) exit;

/**
 * infinitishine Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package infinitishine
 */

/**
 * Hook into settings
 */
include_once(infinitishine_DIR . 'settings.php');

class infinitishine
{
    /**
     *
     */
    private $requires = array();

    /**
     *
     */
    protected static $instance;

    /**
     * prefix for all meta data
     */
    protected static $META_PREFIX = '_infinitishine_';

    /**
     * Stores theme options
     */
    protected static $options;

    /**
     * Return exising intance;
     * otherwise instantiate, then return new instance.
     */
    public static function get_instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public static function get_meta_prefix(){
        return self::$META_PREFIX;
    }

    /**
     * Api for accessing theme options
     *
     * @return Array
     */
    public static function get_options()
    {
        if (self::$options)
            return self::$options;

        self::$options = get_theme_mod('infinitishine_setting', []);
        $transform_to_terms = ['accessories_cat', 'load_primary_cat'];

        foreach ($transform_to_terms as $key => $option_key) {
            if (isset(self::$options[$option_key])) {
                if (intval(self::$options[$option_key]) > 0) {
                    self::$options[$option_key] = new \Timber\Term(get_term(intval(self::$options[$option_key])));
                }
            }
        }

        if (isset(self::$options['sort_by_metas'])) {
            self::$options['sort_by_metas'] = explode(',', self::$options['sort_by_metas']);
            self::$options['sort_by_metas'] = self::array_flatten(array_map(function ($m) {
                return [$m => ucwords(trim(str_replace('_', ' ', $m)))];
            }, self::$options['sort_by_metas']));
        }

        if (isset(self::$options['load_primary_cat_excludes'])) {
            self::$options['load_primary_cat_excludes'] = explode(',', self::$options['load_primary_cat_excludes']);
        }

        return self::$options;
    }

    /**
     * Class constructor
     * Prevent direct instantiation
     *
     * @see get_instance()
     *
     * @return null
     */
    protected function __construct()
    {
        /** Load all require files */
        $this->load_requires();

        self::get_options();

        /** Load all include files */
        $this->load_includes();

        $this->load_classes();

        $this->init();
    }

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    public function infinitishine_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Woocommerce Clean Shop, use a find and replace
         * to change 'infinitishine' to the name of your theme in all the template files.
         */
        load_theme_textdomain('infinitishine', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'infinitishine_primary' => esc_html__('Primary Menu', 'infinitishine'),
            'infinitishine_user' => esc_html__('User Menu', 'infinitishine'),
            'infinitishine_footer' => esc_html__('Footer Menu', 'infinitishine'),
            'infinitishine_helpful_links' => esc_html__('Helpful Links Menu', 'infinitishine')
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        /*
         * Enable support for Post Formats.
         * See https://developer.wordpress.org/themes/functionality/post-formats/
         */
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
        ));

        add_theme_support('woocommerce');
    }

    public function infinitishine_scripts_styles()
    {
        wp_enqueue_style('infinitishine-style', infinitishine_ASSETS_URI . "css/theme.css", array(), infinitishine_VER);

        wp_register_script('infinitishine-script', infinitishine_ASSETS_URI . 'js/app.js', array('jquery', 'bootstrap', 'vue', 'slick'), infinitishine_VER, true);
        wp_localize_script('infinitishine-script', 'APP_VARS', apply_filters('af_theme_vars', [
            'BREAKPOINTS' => [
                'breakpoint_sm' => 544,
                'breakpoint_md' => 768,
                'breakpoint_lg' => 992,
                'breakpoint_xl' => 1100,
                'breakpoint_xxl' => 1400,
                'breakpoint_sl' => 1600,
                'breakpoint_ssl' => 2100
            ]
        ]));
        wp_enqueue_script('infinitishine-script');

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }


        if (is_home() || is_front_page()) {
            wp_enqueue_script('infinitishine-home', infinitishine_ASSETS_URI . 'js/home.js', array('infinitishine-script', 'vue'), infinitishine_VER, true);
        }
    }

    public function infinitishine_admin_scripts_styles()
    {
        wp_enqueue_script('infinitishine-admin-script', infinitishine_ASSETS_URI . '/js/admin/app.admin.js', array('jquery'), '2', true);
    }

    public function add_to_context($context)
    {
        $options = self::get_options();
        //!Kint::dump($options); die();

        $context['menu']['primary'] = new TimberMenu('infinitishine_primary');
        $context['menu']['user'] = new TimberMenu('infinitishine_user');
        $context['menu']['footer'] = new TimberMenu('infinitishine_footer');
        $context['site'] = new TimberSite();
        $context['sidebar'] = Timber::get_sidebar('sidebar.php');

        if (is_front_page() || is_404()) {
            if (isset($options['pages'])) {
                $page_options = $options['pages'];
            }

            if (isset($page_options['home'])) {
                $page_options = $page_options['home'];
            } else {
                false;
            }

            if (isset($page_options['banner']) && isset($page_options['banner'][2])) {
                if (is_numeric($page_options['banner'][2]['link'])) {
                    $page_options['banner'][2]['link'] = get_permalink($page_options['banner'][2]['link']);
                }

                if (!is_object($page_options['banner'][2]['link']) && strpos($page_options['banner'][2]['link'], 'http') === false)
                    $page_options['banner'][2]['link'] = site_url($page_options['banner'][2]['link']);
            }
            if (isset($page_options)) {
                $context['page_options'] = $page_options;
            }
        }

        $context['show_sidebar'] = true;
        $context['page_header'] = true;
        $context['container'] = true;
        $context['infinitishine_URI'] = infinitishine_URI;
        $context['widgets']['footer_widget_fluid'] = Timber::get_widgets('infinitishine_footer_fluid_columns');

        if (is_array($options) && !empty($options))
            $context['options'] = array_merge($options, (array)$context['options']);

        if (isset($context['options']['logo'])) {
            $context['options']['logo'] = new \Timber\Image($context['options']['logo']);
        }

        return $context;
    }

    public function timber_term_link($link, $term)
    {
        if (self::$options['load_primary_cat'] != true)
            return $link;

        if (!isset(self::$options['load_primary_cat_excludes']))
            return $link;

        if (!is_array(self::$options['load_primary_cat_excludes']))
            return $link;

        if (empty(self::$options['load_primary_cat_excludes']))
            return $link;

        if ($term == null)
            return $link;

        if (!isset($term->taxonomy))
            return $link;

        if ($term->taxonomy !== 'brands')
            return $link;

        if (in_array($term->term_id, self::$options['load_primary_cat_excludes']))
            return $link;

        return $link . '?product-type=sheds';
    }

    public function woocommerce_checkout_fields($fields)
    {
        //stash billing company
        $b_company = $fields['billing']['billing_company'];

        //Remove billing company
        unset($fields['billing']['billing_company']);

        //add billing company to end of fields to change order or display
        $fields['billing'] = array_merge(['billing_company' => $b_company], $fields['billing']);

        return $fields;
    }

    public function sales_template_meta_fields()
    {
        $prefix = '_infinitishine_';

        /**
         * Initiate the metabox
         */
        $cmb = new_cmb2_box(array(
            'id' => '_infinitishine_sales_meta',
            'title' => __('Sales Settings', 'infinitishine'),
            'object_types' => array('page',), // Post type
            'show_on' => array('key' => 'page-template', 'value' => 'template-sales.php'),
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true, // Show field names on the left
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // Keep the metabox closed by default
        ));

        $cmb->add_field(array(
            'name' => 'Sales Category',
            'desc' => 'Restrict item to the following categories',
            'id' => '_infinitishine_sales_meta_terms',
            'taxonomy' => 'product_cat', //Enter Taxonomy Slug
            'type' => 'taxonomy_multicheck',
            // Optional :
            'text' => array(
                'no_terms_text' => 'Sorry, no categories found.' // Change default text. Default: "No terms"
            ),
            'remove_default' => 'false' // Removes the default metabox provided by WP core. Pending release as of Aug-10-16
        ));
    }

    public function shop_by_tax_template_meta_fields()
    {
        $prefix = infinitishine::get_meta_prefix();

        /**
         * Initiate the metabox
         */
        $cmb = new_cmb2_box(array(
            'id' => '_infinitishine_landing_page_meta',
            'title' => __('Landing Page Settings', 'infinitishine'),
            'object_types' => array('page',), // Post type
            'show_on' => array('key' => 'page-template', 'value' => 'template-taxonomy-landing-page.php'),
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true, // Show field names on the left
        ));

        $taxonomies = [];
        foreach (get_object_taxonomies('product') as $taxonomy) {
            $taxonomies[$taxonomy] = ucwords(str_replace('_', ' ', $taxonomy));
        }

        $cmb->add_field(array(
            'name' => 'Taxonomy',
            'desc' => 'Select Taxonomy',
            'id' => "{$prefix}taxonomy",
            'type' => 'select',
            'show_option_none' => true,
            'options' => $taxonomies
        ));

        $options = [];

        if (isset($_GET['post'])) {
            $taxonomy = get_post_meta($_GET['post'], '_infinitishine_taxonomy', true);
            $terms = get_terms([
                'taxonomy' => $taxonomy,
                'hide_empty' => true
            ]);

            foreach ($terms as $term) {
                if (!is_object($term)) {
                    continue;
                }

                $options[$term->term_id] = $term->name;
            }
        }
        $cmb->add_field(array(
            'name' => 'Select Terms',
            'desc' => 'Check Terms To Show on landing page',
            'id' => "{$prefix}taxonomy_terms",
            'type' => 'multicheck_inline',
            'options' => $options
        ));

        $cmb->add_field(array(
            'id' => self::$META_PREFIX .'sort_alphabetically',
            'name' => 'Sort Alphabetically',
            'desc' => 'Check to sort list alphabetically',
            'type' => 'checkbox'
        ));
    }

    /**
     * Custom handler for shipping rates.
     *
     * @param array $rates Array of rates found for the package
     * @param array $package The package array/object being shipped
     * @return array of modified rates
     */
    public function handle_flat_rate_shipping($rates, $package)
    {
        //If system was unable to calculate shipping rates because shipping location is in multiple locations:
        $new_rates = [];

        foreach ($package['contents'] as $cart_item_key => $cart_item) {
            $cart_item_rates = [];

            //Get Shipping Class Instance
            $shipping_class = $cart_item['data']->get_shipping_class();

            $product_id = $cart_item['product_id'];

            switch ($cart_item['data']->get_type()) {
                case 'variable':
                case 'variation':
                    $product_id = $cart_item['variation_id'];
                    break;
            }

            $zones = get_post_meta($cart_item['product_id'], self::$META_PREFIX.'shipping_zones', true);

            if (empty($zones))
                continue;

            $zones = explode(',', $zones);
            $zones = array_map(function ($z) {
                $z = WC_Shipping_Zones::get_zone($z);

                $data = $z->get_data();
                $shipping_methods = $z->get_shipping_methods();

                $z = $data;
                $z['shipping_methods'] = $shipping_methods;

                return $z;
            }, $zones);

            //remove zones not belonging to shopper's shipping destination
            $zones = array_filter($zones, function ($z) use ($package) {
                if(empty($package['destination']['state']) && !isset($_SERVER['GEOIP_REGION'])){
                    return false;
                }

                $postcode = !empty($package['destination']['postcode']) ? $package['destination']['postcode'] : $_SERVER['GEOIP_POSTAL_CODE'];
                $state = !empty($package['destination']['state']) ? $package['destination']['state'] : $_SERVER['GEOIP_REGION'];

                $customer = new WC_Customer();
                $customer->set_billing_postcode($postcode);     //for setting billing postcode
                $customer->set_shipping_postcode($postcode);    //for setting shipping postcode

                $destination_code = $package['destination']['country'] . ':' . $state;
                $return = false;

                foreach ($z['zone_locations'] as $z_loc) {
                    if ($destination_code == $z_loc->code) {
                        return true;
                    }
                }

                return $return;
            });

            // !Kint::dump($zones);

            $shipping_class = get_the_terms($product_id, 'product_shipping_class');

            if (!is_array($shipping_class))
                continue;

            if (empty($shipping_class))
                continue;

            $shipping_class = $shipping_class[0];

            foreach ($zones as $zone) {
                $shipping_methods = $zone['shipping_methods'];

                foreach ($shipping_methods as $method_key => $Method) {
                    $class_cost = intval($Method->instance_settings["class_cost_{$shipping_class->term_id}"]);

                    if ($class_cost > 0) {
                        $rate_id = $Method->id . ':' . $method_key;

                        $cart_item_rate = new WC_Shipping_Rate($rate_id, $Method->title, $class_cost, [], $Method->id);
                        $cart_item_rate->cost = $cart_item_rate->cost * $cart_item['quantity'];

                        $cart_item_rates[] = $cart_item_rate;

                        if (isset($new_rates[$rate_id])) {
                            $new_rates[$rate_id]->cost = $new_rates[$rate_id]->cost + $cart_item_rate->cost;
                        } else {
                            $new_rates[$rate_id] = $cart_item_rate;
                        }

                        break;
                    }
                }
            }
        }

        //If system was able to calculate rates
        if (empty($new_rates) && is_array($rates) && !empty($rates)) {

            //update labeling to free shipping if cost of shipping == '0.00'
            foreach ($rates as $key => $rate) {
                if ($rate->cost === '0.00') {
                    $rates[$key]->label = 'FREE SHIPPING!';
                }
            }

            return $rates;
        }

        //Combine matching shipping rates
        if (!empty($new_rates) and count($new_rates) > 1) {
            foreach ($new_rates as $key => $n_rate) {
                $key_prefix = explode(':', $key);
                $continue = false;

                foreach ($rates as $rate_key => $rate) {
                    if ($rate->method_id == $n_rate->method_id) {
                        $rates[$rate_key]->cost = $n_rate->cost + $rates[$rate_key]->cost;
                        $continue = true;
                        continue;
                    }
                }
                if ($continue) {
                    return $rates;
                }
            }
        }

        $rates = $new_rates;
        $package['rates'] = $rates;

        return $rates;
    }

    public function woocommerce_product_options_shipping($settings)
    {
        //Get all Shipping zones
        $zones = $this->get_shipping_zones();

        $zones = array_map(function ($z) {
            if (!isset($z['zone_id']) || $z['zone_id'] == null)
                return false;

            return [
                'id' => $z['zone_id'],
                'name' => $z['zone_name']
            ];
        }, $zones);

        $zones = array_filter($zones, function ($z) {
            return (is_array($z) && !empty($z));
        });

        $options = [];

        foreach ($zones as $zone) {
            $options[$zone['id']] = $zone['name'];
        }

        $html = '';

        $saved_zones = get_post_meta(get_the_ID(), self::$META_PREFIX . 'shipping_zones', true);
        if (!empty($saved_zones)) {
            $saved_zones = explode(',', $saved_zones);
        } else {
            $saved_zones = [];
        }

        echo '<div class="options_group">';
            echo '<p class="form-field dimensions_field">';
                echo '<label for="shipping_zones">Shipping Zones</label>';

                echo '<select multiple="multiple" class="multiselect wc-enhanced-select" name="shipping_zones[]" id="shipping_zones" style="width:100%" data-placeholder="Select all shipping zones">';
                    foreach ($options as $key => $value) {
                        echo '<option value="' . esc_attr($key) . '" ' . selected(in_array($key, $saved_zones), true, false) . '>' . esc_html($value) . '</option>';
                    }
                echo '</select>';
            echo '</p>';
        echo '</div>';

        return;

        global $woocommerce, $post;
        echo '<div class="options_group">';
            // Select
            woocommerce_wp_select(
                array(
                    'id' => self::$META_PREFIX .'shipping_zones',
                    'label' => __('Shipping Zone', 'bsusa'),
                    'options' => $options
                )
            );
        echo '</div>';
    }

    public function add_custom_general_fields_save($post_id)
    {
        // Select
        $front_end_unit = self::$META_PREFIX . $_POST['front_end_unit'];

        if (!empty($front_end_unit))
            update_post_meta($post_id, self::$META_PREFIX . 'front_end_unit', esc_attr($front_end_unit));

        $shipping_zones = $_POST['shipping_zones'];
        if (is_array($shipping_zones))
            $shipping_zones = implode(',', $shipping_zones);

        if (!empty($shipping_zones))
            update_post_meta($post_id, self::$META_PREFIX . 'shipping_zones', esc_attr($shipping_zones));
    }

    /**
     * Theme uses dynamic_sidebar in directly in timber .twig file: {{dynamic_sidebar('home_content')}}.
     * This has a side effect of printing the return boolean value 1 or 0 string equivalent.
     * While dynamic_sidebar is meant to use from php file, using this way in the .twig template is the only way
     * to get wp_enquey_script to properly fire and regidter conditional scripts and styles required by accompannying widget.
     */
    public function remove_true_literal_from_end_widgets($did_one, $index = 0)
    {
        if (is_home() || is_front_page()) {
            return '';
        }

        return $did_one;
    }

    protected function get_shipping_zones(): Array{
        $zones = [];

        //get shipping zones
        // Rest of the World zone
        $zone                                                = new \WC_Shipping_Zone();
        $zones[ $zone->get_id() ]                            = $zone->get_data();
        $zones[ $zone->get_id() ]['formatted_zone_location'] = $zone->get_formatted_location();
        $zones[ $zone->get_id() ]['shipping_methods']        = $zone->get_shipping_methods();

        // Add user configured zones
        $zones = array_merge( $zones, \WC_Shipping_Zones::get_zones() );

        return $zones;
    }

    protected function create_image_sizes()
    {
        add_image_size('product-thumbnail', 440, 240, true);
        add_image_size('product-feature', 640, 440, true);
    }

    private function load_classes()
    {
        foreach (glob(infinitishine_FRAMEWORK_DIR . "/classes/*.php") as $file):
            include_once($file);
        endforeach;
    }

    private function load_includes()
    {

    }

    private function load_requires()
    {

    }

    /**
     * Convert a multi-dimensional array into a single-dimensional array.
     * @author Sean Cannon, LitmusBox.com | seanc@litmusbox.com
     * @param  array $array The multi-dimensional array.
     * @return array
     */
    private static function array_flatten($array): Array
    {
        if (!is_array($array)) {
            return [];
        }

        $result = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $vkey => $val) {
                    $result[$vkey] = $val;
                }
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Bootstrap class and plug into various hooks and filters
     */
    protected function init()
    {
        $this->create_image_sizes();
        add_action('cmb2_admin_init', array(&$this, 'sales_template_meta_fields'));
        add_action('cmb2_admin_init', array(&$this, 'shop_by_tax_template_meta_fields'));

        add_action('after_setup_theme', array(&$this, 'infinitishine_setup'), 40);
        add_action('wp_enqueue_scripts', array(&$this, 'infinitishine_scripts_styles'), 40);

        add_filter('dynamic_sidebar_has_widgets', array(&$this, 'remove_true_literal_from_end_widgets'));
        add_filter('timber_context', array(&$this, 'add_to_context'), 40);
        add_filter('woocommerce_checkout_fields', array(&$this, 'woocommerce_checkout_fields'));
        add_filter( 'woocommerce_package_rates', [&$this, 'handle_flat_rate_shipping'], 10, 2 );
        add_action('woocommerce_product_options_shipping', [&$this, 'woocommerce_product_options_shipping'], 60 );
        add_action('woocommerce_process_product_meta', [&$this, 'add_custom_general_fields_save']);
        //add_filter('timber_term_link', array(&$this, 'timber_term_link'), 40, 2);
    }
}

infinitishine::get_instance();
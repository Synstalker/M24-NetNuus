<?php
/**
 * Repeatable fields widget for Koos Bar
 */
add_action('widgets_init', 'koos_bar_load_widget');

function koos_bar_load_widget()
{
    //Koos Bar SB
    register_sidebar(
        array(
            'name' => __('24:: Koos Bar', 'koosbar'),
            'id' => 'mtf_koos_bar_sb',
            'description' => __('Used to the Koos Bar', 'koosbar'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widgettitle">24:: Koos Bar',
            'after_title' => '</h2>'
        )
    );
    //Register Widget
    register_widget('Koos_Bar_Widget');
}

class Koos_Bar_Widget extends WP_Widget
{

    function __construct()
    {
        $this->textdomain = 'koosbar';
        $widget_ops = array('classname' => 'koos_bar', 'description' => 'A list of Central Bark Experts.');

        $control_ops = array('id_base' => 'koos_bar-widget');

        add_action('admin_print_scripts-widgets.php', array($this, 'load_scripts'));
        add_action('admin_print_styles-widgets.php', array($this, 'load_styles'));

        //Load frontend styles
        wp_enqueue_style('koos-bar-fe-styles', TF_KB_URL . 'assets/css/koos-bar-frontend.css', array(), '0.0.1');
        wp_enqueue_script('koos-bar-fe-script', TF_KB_URL . 'assets/js/koos-bar-frontend.js', array('jquery'), '0.0.1');

        parent::__construct('koos_bar-widget', '24:: Koos Bar', $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);
        $admin_mode = $instance['admin_mode'];
        $kb_items = $instance['koos_data'];
        $bg_color = $instance['background_color'] ? $instance['background_color'] : '#eaeaea';
        $font_color = $instance['font_color'] ? $instance['font_color'] : '#333333';

        $contrast_class = (hexdec($font_color) > 0xffffff / 2) ? 'kb-dark' : 'kb-light';

        $before_widget = $args['before_widget'];
        $after_widget = $args['after_widget'];

        if(!empty($kb_items['title'])) :

        $output = $before_widget;
        $output .= '<style>.koos_bar, #koos-bar{background-color:' . esc_attr($bg_color) . '} #koos-bar .kb-inner ul{color:' . esc_attr($font_color) . '} #koos-bar .kb-inner ul li a{color:' . esc_attr($font_color) . '}</style>';
        $output .= '<div id="koos-bar" class="kb-clearfix">';
        $output .= '<div class="kb-inner kb-mobile-hide">';

        $i = 0;

        $output .= '<span id="kb-nav-control"></span>';
        $output .= '<ul>';
        foreach ($kb_items['title'] as $item) {
            if (($i + 1) < count($kb_items['title'])) {
                $output .= '<li class="' . $contrast_class . '"><a href="' . esc_url($kb_items['url'][$i]) . '">' . esc_html($item) . '</a> <span>|</span> </li>';
            } else {
                $output .= '<li class="' . $contrast_class . '"><a href="' . esc_url($kb_items['url'][$i]) . '">' . esc_html($item) . '</a></li>';
            }
            $i++;
        }
        $output .= '</ul>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= $after_widget;


        if ($admin_mode) {
            if (current_user_can('manage_options')) {
                echo $output;
            }
        } else {
            echo $output;
        }

        endif;
    }

    function load_scripts()
    {
        wp_enqueue_script('koos-bar-script', TF_KB_URL . 'assets/js/koos-bar.js', array('jquery', 'jquery-ui-sortable'), '0.0.1');
        wp_enqueue_script('wp-color-picker');
    }

    function load_styles()
    {
        wp_enqueue_style('koos-bar-styles', TF_KB_URL . 'assets/css/koos-bar.css', array(), '0.0.1');
        wp_enqueue_style('wp-color-picker');
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['admin_mode'] = strip_tags($new_instance['admin_mode']);
        $instance['font_color'] = $new_instance['font_color'];
        $instance['background_color'] = $new_instance['background_color'];
        $instance['koos_data']['title'] = array();
        $instance['koos_data']['url'] = array();

        if (isset ($new_instance['koos_data']['title'])) {
            foreach ($new_instance['koos_data']['title'] as $value) {
                if ('' !== trim($value))
                    $instance['koos_data']['title'][] = $value;
            }
        }
        if (isset ($new_instance['koos_data']['url'])) {
            foreach ($new_instance['koos_data']['url'] as $value) {
                if ('' !== trim($value))
                    if (!preg_match("~^(?:f|ht)tps?://~i", $value)) {
                        $instance['koos_data']['url'][] = 'http://' . $value;
                    } else {
                        $instance['koos_data']['url'][] = esc_url_raw($value);
                    }

            }
        }

        return $instance;
    }

    function form($instance)
    {
        $defaults = array('admin_mode' => '1', 'background_color' => '#eaeaea', 'font_color' => '#333333');
        $instance = wp_parse_args((array)$instance, $defaults);
        $admin_mode = esc_attr($instance['admin_mode']);

        $fields = isset($instance['koos_data']) ? $instance['koos_data'] : '';

        $i = 0;

        //Was thinking of using DashIcons, but didn't have a suitable 'mover/sorter' icon
        $handle = '<span class="kb-move wp-pre-mp6 kb-sort-handle"></span>';
        $remover = '<span class="kb-remove wp-pre-mp6 kb-remove-item"></span>';

        ?>
        <!-- Only load JS if found -->
        <input type="hidden" class="mtf_koos_bar"/>
        <p>
            <input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('admin_mode'); ?>"
                   name="<?php echo $this->get_field_name('admin_mode'); ?>"
                   value="1" <?php checked('1', $admin_mode); ?> />
            <label
                for="<?php echo $this->get_field_id('admin_mode'); ?>"><?php _e('Admin mode', $this->textdomain); ?></label>
        </p>
        <p>
            <label
                for="<?php echo $this->get_field_id('font_color'); ?>"><?php _e('Font Colour', $this->textdomain); ?></label><br>
            <input class="kb-color-picker" type="text" id="<?php echo $this->get_field_id('font_color'); ?>"
                   name="<?php echo $this->get_field_name('font_color'); ?>"
                   value="<?php echo esc_attr($instance['font_color']); ?>"/>
        </p>
        <p>
            <label
                for="<?php echo $this->get_field_id('background_color'); ?>"><?php _e('Background Colour', $this->textdomain); ?></label><br>
            <input class="kb-color-picker" type="text" id="<?php echo $this->get_field_id('background_color'); ?>"
                   name="<?php echo $this->get_field_name('background_color'); ?>"
                   value="<?php echo esc_attr($instance['background_color']); ?>"/>
        </p>
        <ul class="kb-sort-list kb-clearfix">
            <?php if (!empty($fields['title'])) : foreach ($fields['title'] as $field) {
                echo '<li data-item="' . ($i + 1) . '">';
                ?>
                <!-- Handle to sort entry -->
                <?php echo $handle; ?>

                <input class="widefat kb-field kb-field-title" type="text" id="<?php echo esc_attr($field); ?>"
                       name="<?php echo esc_attr($this->get_field_name('koos_data')); ?>[title][]"
                       value="<?php echo esc_attr($field); ?>"
                       placeholder="<?php _e('Enter title', $this->textdomain); ?>"/>
                <!--<div class="kb-notifier" data-notifier="title"></div>-->

                <input class="widefat kb-field kb-field-url" type="text"
                       id="<?php echo esc_attr($fields['url'][$i]); ?>"
                       name="<?php echo esc_attr($this->get_field_name('koos_data') . '[url][]'); ?>"
                       value="<?php echo esc_attr($fields['url'][$i]); ?>" placeholder="http://www.mydestination.com/"/>
                <div class="kb-notifier" data-notifier></div>

                <!-- Used to remove entry -->
                <?php echo $remover; ?>
                <?php
                $i++;
                echo '</li>';
            }
            else :
                echo '<li data-item="1">';
                ?>
                <!-- Handle to sort entry -->
                <?php echo $handle; ?>

                <input class="widefat kb-field kb-field-title" type="text" id="<?php echo esc_attr($this->get_field_id('koos_data')); ?>[title][]"
                       name="<?php echo esc_attr($this->get_field_name('koos_data')); ?>[title][]"
                       value=""
                       placeholder="<?php _e('e.g. Enter title', $this->textdomain); ?>"/>
                <!--<div class="kb-notifier" data-notifier="title"></div>-->

                <input class="widefat kb-field kb-field-url" type="text"
                       id="<?php echo esc_attr($this->get_field_name('koos_data')); ?>[url][]"
                       name="<?php echo esc_attr($this->get_field_name('koos_data') . '[url][]'); ?>"
                       value=""
                       placeholder="e.g. http://www.mydestination.com/"/>
                <div class="kb-notifier" data-notifier></div>

                <!-- Used to remove entry -->
                <?php echo $remover; ?>
                <?php
                $i++;
                echo '</li>'; endif;
            ?>
        </ul>
        <p><a class="kb-add-item">Add Item +</a></p>
        <?php
    }
}

if (!function_exists('koos_bar_widget_body_class')) {
    function koos_bar_widget_body_class($classes)
    {
        $widgetData = get_option('widget_koos_bar-widget');
        foreach ($widgetData as $data) {
            if (is_array($data)) {
                foreach ($data as $k => $v) {
                    if ($k === 'admin_mode') {
                        if ($data['admin_mode'] !== '1') {
                            $classes[] = 'kb-active';
                        } else {
                            if (is_user_logged_in() && current_user_can('manage_options')) {
                                $classes[] = 'kb-active';
                            }
                        }
                    }
                }
            }
        }
        // return the $classes array
        return $classes;
    }

    add_filter('body_class', 'koos_bar_widget_body_class');
}
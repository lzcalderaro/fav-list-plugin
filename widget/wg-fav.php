<?php

class Fav_Wg extends WP_Widget {

    function Fav_Wg() {
        $widget_ops = array( 'classname' => 'example', 'description' => __('List Fav Posts', 'example') );
        $this->WP_Widget( 'example-widget', __('List Fav List', 'example'), $widget_ops );
    }

    function widget( $args, $instance ){
        extract( $args );

        $favList = apply_filters('widget_title', $instance['fav_list'] );

        // Display the widget title 
        if ( $favList ) echo $favList . '<br>';
        echo '<ul id="fav_list">Nenhum Post Favoritado</ul>';

    }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        //Strip tags from title and name to remove HTML
        $instance['fav_list'] = strip_tags( $new_instance['fav_list'] );
        return $instance;
    }

    function form( $instance ) {

        //Set up some default widget settings.
        $defaults = array( 'fav_list' => __('Example', 'example'), 'show_info' => true);
        $instance = wp_parse_args( (array) $instance, $defaults );
    ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'fav_list' ); ?>"><?php _e('Title:', 'example'); ?></label>
            <input id="<?php echo $this->get_field_id( 'fav_list' ); ?>" name="<?php echo $this->get_field_name( 'fav_list' ); ?>" value="<?php echo $instance['fav_list']; ?>" style="width:100%;" />
        </p>
<?php

    }

}

function fav_sidebar() {
    register_widget( 'Fav_Wg' );
}
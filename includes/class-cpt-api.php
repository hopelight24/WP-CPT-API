<?php

class CharacterAPI
{
    public function init()
    {
        add_action('rest_api_init', array($this, 'my_custom_api_init'));
    }



    public function my_custom_api_init()
    {
        register_rest_route('api/v2/', 'Characters', [
            'method' => 'GET',
            'callback' => array($this, 'get_all_characters'),
        ]);

        register_rest_route('api/v2/', 'Characters/(?P<ID>[a-zA-Z0-9-]+)', [
            'method' => 'GET',
            'callback' =>  array($this, 'get_single_character'),
        ]);
    }

    public function  get_all_characters()
    {
        $data = [];
        $i = 0;
        $args = array(
            'post_type' => 'character',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
        );

        $loop = new WP_Query($args);

        if ($loop->have_posts()) {

            while ($loop->have_posts()) {
                $loop->the_post();
                $data[$i]['id'] = get_the_ID();
                $data[$i]['customID'] = get_post_meta( get_the_ID(), 'character_id', true) ;
                $data[$i]['fullName'] = get_the_title();
                $data[$i]['imageUrl'] = get_the_post_thumbnail_url( get_the_ID() , 'full' );

                $i++;
            }
            
        }

        return $data;
    }
    public function  get_single_character(WP_REST_Request $request)
    {
        $id = $request->get_param( 'ID' );
        
        $data = [];
        $i = 0;
        $args = array(
            'post_type' => 'character',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key'     => 'character_id',
                    'value'   => $id,
                    'compare' => '=',
                ),
            ),
        );

        $loop = new WP_Query($args);

        if ($loop->have_posts()) {

            while ($loop->have_posts()) {
                $loop->the_post();
                $data[$i]['id'] = get_the_ID();
                $data[$i]['customID'] = get_post_meta( get_the_ID(), 'character_id', true) ;
                $data[$i]['fullName'] = get_the_title();
                $data[$i]['imageUrl'] = get_the_post_thumbnail_url( get_the_ID() , 'full' );

                $i++;
            }
            
        }

        return $data;
    }
}

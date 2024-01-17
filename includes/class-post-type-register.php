<?php

class CharacterRegister
{

	public $post_type = 'character';

	public function init()
	{
		add_action('init', array($this, 'register'));		
	}

	public function register()
	{
		$this->register_post_type();
	}


	protected function register_post_type()
	{
		$cpt_name = 'Character';
		$labels = array(
			'name'               => __($cpt_name, 'character'),
			'singular_name'      => __($cpt_name, 'character'),
			'add_new'            => __('Add ' . $cpt_name, 'character'),
			'add_new_item'       => __('Add '. $cpt_name , 'character'),
			'edit_item'          => __('Edit ' . $cpt_name, 'character'),
			'new_item'           => __('New ' . $cpt_name, 'character'),
			'view_item'          => __('View ' . $cpt_name, 'character'),
			'search_items'       => __('Search ' . $cpt_name, 'character'),
			'not_found'          => __('No '. $cpt_name .'s found', 'character'),
			'not_found_in_trash' => __('No '. $cpt_name .'s in the trash', 'character'),
		);

		$supports = array(
			'title',
			'editor',
			'thumbnail',
		);

		$args = array(
			'labels'          => $labels,
			'supports'        => $supports,
			'public'          => true,
			'capability_type' => 'post',
			'rewrite'         => array('slug' => $this->post_type,), // Permalinks format
			'menu_position'   => 30,
			'menu_icon'       => 'dashicons-id',
			'has_archive'     => $this->post_type,
		);

		register_post_type($this->post_type, $args);
	}
}

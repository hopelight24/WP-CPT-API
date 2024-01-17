<?php


class CharacterMetaboxes
{

	public function init()
	{
		add_action('add_meta_boxes', array($this, 'team_meta_boxes'));
		add_action('save_post', array($this, 'save_meta_boxes'),  10, 2);
	}

	public function team_meta_boxes()
	{
		$tmr = new CharacterRegister();
		add_meta_box(
			'character_fields',
			'Character Additional Fields',
			array($this, 'render_meta_boxes'),
			$tmr->post_type,
			'normal',
			'high'
		);
	}


	public function render_meta_boxes($post)
	{

		$meta = get_post_custom($post->ID);
		$character_ID = !isset($meta['character_id'][0]) ? '' : $meta['character_id'][0];

		wp_nonce_field(basename(__FILE__), 'character_fields'); ?>

		<table class="form-table">
			<tr>
				<td class="team_meta_box_td" colspan="2">
					<label for="character_id"><?php _e('ID', 'character'); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="character_id" class="regular-text" value="<?php echo $character_ID; ?>">					
				</td>
			</tr>
			

		</table>

	<?php }


	public function save_meta_boxes($post_id)
	{
		global $post;
		if (!isset($_POST['character_fields']) || !wp_verify_nonce($_POST['character_fields'], basename(__FILE__))) {
			return $post_id;
		}

		if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || (defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit'])) {
			return $post_id;
		}

		if (isset($post->post_type) && $post->post_type == 'revision') {
			return $post_id;
		}
		if (!current_user_can('edit_post', $post->ID)) {
			return $post_id;
		}

		$meta['character_id'] = (isset($_POST['character_id']) ? sanitize_text_field($_POST['character_id']) : '');

		foreach ($meta as $key => $value) {
			update_post_meta($post->ID, $key, $value);
		}
	}



	
}

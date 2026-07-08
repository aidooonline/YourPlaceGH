<?php
/**
 * Listing gallery: multiple images stored as attachment ID list.
 *
 * @package ypgh
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the gallery meta box.
 */
function ypgh_gallery_box() {
	add_meta_box( 'ypgh_gallery', __( 'Gallery', 'ypgh' ), 'ypgh_render_gallery_box', 'yp_listing', 'normal', 'default' );
}
add_action( 'add_meta_boxes', 'ypgh_gallery_box' );

/**
 * Render the gallery picker.
 *
 * @param WP_Post $post Post object.
 */
function ypgh_render_gallery_box( $post ) {
	wp_nonce_field( 'ypgh_gallery', 'ypgh_gallery_nonce' );
	$ids = get_post_meta( $post->ID, '_yp_gallery', true );
	?>
	<div class="ypgh-gallery-field">
		<input type="hidden" id="ypgh_gallery_ids" name="_yp_gallery" value="<?php echo esc_attr( $ids ); ?>">
		<div id="ypgh_gallery_preview" style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:10px;">
			<?php
			if ( $ids ) {
				foreach ( array_filter( explode( ',', $ids ) ) as $img_id ) {
					$thumb = wp_get_attachment_image( (int) $img_id, array( 80, 80 ) );
					if ( $thumb ) {
						echo '<span class="gimg" data-id="' . esc_attr( $img_id ) . '" style="position:relative;display:inline-block;">' . $thumb . '<button type="button" class="gimg-remove" style="position:absolute;top:-6px;right:-6px;background:#c1462b;color:#fff;border:0;border-radius:50%;width:18px;height:18px;cursor:pointer;line-height:1;">x</button></span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
				}
			}
			?>
		</div>
		<button type="button" class="button" id="ypgh_gallery_add"><?php esc_html_e( 'Add images', 'ypgh' ); ?></button>
	</div>
	<?php
}

/**
 * Enqueue the media picker script on listing edit screens.
 *
 * @param string $hook Admin page hook.
 */
function ypgh_gallery_admin_assets( $hook ) {
	if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
		return;
	}
	$screen = get_current_screen();
	if ( ! $screen || 'yp_listing' !== $screen->post_type ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_script( 'ypgh-gallery-admin', YPGH_URI . '/assets/js/gallery-admin.js', array( 'jquery' ), YPGH_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'ypgh_gallery_admin_assets' );

/**
 * Save gallery ids.
 *
 * @param int $post_id Post ID.
 */
function ypgh_save_gallery( $post_id ) {
	if ( ! isset( $_POST['ypgh_gallery_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['ypgh_gallery_nonce'] ), 'ypgh_gallery' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['_yp_gallery'] ) ) {
		$clean = preg_replace( '/[^0-9,]/', '', wp_unslash( $_POST['_yp_gallery'] ) ); // phpcs:ignore
		update_post_meta( $post_id, '_yp_gallery', $clean );
	}
}
add_action( 'save_post', 'ypgh_save_gallery' );

/**
 * Return gallery attachment IDs for a listing.
 *
 * @param int $post_id Post ID.
 * @return array
 */
function ypgh_gallery_ids( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$ids     = get_post_meta( $post_id, '_yp_gallery', true );
	return $ids ? array_filter( array_map( 'intval', explode( ',', $ids ) ) ) : array();
}

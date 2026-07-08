/**
 * Gallery media picker for the listing editor.
 */
(function ($) {
	'use strict';

	function ids() {
		var raw = $('#ypgh_gallery_ids').val();
		return raw ? raw.split(',').filter(Boolean) : [];
	}

	function sync(list) {
		$('#ypgh_gallery_ids').val(list.join(','));
	}

	$('#ypgh_gallery_add').on('click', function (e) {
		e.preventDefault();
		var frame = wp.media({
			title: 'Select listing images',
			multiple: true,
			library: { type: 'image' },
			button: { text: 'Add to gallery' }
		});

		frame.on('select', function () {
			var current = ids();
			frame.state().get('selection').each(function (att) {
				var id = String(att.id);
				if (current.indexOf(id) === -1) {
					current.push(id);
					var url = att.attributes.sizes && att.attributes.sizes.thumbnail
						? att.attributes.sizes.thumbnail.url
						: att.attributes.url;
					$('#ypgh_gallery_preview').append(
						'<span class="gimg" data-id="' + id + '" style="position:relative;display:inline-block;">' +
						'<img src="' + url + '" width="80" height="80" style="object-fit:cover;border-radius:4px;">' +
						'<button type="button" class="gimg-remove" style="position:absolute;top:-6px;right:-6px;background:#c1462b;color:#fff;border:0;border-radius:50%;width:18px;height:18px;cursor:pointer;line-height:1;">x</button>' +
						'</span>'
					);
				}
			});
			sync(current);
		});

		frame.open();
	});

	$('#ypgh_gallery_preview').on('click', '.gimg-remove', function () {
		var span = $(this).closest('.gimg');
		var id = String(span.data('id'));
		sync(ids().filter(function (v) { return v !== id; }));
		span.remove();
	});
})(jQuery);

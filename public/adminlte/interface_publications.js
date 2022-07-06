var newsImage = null;

function newsImageAttache(elem, e) {
	$.each(e.target.files, function (key, file) {
		if (file['size'] > max_file_size) {
			alert('Слишком большой размер файла. Максимальный размер 2Мб');
		} else {
			newsImage = file;
			renderImage(file, function (imgSrc) {
				var item = '<img class="img-polaroid" src="' + imgSrc + '" height="100" data-image="' + imgSrc + '" onclick="return popupImage($(this).data(\'image\'))">';
				$('#article-image-block').html(item);
			});
		}
	});
	$(elem).val('');
}

function update_order(form, e) {
	e.preventDefault();
	var button = $(form).find('[type="submit"]');
	button.attr('disabled', 'disabled');
	var url = $(form).attr('action');
	var data = $(form).serialize();
	sendAjax(url, data, function (json) {
		button.removeAttr('disabled');
	});
}

function categorySave(form, e) {
	var url = $(form).attr('action');
	var data = new FormData();
	$.each($(form).serializeArray(), function (key, value) {
		data.append(value.name, value.value);
	});
	if (newsImage) {
		data.append('image', newsImage);
	}
	var checkedNode = $('#tree').treeview('getChecked', 0);
	$.each(checkedNode, function (key, node) {
		if (typeof node.type != 'undefined' && node.type == 'stock_item') {
			data.append('stock_items[]', node.value);
		}
	});
	sendFiles(url, data, function (json) {
		if (typeof json.row != 'undefined') {
			if ($('#users-list tr[data-id=' + json.id + ']').length) {
				$('#users-list tr[data-id=' + json.id + ']').replaceWith(urldecode(json.row));
			} else {
				$('#users-list').append(urldecode(json.row));
			}
		}
		if (typeof json.errors != 'undefined') {
			applyFormValidate(form, json.errors);
			var errMsg = [];
			for (var key in json.errors) {
				errMsg.push(json.errors[key]);
			}
			$(form).find('.onSaveStatus').after(autoHideMsg('red', urldecode(errMsg.join(' '))));
		}
		if (typeof json.redirect != 'undefined') document.location.href = urldecode(json.redirect);
		if (typeof json.msg != 'undefined') $(form).find('.onSaveStatus').after(autoHideMsg('green', urldecode(json.msg)));
		if (typeof json.success != 'undefined' && json.success === true) {
			newsImage = null;
		}
	});
	return false;
}

function categoryDel(elem) {
	if (!confirm('Удалить категорию со всеми статьями?')) return false;
	var url = $(elem).attr('href');
	sendAjax(url, {}, function (json) {
		if (typeof json.msg != 'undefined') alert(urldecode(json.msg));
		if (typeof json.success != 'undefined' && json.success == true) {
			document.location.href = '/admin/publications/';
		}
	});
	return false;
}

function publicationSave(form, e) {
	var url = $(form).attr('action');
	var data = $(form).serialize();

	sendAjax(url, data, function (json) {
		if (typeof json.errors != 'undefined') {
			applyFormValidate(form, json.errors);
			var errMsg = [];
			for (var key in json.errors) {
				errMsg.push(json.errors[key]);
			}
			$(form).find('.onSaveStatus').after(autoHideMsg('red', urldecode(errMsg.join(' '))));
		}
		if (typeof json.redirect != 'undefined') document.location.href = urldecode(json.redirect);
		if (typeof json.msg != 'undefined') $(form).find('.onSaveStatus').after(autoHideMsg('green', urldecode(json.msg)));
	});
	return false;
}

function publicationDel(elem) {
	if (!confirm('Удалить товар?')) return false;
	var url = $(elem).attr('href');
	sendAjax(url, {}, function (json) {
		if (typeof json.msg != 'undefined') alert(urldecode(json.msg));
		if (typeof json.success != 'undefined' && json.success == true) {
			document.location.href = '/admin/publications/';
		}
	});
	return false;
}

function publicationImageUpload(elem, e) {
	var url = $(elem).data('url');
	files = e.target.files;
	var data = new FormData();
	$.each(files, function (key, value) {
		if (value['size'] > max_file_size) {
			alert('Слишком большой размер файла. Максимальный размер 2Мб');
		} else {
			data.append('images[]', value);
		}
	});
	$(elem).val('');

	sendFiles(url, data, function (json) {
		if (typeof json.html != 'undefined') {
			$('.images_list').append(urldecode(json.html));
			if (!$('.images_list img.active').length) {
				$('.images_list .img_check').eq(0).trigger('click');
			}
		}
	});
}

function publicationCheckImage(elem) {
	$('.images_list img').removeClass('active');
	$('.images_list .img_check .glyphicon').removeClass('glyphicon-check').addClass('glyphicon-unchecked');

	$(elem).find('.glyphicon').removeClass('glyphicon-unchecked').addClass('glyphicon-check');
	$(elem).siblings('img').addClass('active');

	$('#product-image').val($(elem).siblings('img').data('image'));
	return false;
}

function publicationImageDel(elem) {
	if (!confirm('Удалить изображение?')) return false;
	var url = $(elem).attr('href');
	sendAjax(url, {}, function (json) {
		if (typeof json.msg != 'undefined') alert(urldecode(json.msg));
		if (typeof json.success != 'undefined' && json.success == true) {
			$(elem).closest('.images_item').fadeOut(300, function () {
				$(this).remove();
			});
		}
	});
	return false;
}

$(document).ready(function () {
	$('#pubs-tree').jstree({
		"core": {
			"animation": 0,
			"check_callback": true,
			'force_text': false,
			"themes": {"stripes": true},
			'data': {
				'url': function (node) {
					if (node.id === '#') {
						return '/admin/publications/get-categories/'
					} else {
						// return  '/admin/publications/get-publications/' + node.id;
					}
				},
			},
		},
		"plugins": ["contextmenu", "dnd", "state", "types"],
		"contextmenu": {
			"items": function ($node) {
				var tree = $("#tree").jstree(true);
				return {
					"CreateCat": {
						"icon": "fa fa-plus text-blue",
						"label": "Создать категорию",
						"action": function (obj) {
							// $node = tree.create_node($node);
							document.location.href = '/admin/publications/category-edit'
						}
					},
					"CreatePub": {
						"icon": "fa fa-plus text-blue",
						"label": "Создать статью",
						"action": function (obj) {
							// $node = tree.create_node($node);
							document.location.href = '/admin/publications/publication-edit'
						}
					},
					"Edit": {
						"icon": "fa fa-pencil text-yellow",
						"label": "Редактировать элемент",
						"action": function (obj) {
							// tree.delete_node($node);
							// console.log($node.parent);
							const id = $node.id.replace(/[^0-9]/g, "") //оставляем в id только цифры
							if ($node.parent === '#') {
								document.location.href = '/admin/publications/category-edit/' + id
							} else {
								document.location.href = '/admin/publications/publication-edit/' + id
							}
						}
					},
					"Remove": {
						"icon": "fa fa-trash text-red",
						"label": "Удалить элемент",
						"action": function (obj) {
							const id = $node.id.replace(/[^0-9]/g, "") //оставляем в id только цифры
							if ($node.parent === '#') {
								if (confirm("Действительно удалить всю категорию?")) {
									var url = '/admin/publications/category-delete/' + id;
									sendAjax(url, {}, function () {
										document.location.href = '/admin/publications';
									})
								}
								document.location.href = '/admin/publications/category-delete/' + id
							} else {
								if (confirm("Действительно удалить cтатью?")) {
									var url = '/admin/publications/publication-delete/' + id;
									sendAjax(url, {}, function () {
										document.location.href = '/admin/publications';
									})
								}
							}
						}
					}
				};
			}
		}
	}).bind("move_node.jstree", function (e, data) {
		treeInst = $(this).jstree(true);
		parent = treeInst.get_node(data.parent);
		var d = {
			'id': data.node.id,
			'parent': (data.parent == '#') ? 0 : data.parent,
			'sorted': parent.children
		};
		sendAjax('/admin/publications/category-reorder', d);
	}).on("activate_node.jstree", function (e, data) {
		const id = data.node.id.replace(/[^0-9]/g, "") //оставляем в id только цифры
		if (data.event.button == 0 && data.node.parent === '#') {
			//переход к редактированию категории
			window.location.href = '/admin/publications/category-edit/' + id;
		}
		if (data.event.button == 0 && data.node.parent !== '#') {
			//переход к редактированию статьи
			window.location.href = '/admin/publications/publication-edit/' + id;
		}
	});
});

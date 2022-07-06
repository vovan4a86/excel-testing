var price = null;

function stockPriceAttache(elem, e) {
	$.each(e.target.files, function (key, file) {
		if (file['size'] > max_file_size) {
			alert('Слишком большой размер файла. Максимальный размер 2Мб');
		} else {
			price = file;
			renderImage(file, function () {
				$(elem).closest('.form-group').find('#article-image-block').text(file.name);
			});
		}
	});
	$(elem).val('');
}

function stockSave(form, e) {
	e.preventDefault();
	let url = $(form).attr('action');
	let submitBtn = $(form).find('[type=submit]');
	submitBtn.attr('disabled', 'disabled');
	submitBtn.text('Сохранение...');
	var data = new FormData(form);
	if (price) {
		data.append('fileXls', price);
	}

	sendFiles(url, data, function (json) {
		if (typeof json.errors != 'undefined') {
			applyFormValidate(form, json.errors);
			var errMsg = [];
			for (var key in json.errors) {
				errMsg.push(json.errors[key]);
			}
			$(form).find('[type=submit]').after(autoHideMsg('red', urldecode(errMsg.join(' '))));
		} else {
			if (typeof json.redirect != 'undefined') document.location.href = urldecode(json.redirect);
			if (typeof json.msg != 'undefined') $(form).find('[type=submit]').after(autoHideMsg('green', urldecode(json.msg)));
			price = null;
		}
	});

	submitBtn.removeAttr('disabled');
	submitBtn.text('Сохранить');
	return false;
}


$(document).ready(function () {
	if ($('#tag_name')) {
		init_autocomplete($('#tag_name'));
	}
});

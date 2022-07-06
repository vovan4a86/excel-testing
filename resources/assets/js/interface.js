function sendAjax(url, data, callback, type){
    data = data || {};
    if (typeof type == 'undefined') type = 'json';
    $.ajax({
        type: 'post',
        url: url,
        data: data,
        dataType: type,
        beforeSend: function(request) {
            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        },
        success: function(json){
            if (typeof callback == 'function') {
                callback(json);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
            alert('Не удалось выполнить запрос! Ошибка на сервере.');
        },
    });
}
function sendFiles(url, data, callback, type){
    if (typeof type == 'undefined') type = 'json';
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        cache: false,
        dataType: type,
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        beforeSend: function(request) {
            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        },
        success: function(json, textStatus, jqXHR)
        {
            if (typeof callback == 'function') {
                callback(json);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            alert('Не удалось выполнить запрос! Ошибка на сервере.');
        }
    });
}

function popup(html) {
    $('#popupWindow .text-center').html(html);
    $.magnificPopup.open({
        items: {
            src: '#popupWindow',
        },
        type: 'inline'
    });
}

function resetForm(form) {
    $(form).trigger('reset');
    $(form).find('.err-msg-block').remove();
    $(form).find('.invalid').attr('title', '').removeClass('invalid');
}

function applyFormValidate(form, ErrMsg){
    $(form).find('.invalid').attr('title', '').removeClass('invalid');
    for (var key in ErrMsg) {
        $(form).find('[name="'+urldecode(key)+'"]').addClass('invalid').attr('title', urldecode(ErrMsg[key].join(' ')));
    }
    $(form).find('.invalid').eq(0).trigger('focus');
}

function urldecode(str) {
    return decodeURIComponent((str+'').replace(/\+/g, '%20'));
}

function validField(elem) {
    if (!elem.val()) {
        elem.addClass('invalid');
        return false;
    } else {
        elem.removeClass('invalid').removeAttr('title');
        return true;
    }
}

function validForm(form, fields) {
    var valid = true;
    for (var key in fields) {
        var field = form.find('[name="' + fields[key] + '"]');
        if (!validField(field)) {
            valid = false;
        }
    }
    if (!valid) {
        form.find('.invalid').eq(0).focus();
        return false;
    }
    return true;
}

function sendCallback(form, e) {
    e.preventDefault();
    form = $(form);
    var data = form.serialize();
    var url = $(form).attr('action');
    form.find('.err-msg-block').remove();
    sendAjax(url, data, function (json) {
        if (typeof json.errors != 'undefined') {
            validForm(form, json.errors);
            var errMsg = [];
            for (var key in json.errors) {
                errMsg.push(json.errors[key]);
            }
            var strError = errMsg.join('<br />');
            form.find('.f_tit, .form__title').after('<div class="err-msg-block">' + strError + '</div>');
        } else {
            resetForm(form);
            popup('Спасибо за заявку, в ближайшее время мы вам ответим!');
        }
    });
}

function moreNews(el) {
    var url = $(el).data('url');
    var $more_lnk = $('.js_more_lnk');
    var $js_wait = $('.js_wait');
    $more_lnk.hide();
    $js_wait.show();
    sendAjax(url,{},function(json){
        $js_wait.hide();
        if(typeof json.items !== 'undefined'){
            $.each(json.items, function(n, el){
                var node = createElementFromHTML(el);
                $bricklayer.append(node);
            })
        }
        if(typeof json.next_count !== 'undefined' && json.next_count > 0){
            $more_lnk.data('url', json.next_page);
            $more_lnk.find('span').text(json.next_count);
            $more_lnk.show();
        }
    });
}

function createElementFromHTML(htmlString) {
    var div = document.createElement('div');
    div.innerHTML = htmlString.trim();

    // Change this to div.childNodes to support multiple top-level nodes
    return div.firstChild;
}

function removeFromCart(el){
    if(!confirm('Действительно удалить позицию?')) return;
    let id = $(el).closest('tr').data('id');
    let url = '/ajax/remove-from-cart/' + id;
    sendAjax(url, {}, function(json){
        if(typeof json.header_order !== 'undefined'){
            $('.header__order').replaceWith(json.header_order);
        }
        $(el).closest('tr').fadeOut(300, function(){ $(this).remove(); });
    });
}

function sendOrder(form, e){
    e.preventDefault();
    let data = $(form).serialize();
    let url = $(form).attr('action');
    sendAjax(url, data, function(json){
        if(typeof json.errors != "undefined"){
            var errMsg = [];
            for (var key in json.errors) {
                errMsg.push(json.errors[key]);
            }
            var strError = errMsg.join('<br />');
            form.find('.page__block-title').after('<div class="err-msg-block">' + strError + '</div>');
        } else {
            $.magnificPopup.open({
                items: {
                    src: '#success_order'
                },
                type: 'inline'
            });
        }
    });
}

$(document).ready(function(){
    $('.js-to-cart').click(function(){
        let id = $(this).data('id');
        let url = '/ajax/to-cart/' + id;
        sendAjax(url, {}, function(json){
           if(typeof json.header_order !== 'undefined'){
               $('.header__order').replaceWith(json.header_order);
           }
        });
    })
});
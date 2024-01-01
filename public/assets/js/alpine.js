// PAGE LOADING
function loading() {
    $("#global-loader").fadeIn('slow');
}
function loaded() {
    $("#global-loader").fadeOut();
}
function _openForm(url, title) {
    _browser(url, {
        'class': 'modal-fullscreen',
        'title': title,
        'style': '',
    });
}

function _open(url, title, tagert) {
    var browser = $(tagert);
    var frame = browser.find('iframe');

    browser.find('.modal-title').html(title);
    browser.find('.btn-close').on('click', function () {
        frame.attr('src', '');
    });
    frame.attr('src', url);
    browser.modal('show');
}


function _browser(url, attr = { 'class': ' ', 'style': ' ' }) {
    var modal = $("#browser").find('.modal-dialog');
    modal.attr('class', 'modal-dialog ' + attr.class);
    modal.attr('style', attr.style);
    _open(url, attr.title, '#browser');
}

function _exit() {
    var browser = $('#browser');
    var frame = browser.find('iframe');
    frame.attr('src', '');
    browser.modal('hide');
}
async function _draft(act, icon, title) {
    item = await _wjson(act);
    _openForm(item.edit, '<i class="' + icon + ' me-2 "></i>' + title);
}

function _destroy(action) {
    if (confirm('Data will drop! Are you sure?')) {
        _submit({
            'method': 'DELETE',
            'action': action
        }).done(function (data) {
            notif({
                msg: 'Deleted',
                type: 'success'
            });
            if(reload) reload();
        }).fail(function (res) {
            console.log(res);
        });
    }
}
function _submitId(fm) {
    var data = {
        'action': $(fm).attr("_action"),
        'inputs': $(fm).find(':input'),
        'method': $(fm).attr("_method") ? $(fm).attr("_method") : 'POST'
    };

    return _submit(data);
}

function _drapdrop(items, dragging, dropping) {
    if (dragging !== null && dropping !== null) {
        if (dragging < dropping) {
            items = [
                ...items.slice(0, dragging),
                ...items.slice(dragging + 1, dropping + 1),
                items[dragging],
                ...items.slice(dropping + 1)
            ];
        } else {
            items = [
                ...items.slice(0, dropping),
                items[dragging],
                ...items.slice(dropping, dragging),
                ...items.slice(dragging + 1)
            ];
        }
        dropping = null;
    }
    return items;
}

function _submit(data) {
    var fd = new FormData();
    var method = data.method ? data.method : 'POST';
    var action = data.action ? data.action : '';
    fd.append('_method', method);

    if (data.inputs) {
        $.each(data.inputs, function () {
            inp = $(this).attr('name');
            type = $(this).attr('type');
            val = $(this).val();

            switch (type) {
                case "file":
                    files = $(this)[0].files;
                    $.each(files, function (i, file) {
                        fd.append(inp, file, file.name);
                    })
                    break;
                case "checkbox":
                    chck = $(this).is(":checked");
                    if (chck) fd.append(inp, val);
                    break;
                default:
                    fd.append(inp, val);
            }

        })
    }

    //loading();

    return $.ajax({
        headers: { 'X-CSRF-TOKEN': _token() },
        type: 'POST',
        url: action,
        data: fd,
        processData: false,
        contentType: false,
        cache: false,
    });
}

function _token() {
    return $('meta[name="csrf-token"]').attr('content');
}

function _setting(attr) {
    return $('meta[name="setting"]').attr(attr);
}


function _inputs(tagert) {
    return $(tagert).find(':input');
}

function _url(path) {
    root = _setting('home');
    return root + '/' + path;
}

async function _wjson(url) {
    return (await fetch(url)).json();
}

async function _config() {
    url = _setting('config');
    return _wjson(url);
}

async function _fetch(query = '') {
    url = _setting('fetch') + query;
    return _wjson(url);
}

function _chunk(data, size) {
    chunks = [];
    for (let i = 0; i < data.length; i += size) {
        const chunk = data.slice(i, i + size);

        chunks.push(chunk);
    }
    return chunks;
}
// function _postback() {
//     var data = {
//         'action': _url('!/postback'),
//         'inputs': _inputs('#app'),
//         'method': 'POST'
//     };
//     return _submit(data);
// }

function _apost(action, formdata) {
    return $.ajax({
        headers: { 'X-CSRF-TOKEN': _token() },
        type: 'POST',
        url: action,
        data: formdata,
        processData: false,
        contentType: false,
        cache: false,
    });
}


function _summernoteUpload(files, summernote, url) {
    fd = new FormData();
    for (var x = 0; x < files.length; x++) {
        fd.append("media[]", files[x]);
    }
 
    _apost(url, fd).done(function (data) {
       
        src = data.src
        src.filter(el => Object.keys(el).length).map((url) => {
            summernote.summernote('editor.insertImage', url);
            console.log(url);
        })

    }).fail(function (res) {
        console.log(res);
    });
}

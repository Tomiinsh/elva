function updateItems(r) {
    _opts.items.available = r.available;
    _opts.items.assigned = r.assigned;
    search('available');
    search('assigned');
}

$('.btn-assign').click(function () {
    var target = $(this).data('target');
    var items = $('select.list[data-target="' + target + '"]').val();

    if (items && items.length) {
        $.post($(this).attr('href'), {items: items}, function (r) {
            updateItems(r);
        });
    }
    return false;
});

$('.search[data-target]').keyup(function () {
    search($(this).data('target'));
});

function search(target) {
    var list = $('select.list[data-target="' + target + '"]');
    list.html('');
    var q = $('.search[data-target="' + target + '"]').val();
    var items = _opts.items[target];

    $.each(items, function (index) {
        if (q.length === 0 || items[index].includes(q)) {
            $('<option>').text(items[index]).val(index).appendTo(list);
        }
    });
}

search('available');
search('assigned');
$(function () {
    $(document).on('click', 'li[href], span[href]', function () {
        window.location.href = $(this).attr('href');
    });

    $(document).on('click', '.mdl-select li[data-value]', function () {
        var val = $(this).data('value');
        var label = $(this).text();
        var parent = $(this).parent().parent().parent();
        var select = parent.find('select');
        var input = parent.find('input.mdl-textfield__input');

        select.val(val);
        input.val(label);
    });

    $(document).ready(function () {
        $('.mdl-select').each(function (x, item) {
            var option = $('select option:selected', item);

            if (option) {
                $(item).find('input').val(option.text());
            }
        });
    });
});

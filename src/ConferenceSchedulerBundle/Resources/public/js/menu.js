    $(function () {
        $(document).on('click', 'li[href], span[href]', function () {
            window.location.href = $(this).attr('href');
        });
    });

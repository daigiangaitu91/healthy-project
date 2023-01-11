$(function () {
    $('.document-listing a[data-toggle="file"]').on('click', function (e) {
        e.preventDefault();
        $('.document-listing .tree li').removeClass('active');
        $(this).parent('li').addClass('active');

        $('.document-listing .file-listing .message').html('Loading...');
        var path = $(this).data('path');
        var module = $(this).data('module');

        $.ajax({
            type: 'GET',
            url: '/core/document-management/file-list',
            data: 'path=' + path + '&module=' + module + '&' + $('#filter-form').serialize(),
            success: function (result) {
                $('.document-listing .file-listing').html(result);
            }
        });
    });
});

$(function(){
    $('.document-listing .folder-listing .panel-body .tree li.opened').addClass('has-file').parents('.panel-collapse').addClass('in');
    $('.document-listing .folder-listing .panel-body .tree > li.opened:first > a').trigger('click');
});

$(function () {
    var from_date = $('.calendar.from').val();

    $('.calendar.to').datetimepicker({
        minView: 2,
        autoclose: true,
        format: 'dd-mm-yyyy'
    });

    if ($('.calendar.to').length && from_date.length > 0) {
        $('.calendar.to').datetimepicker('setStartDate', from_date);
    }

    $('.calendar.from').datetimepicker({
        minView: 2,
        autoclose: true,
        format: 'dd-mm-yyyy'
    })
        .on('changeDate', function (ev) {
            var startDate = ev.date.getFullYear() + '-' + (ev.date.getMonth() + 1) + '-' + ev.date.getDate();
            var to_date = $(this).parents('form').find('.calendar.to');
            to_date.val('');
            to_date.datetimepicker('update');
            to_date.datetimepicker('setStartDate', startDate);
            to_date.datetimepicker('setInitialDate', startDate);
            to_date.datetimepicker('show');
        });
});
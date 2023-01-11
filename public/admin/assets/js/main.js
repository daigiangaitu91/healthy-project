(function ($) {

    $('[data-toggle="tooltip"]').tooltip();
    //$('.sidebar').mCustomScrollbar();
    $('.sidebar .nav-sidebar li a.dropdown-toggle').removeAttr('data-toggle');

    $(document).ready(function () {

        if ($('#ckeditor').length) {
            CKEDITOR.replace('ckeditor');
        }

        $('.nav-tabs a').on('click', function () {
            if (!($(this).data('toggle') && $(this).data('toggle') == 'modal')) {
                location.href = $(this).attr('href');
            }
        });

        var hash = window.location.hash;
        if (hash.length > 0) {
            $('a[href="' + hash + '"]').tab('show')
        }

        $(document).on('click', 'button.clear', function (event) {
            event.preventDefault();
            var form = $(this).parents('form');
            form.find('input[type="text"], input[type="checkbox"]').attr('disabled', 'disabled');
            form.find('select').attr('disabled', 'disabled');
            form.find('.btn-filter').addClass('disabled');
            form.trigger('submit');
        });

        $('.calendar').next('.input-group-addon').on('click', function (event) {
            event.preventDefault();
            $(this).prev('.calendar').trigger('focus');
        });

        $(document).on('focus', '.calendar', function () {
            $(this).datetimepicker({
                format: 'dd-mm-yyyy',
                minView: 2,
                autoclose: 1
            })
        });

        $(document).on('focus', '.datetime', function () {
            $(this).datetimepicker({
                format: 'dd-mm-yyyy hh:ii',
                autoclose: 1,
                minuteStep: 10
            })
        });

        $('.select2').select2();
        $("#product-vendor_id").select2({
            placeholder: "Selects Vendor"
        });


        $('.tagging').select2({
            placeholder: 'Please input...',
            tags: true
        });

        $('.filter form select, .filter form .auto').on('change', function () {
            $(this).parents('form').trigger('submit');
        });

        $('.modal-ajax').on('shown.bs.modal', function (e) {
            var button = $(e.relatedTarget);
            var href = button.attr('href');

            if (!href && e.relatedTarget.localName.toLowerCase() != 'a') {
                href = button.find('a').first().attr('href');
            }

            if (typeof href !== 'undefined') {
                var modal = $(this)
                modal.find('.modal-body').html('<div class="loading"></div>.');

                if (button.data('header')) {
                    modal.find('.modal-header h4').text(button.data('header'));
                }

                $.ajax({
                    type: 'POST',
                    url: href,
                    success: function (result) {
                        modal.find('.modal-body').html(result);

                        modal.find('.select2').select2({
                            placeholder: 'Please select...'
                        });

                        modal.find('.tagging').select2({
                            placeholder: 'Please select...',
                            tags: true
                        });
                    }
                });
            }
        });

        $(document).on('hidden.bs.modal', '.modal', function () {
            $('.modal.in').length && $(document.body).addClass('modal-open');
        });

        $(document).on('click', '.input-group-addon', function (event) {
            event.preventDefault();
            $(this).parents('.input-group').find('input').first().focus();
        });

        if ($(window).width() < 992) {
            localStorage.setItem('sidebar-collapse', '1');
        }

        collapseSidebar();

        $('.sidebar-toggle').on('click', function (event) {
            event.preventDefault();
            $('body').toggleClass('collapse-sidebar');
            if ($('body').hasClass('collapse-sidebar')) {
                localStorage.setItem('sidebar-collapse', '1');
            }
            else {
                localStorage.setItem('sidebar-collapse', '0');
            }

            collapseSidebar();

        });

        $('.filter .btn-filter.dropdown-toggle').each(function () {
            var selected_label = [];

            $(this).next(".dropdown-menu").find("input[type='checkbox']:checked").each(function (index) {
                selected_label[index] = $(this).parents('label').text();
            });

            if (selected_label.length) {
                $(this).find('span.selected').text(selected_label.join(', '));
            }
        });

        $('.filter .dropdown-menu input').on('change', function () {
            var selected_label = [];

            $(this).parents(".dropdown-menu").find("input[type='checkbox']:checked").each(function (index) {
                selected_label[index] = $(this).parents('label').text();
            });

            var label = $(this).parents(".input-group").find('span.selected');
            if (selected_label.length) {
                label.text(selected_label.join(', '));
            }
            else {
                label.text('All');
            }
        });

        $(document).on('click', '.filter .dropdown-menu', function (e) {
            e.stopPropagation();
        });

        $('.sidebar li.parent > a').on('click', function (e) {
            e.preventDefault();
            $(this).next('.dropdown-menu').slideToggle();
            $(this).parent('li').toggleClass('active');
        });

    });

    $(window).resize(function () {
        collapseSidebar();
        if ($(window).width() < 992) {
            localStorage.setItem('sidebar-collapse', '1');
        }
    });

    function collapseSidebar() {
        var collapse = localStorage.getItem('sidebar-collapse');

        if (collapse == 1) {
            $('body').addClass('collapse-sidebar');
            $('.sidebar-toggle').removeClass('maximize').addClass('minimize');
            //$('.sidebar').mCustomScrollbar('destroy');
        }
        else {
            $('body').removeClass('collapse-sidebar');
            $('.sidebar-toggle').removeClass('minimize').addClass('maximize');
            //$('.sidebar').mCustomScrollbar();
        }
    }

})(jQuery);

var loadFile = function (event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
};

function uploadFile() {
    jQuery('#upload-image').click()
}
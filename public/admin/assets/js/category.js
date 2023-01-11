/**
 *
 * @type {{getProduct: *, getUOM: *, getSubCategory: *, getVendor: *}}
 */
let category = (function ($, window, undefined) {
    'use strict';

    let getSubCategory = function (element) {
        let depends = $(element).data('depends');
        let href = $(element).data('href');
        $(document).on("change", depends, function (e) {
            e.preventDefault();
            let depdrop_parents = [$(this).val()];
            $.ajax({
                type: 'POST',
                data: {depdrop_parents: depdrop_parents},
                url: href
            }).done(function (response) {
                initOption(element, response);
                resetOptionChildDepends($(depends));
            });
        });
    }

    let getProduct = function (element) {
        let depends = $(element).data('depends');
        let href = $(element).data('href');
        $(document).on("change", depends, function (e) {
            e.preventDefault();
            let parentDepends = $($(this).data('depends'));
            let depdrop_parents = [parentDepends.val(), $(this).val()];
            $.ajax({
                type: 'POST',
                data: {depdrop_parents: depdrop_parents},
                url: href
            }).done(function (response) {
                initOption(element, response);
            });
        });
    }

    let getUOM = function (element) {
        let depends = $(element).data('depends');
        let href = $(element).data('href');
        $(document).on("change", depends, function (e) {
            e.preventDefault();
            let depdrop_parents = [$(this).val()];
            $.ajax({
                type: 'POST',
                data: {depdrop_parents: depdrop_parents},
                url: href
            }).done(function (response) {
                initOption(element, response, false);
            });
        });
    }

    let getVendor = function (element) {
        let depends = $(element).data('depends');
        let href = $(element).data('href');
        $(document).on("change", depends, function (e) {
            e.preventDefault();
            let depdrop_parents = [$(this).val()];
            $.ajax({
                type: 'POST',
                data: {depdrop_parents: depdrop_parents},
                url: href
            }).done(function (response) {
                initOption(element, response, false);
            });
        });
    }

    let initOption = function (element, newOptions, placeholder = true) {
        var el = $(element);
        if (placeholder) {
            el.empty().append("<option value=''>Select ...</option>");
        }
        else {
            el.empty();
        }
        if (newOptions.output != undefined) {
            $.each(newOptions.output, function (key, value) {
                el.append($("<option></option>")
                    .attr("value", value.id).text(value.name));
            });
            el.select2();
        }
    }

    let resetOptionChildDepends = function (element) {
        var idParent = element.attr('id');
        var form = element.closest('form');
        var childs = form.find("[data-parent-depends='#" + idParent + "']");

        if (childs.length) {
            $.each(childs, function (key, value) {
                $(value).empty();
            });
        }
    }

    return {
        getSubCategory: getSubCategory,
        getProduct: getProduct,
        getUOM: getUOM,
        getVendor: getVendor
    };

})(jQuery, window);



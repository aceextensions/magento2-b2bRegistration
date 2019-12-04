/**
 * Ace Extensions
 *
 * @category   Ace
 * @package    Ace_B2bRegistration
 * @author     Durga Shankar Gupta (dsguptas@gmail.com)
 * @copyright  Copyright (c) 2019 Ace Extensions ( http://aceextensions.com )
 */
require([
    'jquery',
    'mage/mage'
], function ($) {

    var dataForm = $('#form-validate');

    dataForm.mage('validation', {
        errorPlacement: function (error, element) {
            if (element.prop('id').search('full') !== -1) {
                var dobElement = $(element).parents('.customer-dob'),
                    errorClass = error.prop('class');
                error.insertAfter(element.parent());
                dobElement.find('.validate-custom').addClass(errorClass)
                    .after('<div class="' + errorClass + '"></div>');
            } else {
                error.insertAfter(element);
            }
        },
    }).find('input:text').attr('autocomplete', 'off');

});
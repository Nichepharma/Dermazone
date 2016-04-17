/*! AdminLTE custom style
 * ================
 * Main JS application file for AdminLTE v2. This file
 * should be included in all pages. It controls some layout
 * options and implements exclusive AdminLTE plugins.
 *
 * @Author  Almsaeed Studio
 * @Support <http://www.almsaeedstudio.com>
 * @Email   <support@almsaeedstudio.com>
 * @version 2.1.0
 * @license MIT <http://opensource.org/licenses/MIT>
 */

'use strict';

$('.form-animated .form-control').each(function(){
	$(this).attr('placeholder', '');
    var label = $(this).closest('.form-group').find('label');
    $(this).after(label);
    $(this).focusin(function(){
        $(this).closest('.form-group').find('label').addClass('label-active');
    });
    $(this).focusout(function(){
        $(this).closest('.form-group').find('label').removeClass('label-active');
    });
    $(this).change(function(){
        if($(this).val()){
            $(this).closest('.form-group').find('label').addClass('label-active-val');
        }
        else if(!$(this).val()){
            $(this).closest('.form-group').find('label').removeClass('label-active, label-active-val');
        }
    });
});
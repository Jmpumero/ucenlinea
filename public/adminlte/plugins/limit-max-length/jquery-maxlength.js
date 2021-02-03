/* ==========================================================
 * jQuery-maxlength.js v1.0.0
 *
 * Copyright (c) 2020 Gururaj Nadager;
 *
 * Licensed under the terms of the MIT license.
 * See: https://github.com/GururajNadager/jQuery-maxlength/blob/master/LICENSE
 * ========================================================== */
(function ($) {
    'use strict';

    var attrs = {
        maxLengthTemplate: "data-maxlength-template"
    }

    /**
      * This function uses maxlength attribute to restrict maximum number of characters allowed in the <input> <textarea> element.
      * Also provides template for displaying the number of characters entered in the <input> <textarea> element.
      * @param {Object} options - the configuration for this plugin.
      */
    $.fn.maxlength = function (options) {
        var settings = $.extend({}, $.fn.maxlength.defaults, options);
        this.each(function () {
            var ele = $(this);
            //Attach events only if the element has MaxLength attribute.
            if (typeof ele.attr("maxlength") != "undefined") {
                ele.on("keypress", settings, keypress);
                if (settings.showTemplate) {
                    insertTemplate(ele, settings);
                    ele.on("focusout", settings, clear);
                    ele.on("keyup", settings, keyup);
                    ele.on("paste", settings, paste);
                }
            }
        });
        return this;
    };

    /**
      * Add a new HTML element next to input element.
      * @param {HTMLElement} ele - HTML element.
      * @param {HTMLElement} settings - plugin configuration.
      */
    function insertTemplate(ele, settings) {
        $(settings.template).attr(attrs.maxLengthTemplate, "true")
            .css("color", settings.color)
            .css("font-size", settings.fontSize)
            .css("text-align", settings.position)
            .insertAfter(ele);
    }

    /**
      * show the template.
      * @param {Object} event - HTML Textbox event.
      * @param {int} length - length of the characters entered.
      * @param {int} maxLength - max length of characters allowed to be enetered.
      */
    function show(event, length, maxLength) {
        if (length != 0)
            $(event.target).next("[" + attrs.maxLengthTemplate + "='true']").text(format(event.data.text, length, maxLength));
        else
            clear(event);
    }

    /**
      * Format the template text.
      * @param {string} text - template text.
      * @param {int} length - length of the characters entered.
      * @param {int} maxLength - max length of characters allowed to be enetered.
      */
    function format(text, length, maxLength) {
        return text.replace("{total}", length).replace("{maxLength}", maxLength);
    }

    /**
      * Clear the template.
      * @param {Object} event - HTML Textbox event.
      */
    function clear(event) {
        $(event.target).next("[" + attrs.maxLengthTemplate + "='true']").text("");
    }

    /**
      * Keypress event of HTML Element.
      * @param {Object} event - HTML Textbox event.
      */
    function keypress(event) {
        var key = (event.keyCode ? event.keyCode : event.which);
        var length = this.value.length;
        var maxLength = $(event.target).attr("maxlength");
        if (key >= 33 || key == 13 || key == 32) {
            if (length >= maxLength)
                event.preventDefault();
        }
    }

    /**
     * Keyup event of HTML Element.
     * @param {Object} event - HTML Textbox event.
     */
    function keyup(event) {
        var length = this.value.length;
        show(event, length, $(event.target).attr("maxlength"));
    }

    /**
    * paste event of HTML Element.
    * @param {Object} event - HTML Textbox event.
    */
    function paste(event) {
        var pastedData = event.originalEvent.clipboardData.getData('text') ? event.originalEvent.clipboardData.getData('text')
                                                                           : event.originalEvent.clipboardData.getData('text/plain');
        var maxlength = $(event.target).attr("maxlength");
        var length = pastedData.length > maxlength ? maxlength : pastedData.length;
        show(event, length, maxlength );
    }

    $.fn.maxlength.defaults = {
        text: "{total}/{maxLength}",
        position: "left",
        color: "grey",
        fontSize: "12px",
        template: "<div />",
        showTemplate: true
    };
})(jQuery);

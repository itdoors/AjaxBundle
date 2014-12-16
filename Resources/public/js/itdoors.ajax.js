var ITDoorsAjax = (function() {

    var defaults = {
        ajaxFormClass: 'itdoors-ajax-form',
        ajaxFormBtnClass: 'itdoors-ajax-form-btn',
        ajaxFilterFormClass: 'ajax-filter-form',
        ajaxPaginationClass: 'it-doors-ajax-pagination-class',
        ajaxPaginationHolder: 'it-doors-pagination-holder',
        ajaxOrderingClass: 'it-doors-ordering',
        ajaxTabClass: 'ajax-tab-class',
        ajaxTabHolder: 'ajax-tab-holder',
        shortFormClass: 'itdoors-short-form',
        canBeResetedClass: 'can-be-reseted',
        select2Class: 'itdoors-select2',
        select2DependentClass: 'itdoors-select2-dependent',
        select2ListenerDependentClass: 'itdoors-dependent-listener-select2',
        textInputClass: 'itdoors-text',
        daterangeClass: 'itdoors-daterange',
        daterangeCustomClass: 'itdoors-daterange-custom',
        daterangeTextClass: 'itdoors-daterange-text',
        daterangeStartClass: 'itdoors-daterange-start',
        daterangeEndClass: 'itdoors-daterange-end',
        assetsDir: '',
        loadingImgPath: ''
    };

    function ITDoorsAjax() {
        this.params = {};
    };

    ITDoorsAjax.prototype.init = function(options)
    {
        this.params = $.extend(defaults, options);

        this.params.loadingImgPath = this.params.assetsDir + 'templates/metronic/img/ajax-loading.gif';

        this.initAjaxFilterForm();

        this.initAjaxForm();

        this.initSelect2();

        this.initSelect2Dependent();
        
        this.initListenerSelect2Dependent();

        this.initDateRange();

        this.initDateRangeCustom();

        this.initAjaxPagination();

        this.initAjaxTab();

        this.initAjaxOrdering();

    }

    ITDoorsAjax.prototype.initSelect2 = function()
    {
        if (!jQuery().select2) {
            return;
        }

        var selfClass = this;

        $('.' + selfClass.params.select2Class).each(function(index) {
            selfClass.select2($(this));
        });
    }
    ITDoorsAjax.prototype.initSelect2Dependent = function()
    {
        if (!jQuery().select2) {
            return;
        }

        var selfClass = this;

        $('.' + selfClass.params.select2Class).each(function(index) {
            selfClass.select2DependentClass($(this));
        });
    };
    ITDoorsAjax.prototype.initListenerSelect2Dependent = function()
    {
        var selfClass = this;

        $('.' + selfClass.params.select2ListenerDependentClass).each(function(index) {
            selfClass.select2ListenerDependent($(this));
        });
    };

    ITDoorsAjax.prototype.initDateRange = function()
    {
        var selfClass = this;

        if (!jQuery().daterangepicker) {
            return;
        }

        $('.' + selfClass.params.daterangeClass).each(function(index) {
            var self = $(this);

            var $form = self.closest('form');

            var btn =
                    '<span class="input-group-btn">' +
                    '<button class="btn default date-range-toggle" type="button">' +
                    '   <i class="fa fa-calendar"></i>' +
                    '</button>' +
            '</span>';

            self.append($(btn));

            if (Metronic) {
                var rtl = Metronic.isRTL();
            } else if (App) {
                var rtl = App.isRTL();
            }

            $(this).daterangepicker({
                opens: (rtl ? 'left' : 'right'),
                format: 'DD.MM.YYYY',
                separator: ' to ',
                startDate: moment().subtract('days', 29),
                endDate: moment(),
                locale: {
                    applyLabel: 'ОК',
                    cancelLabel: 'Отмена',
                    fromLabel: 'от',
                    toLabel: 'до',
                    customRangeLabel: 'Выбрать диапазон',
                    daysOfWeek: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб','Вс'],
                    monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                    firstDay: 0
                }
            },
            function(start, end) {
                var daterangeStart = self.parent().find('.' + selfClass.params.daterangeStartClass);
                var daterangeEnd = self.parent().find('.' + selfClass.params.daterangeEndClass);

                daterangeStart.val(start.format('DD.MM.YYYY'));
                daterangeEnd.val(end.format('DD.MM.YYYY'));

                self.find('input').val(start.format('DD.MM.YYYY') + ' - ' + end.format('DD.MM.YYYY'));

                if ($form.hasClass(selfClass.params.shortFormClass)) {
                    $form.trigger('change');
                }
            }
            );
        });
    }

    ITDoorsAjax.prototype.initDateRangeCustom = function()
    {
        var selfClass = this;

        if (!jQuery().daterangepicker) {
            return;
        }

        $('.' + selfClass.params.daterangeCustomClass).each(function(index) {
            var self = $(this);

            var $form = self.closest('form');

            var btn =
                    '<span class="input-group-btn">' +
                    '<button class="btn default date-range-toggle" type="button">' +
                    '   <i class="fa fa-calendar"></i>' +
                    '</button>' +
            '</span>';

            self.append($(btn));

            $(this).daterangepicker({
                opens: 'right',
                startDate: moment().subtract('days', 29),
                endDate: moment(),
                dateLimit: {
                    days: 60
                },
                showDropdowns: false,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Сегодня': [moment(), moment()],
                    'Вчера': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Последняя неделя': [moment().subtract('days', 6), moment()],
                    'Последние 30 дней': [moment().subtract('days', 29), moment()],
                    'Текущий месяц': [moment().startOf('month'), moment().endOf('month')],
                    'Предыдущий месяц': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                },
                buttonClasses: ['btn'],
                applyClass: 'blue',
                cancelClass: 'default',
                format: 'MM/DD/YYYY',
                separator: ' до ',
                language: 'ru',
                locale: {
                    applyLabel: 'Принять',
                    fromLabel: 'До',
                    toLabel: 'С',
                    customRangeLabel: 'Выберите интервал',
                    daysOfWeek: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
                    monthNames: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
                    firstDay: 1
                }
            },
            function(start, end) {
                var daterangeStart = self.parent().find('.' + selfClass.params.daterangeStartClass);
                var daterangeEnd = self.parent().find('.' + selfClass.params.daterangeEndClass);

                daterangeStart.val(start.format('DD.MM.YYYY'));
                daterangeEnd.val(end.format('DD.MM.YYYY'));

                self.find('input').val(start.format('DD.MM.YYYY') + ' - ' + end.format('DD.MM.YYYY'));

                if ($form.hasClass(selfClass.params.shortFormClass)) {
                    $form.trigger('change');
                }
            }
            );

            self.find('input').html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            $(this).show();
        });
    }

    ITDoorsAjax.prototype.updateList = function(targetId)
    {
        var selfClass = this;

        var target = $('#' + targetId);

        var url = target.data('url');

        var params = target.data('params');

        $.ajax({
            type: 'POST',
            url: url,
            data: params,
            beforeSend: function() {
                selfClass.blockUI(target);
            },
            success: function(response) {
                target.html(response);
                selfClass.unblockUI(target);
            }
        });
    }

    ITDoorsAjax.prototype.blockUI = function(el, centerY) {
        var selfClass = this;

        if (el.height() <= 400) {
            centerY = true;
        }
        el.block({
            message: '<img src="' + selfClass.params.loadingImgPath + '" align="">',
            centerY: centerY != undefined ? centerY : true,
            css: {
                top: '10%',
                border: 'none',
                padding: '2px',
                backgroundColor: 'none'
            },
            overlayCSS: {
                backgroundColor: '#FFF',
                opacity: 0.5,
                cursor: 'wait'
            }
        });
    };

    // wrapper function to  un-block element(finish loading)
    ITDoorsAjax.prototype.unblockUI = function(el, clean) {
        el.css('position', '');
        el.css('zoom', '');
        el.unblock();
    };

    ITDoorsAjax.prototype.select2 = function($selector, defaultParams) {

        if (!defaultParams) {
            defaultParams = {};
        }
        if (!$selector.length) {
            return false;
        }
        if (!$.isFunction($.fn.select2)) {
            return false;
        }
        var url = $selector.data('url');
        var urlById = $selector.data('url-by-id');
        var selectorParams = $selector.data('params');
        var params = $.extend({
            minimumInputLength: 2,
            allowClear: true
        }, selectorParams);
        params = $.extend(params, defaultParams);
        var choices = $selector.data('choices');
        if (choices) {
            params.data = choices;
        }
        if (url) {
            params.ajax = {
                url: url,
                dataType: 'json',
                data: function(term, page) {
                    return {
                        query: term,
                        q: term
                    };
                },
                results: function(data, page) {
                    return {
                        results: data
                    };
                }
            };
        }
        if (urlById) {
            params.initSelection = function(element, callback) {
                var id = $(element).val();
                if (id !== "") {
                    $.ajax(urlById, {
                        data: {
                            id: id
                        },
                        dataType: "json"
                    }).done(function(data) {
                        callback(data);
                    });
                }
            };
        }
        $selector.select2(params);
    };
    ITDoorsAjax.prototype.select2Dependent = function($selector, defaultParams) {

        if (!defaultParams) {
            defaultParams = {};
        }
        if (!$selector.length) {
            return false;
        }
        if (!$.isFunction($.fn.select2)) {
            alert('Function select2 not found');
            return false;
        }
        var url = $selector.data('url');
        var urlById = $selector.data('url-by-id');
        var $dependent = $('#'+$selector.data('dependent'));
        var dependentId = null;
        $selector.attr('disabled', 'disabled');
        $dependent.on('select2-selecting', function(e){
            dependentId = e.object.id;
            if (e.object.id) {
                 $selector.removeAttr('disabled');
            } else {
                $selector.select2('data', '');
                $selector.trigger("select2-clearing");
                $selector.attr('disabled', 'disabled');
            }
        });
        $dependent.on('select2-clearing', function(e){
                $selector.select2('data', '');
                $selector.trigger("select2-clearing");
                $selector.attr('disabled', 'disabled');
        });
        
        var selectorParams = $selector.data('params');

        var params = $.extend({
            minimumInputLength: 2,
            allowClear: true
        }, selectorParams);

        params = $.extend(params, defaultParams);

        var choices = $selector.data('choices');

        if (choices) {
            params.data = choices;
        }

        if (url) {
            params.ajax = {
                url: url,
                dataType: 'json',
                data: function(term, page) {
                    return {
                        query: term,
                        q: term,
                        dependent: dependentId
                    };
                },
                results: function(data, page) {
                    return {
                        results: data
                    };
                }
            };
        }

        if (urlById) {
            params.initSelection = function(element, callback) {
                var id = $(element).val();
                if (id !== "") {
                    $.ajax(urlById, {
                        data: {
                            id: id
                        },
                        dataType: "json"
                    }).done(function(data) {
                        callback(data);
                    });
                }
            };
        }

        $selector.select2(params);
        
    };
    ITDoorsAjax.prototype.select2DependentToSelect2 = function($selector, defaultParams) {

        if (!defaultParams) {
            defaultParams = {};
        }

        if (!$selector.length) {
            return false;
        }

        if (!$.isFunction($.fn.select2)) {
            alert('Function select2 not found');
            return false;
        }

        var url = $selector.data('url');
        var urlById = $selector.data('url-by-id');
        var urlByOne = $selector.data('url-by-one');
        var $field = $selector.data('field');
        var $dependent = $('#'+$selector.data('dependent'));
        var dependentId = null;
        $selector.attr('disabled', 'disabled');
        
        $dependent.on('select2-selecting', function(e){
            dependentId = e.object.id;
            if (e.object.isNew == undefined) {
                
                $selector.select2('data', '');
                $selector.trigger("select2-clearing");
                $selector.attr('disabled', 'disabled');
                $.ajax(
                        urlByOne, {
                        data: {
                            field: $field,
                            dependent: dependentId
                            },
                            dataType: "json"
                        }).done(function(data) {
                            if (data === null) {
                                data = '';
                            }
                            $selector.select2('data', data);
                            $selector.trigger("change");
                        });
                
            } else {
                $selector.select2('data', '');
                $selector.trigger("select2-clearing");
                $selector.removeAttr('disabled');
            }
        });
        $dependent.on('select2-clearing', function(e){
            dependentId = null;
            $selector.select2('data', '');
            $selector.trigger("select2-clearing");
            $selector.attr('disabled', 'disabled');
        });

        var selectorParams = $selector.data('params');

        var params = $.extend({
            minimumInputLength: 2,
            allowClear: true
        }, selectorParams);

        params = $.extend(params, defaultParams);

        var choices = $selector.data('choices');

        if (choices) {
            params.data = choices;
        }

        if (url) {
            params.ajax = {
                url: url,
                dataType: 'json',
                data: function(term, page) {
                    return {
                        query: term,
                        field: $field,
                        q: term,
                        dependent: dependentId
                    };
                },
                results: function(data, page) {
                    return {
                        results: data
                    };
                }
            };
        }

        if (urlById) {
            params.initSelection = function(element, callback) {
                var id = $(element).val();
                if (id !== "") {
                    $.ajax(urlById, {
                        data: {
                            id: id
                        },
                        dataType: "json"
                    }).done(function(data) {
                        callback(data);
                    });
                }
            };
        }

        $selector.select2(params);
    };
    ITDoorsAjax.prototype.select2ListenerDependent = function($object, defaultParams) {

        if (!defaultParams) {
            defaultParams = {};
        }

        if (!$object.length) {
            return false;
        }

        var url = $object.data('url');
        var $dependent = $('#'+$object.data('dependent'));
        var $field = $object.data('field');
        var dependentVal = $dependent.val();

        $dependent.on('select2-selecting', function(e){
            var $text = $('#'+$object.attr('id')+'Div');
            $text.text('');
            if (e.object.id) {
                $.ajax(url, {
                    data: {
                        field: $field,
                        id: e.object.value
                    },
                    dataType: "json"
                }).done(function(data) {
                    if (data === null) {
                        data = '';
                    }
                    $text.html(data);
                });
            }
        });
        $dependent.on('select2-clearing', function(e){
            var $text = $('#'+$object.attr('id')+'Div');
            $text.text('');
        });
        
        $dependent.on('change', function(){
            var $text = $('#'+$object.attr('id')+'Div');
            dependentVal = $(this).val();
            $text.text('');
            if (dependentVal !== '') {
                if (url) {
                    $.ajax(url, {
                        data: {
                            field: $field,
                            id: dependentVal
                        },
                        dataType: "json"
                    }).done(function(data) {
                        if (data === null) {
                            data = '';
                        }
                        $text.html(data);
                    });
                }
            }
        });
    };

    ITDoorsAjax.prototype.resetForm = function(form)
    {
        var selfClass = this;
        form.find('.' + selfClass.params.canBeResetedClass).each(function(index) {
            if ($(this).hasClass(selfClass.params.select2Class)) {
                $(this).select2('data', null);
            }

            if ($(this).hasClass(selfClass.params.daterangeStartClass) || $(this).hasClass(selfClass.params.daterangeEndClass) || $(this).hasClass(selfClass.params.daterangeTextClass)) {
                $(this).val('');
            }

            if ($(this).hasClass(selfClass.params.textInputClass)) {
                $(this).val('');
            }

            if ($(this).attr('type') == 'checkbox') {
                if ($(this).is(':checked')) {
                    $(this).trigger('click');
                }
            }
        });
    }

    ITDoorsAjax.prototype.initAjaxFilterForm = function()
    {
        var selfClass = this;

        var $form = $('.' + selfClass.params.ajaxFilterFormClass)

        $('.' + selfClass.params.ajaxFilterFormClass + ' .itdoors-filter-cancel-btn').die('click');
        $('.' + selfClass.params.ajaxFilterFormClass + ' .itdoors-filter-cancel-btn').live('click', function(e){
            e.preventDefault();

            var resetField = $form.find('.ajax-form-reset-field');

            selfClass.resetForm($form);

            resetField.val(1);

            $form.submit();

            resetField.val(0);
        });
        $form.die('submit');
        $form.live('submit', function(e){

            e.preventDefault();

            var self = $(this);

            $(this).ajaxSubmit({
                dataType: 'json',
                beforeSend: function() {

                    selfClass.blockUI(self);
                },
                success: function(response) {

                    selfClass.unblockUI(self);

                    if (response.error) {
                        return;
                    }

                    if (response.success) {
                        if (response.successFunctions) {
                            var successFunctions = JSON.parse(response.successFunctions);

                            for (key in successFunctions) {
                                var successFunction = successFunctions[key].split('.');

                                if (successFunction[0] && successFunction[1]) {
                                    if (window[successFunction[0]] && typeof window[successFunction[0]][successFunction[1]] === 'function') {
                                        formok = window[successFunction[0]][successFunction[1]](key);
                                    }
                                } else {
                                    if (typeof window[successFunctions[key]] === 'function') {
                                        formok = window[successFunctions[key]](key);
                                    }
                                }
                            }
                        }
                    }
                }
            });
        });

        var $formShort = $('.' + selfClass.params.ajaxFilterFormClass + '.' + selfClass.params.shortFormClass).live('change', function() {
            $(this).submit();
        });
    };

    /**
     * Init Btn, onClick - load form from params
     *
     * @param {Object} $selector
     */
    ITDoorsAjax.prototype.initAjaxFormBtn = function($selector) {
        var selfClass = this;

        var params = $selector.data('params');
        var $target = $(params.target);

        $selector.die('click');

        $selector.live('click', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: params.url,
                data: {
                    params: JSON.stringify(params)
                },
                beforeSend: function() {
                    console.log('before send');
                    if (!$target.html()) {
                        $target.show();
                        $target.html(params.loadingText);
                    }
                    $target.show();
                    selfClass.blockUI($target);
                },
                success: function(response) {
                    $selector.hide();
                    $target.show();
                    $target.html(response.content);
                    selfClass.unblockUI($target);
                }
            });
        });
    };

    ITDoorsAjax.prototype.initAjaxForm = function()
    {
        var selfClass = this;

        var $form = $('.' + selfClass.params.ajaxFormClass)
        $('.' + selfClass.params.ajaxFormClass + ' .itdoors-form-cancel-btn').die('click');
        $('.' + selfClass.params.ajaxFormClass + ' .itdoors-form-cancel-btn').live('click', function(e){
            e.preventDefault();

            var params = JSON.parse($(this).closest('form').find('.params-hidden').val());

            var $selector = $(params.selector);
            var $target = $(params.target);

            $selector.fadeIn();
            $target.html('');
            $target.hide();
        });

        $form.die('submit');
        $form.live('submit', function(e){

            e.preventDefault();

            var self = $(this);

            $(this).ajaxSubmit({
                dataType: 'json',
                beforeSend: function () {

                    selfClass.blockUI(self);
                },
                success: function(response) {

                    selfClass.unblockUI(self);

                    selfClass.unblockUI(self);

                    var params = JSON.parse(response.params);

                    var $selector = $(params.selector);
                    var $target = $(params.target);

                    if (response.error) {
                        $target.html(response.content);
                        return;
                    }

                    if (response.success) {

                        $selector.fadeIn();
                        $target.html('');
                        $target.hide();

                        if (params.successFunctions) {
                            var successFunctions = params.successFunctions;

                            for (key in successFunctions) {
                                var successFunction = successFunctions[key].split('.');

                                if (successFunction[0] && successFunction[1]) {
                                    if (window[successFunction[0]] && typeof window[successFunction[0]][successFunction[1]] === 'function') {
                                        formok = window[successFunction[0]][successFunction[1]](key);
                                    }
                                } else {
                                    if (typeof window[successFunctions[key]] === 'function') {
                                        formok = window[successFunctions[key]](key);
                                    }
                                }
                            }
                        }
                    }
                }
            });
        });
    };

    ITDoorsAjax.prototype.initAjaxPagination = function()
    {
        var selfClass = this;
        $('.' + selfClass.params.ajaxPaginationClass).die( "click" );
        $('.' + selfClass.params.ajaxPaginationClass).live('click', function(e){
            e.preventDefault();

            var page = $(this).data('page');

            var parentHolder = $(this).parents('.' + selfClass.params.ajaxPaginationHolder);

            console.log(page);
            var url = parentHolder.data('url');
            var paginationNamespace = parentHolder.data('pagination_namespace');

            console.log(paginationNamespace);

            $target = parentHolder;
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: url,
                data: {
                    page: page,
                    paginationNamespace: paginationNamespace
                },
                beforeSend: function() {
                    console.log('before send');
                    if (!$target.html()) {
                        $target.show();
                        $target.html(params.loadingText);
                    }
                    $target.show();
                    selfClass.blockUI($target);
                },
                success: function(response) {
                    selfClass.unblockUI($target);

                    var successFunctions = parentHolder.data('success');

                    if (successFunctions) {
                        for (key in successFunctions) {
                            var successFunction = successFunctions[key].split('.');

                            if (successFunction[0] && successFunction[1]) {
                                if (window[successFunction[0]] && typeof window[successFunction[0]][successFunction[1]] === 'function') {
                                    formok = window[successFunction[0]][successFunction[1]](key);
                                }
                            } else {
                                if (typeof window[successFunctions[key]] === 'function') {
                                    formok = window[successFunctions[key]](key);
                                }
                            }
                        }
                    }
                }
            });
        })
    }
    
    ITDoorsAjax.prototype.initAjaxTab = function()
    {
        var selfClass = this;
        $('.' + selfClass.params.ajaxTabClass).die('click');
        $('.' + selfClass.params.ajaxTabClass).live('click', function(e) {
            e.preventDefault();
            selfClass.updateTab($(this).data('tab'));
        });
    }
    
    ITDoorsAjax.prototype.updateTab = function(tab)
    {
        var selfClass = this;

        var obj = $('a[data-tab=' + tab + ']');

        var blockupdate = $('.' + $(obj).data('block-update'));

        var url = $(obj).data('url');

        var url_ajax = $(obj).parents('ul').data('url');

        var namespase = $(obj).parents('ul').data('namespase');

        $.ajax({
            type: 'POST',
            url: url_ajax,
            dataType: 'json',
            data: {
                tab: tab,
                tabNamespace: namespase
            },
            beforeSend: function() {
                selfClass.blockUI(blockupdate);
            },
            success: function(json) {
                if (json.success) {
                    $.ajax({
                        type: 'POST',
                        url: url,
                        success: function(response) {
                            blockupdate.html(response);
                            selfClass.unblockUI(blockupdate);
                        }
                    });
                }
            }
        });

    }

    ITDoorsAjax.prototype.initAjaxOrdering = function()
    {
        var selfClass = this;
        $('.' + selfClass.params.ajaxOrderingClass).die( "click" );
        $('.' + selfClass.params.ajaxOrderingClass).live('click', function(e){
            e.preventDefault();

            var field = $(this).data('field');
            var url = $(this).data('url');
            var type = $(this).data('type');
            var orderingNamespace = $(this).data('ordering_namespace');
            var field = $(this).data('field');
            var oneField = $(this).data('one_field');
            $target =  $(this);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: url,
                data: {
                    field: field,
                    type: type,
                    orderingNamespace: orderingNamespace,
                    oneField: oneField
                },
                beforeSend: function() {
                    if (!$target.html()) {
                        $target.show();
                        $target.html(params.loadingText);
                    }
                    $target.show();
                    selfClass.blockUI($target);
                },
                success: function(response) {
                    selfClass.unblockUI($target);

                    var successFunctions = $target.data('success');
                    if (successFunctions) {
                        for (key in successFunctions) {
                            var successFunction = successFunctions[key].split('.');

                            if (successFunction[0] && successFunction[1]) {
                                if (window[successFunction[0]] && typeof window[successFunction[0]][successFunction[1]] === 'function') {
                                    formok = window[successFunction[0]][successFunction[1]](key);
                                }
                            } else {
                                if (typeof window[successFunctions[key]] === 'function') {
                                    formok = window[successFunctions[key]](key);
                                }
                            }
                        }
                    }
                }
            });
        })
    }

    return new ITDoorsAjax();
})();
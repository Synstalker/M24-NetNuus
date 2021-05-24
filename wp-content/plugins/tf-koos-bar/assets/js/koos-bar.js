jQuery(document).on('widget-updated widget-added ready', function (e, widget) {
    'use strict';

    var $rightWrapper = jQuery('#widgets-right');

    if (e.type !== 'ready') {
        var updateEvent = jQuery(widget[0]).find(".mtf_koos_bar").length > 0;
        if (updateEvent) {
            koosBar.init();
        }
    } else {
        var $widgetExist = $rightWrapper.find('.mtf_koos_bar');

        if ($widgetExist.length > 0) {
            koosBar.init();
        }
    }
    if($rightWrapper.find('.mtf_koos_bar').length > 0) {
        $rightWrapper.find('.kb-color-picker').each(function () {
            jQuery(this).wpColorPicker({
                change: setTimeout(function () { // For Customizer
                    jQuery(this).trigger('change');
                    //console.log(e.type);
                }, 3000)
            });
        });
    }
});

var createKoosBar = (function ($) {
    'use strict';
    function init() {

        //Initialize Vars
        this.$rightWrapper      = $('#widgets-right');
        this.$listToSort        = this.$rightWrapper.find('ul.kb-sort-list');
        this.$listChildren      = this.$listToSort.children('li');
        this.$fieldInputs       = this.$listToSort.find('.kb-field');
        this.$adderBtn          = this.$rightWrapper.find('.kb-add-item');
        this.$submitBtn         = this.$rightWrapper.find('input[id^=widget-koos_bar][type=submit]');
        this.$itemCount         = this.$listChildren.length;
        this.$notifier          = null;
        this.canAdd             = false;
        this.noSortClass        = 'kb-no-sort';

        this.removeButtons(this.$listChildren);
        this.elementAddedRemoved();
        this.inputsValidate(this.$fieldInputs);
        this.releaseSubmit(this.$fieldInputs);
        this.addButton(this.$adderBtn);
    }

    function elementAddedRemoved(){
        //Re-count <li>'s
        this.$listChildren = this.$listToSort.children('li');
        this.$fieldInputs = this.$listToSort.find('.kb-field'); //Sloppy

        if (this.$itemCount <= 1) {
            //No Sorting
            if (!this.$listToSort.hasClass(this.noSortClass)) {
                this.$listToSort.addClass(this.noSortClass);
            }
        } else {
            //Sorting
            if (this.$listToSort.hasClass(this.noSortClass)) {
                this.$listToSort.removeClass(this.noSortClass);
            }
            this.startSort(this.$listToSort);
        }
        this.$listChildren.each(function(i){
            $(this).data('item', i + 1);
        });
        this.inputsValidate(this.$fieldInputs);
    }

    /* Input fields + Events */
    function inputsValidate(targetElem, eventType) {

        eventType = typeof eventType !== 'undefined' ? eventType : 'change focusout';
        targetElem = typeof targetElem !== 'undefined' ? targetElem : this.$fieldInputs;

        if (targetElem.length > 0) {
            for(var $i = 0; $i < targetElem.length; $i++) {
                $(targetElem[$i]).on('change focusout', {targetElem:targetElem}, this.inputsChangeEvent);
            }
        }
    }
    function inputsChangeEvent(e) {
        var $notifier = $(e.target).parent().find('.kb-notifier');
        if(e.type === 'focusout' || e.type === 'change'){
            switch($(e.target).val()){
                case '':
                    $notifier.stop(true,true).text('Inputs cannot be blank').fadeIn(200).delay(1000).fadeOut(200);
                    break;
                case 'Enter title':
                    if($(e.target).hasClass('kb-field-title')) {
                        $notifier.stop(true, true).text('Title field cannot be \'Enter title\'').fadeIn(200).delay(1000).fadeOut(200);
                    }
                    break
                case 'http://www.mydestination.com/':
                    if($(e.target).hasClass('kb-field-url')) {
                        $notifier.stop(true, true).text('Title field cannot be \'http://www.mydestination.com/\'').fadeIn(200).delay(1000).fadeOut(200);
                    }
                    break;
                default:
                    $notifier.hide();
                    break;
            }
        }
        this.releaseSubmit($(e.data.targetElem));
    }

    function releaseSubmit(targetElems){
        targetElems = typeof targetElems !== 'undefined' ? targetElems : this.$fieldInputs;
        var noSubmit = false;
        for(var i = 0; i < targetElems.length; i++){
            if($(targetElems[i]).val() === '' || $(targetElems[i]).val() === 'Enter title' || $(targetElems[i]).val() === 'http://www.mydestination.com/'){
                noSubmit = true;
                break;
            }
        }
        if(!noSubmit){
            this.$submitBtn.prop("disabled", false);
        }else{
            this.$submitBtn.prop("disabled", true);
        }
    }

    /* Remove Buttons + Events */
    function removeButtons(targetElem) {

        targetElem = typeof targetElem !== 'undefined' ? targetElem : this.$listChildren;

        if (targetElem.length > 0) {
            for(var $i = 0; $i < targetElem.length; $i++){
                var $remover = $(targetElem[$i]).find('.kb-remove-item');
                $remover.on('click', this.removeButtonsEvents);
            }
        }
    }
    function removeButtonsEvents(e) {
        if(this.$itemCount !== 1) {
            $(e.target).parents('li').remove();
            this.$itemCount--;
        }
        this.elementAddedRemoved();
        this.releaseSubmit();
    }

    /* Add Button + Events */
    function addButton(target, eventType) {

        eventType = typeof eventType !== 'undefined' ? eventType : 'click';
        target = typeof target !== 'undefined' ? target : '';

        target.on(eventType, this.addButtonEvent);
    }
    function addButtonEvent(e) {
        e.preventDefault();
        var $lastItem = $(e.target).parent().prev('ul.kb-sort-list').find('li:last'),
            $clone = $lastItem.clone(true, true);
        this.$itemCount++;
        $clone.insertAfter($lastItem);
        this.elementAddedRemoved();
    }

    function startSort(list) {
        var noSort = this.noSortClass;
        list.sortable({
            handle: '.kb-sort-handle',
            containment: "parent",
            cancel: noSort
        });
    };

    return function() {
        'use strict';

        var self = {};

        self.init = init.bind(self);
        self.elementAddedRemoved = elementAddedRemoved.bind(self);

        self.inputsValidate = inputsValidate.bind(self);
        self.inputsChangeEvent = inputsChangeEvent.bind(self);
        self.releaseSubmit = releaseSubmit.bind(self);

        self.removeButtons = removeButtons.bind(self);
        self.removeButtonsEvents = removeButtonsEvents.bind(self);

        self.addButton = addButton.bind(self);
        self.addButtonEvent = addButtonEvent.bind(self);

        self.startSort = startSort.bind(self);

        return self;
    };
})(jQuery);

var koosBar = createKoosBar();
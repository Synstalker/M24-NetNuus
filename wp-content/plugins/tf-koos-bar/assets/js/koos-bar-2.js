jQuery(document).on('widget-updated widget-added ready', function(e, a){
    if(e.type !== 'ready') {
        var updateEvent = jQuery(a[0]).find(".mtf_koos_bar").length > 0;

        if (updateEvent) {
            koosBar.init();
        }
    }else{
        var $right_wrapper = jQuery('#widgets-right'),
            $adderBtn = $right_wrapper.find('.add_koos_field');

        if($adderBtn.length > 0) {
            koosBar.init();
        }
    }
});

var koosBar = ( function ($) {

    var $listToSort,
        $listChildren,
        $right_wrapper,
        $notifier,
        $fieldInputs,
        canAdd = false;

    function init(){

        var $right_wrapper = $('#widgets-right'),
            $adderBtn = $right_wrapper.find('.add_koos_field'),
            $listToSort = $right_wrapper.find('ul.kb-sort-list'),
            $fieldInputs = $listToSort.find('.kb-field'),
            $submitBtn = $right_wrapper.find('input[id^=widget-koos_bar][type=submit]'),
            $notifier;

        $listChildren = $listToSort.children('li');

        /* On canAdd var change */
        $(document).on('canAddValueChange', function(e, can){
            $submitBtn.prop( "disabled", can );
            console.log('canAddValueChange');
        });

        /* Initial Sort*/
        if(!isSingleItem($listChildren)){
            startSort($listToSort);
            if($listToSort.hasClass('kb-no-sort')){
                $listToSort.removeClass('kb-no-sort');
            }
        }else{
            $listToSort.addClass('kb-no-sort');
        }

        /* Remove button events */
        removeButtons($listToSort);

        /* Set initial input events */
        inputsChanged($fieldInputs);

        /* Add Item button event */
        if($adderBtn.length > 0) {
            $adderBtn.on('click', function (e) {
                if(canAdd) {
                    e.preventDefault();
                    var $lastChild = $(this).parent().prev('ul.kb-sort-list').find('li:last'),
                        $clone = $lastChild.clone(true);

                    $listToSort = $right_wrapper.find('ul.kb-sort-list');
                    $listChildren = $listToSort.children('li');

                    $clone.insertAfter($lastChild);

                    if (!isSingleItem($listChildren)) {
                        startSort($listToSort);
                        if ($listToSort.hasClass('kb-no-sort')) {
                            $listToSort.removeClass('kb-no-sort');
                        }
                    } else {
                        $listToSort.addClass('kb-no-sort');
                    }
                    $fieldInputs = $listToSort.find('.kb-field');
                    inputsChanged($fieldInputs, false);
                    removeButtons($listToSort);
                }
            });
        }

        /* Get all notifier divs */
        if($listChildren.length > 0){
            $listChildren.each(function(){
                $notifier = $(this).find('[data-notifier]');
                if($listChildren.length === 1) {

                }
            });
        }

    }

    function inputsChanged(target, init){
        init = typeof init === 'undefined' ? true : false;
        target.each(function(){
            var $this = $(this);
            if(init){
                if($(this).val() === ''){
                    canAdd = false;
                    $(document).trigger('canAddValueChange', true);
                }else if($(this).val() === 'Enter Title' || $(this).val() === 'http://www.mydestination.com/'){
                    canAdd = false;
                    $(document).trigger('canAddValueChange', true);
                }else{
                    canAdd = true;
                    $(document).trigger('canAddValueChange', false);
                }
            }
            $this.on('change focusout', function(e){
                $notifier = $(this).parent().find(".kb-notifier");
                if($(this).val() === ''){
                    notifier('Fields cannot be blank...', $notifier);
                    canAdd = false;
                    $(document).trigger('canAddValueChange', true);
                }else if($(this).val() === 'Enter title' || $(this).val() === 'http://www.mydestination.com/'){
                    notifier('Fields cannot cotain initial values...', $notifier);
                    canAdd = false;
                    $(document).trigger('canAddValueChange', true);
                }else{
                    canAdd = true;
                    $(document).trigger('canAddValueChange', false);
                }
            });
        });
    }

    function removeButtons(elem){
        var elems = elem.children('li');
        if(elems.length > 0){
            elems.each(function(){
                //console.log(isSingleItem(elems));
                var $remover = $(this).find('.kb-remove-item'),
                    $notifier = $(this).parent().find('[data-notifier]');
                if(!isSingleItem(elems)) {
                    if($remover.hasClass('kb-disable')){
                        $remover.removeClass('kb-disable');
                    }
                }else{
                    $remover.addClass('kb-disable');
                }
                $remover.on('click', function(){
                    //console.log('click');
                    if(!$(this).hasClass('kb-disable')) {
                        $(this).parents('li').remove();
                        $right_wrapper = $('#widgets-right');
                        $listToSort = $right_wrapper.find('ul.kb-sort-list');
                        removeButtons($listToSort);

                        $fieldInputs = $listToSort.find('.kb-field'); //ReCount the input fields
                        inputsChanged($fieldInputs, false);
                    }else{
                        notifier('At least 1 element is required', $notifier);
                    }
                });
            });
        }
    }

    function isSingleItem(elem){
        if(elem.length <= 1){
            return true;
        }else{
            return false;
        }
    }

    function notifier(msg, elem){
        elem.stop(true, true).hide().text(msg).fadeIn(200);
        setTimeout(function(){
            elem.fadeOut(100);
        },1000)
    }

    function startSort($list){
        console.log("sorting");
        $list.sortable({
            handle: '.kb-sort-handle',
            containment: "parent",
            cancel:".kb-no-sort",
            axis: 'y'
        });
    }

    return {init:init};

})(jQuery);

/*var KoosBar = ( function ($) {

 var ctor = function() {
 //Initial vars
 this.canAdd = false;
 /!*this.init = function () {

 //Initialize Vars
 this.$rightWrapper = $('#widgets-right');
 this.$listToSort = this.$rightWrapper.find('ul.kb-sort-list');
 this.$listChildren = this.$listToSort.children('li');
 this.$fieldInputs = this.$listToSort.find('.kb-field');
 this.$adderBtn = this.$rightWrapper.find('.add_koos_field');
 this.$submitBtn = this.$rightWrapper.find('input[id^=widget-koos_bar][type=submit]');
 this.$notifier;

 this.inputsChangeEvent();
 };*!/

 /!*this.inputsChangeEvent = function () {
 return console.log(this.$listChildren);
 };*!/

 this.removeButtonsEvents = function () {

 };

 this.addButtonEvent = function () {

 };
 };
 ctor.prototype.init = function () {

 //Initialize Vars
 this.$rightWrapper = $('#widgets-right');
 this.$listToSort = this.$rightWrapper.find('ul.kb-sort-list');
 this.$listChildren = this.$listToSort.children('li');
 this.$fieldInputs = this.$listToSort.find('.kb-field');
 this.$adderBtn = this.$rightWrapper.find('.add_koos_field');
 this.$submitBtn = this.$rightWrapper.find('input[id^=widget-koos_bar][type=submit]');
 this.$notifier;

 this.inputsChangeEvent();
 };

 ctor.prototype.inputsChangeEvent = function () {
 return console.log(this.$listChildren);
 };
 //return {init:this.init};
 return ctor;
 })(jQuery);*/

/*var koosBar = koosBarFactory();*/

/*var koosBar = ( function ($) {

 //return function() {
 var self = {};
 //Initial vars
 self.canAdd = false;
 self.init = function () {

 //Initialize Vars
 self.$rightWrapper = $('#widgets-right');
 self.$listToSort = self.$rightWrapper.find('ul.kb-sort-list');
 self.$listChildren = self.$listToSort.children('li');
 self.$fieldInputs = self.$listToSort.find('.kb-field');
 self.$adderBtn = self.$rightWrapper.find('.add_koos_field');
 self.$submitBtn = self.$rightWrapper.find('input[id^=widget-koos_bar][type=submit]');
 self.$notifier;

 self.inputsChangeEvent();
 }

 self.inputsChangeEvent = function () {
 return console.log(self.$rightWrapper);
 };

 self.removeButtonsEvents = function () {

 };

 self.addButtonEvent = function () {

 };

 return self;
 //return {init:this.init};
 // };
 })(jQuery);*/
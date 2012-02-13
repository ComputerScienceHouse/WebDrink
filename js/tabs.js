/**
 * Created by JetBrains PhpStorm.
 * User: seanmcgary
 * Date: 9/11/11
 * Time: 7:08 PM
 * To change this template use File | Settings | File Templates.
 */

/*var DrinkTabs = (function(){


    return new DrinkTabs();

})();*/
function DrinkTabs(){
    var self = this;

    return self;
}

DrinkTabs.prototype = {
    init: function(tab_id, tab_content, init_tab){
        var self = this;
        self.tab_id_attr = tab_id;
        self.tab_content_attr = tab_content;

        if(typeof init_tab == 'undefined'){
            init_tab = $('#tabs a.' + self.tab_id_attr).first();
        }

        var selected_id = init_tab.attr('tab_id');

        $('.' + self.tab_content_attr + '[tab_content_id="' + selected_id + '"]').css('display', 'block');

        $('.' + self.tab_id_attr).live('click', function(){
            self.switch_tab($(this));
        });

    },
    switch_tab: function(tab_clicked){
        var self = this;

        $('.' + self.tab_content_attr).css('display', 'none');

        $('.' + self.tab_content_attr + '[tab_content_id="' + tab_clicked.attr('tab_id') + '"]').css('display', 'block');

    }
}
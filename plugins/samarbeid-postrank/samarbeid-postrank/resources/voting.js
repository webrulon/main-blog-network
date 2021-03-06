$(function() {

    /**
     * Small Cookies JavaScript Helper
     *
     * Source code available at http://github.com/tdd/cookies-js-helper
     *
     * Copyright (c) 2010 Christophe Porteneuve <tdd@tddsworld.com>
     *
     * Permission is hereby granted, free of charge, to any person
     * obtaining a copy of this software and associated documentation
     * files (the "Software"), to deal in the Software without
     * restriction, including without limitation the rights to use,
     * copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the
     * Software is furnished to do so, subject to the following
     * conditions:
     *
     * The above copyright notice and this permission notice shall be
     * included in all copies or substantial portions of the Software.
     */
    (function(k){var c=Object.prototype.toString;function i(l){return"[object Date]"==c.call(l)}function d(l){return"[object RegExp]"==c.call(l)}var a={get:function b(l){return a.has(l)?a.list()[l]:null},has:function j(l){return new RegExp("(?:;\\s*|^)"+encodeURIComponent(l)+"=").test(document.cookie)},list:function f(o){var p=document.cookie.split(";"),q,m={};for(var n=0,l=p.length;n<l;++n){q=p[n].split("=");if(!d(o)||o.test(q[0])){m[decodeURIComponent(q[0])]=decodeURIComponent(q[1])}}return m},remove:function e(m,l){var o={};for(var n in (l||{})){opts2[n]=l[n]}o.expires=new Date(0);o.maxAge=-1;return a.set(m,null,o)},set:function h(o,r,n){n=n||{};var q=[encodeURIComponent(o)+"="+encodeURIComponent(r)];if(n.path){q.push("path="+n.path)}if(n.domain){q.push("domain="+n.path)}var m="maxAge" in n?n.maxAge:("max_age" in n?n.max_age:n["max-age"]),p;if("undefined"!=typeof m&&"null"!=typeof m&&(!isNaN(p=parseFloat(m)))){q.push("max-age="+p)}var l=i(n.expires)?n.expires.toUTCString():n.expires;if(l){q.push("expires="+l)}if(n.secure){q.push("secure")}q=q.join("; ");document.cookie=q;return q},test:function g(){var m="70ab3d396b85e670f25b93be05e027e4eb655b71",n="Élodie Jaubert";a.remove(m);a.set(m,n);var l=n==a.get(m);a.remove(m);return l}};k.bvt_cookie=a})(window);

    /*
    * jquery.tools 1.1.2 - The missing UI library for the Web
    * 
    * [tools.tooltip-1.1.3, tools.tooltip.slide-1.0.0, tools.tooltip.dynamic-1.0.1]
    * 
    * Copyright (c) 2009 Tero Piirainen
    * http://flowplayer.org/tools/
    *
    * Dual licensed under MIT and GPL 2+ licenses
    * http://www.opensource.org/licenses
    * 
    * -----
    * 
    * File generated: Thu Feb 25 11:13:17 GMT 2010
    */
    (function(c){var d=[];c.tools=c.tools||{};c.tools.tooltip={version:"1.1.3",conf:{effect:"toggle",fadeOutSpeed:"fast",tip:null,predelay:0,delay:30,opacity:1,lazy:undefined,position:["top","center"],offset:[0,0],cancelDefault:true,relative:false,oneInstance:true,events:{def:"mouseover,mouseout",input:"focus,blur",widget:"focus mouseover,blur mouseout",tooltip:"mouseover,mouseout"},api:false},addEffect:function(e,g,f){b[e]=[g,f]}};var b={toggle:[function(e){var f=this.getConf(),g=this.getTip(),h=f.opacity;if(h<1){g.css({opacity:h})}g.show();e.call()},function(e){this.getTip().hide();e.call()}],fade:[function(e){this.getTip().fadeIn(this.getConf().fadeInSpeed,e)},function(e){this.getTip().fadeOut(this.getConf().fadeOutSpeed,e)}]};function a(f,g){var p=this,k=c(this);f.data("tooltip",p);var l=f.next();if(g.tip){l=c(g.tip);if(l.length>1){l=f.nextAll(g.tip).eq(0);if(!l.length){l=f.parent().nextAll(g.tip).eq(0)}}}function o(u){var t=g.relative?f.position().top:f.offset().top,s=g.relative?f.position().left:f.offset().left,v=g.position[0];t-=l.outerHeight()-g.offset[0];s+=f.outerWidth()+g.offset[1];var q=l.outerHeight()+f.outerHeight();if(v=="center"){t+=q/2}if(v=="bottom"){t+=q}v=g.position[1];var r=l.outerWidth()+f.outerWidth();if(v=="center"){s-=r/2}if(v=="left"){s-=r}return{top:t,left:s}}var i=f.is(":input"),e=i&&f.is(":checkbox, :radio, select, :button"),h=f.attr("type"),n=g.events[h]||g.events[i?(e?"widget":"input"):"def"];n=n.split(/,\s*/);if(n.length!=2){throw"Tooltip: bad events configuration for "+h}f.bind(n[0],function(r){if(g.oneInstance){c.each(d,function(){this.hide()})}var q=l.data("trigger");if(q&&q[0]!=this){l.hide().stop(true,true)}r.target=this;p.show(r);n=g.events.tooltip.split(/,\s*/);l.bind(n[0],function(){p.show(r)});if(n[1]){l.bind(n[1],function(){p.hide(r)})}});f.bind(n[1],function(q){p.hide(q)});if(!c.browser.msie&&!i&&!g.predelay){f.mousemove(function(){if(!p.isShown()){f.triggerHandler("mouseover")}})}if(g.opacity<1){l.css("opacity",g.opacity)}var m=0,j=f.attr("title");if(j&&g.cancelDefault){f.removeAttr("title");f.data("title",j)}c.extend(p,{show:function(r){if(r){f=c(r.target)}clearTimeout(l.data("timer"));if(l.is(":animated")||l.is(":visible")){return p}function q(){l.data("trigger",f);var t=o(r);if(g.tip&&j){l.html(f.data("title"))}r=r||c.Event();r.type="onBeforeShow";k.trigger(r,[t]);if(r.isDefaultPrevented()){return p}t=o(r);l.css({position:"absolute",top:t.top,left:t.left});var s=b[g.effect];if(!s){throw'Nonexistent effect "'+g.effect+'"'}s[0].call(p,function(){r.type="onShow";k.trigger(r)})}if(g.predelay){clearTimeout(m);m=setTimeout(q,g.predelay)}else{q()}return p},hide:function(r){clearTimeout(l.data("timer"));clearTimeout(m);if(!l.is(":visible")){return}function q(){r=r||c.Event();r.type="onBeforeHide";k.trigger(r);if(r.isDefaultPrevented()){return}b[g.effect][1].call(p,function(){r.type="onHide";k.trigger(r)})}if(g.delay&&r){l.data("timer",setTimeout(q,g.delay))}else{q()}return p},isShown:function(){return l.is(":visible, :animated")},getConf:function(){return g},getTip:function(){return l},getTrigger:function(){return f},bind:function(q,r){k.bind(q,r);return p},onHide:function(q){return this.bind("onHide",q)},onBeforeShow:function(q){return this.bind("onBeforeShow",q)},onShow:function(q){return this.bind("onShow",q)},onBeforeHide:function(q){return this.bind("onBeforeHide",q)},unbind:function(q){k.unbind(q);return p}});c.each(g,function(q,r){if(c.isFunction(r)){p.bind(q,r)}})}c.prototype.tooltip=function(e){var f=this.eq(typeof e=="number"?e:0).data("tooltip");if(f){return f}var g=c.extend(true,{},c.tools.tooltip.conf);if(c.isFunction(e)){e={onBeforeShow:e}}else{if(typeof e=="string"){e={tip:e}}}e=c.extend(true,g,e);if(typeof e.position=="string"){e.position=e.position.split(/,?\s/)}if(e.lazy!==false&&(e.lazy===true||this.length>20)){this.one("mouseover",function(h){f=new a(c(this),e);f.show(h);d.push(f)})}else{this.each(function(){f=new a(c(this),e);d.push(f)})}return e.api?f:this}})(jQuery);
    (function(b){var a=b.tools.tooltip;a.effects=a.effects||{};a.effects.slide={version:"1.0.0"};b.extend(a.conf,{direction:"up",bounce:false,slideOffset:10,slideInSpeed:200,slideOutSpeed:200,slideFade:!b.browser.msie});var c={up:["-","top"],down:["+","top"],left:["-","left"],right:["+","left"]};b.tools.tooltip.addEffect("slide",function(d){var f=this.getConf(),g=this.getTip(),h=f.slideFade?{opacity:f.opacity}:{},e=c[f.direction]||c.up;h[e[1]]=e[0]+"="+f.slideOffset;if(f.slideFade){g.css({opacity:0})}g.show().animate(h,f.slideInSpeed,d)},function(e){var g=this.getConf(),i=g.slideOffset,h=g.slideFade?{opacity:0}:{},f=c[g.direction]||c.up;var d=""+f[0];if(g.bounce){d=d=="+"?"-":"+"}h[f[1]]=d+"="+i;this.getTip().animate(h,g.slideOutSpeed,function(){b(this).hide();e.call()})})})(jQuery);
    (function(d){var c=d.tools.tooltip;c.plugins=c.plugins||{};c.plugins.dynamic={version:"1.0.1",conf:{api:false,classNames:"top right bottom left"}};function b(h){var e=d(window);var g=e.width()+e.scrollLeft();var f=e.height()+e.scrollTop();return[h.offset().top<=e.scrollTop(),g<=h.offset().left+h.width(),f<=h.offset().top+h.height(),e.scrollLeft()>=h.offset().left]}function a(f){var e=f.length;while(e--){if(f[e]){return false}}return true}d.fn.dynamic=function(g){var h=d.extend({},c.plugins.dynamic.conf),f;if(typeof g=="number"){g={speed:g}}g=d.extend(h,g);var e=g.classNames.split(/\s/),i;this.each(function(){if(d(this).tooltip().jquery){throw"Lazy feature not supported by dynamic plugin. set lazy: false for tooltip"}var j=d(this).tooltip().onBeforeShow(function(n,o){var m=this.getTip(),l=this.getConf();if(!i){i=[l.position[0],l.position[1],l.offset[0],l.offset[1],d.extend({},l)]}d.extend(l,i[4]);l.position=[i[0],i[1]];l.offset=[i[2],i[3]];m.css({visibility:"hidden",position:"absolute",top:o.top,left:o.left}).show();var k=b(m);if(!a(k)){if(k[2]){d.extend(l,g.top);l.position[0]="top";m.addClass(e[0])}if(k[3]){d.extend(l,g.right);l.position[1]="right";m.addClass(e[1])}if(k[0]){d.extend(l,g.bottom);l.position[0]="bottom";m.addClass(e[2])}if(k[1]){d.extend(l,g.left);l.position[1]="left";m.addClass(e[3])}if(k[0]||k[2]){l.offset[0]*=-1}if(k[1]||k[3]){l.offset[1]*=-1}}m.css({visibility:"visible"}).hide()});j.onShow(function(){var l=this.getConf(),k=this.getTip();l.position=[i[0],i[1]];l.offset=[i[2],i[3]]});j.onHide(function(){var k=this.getTip();k.removeClass(g.classNames)});f=j});return g.api?f:this}})(jQuery);
    
    
    /**
     * Send a vote via AJAX and process the result
     * @param voteButton The HTMLElement <button> that was clicked
     */
     
    $.fn.voter = function(options) {
        var defaults = {            
            agreeSelector:'.agree',
            disagreeSelector:'.disagree'
        };    

        var options = $.extend(defaults, options);
        
        var processVote = function($el, postData){                           
            $.ajax({
                    url:bvt_sfa_ajax_url,
                    data:postData,
                    dataType:'json',
                    type:'POST',
                    success:function(data, textStatus, XMLHttpRequest){   
                        if(data.result == 'new_nonce'){                                
                            bvt_cookie.set("bvt_sfa_nonce", data.data, {
                                           path: "/",
                                           maxAge: 3000000  // roughly 1 month
                            });
                            $el.trigger('click');                                                   
                        }
                        else if(data.result == 'ok'){
                            var $count = $el.find('strong').eq(0);
                            var count = parseInt($count.text());                
                            count = count +1;
                            $count.fadeOut(5, function(){
                                $count.text(count);
                                $count.fadeIn();
                                 feedback($el, '.bvt-sfa-info', "Din mening er registrert");   
                            }); 
                            
                        
                        }
                        else if(data.result == 'error'){
                            var api = $el.tooltip();                            
                            api.hide();
                            feedback($el, '.bvt-sfa-error', "en feil oppstod.");

                        }                       
                        else if(data.result == 'already_voted'){
                            var api = $el.tooltip();                            
                            api.hide();
                            feedback($el, '.bvt-sfa-error', "Du har allerede stemt");                            
                        }                                               
                    },
                    error:function(xhr, textStatus, errorThrown){
                        feedback($el, '.bvt-sfa-error', "en feil oppstod: "+textStatus);
                    }
                    
            });            
        }
        var feedback = function($el, selector, feedback){
            var $vote = $el.parent('.vote');
            var $feedback = $vote.find(selector);
            if($feedback.length > 0){
               $feedback.text(feedback);
               $feedback.show().fadeOut(5000);               
            }
            else{
                $feedback = $('<div class="bvt-sfa-feedback '+selector.replace('.','')+'">'+feedback+'</div>').appendTo($vote);
                $feedback.fadeOut(5000);
            }            
        }
        
        return this.each(function(index, el) {
                
            var $this = $(this);            
            var $disagree = $this.find(options.disagreeSelector);
            var $agree = $this.find(options.agreeSelector);
            
            $('<button type="button">Enig</button>')
                            .prependTo($agree);                           
            
            $('<button type="button">Uenig</button>')
                            .prependTo($disagree);               
                            
            var id = $this.find(".post_id").eq(0).attr('value');
            
            var  postData = {
                "action": "bvt_sfa_vote",
                "bvt_sfa_post_id": id,
                "bvt_sfa_vote_type": ''
            };
            
            $agree.bind('click', function(){
                var $this = $(this);
                postData.bvt_sfa_vote_type = 'up';
                processVote($this, postData);                
                return false;
            });   
            
            $disagree.bind('click', function(){
                var $this = $(this);
                postData.bvt_sfa_vote_type = 'down';
                processVote($this, postData);          
                return false;
            })
        });
    };
    $(document).ready(function(){
        $('.bvt_sfa_feedlist .vote').voter();
        $('.bvt_sfa_feedlist .decision').tooltip({
            // use div.tooltip as our tooltip 
            tip: '#bvt_sfa_tooltip',
            offset: [-5, 0]
         });
        var $iframe = $('<iframe frameborder="0" width="90" height="20"></iframe>'); 
        $(".bvt_sfa_item").each(function(){
            var $this = $(this);            
            var $link = $this.find('.external');             
            var url = escape($link.attr('href')); 
            //quicker            
            var $new_iframe = $iframe.clone();            
            var tweetmemeurl = 'http://api.tweetmeme.com/button.js?url='+url+'&style=compact';            
            $new_iframe.attr("src", tweetmemeurl);
            $this.find('.tweetmeme').append($new_iframe);
        });        
    })
});
/*
 * main JS Document for Blogs@MLU Home Theme
 * Copyright (c) 2009 Matthias Kretschmann | krema@jpberlin.de
 * http://matthiaskretschmann.com
 * http://kremalicious.com
 */

var $ = jQuery.noConflict();

/*
 * In-Field Label jQuery Plugin
 * http://fuelyourcoding.com/scripts/infield.html
 *
 * Copyright (c) 2009 Doug Neiner
 * Dual licensed under the MIT and GPL licenses.
 * Uses the same license as jQuery, see:
 * http://docs.jquery.com/License
 *
 * @version 0.1
 */
(function($){$.InFieldLabels=function(b,c,d){var f=this;f.$label=$(b);f.label=b;f.$field=$(c);f.field=c;f.$label.data("InFieldLabels",f);f.showing=true;f.init=function(){f.options=$.extend({},$.InFieldLabels.defaultOptions,d);if(f.$field.val()!=""){f.$label.hide();f.showing=false};f.$field.focus(function(){f.fadeOnFocus()}).blur(function(){f.checkForEmpty(true)}).bind('keydown.infieldlabel',function(e){f.hideOnChange(e)}).change(function(e){f.checkForEmpty()}).bind('onPropertyChange',function(){f.checkForEmpty()})};f.fadeOnFocus=function(){if(f.showing){f.setOpacity(f.options.fadeOpacity)}};f.setOpacity=function(a){f.$label.stop().animate({opacity:a},f.options.fadeDuration);f.showing=(a>0.0)};f.checkForEmpty=function(a){if(f.$field.val()==""){f.prepForShow();f.setOpacity(a?1.0:f.options.fadeOpacity)}else{f.setOpacity(0.0)}};f.prepForShow=function(e){if(!f.showing){f.$label.css({opacity:0.0}).show();f.$field.bind('keydown.infieldlabel',function(e){f.hideOnChange(e)})}};f.hideOnChange=function(e){if((e.keyCode==16)||(e.keyCode==9))return;if(f.showing){f.$label.hide();f.showing=false};f.$field.unbind('keydown.infieldlabel')};f.init()};$.InFieldLabels.defaultOptions={fadeOpacity:0.5,fadeDuration:300};$.fn.inFieldLabels=function(c){return this.each(function(){var a=$(this).attr('for');if(!a)return;var b=$("input#"+a+"[type='text'],"+"input#"+a+"[type='password'],"+"textarea#"+a);if(b.length==0)return;(new $.InFieldLabels(this,b[0],c))})}})(jQuery);

//Live Search plug-in | http://andreaslagerkvist.com/jquery/live-search/
jQuery.fn.liveSearch=function(conf){var config=jQuery.extend({url:'/?module=SearchResults&q=',id:'jquery-live-search',duration:400,typeDelay:200,loadingClass:'loading',onSlideUp:function(){}},conf);var liveSearch=jQuery('#'+config.id);if(!liveSearch.length){liveSearch=jQuery('<div id="'+config.id+'"></div>').appendTo(document.body).hide().slideUp(0);jQuery(document.body).click(function(event){var clicked=jQuery(event.target);if(!(clicked.is('#'+config.id)||clicked.parents('#'+config.id).length||clicked.is('input'))){liveSearch.slideUp(config.duration,function(){config.onSlideUp()})}})}return this.each(function(){var input=jQuery(this).attr('autocomplete','off');var resultsShit=parseInt(liveSearch.css('paddingLeft'),10)+parseInt(liveSearch.css('paddingRight'),10)+parseInt(liveSearch.css('borderLeftWidth'),10)+parseInt(liveSearch.css('borderRightWidth'),10);input.focus(function(){if(this.value!==''){if(liveSearch.html()==''){this.lastValue='';input.keyup()}else{liveSearch.slideDown(config.duration)}}}).keyup(function(){if(this.value!=this.lastValue){input.addClass(config.loadingClass);var q=this.value;if(this.timer){clearTimeout(this.timer)}this.timer=setTimeout(function(){jQuery.get(config.url+q,function(data){input.removeClass(config.loadingClass);if(data.length&&q.length){var tmpOffset=input.offset();var inputDim={left:tmpOffset.left,top:tmpOffset.top,width:input.outerWidth(),height:input.outerHeight()};inputDim.topNHeight=inputDim.top+inputDim.height;inputDim.widthNShit=inputDim.width-resultsShit;liveSearch.css({position:'absolute',left:inputDim.left+'px',top:inputDim.topNHeight+'px',width:inputDim.widthNShit+'px'});liveSearch.html(data).slideDown(config.duration)}else{liveSearch.slideUp(config.duration,function(){config.onSlideUp()})}})},config.typeDelay);this.lastValue=this.value}})})};

// Twitter Plugin
(function(a){a.fn.tweet=function(c){var k=a.extend({username:null,list:null,favorites:false,query:null,avatar_size:null,count:3,fetch:null,page:1,retweets:true,intro_text:null,outro_text:null,join_text:null,auto_join_text_default:"i said,",auto_join_text_ed:"i",auto_join_text_ing:"i am",auto_join_text_reply:"i replied to",auto_join_text_url:"i was looking at",loading_text:null,refresh_interval:null,twitter_url:"twitter.com",twitter_api_url:"api.twitter.com",twitter_search_url:"search.twitter.com",template:"{avatar}{time}{join}{text}",comparator:function(m,l){return l.tweet_time-m.tweet_time},filter:function(l){return true}},c);var b=/\b((?:[a-z][\w-]+:(?:\/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'".,<>?«»“”‘’]))/gi;function j(n,o){if(typeof n==="string"){var l=n;for(var m in o){var p=o[m];l=l.replace(new RegExp("{"+m+"}","g"),p===null?"":p)}return l}else{return n(o)}}a.extend({tweet:{t:j}});function e(m,l){return function(){var n=[];this.each(function(){n.push(this.replace(m,l))});return a(n)}}a.fn.extend({linkUrl:e(b,function(m){var l=(/^[a-z]+:/i).test(m)?m:"http://"+m;return'<a href="'+l+'">'+m+"</a>"}),linkUser:e(/@(\w+)/gi,'@<a href="http://'+k.twitter_url+'/$1">$1</a>'),linkHash:e(/(?:^| )[\#]+([\w\u00c0-\u00d6\u00d8-\u00f6\u00f8-\u00ff\u0600-\u06ff]+)/gi,' <a href="http://'+k.twitter_search_url+"/search?q=&tag=$1&lang=all"+((k.username&&k.username.length==1)?"&from="+k.username.join("%2BOR%2B"):"")+'">#$1</a>'),capAwesome:e(/\b(awesome)\b/gi,'<span class="awesome">$1</span>'),capEpic:e(/\b(epic)\b/gi,'<span class="epic">$1</span>'),makeHeart:e(/(&lt;)+[3]/gi,"<tt class='heart'>&#x2665;</tt>")});function i(l){return Date.parse(l.replace(/^([a-z]{3})( [a-z]{3} \d\d?)(.*)( \d{4})$/i,"$1,$2$4$3"))}function g(l){var n=(arguments.length>1)?arguments[1]:new Date();var o=parseInt((n.getTime()-l)/1000,10);var m="";if(o<60){m=o+" seconds ago"}else{if(o<120){m="a minute ago"}else{if(o<(45*60)){m=(parseInt(o/60,10)).toString()+" minutes ago"}else{if(o<(2*60*60)){m="an hour ago"}else{if(o<(24*60*60)){m=""+(parseInt(o/3600,10)).toString()+" hours ago"}else{if(o<(48*60*60)){m="a day ago"}else{m=(parseInt(o/86400,10)).toString()+" days ago"}}}}}}return"about "+m}function f(l){if(l.match(/^(@([A-Za-z0-9-_]+)) .*/i)){return k.auto_join_text_reply}else{if(l.match(b)){return k.auto_join_text_url}else{if(l.match(/^((\w+ed)|just) .*/im)){return k.auto_join_text_ed}else{if(l.match(/^(\w*ing) .*/i)){return k.auto_join_text_ing}else{return k.auto_join_text_default}}}}}function d(){var m=("https:"==document.location.protocol?"https:":"http:");var l=(k.fetch===null)?k.count:k.fetch;if(k.list){return m+"//"+k.twitter_api_url+"/1/"+k.username[0]+"/lists/"+k.list+"/statuses.json?page="+k.page+"&per_page="+l+"&callback=?"}else{if(k.favorites){return m+"//"+k.twitter_api_url+"/favorites/"+k.username[0]+".json?page="+k.page+"&count="+l+"&callback=?"}else{if(k.query===null&&k.username.length==1){return m+"//"+k.twitter_api_url+"/1/statuses/user_timeline.json?screen_name="+k.username[0]+"&count="+l+(k.retweets?"&include_rts=1":"")+"&page="+k.page+"&callback=?"}else{var n=(k.query||"from:"+k.username.join(" OR from:"));return m+"//"+k.twitter_search_url+"/search.json?&q="+encodeURIComponent(n)+"&rpp="+l+"&page="+k.page+"&callback=?"}}}}function h(l){var m={};m.item=l;m.source=l.source;m.screen_name=l.from_user||l.user.screen_name;m.avatar_size=k.avatar_size;m.avatar_url=l.profile_image_url||l.user.profile_image_url;m.retweet=typeof(l.retweeted_status)!="undefined";m.tweet_time=i(l.created_at);m.join_text=k.join_text=="auto"?f(l.text):k.join_text;m.tweet_id=l.id_str;m.twitter_base="http://"+k.twitter_url+"/";m.user_url=m.twitter_base+m.screen_name;m.tweet_url=m.user_url+"/status/"+m.tweet_id;m.reply_url=m.twitter_base+"intent/tweet?in_reply_to="+m.tweet_id;m.retweet_url=m.twitter_base+"intent/retweet?tweet_id="+m.tweet_id;m.favorite_url=m.twitter_base+"intent/favorite?tweet_id="+m.tweet_id;m.retweeted_screen_name=m.retweet&&l.retweeted_status.user.screen_name;m.tweet_relative_time=g(m.tweet_time);m.tweet_raw_text=m.retweet?("RT @"+m.retweeted_screen_name+" "+l.retweeted_status.text):l.text;m.tweet_text=a([m.tweet_raw_text]).linkUrl().linkUser().linkHash()[0];m.tweet_text_fancy=a([m.tweet_text]).makeHeart().capAwesome().capEpic()[0];m.user=j('<a class="tweet_user" href="{user_url}">{screen_name}</a>',m);m.join=k.join_text?j(' <span class="tweet_join">{join_text}</span> ',m):" ";m.avatar=m.avatar_size?j('<a class="tweet_avatar" href="{user_url}"><img src="{avatar_url}" height="{avatar_size}" width="{avatar_size}" alt="{screen_name}\'s avatar" title="{screen_name}\'s avatar" border="0"/></a>',m):"";m.time=j('<span class="tweet_time"><a href="{tweet_url}" title="view tweet on twitter">{tweet_relative_time}</a></span>',m);m.text=j('<span class="tweet_text">{tweet_text_fancy}</span>',m);m.reply_action=j('<a class="tweet_action tweet_reply" href="{reply_url}">reply</a>',m);m.retweet_action=j('<a class="tweet_action tweet_retweet" href="{retweet_url}">retweet</a>',m);m.favorite_action=j('<a class="tweet_action tweet_favorite" href="{favorite_url}">favorite</a>',m);return m}return this.each(function(m,p){var o=a('<ul class="tweet_list">').appendTo(p);var n='<p class="tweet_intro">'+k.intro_text+"</p>";var l='<p class="tweet_outro">'+k.outro_text+"</p>";var q=a('<p class="loading">'+k.loading_text+"</p>");if(k.username&&typeof(k.username)=="string"){k.username=[k.username]}if(k.loading_text){a(p).append(q)}a(p).bind("tweet:load",function(){a.getJSON(d(),function(r){if(k.loading_text){q.remove()}if(k.intro_text){o.before(n)}o.empty();var s=a.map(r.results||r,h);s=a.grep(s,k.filter).sort(k.comparator).slice(0,k.count);o.append(a.map(s,function(t){return"<li>"+j(k.template,t)+"</li>"}).join("")).children("li:first").addClass("tweet_first").end().children("li:odd").addClass("tweet_even").end().children("li:even").addClass("tweet_odd");if(k.outro_text){o.after(l)}a(p).trigger("loaded").trigger((s.length===0?"empty":"full"));if(k.refresh_interval){window.setTimeout(function(){a(p).trigger("tweet:load")},1000*k.refresh_interval)}})}).trigger("tweet:load")})}})(jQuery);

// jQuery Cookie plug-in
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('o.5=q(b,9,2){7(h 9!=\'x\'){2=2||{};7(9===j){9=\'\';2=$.v({},2);2.3=-1}4 3=\'\';7(2.3&&(h 2.3==\'m\'||2.3.l)){4 6;7(h 2.3==\'m\'){6=t u();6.s(6.w()+(2.3*r*p*p*z))}k{6=2.3}3=\'; 3=\'+6.l()}4 8=2.8?\'; 8=\'+(2.8):\'\';4 a=2.a?\'; a=\'+(2.a):\'\';4 c=2.c?\'; c\':\'\';d.5=[b,\'=\',E(9),3,8,a,c].y(\'\')}k{4 e=j;7(d.5&&d.5!=\'\'){4 g=d.5.F(\';\');D(4 i=0;i<g.f;i++){4 5=o.C(g[i]);7(5.n(0,b.f+1)==(b+\'=\')){e=B(5.n(b.f+1));G}}}A e}};',43,43,'||options|expires|var|cookie|date|if|path|value|domain|name|secure|document|cookieValue|length|cookies|typeof||null|else|toUTCString|number|substring|jQuery|60|function|24|setTime|new|Date|extend|getTime|undefined|join|1000|return|decodeURIComponent|trim|for|encodeURIComponent|split|break'.split('|'),0,{}))

this.tooltip = function(){	
		xOffset = -15;
		yOffset = -10;				
	$(".infopopup").hover(function(e){											  
		this.t = this.title;
		this.title = "";									  
		$("body").append("<p id='tooltip'>"+ this.t +"</p>");
		$("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
    },
	function(){
		this.title = this.t;		
		$("#tooltip").remove();
    });	
	$(".tooltip").mousemove(function(e){
		$("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});			
};

//Start the real fun
jQuery(function($) {//DOMdiDOM
	
	if (!$('.mu_register').length) {
		$('label').inFieldLabels();
    }
    
    //Front-End login and admin
	var $panel = $('#front-admin > *:not(#login-link)')
	$('#login-link').click(function(){
		if ($panel.is(":hidden")) {
			$panel.slideDown('normal');
			$.cookie('panelState', 'expanded');
		return false;
	} else {
		$panel.slideUp('normal');
		$.cookie('panelState', 'collapsed');
	return false;
	}
	});
    var panelCookie = $.cookie('panelState');
    if (panelCookie == 'collapsed') {
 		$panel.hide();
 	}
    
    //Open pdf links in new window
    $('a[href*=".pdf"]').click(function(){
		window.open(this.href);
	return false;
	});
	
	//init live search
	$('#s').liveSearch({url: '/index.php?ajax=1&s='});
	
	//Thickbox on linked images
	$('.hentry a').filter('[href$=".png"],[href$=".PNG"],[href$=".jpg"],[href$=".JPG"],[href$=".gif"],[href$=".GIF"]').addClass('thickbox').attr('rel','thickbox-gallery');
	
	//Pretty Simple Tab Interfaces
	var tabContainers = $('#posts > .panel');
	var tabNav = $('#posts ul.tab-menu a');
	
	tabContainers.hide().filter(':first').show();
    tabNav.click(function () {
	    tabContainers.fadeOut(200).hide();
	    tabContainers.filter(this.hash).fadeIn(200).show();
	    tabNav.removeClass('selected');
	    $(this).addClass('selected');
	    return false;
    });
    
    var tabContainers2 = $('#blogs > .panel');
	var tabNav2 = $('#blogs ul.tab-menu a');
	
	tabContainers2.hide().filter(':first').show();
    tabNav2.click(function () {
	    tabContainers2.fadeOut(200).hide();
	    tabContainers2.filter(this.hash).fadeIn(200).show();
	    tabNav2.removeClass('selected');
	    $(this).addClass('selected');
	    return false;
    });
	
});//don't delete me or the DOM will collaps

//Finally load all this after the content has loaded
jQuery(window).load(function() {
	
	//Twitter integration
	//http://tweet.seaofclouds.com/
	$("#tweets").nextAll("p").andSelf().remove();
	/*
	.tweet({
		username: "mlublogs",
	    query: "mlublogs",
	    join_text: "",
	    avatar_size: 27,
	    count: 4,
	    loading_text: "tweets werden geladen…",
	    template: "{avatar}{text}{time}{join}"
	});
	*/
	
	//Info Popup
	tooltip();
	
});



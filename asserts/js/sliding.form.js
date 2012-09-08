$(function() {
	var current 	= 1;
	var tabsWidth	= 0;
   var widths 		= new Array();
	$('#tabs .tab').each(function(i){
        var $tab 		= $(this);
			widths[i]  		= tabsWidth;
        tabsWidth	 	+= $tab.width();
   });
	$('#tabs').width(tabsWidth);
	$('.menu a').bind('click',function(e){
		var $this	= $(this);
		var prev	= current;
		$this.closest('ul').find('li').removeClass('active');
		$this.parent().addClass('active');
		current = $this.parent().index();
		$('#tabs').stop().animate({
			marginLeft: '-' + widths[current] + 'px'
		},500,function(){});
		//if the page is not loaded yet
		loadPage();
		e.preventDefault();
	});
   //set the default
   $("ul.menu li:first-child").addClass('active');
	$('#tabs').stop().animate({marginLeft: '-' + widths[(current-1)] + 'px'},500,function(){});

   $("#refresh-btn").click(function(){
		loadPage()
   });
   loadPage();
});
function loadPage(){
	var url = $('ul.menu li.active a').attr('href');
	$.ajax({
		url: 'page.php?page='+url,
		dataType: 'json'
	}).done(function(r){
		$('#contols').html(r.controls);
		$('#tabs #'+url).html(r.body);
	});
}

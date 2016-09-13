$(document).ready(function () {
    // Plugin initialization
    $('.slider').slider({
    full_width: false,
    interval:4000,
    transition:800,
        height:500
  });
});
$(document).ready(function(){
      $('.carousel').carousel();
    });
$('.datepicker').pickadate({ selectMonths: true,  selectYears: 1000, format: 'yyyy-mm-dd' });
  $(document).ready(function(){
    $('.tooltipped').tooltip({delay: 50});
  });

//inicializando one page

$(document).ready(function() {
	$('#fullpage').fullpage({
		menu: '#menu',
		anchors: ['firstPage', 'secondPage', '3rdPage', '4thPage', '5thPage' ],
		//sectionsColor: ['#C63D0F', '#1BBC9B', '#7E8F7C', '#7E2F7C'],
		autoScrolling: false,
		//verticalCentered: false,
		scrollOverflow: true,
		css3:false
	});
});
   
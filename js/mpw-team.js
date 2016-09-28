jQuery(document).ready( function () {
	origContent = jQuery('#main-service').html();
	origTitle = '';
	origPos = '';
	var winWidth = window.innerWidth;
	jQuery( window ).resize(function() {
  winWidth = window.innerWidth;
  if ( winWidth > 600 ) {
  	jQuery('.team-member-info').hide(500);
  }
  if ( winWidth < 601 ) {
  	  docReset(origTitle, origPos, origContent);
  }
});

	jQuery('.team-member-img-container').on('click', function(e) {
			e.preventDefault();
			if (!jQuery( this ).parent('.team-member').hasClass('active') ){
			jQuery('.team-member').removeClass('active');
			jQuery( this ).parent('.team-member').addClass('active');
			jQuery('.team-member-info').hide(500);
		}
		jQuery('.contact-link').show();
			var position = jQuery(this).position();
			//console.log(getViewportTop());
			//console.log('el top '+getElementTop('.team-description-col'));
			var marTop = getViewportTop() - getElementTop('.team-description-col');
			//console.log('martop is '+marTop);
			if (jQuery('body').hasClass('admin-bar')){
				marTop = marTop + 30;
			}
			if ( marTop > 0 ){
					jQuery('.team-description').css('margin-top',marTop+'px');
			} else {
					jQuery('.team-description').css('margin-top','0');
			}

			jQuery('.team-description .entry-title').html(jQuery( this ).find('.entry-title').html());
			jQuery('.team-description .job-title').html(jQuery( this ).parent().find('.team-member-info .job-title').html());
			jQuery('.team-description .team-member-content').html(jQuery( this ).parent().find('.team-member-info .team-member-description').html());
			jQuery('.team-description .contact-link').html(jQuery( this ).parent().find('.team-member-info .contact-link').html());
			jQuery('.team-description .contact-link').attr('data-shortname', jQuery( this ).parent().find('.team-member-info .contact-link').attr('data-shortname'));
			if (winWidth < 601 ){
				jQuery( this ).parent('.team-member').children('.team-member-info').show(500);
			}
	});
	jQuery( window ).scroll( function () {
		resetDescriptionMargin();
	});
	jQuery('.contact-link').on('click', function(e){
console.log(jQuery(this).attr('data-shortname'));
		jQuery('.recip-text').val(jQuery(this).attr('data-shortname'));
	})
})
function docReset (origTitle, origPos, origContent) {
	jQuery('.team-description .entry-title').html(origTitle);
	jQuery('.team-description .job-title').html(origPos);
	jQuery('.team-description .team-member-main').html(origContent);
	jQuery('.team-description').css('margin-top','0');
}
function loadTeamMember () {
			jQuery('.team-member').removeClass('active');
		jQuery( this ).addClass('active');
		var position = jQuery(this).position();
		console.log(position.top);
		jQuery('.team-description').css('top',position.top);
		jQuery('.team-description .entry-title').html(jQuery( this ).find('.entry-title').html())
		jQuery('.team-description .job-title').html(jQuery( this ).find('.team-member-info .job-title').html())
		jQuery('.team-description .team-member-main').html(jQuery( this ).find('.team-member-info .team-member-description').html())
}
getViewport2 = function() {
    var w = jQuery(window);
    return {
        l: w.scrollLeft(),
        t: w.scrollTop(),
        w: w.width(),
        h: w.height() 
    }
}

getViewportTop = function() {
    var w = jQuery(window);
    return w.scrollTop();
}

getElementTop = function (elementToGet) {
	var posi = jQuery(elementToGet).offset();
	return posi.top;
}
getElementTopLast = function (elementToGet) {
	var posi = jQuery(elementToGet).last().offset();
	return posi.top;
}
getElementBottom = function (elementToGet) {
	var posi = jQuery(elementToGet).offset();
	var offTop = posi.top;
	var elHeight = jQuery(elementToGet).outerHeight();
	console.log(offTop);
	console.log (elHeight);
	var bottom = offTop + elHeight;
	console.log(bottom);
	return bottom;
}
resetDescriptionMargin = function () {
	var vTop = getViewportTop();
	var eltop =  getElementTop('.team-description-col');
	var marTop = getViewportTop() - getElementTop('.team-description-col');
	var marBot = getElementTopLast('.team-member')-eltop;
	var marAdjustment = 10;
		console.log(vTop);
		console.log(eltop);
			console.log('martop is '+marTop);
			console.log('marbot is '+marBot);
	marTopAdj = marTop + marAdjustment;
	marBotAdj = marBot + (marAdjustment * 5);
			if (jQuery('body').hasClass('admin-bar')){
				marTop = marTop + 30;
				marTopAdj = marTopAdj + 30;
			}
						console.log('martopadj is '+marTopAdj);
			console.log('marbotadj is '+marBotAdj);
			if ( marTop > 0 && marTopAdj < marBotAdj ){
					jQuery('.team-description').css('margin-top',marTopAdj+'px');
			} else if ( marTop > 0 ){
					jQuery('.team-description').css('margin-top',marBotAdj+'px');
			} else {
					jQuery('.team-description').css('margin-top','0');
			}
}
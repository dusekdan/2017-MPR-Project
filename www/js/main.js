/**
 * Po nacteni
 */
$(document).ready(function(e)
{
	/**
	 * Aktivace animace flashzpráv
	 */
	flashMessageAnimation();
	/**
	 * Pro podlisti s danou tridu se daji rozjizdet
	 */
	sublist = $('.sublist');
	sublist.parent().click(function(event) {
		event.stopPropagation(); // kvuli probublavani
		$(this).children('ul.sublist').slideToggle();
		$(this).children('ul').find('ul.sublist').css('display','none');
		$(this).toggleClass('rolled-up');
		$(this).toggleClass('rolled-down');
	});
});

/**
 * Pri resize
 */
$(window).resize(function (e) {
	resetMenu();
});

/**
 * Hamburger menu animace - pridanim tridy
 */
function scrollToggleMenu(elem, id)
{
	$(elem).toggleClass('open');
	$(id).slideToggle();
}

function resetMenu()
{
	$('#menu').css('display',''); // u menu zustane po volani toggleClass display none
	$('.menu-hamburger').removeClass('open'); // pokud pri resize zavru menu musim navratit i stav hamburgeru
}


/**
 * Obsluha elementu pro soubory
 * @param inputHiddenId
 */
function setFile(inputHiddenId) {
	// vytahnem si pocet souboru a jmeno souboru a vyvolame si vlastni akci fileSelectAction
	$(inputHiddenId).hide();
	$(document).on('change', inputHiddenId, function() {
		var input = $(this),
			numFiles = input.get(0).files ? input.get(0).files.length : 1,
			fileName = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileSelectAction', [numFiles, fileName]);
	});

	$(document).ready( function() {
		// vlastní událost - vlozi text do textoveho inputu
		$(inputHiddenId).on('fileSelectAction', function(event, numFiles, fileName) {
			var input = $(this).prev().prev().prev();
			message = numFiles > 1 ? numFiles + ' vybrané soubory' : fileName;
			input.val(message);
		});
	});
}


/**
 * Odesílání formuláře při skrytém tlačítku. např na onchange při něčem
 */
function sendForm(element)
{
	element.form.submit();
}

/**
 * Zobrazování flashzpáv postupně a jejich schovávání
 * v případě výstrahy, tak ta se neschová
 */
function flashMessageAnimation()
{
	var length = $('.flash-message').length;
	for(i=0; i<length ; i++){
		if($('.flash-message').eq(i).hasClass('alert-danger')){
			$('.flash-message').eq(i).slideDown();
		}else{
			$('.flash-message').eq(i).delay(i*4000).slideDown().delay(3000).slideUp(function() {
				$(this).remove();
			});
		}
	}
}
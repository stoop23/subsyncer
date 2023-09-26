/*
	By Osvaldas Valutis, www.osvaldas.info
	Available for use under the MIT License
*/

'use strict';
;( function ( document, window, index )
{
	var inputs = document.querySelectorAll( '.inputfile' );
	Array.prototype.forEach.call( inputs, function( input )
	{
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function( e )
		{
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});

		// Firefox bug fix
		input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
		input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
	});
}( document, window, 0 ));

/* Check if jQuery is loaded or not.
 */
if (typeof jQuery == 'undefined') {
	(function (e, t, n) { var r = e.querySelectorAll("html")[0]; r.className = r.className.replace(/(^|\s)js(\s|$)/, "$1no-js$2") })(document, window, 0);
}



$(document).ready(function () {
	/* Drag & Drop Feature
	 * Prevents drops in window that would open the file in another tab
	 * Sets class to show dropping zone
	 */
	$("html").on("dragenter dragover drop", function (e) {
		e.preventDefault();
		e.stopPropagation();
	});
	var obj = $("#file--label");
	obj.on('dragenter dragover', function (e) {
		e.stopPropagation();
		e.preventDefault();
		$(this).addClass('dragging');
	});
	obj.on('dragleave', function (e) {
		e.preventDefault();
		e.stopPropagation();
		$(this).removeClass('dragging');
	});
	obj.on('drop', function (e) {
		e.stopPropagation();
		e.preventDefault();
		$(this).removeClass('dragging');

		// Makes sure that only 1 file was selected. Text is changed if 1 file is selected otherwise stays unchanged.
		if (e.originalEvent.dataTransfer.files.length == 1) {
			var fileName = e.originalEvent.dataTransfer.files[0].name;
			obj.attr("data-text", fileName.replace(/.*(\/|\\)/, ''));
			$("input[type='file']").prop("files", e.originalEvent.dataTransfer.files);
			obj.removeClass('submit-error');
			obj.addClass('submit-ready');
		} else {
			console.log("Only 1 file at once");
		}
	});

	/* Puts the name of the selected file in the :after pseudo element
	 * 23/11/2020 Added: Changed the on.() function into its into independent function.
	 * Can now be triggered when files are kept in the session (as files do not get cleared when going back from the browser's back button) allowing users to re-submit without re-selecting their files.
	 */
	$("form").on("change", ".file-upload-field", checkAddFile);
	if ($('.file-upload-field').length) {
		if ($('.file-upload-field').val().length >= 1) { checkAddFile(); }
	}

	function checkAddFile() {
		var id = $('.file-upload-field');
		for (var i = 0; i < id[0].files.length;i++) {
			console.log(id[0].files[i].name);
		}
		if (id[0].files.length == 1) {
			id.next().attr("data-text", id.val().replace(/.*(\/|\\)/, ''));
		} else {
			id.next().attr("data-text", id[0].files.length + " File(s) Selected");
		}
		id.next().removeClass('submit-error');
		id.next().addClass('submit-ready');
	}

	/* Prevents the form from being submitted if no file is selected
	 * If no file is selected output a border
	 */
	$('.btn-submit').click(function (e) {
		$('.file-upload-field').each(function () {
			if ($(this).val().length == 0) {
				$(this).next().addClass('submit-error');
				e.preventDefault();
			}
		});
	});

	/* Logic for the buttons
	 */
	//if ($('.btn-list').length) { }
	$(function () {
		$('.btn-list a').click(function () {
			$('.submit-list button').hide(); // reset
			$('.settings div').css('display', 'none'); // reset
			if (!$(this).hasClass('active')) {
				$('.btn-list a').removeClass('active'); // reset
				$(this).addClass('active');
				$('#btn-' + $(this).attr('target')).show();
				$('#settingBtn-' + $(this).attr('target')).css('display', 'inline-block');
			} else {
				$('.btn-list a').removeClass('active'); // reset
			}
		});
	});

	/* Logic for timecodeShift
	 */
	$('.timecodeShiftDisable').click(function () {
		console.log($(this).attr('target'));
		if ($('input[name=' + $(this).attr('target') + ']').attr('disabled')) {
			$('input[name=' + $(this).attr('target') + ']').removeAttr('disabled');
			$(this).text("Ignore");
		} else {
			$('input[name=' + $(this).attr('target') + ']').attr('disabled', 'disabled');
			$(this).text("Set");
		}
	});

	/* Logic for the clipboard
	 */
	$("button[data-clipboard-target], a[data-clipboard-target]").on('click', function () {
		var target = $(this).attr("data-clipboard-target");
		var $temp = $("<input>");
		$("body").append($temp);
		if(target == ".link") {
			var linksplit = $(target).attr("href").split("\\", 3); // local: \\; server: /
			$temp.val(encodeURI("https://subsyncer.com/get.php?d=" + linksplit[1].substring(1) + "&t=" + linksplit[2])).select();
		} else {
			$temp.val(encodeURI($(target).text())).select();
		}
		document.execCommand("copy");
		$temp.remove();
		$(this).html("Copied!")
	});

	/* Logic for the alerts
	 */
	$("button[data-dismiss='alert']").on("click", function () {
		//$(this).parent("*[role='alert']").fadeOut(200);
		$(".updatealert").fadeOut(200);
	});

	/* Logic for the FAQ toggles
	 */
	var acc = document.getElementsByClassName("faq_Question");
	var i;
	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function () {
			this.classList.toggle("active");
			var panel = this.nextElementSibling;
			/*if (panel.style.display === "block") {
				panel.style.display = "none";
			} else {
				panel.style.display = "block";
			}*/
			if (panel.style.maxHeight) {
				panel.style.maxHeight = null;
			} else {
				panel.style.maxHeight = panel.scrollHeight + "px";
			}
		});
	}

});


var TxtRotate = function (el, toRotate, period) {
	this.toRotate = toRotate;
	this.el = el;
	this.loopNum = 0;
	this.period = parseInt(period, 10) || 2000;
	this.txt = '';
	this.tick();
	this.isDeleting = false;
};

TxtRotate.prototype.tick = function () {
	var i = this.loopNum % this.toRotate.length;
	var fullTxt = this.toRotate[i];

	if (this.isDeleting) {
		this.txt = fullTxt.substring(0, this.txt.length - 1);
	} else {
		this.txt = fullTxt.substring(0, this.txt.length + 1);
	}

	this.el.innerHTML = '<span class="wrap">' + this.txt + '</span>';

	var that = this;
	var delta = 270 - Math.random() * 100; //300

	if (this.isDeleting) { delta /= 2; }

	if (!this.isDeleting && this.txt === fullTxt) {
		delta = this.period;
		this.isDeleting = true;
	} else if (this.isDeleting && this.txt === '') {
		this.isDeleting = false;
		this.loopNum++;
		delta = 500;
	}

	setTimeout(function () {
		that.tick();
	}, delta);
};

window.onload = function () {
	var elements = document.getElementsByClassName('txt-rotate');
	for (var i = 0; i < elements.length; i++) {
		var toRotate = elements[i].getAttribute('data-rotate');
		var period = elements[i].getAttribute('data-period');
		if (toRotate) {
			new TxtRotate(elements[i], JSON.parse(toRotate), period);
		}
	}
	// INJECT CSS
	var css = document.createElement("style");
	css.type = "text/css";
	css.innerHTML = ".txt-rotate > .wrap { border-right: 0.08em solid #666 }";
	document.body.appendChild(css);
};
/* Vanilla JS
document.querySelector(".mail").onclick = function () {
	var aux = document.createElement("input");
	aux.setAttribute("value", this.innerHTML);
	document.body.appendChild(aux);
	aux.select();
	document.execCommand("copy");
	document.body.removeChild(aux);
}/*
var copyText = document.getElementById("myInput");

copyText.select();
copyText.setSelectionRange(0, 99999); //For mobile devices
document.execCommand("copy");

alert("Copied the text: " + copyText.value);
}*/
/*
mail.addEventListener("copy", function (event) {
	event.preventDefault();
	if (event.clipboardData) {
		event.clipboardData.setData("text/plain", span.textContent);
		console.log(event.clipboardData.getData("text"))
	}
});*/
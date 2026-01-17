$(document).ready(function() {
	//custom cron
	$('[name=cronstate]').click(function(){
		switch ($(this).val()) {
			case 'advanced':
				$('#cronsched_adv').slideDown();
				break;
			default:
				$('#cronsched_adv').slideUp();
				break;
		}
	});

	//add a version number when we click upgrade
	$('.upgrade').click(function(){
		ver = $(this).data('version'); 
		form = $(this).parents('form');
		form.append('<input type="hidden" name="version" value="' + ver + '"/>');
	});

	//log view popups
	$('.viewlog').click(function(){
		id = 'log' + new Date().getTime();
		ver = $(this).data('version');
		live = $(this).data('logType') == 'live';
		console.log($(this)[0], live)
		html = '<div id="' + id + '"></div>';
		if (live) {
			html += '<progress class="modalprog" style="width: 100%">'
			+ 'Please wait...'
			+ '</progress>';
		}

	 	box = $('<div></div>')
		.html(html)
		.dialog({
			title: 'Log',
			resizable: false,
			modal: true,
			position: ['center', 50],
			width: 500,
			close: function (e) {
				$(e.target).dialog("destroy").remove();
			}
		});
		get_status($('#' + id), ver, '', live);
	});
});
function get_status(el, version, last, live) {
	var el = el;
	var version = version;
	var last = last;
	var live = live;
	$.ajax({
		url: window.location.href,
		type: 'post',
		data: {
			ajax: 'status_update',
			last_update: last,
			version: version
		},
		dataType: 'json',
		cache: false,
		success: function(msg, status){
			//console.log(msg, status);
			
			for (var i in msg) {
				add_msg(el, msg[i]);
				var status = msg[i].status_id
				last = msg[i].time;
			}
			if (live) {
				//850 means were done here
				if (status == 850) {
					$('progress.modalprog').val(100);
					setTimeout('window.location = window.location.href', 10000);
				} else {
					//create another request in 5 seconds
					setTimeout(function(){
						get_status(el, version, last, live);
					}, 5000);
				}	
			}
		},
		error: function() {
			//todo: set error handling

		}
	});
}

function add_msg(el, msg) {
		el.append('<div class="update_text_item">' 
			+ msg.date_string 
			+ ' '
			+ msg.status
			+ '</div>');

}


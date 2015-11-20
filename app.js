$(document).ready(function(){
	var connection = null;
	var participantTimeout = null;
	var conferenceCode = $('#conferenceCode').val();

	$('#participantsHeader').hide();

	function getParticipants() {
		if (connection == null) {
			// We should never get here
			clearTimeout(participantTimeout);
			return;
		}

		$.get('/index.php?getParticipants=' + conferenceCode, function(data) {
			$("#participants").html("");
			$.each(data, function(index, participant) {
				var human = moment.duration(participant.call.duration, "seconds").format("h:mm:ss", { trim: false });
				var $div = $("<div>", {class: "participant", html: participant.call.from + ", " + human});
				//$div.click(function(){ /* ... */ }); //@TODO: Mute? Unmute?
				$("#participants").append($div);
			});

			participantTimeout = setTimeout(getParticipants, 3000); // We use set timeout so this can't get called again before the previous call finished
		});
	}

	$(document).keypress(function(e) {
		if (e.which == 35 || e.which == 42 || (e.which >= 48 && e.which <= 57)) {
			var c = String.fromCharCode(e.which);
			if (connection) {
				connection.sendDigits(c);
			}
		}
	});

	Twilio.Device.setup($('#deviceToken').val());
	Twilio.Device.ready(function (device) {
		$('#status').html('Click the green call button to join the conference');
		$('.key.phone').show();
		$(".key").click(function() {
			var value = $(this).attr("rel");

			if (value == "connect") {
				connection = Twilio.Device.connect({'conferenceCode': conferenceCode});
			} else if (value == "disconnect") {
				Twilio.Device.disconnectAll();
			} else if (connection) {
				connection.sendDigits(value);
			}
		});
	});

	Twilio.Device.offline(function (device) {
		$('#status').html('Offline');
		clearTimeout(participantTimeout);
		$('#participantsHeader').hide();
	});

	Twilio.Device.error(function (error) {
		$('#status').html(error);
		clearTimeout(participantTimeout);
		$('#participantsHeader').hide();
	});

	Twilio.Device.connect(function (conn) {
		$('#status').html("You're in! Invite people with your conference code");
		getParticipants();
		toggleCallStatus();
	});

	Twilio.Device.disconnect(function (conn) {
		$('#status').html('Click the green call button to join the conference');
		toggleCallStatus();
		clearTimeout(participantTimeout);
	});

	function toggleCallStatus(){
		var el = $('.key.phone');
		if(el.hasClass('hangup')) {
			el.removeClass('hangup');
			el.attr('rel', 'connect');
			$('#participantsHeader').hide();
			$('#participants').html('');
		} else {
			el.addClass('hangup');
			el.attr('rel', 'disconnect');
			$('#participantsHeader').show();
		}
	};
});


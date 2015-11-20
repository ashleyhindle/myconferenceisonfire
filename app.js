		$(document).ready(function(){
			var connection = null;
			var participantInterval = null;
			var conferenceCode = $('#conferenceCode').val();

			function getParticipants() {
				if (connection == null) {
					// We should never get here
					clearInterval(participantInterval);
					return;
				}

				$.get('/index.php?getParticipants=' + conferenceCode, function(data) {
					console.log(data);
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
				clearInterval(participantInterval);
			});

			Twilio.Device.error(function (error) {
				$('#status').html(error);
				clearInterval(participantInterval);
			});

			Twilio.Device.connect(function (conn) {
				$('#status').html("You're in conference, make sure to invite people and tell them your conference code");
				getParticipants();
				participantInterval = setInterval(getParticipants, 3000);
				toggleCallStatus();
			});

			Twilio.Device.disconnect(function (conn) {
				$('#status').html('Click the green call button to join the conference');
				clearInterval(participantInterval);
				toggleCallStatus();
			});
			
			function toggleCallStatus(){
				var el = $('.key.phone');
				if(el.hasClass('hangup')) {
					el.removeClass('hangup');
					el.attr('rel', 'connect');
				} else {
					el.addClass('hangup');
					el.attr('rel', 'disconnect');
				}
			};

		});


		$(document).ready(function(){
			var connection = null;

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
				$('#status').html('Ready to join conference');
				$('.key.phone').show();
				$(".key").click(function() {
					var value = $(this).attr("rel");
					if (value == "connect") {
						connection = Twilio.Device.connect();
					} else if (value == "disconnect") {
						Twilio.Device.disconnectAll();
					} else if (connection) {
						connection.sendDigits(value);
					}
				});
			});
			
			Twilio.Device.offline(function (device) {
				$('#status').html('Offline');
			});

			Twilio.Device.error(function (error) {
				$('#status').html(error);
			});

			Twilio.Device.connect(function (conn) {
				$('#status').html("Successfully established call");
				toggleCallStatus();
			});

			Twilio.Device.disconnect(function (conn) {
				$('#status').html("Call ended");
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


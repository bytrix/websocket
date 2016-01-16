<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">

	<script src="http://code.jquery.com/jquery-1.12.0.js"></script>
	<script src="//js.pusher.com/3.0/pusher.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<style>
		.time{
			color: #aaa;
			margin-right: 12px;
		}
		.username{ 
			color: green;
			margin-right: 12px;
			font-weight: bold;
		}
		li{
			list-style-type: none;
		}
		.state{
			color: red;
		}
		li.message{
			word-break: break-all;
			margin-bottom: 6px;
		}
		.username-bar{
			/*background-color: red;*/
			height: 40px;
			line-height: 40px;
			display: block;
		}
		footer{
			color: #ccc;
			margin-top: 60px;
		}
		#board{
			/*background-color: yellow;*/
			height: 350px;
			overflow: hidden;
			overflow-y: auto;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="page-header">
			<h1>Fun with WebSocket!</h1>
		</div>
		<div class="col-md-12">
			<div class="col-md-6">
				<div id="board"></div>
			</div>
			<div class="col-md-6">
				<div class="username-bar form-group form-inline">
					<span style="margin-right: 18px;">Username:</span>
					<a href="javascript:;" id="username" data-toggle="tooltip" data-placement="top" title="Change username"></a>
					<span id="username-edit">
						<input type="text" name="" value="" placeholder="" id="username-editbox" class="input-sm form-control">
						<div class="btn-group">
							
						<button type="button" class="btn btn-success btn-sm" id="ok" data-toggle="tooltip" data-placement="top" title="Ok">
							<i class="fa fa-check"></i>
						</button>
						<button type="button" class="btn btn-danger btn-sm" id="cancel" data-toggle="tooltip" data-placement="top" title="Cancel">
							<i class="fa fa-times"></i>
						</button>
						</div>
					</span>
				</div>
				<div class="form-group">
					<textarea name="" id="message-box" cols="30" rows="8" class="form-control" placeholder="Leave message..."></textarea>
				</div>
				<div class="form-group">
					<input type="button" name="" value="Send (Ctrl+Enter)" id="send" class="btn btn-primary">
				</div>
			</div>
		</div>
	</div>

	<script>
	$(function() {

		$('[data-toggle="tooltip"]').tooltip();


		$('#username-edit').hide();

		var username = "guest" + Math.round(Math.random() * 100000);
		var pusher = new Pusher('8bb3cacf5137c936bec5');
		var channel = pusher.subscribe('test_channel');
		var msg = '';
		pusher.connection.bind('state_change', function(change) {
			// console.log(change.current);
			$('#board').append("<span class='state'>Server status: " + change.current + "</span><br />");
		});
		channel.bind('my_event', function(data) {
			// console.log(data);
			msg = "<li class='message'>" + "<span class='time'>" + data.time + "</span>" + "<span class='username'>" + data.username + ":" + "</span>" + data.message + "</li>";
			$('#board').append(msg);
			$('#board')[0].scrollTop = $('#board')[0].scrollHeight;
			// alert($('#board').scrollTop);
			// $('#board').scrollIntoView(false);
		});


		$('#username').text(username);
		$('#username').click(function() {
			// username = prompt("Enter your username");
			$('#username-edit').show();
			$(this).hide();
			// $(this).text(username);
			$('#username-editbox').val(username);
		});

		$('#cancel').click(function() {
			$('#username-edit').hide();
			$('#username').show();
		})
		$('#ok').click(function() {
			$('#username-edit').hide();
			$('#username').show();
			username = $('#username-editbox').val();
			$('#username').text(username);
			// alert(username);
		});

		$('#send').click(function() {
			send();
		});
		$('#message-box').keypress(function(e) {
			if (e.ctrlKey && e.which == 13 || e.which == 10) {
				send();
				// alert('aa');
			};
		});

		function send() {
			var message = $('#message-box').val();
			$('#send').attr('disabled', 'disabled');
			$('#send').val("Sending... (Ctrl+Enter)");
			$.post('/post.php', {username: username, message: message}, function(result) {
				// alert('ok');
				$('#send').removeAttr('disabled', 'disabled');
				$('#send').val("Send (Ctrl+Enter)");
				$('#message-box').val('');
			});
		}

	});
	</script>
</body>
<footer>
	<div class="container">
		coded with Pusher.js by
		<a target="blank" href="https://github.com/bytrix">bytrix</a>
	</div>
</footer>
</html>
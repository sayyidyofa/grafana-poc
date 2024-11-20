<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta name="author" content="Jose Purba"/>
		<meta name="creator" content="Jose Purba"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<title><?php echo $title; ?></title>

		<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(STYLESHEET.'sweetalert.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(STYLESHEET.'main.css'); ?>">
	</head>
	<body>

		<div class="container-fluid">
			<div class="row" style="text-align: center;margin-top: 15px;">
				<h1>Todo List <small style="font-size: 12px;">by <strong>Jose Purba</strong></small></h1>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="float: none;display: inline-block;margin-top:20px;">
					<div id="input-panel">
						<form name="todo-form" id="todo-from">
							<input name="todo-input" placeholder="ADD SOMETHING TO DO"/>
						</form>
					</div>
					<small id="log">...</small>
					<hr/>
					<div class="panel panel-default">
						<div class="panel-body">
							<ul id="todo-container">
								<?php if (count($todos) > 0){
								foreach ($todos as $todo){ ?>
								<li data-id="<?php echo $todo->id; ?>">
									<span data-id="<?php echo $todo->id; ?>"><?php echo $todo->name; ?></span>
									<div class="action">
										<button data-toggle="tooltip" data-title="Edit" class="edit-btn" data-id="<?php echo $todo->id; ?>"><i class="glyphicon glyphicon-pencil"></i></button>
										<button data-toggle="tooltip" data-title="Done" class="done-btn" data-id="<?php echo $todo->id; ?>"><i class="glyphicon glyphicon-ok"></i></button>
									</div>
								</li>
								<?php } } ?>
								<span id="nothing" style="<?php echo (count($todos) > 0) ? 'display:none' : 'display:block'; ?>;color:#999">Nothind todo, add something..</span>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script type="text/javascript" src="<?php echo base_url(SCRIPT.'sweetalert.min.js'); ?>"></script>
		<script type="text/javascript">
			
		$(function() {

			var uri = '<?php echo base_url(); ?>'
			$('[data-toggle=tooltip]').tooltip();

			$('#todo-from').submit(function(e) {
				e.preventDefault();
				var todoval = $('input[name=todo-input]').val();
				if (todoval == '') {
					alert('isi dulu lah tolo >:(');
					$('input[name=todo-input]').focus();
					return false;
				}

				$.ajax({
					'type': "POST",
					data: {todo: todoval},
					url: uri+'insert',
					dataType: "json",
					beforeSend: function(e) {
						$('#log').html('inserting..')
					},
					error: function(error) {
						$('#log').html('something wrong');
					},
					success: function(response) {
						resetLog();
						$('#nothing').css('display','none');
						$('input[name=todo-input]').val('');
						$('#todo-container').append("<li data-id="+ response.id +"><span data-id="+ response.id +">"+ response.name +"</span>"+
														"<div class=\"action\">"+
															"<button data-toggle=\"tooltip\" data-title=\"Edit\" class=\"edit-btn\" data-id="+ response.id +"><i class=\"glyphicon glyphicon-pencil\"></i></button>\r\n"+
															"<button data-toggle=\"tooltip\" data-title=\"Done\" class=\"done-btn\" data-id="+ response.id +"><i class=\"glyphicon glyphicon-ok\"></i></button>"+
														"</div>"+
													"</li>");
						$('[data-toggle=tooltip]').tooltip();
					}
				});
			});

			$('body').on('click','.done-btn',function(e) {
				var id = $(this).attr('data-id');
				if(typeof id == undefined){
					alert("something wrong!!");
					return false;
				}

				$.ajax({
					type :"POST",
					url : uri+'done',
					data:{id:id},
					beforeSend: function(e){
						$("li[data-id='"+ id +"']").css('background-color','rgba(120, 174, 223,0.2)');
						$("#log").html("loading..");
					},
					error : function(error){
						$('#log').html('something wrong');
					},
					success : function(response){
						$("li[data-id='"+ id +"']").fadeOut(300);
						setTimeout(function(){
							$("li[data-id='"+ id +"']").remove();
						},500);
						resetLog();
						checkifempty();
					}
				});
			})

			$('body').on('click','.edit-btn',function(e) {
				var id = $(this).attr('data-id');
				if(typeof id == undefined){
					alert("something wrong!!");
					return false;
				}

				$.ajax({
					type: 'POST',
					url: uri+'edit',
					data: {id:id},
					dataType: 'json',
					beforeSend: function(e){
						$("#log").html("loading..");
					},
					error : function(error){
						$('#log').html('something wrong');
					},
					success : function(response){
						resetLog();
						swal({
						  title: "Edit",
						  text: "What will you do then?",
						  type: "input",
						  showCancelButton: true,
						  closeOnConfirm: false,
						  showLoaderOnConfirm: true,
						  animation: "slide-from-top",
						  inputValue: response.name,
						  inputPlaceholder: "Do something"
						},
						function(inputValue){
							if (inputValue === "" || inputValue === false) {
							    return false;
							}
							update(id,inputValue);
						});
					}
				});
			});

			var update = function(id,name){
				$.ajax({
					type:"POST",
					url:uri+'update',
					data:{id:id,todo:name},
					dataType:'json',
					beforeSend: function(e){
						$("#log").html("updating..");
					},
					error : function(error){
						$("#log").html("something wrong");
					},
					success :function(response){
						resetLog();
						$("ul#todo-container li[data-id='"+ response.id +"'] span").html(response.name);
						setTimeout(function(e){
							swal.close();
						}),300;
					}
				});
				// swal("Ajax request finished!");
			} 
			var resetLog = function() {
				$('#log').html('...');
			}
			var checkifempty = function() {
				$.get(uri+'countTodos', function(response){
					response = $.parseJSON(response);
					if (response[0] == undefined) {
						$('#nothing').css('display','block');
					}
				})
			}

		});

		</script>
	</body>
</html>
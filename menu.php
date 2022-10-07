
<br/>
<nav class="navbar navbar-light" style="background-color: CadetBlue;">

				<div class="container-fluid">
					<div class="navbar-header">
					<p><strong><a class="navbar-brand" href="index.php"><font color="GhostWhite">Twitty  </font></a></strong></p>
					</div>
							<ul class="nav navbar-nav navbar-right">

					<div class="btn-group">
					
 					 	<button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								
  								<?php echo $_SESSION['username']; ?>
								<span class="caret"></span>
  
  						</button>
  							<div class="dropdown-menu">
  								<li><a class="dropdown-item" href="logout.php">Logout</a></li>

  							</div>
					</div>
				</div>							
				</ul>										
			</nav>

			<script type="text/javascript">

				$(document).ready(function(){
					$('#search_user').typeahead({
						source:function(query, result)
						{
							$('.typeahead').css('position', 'absolute');
							$('.typeahead').css('top', '45px');
							var action = 'search_user';
							$.ajax({
								url:"action.php",
								method:"POST",
								data:{query:query, action:action},
								dataType:"json",
								success:function(data)
								{
									result($.map(data, function(item){
										return item;
									}));
								}
							})
						}
					});

					$(document).on('click', '.typeahead li', function(){
						var search_query = $(this).text();
						window.location.href="wall.php?data="+search_query;
					});
				});

			</script>


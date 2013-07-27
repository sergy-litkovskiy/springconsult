<script type="text/javascript">
						$(function() {
							$('#login').dialog({
								autoOpen: false,
								title: '<p style=\'font-size:12pt;color:#FFFFFF\'>¬ведите логин и пароль</p>',
								width:350,
								heigth:300,
								show: 'blind',
								hide: 'explode'
							});
							
							$('#opener').click(function() {
								$('#login').dialog('open');
								return false;
							});
						});

                </script>
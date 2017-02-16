<?php
//$result = $db->query('SELECT * FROM auto');

//$cars = $result->rows;

$action = BASE_URI . '/step2';

//echo '<pre/>';
//print_r($result);
?>
	<nav class="idealsteps-nav">
		<ul>
			<li class="idealsteps-step-active">
				<a class="top-navigation" id="index" href="#" tabindex="-1">RCVDB</a>
			</li>
			<!--<li class="">
				<a onclick="return false;" href="#" tabindex="-1">TWO<span class="counter"></span></a>
			</li>
			<li class="">
				<a onclick="return false;" href="#" tabindex="-1">THREE<span class="counter"></span></a>
			</li>
			<li class="">
				<a onclick="return false;" href="#" tabindex="-1">FOUR<span class="counter"></span></a>
			</li>
			<li class="">
				<a onclick="return false;" href="#" tabindex="-1">FIVE<span class="counter"></span></a>
			</li>-->
		</ul>
	</nav>
	
	<section class="idealsteps-step">
		<div class="field idealforms-field idealforms-field-text login-link">
			<?php if( $logged_in ) { ?>
			Hello, <?php if( isset($session->data['user_id']) && !empty($session->data['user_id']) ) { echo $session->data['user_id']; } else { echo 'User';} ?> 
			<a href="#" id="logout-link">Logout</a>
			<span class="login-err" id="logout_err" style="display: none;">ERROR</span>
			<?php } else { ?>
			Return users please <a href="#login-dialog" data-toggle="modal">Login</a>
			<?php } ?>
		</div>
	</section>
	
    <form action="<?php echo $action; ?>" novalidate="" autocomplete="off" class="idealforms" id="form1" method="post" enctype="multipart/form-data">

        <div class="idealsteps-wrap">

          <!-- Step 1 -->

          <section class="idealsteps-step">

            <div class="field idealforms-field idealforms-field-text">
				<label class="main">Select .frm:</label>
				<input type="file" class="input-file" name="frm-fle[]" id="frm-fle" accept=".frm" multiple>
				<span class="error" id="error1" style="display: none;">Please select a .frm</span>
				<i class="icon"></i>
			</div>

            <div class="field buttons">
              <label class="main">&nbsp;</label>
              <button type="button" class="next">Start »</button>
            </div>

          </section>

        </div>

        <span id="invalid"></span>

    </form>
	<div id="ajresponse"></div>
	<script>
		$(document).ready(
			function(){
				$('.next').click(
					function(){
						if($('#frm-fle').val() != 0) {
							$('#error1').css('display', 'none');
							<?php if( IS_AJAX == true ) { ?>
							$('#progressbar').modal('show');
							//var file_data = $("#frm-fle").prop('files')[0];
							var file_data = $("#frm-fle").prop('files');
							var form_data = new FormData();
							$.each(file_data, function(key,val) { form_data.append('frm-fle'+key, val); });							
							form_data.append('action', 'UP_FRM');
							$.ajax({
								url: '<?php echo BASE_URI; ?>/ajax.php',
								type: 'POST',
								data: form_data,
								processData: false,
								contentType: false,
								success: function( data, textStatus, jQxhr ) {
									$('#ajresponse').html('<textarea style="width:920px;height:360px;">'+data+'</textarea>');
									$('#progressbar').modal('hide');
								},
								error: function( jqXhr, textStatus, errorThrown ) {
									$('#ajresponse').html(errorThrown);
									$('#progressbar').modal('hide');
								}
							});
							<?php } else { ?>
							$('#form1').submit();
							<?php } ?>
						} else {
							$('#error1').css('display', 'block');
						}
					}
				);
				<?php if(isset($session->data['car_id'])) { ?>
					$('#car_id option').filter(function(){return this.value === '<?php echo $session->data['car_id']; ?>';}).prop('selected', true);
				<?php } ?>
			}
		);
	</script>
<?php include_once(GLOBAL_JS); ?>
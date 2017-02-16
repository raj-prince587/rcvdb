<?php
//echo 'step2<br>';

$action = BASE_URI . '/step4';

$options = array();

$total = 0.00;
	
$grandtotal = 0.00;

//if( IS_AJAX == true ) {
if( 1 ) {

	if( isset($request->post['data']) ) {

		$formdata = $request->post['data'];
		//print_r($formdata);
		
		foreach($formdata as $element) {
			
			$session->data[$element['name']] = $element['value'];
			
		}

	}
	
} else {
	
	
}
if( isset( $session->data['car_id'] ) && isset( $session->data['method'] ) ) {

	$options = getOption($session->data['car_id'])->rows;
	
	$total = getCarCost($session->data['car_id'], $session->data['method']);
	
	$session->data['grand_total'] = $grand_total = $total;
	
	
}

if( isset( $session->data['book_option'] ) ) {
	
	$selected = explode( '~', $session->data['book_option'] );
	
	if(strlen($booking->book_option) > 0) {
			
		$checked_cost = getCheckedCost( str_replace('~', ',', $booking->book_option) )->rows;

		foreach($checked_cost as $cost) {

			$grand_total += (float)$cost['opt_cost'];

		}

		$session->data['grand_total'] = $grand_total = number_format($grand_total, 2, '.', '');

	}

}

/*if( isset( $session->data['grand_total'] ) ) 
	
	$grand_total = $session->data['grand_total'];*/

?>

	<nav class="idealsteps-nav">
		<ul>
			<li class="">
				<a class="top-navigation" id="step1" href="#" tabindex="-1">Schritt 1<span class="counter"></span></a>
			</li>
			<li class="">
				<a class="top-navigation" id="step2" href="#" tabindex="-1">Schritt 2<span class="counter"></span></a>
			</li>
			<li class="idealsteps-step-active">
				<a class="top-navigation" id="step3" href="#" tabindex="-1">Schritt 3</a>
			</li>
			<li class="">
				<a onclick="return false;" href="#" tabindex="-1">Schritt 4<span class="counter"></span></a>
			</li>
			<li class="">
				<a onclick="return false;" href="#" tabindex="-1">Schritt 5<span class="counter"></span></a>
			</li>
		</ul>
	</nav>

	<section class="idealsteps-step">
		<div class="field idealforms-field idealforms-field-text login-link">
			<?php if( $logged_in ) { ?>
			Hallo, <?php if( isset($session->data['vorname']) && !empty($session->data['vorname']) ) { echo $session->data['vorname']; } else { echo 'User';} ?> 
			<a href="#" id="logout-link">Abmelden</a>
			<span class="login-err" id="logout_err" style="display: none;">ERROR</span>
			<?php } else { ?>
			Stammkunden bitte <a href="#login-dialog" data-toggle="modal">Einloggen</a>
			<?php } ?>
		</div>
	</section>
	
    <form action="<?php echo $action; ?>" novalidate="" autocomplete="off" class="idealforms" id="form1" method="post">

        <div class="idealsteps-wrap">


<!-- Step 2 -->

        <section class="idealsteps-step">
			
			<div class="field idealforms-field idealforms-field-text"><b>Erganzungen:</b></div>

			<?php if(count($options) > 0) { ?>
			
			<?php foreach( $options as $option ) { ?>
			
				<?php if( @in_array( $option['opt_id'], $selected ) ) $checked = 'checked';  else $checked = ''; ?>
			
				<div class="field idealforms-field idealforms-field-text" id="optionid-<?php echo $option['opt_id']; ?>">
				
					<label class="main main1">
						
						<input type="checkbox" class="car-options" name="caroption" value="<?php echo $option['opt_id']; ?>" <?php echo $checked; ?>>
						
						<?php echo $option['text']; ?>
					
					</label>
					
					<label class="main"><input type="text" class="cost-input" name="" id="optoincost-<?php echo $option['opt_id']; ?>" value="<?php echo $option['opt_cost']; ?>" disabled> <b><?php echo CURR_SY;?></b></label>

					<i class="icon"></i>

				</div>
			
			<?php } ?>
			
			<?php } ?>
			
			<div class="field idealforms-field idealforms-field-text divider"><hr/><b>Ihre Preisubersicht:</b></div>
			<div class="field idealforms-field idealforms-field-text">
				
				<label class="main main1"> Buchungspreis (2 Abre...) </label>
				
				<label class="main"><input type="text" class="cost-input" name="sub-total" id="sub-total" value="<?php echo $total; ?>" disabled><b><?php echo CURR_SY;?></b></label>
				
				<i class="icon"></i>

			</div>
			
			<div class="field idealforms-field idealforms-field-text" id="addition-options">
			
			</div>
			
			<div class="field idealforms-field idealforms-field-text divider">
				<hr/>
				<label class="main main1"> <b>Gesamtpreis: </b></label>
				
				<label class="main"><input type="text" class="cost-input" name="grand-total" id="grand-total" value="<?php echo $grand_total; ?>" readonly><b><?php echo CURR_SY;?></b></label>
				
				<i class="icon"></i>

			</div>

            <div class="field buttons">
				<label class="main">&nbsp;</label>
				<button type="button" class="prev">« Prev</button>
				<button type="button" class="next">Next »</button>
            </div>

        </section>

		  </div>

        <span id="invalid"></span>

    </form>
	
	<script>
		$(document).ready(
			function(){
				
				$('.prev').click(
					function(){
						<?php if( IS_AJAX == true ) { ?>
						$('#progressbar1').modal('show');
						$.ajax({
							url: '<?php echo BASE_URI; ?>/ajax.php',
							dataType: 'html',
							type: 'post',
							data: { "action" : 'step2' },
							success: function( data, textStatus, jQxhr ) {
								$('#ajax-container').html(data);
								$('#progressbar1').modal('hide');
							},
							error: function( jqXhr, textStatus, errorThrown ) {
								$('#ajax-container').html(errorThrown);
								$('#progressbar1').modal('hide');
								/*console.log( errorThrown );*/
							}
						});
						<?php } else { ?>
						$(location).attr('href', '<?php echo BASE_URI . '/step2'; ?>');
						<?php } ?>
					}
				);
				
				$('.next').click(
					function(){
						if(1) {
							$('#error1').css('display', 'none');
							<?php if( IS_AJAX == true ) { ?>
							$('#progressbar').modal('show');
							$.ajax({
								url: '<?php echo BASE_URI; ?>/ajax.php',
								dataType: 'html',
								type: 'post',
								data: { /*"car_id": $('#car_id').val(),*/ "action" : 'step4' },
								success: function( data, textStatus, jQxhr ) {
									$('#ajax-container').html(data);
									$('#progressbar').modal('hide');
								},
								error: function( jqXhr, textStatus, errorThrown ) {
									$('#ajax-container').html(errorThrown);
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
				<?php //if(isset($session->data['car_id'])) { ?>
					//$('#car_id option').filter(function(){return this.value === '<?php echo $session->data['car_id']; ?>';}).prop('selected', true);
				<?php //} ?>
				
				$('.car-options').change(
					function() {
						if($(this).is(':checked')) {
							$('#grand-total').val((parseFloat($('#grand-total').val()) + parseFloat($('#optoincost-' + $(this).val()).val())).toFixed(2));
							$('#addition-options').append( '<div class="optionval" id="optionval'+$(this).val()+'">' + $('#optionid-' + $(this).val()).html() + '</div>' );
							$('#addition-options .car-options').remove();
						} else {
							$('#optionval' + $(this).val()).remove();
							$('#grand-total').val((parseFloat($('#grand-total').val()) - parseFloat($('#optoincost-' + $(this).val()).val())).toFixed(2));
						}
						$('#progressbar').modal('show');
						$.ajax({
							url: '<?php echo BASE_URI; ?>/ajax.php',
							dataType: 'html',
							type: 'post',
							data: { "data": $('#form1').serializeArray(), "action" : 'SETOPT' },
							success: function( data, textStatus, jQxhr ) {
								$('#progressbar').modal('hide');
								//$('#ajax-container').html(data);
								//alert(data);
							},
							error: function( jqXhr, textStatus, errorThrown ) {
								$('#ajax-container').html(errorThrown);
								$('#progressbar').modal('hide');
							}
						});
					}
				);
				
				$('.car-options').each(
					function(){
						if($(this).is(':checked')) {
							$('#grand-total').val((parseFloat($('#grand-total').val()) + parseFloat($('#optoincost-' + $(this).val()).val())).toFixed(2));
							$('#addition-options').append( '<div class="optionval" id="optionval'+$(this).val()+'">' + $('#optionid-' + $(this).val()).html() + '</div>' );
							$('#addition-options .car-options').remove();
						}
					}
				);
			}
		);
	</script>
<?php include_once(GLOBAL_JS); ?>
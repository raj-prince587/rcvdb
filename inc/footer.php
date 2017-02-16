			</div>
		
		</div>
		
		<!-- Modal -->
		<div id="progressbar" class="modal fade" tabindex="-2">
			<div class="modal-dialog" id="progress-body" style="">
				<img src="<?php echo IMAGE_URI ?>progressbar.gif" alt="Loading...." width="150">
			</div>
		</div>
		<!-- Modal -->
		<div id="progressbar1" class="modal fade" tabindex="-2">
			<div class="modal-dialog" id="progress-body" style="">
				<img src="<?php echo IMAGE_URI ?>backprogress.gif" alt="Loading...." width="150">
			</div>
		</div>
		<!-- Modal -->
		<div id="login-dialog" class="modal fade" tabindex="-2">
			<div class="modal-dialog" id="dialog-login">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" type="button" data-dismiss="modal">×</button>
						<h4 class="modal-title">Login</h4>
					</div>
					<div class="modal-body">
						<form action="" novalidate="" autocomplete="off" class="idealforms" id="login-form" method="post">
							<div class="field idealforms-field idealforms-field-text">
								<input type="text" name="login_user" id="login_user" placeholder="Username/Email ID">
								<span class="login-err" id="log_error1" style="display: none;">Required</span>
							</div>
							 <div class="field idealforms-field idealforms-field-text">
								<input type="password" name="login_pass" id="login_pass" placeholder="Password">
								<span class="login-err" id="log_error2" style="display: none;">Required</span>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" id="login-submit">Login</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
	</body>
	
</html>
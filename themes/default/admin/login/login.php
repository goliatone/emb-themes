<div class="login">
	<?php echo Form::open();?>
	<p class="note">
		Fields with
		<span class="required">*</span> are required.
	</p>

	<fieldset>
		<div class="clearfix">
			<label for="LoginForm_username" class="required">
				Username
				<span class="required">*</span>
			</label>
			<div class="input">
				<input name="LoginForm[username]" id="LoginForm_username" type="text" />
				<span class="help-inline" id="LoginForm_username_em_" style="display:none"></span>
			</div>
		</div>
		<div class="clearfix">
			<label for="LoginForm_password" class="required">
				Password
				<span class="required">*</span>
			</label>
			<div class="input">
				<input hint="Hint: You may login with &lt;tt&gt;demo/demo&lt;/tt&gt; or &lt;tt&gt;admin/admin&lt;/tt&gt;" name="LoginForm[password]" id="LoginForm_password" type="password" />
				<span class="help-block">
					Hint: You may login with
					<tt>
						demo/demo
					</tt> or
					<tt>
						admin/admin
					</tt>
				</span>
				<span class="help-inline" id="LoginForm_password_em_" style="display:none"></span>
			</div>
		</div>
		<div class="clearfix">
			<div class="input">
				<div class="inputs-list">
					<label for="LoginForm_rememberMe">
						<input id="ytLoginForm_rememberMe" type="hidden" value="0" name="LoginForm[rememberMe]" />
						<input name="LoginForm[rememberMe]" id="LoginForm_rememberMe" value="1" type="checkbox" />
						<span>Remember me next time</span>
						<span class="help-inline" id="LoginForm_rememberMe_em_" style="display:none"></span>
					</label>
				</div>
			</div>
		</div>
	</fieldset>

	<div class="actions">
		<input class="btn primary" type="submit" name="yt0" value="Login" />
	</div>
	<?php echo Form::close();?>
</div>
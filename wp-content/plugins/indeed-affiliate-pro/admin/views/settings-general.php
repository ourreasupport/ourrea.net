<div class="uap-wrapper">
<form action="" method="post">

	<input type="hidden" name="uap_admin_forms_nonce" value="<?php echo wp_create_nonce( 'uap_admin_forms_nonce' );?>" />

<div class="uap-stuffbox">
	<h3 class="uap-h3"><?php _e('General Settings', 'uap');?></h3>
	<div class="inside">
		<div class="uap-inside-item">
			<div class="row">
				<div class="col-xs-6">
					<h3><?php _e('Which Amount should be used for Referral?', 'uap');?></h3>
					<p><?php _e('If there are multiple Amounts set for the same action, like Ranks&Offers or multiple Offers decide which one will be taken in consideration', 'uap');?></p>
					<div class="uap-form-line">
							<select name="uap_referral_offer_type" class="form-control m-bot15"><?php
							$types = array('lowest'=>__('Lowest Amount', 'uap'), 'biggest'=>__('Biggest Amount', 'uap'));
							foreach ($types as $key=>$value){
								$selected = ($key==$data['metas']['uap_referral_offer_type']) ? 'selected' : '';
								?>
								<option value="<?php echo $key?>" <?php echo $selected;?>><?php echo $value;?></option>
								<?php
							}
						?></select>
					</div>
				</div>
			</div>
		</div>
		<div class="uap-inside-item">
			<div class="row">
				<div class="col-xs-6">
					<h3><?php _e('Redirect', 'uap');?></h3>
					<p><?php _e('Redirect Same Page Without URL parameters:', 'uap');?></p>
					<label class="uap_label_shiwtch" style="margin:10px 0 10px -10px;">
						<?php $checked = ($data['metas']['uap_redirect_without_param']) ? 'checked' : '';?>
						<input type="checkbox" class="uap-switch" onClick="uapCheckAndH(this, '#uap_redirect_without_param');" <?php echo $checked;?> />
						<div class="switch" style="display:inline-block;"></div>
					</label>
					<input type="hidden" name="uap_redirect_without_param" value="<?php echo $data['metas']['uap_redirect_without_param'];?>" id="uap_redirect_without_param" />
				</div>
			</div>
		</div>
		<div class="uap-line-break"></div>
		<div class="uap-inside-item">
			<div class="row">
				<div class="col-xs-4">
				<h3><?php _e('Referral Settings', 'uap');?></h3>
				<br/>
				<p><?php _e('Set the referral Variable name', 'uap');?></p>
					<div class="form-group">
						<input type="text" class="form-control" value="<?php echo $data['metas']['uap_referral_variable'];?>" name="uap_referral_variable" />
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-4">
				<h3><?php _e('Base Referral Link', 'uap');?></h3>
				<br/>
					<div class="form-group">
						<?php if (empty($data['metas']['uap_referral_custom_base_link'])) $data['metas']['uap_referral_custom_base_link'] = get_home_url();?>
						<input type="text" class="form-control" onBlur="uapCheckBaseReferralLink(this.value, '<?php echo get_site_url();?>');" value="<?php echo $data['metas']['uap_referral_custom_base_link'];?>" name="uap_referral_custom_base_link" />
					</div>
					<p id="base_referral_link_alert"><?php _e('Please insert a link from the website on which this plugin is installed.
Do not enter a link from a different website.', 'uap');?></p>
				</div>
			</div>

		</div>
		<div class="uap-inside-item">
			<div class="row">
				<div class="col-xs-4">
				<p class="uap-labels-special"><?php _e('Referral Format:', 'uap');?></p>
				<select name="uap_default_ref_format" class="form-control m-bot15"><?php
				$referral_format = array('id' => 'Affiliate ID', 'username'=>'UserName');
				foreach ($referral_format as $k=>$v){
					$selected = ($data['metas']['uap_default_ref_format']==$k) ? 'selected' : '';
					?>
					<option value="<?php echo $k;?>" <?php echo $selected;?> ><?php echo $v;?></option>
					<?php
				}
				?></select>

				</div>
			</div>
		</div>

		<div class="uap-inside-item">
			<div class="row">
				<div class="col-xs-4">
						<p class="uap-labels-special"><?php _e('Search into URL for both referral format:', 'uap');?></p>
						<label class="uap_label_shiwtch" style="margin:10px 0 10px -10px;">
							<?php $checked = ($data['metas']['uap_search_into_url_for_affid_or_username']) ? 'checked' : '';?>
							<input type="checkbox" class="uap-switch" onClick="uapCheckAndH(this, '#uap_search_into_url_for_affid_or_username');" <?php echo $checked;?> />
							<div class="switch" style="display:inline-block;"></div>
						</label>
						<input type="hidden" name="uap_search_into_url_for_affid_or_username" value="<?php echo $data['metas']['uap_search_into_url_for_affid_or_username'];?>" id="uap_search_into_url_for_affid_or_username" />
				</div>
			</div>
		</div>

		<div class="uap-inside-item">
			<div class="row">
				<div class="col-xs-4">
				<div class="input-group">
					<span class="input-group-addon" id="basic-addon1"><?php _e('Cookie Expiration:', 'uap');?></span>
					<input type="number" min="1" class="form-control" value="<?php echo $data['metas']['uap_cookie_expire'];?>" name="uap_cookie_expire"/>
					<div class="input-group-addon"> <?php _e("Days", 'uap');?></div>
				</div>

				</div>
			</div>
		</div>
		<div class="uap-line-break"></div>
		<div class="uap-inside-item">
			<div class="row">
				<div class="col-xs-4">
				<h3><?php _e('Campaign Settings', 'uap');?></h3>
				<br/>
				<p><?php _e('Set the Campaign Variable name', 'uap');?></p>
					<div class="form-group">
						<input type="text" class="form-control" value="<?php echo $data['metas']['uap_campaign_variable'];?>" name="uap_campaign_variable"  />
					</div>
				</div>
			</div>
		</div>
		<div class="uap-line-break"></div>
		<div class="uap-inside-item">
			<div class="row">
				<div class="col-xs-4">
					<h3><?php _e('Amount Value Settings', 'uap');?></h3>
					<div class="uap-form-line">
						<span class="uap-labels-special"><?php _e('Currency:', 'uap');?></span>
						<select name="uap_currency" class="form-control m-bot15">><?php
							$currency = uap_get_currencies_list();
							foreach ($currency as $k=>$v){
								$selected = ($k==$data['metas']['uap_currency']) ? 'selected' : '';
								?>
								<option value="<?php echo $k;?>" <?php echo $selected;?> ><?php echo $v;?></option>
								<?php
							}
						?></select>
					</div>
					<div class="uap-form-line">
						<span class="uap-labels-special"><?php _e('Currency position:', 'uap');?></span>
						<select name="uap_currency_position" class="form-control m-bot15">><?php
							$positions = array('left' => __('Left', 'uap'), 'right' => __('Right', 'uap'));
							foreach ($positions as $k=>$v){
								$selected = ($k==$data['metas']['uap_currency_position']) ? 'selected' : '';
								?>
								<option value="<?php echo $k;?>" <?php echo $selected;?> ><?php echo $v;?></option>
								<?php
							}
						?></select>
					</div>
					<div class="uap-form-line">
						<span class="uap-labels-special"><?php _e('Thousands Separator', 'uap');?></span>
						<input type="text" value="<?php echo $data['metas']['uap_thousands_separator'];?>" name="uap_thousands_separator" class="form-control" />
					</div>

					<div class="uap-form-line">
						<span class="uap-labels-special"><?php _e('Decimals Separator', 'uap');?></span>
						<input type="text" value="<?php echo $data['metas']['uap_decimals_separator'];?>" name="uap_decimals_separator" class="form-control" />
					</div>

					<div class="uap-form-line">
						<span class="uap-labels-special"><?php _e('Number of Decimals', 'uap');?></span>
						<input type="number" min="0" value="<?php echo $data['metas']['uap_num_of_decimals'];?>" name="uap_num_of_decimals" class="form-control" />
					</div>

					<div class="uap-form-line">
						<span class="uap-labels-special"><?php _e('Exclude Shipping', 'uap');?></span>
						<label class="uap_label_shiwtch" style="margin:10px 0 10px -10px;">
							<?php $checked = ($data['metas']['uap_exclude_shipping']) ? 'checked' : '';?>
							<input type="checkbox" class="uap-switch" onClick="uapCheckAndH(this, '#uap_exclude_shipping');" <?php echo $checked;?> />
							<div class="switch" style="display:inline-block;"></div>
						</label>
						<input type="hidden" name="uap_exclude_shipping" value="<?php echo $data['metas']['uap_exclude_shipping'];?>" id="uap_exclude_shipping" />
					</div>

					<div class="uap-form-line">
						<span class="uap-labels-special"><?php _e('Exclude Tax', 'uap');?></span>
						<label class="uap_label_shiwtch" style="margin:10px 0 10px -10px;">
							<?php $checked = ($data['metas']['uap_exclude_tax']) ? 'checked' : '';?>
							<input type="checkbox" class="uap-switch" onClick="uapCheckAndH(this, '#uap_exclude_tax');" <?php echo $checked;?> />
							<div class="switch" style="display:inline-block;"></div>
						</label>
						<input type="hidden" name="uap_exclude_tax" value="<?php echo $data['metas']['uap_exclude_tax'];?>" id="uap_exclude_tax" />
					</div>

				</div>
			</div>
		</div>

		<div class="uap-line-break"></div>
        
		<div class="uap-inside-item">
			<div class="row">
				<div class="col-xs-6">
					<h3><?php _e('Default Country', 'uap');?></h3>
					<p><?php _e('Choose a default country for Affiliates submission form. If none is chosen default WordPress Locale will be used instead', 'uap');?></p>
					<div class="uap-form-line">
							<select name="uap_defaultcountry" class="form-control m-bot15">
							<option value="" >....</option>
							<?php
							$types = uap_get_countries();
							foreach ($types as $key=>$value){
								$key = strtolower($key);
								$selected = ($key==$data['metas']['uap_defaultcountry']) ? 'selected' : '';
								?>
								<option value="<?php echo $key?>" <?php echo $selected;?>><?php echo $value;?></option>
								<?php
							}
						?></select>
				</div>
			</div>
		</div>
        <div class="uap-line-break"></div>
        
		<div class="uap-inside-item">
			<div class="row">
				<div class="col-xs-6">
					<h3><?php _e('Automatically Affiliate', 'uap');?></h3>
					<p><?php _e('All new Users become Affiliates', 'uap');?></p>
					<label class="uap_label_shiwtch" style="margin:10px 0 10px -10px;">
						<?php $checked = ($data['metas']['uap_all_new_users_become_affiliates']) ? 'checked' : '';?>
						<input type="checkbox" class="uap-switch" onClick="uapCheckAndH(this, '#uap_all_new_users_become_affiliates');" <?php echo $checked;?> />
						<div class="switch" style="display:inline-block;"></div>
					</label>
					<input type="hidden" name="uap_all_new_users_become_affiliates" value="<?php echo $data['metas']['uap_all_new_users_become_affiliates'];?>" id="uap_all_new_users_become_affiliates" />
				</div>
			</div>
		</div>

		<div class="uap-line-break"></div>
		<div class="uap-inside-item">
			<div class="row">
				<div class="col-xs-6">
					<h3><?php _e('Empty Referrals', 'uap');?></h3>
					<p><?php _e('Save Empty Referrals', 'uap');?></p>
					<label class="uap_label_shiwtch" style="margin:10px 0 10px -10px;">
						<?php $checked = ($data['metas']['uap_empty_referrals_enable']) ? 'checked' : '';?>
						<input type="checkbox" class="uap-switch" onClick="uapCheckAndH(this, '#uap_empty_referrals_enable');" <?php echo $checked;?> />
						<div class="switch" style="display:inline-block;"></div>
					</label>
					<input type="hidden" name="uap_empty_referrals_enable" value="<?php echo $data['metas']['uap_empty_referrals_enable'];?>" id="uap_empty_referrals_enable" />
				</div>
			</div>
		</div>

		<div class="uap-submit-form">
			<input type="submit" value="<?php _e('Save Changes', 'uap');?>" name="save" class="button button-primary button-large" />
		</div>
	</div>
</div>
</form>
</div>

<div class="uap-wrapper">
	<?php if (!empty($data['alert_message'])):?>
		<div class="uap-error-message"><?php echo $data['alert_message'];?></div>
	<?php endif;?>
		<div class="uap-page-title">Ultimate Affiliate Pro - <span class="second-text"><?php _e('Ranks', 'uap');?></span></div>
		<a href="<?php echo $data['url-add_edit'];?>" class="uap-add-new-like-wp"><i class="fa-uap fa-add-uap"></i><span><?php _e('Add new Rank', 'uap');?></span></a>
		<span class="uap-top-message"><?php _e('...create your Rank with new achievements!', 'uap');?></span>
		<div class="uap-clear"></div>
		<?php if (!empty($data['ranks'])) : ?>

			<form action="" method="post" id="form_ranks" style="margin-top:15px;">
					<table class="wp-list-table widefat fixed tags uap-admin-tables">
						<thead>
							<tr>
								<th><?php _e('Label', 'uap');?></th>
								<th><?php _e('Amount', 'uap');?></th>
								<th><?php _e('Achieve', 'uap');?></th>
								<th><?php _e('Status', 'uap');?></th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th><?php _e('Label', 'uap');?></th>
								<th><?php _e('Amount', 'uap');?></th>
								<th><?php _e('Achieve', 'uap');?></th>
								<th><?php _e('Status', 'uap');?></th>
							</tr>
						</tfoot>
						<tbody class="ui-sortable uap-alternate">
							<?php foreach ($data['ranks'] as $arr) : ?>
								<tr onmouseover="uapDhSelector('#rank_<?php echo $arr->id;?>', 1);" onmouseout="uapDhSelector('#rank_<?php echo $arr->id;?>', 0);">
									<td>
										<?php echo $arr->label;?>
										<div id="rank_<?php echo $arr->id;?>" style="visibility: hidden;">
											<a href="<?php echo $data['url-add_edit'] . '&id=' . $arr->id;?>"><?php _e('Edit', 'uap');?></a>
											|
											<span class="uap-js-delete-ranks uap-delete-span" data-id="<?php echo $arr->id;?>" ><?php _e('Delete', 'uap');?></span>
										</div>
									</td>
									<td><?php
										if ($arr->amount_type){
											if (!empty($this->amount_type_list[$arr->amount_type])){
												if ('%'==$this->amount_type_list[$arr->amount_type]){
													echo $arr->amount_value . ' ' . $this->amount_type_list[$arr->amount_type];
												} else {
													echo uap_format_price_and_currency($this->amount_type_list[$arr->amount_type], $arr->amount_value);
												}
											} else {
												echo $arr->amount_value;
											}
										}
										?></td>
									<td><?php
										$achieve = json_decode($arr->achieve, TRUE);
										if ($achieve):
										for ($i=1; $i<=$achieve['i']; $i++):?>
											<div class="uap-admin-listing-ranks-achieve">
												<div><strong><?php echo $data['achieve_types'][$achieve['type_' . $i]];?></strong></div>
												<div><?php echo __('From: ', 'uap');
													if ($achieve['type_' . $i]=='total_amount'){
															echo uap_format_price_and_currency( $this->amount_type_list['flat'], $achieve['value_' . $i] );
													} else {
															echo $achieve['value_' . $i];
													}
													?></div>
											</div>
										<?php
											endfor;
										else:
											?>
											<div class="uap-admin-listing-ranks-achieve">
												<?php _e('None', 'uap');?>
											</div>
											<?php
										endif;
										?>
									</td>
									<td><?php
										if ($arr->status) _e('Active', 'uap');
										else _e('Inactive', 'uap');
									?></td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>

				<input type="hidden" name="delete_rank" value="" id="delete_rank_id" />
			</form>

		<?php else :?>

			<h5><?php _e('No Ranks Available!', 'uap');?></h5>

		<?php endif;?>
</div>


</div><!-- end of uap-dashboard-wrap -->

<script>
jQuery( '.uap-js-delete-ranks' ).on( 'click', function(){
		var rankId = jQuery( this ).attr( 'data-id' );
		swal({
			title: "<?php _e( 'Are you sure that you want to delete this rank?', 'uap' );?>",
			text: "",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "OK",
			closeOnConfirm: true
		},
		function(){
				jQuery.ajax({
						type : 'post',
						url : decodeURI( window.uap_url )+'/wp-admin/admin-ajax.php',
						data : {
											 action									: 'uap_admin_delete_ranks',
											 id											:	rankId,
											 uap_admin_forms_nonce	:	'<?php echo wp_create_nonce( 'uap_admin_forms_nonce' );?>',
									 },
						success: function (response) {
								if ( response == 'success' ){
										location.reload();
								} else {
									swal({
										title: response,
										text: "",
										type: "warning",
										showCancelButton: false,
										confirmButtonClass: "btn-danger",
										confirmButtonText: "OK",
										closeOnConfirm: true
									});
								}
						}
			 });
	 });
});
</script>

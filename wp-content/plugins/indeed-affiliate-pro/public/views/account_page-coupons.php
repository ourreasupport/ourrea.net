<div class="uap-ap-wrap">

<?php if (!empty($data['title'])):?>
	<h3><?php echo $data['title'];?></h3>
<?php endif;?>
<?php if (!empty($data['message'])):?>
	<p><?php echo do_shortcode($data['message']);?></p>
<?php endif;?>

<div class="uap-profile-box-wrapper">
    	<div class="uap-profile-box-title"><span><?php _e("Your Discount Coupons", 'uap');?></span></div>
        <div class="uap-profile-box-content">
        	<div class="uap-row ">
            	<div class="uap-col-xs-12">
                <?php _e("Whenever a buyer makes a purchase with that coupon, you will automatically receive revenue. Promote available coupons to get more rewards.", 'uap');?>
                </div>
             </div>
                <div class="uap-row ">
            	<div class="uap-col-xs-8">
					<?php if (!empty($data['codes'])) : ?>
                        <table class="uap-account-table">
                            <thead>
                                <tr>
                                    <th><?php _e('Discount Code', 'uap');?></th>
                                    <th><?php _e('Discount value', 'uap');?></th>
                                    <th><?php _e('Source', 'uap');?></th>
                                    <th><?php _e('Your reward', 'uap');?></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th><?php _e('Discount Code', 'uap');?></th>
                                    <th><?php _e('Discount value', 'uap');?></th>
                                    <th><?php _e('Source', 'uap');?></th>
                                    <th><?php _e('Your reward', 'uap');?></th>
                                </tr>
                            </tfoot>
                            <tbody class="uap-alternate">
                                <?php foreach ($data['codes'] as $arr) : ?>
                                    <tr>
                                        <td><?php echo $arr['code'];?></td>
																				<td><?php
																						if ( isset( $arr['customer_discount_type'] ) && isset( $arr['customer_discount_value'] ) ){
																								if ( $arr['customer_discount_type'] == 'percentage' || $arr['customer_discount_type'] =='percent' ){
																										echo $arr['customer_discount_value'] . '%';
																								} else {
																										echo uap_format_price_and_currency($data['currency'], $arr['customer_discount_value'] );
																								}
																						}
																				?></td>
                                        <td><?php echo uap_service_type_code_to_title($arr['type']);?></td>
                                        <td><?php
                                            $settings = unserialize($arr['settings']);
                                            if ($settings){
                                                if ($settings['amount_type']=='flat'){
                                                    echo uap_format_price_and_currency($data['currency'], $settings['amount_value']);
                                                } else {
                                                    echo $settings['amount_value'] . ' %';
                                                }
                                            }
                                        ?></td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>

                    <?php else :?>
                     <div class="uap-warning-box" style="margin-top:25px;"><?php _e('No Coupons have been assigned to your account yet.', 'uap');?></div>
                    <?php endif;?>
         </div>
    </div>
    </div>
</div>
</div>
<?php

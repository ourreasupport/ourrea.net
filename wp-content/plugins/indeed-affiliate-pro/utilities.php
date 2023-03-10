<?php
function uap_reorder_arr($arr){
	/*
	 * @param array
	 * @return array
	 */
	if (isset($arr) && count($arr)>0 && $arr !== false){
		$new_arr = false;
		foreach ($arr as $k=>$v){
			$order = $v['order'];
			$new_arr[$order][$k] = $v;
		}
		if ($new_arr && count($new_arr)){
			ksort($new_arr);
			foreach ($new_arr as $k=>$v){
				$return_arr[key($v)] = $v[key($v)];
			}
			return $return_arr;
		}
	}
	return $arr;
}

function uap_reorder_ranks($ranks_arr=array()){
	/*
	 * reorder ranks by order attr
	 * @param array
	 * @return array
	 */
	if ($ranks_arr){
		foreach ($ranks_arr as $k=>$v){
			if (isset($v->rank_order)){
				$key = $v->rank_order;
				while (!empty($new_arr[$key])){
					$key++;
				}
				$new_arr[$key] = $v;
			}
		}
		if (!empty($new_arr)){
			ksort($new_arr);
			return $new_arr;
		}
	}
	return $ranks_arr;
}

function uap_custom_reorder_rank($ranks_arr, $id, $new_order){
	/*
	 * @param arrray, int, int
	 * @return array
	 */
	foreach ($ranks_arr as $k=>$v){
		if ($v->rank_order==$new_order){
			$swap_key_1 = $k;
			break;
		}
	}
	if (isset($swap_key_1) && isset($ranks_arr[$swap_key_1]->id) && $ranks_arr[$swap_key_1]->id!=$id){
		/// if array must be reorder
		foreach ($ranks_arr as $k=>$v){
			if ($v->id==$id){
				$swap_key_2 = $k;
				$old_order = $v->rank_order;
			}
		}
		if (isset($swap_key_2) && isset($swap_key_1) && isset($old_order)){
			$ranks_arr[$swap_key_1]->rank_order = $old_order;
			$ranks_arr[$swap_key_2]->rank_order = $new_order;
		}
	}
	return $ranks_arr;
}

function uap_correct_text($str, $wp_editor_content=false){
	/*
	 * @param string, bool
	 * @return string
 	 */
	$str = stripcslashes(htmlspecialchars_decode($str));
	if ($wp_editor_content){
		return uap_format_str_like_wp($str);
	}
	return $str;
}

function uap_format_str_like_wp( $str ){
	/*
	 * @param string
	 * @return string
	 */
	/*
	$str = preg_replace("/\n\n+/", "\n\n", $str);
	$str_arr = preg_split('/\n\s*\n/', $str, -1, PREG_SPLIT_NO_EMPTY);
	$str = '';

	foreach ( $str_arr as $str_val ) {
		$str .= '<p>' . trim($str_val, "\n") . "</p>\n";//trim($str_val, "\n") . "\n";
	}
	return $str;
	*/
	$str = wpautop( $str );
	return $str;
}

function uap_get_wp_roles_list(){
	/*
	 * @param none
	 * @return array with all wp roles available without administrator
	 */
	global $wp_roles;
	$roles = $wp_roles->get_names();
	if (!empty($roles)){
		unset($roles['administrator']);// remove admin role from our list
		return $roles;
	}
	return FALSE;
}

function uap_create_form_element($attr=array()){
	/*
	 * @param string
	 * @return string
	 */
	foreach (array('name', 'id', 'value', 'class', 'other_args', 'disabled', 'placeholder', 'multiple_values', 'user_id', 'sublabel') as $k){
		if (!isset($attr[$k])){
			$attr[$k] = '';
		}
	}
	if (empty($attr['id'])){
			$attr['id'] = 'uap_' . $attr['name'] . '_field';
	}

	$str = '';
	if (isset($attr['type']) && $attr['type']){
		switch ($attr['type']){
			case 'text':
			case 'conditional_text':
				$str = '<input type="text" name="'.$attr['name'].'" id="'.$attr['id'].'" class="uap-form-element uap-form-element-text '.$attr['class'].'" value="' . uap_correct_text($attr['value']) . '" placeholder="'.$attr['placeholder'].'" '.$attr['other_args'].' '.$attr['disabled'].' />';
				if (!empty($attr['sublabel'])){
					$str .= '<label class="uap-form-sublabel">' . uap_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'number':
				$str = '<input type="number" name="'.$attr['name'].'" id="'.$attr['id'].'" class="uap-form-element uap-form-element-number '.$attr['class'].'" value="'.$attr['value'].'"  '.$attr['other_args'].' '.$attr['disabled'].' />';
				if (!empty($attr['sublabel'])){
					$str .= '<label class="uap-form-sublabel">' . uap_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'textarea':
				$str = '<textarea name="'.$attr['name'].'" id="'.$attr['id'].'" class="uap-form-element uap-form-element-textarea uap-form-textarea '.$attr['class'].'" '.$attr['other_args'].' '.$attr['disabled'].' >' . uap_correct_text($attr['value']) . '</textarea>';
				if (!empty($attr['sublabel'])){
					$str .= '<label class="uap-form-sublabel">' . uap_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'password':
				wp_register_script('uap_passwordStrength', UAP_URL . 'assets/js/passwordStrength.js', array(), null );
				wp_localize_script('uap_passwordStrength', 'uapPasswordStrengthLabels', json_encode( array(__('Very Weak', 'uap'), __('Weak', 'uap'), __('Good', 'uap'), __('Strong', 'uap'))) );
				wp_enqueue_script('uap_passwordStrength');

				$ruleOne = (int)get_option('uap_register_pass_min_length');
				$ruleTwo = (int)get_option('uap_register_pass_options');

				$str = '<input type="password" name="'.$attr['name'].'" id="'.$attr['id'].'" class="uap-form-element uap-form-element-password '.$attr['class'].'" value="'.$attr['value'].'" placeholder="'.$attr['placeholder'].'" '.$attr['other_args'].' data-rules="' . $ruleOne . ',' . $ruleTwo . '"  autocomplete="new-password" />';
				$str .= '<div class="uap-strength-wrapper">';
				$str .= '<ul class="uap-strength"><li class="point"></li><li class="point"></li><li class="point"></li><li class="point"></li><li class="point"></li></ul>';
				$str .= '<div class="uap-strength-label"></div>';
				$str .= '</div>';
				if (!empty($attr['sublabel'])){
					$str .= '<label class="uap-form-sublabel">' . uap_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'hidden':
				$str = '<input type="hidden" name="'.$attr['name'].'" id="'.$attr['id'].'" class="uap-form-element uap-form-element-hidden '.$attr['class'].'" value="'.$attr['value'].'" '.$attr['other_args'].' />';
				break;

			case 'checkbox':
				$str = '';
				if ($attr['multiple_values']){
					$id = 'uap_checkbox_parent_' . rand(1,1000);
					$str .= '<div class="uap-form-checkbox-wrapper" id="' . $id . '">';
					foreach ($attr['multiple_values'] as $v){
						if (is_array($attr['value'])){
							$checked = (in_array($v, $attr['value'])) ? 'checked' : '';
						} else {
							$checked = ($v==$attr['value']) ? 'checked' : '';
						}
						$str .= '<div class="uap-form-checkbox">';
						$str .= '<input type="checkbox" name="'.$attr['name'].'[]" id="'.$attr['id'].'" class="uap-form-element uap-form-element-checkbox '.$attr['class'].'" value="' . uap_correct_text($v) . '" '.$checked.' '.$attr['other_args'].' '.$attr['disabled'].'  />';
						$str .= uap_correct_text($v);
						$str .= '</div>';
					}
					$str .= '</div>';
				}
				if (!empty($attr['sublabel'])){
					$str .= '<label class="uap-form-sublabel">' . uap_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'single_checkbox':
				$str = "";
				$str .= '<div class="uap-single-checkbox-wrap" id="' . $attr['id'] . '">'
								. '<input type="checkbox" value="1" name="' . $attr['name'] . '" class="uap-form-element uap-form-element-checkbox ' . $attr['class'] . '" />';
				if (!empty($attr['sublabel'])){
						$str .= '<label class="iump-form-sublabel">' . uap_correct_text($attr['sublabel']) . '</label>';
				}
				$str .= '</div>';
				break;

			case 'radio':
				$str = '';
				if ($attr['multiple_values']){
					$id = 'uap_radio_parent_' . rand(1,1000);
					$str .= '<div class="uap-form-radiobox-wrapper" id="' . $id . '">';
					foreach ($attr['multiple_values'] as $v){
						$checked = ($v==$attr['value']) ? 'checked' : '';
						$str .= '<div class="uap-form-radiobox">';
						$str .= '<input type="radio" name="'.$attr['name'].'" id="'.$attr['id'].'" class="uap-form-element uap-form-element-radio '.$attr['class'].'" value="' . uap_correct_text($v) . '" '.$checked.' '.$attr['other_args'].' '.$attr['disabled'].'  />';
						$str .= uap_correct_text($v);
						$str .= '</div>';
					}
					$str .= '</div>';
				}
				if (!empty($attr['sublabel'])){
					$str .= '<label class="uap-form-sublabel">' . uap_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'select':
				$str = '';
				if ($attr['multiple_values']){
					$str .= '<select name="'.$attr['name'].'" id="'.$attr['id'].'" class="uap-form-element uap-form-element-select uap-form-select '.$attr['class'].'" '.$attr['other_args'].' '.$attr['disabled'].' >';
					if ($attr['multiple_values']){
						foreach ($attr['multiple_values'] as $k=>$v){
							$selected = ($k==$attr['value']) ? 'selected' : '';
							$str .= '<option value="'.$k.'" '.$selected.'>' . uap_correct_text($v) . '</option>';
						}
					}
					$str .= '</select>';
				}
				if (!empty($attr['sublabel'])){
					$str .= '<label class="uap-form-sublabel">' . uap_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'multi_select':
				$str = '';
				if ($attr['multiple_values']){
					$str .= '<select name="'.$attr['name'].'[]" id="'.$attr['id'].'" class="uap-form-element uap-form-element-multiselect uap-form-multiselect '.$attr['class'].'" '.$attr['other_args'].' '.$attr['disabled'].' multiple>';
					foreach ($attr['multiple_values'] as $k=>$v){
						if (is_array($attr['value'])){
							$selected = (in_array($v, $attr['value'])) ? 'selected' : '';
						} else {
							$selected = ($v==$attr['value']) ? 'selected' : '';
						}
						$str .= '<option value="'.$k.'" '.$selected.'>' . uap_correct_text($v) . '</option>';
					}
					$str .= '</select>';
				}
				if (!empty($attr['sublabel'])){
					$str .= '<label class="uap-form-sublabel">' . uap_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'submit':
				$str = '<input type="submit" value="' . uap_correct_text($attr['value']) . '" name="'.$attr['name'].'" id="'.$attr['id'].'" class="uap-form-element uap-form-element-submit '.$attr['class'].'" '.$attr['other_args'].' '.$attr['disabled'].' />';
				if (!empty($attr['sublabel'])){
					$str .= '<label class="uap-form-sublabel">' . uap_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'date':
				wp_enqueue_script('jquery-ui-datepicker');
				if (empty($attr['class'])){
					$attr['class'] = 'uap-date-field';
				}
				$str = '';

				global $uap_jquery_ui_min_css;
				if (empty($uap_jquery_ui_min_css)){
					$uap_jquery_ui_min_css = TRUE;
					$str .= '<link rel="stylesheet" type="text/css" href="' . UAP_URL . '/assets/css/jquery-ui.min.css"/>' ;
				}

				$str .= '<script>
				jQuery(document).ready(function() {
				jQuery(".'.$attr['class'].'").datepicker({
				dateFormat : "dd-mm-yy"
		});
		});
		</script>
		';
				$str .= '<input type="text" value="'.$attr['value'].'" name="'.$attr['name'].'" id="'.$attr['id'].'" class="uap-form-element uap-form-element-date uap-form-datepicker '.$attr['class'].'" '.$attr['other_args'].' '.$attr['disabled'].' />';
				if (!empty($attr['sublabel'])){
					$str .= '<label class="uap-form-sublabel">' . uap_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'file':
				wp_enqueue_script( 'uap-jquery_form_module' );
				wp_enqueue_script( 'uap-jquery.uploadfile' );

				global $indeed_db;
				//$upload_settings = uap_return_meta_arr('extra_settings');
				$upload_settings = $indeed_db->return_settings_from_wp_option('general-uploads');
				$max_size = $upload_settings['uap_upload_max_size'] * 1000000;
				$rand = rand(1,10000);
				$str .= '<div id="uap_fileuploader_wrapp_' . $rand . '" class="uap-wrapp-file-upload" style=" vertical-align: text-top;">';
				$str .= '<div class="uap-file-upload uap-file-upload-button">Upload</div>
<script>
jQuery(document).ready(function() {
	jQuery("#uap_fileuploader_wrapp_' . $rand . ' .uap-file-upload").uploadFile({
		onSelect: function (files) {
			jQuery("#uap_fileuploader_wrapp_' . $rand . ' .ajax-file-upload-container").css("display", "block");
			var check_value = jQuery("#uap_upload_hidden_'.$rand.'").val();
			if (check_value!="" ){
				alert("To add a new file please remove the previous one!");
				return false;
			}
			return true;
		},
		url: "'.UAP_URL.'public/ajax-upload.php",
		fileName: "uap_file",
		dragDrop: false,
		showFileCounter: false,
		showProgress: true,
		showFileSize: false,
		maxFileSize: ' . $max_size . ',
		allowedTypes: "' . $upload_settings['uap_upload_extensions'] . '",
		onSuccess: function(a, response, b, c){
			if (response){
				var obj = jQuery.parseJSON(response);
				if (typeof obj.secret!="undefined"){
						jQuery("#uap_fileuploader_wrapp_' . $rand . '").attr("data-h", obj.secret);
				}
				jQuery("#uap_fileuploader_wrapp_' . $rand . ' .uap-file-upload").prepend("<div onClick=\"uapDeleteFileViaAjax("+obj.id+", -1, \'#uap_fileuploader_wrapp_' . $rand . '\', \'' . $attr['name'] . '\', \'#uap_upload_hidden_'.$rand.'\');\" class=\'uap-delete-attachment-bttn\'>Remove</div>");
				switch (obj.type){
					case "image":
						jQuery("#uap_fileuploader_wrapp_' . $rand . ' .uap-file-upload").prepend("<img src="+obj.url+" class=\'uap-member-photo\' /><div class=\'uap-clear\'></div>");
					break;
					case "other":
						jQuery("#uap_fileuploader_wrapp_' . $rand . ' .uap-file-upload").prepend("<div class=uap-icon-file-type></div><div class=uap-file-name-uploaded>"+obj.name+"</div>");
					break;
				}
				jQuery("#uap_upload_hidden_'.$rand.'").val(obj.id);
				setTimeout(function(){
					jQuery("#uap_fileuploader_wrapp_' . $rand . ' .ajax-file-upload-container").css("display", "none");
				}, 3000);
			}
		}
	});
});
</script>';
				if ($attr['value']){
					$attachment_type = uap_get_attachment_details($attr['value'], 'extension');
					$url = wp_get_attachment_url($attr['value']);
					switch ($attachment_type){
						case 'jpg':
						case 'jpeg':
						case 'png':
						case 'gif':
							//print the picture
							$str .= '<img src="' . $url . '" class="uap-member-photo" /><div class="uap-clear"></div>';
							break;
						default:
							//default file type
							$str .= '<div class="uap-icon-file-type"></div>';
							break;
					}
					$attachment_name = uap_get_attachment_details($attr['value']);
					$str .= '<div class="uap-file-name-uploaded"><a href="' . $url . '" target="_blank">' . $attachment_name . '</a></div>';
					$str .= '<div onClick=\'uapDeleteFileViaAjax(' . $attr['value'] . ', '.$attr['user_id'].', "#uap_fileuploader_wrapp_' . $rand . '", "' . $attr['name'] . '", "#uap_upload_hidden_' . $rand . '");\' class="uap-delete-attachment-bttn">Remove</div>';
				}
				$str .= '<input type="hidden" value="'.$attr['value'].'" name="' . $attr['name'] . '" id="uap_upload_hidden_'.$rand.'" />';
				$str .= "</div>";
				if (!empty($attr['sublabel'])){
					$str .= '<label class="uap-form-sublabel">' . uap_correct_text($attr['sublabel']) . '</label>';
				}
				break;


			case 'upload_image':
				global $indeed_db;
				$data = $attr;
				$data['rand'] = rand(1, 10000);
				$data['imageClass'] = 'uap-member-photo';
				if (empty($data['user_id'])){
						$data['user_id'] = -1;
				}
				$data['imageUrl'] = '';
				if ( !empty($data['value']) ){
						if (strpos($data['value'], "http")===0){
								$data['imageUrl'] = $data['value'];
						} else {
								$tempData = $indeed_db->getMediaBaseImage($data['value']);
								if (!empty($tempData)){
									$data['imageUrl'] = $tempData;
								}
						}
				}
				$viewObject = new \Indeed\Uap\IndeedView();
				$str = $viewObject->setTemplate( UAP_PATH . 'public/views/upload_image.php')->setContentData( $data )->getOutput();
				/*
				global $indeed_db;
				$upload_settings = $indeed_db->return_settings_from_wp_option('general-uploads');
				$max_size = $upload_settings['uap_avatar_max_size'] * 1000000;
				$rand = rand(1,10000);
				$str .= '<div id="uap_fileuploader_wrapp_' . $rand . '" class="uap-wrapp-file-upload" style=" vertical-align: text-top;">';
				$str .= '		<script>
						jQuery(document).ready(function() {
							jQuery("#uap_fileuploader_wrapp_' . $rand . ' .uap-file-upload").uploadFile({
								onSelect: function (files) {
									jQuery("#uap_fileuploader_wrapp_' . $rand . ' .ajax-file-upload-container").css("display", "block");
									var check_value = jQuery("#uap_upload_hidden_'.$rand.'").val();
									if (check_value!="" ){
										alert("To add a new image please remove the previous one!");
										return false;
									}
									return true;
								},
								url: "'.UAP_URL.'public/ajax-upload.php",
								allowedTypes: "jpg,png,jpeg,gif",
								fileName: "avatar",
								maxFileSize: ' . $max_size . ',
								dragDrop: false,
								showFileCounter: false,
								showProgress: true,
								onSuccess: function(a, response, b, c){
									if (response){
										var obj = jQuery.parseJSON(response);
										if (typeof obj.secret!="undefined"){
												jQuery("#uap_fileuploader_wrapp_' . $rand . '").attr("data-h", obj.secret);
										}
										jQuery("#uap_upload_hidden_'.$rand.'").val(obj.id);
										jQuery("#uap_fileuploader_wrapp_' . $rand . ' .uap-file-upload").prepend("<div onClick=\"uapDeleteFileViaAjax("+obj.id+", -1, \'#uap_fileuploader_wrapp_' . $rand . '\', \'' . $attr['name'] . '\', \'#uap_upload_hidden_'.$rand.'\');\" class=\'uap-delete-attachment-bttn\'>Remove</div>");
										jQuery("#uap_fileuploader_wrapp_' . $rand . ' .uap-file-upload").prepend("<img src="+obj.url+" class=\'uap-member-photo\' /><div class=\'uap-clear\'></div>");
										jQuery(".uap-no-avatar").remove();
										setTimeout(function(){
											jQuery("#uap_fileuploader_wrapp_' . $rand . ' .ajax-file-upload-container").css("display", "none");
										}, 3000);
									}
								}
						});
					});
				</script>';

				if ($attr['value']){
					if (strpos($attr['value'], "http")===0){
						$url = $attr['value'];
					} else {
						$data = wp_get_attachment_image_src($attr['value']);
						if (!empty($data[0])){
							$url = $data[0];
						}
					}

					if (isset($url)){
						$str .= '<img src="' . $url . '" class="uap-member-photo" /><div class="uap-clear"></div>';
						if (strpos($attr['value'], "http")===0){
							$str .= '<div onClick=\'uapDeleteFileViaAjax("", '.$attr['user_id'].', "#uap_fileuploader_wrapp_' . $rand . '", "' . $attr['name'] . '", "#uap_upload_hidden_'.$rand.'" );\' class="uap-delete-attachment-bttn">' . __("Remove", "uap") . '</div>';
						} else {
							$str .= '<div onClick=\'uapDeleteFileViaAjax(' . $attr['value'] . ', '.$attr['user_id'].', "#uap_fileuploader_wrapp_' . $rand . '", "' . $attr['name'] . '", "#uap_upload_hidden_'.$rand.'" );\' class="uap-delete-attachment-bttn">' . __("Remove", "uap") . '</div>';
						}
						$str .= '<div class="uap-file-upload uap-file-upload-button" style="display: none;">' . __("Upload", 'uap') . '</div>';
						$str .= '<input type="hidden" value="'.$attr['value'].'" name="uap_avatar"  id="uap_upload_hidden_'.$rand.'" />';
					} else {
						/// No image
						$str .= '<div class="uap-file-upload uap-file-upload-button" style="display: block;">' . __("Upload", 'uap') . '</div>';
						$str .= '<input type="hidden" value="" name="uap_avatar"  id="uap_upload_hidden_'.$rand.'" />';
					}
				} else {
					$str .= '<div class="uap-no-avatar uap-member-photo"></div>';
					$str .= '<div class="uap-file-upload uap-file-upload-button" style="display: block;">' . __("Upload", 'uap') . '</div>';
					$str .= '<input type="hidden" value="'.$attr['value'].'" name="uap_avatar"  id="uap_upload_hidden_'.$rand.'" />';
				}

				$str .= "</div>";
				if (!empty($attr['sublabel'])){
					$str .= '<label class="uap-form-sublabel">' . uap_correct_text($attr['sublabel']) . '</label>';
				}
				*/
				break;

			case 'plain_text':
				$str = uap_correct_text($attr['value']);
				if (!empty($attr['sublabel'])){
					$str .= '<label class="uap-form-sublabel">' . uap_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'uap_country':
				wp_enqueue_style( 'uap_select2_style' );
				wp_enqueue_script( 'uap-select2' );

				if (empty($attr['id'])){
					$attr['id'] = $attr['name'] . '_field';
				}
				$countries = uap_get_countries();

				$default_country = getDefaultCountry();
				if(empty($attr['value'])) $attr['value'] = $default_country;

				$str .= '<select name="' . $attr['name'] . '" id="' . $attr['id'] . '" class="uap-form-element uap-form-element-select">';
				foreach ($countries as $k=>$v):
					$k = strtolower($k);
					$selected = ($attr['value']==$k) ? 'selected' : '';
					$str .= '<option value="' . $k . '" ' . $selected . '>' . $v . '</option>';
				endforeach;
				$str .= '</select>';
				if (!empty($attr['sublabel'])){
					$str .= '<label class="uap-form-sublabel">' . uap_correct_text($attr['sublabel']) . '</label>';
				}
				$str .= '<ul id="uap_countries_list_ul" style="display: none;">';

				$str .= '</ul>';
				$str .= '<script>
					jQuery(document).ready(function(){
							jQuery("#' . $attr['id'] . '").select2({
							  placeholder: "' . __( 'Select Your Country', 'uap' ) . '",
							  allowClear: true
							});
					});
				</script>';
				break;
			case 'uap_affiliate_autocomplete_field':
				ob_start();
				include UAP_PATH . 'admin/views/search_user_field_autocomplete.php';
				$str = ob_get_contents();
				ob_end_clean();
				break;
		}
	}
	return $str;

}

function uap_array_value_exists($haystack, $needle, $key){
	/*
	 * @param array, string, string
	 * @return string|int, bool
	 */
	if (is_array($haystack)){
		foreach ($haystack as $k=>$v){
			if ($v[$key]==$needle){
				return $k;
			}
		}
	}
	return FALSE;
}

function uap_value_exists_in_another_subarray($haystack=array(), $needle='', $key='', $id=0){
	/*
	 * @param array, string, string, int
	 * @return boolean
	 */
	foreach ($haystack as $k=>$v){
		if ($v[$key]==$needle && $k!=$id){
			return TRUE;
		}
	}
	return FALSE;
}


function uap_send_user_notifications($u_id=0, $notification_type='', $rank=0, $dynamic_data=array() ){
	/*
	 * main function for notification module
	 * send e-mail to user
	 * int, string, int, array
	 * @return TRUE if mail was sent, FALSE otherwise
	 */
	$sent = FALSE;

	if ($u_id && $notification_type){
		global $indeed_db;
		$send_to_admin = FALSE;
		if (empty($rank)){
			$rank = $indeed_db->get_affiliate_rank(0, $u_id);
		}
		$domain = 'uap';
		$languageCode = get_user_meta( $u_id, 'uap_locale_code', true );
		if ($rank && $rank>-1){
			$data = $indeed_db->get_notification_for_rank($rank, $notification_type);
			if ($data){
					$subject = (empty($data['subject'])) ? '' : $data['subject'];
					$message = (empty($data['message'])) ? '' : $data['message'];
					$wmplName = $notification_type . '_subject_' . $rank;
					$subject = apply_filters( 'wpml_translate_single_string', $subject, $domain, $wmplName, $languageCode );
					$wmplName = $notification_type . '_message_' . $rank;
					$message = apply_filters( 'wpml_translate_single_string', $message, $domain, $wmplName, $languageCode );
			}
		}
		if (empty($data) || $rank==-1 || !$rank){
			$data = $indeed_db->get_notification_for_rank(-1, $notification_type);
			if ($data){
					$subject = (empty($data['subject'])) ? '' : $data['subject'];
					$message = (empty($data['message'])) ? '' : $data['message'];
					$wmplName = $notification_type . '_subject_-1';
					$subject = apply_filters( 'wpml_translate_single_string', $subject, $domain, $wmplName, $languageCode );
					$wmplName = $notification_type . '_message_-1';
					$message = apply_filters( 'wpml_translate_single_string', $message, $domain, $wmplName, $languageCode );
			}
		}
		if (!empty($data)){
			$from_name = get_option('uap_notification_name');
			if (empty($from_name)){
				$from_name = get_option("blogname");
			}
			//user data
			$u_data = get_userdata($u_id);
			$user_email = $u_data->data->user_email;
			//from email
			$from_email = get_option('uap_notification_email_from');
			if (empty($from_email)){
				$from_email = get_option('admin_email');
			}
			$message = uap_replace_constants($message, $u_id, $dynamic_data);
			$subject = uap_replace_constants($subject, $u_id, $dynamic_data);

			$message = stripslashes(htmlspecialchars_decode(uap_format_str_like_wp($message)));
			$message = apply_filters('uap_notification_filter', $message, $u_id, $notification_type);
			$message = "<html><head></head><body>" . $message . "</body></html>";
			if ($subject && $message && $user_email){
				if ($notification_type=='admin_user_register' || $notification_type=='admin_on_aff_change_rank' || $notification_type=='admin_affiliate_update_profile'){
					/////// ADMIN NOTIFICATION
					$user_email = get_option('admin_email');//we change the destination
					$send_to_admin = TRUE;
				}
				if (!empty($from_email) && !empty($from_name)){
					$headers[] = "From: $from_name <$from_email>";
				}
				$headers[] = 'Content-Type: text/html; charset=UTF-8';
				$sent = wp_mail($user_email, $subject, $message, $headers);
			}
		}

		/// PUSHOVER
		if ($indeed_db->is_magic_feat_enable('pushover')){
			require_once UAP_PATH . 'classes/Uap_Pushover.class.php';
			$pushover_object = new Uap_Pushover();
			$pushover_object->send_notification($u_id, $rank, $notification_type, $send_to_admin);
		}
		/// PUSHOVER
	}
	return $sent;
}

function uap_general_options_print_page_links($id=FALSE){
	/*
	 * used in admin section
	 * @param int
	 * @return string
	 */
	if ($id!=-1 && $id!==FALSE){
		$target_page_link = get_permalink($id);
		if ($target_page_link) {
			echo '<div class="uap-general-options-link-pages">' . __('Link:', 'uap') . ' <a href="' . $target_page_link . '" target="_blank">' . $target_page_link . '</a></div>';
		}
	}
	return '';
}

function uap_get_redirect_links_as_arr_for_select(){
	/*
	 * used in admin section
	 * @param none
	 * @return array
	 */
	$return = array();
	$redirect_links = get_option("uap_custom_redirect_links_array");
	if (is_array($redirect_links) && count($redirect_links)){
		foreach ($redirect_links as $k=>$v){
			$return[$k] = __("Custom Link: ", 'uap') . $k;
		}
	}
	return $return;
}

function uap_get_all_pages(){
	/*
	 * @param none
	 * @return array
	 */
	$arr = array();
	$args = array(
					'sort_order' => 'ASC',
					'sort_column' => 'post_title',
					'hierarchical' => 1,
					'child_of' => 0,
					'parent' => -1,
					'number' => '',
					'offset' => 0,
					'post_type' => 'page',
					'post_status' => 'publish',
	);
	$pages = get_pages($args);
	if (isset($pages) && count($pages)>0){
		foreach ($pages as $page){
			if ($page->post_title=='') $page->post_title = '(no title)';
			$arr[$page->ID] = $page->post_title;
		}
	}
	return $arr;
}

function get_device_type(){
	/*
	 * @param none
	 * @return string
	 */
	if(!class_exists('Mobile_Detect'))
		require UAP_PATH . 'classes/Mobile_Detect.class.php';
	$detect = new Mobile_Detect();
	if( ($detect->isMobile()) || ($detect->isTablet()) ) return 'mobile';
	return 'web';
}

function uap_check_value_field($type='', $value='', $val2='', $register_msg=array()){
	/*
	 * @param string, string, string, array
	 * @return
	 */
	global $indeed_db;
	if (isset($value) && $value!=''){
		switch ($type){
			case 'user_login':
				if (!validate_username($value)){
					$return = $register_msg['uap_register_error_username_msg'];
				}
				if (username_exists($value)) {
					$return = $register_msg['uap_register_username_taken_msg'];
				}
				break;
			case 'user_email':
				if (!is_email($value)) {
					$return = $register_msg['uap_register_invalid_email_msg'];
				}
				if (email_exists($value)){
					$return = $register_msg['uap_register_email_is_taken_msg'];
				}
				break;
			case 'confirm_email':
				if ($value==$val2){
					$return = 1;
				} else {
					$return = $register_msg['uap_register_emails_not_match_msg'];
				}
				break;
			case 'pass1':
				$register_metas = $indeed_db->return_settings_from_wp_option('register');
				if ($register_metas['uap_register_pass_options']==2){
					//characters and digits
					if (!preg_match('/[a-z]/', $value)){
						$return = $register_msg['uap_register_pass_letter_digits_msg'];
					}
					if (!preg_match('/[0-9]/', $value)){
						$return = $register_msg['uap_register_pass_letter_digits_msg'];
					}
				} else if ($register_metas['uap_register_pass_options']==3){
					//characters, digits and one Uppercase letter
					if (!preg_match('/[a-z]/', $value)){
						$return = $register_msg['uap_register_pass_let_dig_up_let_msg'];
					}
					if (!preg_match('/[0-9]/', $value)){
						$return = $register_msg['uap_register_pass_let_dig_up_let_msg'];
					}
					if (!preg_match('/[A-Z]/', $value)){
						$return = $register_msg['uap_register_pass_let_dig_up_let_msg'];
					}
				}
				//check the length of password
				if($register_metas['uap_register_pass_min_length']!=0){
					if (strlen($value)<$register_metas['uap_register_pass_min_length']){
						$return = str_replace( '{X}', $register_metas['uap_register_pass_min_length'], $register_msg['uap_register_pass_min_char_msg'] );
					}
				}
				break;
			case 'pass2':
				if ($value==$val2){
					$return = 1;
				} else {
					$return = $register_msg['uap_register_pass_not_match_msg'];
				}
				break;
			case 'tos':
				if ($value==1){
					$return = 1;
				} else {
					$return = $register_msg['uap_register_err_tos'];
				}
				break;

			default:
				//required conditional field
				$check = uap_required_conditional_field_test($type, $value);
				if ($check){
					$return = $check;
				} else {
					$return = 1;
				}
				break;
		}
		if (empty($return)){
			$return = 1;
		}
		return $return;
	} else {
		$check = uap_required_conditional_field_test($type, $value);//Check for required conditional field
		if ($check){
			return $check;
		} else {
			return $register_msg['uap_register_err_req_fields'];
		}
	}
}

function uap_required_conditional_field_test($name='', $match_string=''){
	/*
	 * @param string, string
	 * @return string with error if it's case, empty string if it's ok
	 */
	global $indeed_db;
	$fields_meta = $indeed_db->register_get_custom_fields();
	$key = uap_array_value_exists($fields_meta, $name, 'name');
	if ($key!==FALSE && isset($fields_meta[$key]) && $fields_meta[$key]['type']=='conditional_text' && !empty($fields_meta[$key]['conditional_text'])){
		if ($fields_meta[$key]['conditional_text']!=$match_string){
			return uap_correct_text($fields_meta[$key]['error_message']);
		}
	}
	return '';
}


function uap_get_currencies_list($type='all'){
	/*
	 * @param [string - all | custom ]
	 * @return array
	 */

	$custom = get_option('uap_currencies_list');
	if (empty($custom)){
		$custom = array();
	}
	$basic = array(
			'AUD' => 'Australian Dollar (A $)',
			'CAD' => 'Canadian Dollar (C $)',
			'EUR' => 'Euro (&#8364;)',
			'GBP' => 'British Pound (&#163;)',
			'JPY' => 'Japanese Yen (&#165;)',
			'USD' => 'U.S. Dollar ($)',
			'NZD' => 'New Zealand Dollar ($)',
			'CHF' => 'Swiss Franc',
			'HKD' => 'Hong Kong Dollar ($)',
			'SGD' => 'Singapore Dollar ($)',
			'SEK' => 'Swedish Krona',
			'DKK' => 'Danish Krone',
			'PLN' => 'Polish Zloty',
			'NOK' => 'Norwegian Krone',
			'HUF' => 'Hungarian Forint',
			'CZK' => 'Czech Koruna',
			'ILS' => 'Israeli New Shekel',
			'MXN' => 'Mexican Peso',
			'BRL' => 'Brazilian Real (only for Brazilian members)',
			'MYR' => 'Malaysian Ringgit (only for Malaysian members)',
			'PHP' => 'Philippine Peso',
			'TWD' => 'New Taiwan Dollar',
			'THB' => 'Thai Baht',
			'TRY' => 'Turkish Lira (only for Turkish members)',
			'RUB' => 'Russian Ruble',
	);
	if ($type=='custom'){
		return $custom;
	}
	return array_merge($basic, $custom);
}

function uap_get_image_size($image=''){
	/*
	 * @param string
	 * @return array
	 */
	if ($image){
		$data = getimagesize($image);
		if (!empty($data[0]) && !empty($data[1])){
			return array('width'=>$data[0], 'height'=>$data[1]);
		}
	}
	return array();
}

function uap_replace_constants($str = '', $u_id = FALSE, $dynamic_data = array()){
	/*
	 * @param $str - string where to replace,
	 * user id - int,
	 * current level id - int,
	 * level id - int,
	 * dynamic_data must be an array ( {name of constant} => {value} )
	 * @return string
	 */
	if ($u_id){
		global $indeed_db;
		$username = '';
		$first_name = '';
		$last_name = '';
		$user_email = '';
		$account_page = '';
		$login_page = '';
		$blogname = '';
		$blogurl = '';
		$site_url = '';
		$current_rank = '';
		$rank = '';
		$rank_name = '';

		//user data
		$u_data = get_userdata($u_id);
		$user_email = $u_data->data->user_email;
		$username = $u_data->data->user_login;
		$user_url = $u_data->data->user_url;
		$user_registered = uap_convert_date_to_us_format($u_data->data->user_registered);
		$first_name = get_user_meta($u_id, 'first_name', true);
		$last_name = get_user_meta($u_id, 'last_name', true);
		$blogname = get_option("blogname");
		$blogurl = get_option("siteurl");
		$site_url = get_option('siteurl');
		$affiliate_id = $indeed_db->get_affiliate_id_by_wpuid($u_id);

		///CURRENT RANK
		$rank = $indeed_db->get_affiliate_rank(0, $u_id);
		if ($rank){
			$rank_data = $indeed_db->get_rank($rank);
			$rank_name = (empty($rank_data['label'])) ? '' : $rank_data['label'];
		}

		//account page
		$account_page = get_option("uap_general_user_page");
		if ($account_page){
			$account_page = get_permalink($account_page);
		}
		//login page
		$login_page = get_option("uap_general_login_default_page");
		if ($login_page){
			$login_page = get_permalink($login_page);
		}

		/// AVATAR
		$avatar = get_user_meta($u_id, 'uap_avatar', true);
		if (strpos($avatar, "http")===0){
			$avatar_url = $avatar;
		} else {
			$avatar_url = wp_get_attachment_url($avatar);
		}
		$avatar = ($avatar_url) ? $avatar_url : UAP_URL . 'assets/images/no-avatar.png';
		$avatar = '<img src="' . $avatar . '" class="uap-public-shortcode-avatar"/>';

		$flag = get_user_meta($u_id, 'uap_country', true);
		if (empty($flag)){
			$flag = '';
		} else {
			$countries = uap_get_countries();
			$key = $flag;
			$country = $countries[strtoupper($key)];
			$title = (empty($country)) ? '' : $country;
			$flag = '<img src="' . UAP_URL . 'assets/flags/' . $flag . '.svg" class="uap-public-flag" title="' . $title . '" />';
		}

		$replace = array(
				"{username}" => $username,
				"{first_name}" => $first_name,
				"{last_name}" => $last_name,
				"{user_id}" => $u_id,
				"{current_rank}" => $current_rank,
				"{user_email}" => $user_email,
				"{account_page}" => $account_page,
				"{login_page}" => $login_page,
				"{blogname}" => $blogname,
				"{blogurl}" => $blogurl,
				"{siteurl}" => $site_url,
				'{rank_id}' => $rank,
				'{rank_name}' => $rank_name,
				'{user_url}' => $user_url,
				'{uap_avatar}' => $avatar,
				'{user_registered}' => $user_registered,
				'{flag}' => $flag,
				'{affiliate_id}' => $affiliate_id,
		);

		$custom_constant_fields = uap_get_custom_constant_fields();

		foreach ($custom_constant_fields as $k=>$v){
				if ( !$v ){
						continue;
				}
				$replace[$k] = get_user_meta($u_id, $v, TRUE);
				if ( $replace[$k] && is_array($replace[$k])){
					$replace[$k]= implode(',',$replace[$k]);
				}
		}

		//if ($dynamic_data){
			foreach ($dynamic_data as $k=>$v){
				$replace[$k] = $v;

			}
		//}

		foreach ($replace as $k=>$v){
			$str = str_replace($k, $v, $str);
		}

	}
	return $str;
}

function uap_get_custom_constant_fields(){
	/*
	 * @param none
	 * @return array
	 */
	global $indeed_db;
	$data = $indeed_db->register_get_custom_fields();

	if ($data && is_array($data)){
		foreach ($data as $arr){
			$fields["{CUSTOM_FIELD_" . $arr['name'] ."}"] = $arr['name'];
		}
		$diff = array('uap_social_media', 'recaptcha', 'tos', 'pass2', 'pass1', 'user_login', 'user_email', 'confirm_email', 'first_name', 'last_name', 'uap_avatar');
		$fields = array_diff($fields, $diff);

		return $fields;
	}
	return array();
}

function uap_create_affiliate_link($url='', $ref_param='', $ref_value='', $campaign_name='', $campaign_value='', $prettify=FALSE){
	/*
	 * @param string
	 * @return string
	 */
	if (strpos($url, '?')===FALSE){
		if (substr($url, -1, 1)!='/'){
			$url .= '/';
		}
	}
	if ($prettify){
		$slash_pos = strpos($url, '?');
		if ($slash_pos){
			$url = substr($url, 0, $slash_pos - 1);
		}
		if (substr($url, -1)!='/'){
			$url .= '/';
		}
		$url .= implode('/', array($ref_param, $ref_value));
		if ($campaign_name && $campaign_value){
			$url .= '/' . implode('/', array($campaign_name, $campaign_value));
		}
		return $url;
	}
	$url = add_query_arg($ref_param, $ref_value, $url);
	if ($campaign_name && $campaign_value){
		$url = add_query_arg($campaign_name, $campaign_value, $url);
	}
	if ($prettify){
		$url = user_trailingslashit($url);
	}
	return $url;
}

function uap_return_cc_list($user, $pass){
	/*
	 * @param string, string
	 * @return array
	 */
	if (!class_exists('cc')){
		include_once UAP_PATH .'classes/email_services/constantcontact/class.cc.php';
	}
	$list = array();
	$cc = new cc($user, $pass);
	$lists = $cc->get_lists('lists');
	if ($lists){
		foreach ((array) $lists as $v){
			$list[$v['id']] = array('name' => $v['Name']);
		}
	}
	return $list;
}

function uap_return_date_filter($url='', $status_arr=array(), $search_affiliate=FALSE){
	/*
	 * @param string
	 * @return string
	 */
	wp_enqueue_script('jquery-ui-datepicker');
	ob_start();
	$start = (empty($_REQUEST['udf'])) ? '' : $_REQUEST['udf'];
	$end = (empty($_REQUEST['udu'])) ? '' : $_REQUEST['udu'];
	$status = (isset($_REQUEST['u_sts'])) ? $_REQUEST['u_sts'] : -1;

	?>
	<form action="<?php echo $url;?>" method="post">
		<div class="uap-general-date-filter-wrap" style="padding: 10px 0px;">
			<?php if ($search_affiliate):?>
			<input type="text" name="aff_u" value="<?php echo @$_REQUEST['aff_u'];?>" class="" placeholder="<?php _e('Affiliate', 'uap');?>"/>
			<?php endif;?>
			<!--label class="uap-label"><?php _e('Start:', 'uap');?></label-->
			<input type="text" name="udf" value="<?php echo $start;?>" class="uap-general-date-filter" placeholder="From - mm/dd/yyyy"/>
			<!--label class="uap-label"><?php _e('Until:', 'uap');?></label--><span class="uap-date-line">-</span>
			<input type="text" name="udu" value="<?php echo $end;?>" class="uap-general-date-filter" placeholder="To - mm/dd/yyyy"/>

			<?php if (!empty($status_arr)):
					$status_arr[-1] = '...';
					ksort($status_arr);
				?>
				<select name="u_sts"><?php
					foreach ($status_arr as $key=>$value):
					$selected = ($status==$key) ? 'selected' : '';
					?>
					<option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $value;?></option>
					<?php
					endforeach;
				?></select>
			<?php endif;?>

			<input type="submit" value="<?php _e("Apply", 'uap');?>" name="apply" class="button button-primary button-large" />
		</div>

	</form>
	<script>
	jQuery(document).ready(function() {
		jQuery('.uap-general-date-filter').each(function(){
			jQuery(this).datepicker({
	            dateFormat : 'yy-mm-dd',
	            onSelect: function(datetext){
	                jQuery(this).val(datetext);
	            }
	        });
	    });
	});
	</script>
	<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}


function uap_is_social_share_intalled_and_active(){
	/*
	 * @param none
	 * @return boolean
	 */
	if (is_plugin_active('indeed-social-media/indeed-social-media.php')){
		if (get_option('ism_license_set')==1){
			return TRUE;
		}
	}
	return FALSE;
}

function uap_return_default_notification_content($type=''){
	/*
	 * @param string
	 * @return array
	 */
	$template = array();
	if ($type){
		switch ($type){
				case 'admin_user_register':
					$template['subject'] = '{blogname}: New Affiliate User registration';
					$template['content'] = '<html><head></head><body><p>New Affiliate User registration on: <strong> {blogname} </strong></p>

									<p><strong> Username:</strong> {username}</p>

									<p><strong> Email:</strong> {user_email}</p>

									<p>Have a nice day!</p>
					</body></html>';
					break;
				case 'register':
					$template['subject'] = '{blogname}: Welcome to {blogname}';
					$template['content'] = '<p>Hi {username},</p><br/>

												<p>Thanks for registering on {blogname}. Your account is now active.</p><br/>

												<p>To login please fill out your credentials on:<br/>
												{login_page}</p><br/>

												<p>Your Username: {username}</p><br/><br/>


												<p>Have a nice day!</p>';
					break;
				case 'reset_password_process':
					$template['subject'] = '{blogname}: Reset Password request';
					$template['content'] = "<p>Hi {first_name} {last_name},</p></br>
						<p>You or someone else has requested to change password for your account: {username}</p></br>
						<p>To change Your Password click on this URL: {password_reset_link}</p></br>
						<p>If you did not request for a new password, please ignore this Email notification.</p>";
					break;
				case 'reset_password':
					$template['subject'] = '{blogname}: Reset Password';
					$template['content'] = "<p>Hi {first_name} {last_name},</p></br>

					<p>You or someone else has requested to change password for your account: {username}</p></br>

					<p>Your new Password is: <strong>{NEW_PASSWORD}</strong></p></br>

					<p>To update your Password once you are logged from your Profile Page:
					{account_page}</p></br>

					<p>If you did not request for a new password, please ignore this Email notification.</p>";
					break;
				case 'change_password':
					$template['subject'] = '{blogname}: Your Password has been changed';
					$template['content'] = '<p>Hi {first_name} {last_name},</p><br/>

					<p>Your Password has been changed.</p><br/>

					<p>To login please fill out your credentials on:<br/>
					{login_page}</p><br/>

					<p>Your Username: {username}</p><br/>

					<p>Have a nice day!</p>';
					break;
				case 'user_update':
					$template['subject'] = '{blogname}: Your Account has been Updated';
					$template['content'] = '<p>Hi {username},</p><br/>

					<p>Your Account has been Updated.</p><br/>

					<p>To visit your Profile page follow the next link:<br/>
					{account_page}</p><br/>

					<p>Have a nice day!</p>';
					break;
				case 'rank_change':
					$template['subject'] = '{blogname}: You\'ve got a new Rank! ';
					$template['content'] = '<p>Hi {username},</p><br/>

					<p>You receive a new Rank!</p>

					<p>Have a nice day!</p>';
					break;
				case 'admin_on_aff_change_rank':
					$template['subject'] = '{blogname}: Hello';
					$template['content'] = '<p>{username} gets the following rank {rank_name}</p>';
					break;
				case 'admin_affiliate_update_profile':
					$template['subject'] = '{blogname}: Hello';
					$template['content'] = '<p>{username} has update his\\her profile.</p>';
					break;
				case 'affiliate_account_approve':
					$template['subject'] = '{blogname}: Your Account has been approved';
					$template['content'] = '<p>{username} has been approved.</p>';
					break;
				case 'affiliate_profile_delete':
					$template['subject'] = '{blogname}: Your Account has been deleted';
					$template['content'] = '<p>{username} Your account has been deleted.</p>';
					break;
				case 'affiliate_payment_fail':
					$template['subject'] = '{blogname}: Payment Inform';
					$template['content'] = '<p>Error on transfering {amount_to_pay} {amount_currency} to You!</p><p>Please review Your payment settings or contact the administrator!</p>';
					break;
				case 'affiliate_payment_pending':
					$template['subject'] = '{blogname}: Payment Inform';
					$template['content'] = '<p>{amount_to_pay} {amount_currency} has been sent to You. Payment status is pending.</p>';
					break;
				case 'affiliate_payment_complete':
					$template['subject'] = '{blogname}: Payment Inform';
					$template['content'] = '<p>Your {amount_to_pay} {amount_currency} it\'s now available to You.</p>';
					break;
				case 'email_check':
					$template['subject'] = '{blogname}: Email Verification';
					$template['content'] = '<p>Hi {first_name} {last_name},</p><br/>
	<p>You must confirm/validate your Email Account before logging in.</p><br/>
	<p>Please click on the following link to successfully activate your account:<br/>
	<a href="{verify_email_address_link}">click here</a></p><br/>
	<p>Have a nice day!</p><br/>';
					break;
				case 'email_check_success':
					$template['subject'] = '{blogname}: Email Verification Successfully';
					$template['content'] = '<p>Hi {first_name} {last_name},</p><br/>
	<p>Your account is now verified at {blogname}.</p><br/>
	<p>Have a nice day!</p><br/>';
					break;
				case 'register_lite_send_pass_to_user':
					$template['subject'] = '{blogname}: Your Password';
					$template['content'] = '<html><head></head><body>
<p>Hi {username}</p>
<p>Your password for {blogname} is {NEW_PASSWORD}</p>
					</body></html>';
					break;

			}
	}
	return $template;
}

function uap_convert_date_to_us_format($date=''){
	/*
	 * @param string
	 * @return string
	 */
	if ($date && $date!='-' && is_string($date)){
		@$date = strtotime($date);
		//$format = 'F j, Y';
		$format = get_option('date_format');
		$return_date = date_i18n($format, $date);

		$time_format = get_option('time_format');
		$time = date_i18n($time_format, $date);
		if ($time){
			$time = ' ' . $time;
		}
		return $return_date . $time;
	}
	return $date;
}

function uap_service_type_code_to_title($type=''){
	/*
	 * @param string
	 * @return string
	 */
	if ($type){
		switch ($type){
			case 'ump':
				$label = get_option('uap_custom_source_name_ump');
				if ($label){
						return $label;
				}
				return 'Ultimate Membership Pro';
				break;
			case 'woo':
				$label = get_option('uap_custom_source_name_woo');
				if ($label){
						return $label;
				}
			 	return 'WooCommerce';
				break;
			case 'ulp':
				$label = get_option('uap_custom_source_name_ulp');
				if ($label){
						return $label;
				}
				return 'Ultimate Learning Pro';
				break;
			case 'edd':
				$label = get_option('uap_custom_source_name_edd');
				if ($label){
						return $label;
				}
				return 'Easy Digital Downloads';
				break;
			case 'bonus':
				$label = get_option('uap_custom_source_name_bonus');
				if ($label){
						return $label;
				}
				return 'Bonus';
				break;
			case 'mlm':
				$label = get_option('uap_custom_source_name_mlm');
				if ($label){
						return $label;
				}
				return 'MLM';
				break;
			case 'User SignUp':
				$label = get_option('uap_custom_source_name_user_signup');
				if ($label){
						return $label;
				}
				return 'User SignUp';
				break;
			case 'from landing commissions':
				$label = get_option('uap_custom_source_name_landing_commissions');
				if ($label){
						return $label;
				}
				return 'Landing commissions';
				break;
			default:
				return $type;
				break;
		}
	}
	return '';
}

function uap_from_simple_array_to_k_v($arr){
	/*
	 * @param array
	 * @return array
	 */
	$return_arr = array();
	foreach ($arr as $v){
		$return_arr[$v] = $v;
	}
	return $return_arr;
}

function uap_make_string_simple($str=''){
	/*
	 * @param string
	 * @return string
	 */
	if (!empty($str)){
		$str = trim($str);
		$str = str_replace(' ', '_', $str);
		$str = preg_replace("/[^A-Za-z0-9_]/", '', $str);//remove all non-alphanumeric chars
	}
	return $str;
}

function uap_random_string($length=4, $keyspace='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'){
	/*
	 * @param length - int, keyspace - string
	 * @return string
	 */
	$str = '';
	$max = mb_strlen($keyspace, '8bit') - 1;
	for ($i = 0; $i < $length; ++$i) {
		$str .= $keyspace[rand(0, $max)];
	}
	return $str;
}

function uap_get_active_services(){
	/*
	 * @param none
	 * @return array
	 */
	 $array = array();
	 if (!function_exists('is_plugin_active')){
	 	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	 }
	 if (is_plugin_active('indeed-membership-pro/indeed-membership-pro.php')){
	 	$array['ump'] = 'Ultimate Membership Pro';
	 }
	 if (is_plugin_active('woocommerce/woocommerce.php')){
	 	$array['woo'] = 'WooCommerce';
	 }
	 if (is_plugin_active('indeed-learning-pro/indeed-learning-pro.php')){
	 	$array['ulp'] = 'Ultimate Learning Pro';
	 }
	 if (is_plugin_active('easy-digital-downloads/easy-digital-downloads.php')){
	 	$array['edd'] = 'Easy Digital Downloads';
	 }
	 return $array;
}

function uap_is_ump_active(){
	/*
	 * @param none
	 * @return bool
	 */
	  if (!function_exists('is_plugin_active')){
	 	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	 }
	 if (is_plugin_active('indeed-membership-pro/indeed-membership-pro.php')){
	 	return TRUE;
	 }
	 return FALSE;
}

function uap_get_avatar_for_uid($uid){
	/*
	 * @param int
	 * @return string
	 */
	global $indeed_db;
	$avatar_url = UAP_URL . 'assets/images/no-avatar.png';
	if (!empty($uid)){
		$avatar = get_user_meta($uid, 'uap_avatar', TRUE);
		if (!empty($avatar)){
			if (strpos($avatar, "http")===0){
				$avatar_url = $avatar;
			} else {
				$avatar_url = $indeed_db->getMediaBaseImage( $avatar );
				if ( $avatar_url && strpos($avatar_url, "http")===0 ){
						return $avatar_url;
				}
				$avatar_data = wp_get_attachment_image_src($avatar, 'full');
				if (!empty($avatar_data[0])){
					$avatar_url = $avatar_data[0];
				}
			}
		}
	}
	return $avatar_url;
}

function uap_get_possible_referral_types(){
	/*
	 * @param none
	 * @return array
	 */
	 $array = uap_get_active_services();
	 global $indeed_db;
	 if ($indeed_db->is_magic_feat_enable('mlm')){
	 	$array['mlm'] = __('Multi Level Marketing', 'uap');
	 }
	 if ($indeed_db->is_magic_feat_enable('bonus_on_rank')){
	 	$array['bonus'] = __('Bonus Rank', 'uap');
	 }
	 if ($indeed_db->is_magic_feat_enable('sign_up_referrals')){
	 	$array['User SignUp'] = __('SignUp', 'uap');
	 }
	 $referral_types = array();
	 foreach ($array as $k=>$v){
	 	$referral_types[$k]['label'] = $v;
		switch($k){
			case 'ump':
						$referral_types[$k]['sub_label'] = __('Based on Subscription purchases from Ultimate Membership system', 'uap');
						break;
			case 'woo':
						$referral_types[$k]['sub_label'] = __('Based on Product purchases from WooCommerce system', 'uap');
						break;
			case 'ulp':
						$referral_types[$k]['sub_label'] = __('Based on Product purchases from Ultimate Learning Pro system', 'uap');
						break;
			case 'edd':
						$referral_types[$k]['sub_label'] = __('Based on Product purchases from Easy Digital Downloads system', 'uap');
						break;
			case 'mlm':
						$referral_types[$k]['sub_label'] = __('Related on Rewarads provided to Affiliate from your MLM System', 'uap');
						break;
			case 'bonus':
						$referral_types[$k]['sub_label'] = __('Bonus when a new Rank is achieved', 'uap');
						break;
			case 'User SignUp':
						$referral_types[$k]['sub_label'] = __('Referrals from based on new user SignUp Rewards system', 'uap');
						break;
			default:
					$referral_types[$k]['sub_label'] = '';
		}
	 }
	return $referral_types;
}

function uap_generate_qr_code($link='', $file_unique_name=''){
	/*
	 * @param string, string
	 * @return string
	 */
	 if ($link){
	 	if (!class_exists('QRcode')){
	 		require_once UAP_PATH . 'classes/qrcode/qrlib.php';
	 	}
		ulp_empty_qr_images();/// delete old files
		if (strpos($file_unique_name, 'home')!==FALSE){
				$file_name = 'qrcode_' . $file_unique_name . '.png';
		} else {
				$file_name = 'qrcode_' . $file_unique_name . time() . '.png';
		}

		$file_location = UAP_PATH . 'classes/qrcode/images/' . $file_name;
		$file_link = UAP_URL . 'classes/qrcode/images/' . $file_name;
		$size = get_option('uap_qr_code_size');
		if (!$size){
			$size = 5;
		}

		$ecc_level = get_option('uap_qr_code_size');
		switch ($ecc_level){
			case 'l':
				$ecc_level = QR_ECLEVEL_L;
				break;
			case 'm':
				$ecc_level = QR_ECLEVEL_M;
				break;
			case 'q':
				$ecc_level = QR_ECLEVEL_Q;
				break;
			case 'h':
			default:
				$ecc_level = QR_ECLEVEL_H;
				break;
		}

		QRcode::png($link, $file_location, $ecc_level, $size);
		return $file_link;
	 }
	 return '';
}

function uap_do_opt_in($email=''){
	/*
	 * @param string
	 * @return none
	 */
	global $indeed_db;
	if (!get_option('uap_register_opt-in')){
		return;
	}
	$target_opt_in = get_option('uap_register_opt-in-type');
	if ($target_opt_in && $email){
		if (!class_exists('UapMailServices')){
			require_once UAP_PATH . 'classes/UapMailServices.class.php';
		}

		$uid = $indeed_db->getUidByEmail( $email );
		if ( isset( $_POST['first_name'] ) ){
				$firstName = esc_sql( $_POST['first_name'] );
		} else {
				$firstName = get_user_meta( 'first_name', $uid, true );
		}
		if ( !$firstName ){
				$firstName = '';
		}
		if ( isset( $_POST['last_name'] ) ){
				$lastName = esc_sql( $_POST['last_name'] );
		} else {
				$lastName = get_user_meta( 'last_name', $uid, true );
		}
		if ( !$lastName ){
				$lastName = '';
		}

		$indeed_mail = new UapMailServices();
		$indeed_mail->dir_path = UAP_PATH . 'classes';
		switch ($target_opt_in){
			case 'aweber':
				$awListOption = get_option('uap_aweber_list');
				if ($awListOption){
					$aw_list = str_replace('awlist', '', $awListOption);
					$consumer_key = get_option( 'uap_aweber_consumer_key' );
					$consumer_secret = get_option( 'uap_aweber_consumer_secret' );
					$access_key = get_option( 'uap_aweber_acces_key' );
					$access_secret = get_option( 'uap_aweber_acces_secret' );
					if ($consumer_key && $consumer_secret && $access_key && $access_secret){
						$return = $indeed_mail->indeed_aWebberSubscribe( $consumer_key, $consumer_secret, $access_key, $access_secret, $aw_list, $email, $firstName . ' ' . $lastName );
					}
				}
				break;
			case 'email_list':
				$email_list = get_option('uap_email_list');
				$email_list .= $email . ',';
				update_option('uap_email_list', $email_list);
				break;
			case 'mailchimp':
				$mailchimp_api = get_option( 'uap_mailchimp_api' );
				$mailchimp_id_list = get_option( 'uap_mailchimp_id_list' );
				if ($mailchimp_api && $mailchimp_id_list){
					$indeed_mail->indeed_mailChimp( $mailchimp_api, $mailchimp_id_list, $email, $firstName, $lastName );
				}
				break;
			case 'get_response':
				$api_key = get_option('uap_getResponse_api_key');
				$token = get_option('uap_getResponse_token');
				/*
				if ($api_key && $token){
					$indeed_mail->indeed_getResponse( $api_key, $token, $email, $firstName . ' ' . $lastName );
				}
				*/
				// since uap v. 5.8
				require_once UAP_PATH . 'classes/email_services/get_response_v3/vendor/autoload.php';
				$client = \Getresponse\Sdk\GetresponseClientFactory::createWithApiKey( $api_key );
				$newContact = new \Getresponse\Sdk\Operation\Model\NewContact(
							 new \Getresponse\Sdk\Operation\Model\CampaignReference( $token ),
							 $email
				);
				if ( $firstName && $lastName ){
						$newContact->setName( $firstName . ' ' . $lastName );
				}
				$createContact = new \Getresponse\Sdk\Operation\Contacts\CreateContact\CreateContact($newContact);
				$createContactResponse = $client->call($createContact);
				break;
			case 'campaign_monitor':
				$listId = get_option('uap_cm_list_id');
				$apiID = get_option('uap_cm_api_key');
				if ($listId && $apiID){
					$indeed_mail->indeed_campaignMonitor( $listId, $apiID, $email, $firstName . ' ' . $lastName );
				}
				break;
			case 'icontact':
				$appId = get_option('uap_icontact_appid');
				$apiPass = get_option('uap_icontact_pass');
				$apiUser = get_option('uap_icontact_user');
				$listId = get_option('uap_icontact_list_id');
				if ($appId && $apiPass && $apiUser && $listId){
					$indeed_mail->indeed_iContact( $apiUser, $appId, $apiPass, $listId, $email, $firstName, $lastName );
				}
				break;
			case 'constant_contact':
				$apiUser = get_option('uap_cc_user');
				$apiPass = get_option('uap_cc_pass');
				$listId = get_option('uap_cc_list');
				if ($apiUser && $apiPass && $listId){
					$indeed_mail->indeed_constantContact( $apiUser, $apiPass, $listId, $email, $firstName, $lastName );
				}
			break;
			case 'wysija':
				$listID = get_option('uap_wysija_list_id');
				if ($listID){
					$indeed_mail->indeed_wysija_subscribe( $listID, $email, $firstName, $lastName );
				}
				break;
			case 'mymail':
				$listID = get_option('uap_mymail_list_id');
				if ($listID){
					$indeed_mail->indeed_myMailSubscribe( $listID, $email, $firstName, $lastName );
				}
				break;
			case 'madmimi':
				$username = get_option('uap_madmimi_username');
				$api_key =  get_option('uap_madmimi_apikey');
				$listName = get_option('uap_madmimi_listname');
				if ($username && $api_key && $listName){
					$indeed_mail->indeed_madMimi( $username, $api_key, $listName, $email, $firstName, $lastName );
				}
				break;
			case 'active_campaign':
				$api_url = get_option('uap_active_campaign_apiurl');
				$api_key =  get_option('uap_active_campaign_apikey');
				if ($api_url && $api_key){
					$indeed_mail->add_contanct_to_active_campaign( $api_url, $api_key, $email, $firstName, $lastName );
				}
				break;
		}
	}
}

function uap_get_attachment_details($id, $return_type='name'){
	/*
	 * @param attachment id, what to return: name or extension
	 * @return string :
	 */
	$attachment_data = wp_get_attachment_url($id);
	if (isset($attachment_data)){
		$attachment_arr = explode('/', $attachment_data);
		if (isset($attachment_arr)){
			end($attachment_arr);
			$attachment_name = $attachment_arr[key($attachment_arr)];
			if ($return_type=='name'){
				return $attachment_name;
			}
			$attachment_type = explode('.', $attachment_name);
			if (isset($attachment_type)){
				end($attachment_type);
				if (isset($attachment_type[key($attachment_type)])){
					return $attachment_type[key($attachment_type)];
				}
			}
		}
	}
	return 'Unknown';
}

if (!function_exists('uap_get_countries')):

	function uap_get_countries(){
		/*
		 * @param none
		 * @return array
		 */
		 return array(
						'AF' => __( 'Afghanistan', 'uap' ),
						'AX' => __( '&#197;land Islands', 'uap' ),
						'AL' => __( 'Albania', 'uap' ),
						'DZ' => __( 'Algeria', 'uap' ),
						'AS' => __( 'American Samoa', 'uap' ),
						'AD' => __( 'Andorra', 'uap' ),
						'AO' => __( 'Angola', 'uap' ),
						'AI' => __( 'Anguilla', 'uap' ),
						'AQ' => __( 'Antarctica', 'uap' ),
						'AG' => __( 'Antigua and Barbuda', 'uap' ),
						'AR' => __( 'Argentina', 'uap' ),
						'AM' => __( 'Armenia', 'uap' ),
						'AW' => __( 'Aruba', 'uap' ),
						'AU' => __( 'Australia', 'uap' ),
						'AT' => __( 'Austria', 'uap' ),
						'AZ' => __( 'Azerbaijan', 'uap' ),
						'BS' => __( 'Bahamas', 'uap' ),
						'BH' => __( 'Bahrain', 'uap' ),
						'BD' => __( 'Bangladesh', 'uap' ),
						'BB' => __( 'Barbados', 'uap' ),
						'BY' => __( 'Belarus', 'uap' ),
						'BE' => __( 'Belgium', 'uap' ),
						'PW' => __( 'Belau', 'uap' ),
						'BZ' => __( 'Belize', 'uap' ),
						'BJ' => __( 'Benin', 'uap' ),
						'BM' => __( 'Bermuda', 'uap' ),
						'BT' => __( 'Bhutan', 'uap' ),
						'BO' => __( 'Bolivia', 'uap' ),
						'BQ' => __( 'Bonaire, Saint Eustatius and Saba', 'uap' ),
						'BA' => __( 'Bosnia and Herzegovina', 'uap' ),
						'BW' => __( 'Botswana', 'uap' ),
						'BV' => __( 'Bouvet Island', 'uap' ),
						'BR' => __( 'Brazil', 'uap' ),
						'IO' => __( 'British Indian Ocean Territory', 'uap' ),
						'VG' => __( 'British Virgin Islands', 'uap' ),
						'BN' => __( 'Brunei', 'uap' ),
						'BG' => __( 'Bulgaria', 'uap' ),
						'BF' => __( 'Burkina Faso', 'uap' ),
						'BI' => __( 'Burundi', 'uap' ),
						'KH' => __( 'Cambodia', 'uap' ),
						'CM' => __( 'Cameroon', 'uap' ),
						'CA' => __( 'Canada', 'uap' ),
						'CV' => __( 'Cape Verde', 'uap' ),
						'KY' => __( 'Cayman Islands', 'uap' ),
						'CF' => __( 'Central African Republic', 'uap' ),
						'TD' => __( 'Chad', 'uap' ),
						'CL' => __( 'Chile', 'uap' ),
						'CN' => __( 'China', 'uap' ),
						'CX' => __( 'Christmas Island', 'uap' ),
						'CC' => __( 'Cocos (Keeling) Islands', 'uap' ),
						'CO' => __( 'Colombia', 'uap' ),
						'KM' => __( 'Comoros', 'uap' ),
						'CG' => __( 'Congo (Brazzaville)', 'uap' ),
						'CD' => __( 'Congo (Kinshasa)', 'uap' ),
						'CK' => __( 'Cook Islands', 'uap' ),
						'CR' => __( 'Costa Rica', 'uap' ),
						'HR' => __( 'Croatia', 'uap' ),
						'CU' => __( 'Cuba', 'uap' ),
						'CW' => __( 'Cura&ccedil;ao', 'uap' ),
						'CY' => __( 'Cyprus', 'uap' ),
						'CZ' => __( 'Czech Republic', 'uap' ),
						'DK' => __( 'Denmark', 'uap' ),
						'DJ' => __( 'Djibouti', 'uap' ),
						'DM' => __( 'Dominica', 'uap' ),
						'DO' => __( 'Dominican Republic', 'uap' ),
						'EC' => __( 'Ecuador', 'uap' ),
						'EG' => __( 'Egypt', 'uap' ),
						'SV' => __( 'El Salvador', 'uap' ),
						'GQ' => __( 'Equatorial Guinea', 'uap' ),
						'ER' => __( 'Eritrea', 'uap' ),
						'EE' => __( 'Estonia', 'uap' ),
						'ET' => __( 'Ethiopia', 'uap' ),
						'FK' => __( 'Falkland Islands', 'uap' ),
						'FO' => __( 'Faroe Islands', 'uap' ),
						'FJ' => __( 'Fiji', 'uap' ),
						'FI' => __( 'Finland', 'uap' ),
						'FR' => __( 'France', 'uap' ),
						'GF' => __( 'French Guiana', 'uap' ),
						'PF' => __( 'French Polynesia', 'uap' ),
						'TF' => __( 'French Southern Territories', 'uap' ),
						'GA' => __( 'Gabon', 'uap' ),
						'GM' => __( 'Gambia', 'uap' ),
						'GE' => __( 'Georgia', 'uap' ),
						'DE' => __( 'Germany', 'uap' ),
						'GH' => __( 'Ghana', 'uap' ),
						'GI' => __( 'Gibraltar', 'uap' ),
						'GR' => __( 'Greece', 'uap' ),
						'GL' => __( 'Greenland', 'uap' ),
						'GD' => __( 'Grenada', 'uap' ),
						'GP' => __( 'Guadeloupe', 'uap' ),
						'GU' => __( 'Guam', 'uap' ),
						'GT' => __( 'Guatemala', 'uap' ),
						'GG' => __( 'Guernsey', 'uap' ),
						'GN' => __( 'Guinea', 'uap' ),
						'GW' => __( 'Guinea-Bissau', 'uap' ),
						'GY' => __( 'Guyana', 'uap' ),
						'HT' => __( 'Haiti', 'uap' ),
						'HM' => __( 'Heard Island and McDonald Islands', 'uap' ),
						'HN' => __( 'Honduras', 'uap' ),
						'HK' => __( 'Hong Kong', 'uap' ),
						'HU' => __( 'Hungary', 'uap' ),
						'IS' => __( 'Iceland', 'uap' ),
						'IN' => __( 'India', 'uap' ),
						'ID' => __( 'Indonesia', 'uap' ),
						'IR' => __( 'Iran', 'uap' ),
						'IQ' => __( 'Iraq', 'uap' ),
						'IE' => __( 'Republic of Ireland', 'uap' ),
						'IM' => __( 'Isle of Man', 'uap' ),
						'IL' => __( 'Israel', 'uap' ),
						'IT' => __( 'Italy', 'uap' ),
						'CI' => __( 'Ivory Coast', 'uap' ),
						'JM' => __( 'Jamaica', 'uap' ),
						'JP' => __( 'Japan', 'uap' ),
						'JE' => __( 'Jersey', 'uap' ),
						'JO' => __( 'Jordan', 'uap' ),
						'KZ' => __( 'Kazakhstan', 'uap' ),
						'KE' => __( 'Kenya', 'uap' ),
						'KI' => __( 'Kiribati', 'uap' ),
						'KW' => __( 'Kuwait', 'uap' ),
						'KG' => __( 'Kyrgyzstan', 'uap' ),
						'LA' => __( 'Laos', 'uap' ),
						'LV' => __( 'Latvia', 'uap' ),
						'LB' => __( 'Lebanon', 'uap' ),
						'LS' => __( 'Lesotho', 'uap' ),
						'LR' => __( 'Liberia', 'uap' ),
						'LY' => __( 'Libya', 'uap' ),
						'LI' => __( 'Liechtenstein', 'uap' ),
						'LT' => __( 'Lithuania', 'uap' ),
						'LU' => __( 'Luxembourg', 'uap' ),
						'MO' => __( 'Macao S.A.R., China', 'uap' ),
						'MK' => __( 'Macedonia', 'uap' ),
						'MG' => __( 'Madagascar', 'uap' ),
						'MW' => __( 'Malawi', 'uap' ),
						'MY' => __( 'Malaysia', 'uap' ),
						'MV' => __( 'Maldives', 'uap' ),
						'ML' => __( 'Mali', 'uap' ),
						'MT' => __( 'Malta', 'uap' ),
						'MH' => __( 'Marshall Islands', 'uap' ),
						'MQ' => __( 'Martinique', 'uap' ),
						'MR' => __( 'Mauritania', 'uap' ),
						'MU' => __( 'Mauritius', 'uap' ),
						'YT' => __( 'Mayotte', 'uap' ),
						'MX' => __( 'Mexico', 'uap' ),
						'FM' => __( 'Micronesia', 'uap' ),
						'MD' => __( 'Moldova', 'uap' ),
						'MC' => __( 'Monaco', 'uap' ),
						'MN' => __( 'Mongolia', 'uap' ),
						'ME' => __( 'Montenegro', 'uap' ),
						'MS' => __( 'Montserrat', 'uap' ),
						'MA' => __( 'Morocco', 'uap' ),
						'MZ' => __( 'Mozambique', 'uap' ),
						'MM' => __( 'Myanmar', 'uap' ),
						'NA' => __( 'Namibia', 'uap' ),
						'NR' => __( 'Nauru', 'uap' ),
						'NP' => __( 'Nepal', 'uap' ),
						'NL' => __( 'Netherlands', 'uap' ),
						'AN' => __( 'Netherlands Antilles', 'uap' ),
						'NC' => __( 'New Caledonia', 'uap' ),
						'NZ' => __( 'New Zealand', 'uap' ),
						'NI' => __( 'Nicaragua', 'uap' ),
						'NE' => __( 'Niger', 'uap' ),
						'NG' => __( 'Nigeria', 'uap' ),
						'NU' => __( 'Niue', 'uap' ),
						'NF' => __( 'Norfolk Island', 'uap' ),
						'MP' => __( 'Northern Mariana Islands', 'uap' ),
						'KP' => __( 'North Korea', 'uap' ),
						'NO' => __( 'Norway', 'uap' ),
						'OM' => __( 'Oman', 'uap' ),
						'PK' => __( 'Pakistan', 'uap' ),
						'PS' => __( 'Palestinian Territory', 'uap' ),
						'PA' => __( 'Panama', 'uap' ),
						'PG' => __( 'Papua New Guinea', 'uap' ),
						'PY' => __( 'Paraguay', 'uap' ),
						'PE' => __( 'Peru', 'uap' ),
						'PH' => __( 'Philippines', 'uap' ),
						'PN' => __( 'Pitcairn', 'uap' ),
						'PL' => __( 'Poland', 'uap' ),
						'PT' => __( 'Portugal', 'uap' ),
						'PR' => __( 'Puerto Rico', 'uap' ),
						'QA' => __( 'Qatar', 'uap' ),
						'RE' => __( 'Reunion', 'uap' ),
						'RO' => __( 'Romania', 'uap' ),
						'RU' => __( 'Russia', 'uap' ),
						'RW' => __( 'Rwanda', 'uap' ),
						'BL' => __( 'Saint Barth&eacute;lemy', 'uap' ),
						'SH' => __( 'Saint Helena', 'uap' ),
						'KN' => __( 'Saint Kitts and Nevis', 'uap' ),
						'LC' => __( 'Saint Lucia', 'uap' ),
						'MF' => __( 'Saint Martin (French part)', 'uap' ),
						'SX' => __( 'Saint Martin (Dutch part)', 'uap' ),
						'PM' => __( 'Saint Pierre and Miquelon', 'uap' ),
						'VC' => __( 'Saint Vincent and the Grenadines', 'uap' ),
						'SM' => __( 'San Marino', 'uap' ),
						'ST' => __( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe', 'uap' ),
						'SA' => __( 'Saudi Arabia', 'uap' ),
						'SN' => __( 'Senegal', 'uap' ),
						'RS' => __( 'Serbia', 'uap' ),
						'SC' => __( 'Seychelles', 'uap' ),
						'SL' => __( 'Sierra Leone', 'uap' ),
						'SG' => __( 'Singapore', 'uap' ),
						'SK' => __( 'Slovakia', 'uap' ),
						'SI' => __( 'Slovenia', 'uap' ),
						'SB' => __( 'Solomon Islands', 'uap' ),
						'SO' => __( 'Somalia', 'uap' ),
						'ZA' => __( 'South Africa', 'uap' ),
						'GS' => __( 'South Georgia/Sandwich Islands', 'uap' ),
						'KR' => __( 'South Korea', 'uap' ),
						'SS' => __( 'South Sudan', 'uap' ),
						'ES' => __( 'Spain', 'uap' ),
						'LK' => __( 'Sri Lanka', 'uap' ),
						'SD' => __( 'Sudan', 'uap' ),
						'SR' => __( 'Suriname', 'uap' ),
						'SJ' => __( 'Svalbard and Jan Mayen', 'uap' ),
						'SZ' => __( 'Swaziland', 'uap' ),
						'SE' => __( 'Sweden', 'uap' ),
						'CH' => __( 'Switzerland', 'uap' ),
						'SY' => __( 'Syria', 'uap' ),
						'TW' => __( 'Taiwan', 'uap' ),
						'TJ' => __( 'Tajikistan', 'uap' ),
						'TZ' => __( 'Tanzania', 'uap' ),
						'TH' => __( 'Thailand', 'uap' ),
						'TL' => __( 'Timor-Leste', 'uap' ),
						'TG' => __( 'Togo', 'uap' ),
						'TK' => __( 'Tokelau', 'uap' ),
						'TO' => __( 'Tonga', 'uap' ),
						'TT' => __( 'Trinidad and Tobago', 'uap' ),
						'TN' => __( 'Tunisia', 'uap' ),
						'TR' => __( 'Turkey', 'uap' ),
						'TM' => __( 'Turkmenistan', 'uap' ),
						'TC' => __( 'Turks and Caicos Islands', 'uap' ),
						'TV' => __( 'Tuvalu', 'uap' ),
						'UG' => __( 'Uganda', 'uap' ),
						'UA' => __( 'Ukraine', 'uap' ),
						'AE' => __( 'United Arab Emirates', 'uap' ),
						'GB' => __( 'United Kingdom (UK)', 'uap' ),
						'US' => __( 'United States (US)', 'uap' ),
						'UM' => __( 'United States (US) Minor Outlying Islands', 'uap' ),
						'VI' => __( 'United States (US) Virgin Islands', 'uap' ),
						'UY' => __( 'Uruguay', 'uap' ),
						'UZ' => __( 'Uzbekistan', 'uap' ),
						'VU' => __( 'Vanuatu', 'uap' ),
						'VA' => __( 'Vatican', 'uap' ),
						'VE' => __( 'Venezuela', 'uap' ),
						'VN' => __( 'Vietnam', 'uap' ),
						'WF' => __( 'Wallis and Futuna', 'uap' ),
						'EH' => __( 'Western Sahara', 'uap' ),
						'WS' => __( 'Samoa', 'uap' ),
						'YE' => __( 'Yemen', 'uap' ),
						'ZM' => __( 'Zambia', 'uap' ),
						'ZW' => __( 'Zimbabwe', 'uap' )
		);
	}

endif;

if (!function_exists('indeed_debug_var')):
function indeed_debug_var($variable){
	/*
	 * print the array into '<pre>' tags
	 * @param array, string, int ... anything
	 * @return none (echo)
	 */
	 if (is_array($variable) || is_object($variable)){
		 echo '<pre>';
		 print_r($variable);
		 echo '</pre>';
	 } else {
	 	var_dump($variable);
	 }
}
endif;


if (!function_exists('uap_reorder_menu_items')):
function uap_reorder_menu_items($order=array(), $array=array()){
	/*
	 * @param array, array
	 * @return array
	 */
	 if (!empty($order) && is_array($order)){
		 $return_array = array();
		 foreach ($order as $key=>$value){
		 	 if (isset($array[$key])){
		 	 	 $return_array[$key] = $array[$key];
				 unset($array[$key]);
		 	 }
		 }
		 if (!empty($array)){
		 	$return_array = array_merge($return_array, $array);
		 }
		 return $return_array;
	 }
	 return $array;
}
endif;

if (!function_exists('uap_format_price_and_currency')):
function uap_format_price_and_currency($currency='', $price_value=''){
	/*
	 * @param string, string
	 * @return string
	 */
	 $output = '';
	 $data = get_option('uap_currency_position');
	 if (empty($data)){
	 	$data = 'right';
	 }

	 $settings = [
		 							'uap_num_of_decimals'			=> get_option( 'uap_num_of_decimals' ),
							 		'uap_thousands_separator'	=> get_option( 'uap_thousands_separator' ),
									'uap_decimals_separator'	=> get_option( 'uap_decimals_separator' ),
	 ];
	 if ( isset( $settings['uap_num_of_decimals'] ) && isset( $settings['uap_decimals_separator'] ) && isset( $settings['uap_thousands_separator'] ) ){
			$price_value = number_format( $price_value, $settings['uap_num_of_decimals'], $settings['uap_decimals_separator'], $settings['uap_thousands_separator'] );
	 }

	 if ($data=='left'){
	 	$output = $currency . $price_value;
	 } else {
	 	$output = $price_value . $currency;
	 }
	 return $output;
}
endif;

if (!function_exists('uap_get_array_key_for_subarray_element')):
function uap_get_array_key_for_subarray_element($haystack=array(), $needle='', $value=''){
	/*
	 * @param array (where to search)
	 * @param string (search key)
	 * @param string (search value)
	 * @return int (-1 if not found)
	 */
	foreach ($haystack as $key=>$array){
		if ($array[$needle]==$value){
			return $key;
		}
	}
	return -1;
}
endif;

/**
 * Convert array of objects into array of array
 * @param mixed (array or object)
 * @return array
 */
if (!function_exists('indeed_convert_to_array')):
function indeed_convert_to_array($input=null){
	if ($input){
		foreach ($input as $object){
			$array[] = (array)$object;
		}
		return $array;
	}
	return $input;
}
endif;

if (!function_exists('ulp_empty_qr_images')):
function ulp_empty_qr_images(){
		$path = UAP_PATH . 'classes/qrcode/images/';
		if ($handle = opendir($path)) {
				while (false !== ($file = readdir($handle))){
						$filetime = filectime($path.'/'.$file)+3600;
						$time = time();
				    if ($filetime && $time-$filetime >= 0) {
				      if (preg_match('/\.png$/i', $file)) {
				        unlink($path.'/'.$file);
				      }
				    }
				}
		}
}
endif;

if (!function_exists('indeed_get_uid')):
function indeed_get_uid(){
		global $current_user;
		if (isset($current_user->ID)){
				return $current_user->ID;
		}
		return 0;
}
endif;

if (!function_exists('dd')):
function dd($variable)
{
		indeed_debug_var($variable);
		die;
}
endif;

if ( !function_exists('indeed_get_current_language_code') ):
function indeed_get_current_language_code()
{
		$languageCode = get_locale();
		if ( !$languageCode ){
				return false;
		}
		$language = explode( '_', $languageCode );
		if ( isset($language[0]) ){
				return $language[0];
		}
		return $languageCode;
}
endif;

if ( !function_exists( 'uapIsRegisterPage' ) ):
function uapIsRegisterPage( $url )
{
		$registerPage = get_option('uap_general_register_default_page');
		if ( !$registerPage || $registerPage==-1 ){
				return false;
		}
		$permalink = get_permalink($registerPage);
		if ( empty( $permalink ) || $permalink == '' ){
				return false;
		}
		if ( strpos( $url, $permalink) !== false ){
				return true;
		}
		return false;
}
endif;

if ( !function_exists( 'uap_generate_color_hex' ) ):
/**
 * @param none
 * @return string
 */
function uap_generate_color_hex()
{
	$colors = [
			'#0a9fd8',
			'#38cbcb',
			'#27bebe',
			'#0bb586',
			'#94c523',
			'#6a3da3',
			'#f1505b',
			'#ee3733',
			'#f36510',
			'#f8ba01',
	];
	return $colors[rand(0, (count($colors)-1) )];
}
endif;

if ( !function_exists( 'indeedIsAdmin' ) ):
function indeedIsAdmin()
{
		global $current_user;
		if ( empty( $current_user->ID ) ){
				return false;
		}
		$userData = get_userdata( $current_user->ID );
		if ( !$userData || empty( $userData->roles ) ){
				return false;
		}
		if ( !in_array( 'administrator', $userData->roles ) ){
				return false;
		}
		return true;
}
endif;

if ( !function_exists( 'uapAdminVerifyNonce' ) ):
function uapAdminVerifyNonce()
{
		$nonce = isset( $_SERVER['HTTP_X_CSRF_UAP_ADMIN_TOKEN'] ) ? $_SERVER['HTTP_X_CSRF_UAP_ADMIN_TOKEN']	: '';
		if ( wp_verify_nonce( $nonce, 'uapAdminNonce' ) ) {
				return true;
		}
		return false;
}
endif;

if ( !function_exists( 'uapPublicVerifyNonce' ) ):
function uapPublicVerifyNonce()
{
		$nonce = isset( $_SERVER['HTTP_X_CSRF_UAP_TOKEN'] ) ? $_SERVER['HTTP_X_CSRF_UAP_TOKEN']	: '';
		if ( wp_verify_nonce( $nonce, 'uapPublicNonce' ) ) {
				return true;
		}
		return false;
}
endif;

if ( !function_exists('uapInputNumerStep') ):
function uapInputNumerStep()
{
		$number = get_option( 'uap_num_of_decimals' );
		if ( $number === FALSE ){
				return 0.01;
		}
		if ( $number == 0 ){
			return 1;
		}
		$j = 1;
		for ( $i=0; $i<$number; $i++ ){
				$j = $j / 10;
		}
		return $j;
}
endif;

if ( !function_exists('getDefaultCountry') ):
function getDefaultCountry()
{
		$locale = 'US';

		$defaultcountry = get_option( 'uap_defaultcountry' );
		if(empty($defaultcountry)){
				$locale = get_locale();
				$locale_arr = explode( '_' , $locale);

				if(is_array($locale_arr) && isset($locale_arr[1]))
					$locale = $locale_arr[1];
				elseif(isset($locale_arr[0]))
					$locale = $locale_arr[0];
		}else{
			$locale = $defaultcountry;
		}
		return strtolower ($locale);
}
endif;

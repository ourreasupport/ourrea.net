jQuery(document).ready(function($){'use strict';var $contentProtectedAlert=$('#maxcoach-content-protected-box');var delayTime=3000;$(document).on('contextmenu',function(){$contentProtectedAlert.show().delay(delayTime).fadeOut();return false;});$(window).on('keydown',function(event){if(event.keyCode==123){$contentProtectedAlert.show().delay(delayTime).fadeOut();return false;}
if(event.ctrlKey&&event.shiftKey&&(event.keyCode==67||event.keyCode==73||event.keyCode==74)){$contentProtectedAlert.show().delay(delayTime).fadeOut();return false;}
if(event.metaKey&&event.altKey&&(event.keyCode==67||event.keyCode==73||event.keyCode==74)){$contentProtectedAlert.show().delay(delayTime).fadeOut();return false;}
if(event.metaKey&&event.shiftKey&&event.keyCode==67){$contentProtectedAlert.show().delay(delayTime).fadeOut();return false;}});});
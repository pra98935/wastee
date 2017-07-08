<?php
//	$cookie_email = '';
//	$cookie_password = '';
//	if(!$this->user_id) {
//		if(isset($_COOKIE['users'])) {
//			$users_cookie = unserialize($_COOKIE['users']);
//			$cookie_email = $users_cookie['email'];
//			$cookie_password = $users_cookie['key'];
//		} 
//	}
?>
<script type="text/javascript">
	var site_url           = '<?php echo site_url()?>';
	var base_url           = '<?php echo base_url()?>';
	var project_name       = '<?php echo PROJECT_NAME;?>';
	var timeZone           = '<?php echo DEFAULT_TIME_ZONE_ABBR ?>';
	var AUTH_KEY           = '<?php echo AUTH_KEY; ?>';
	var IMAGE_UPLOADS_URL           = '<?php echo IMAGE_UPLOADS_URL; ?>';
	var FacebookAppId      = '<?php echo FACEBOOK_ID ?>';
	var google_client_id      = '<?php echo GOOGLE_CLIENT_ID ?>';
	var google_scope      = '';
	var google_api_key      = '<?php echo GOOGLE_API_KEY ?>';
	
</script>
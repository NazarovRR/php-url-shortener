<?php
function webpage_exist($webpage)
{
	$headers = @get_headers($webpage);
	if(strpos($headers[0],'200')===FALSE)return FALSE;
	return TRUE;
}
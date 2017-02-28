<?php
function webpage_exist($webpage)
{
	$headers = @get_headers($webpage);
	if(in_array("HTTP/1.0 200 OK", $headers)) {
		return TRUE;
	} else {
		return FALSE;
	}
}
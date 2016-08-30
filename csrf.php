<?php

/**
 * CSRF対策
 */
function getToken()
{
	return hash('sha256', session_id());
}

?>

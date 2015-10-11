<?php
function getIP(){							
$variables = array('REMOTE_ADDR', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'HTTP_X_COMING_FROM', 'HTTP_COMING_FROM', 'HTTP_CLIENT_IP');		
$return = 'Unknown';		
foreach ($variables as $variable)
{
	if (isset($_SERVER[$variable]))
	{
		$return = $_SERVER[$variable];
		break;
	}
}
return $return;
}
?>
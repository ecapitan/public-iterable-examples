<?php 
	// set Iterable API key
	$api_key = "EnterYourAPIKey";

	// set user email
	// email must be URL encoded for use in the GET Display in-app messages to user call
	// set user email; for use in the POST Consume In-App URL
	$email = "enrico.capitan+950@iterable.com";

	if (isset($_GET["messageId"])) {
		// set messageId variable
		$messageId = htmlspecialchars($_GET["messageId"]);
		// echo $messageId . "<br />";
		
		// variabilize the Consume In-App URL
		$consumeInAppURL = "https://api.iterable.com/api/events/inAppConsume?api_key=" . "$api_key";
		// echo $consumeInAppURL . "<br />";
        
        // prepare the data to post
        $data_string = '{"email": "' . $email . '","messageId": "' . $messageId . '"}';
		// echo $data_string . "<br />";
        
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $consumeInAppURL);
        
        // TRUE to do a regular HTTP POST.
        curl_setopt($ch, CURLOPT_POST, 1);

		// Headers
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		// TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it directly.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		// data to post
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		
        // executes the request
        $output = curl_exec($ch);
        //var_dump($output);

        // close curl resource to free up system resources
        curl_close($ch);     

	}

?>

<html>
<head>
	<title>Enrico's Web In-App PHP example</title>
	<style>
		table, th, td {
  			border: 1px solid black;
		}
	</style>
</head>
<body>

<div>Enrico's Web In-App PHP example</div>
<br />
<div>This example is tied to the 'EnricoTrainingProject' project in the 'training@iterable.com' organization.<br />
Future revisions will allow you to set the API key and email address.</div>
<br />
<div>Usage Instructions:<br />
<ul>
<li>Access the 'EnricoTrainingProject'</li>
<li>Create an In-app template</li>
<li>Create and send an In-app campaign using the 'enrico.capitan+950@iterable.com' list and the template you just created</li>
<li>Refresh this page and you should see the In-app message appear</li>
<li>Click Delete to delete the message</li>
</ul>

<br />

<table>
	<tr>
		<th>Message</th><th>Delete</th>
	</tr>
<?php
		// variabilize the GET Display in-app messages to user URL
		$displayInAppMessagesURL = "https://api.iterable.com/api/inApp/getMessages?api_key=" . $api_key . "&email=" . urlencode($email) . "&count=10&platform=iOS&SDKVersion=None";
		// echo $displayInAppMessagesURL . "<br />";

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $displayInAppMessagesURL);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);     
        
        /*
        echo "Output as string";
        echo "<br />";
        var_dump($output);
        echo "<br />";
        echo "<br />";
        */
        
        //convert to an array
        $output = json_decode($output);
        
        /*
        echo "Output as array";
        echo "<br />";
        var_dump($output);
		echo "<br />";
        echo "<br />";
        */


/* for looping through an array of arrays
		foreach ($output as $value){
			//echo $key;
			//echo $value;
			foreach ($value as $key => $value){
				echo $key;
				echo "<br />";
				var_dump($value);
				echo "<br />";
				echo "<br />";
			}
		}
*/

/* for looping through an array of objects */
		foreach($output->inAppMessages as $inAppMessage){
			echo "<tr>";
			echo "<td>" . $inAppMessage->content->html . "</td>";
			echo "<td>" . '<a href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . '?messageId=' . $inAppMessage->messageId . '">Delete</a>'. '</td>';
			echo "</tr>";
		}

?>
</table>

</body>
</html>
<?php 
	// set Iterable API key
	$api_key = "enterYourAPIKey";

    if (isset($_POST['submit'])){

		// set email variable from POST variable
		if (isset($_POST["email"])) {
		$email = htmlspecialchars($_POST["email"]);
		// echo $email . "<br />";
		}

    	// prepare the data to post
        $data_string = '{"email": "' . $email . '","unsubscribedChannelIds": [';

    	if (isset($_POST['unsubscribe'])){
    		// echo $_POST['unsubscribe'] . "<br>";
    		// build "unsubscribedChannelIds" array
    		$data_string .= '24198,';
    	}
        
        $data_string .= '0],"unsubscribedMessageTypeIds": [';
        
    	if (!isset($_POST['dailyPromotional'])){
    		//add 26846 to the "unsubscribedMessageTypeIds" array
    		$data_string .= '26846,';
    	}

    	if (!isset($_POST['weeklyPromotional'])){
    		//add 29250 to the "unsubscribedMessageTypeIds" array
    		$data_string .= '29250,';
    	}

    	if (!isset($_POST['weeklyNewsletter'])){
    		//add 29251 to the "unsubscribedMessageTypeIds" array
    		$data_string .= '29251,';
    	}

    	if (!isset($_POST['cartReminders'])){
    		//add 29252 to the "unsubscribedMessageTypeIds" array
    		$data_string .= '29252,';
    	}

    	if (!isset($_POST['productSuggestions'])){
    		//add 29253 to the "unsubscribedMessageTypeIds" array
    		$data_string .= '29253,';
    	}

		$data_string .= '0]}';

		// echo $data_string . "<br>";
		
		// variabilize the Update user subscriptions URL
		$updateUserSubscriptionsURL = "https://api.iterable.com/api/users/updateSubscriptions?api_key=" . "$api_key";
		// echo $updateUserSubscriptionsURL . "<br />";        
        
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $updateUserSubscriptionsURL);
        
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

		// sleep for 10 seconds
		sleep(2);

    }

    // set the variable for the email marketing channel to false
    $emailMarketingChannel = FALSE;
    
    // set the variables for each of the message types to true
    $dailyPromotional = TRUE;
    $weeklyPromotional = TRUE;
    $weeklyNewsletter = TRUE;
    $cartReminders = TRUE;
    $productSuggestions = TRUE;


	// retrieve email from URL
	if (isset($_GET["email"]) || isset($_POST["email"])) {
		
		// set email variable from GET variable
		if (isset($_GET["email"])) {
		$email = htmlspecialchars($_GET["email"]);
		// echo $email . "<br />";
		}

		// set email variable from POST variable
		if (isset($_POST["email"])) {
		$email = htmlspecialchars($_POST["email"]);
		// echo $email . "<br />";
		}
		
		// variabilize the Get a user by email URL
		$getUserByEmailURL = "https://api.iterable.com/api/users/" . urlencode($email) . "?api_key=" . $api_key;
		// echo $getUserByEmailURL . "<br />";
        
        
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $getUserByEmailURL);
        
		// TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it directly.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				
        // executes the request
        $output = curl_exec($ch);
        // var_dump($output);

        // close curl resource to free up system resources
        curl_close($ch);     

		//convert to an array
        $output = json_decode($output);
        // var_dump($output);
        
        /* for looping through the array of unsubscribedChannelIds */
		foreach($output->user->dataFields->unsubscribedChannelIds as $unsubscribedChannelId){
			// echo $unsubscribedChannelId . "<br>";
			if ($unsubscribedChannelId == 24198) {
				$emailMarketingChannel = TRUE;
			}
		} // end of loop through unsubscribedChannelIds

        /* for looping through the array of unsubscribedMessageTypeIds */
		foreach($output->user->dataFields->unsubscribedMessageTypeIds as $unsubscribedMessageTypeId){
			// echo $unsubscribedMessageTypeId . "<br>";
			if ($unsubscribedMessageTypeId == 26846) {
				$dailyPromotional = FALSE;
			}
			if ($unsubscribedMessageTypeId == 29250) {
				$weeklyPromotional = FALSE;
			}
   			if ($unsubscribedMessageTypeId == 29251) {
				$weeklyNewsletter = FALSE;
			} 			
     		if ($unsubscribedMessageTypeId == 29252) {
				$cartReminders = FALSE;
			} 			  			
       		if ($unsubscribedMessageTypeId == 29253) {
				$productSuggestions = FALSE;
			} 	  			
		} // end of loop through unsubscribedMessageTypeIds
		
	} // end of "if (isset($_GET["email"]))""

	// echo $emailMarketingChannel . "<br>";
    // echo $dailyPromotional . "<br>";
    // echo $weeklyPromotional . "<br>";
    // echo $weeklyNewsletter . "<br>";
    // echo $cartReminders . "<br>";
    // echo $productSuggestions . "<br>";

?>

<html>
<head>
	<title>Enrico's Subscription Preference Center PHP example</title>
	<style>
		table, th, td {
  			border: 1px solid black;
		}
	</style>
</head>
<body>

<div>Enrico's Subscription Preference Center PHP example</div>
<br />
<div>This example is tied to the 'EnricoTrainingProject' project in the 'training@iterable.com' organization.</div>
<br />
<div>Email Subscription Preferences<br />
<br />
<form action="/preferences.php" method="post">
  <fieldset>
    <legend>I would like to receive the following types of marketing emails:</legend>
    <input type="checkbox" name="dailyPromotional" value="26846" <?php if ($dailyPromotional) {echo "checked";}?>> Daily Promotional<br>
    <input type="checkbox" name="weeklyPromotional" value="29250" <?php if ($weeklyPromotional) {echo "checked";}?>> Weekly Promotional<br>
    <input type="checkbox" name="weeklyNewsletter" value="29251" <?php if ($weeklyNewsletter) {echo "checked";}?>> Weekly Newsletter<br>
    <input type="checkbox" name="cartReminders" value="29252" <?php if ($cartReminders) {echo "checked";}?>> Cart Reminders<br>
    <input type="checkbox" name="productSuggestions" value="29253" <?php if ($productSuggestions) {echo "checked";}?>> Product Suggestions<br>
    <br>
    <input type="checkbox" name="unsubscribe" value="24198" <?php if ($emailMarketingChannel) {echo "checked";}?>> Unsubscribe me from all marketing emails<br>
    <input type="hidden" name="email" value="<?php if (isset($email)) {echo $email;}?>">
    <input type="submit" name="submit" value="Submit">
  </fieldset>
</form>
<br />
</div>

</body>
</html>
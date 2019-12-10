<html>
<head>
	<title>Enrico's Setting cookies with JavaScript example</title>
	<style>
		table, th, td {
  			border: 1px solid black;
		}
	</style>
	<script>
		/**
		 * Get the URL parameters
		 * source: https://css-tricks.com/snippets/javascript/get-url-variables/
		 * @param  {String} url The URL
		 * @return {Object}     The URL parameters
		 */
		var getParams = function (url) {
			var params = {};
			var parser = document.createElement('a');
			parser.href = url;
			var query = parser.search.substring(1);
			var vars = query.split('&');
			for (var i = 0; i < vars.length; i++) {
				var pair = vars[i].split('=');
				params[pair[0]] = decodeURIComponent(pair[1]);
			}
			return params;
		};
	</script>
</head>
<body>
<div>Enrico's Setting cookies with JavaScript example</div>
<br />
<br />

<div>
Display parameters from the current URL<br>

<script>
// put parameters into a variable to work with
var parameters = getParams(window.location.href);
console.log(parameters);

// get tomorrow's date
var tomorrow = new Date();
tomorrow.setDate(tomorrow.getDate() + 1);

// display parameters on page and set cookies
for (let [key, value] of Object.entries(parameters)) {
  console.log(`${key}: ${value}`);
  document.write(key + ": " +value + "<br>");
  document.cookie = key + "=" + value + "; expires=" + tomorrow + "; path=/";
}
</script>

</div


</body>
</html>
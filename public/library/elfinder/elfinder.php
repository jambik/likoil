<?php

// Load Laravel Framework
require __DIR__.'/../../../bootstrap/autoload.php';
$app = require_once __DIR__.'/../../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')
		->pushMiddleware(\App\Http\Middleware\EncryptCookies::class)
		->pushMiddleware(\Illuminate\Session\Middleware\StartSession::class)
//		->pushMiddleware(\App\Http\Middleware\Admin::class)
		->handle(Illuminate\Http\Request::capture());

if ( ! Auth::check() || ! Auth::user()->hasRole(['admin'])) {
	echo 'Unauthorized.';
	return;
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>elFinder 2.1.x source version with PHP connector</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2" />

		<!-- Section CSS -->
		<!-- jQuery UI (REQUIRED) -->
		<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/themes/smoothness/jquery-ui.css">

		<!-- elFinder CSS (REQUIRED) -->
		<link rel="stylesheet" type="text/css" href="css/elfinder.min.css">
		<link rel="stylesheet" type="text/css" href="css/theme.css">
		<link rel="stylesheet" type="text/css" href="css/theme-bootstrap-libreicons-svg.css">

		<!-- Section JavaScript -->
		<!-- jQuery and jQuery UI (REQUIRED) -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>

		<!-- elFinder JS (REQUIRED) -->
		<script src="js/elfinder.min.js"></script>

		<!-- GoogleDocs Quicklook plugin for GoogleDrive Volume (OPTIONAL) -->
		<!--<script src="js/extras/quicklook.googledocs.js"></script>-->

		<!-- elFinder translation (OPTIONAL) -->
		<script src="js/i18n/elfinder.ru.js"></script>

		<!-- elFinder initialization (REQUIRED) -->
		<script type="text/javascript" charset="utf-8">
			// Documentation for client options:
			// https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
			/*$(document).ready(function() {
				$('#elfinder').elfinder({
					url : 'php/connector.minimal.php'  // connector URL (REQUIRED)
					// , lang: 'ru'                    // language (OPTIONAL)
				});
			});*/

			// Helper function to get parameters from the query string.
			function getUrlParam(paramName) {
				var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
				var match = window.location.search.match(reParam) ;

				return (match && match.length > 1) ? match[1] : '' ;
			}

			$(document).ready(function() {
				var funcNum = getUrlParam('CKEditorFuncNum');

				var elf = $('#elfinder').elfinder({
					url : 'php/connector.php',
					getFileCallback : function(file) {
						window.opener.CKEDITOR.tools.callFunction(funcNum, file.url);
						elf.destroy();
						window.close();
					},
					resizable: false,
					lang: 'ru'
				}).elfinder('instance');
			});
		</script>
	</head>
	<body>

		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinder"></div>

	</body>
</html>

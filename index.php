<?php
$ch = curl_init();
$resp = "";
if(isset($_POST['formsubmit']))
{
	$requestMethod = "" . $_POST['method'];
	$numOfRedirects = "" . $_POST['redirects'];
	$url = "" . $_POST['url'];
	$headers = array();
	$headerCount = 0;
	while (isset($_POST['headerkey' . ($headerCount+1)])) {
		array_push($headers, $_POST['headerkey' . ($headerCount+1)] . ": " . $_POST['headervalue' . ($headerCount+1)]);
		$headerCount = $headerCount + 1;
	}
	if ($requestMethod == "1") {
		$resp = send_get($url, $numOfRedirects, $headers, $ch);
	}
	if ($requestMethod == "2") {
		$postInput = "" . $_POST['postInput'];
		if ($postInput == "1") {
			$parameterCount = 0;
			$params = array();
			while (isset($_POST['parameterkey' . ($parameterCount+1)])) {
				$params = array_merge ($params, [($_POST['parameterkey' . ($parameterCount+1)]) => ($_POST['parametervalue' . ($parameterCount+1)])]);
				$parameterCount = $parameterCount + 1;
			}
			$resp = send_post($url, $params, $numOfRedirects, $headers, $ch);
		} else {
			$resp = send_post($url, "" . $_POST['postbody'], $numOfRedirects, $headers, $ch);
		}
	}
}
function send_post($url, $data, $numRedirects, $headers, $ch){
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_MAXREDIRS, (int)$numRedirects);
	curl_setopt($ch, CURLOPT_HEADER, true); 
	if ($numRedirects == "0") {
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); 
	}
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
function send_get($url, $numRedirects, $headers, $ch){
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_MAXREDIRS, (int)$numRedirects);
	curl_setopt($ch, CURLOPT_HEADER, true); 
	if ($numRedirects == "0") {
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); 
	}
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
	<title>Curl It</title>
	<script type="text/javascript">
		$(document).ready(function(){
			HTTP_Dropdown_Changed();
			$('select').formSelect();
			$('#selectHTTP').on('change', function(e) { HTTP_Dropdown_Changed();});
			$('#postInput').on('change', function(e) { PostInputChanged();});
		});
	</script>
</head>
<body style="display: flex; min-height: 100vh; flex-direction: column;">
	<div class="navbar-fixed">
		<nav class="blue lighten-2">
			<div class="nav-wrapper container">
				<a href="#" class="brand-logo">Curl it</a>
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<li><a href="https://github.com/James231/Curl-It" target="_blank">Curl It on GitHub</a></li>
				</ul>
			</div>
		</nav>
	</div>
	<br><br><br>
	<main style="flex: 1 0 auto;">
		<div class="container">
			<h3>Curl It</h3>
			<h5 class="light">A Free Open-Source HTTP (GET/POST) Request Testing tool.</h5>
		</div>
		<br><br>
		<div class="container">
			<form id="form" method="post" onsubmit="return ValidateForm();">
				<div class="row">
					<div class="input-field col s6">
						<select id="selectHTTP" name="method" form="form">
							<?php 
							if(isset($_POST['formsubmit'])) 
							{
								$requestMethod = "" . $_POST['method'];
								if ($requestMethod == "1") {
									echo("<option value=\"1\" selected>HTTP GET</option>
							<option value=\"2\">HTTP POST</option>");
								} else {
									echo("<option value=\"1\">HTTP GET</option>
							<option value=\"2\" selected>HTTP POST</option>");
								}
							} else {
								echo("<option value=\"1\" selected>HTTP GET</option>
							<option value=\"2\">HTTP POST</option>");
							}
							?>
						</select>
						<label>HTTP Method</label>
					</div>
					<div class="input-field col s6">
						<select form="form" name="redirects">
						<?php 
							if(isset($_POST['formsubmit'])) 
							{
								$numOfRedirects = "" . $_POST['redirects'];
								if ($numOfRedirects == "0") {
									echo("<option value=\"0\" selected>No Redirects</option>");
								} else {
									echo("<option value=\"0\">No Redirects</option>");
								}
								if ($numOfRedirects == "1") {
									echo("<option value=\"1\" selected>1 Redirect</option>");
								} else {
									echo("<option value=\"1\">1 Redirect</option>");
								}
								if ($numOfRedirects == "2") {
									echo("<option value=\"2\" selected>2 Redirects</option>");
								} else {
									echo("<option value=\"2\">2 Redirects</option>");
								}
								if ($numOfRedirects == "3") {
									echo("<option value=\"3\" selected>3 Redirects</option>");
								} else {
									echo("<option value=\"3\">3 Redirects</option>");
								}
							} else {
								echo("<option value=\"0\" selected>No Redirects</option>
							<option value=\"1\">1 Redirect</option>
							<option value=\"2\">2 Redirects</option>
							<option value=\"3\">3 Redirects</option>");
							}
						?>
						</select>
						<label>Max Num. of Redirects</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<label for="url">URL</label>
						<?php
							if(isset($_POST['formsubmit'])) {
								echo("<input placeholder=\"https://www.example.com\" id=\"url\" type=\"url\" name=\"url\" form=\"form\" value=\"" . $_POST['url'] . "\">");
							} else {
								echo("<input placeholder=\"https://www.example.com\" id=\"url\" type=\"url\" name=\"url\" form=\"form\">");
							}
						?>
					</div>
				</div>
				<h5>Headers:</h5>
				<div id="headers">
					<div class="row" style="margin-bottom: 0; display: none;">
						<div class="input-field col s4" style="margin-top: 0;">
							<input id="headerkey" type="text" name="headerkey" form="form">
							<label for="headerkey">Key</label>
						</div>
						<div class="input-field col s6" style="margin-top: 0;">
							<input id="headervalue" type="text" name="headervalue" form="form">
							<label for="headervalue">Value</label>
						</div>
						<div class="input-field col s2" style="margin-top: 0;">
							<a id="headerclose" class="waves-effect blue lighten-2 waves-light btn headerclose" onclick="RemoveHeader(this);"><i class="material-icons">close</i></a>
						</div>
					</div>
					<?php
						if(isset($_POST['formsubmit'])) {
							$headerCount = 0;
							while (isset($_POST['headerkey' . ($headerCount+1)])) {
								echo("<div id=\"header" . ($headerCount+1) . "\" class=\"row\" style=\"margin-bottom: 0;\">
						<div class=\"input-field col s4\" style=\"margin-top: 0;\">
							<input id=\"headerkey\" type=\"text\" name=\"headerkey" . ($headerCount+1) . "\" form=\"form\" value=\"" . $_POST['headerkey' . ($headerCount+1)] . "\">
							<label for=\"headerkey\">Key</label>
						</div>
						<div class=\"input-field col s6\" style=\"margin-top: 0;\">
							<input id=\"headervalue\" type=\"text\" name=\"headervalue" . ($headerCount+1) . "\" form=\"form\" value=\"" . $_POST['headervalue' . ($headerCount+1)] . "\">
							<label for=\"headervalue\">Value</label>
						</div>
						<div class=\"input-field col s2\" style=\"margin-top: 0;\">
							<a id=\"headerclose" . ($headerCount+1) . "\" class=\"waves-effect blue lighten-2 waves-light btn headerclose\" onclick=\"RemoveHeader(this);\"><i class=\"material-icons\">close</i></a>
						</div>
					</div>");
								$headerCount = $headerCount + 1;
							}
						}
					?>
				</div>
				<a class="waves-effect blue lighten-2 waves-light btn" onclick="AddHeader();">Add Header</a>
				<br><br><br>
				<div id="PostStuff" style="display: none;">
					<div class="row">
						<div class="input-field col s12 m6">
							<select id="postInput" name="postInput" form="form">
								<?php
								if(isset($_POST['formsubmit'])) {
									$postInput = "" . $_POST['postInput'];
									if ($postInput == "2") {
										echo("<option value=\"1\">Parameters</option>
								<option value=\"2\" selected>Raw Body</option>");
									} else {
										echo("<option value=\"1\" selected>Parameters</option>
								<option value=\"2\">Raw Body</option>");
									}
								} else {
									echo("<option value=\"1\" selected>Parameters</option>
								<option value=\"2\">Raw Body</option>");
								}
								?>
							</select>
							<label>Data Input Method</label>
						</div>
					</div>
					<?php
						if(isset($_POST['formsubmit'])) {
							$postInput = "" . $_POST['postInput'];
							if ($postInput == "2") {
								echo("<div id=\"rawPostBody\">");
							} else {
								echo("<div id=\"rawPostBody\" style=\"display: none;\">");
							}
						} else {
							echo("<div id=\"rawPostBody\" style=\"display: none;\">");
						}
					?>
						<h5>POST Body:</h5>
						<div class="row">
							<div class="input-field col s12">
								<label for="postbody">Post Body</label>
								<?php
									if(isset($_POST['formsubmit'])) {
										if (isset($_POST['postbody'])) {
											echo("<textarea class=\"materialize-textarea\" id=\"postbody\" type=\"text\" name=\"postbody\" form=\"form\">" . $_POST['postbody'] . "</textarea>");
										} else {
											echo("<textarea class=\"materialize-textarea\" id=\"postbody\" type=\"text\" name=\"postbody\" form=\"form\"></textarea>");
										}
									} else {
										echo("<textarea class=\"materialize-textarea\" id=\"postbody\" type=\"text\" name=\"postbody\" form=\"form\"></textarea>");
									}
								?>
							</div>
						</div>
					</div>
					<?php
						if(isset($_POST['formsubmit'])) {
							$postInput = "" . $_POST['postInput'];
							if ($postInput == "2") {
								echo("<div id=\"postParams\" style=\"display: none;\">");
							} else {
								echo("<div id=\"postParams\">");
							}
						} else {
							echo("<div id=\"postParams\">");
						}
					?>
						<h5>POST Parameters:</h5>
						<div id="parameters">
							<div class="row" style="margin-bottom: 0; display: none;">
								<div class="input-field col s4" style="margin-top: 0;">
									<input id="parameterkey" type="text" name="parameterkey" form="form">
									<label for="parameterkey">Key</label>
								</div>
								<div class="input-field col s6" style="margin-top: 0;">
									<input id="parametervalue" type="text" name="parametervalue" form="form">
									<label for="parametervalue">Value</label>
								</div>
								<div class="input-field col s2" style="margin-top: 0;">
									<a id="parameterclose" class="waves-effect blue lighten-2 waves-light btn parameterclose" onclick="RemoveParameter(this);"><i class="material-icons">close</i></a>
								</div>
							</div>
							<?php
							if(isset($_POST['formsubmit'])) {
								if(isset($_POST['formsubmit'])) {
									$paramCount = 0;
									while (isset($_POST['parameterkey' . ($paramCount+1)])) {
										echo("<div id=\"parameter" . ($paramCount+1) . "\" class=\"row\" style=\"margin-bottom: 0;\">
								<div class=\"input-field col s4\" style=\"margin-top: 0;\">
									<input id=\"parameterkey\" type=\"text\" name=\"parameterkey" . ($paramCount+1) . "\" form=\"form\" value=\"" . $_POST['parameterkey' . ($paramCount+1)] . "\">
									<label for=\"parameterkey\">Key</label>
								</div>
								<div class=\"input-field col s6\" style=\"margin-top: 0;\">
									<input id=\"parametervalue\" type=\"text\" name=\"parametervalue" . ($paramCount+1) . "\" form=\"form\" value=\"" . $_POST['parametervalue' . ($paramCount+1)] . "\">
									<label for=\"parametervalue\">Value</label>
								</div>
								<div class=\"input-field col s2\" style=\"margin-top: 0;\">
									<a id=\"parameterclose" . ($paramCount+1) . "\" class=\"waves-effect blue lighten-2 waves-light btn parameterclose\" onclick=\"RemoveParameter(this);\"><i class=\"material-icons\">close</i></a>
								</div>
							</div>");
										$paramCount = $paramCount + 1;
									}
								}
							}
							?>
						</div>
						<a class="waves-effect blue lighten-2 waves-light btn" onclick="AddParameter();" >Add Parameter</a>
					</div>
				</div><br><br><br><br>
				<div class="row" id="ErrorMessage" style="display: none;">
					<div class="col s12 ">
						<div class="card red">
							<div class="card-content white-text" style="padding-top: 10px; padding-bottom: 10px;">
								Please fill in the URL field and all header/parameter key fields.
							</div>
						</div>
					</div>
				</div>
				<br>
				<button class="waves-effect blue lighten-2 waves-light btn white-text" style="width: 100%" type="submit" name="formsubmit">Send</button>
			</form>
		</div>
		<br><br><br>
		<div class="container">
			<h3>Response:</h3>
			<h5 class="light">Header:</h5>
			<pre id="editor2" style="position: relative !important; border: 1px solid lightgray; margin: auto;height: 300px; width: 100%;"><?php
			$header_len = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$header = substr($resp, 0, $header_len);
			$body = substr($resp, $header_len);
			echo $header;
			?></pre>
			<div class="code" ace-mode="ace/mode/asciidoc" ace-theme="ace/theme/monokai" ace-gutter="true">
			</div>
			<br><br>
			<h5 class="light">Body:</h5>
			<pre id="editor" style="position: relative !important; border: 1px solid lightgray; margin: auto;height: 300px; width: 100%;"><?php
			echo htmlentities($body);
			?></pre>
			<div class="code" ace-mode="ace/mode/html" ace-theme="ace/theme/monokai" ace-gutter="true">
			</div>
		</div>
		<br><br>
	</main>
	<footer class="page-footer blue lighten-1">
		<div class="container">
		</div>
		<div class="footer-copyright">
			<div class="container">
				&copy; 2018 Jam-Es.com
			</div>
		</div>
	</footer>
<?php 
if(isset($_POST['formsubmit'])) {
	$headerCount = 0;
	while (isset($_POST['headerkey' . ($headerCount+1)])) {
		$headerCount = $headerCount + 1;
	}
	echo ("<script type=\"text/javascript\">
	function GetHeaderCount () {
		return " . $headerCount . ";
	}</script>");
} else {
	echo ("<script type=\"text/javascript\">
	function GetHeaderCount () {
		return 0;
	}
</script>");
}
if(isset($_POST['formsubmit'])) {
	$paramCount = 0;
	while (isset($_POST['parameterkey' . ($paramCount+1)])) {
		$paramCount = $paramCount + 1;
	}
	echo ("<script type=\"text/javascript\">
	function GetParameterCount () {
		return " . $paramCount . ";
	}</script>");
} else {
	echo ("<script type=\"text/javascript\">
	function GetParameterCount () {
		return 0;
	}
</script>");
}
?>
	<script type="text/javascript">
		var headerCount = GetHeaderCount();
		var paramCount = GetParameterCount();
		function HTTP_Dropdown_Changed () {
			if ($('#selectHTTP').val() == 1) {
				document.getElementById("PostStuff").style.display = "none";
			} else {
				document.getElementById("PostStuff").style.display = "block";
			}
		}
		function PostInputChanged () {
			if ($('#postInput').val() == 1) {
				document.getElementById("rawPostBody").style.display = "none";
				document.getElementById("postParams").style.display = "block";
			} else {
				document.getElementById("rawPostBody").style.display = "block";
				document.getElementById("postParams").style.display = "none";
			}
		}
		function AddHeader () {
			var itm = document.getElementById("headers").firstElementChild;
			var cln = itm.cloneNode(true);
			document.getElementById("headers").appendChild(cln);
			document.getElementById("headers").lastElementChild.style.display = "block";
			headerCount = headerCount + 1;
			document.getElementById("headers").lastElementChild.id = "header" + headerCount;
			document.getElementById("headers").lastElementChild.querySelector("#headerclose").id = "headerclose" + headerCount;
			document.getElementById("headers").lastElementChild.querySelector("#headerkey").name = "headerkey" + headerCount;
			document.getElementById("headers").lastElementChild.querySelector("#headervalue").name = "headervalue" + headerCount;
		}
		function RemoveHeader (e) {
			var headerNum = parseInt(e.id.substring(11));
			var element = document.getElementById("header" + headerNum);
			element.id = "deadheader";
			element.parentNode.removeChild(element);
			for (i = 1; i < headerCount+1; i++) {
    			if (i > headerNum) {
    				var bighead = document.getElementById("header" + i);
    				bighead.id = "header" + (i-1);
    				bighead.querySelector("#headerclose" + i).id = "headerclose" + (i-1);
    				bighead.querySelector("#headerkey").name = "headerkey" + (i-1);
    				bighead.querySelector("#headervalue").name = "headervalue" + (i-1);
    			}
			}
			headerCount = headerCount - 1;
		}
		function AddParameter () {
			var itm = document.getElementById("parameters").firstElementChild;
			var cln = itm.cloneNode(true);
			document.getElementById("parameters").appendChild(cln);
			document.getElementById("parameters").lastElementChild.style.display = "block";
			paramCount = paramCount + 1;
			document.getElementById("parameters").lastElementChild.id = "parameter" + paramCount;
			document.getElementById("parameters").lastElementChild.querySelector("#parameterclose").id = "parameterclose" + paramCount;
			document.getElementById("parameters").lastElementChild.querySelector("#parameterkey").name = "parameterkey" + paramCount;
			document.getElementById("parameters").lastElementChild.querySelector("#parametervalue").name = "parametervalue" + paramCount;
		}
		function RemoveParameter (e) {
			var paramNum = parseInt(e.id.substring(14));
			var element = document.getElementById("parameter" + paramNum);
			element.id = "deadparam";
			element.parentNode.removeChild(element);
			for (i = 1; i < paramCount+1; i++) {
				if (i > paramNum) {
					var bigparam = document.getElementById("parameter" + i);
					bigparam.id = "parameter" + (i-1);
					bigparam.querySelector("#parameterclose" + i).id = "parameterclose" + (i-1);
					bigparam.querySelector("#parameterkey").name = "parameterkey" + (i-1);
					bigparam.querySelector("#parametervalue").name = "parametervalue" + (i-1);
				}
			}
			paramCount = paramCount - 1;
		}
		function ValidateForm () {
			if (document.getElementById('url').value) {
				for (i = 1; i < headerCount+1; i++) {
					if (!document.getElementsByName("headerkey" + i)[0].value) {
						document.getElementById("ErrorMessage").style.display = "block";
						return false;
					}
				}
				if ("" + document.getElementById('postInput').value == "1") {
					for (i = 1; i < paramCount+1; i++) {
						if (!document.getElementsByName("parameterkey" + i)[0].value) {
							document.getElementById("ErrorMessage").style.display = "block";
							return false;
						}
					}
				}
			} else {
				document.getElementById("ErrorMessage").style.display = "block";
				return false;
			}
			document.getElementById("ErrorMessage").style.display = "none";
			return true;
		}
	</script>
	<script src="src-min/ace.js"></script>
	<script src="src-min/ext-themelist.js"></script>
	<script>
		var editor = ace.edit("editor");
		editor.setTheme("ace/theme/monokai");
		editor.session.setMode("ace/mode/html");
		editor.renderer.setScrollMargin(10, 10);
		editor.setOptions({
			autoScrollEditorIntoView: true
		});
		editor.getSession().setUseWrapMode(true);
		editor.setFontSize(18);
		editor.setReadOnly(true);
		editor.setShowPrintMargin(false);
		var editor2 = ace.edit("editor2");
		editor2.setTheme("ace/theme/monokai");
		editor2.session.setMode("ace/mode/asciidoc");
		editor2.renderer.setScrollMargin(10, 10);
		editor2.setOptions({
			autoScrollEditorIntoView: true
		});
		editor2.getSession().setUseWrapMode(true);
		editor2.setFontSize(18);
		editor2.setReadOnly(true);
		editor2.setShowPrintMargin(false);
		var count = 1;
		function add() {
			var oldEl = editor.container
			var pad = document.createElement("div")
			pad.style.padding = "40px"
			oldEl.parentNode.insertBefore(pad, oldEl.nextSibling)
			var el = document.createElement("div")
			oldEl.parentNode.insertBefore(el, pad.nextSibling)
			count++
			var theme = themes[Math.floor(themes.length * Math.random() - 1e-5)]
			editor = ace.edit(el)
			editor.setOptions({
				mode: "ace/mode/javascript",
				theme: theme,
				autoScrollEditorIntoView: true
			})
			editor.setValue([
				"this is editor number: ", count, "\n",
				"using theme \"", theme, "\"\n",
				":)"
				].join(""), -1)
			scroll()
		}
		function scroll(speed) {
			var top = editor.container.getBoundingClientRect().top
			speed = speed || 10
			if (top > 60 && speed < 500) {
				if (speed > top - speed - 50)
					speed = top - speed - 50
				else
					setTimeout(scroll, 10, speed + 10)
				window.scrollBy(0, speed)
			}
		}
		var themes = require("ace/ext/themelist").themes.map(function(t){return t.theme});
		window.add = add;
		window.scroll = scroll;
	</script>
</body>
</html>
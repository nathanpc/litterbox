<?php
/**
 * index.php
 * Website's homepage and upload handler.
 *
 * @author Nathan Campos <nathan@innoveworkshop.com>
 */

require_once __DIR__ . '/upload.php';

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Litter Box</title>

	<!-- Styling for browser that support it. -->
	<style type="text/css">
		body {
			margin-top: 10px;
			margin-bottom: 10px;
		}

		#content {
			margin: 0 auto;
		}

		.black-row {
			background-color: black;
			color: white;
		}

		.black-row td {
			padding-top: 1px;
			padding-bottom: 1px;
			padding-left: 10px;
			padding-right: 10px;
		}

		.black-row a {
			text-decoration: none;
			color: white;
        }

		.black-row a:hover, .black-row a:active {
			text-decoration: underline;
        }

		.black-row a:visited {
			color: white;
        }

		#title {
			margin-top: 0;
			margin-bottom: 10px;
		}

		#desc {
			text-align: justify;
		}

		#file {
			margin-bottom: 5px;
		}

		#otp {
			margin-right: 20px;
		}

		input {
			padding-top: 5px;
			padding-bottom: 5px;
			padding-left: 10px;
			padding-right: 10px;
			height: auto;
			border: dashed 2px #858585;

			background-color: white;
			color: black;

			text-align: center;
		}

		input[type="submit"] {
			padding-left: 20px;
			padding-right: 20px;
			border: dashed 2px black;
		}

		input[type="submit"]:hover {
			background-color: black;
			color: white;
		}

		input[type="submit"]:active {
			border-color: white;
			background-color: black;
			color: white;
		}
	</style>
</head>
<body style="font-family: 'Courier New', monospace;">
	<table id="content" width="600" cellpadding="10" cellspacing="0">
		<tbody>
			<!-- Header row. -->
			<tr class="black-row">
				<td>
					<a href="/">Home</a> |
					<a href="/u/">File Listing</a>
				</td>

				<td align="right">
					<a href="https://github.com/nathanpc/litterbox">Source Code</a> |
					<a href="http://nathancampos.me/">Author</a>
				</td>
			</tr>

			<tr>
				<td colspan="2"></td>
			</tr>

			<!-- Content row. -->
			<tr>
				<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
					<td colspan="2">
						<?php handle_upload($_FILES['file'],
							$_POST['otp'] ?? $_GET['otp'] ?? ''); ?>
					</td>
				<?php } else { ?>
				<td width="300">
					<!-- Project information -->
					<table>
						<tbody>
							<tr>
								<td>
									<center>
										<h1 id="title">Litter Box</h1>
									</center>
								</td>
							</tr>
							<tr>
								<td id="desc">
									A simple solution to upload and share files
									extremely quickly with strangers on the
									internet.
								</td>
							</tr>
						</tbody>
					</table>
				</td>

				<td width="300">
					<!-- File upload form. -->
					<form  method="POST" enctype="multipart/form-data" action="/">
						<center>
							<input type="file" name="file" id="file" size="25">
							<br>
							<label for="otp">OTP: </label>
							<input type="text" name="otp" id="otp" size="6">
							<input type="submit">
						</center>
					</form>
				</td>
				<?php } ?>
			</tr>

			<tr>
				<td colspan="2"></td>
			</tr>

			<!-- Copyright row. -->
			<tr class="black-row">
				<td colspan="2">
					<center>
						Nathan Campos &#169; 2024-<?= date('Y') ?>
					</center>
				</td>
			</tr>
		</tbody>
	</table>
</body>
</html>

<?php
/**
 * upload.php
 * Handles everything related to the upload of files.
 *
 * @author Nathan Campos <nathan@innoveworkshop.com>
 */

require_once __DIR__ . '/totp.php';

/**
 * Directory where all uploaded files will be stored.
 */
const UPLOAD_DIR = __DIR__ . '/u';

/**
 * Performs all the necessary checks for a successful upload.
 *
 * @param array $file Uploaded file associative array (from $_FILES).
 *
 * @return bool True if all checks passed.
 */
function upload_sanity_checks(array $file): bool {
	// Check if we are at least getting a POST.
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		http_response_code(400);
		echo '<b>Error:</b> Invalid request method for upload.';
		return false;
	}

	// Check if an error occurred during the upload.
	if ($file['error'] != UPLOAD_ERR_OK) {
		http_response_code(500);
		echo '<b>Error:</b> ';
		echo match ($file['error']) {
			UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the ' .
				'upload_max_filesize directive in php.ini',
			UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the ' .
				'MAX_FILE_SIZE directive that was specified in the HTML form',
			UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially ' .
				'uploaded',
			UPLOAD_ERR_NO_FILE => 'No file was uploaded',
			UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
			UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
			UPLOAD_ERR_EXTENSION => 'File upload stopped by extension',
			default => 'Unknown upload error code',
		};
		return false;
	}

	// Minimum default check if the file was actually uploaded.
	if (!is_uploaded_file($file['tmp_name'])) {
		http_response_code(400);
		echo '<b>Error:</b> File upload inconsistency detected.';
		return false;
	}

	// Get the file size and perform some basic checks.
	$fsize = filesize($file['tmp_name']);
	if ($fsize === 0) {
		http_response_code(400);
		echo '<b>Error:</b> You tried uploading an empty file.';
		return false;
	} else if ($fsize > (int)ini_get('upload_max_filesize')) {
		http_response_code(400);
		echo "<b>Error:</b> File too big ($fsize bytes). Ensure it is below " .
			ini_get('upload_max_filesize') . ' bytes.';
		return false;
	}

	return true;
}

/**
 * Generates a new file name for the uploaded file in case it conflicts with an
 * existing file that was uploaded in the past.
 *
 * @param string $fn Uploaded file name.
 *
 * @return string File name to be used for the uploaded file to be stored in the
 *                uploads folder.
 */
function generate_fname(string $fn): string {
	$fname = $fn;
	$num = 1;

	// Check if the file already exists and generate a new one.
	while (file_exists(UPLOAD_DIR . '/' . $fname)) {
		$fname = "$num-{$fn}";
		$num++;
	}

	return $fname;
}

/**
 * Handles the upload of a file.
 *
 * @warning This function automatically prints the output for the user.
 *
 * @param array  $file Uploaded file associative array (from $_FILES).
 * @param string $otp  One time password for authentication.
 */
function handle_upload(array $file, string $otp): void {
	// Check if TOTP is valid.
	if (OTP\get_token() !== $otp) {
		http_response_code(401);
		echo 'The provided OTP token is not valid.';
		return;
	}

	// Perform upload sanity checks.
	if (!upload_sanity_checks($file))
		return;

	// Get the new file name, and move file to the appropriate location.
	$fname = generate_fname($file['name']);
	move_uploaded_file($file['tmp_name'], UPLOAD_DIR . '/' . $fname);

	// Print the success message.
	echo 'The file has been successfully uploaded and is available as <a ' .
		"href=\"/u/$fname\">$fname</a>.";
}

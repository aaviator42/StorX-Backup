<?php
// StorX DB File Backup Script
// by aaviator42
// 2024-05-17, v0.1

// Path to StorX library 
require 'lib/StorX.php';

// The db file to backup
$filename = 'db/example.db';

// The directory to backup files to
$backupDir = 'backups/';

// Generate the backup file
backupFile($filename, $backupDir);


//-----------------------------------------------

// Custom error handler to convert errors to exceptions
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}

// Set the custom error handler
set_error_handler("customErrorHandler");

function backupFile($filename, $backupDir){

	try {
		// StorX handler for the file to be backed up
		$currentFile = new \StorX\Sx;
		
		// Read all the keys into $allKeys and close handler
		$currentFile->openFile($filename, false);
		$allKeys;
		$currentFile->readAllKeys($allKeys);
		$currentFile->closeFile();
		
		// Generate timestamped filename for the backup file
		$newFilename  = $backupDir . '/' . date("Y-m-d--H-i-s_") . pathinfo(realpath($filename))['filename'] . ".db";
		
		// Ensure backup folder exists
		if(!is_dir($backupDir)) {
			mkdir($backupDir, 0777, true);
		}
		
		// StorX handler for the backup file
		$newFile = new \StorX\Sx;
		
		// Create the backup file
		$newFile->createFile($newFilename);
		
		// Open the backup file
		$newFile->openFile($newFilename, true);
		
		// Write all the keys in $allKeys to the backup file and close handler
		$newFile->modifyMultipleKeys($allKeys);
		$newFile->closeFile($allKeys);
		
		echo "OK";
		
	} catch (Exception $e) {
		// Log the error to the configured php log file
		error_log($e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
		
		echo "ERROR";
		
		// Immediately exit the script
		exit(1);
	}
}

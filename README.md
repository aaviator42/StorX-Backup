# StorX-Backup
A simple PHP script to create a backup of a StorX DB file.  

`v0.1`: `2024-05-17`  
License: `AGPLv3`  

* Simply configure `$filename` and `$backupDir` at the top of the script now every time the script is run it'll create a timestamped 'snapshot' of `$filename` in `$backupDir`.  
* Suitable to be run as a cron job.
* Can easily be extended to backup multiple files, simply call the `backupFile($filename, $fileDir)` function for each file.  
* Errors are logged to the standard configured `error_log` file. 
* Backup filename format: `example.db` becomes `2024-12-31--24-59-59_example.db`.


-----

Documentation updated: `2024-05-17`.

This script enables you to copy the structure and content of databases back and
 forth between remote and local databases. Remote databases are accessed through
 SSH tunnels.

 This script operates in two modes. The mode is passed in the first parameter
 -- put: Copy a local database to a remote server
 -- get: Copy a remote database to a local server

 When using a config.ini file to specify your database credentials the format is:

 [remote]
 ssh      = user@server.com
 username = remoteDbUsername
 password = remoteDbPassword
 database = remoteDbName

 [local]
 username = localDbUsername
 password = localDbPassword
 database = localDbName


 Example usage: Replace your local database with a remote database
 dbsync.php get

 Example usage: Replace a remote database with your local database
 dbsync.php put

 Example usage using extrenal config file: Replace a remote database with your local database
 dbsync.php put path/to/config.ini

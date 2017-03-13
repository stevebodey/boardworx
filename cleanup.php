<?php
/* Clean up script for Magento sites hosted in a Plesk environment.
  
  Adapted from :
http://www.magentocommerce.com/wiki/groups/227/maintenance_script
  
  Changes :
  Added configuration values (domain, subdirectory, cronOnly)
  Tests for the existence of local.xml before running either command (tests
path and tests existence of db details)
  Removed the exec command in favour of a recursive PHP function to delete
directory contents (much better!)
  Added a security setting that stops the script being run unless by
cron/shell_user of the site.
  Removed some of the directory entries (specifically var/cache and var/log
(the former shouldnt' be emptied frequently and the latter should be managed
within System ---------------> Configuration -> Developer)
  */
  
//Edit the next three lines :
$domain = "board-worx.com"; //Put your domain in here as it looks in Plesk (ie no www.)
$subdirectory = ""; //If your site is in asubdirectory put the subdirectory here otherwise leave empty
$cronOnly = false; //Set to false for testing, or if inexplicably you get thesecurity notice when running as a cron.
 
//Do not edit below this line :
if ($cronOnly)
{
    $dnsArray = dns_get_record($domain,DNS_A);
    $inboundIP = $dnsArray[0]['ip'];
    $callingIP = $_SERVER['REMOTE_ADDR'];
    if ($inboundIP != $_SERVER['REMOTE_ADDR'])
    {
        die("For security this script can only be called via a cron from the
same server as its hosted.  Your IP : $callingIP . Required IP : $inboundIP
");
    }
}
 
$path = "/var/www/vhosts/".$domain."/httpdocs/".$subdirectory;
$localXML = "/app/etc/local.xml";
 
//Check that the path is correct and accessible
 
if (!file_exists($path.$localXML))
{
    echo "I have path : ".$path." but I cannot find Magento here";
    echo "One of the following is incorrect :";
    echo "Domain : ".$domain."";
    echo "Subdirectory : ".$subdirectory."";
    die();
}
 
$xml = simplexml_load_file($path.$localXML, NULL, LIBXML_NOCDATA);
 
$db['host'] = $xml->global->resources->default_setup->connection->host;
$db['name'] = $xml->global->resources->default_setup->connection->dbname;
$db['user'] = $xml->global->resources->default_setup->connection->username;
$db['pass'] = $xml->global->resources->default_setup->connection->password;
$db['pref'] = $xml->global->resources->db->table_prefix;
 
if($_GET['clean'] == 'log') clean_log_tables();
if($_GET['clean'] == 'var') clean_var_directory();
 
function clean_log_tables() {
    global $db;
     
    $tables = array(
        'dataflow_batch_export',   //
        'dataflow_batch_import',
        'log_customer',
        'log_quote',
        'log_summary',
        'log_summary_type',
        'log_url',
        'log_url_info',
        'log_visitor',
        'log_visitor_info',
        'log_visitor_online',
        'report_event'
    );
     
    mysql_connect($db['host'], $db['user'], $db['pass']) or
die(mysql_error());
    mysql_select_db($db['name']) or die(mysql_error());
     
    foreach($tables as $v => $k) {
        mysql_query('TRUNCATE `'.$db['pref'].$k.'`') or die(mysql_error());
    }
}
 
function clean_var_directory() {
 
    global $path;
 
    $dirs = array(
        'downloader/pearlib/cache/',  //Cached files relating to the MagentoConnect process
        'downloader/pearlib/download/', //Downloaded copies of installedMagento modules and extensions
        'var/report/', //Copies of Magento error reports
        'var/session/', //Cart sessions
        'var/tmp/' //Used in old version of Magento (I think)
    );
     
    foreach($dirs as $v => $k) {
       destroy_contents($path.$k);
    }
}
 
 
function destroy_contents($dir) {
   $mydir = opendir($dir);
   if ($mydir == false)
        return;
   while(false !== ($file = readdir($mydir))) {
 
    if($file != "." && $file != "..") {
          chmod($dir.$file, 0777);
          if(is_dir($dir.$file)) {
                chdir('.');
                destroy_contents($dir.$file.'/');
                 if(!rmdir($dir.$file))
                     echo "Could not delete $dir/$file";
            }
            else
                  if(!unlink($dir.$file))
                      echo "Could not delete $dir/$file";
            }
      }
      closedir($mydir);
}
?>
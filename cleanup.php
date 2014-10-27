<?php
/*
 *
 * NOTICE OF LICENSE
 *
 * There is no license at all. Free to use.
 * Credit to Boson @ bosonhuang.com
 *
 *
 * USAGE
 *
 * This script cleans up Magento Database log files or temp files in var folders.
 * 
 * 1. Put this file to root of your Magento installation folder.
 * 2. Type in URL http://www.example.com/cleanup.php?clean=log
 *    OR: Type in URL http://www.example.com/cleanup.php?clean=var
 * 3. DO NOT CHANGE OR MODIFY OTHER CODES.
 * 
 */

/** Mage locations **/
$mageconf = 'app/etc/local.xml';  // Mage local.xml config
$xml = simplexml_load_file('app/etc/local.xml', NULL, LIBXML_NOCDATA);

// get Magento database details
if(file_exists($mageconf)) {
  $xml = simplexml_load_file($mageconf, NULL, LIBXML_NOCDATA);

  $db['host'] = $xml->global->resources->default_setup->connection->host;
  $db['name'] = $xml->global->resources->default_setup->connection->dbname;
  $db['user'] = $xml->global->resources->default_setup->connection->username;
  $db['pass'] = $xml->global->resources->default_setup->connection->password;
  $db['pref'] = $xml->global->resources->db->table_prefix;
} else
  exit('Failed to open ' . $mageconf);

umask(0);

$cleanAction = htmlspecialchars($_GET['clean']);
if($cleanAction == 'log') clean_log_tables();
if($cleanAction == 'var') clean_var_directory();

/*
 * Clean Log Tables
 *
 * @throws database connection error
 */
function clean_log_tables() {
  global $db;
  
  // tables to be clean up
  $tables = array(
    'dataflow_batch_export',
    'dataflow_batch_import',
    'log_customer',
    'log_visitor',
    'log_visitor_info',
    'log_url',
    'log_url_info',
    'log_summary',
    'log_summary_type',
    'log_quote',
    'log_visitor_online',
    'report_event'
  );
  
  mysql_connect($db['host'], $db['user'], $db['pass']) or die(mysql_error());
  mysql_select_db($db['name']) or die(mysql_error());
  
  echo '<p>Start to clean database...</p>';
  
  foreach($tables as $v => $k) {
    echo '<p>Cleaning table ' . $db['pref'] . $k . '..........';
    
    mysql_query('TRUNCATE `'.$db['pref'].$k.'`') or die(mysql_error());
    
    echo 'done!</p>';
  }
}

/*
 * Clean var folder
 *
 * @throws database connection error
 */
function clean_var_directory() {

  // folders to be clean up
  $dirs = array(
    'downloader/pearlib/cache/*',
    'downloader/pearlib/download/*',
    'var/cache/*',
    'var/log/*',
    'var/report/*',
    /* 'var/session/*', */
    'var/tmp/*'
  );
  
  foreach($dirs as $v => $k) {
    
    // execute to remove all files
    exec('rm -rf '.$k);
  }
}

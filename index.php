<?php require_once('Connections/repositorydb.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$maxRows_fwrepository = 10;
$pageNum_fwrepository = 0;
if (isset($_GET['pageNum_fwrepository'])) {
  $pageNum_fwrepository = $_GET['pageNum_fwrepository'];
}
$startRow_fwrepository = $pageNum_fwrepository * $maxRows_fwrepository;

$fieldname_fwrepository = "-1";
if (isset($_GET['Field'])) {
  $fieldname_fwrepository = $_GET['Field'];
}
$searchvalue_fwrepository = "-1";
if (isset($_GET['Search'])) {
  $searchvalue_fwrepository = $_GET['Search'];
}
mysql_select_db($database_repositorydb, $repositorydb);
$query_fwrepository = "SELECT * FROM Drive_Manufacturer, Operating_System, System_Manufacturer, Repository WHERE Repository.Drive_ID = Drive_Manufacturer.Drive_ID AND Repository.System_ID = Operating_System.System_ID AND Repository.Manufacturer_ID = System_Manufacturer.Manufacturer_ID AND $fieldname_fwrepository LIKE '%$searchvalue_fwrepository%'";
$query_limit_fwrepository = sprintf("%s LIMIT %d, %d", $query_fwrepository, $startRow_fwrepository, $maxRows_fwrepository);
$fwrepository = mysql_query($query_limit_fwrepository, $repositorydb) or die(mysql_error());
$row_fwrepository = mysql_fetch_assoc($fwrepository);

if (isset($_GET['totalRows_fwrepository'])) {
  $totalRows_fwrepository = $_GET['totalRows_fwrepository'];
} else {
  $all_fwrepository = mysql_query($query_fwrepository);
  $totalRows_fwrepository = mysql_num_rows($all_fwrepository);
}
$totalPages_fwrepository = ceil($totalRows_fwrepository/$maxRows_fwrepository)-1;
?>
<?php 
// Include the header:
require('templates/header.html');
// Leave the PHP section to display the HTML:
?>
  <div class="content">
    <h1>Welcome to the Rackspace Approved Driver and Firmware Repository!</h1>
    <p>This initial release only targets Dell branded servers.</p>
  </div>
    <div id="downloadarea">
  <div class="linuxsvr">
    <h2>Linux Servers</h2>
 <p>Client Side Script<br />
     Part 1 of 1</p>
      <div class="button"><a href="http://drivers.mirror.rackspace.com/Linux_Client-Side_Scripts/setup.sh">Download Now</a></div> 
</div>
      <div class="wnd1">
    <h2>Windows Servers</h2>
    <p>Client Side Script<br />
     Part 1 of 2</p>
      <div class="button"><a href="http://drivers.mirror.rackspace.com/Windows_Client-Side_Scripts/downloadFiles.vbs">Download Now</a></div>
     </div> 
  <div class="wnd2">
    <h2>Windows Servers</h2>
    <p>Client Side Script<br />
  Part 2 of 2</p>
      <div class="button"><a href="http://drivers.mirror.rackspace.com/Windows_Client-Side_Scripts/setup.vbs">Download Now</a></div> 
</div> 
      <div class="subcontent">
       <p>For instructions on how these scripts are used and other errata pertaining to this repository, please review the documentation.</p>
      <p>Driver and Firmware Repository:<a href="http://drivers.mirror.rackspace.com/Documentation/Driver and Firmware Repository Manual.docx"> Manual</a> | <a href="http://drivers.mirror.rackspace.com/Documentation/Driver and Firmware Repository Overview.pptx"> Overview</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Visual Guide Portrait Overview:<a href="http://drivers.mirror.rackspace.com/Documentation/Visual Guide - Portrait Condensed Overview.docx"> Word Document</a> | <a href="http://drivers.mirror.rackspace.com/Documentation/Visual Guide - Portrait Condensed Overview.pdf">	PDF</a></p></div>
      <div class="dbtable">
    <h2>Hard Drive Firmware Updates</h2>
    <div class="searchform">
    <form action="index.php" method="get">
      <label for="Search">Search for:</label>
      <input type="text" name="Search" id="Search" size="32" />
in      
<label>
        <select name="Field" id="Field">
          <option value="System_Name">Operating System</option>
          <option value="Manufacturer_Name">System Manufacturer</option>
          <option value="Drive_Name">Drive Manufacturer</option>
          <option value="Drive_Model_Name">Drive Model</option>
        </select>
      </label>
      <input type="submit" name="button" id="button" value="Search" />
    </form>
    </div>
<table>
  <tr>
    <td width="221">System Manufacturer</td>
    <td width="184">Operating System</td>
    <td width="173">Drive Manufacturer</td>
    <td width="221">Drive Model</td>
    <td width="175">Drive Speed</td>
    <td width="161">Drive Size</td>
    <td width="253">Firmware Version</td>
    <td width="167">SAS Speed</td>
    <td width="251">Firmware Update</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_fwrepository['Manufacturer_Name']; ?></td>
      <td><?php echo $row_fwrepository['System_Name']; ?></td>
      <td><?php echo $row_fwrepository['Drive_Name']; ?></td>
      <td><?php echo $row_fwrepository['Drive_Model']; ?></td>
      <td><?php echo $row_fwrepository['Drive_Speed']; ?></td>
      <td><?php echo $row_fwrepository['Drive_Size']; ?></td>
      <td><?php echo $row_fwrepository['Firmware_Version']; ?></td>
      <td><?php echo $row_fwrepository['SAS_Speed']; ?></td>
      <td><?php echo $row_fwrepository['Firmware_Update']; ?></td>   
    </tr>
    <?php } while ($row_fwrepository = mysql_fetch_assoc($fwrepository)); ?>
</table>
<table>
  <tr>
    <td><?php if ($pageNum_fwrepository > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_fwrepository=%d%s", $currentPage, 0, $queryString_fwrepository); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_fwrepository > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_fwrepository=%d%s", $currentPage, max(0, $pageNum_fwrepository - 1), $queryString_fwrepository); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_fwrepository < $totalPages_fwrepository) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_fwrepository=%d%s", $currentPage, min($totalPages_fwrepository, $pageNum_fwrepository + 1), $queryString_fwrepository); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_fwrepository < $totalPages_fwrepository) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_fwrepository=%d%s", $currentPage, $totalPages_fwrepository, $queryString_fwrepository); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>


Records <?php echo ($startRow_fwrepository + 1) ?> to <?php echo min($startRow_fwrepository + $maxRows_fwrepository, $totalRows_fwrepository) ?> of <?php echo $totalRows_fwrepository ?>

<div class="login"><a href="login.php">Employee Admin</a></div>
</div>
<?php 
// Include the footer:
require('templates/footer.html');
// Leave the PHP section to display the HTML:
?>
<?php
mysql_free_result($fwrepository);
?>

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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_repositoryrs = 10;
$pageNum_repositoryrs = 0;
if (isset($_GET['pageNum_repositoryrs'])) {
  $pageNum_repositoryrs = $_GET['pageNum_repositoryrs'];
}
$startRow_repositoryrs = $pageNum_repositoryrs * $maxRows_repositoryrs;

mysql_select_db($database_repositorydb, $repositorydb);
$query_repositoryrs = "SELECT * FROM Repository";
$query_limit_repositoryrs = sprintf("%s LIMIT %d, %d", $query_repositoryrs, $startRow_repositoryrs, $maxRows_repositoryrs);
$repositoryrs = mysql_query($query_limit_repositoryrs, $repositorydb) or die(mysql_error());
$row_repositoryrs = mysql_fetch_assoc($repositoryrs);

if (isset($_GET['totalRows_repositoryrs'])) {
  $totalRows_repositoryrs = $_GET['totalRows_repositoryrs'];
} else {
  $all_repositoryrs = mysql_query($query_repositoryrs);
  $totalRows_repositoryrs = mysql_num_rows($all_repositoryrs);
}
$totalPages_repositoryrs = ceil($totalRows_repositoryrs/$maxRows_repositoryrs)-1;

$queryString_repositoryrs = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_repositoryrs") == false && 
        stristr($param, "totalRows_repositoryrs") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_repositoryrs = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_repositoryrs = sprintf("&totalRows_repositoryrs=%d%s", $totalRows_repositoryrs, $queryString_repositoryrs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table border="1" align="center">
  <tr>
    <td>Manufacturer_ID</td>
    <td>System_ID</td>
    <td>Drive_ID</td>
    <td>Drive_Model</td>
    <td>Drive_Speed</td>
    <td>Drive_Size</td>
    <td>Firmware_Version</td>
    <td>SAS_Speed</td>
    <td>Firmware_Update</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="detail.php?recordID=<?php echo $row_repositoryrs['Repository_ID']; ?>"> <?php echo $row_repositoryrs['Manufacturer_ID']; ?>&nbsp; </a></td>
      <td><?php echo $row_repositoryrs['System_ID']; ?>&nbsp; </td>
      <td><?php echo $row_repositoryrs['Drive_ID']; ?>&nbsp; </td>
      <td><?php echo $row_repositoryrs['Drive_Model']; ?>&nbsp; </td>
      <td><?php echo $row_repositoryrs['Drive_Speed']; ?>&nbsp; </td>
      <td><?php echo $row_repositoryrs['Drive_Size']; ?>&nbsp; </td>
      <td><?php echo $row_repositoryrs['Firmware_Version']; ?>&nbsp; </td>
      <td><?php echo $row_repositoryrs['SAS_Speed']; ?>&nbsp; </td>
      <td><?php echo $row_repositoryrs['Firmware_Update']; ?>&nbsp; </td>
    </tr>
    <?php } while ($row_repositoryrs = mysql_fetch_assoc($repositoryrs)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_repositoryrs > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_repositoryrs=%d%s", $currentPage, 0, $queryString_repositoryrs); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_repositoryrs > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_repositoryrs=%d%s", $currentPage, max(0, $pageNum_repositoryrs - 1), $queryString_repositoryrs); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_repositoryrs < $totalPages_repositoryrs) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_repositoryrs=%d%s", $currentPage, min($totalPages_repositoryrs, $pageNum_repositoryrs + 1), $queryString_repositoryrs); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_repositoryrs < $totalPages_repositoryrs) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_repositoryrs=%d%s", $currentPage, $totalPages_repositoryrs, $queryString_repositoryrs); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_repositoryrs + 1) ?> to <?php echo min($startRow_repositoryrs + $maxRows_repositoryrs, $totalRows_repositoryrs) ?> of <?php echo $totalRows_repositoryrs ?>
</body>
</html>
<?php
mysql_free_result($repositoryrs);
?>

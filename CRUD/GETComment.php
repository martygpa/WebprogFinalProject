<?php
/*
 * This PHP is used to redirect the HTTP GET requests
 * depending on if an ID parameter is passed in or not.
 * If the ID is passed in then the Item with that ID
 * is retrieved. If the q parameter is passed in for
 * the live search then it goes through each row
 * searching, Otherwise all items are retrieved.
 * @author Darnell R. Martin
 * @date 12/1/2016
 */
require_once('../Gateways/CommentGateway.php');
$gateway = new CommentGateway();
if(!empty($_GET["ItemIDAvg"]))
{
	$data = $gateway->rowDataQueryByItemID($_GET["ItemIDAvg"]);
	$avgRating;
	$count = 0;
	foreach ($data as $row)
	{
		$count++;
		$avgRating->Rating += $row->Rating;
	}
	$avgRating->Rating = $avgRating->Rating/$count;
	echo(json_encode($avgRating));
}
elseif(!empty($_GET["q"]))
{
	$q=$_GET["q"];
	$array = $gateway->tableDataQuery();
	if (strlen($q)>0)
	{
	  for($i=0;$i<sizeof($array); $i++)
	  {
	    if (stristr($array[$i]->Name,$q))
	    {
	      $response[] = $array[$i];
	    }
	  }
	}
	else
	{
	  $response->Name = "no suggestion";
	}
	echo json_encode($response);
}
else
{
	$data = $gateway->tableDataQuery();
	echo(json_encode($data));
}
?>

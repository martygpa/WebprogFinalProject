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
else if(!empty($_GET["ItemID"]))
{
	$data = $gateway->rowDataQueryByItemID($_GET["ItemID"]);
	echo(json_encode($data));
}
else if(!empty($_GET["JoinID"]))
{
	$data = $gateway->rowDataQueryByJoinID($_GET["JoinID"]);
	echo(json_encode($data));
}
else
{
	$data = $gateway->tableDataQuery();
	echo(json_encode($data));
}
?>

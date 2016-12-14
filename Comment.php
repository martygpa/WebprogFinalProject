<?php
session_start();
?>
<html>
<title>Add Comment</title>
<style>
body{width: 85%; height: 95%; background-color: #e6e6e6;float: left;text-decoration: none; color: black;}
</style>
<body>
  <div><b>Comment:<b></div>
  <textarea id="comment" rows="4" cols="50"></textarea><br>
  <label for="rating"><b>Rating: <b></label>
  <input id="rating" type ="range" min ="0.0" max="5.0" step ="0.5" oninput="update(value)"/><br>
  <div id="itemrating"></div>
  <div id="operations">
    <button id="complete" onclick="addComment()">Complete</button>
  </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script>
var ItemID = <?php echo($_GET["ID"]);?>;
var UserID = <?php echo($_SESSION["ID"]);?>;
function addRatingStars(numberOfStars) {
  var i = parseInt(numberOfStars, 10);
  element = document.getElementById('itemrating');
  element.innerHTML = '<b>Rating: </b>';
  while(i>0)
  {
    oImg=document.createElement('img');
    oImg.setAttribute('src', './images/ratings/fullstar.png');
    oImg.setAttribute('height', '5%');
    oImg.setAttribute('width', '3%');
    element.appendChild(oImg);
    i = i-1;
  }
  if(numberOfStars % 1 >= .5)
  {
    oImg=document.createElement('img');
    oImg.setAttribute('src', './images/ratings/halfstar.png');
    oImg.setAttribute('height', '5%');
    oImg.setAttribute('width', '3%');
    element.appendChild(oImg);
  }
}
function update(count)
{
  addRatingStars(count);
}

function addComment()
{
  var rating= document.getElementById('rating').value;
  var comment = document.getElementById('comment').value;
  $.post( "./CRUD/POSTComment.php", { ItemID: ItemID, UserID: UserID, Rating: rating, Comment: comment } );
  window.close();
}
addRatingStars(2.5);
</script>
</html>

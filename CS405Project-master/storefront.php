<!DOCTYPE html> <html> <head> <script 
src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
<title>Shop</title> 
<link rel="stylesheet" href="styles.css"> 
<style> .button{
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>	cursor: pointer;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<div class="main">
<?php
include('header.php'); 
new headerBar("Storefront","customer");
?>
<body>

<div class="search-container">
      <input type="text" class="textbox" placeholder="Search.." name="search" id="searchBox">
      <button id="buttonSearchBox"><i class="fa fa-search"></i></button>
  </div>
<br>

<label>Sort By: <select class="select" id="sort">
<option value="name asc">Name: A-Z</option>
<option value="name desc">Name: Z-A</option>
<option value="price asc">Price: Asc</option>
<option value="price desc">Price: Desc</option>
</select></label>

<label class="pad" >Show: <select class="select" id="filterID">
<option value="All">All</option>
<option value="Toy">Only Toys</option>
<option value="Book">Only Books</option>
</select></label>
<br><br>

<div class="storefront">
</div>

<script>
var sort = "Name asc";
var filterType = "All";
var searchInput = "";
$(document).ready(function(){
    buildTable();
    function buildTable(){
        $.ajax({
            url:"buildStorefront.php",
            method:"POST",
            data:{sort:sort, filterType:filterType, searchInput:searchInput},
            success:function(data){
	     $('.storefront').html(data);
            }
        });
    }

$("#buttonSearchBox").click(function(){
	searchSubmit();
});

$("#searchBox").keypress(function(){
  	if ( event.which == 13 ) {
    	    searchSubmit();
        }
});
	
function searchSubmit(){
   	searchInput = document.getElementById("searchBox").value;
	buildTable();
}
	
$('.select').click(function(){
	var changed = false;
	
    var tempSort = $("#sort :selected").val();
    if(tempSort != sort){
	    sort=tempSort;
            changed = true;
    }

    var tempFilter = $("#filterID :selected").val();
    if(tempFilter != filterType){
            filterType = tempFilter;
                changed = true;
    }

	if(changed){
		buildTable();
	}
});
});

function addToCart(rowNum){
	var nameID ='n' + rowNum;
	var quantityID = 'q' + rowNum;
	var name = document.getElementById(nameID).innerHTML;
	var quantity = document.getElementById(quantityID).value;
	if(quantity > 0){
		alert(quantity + " " + name + " added to cart!");
		$.ajax({
			url:"addToCart.php",
			method:"POST",
			data:{name:name, quantity:quantity},
			success: function(data){
			console.log(data);
			}
		});
	}
}
</script>
</div>
<?php require('footer.php'); ?>

</body>
</html>

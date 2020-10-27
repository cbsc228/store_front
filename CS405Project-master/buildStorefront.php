<?php
$sort = $_POST["sort"];
$filter = $_POST["filterType"];
$searchInput = $_POST["searchInput"];
echo '
<table border="1";>
<tr>
<td><b>Product Name</b></td>
<td width="120px"><b>Base Price ($)</b></td>
<td width="130px"><b>Stock Remaining</b></td>
<td width="160px"><b>Current Discount (%)</b></td>
<td width="80px"><b>Category</b></td>
<td width="130px"><b>Quantity Desired</b></td>
</tr>'
;
include('dbConnect.php');
$query = "SELECT * FROM products";
$query .= " WHERE (name LIKE '%" . $searchInput . "%'";
$query .= " OR category LIKE '%" . $searchInput . "%')";
if($filter != "All"){
    $query .= " AND category = '" . $filter;
    $query .= "'";
}
$query .= " ORDER BY " . $sort . ", name asc;";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

$i=1;
foreach($result as $row) {
	$name = $row['name'];
	$price = $row['price'];
	$stock = $row['stock_remaining'];
	$rate = $row['promotion_rate'];
	if($rate == "")
		$rate = 0;
	$cat = $row['category'];
	if($stock != 0){
		echo '<tr>';
		echo '<td id= n' . $i .'>' . $name . '</td>';
		echo '<td>' . $price . '</td>';
		echo '<td>'  . $stock . '</td>';
		echo '<td>' . $rate . '</td>';
		echo '<td>' . $cat . '</td>';
		echo '<td>';
		echo '<select id= q' . $i .' style= "width:130px">';
		for($stockCount = 0; $stockCount <= $stock; $stockCount++){
			echo '<option>'. $stockCount .'</option>';
		}
		echo '</select>';
		echo '</td>';
		echo '<td><button  value = ' . $i . ' onclick="addToCart(this.value)" class="button"><b>Add to Cart</b></button></td>';
		echo '</tr>';
		$i = $i+1;
	}
}
?>


</table>
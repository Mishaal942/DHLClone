<?php
$conn = new mysqli("localhost", "uppbmi0whibtc", "bjgew6ykgu1v", "dbqm4qimlchjiv");
if ($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$search = isset($_GET['search']) ? $_GET['search'] : '';
if($search){
    $sql = "SELECT * FROM articles WHERE title LIKE '%$search%' OR content LIKE '%$search%' ORDER BY created_at DESC";
    $heading = "Search results for: '$search'";
}else{
    $category = $_GET['name'];
    $sql = "SELECT * FROM articles WHERE category='$category' ORDER BY created_at DESC";
    $heading = $category." News";
}
$result = $conn->query($sql);

// Function to highlight keyword
function highlight($text, $keyword){
    return preg_replace("/($keyword)/i", '<span style="background:#f90;color:white;padding:2px 3px;border-radius:3px;">$1</span>', $text);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $heading; ?></title>
<style>
body{font-family:Arial,sans-serif;margin:0;background:#f4f4f4;color:#333;}
header{background:#1a1a1a;color:white;padding:20px;text-align:center;}
.card{background:white;margin:10px;padding:15px;border-radius:10px;box-shadow:0 0 10px rgba(0,0,0,0.1);cursor:pointer;}
.card:hover{transform:scale(1.02);transition:0.3s;}
footer{background:#1a1a1a;color:white;text-align:center;padding:15px;margin-top:20px;}
</style>
</head>
<body>

<header><h1><?php echo $heading; ?></h1></header>

<div style="margin:20px;">
<?php while($row=$result->fetch_assoc()){ 
    $title = $search ? highlight($row['title'], $search) : $row['title'];
    $content = $search ? highlight(substr($row['content'],0,150), $search) : substr($row['content'],0,150);
?>
<div class="card" onclick="goArticle(<?php echo $row['id']; ?>)">
<h2><?php echo $title; ?></h2>
<p><?php echo $content.'...'; ?></p>
</div>
<?php } ?>
</div>

<footer><p>© 2025 News Today</p></footer>

<script>
function goArticle(id){window.location.href="article.php?id="+id;}
</script>

</body>
</html>

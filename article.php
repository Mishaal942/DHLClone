<?php
$conn = new mysqli("localhost", "uppbmi0whibtc", "bjgew6ykgu1v", "dbqm4qimlchjiv");
if ($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$id = $_GET['id'];
$sql = "SELECT * FROM articles WHERE id=$id";
$result = $conn->query($sql);

if($result->num_rows == 0){
    die("Article not found.");
}

$row = $result->fetch_assoc();

// Fetch related articles
$related_sql = "SELECT * FROM articles WHERE category='{$row['category']}' AND id!=$id ORDER BY created_at DESC LIMIT 3";
$related_result = $conn->query($related_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $row['title']; ?></title>
<style>
body{font-family:Arial,sans-serif;margin:0;background:#f4f4f4;color:#333;}
header{background:#1a1a1a;color:white;padding:20px;text-align:center;}
article{max-width:800px;margin:20px auto;background:white;padding:20px;border-radius:10px;box-shadow:0 0 10px rgba(0,0,0,0.1);}
article img{width:100%;border-radius:10px;}
footer{background:#1a1a1a;color:white;text-align:center;padding:15px;margin-top:20px;}
#commentsContainer div{padding:10px;margin:5px 0;background:#f9f9f9;border-radius:5px;box-shadow:0 0 5px rgba(0,0,0,0.1);}
#commentForm input, #commentForm textarea{padding:10px;width:80%;border-radius:5px;border:1px solid #ccc;margin-bottom:5px;}
#commentForm button{padding:10px 15px;border:none;background:#f90;color:white;border-radius:5px;cursor:pointer;}
.related .card{background:white;padding:10px;margin:5px 0;border-radius:5px;cursor:pointer;box-shadow:0 0 5px rgba(0,0,0,0.1);}
.related .card:hover{transform:scale(1.02);transition:0.3s;}
</style>
</head>
<body>

<header>
<h1><?php echo $row['title']; ?></h1>
<p>By <?php echo $row['author']; ?> | <?php echo date('F j, Y', strtotime($row['created_at'])); ?></p>
</header>

<article>
<img src="<?php echo $row['image']; ?>" alt="">
<p><?php echo nl2br($row['content']); ?></p>

<section style="margin-top:30px;">
<h3>Comments</h3>
<div id="commentsContainer">
<!-- Comment section always visible, even if empty -->
<p style="color:#888;">No comments yet. Be the first to comment!</p>
</div>

<form id="commentForm" onsubmit="addComment(event)">
<input type="text" id="commentName" placeholder="Your Name" required>
<br>
<textarea id="commentText" placeholder="Write a comment..." required></textarea>
<br>
<button type="submit">Post Comment</button>
</form>
</section>

<section class="related" style="margin-top:30px;">
<h3>Related Articles</h3>
<?php while($rel=$related_result->fetch_assoc()){ ?>
<div class="card" onclick="goArticle(<?php echo $rel['id']; ?>)">
<h4><?php echo $rel['title']; ?></h4>
</div>
<?php } ?>
</section>

</article>

<footer><p>© 2025 News Today</p></footer>

<script>
// Comments stored in localStorage
let comments = JSON.parse(localStorage.getItem('comments_<?php echo $row['id']; ?>') || '[]');
const commentsContainer = document.getElementById('commentsContainer');

function renderComments(){
    commentsContainer.innerHTML = '';
    if(comments.length === 0){
        commentsContainer.innerHTML = '<p style="color:#888;">No comments yet. Be the first to comment!</p>';
    }
    comments.forEach(c=>{
        const div = document.createElement('div');
        div.innerHTML = `<strong>${c.name}</strong><p>${c.text}</p>`;
        commentsContainer.appendChild(div);
    });
}
renderComments();

// Add new comment
function addComment(e){
    e.preventDefault();
    const name = document.getElementById('commentName').value.trim();
    const text = document.getElementById('commentText').value.trim();
    if(name && text){
        comments.push({name,text});
        localStorage.setItem('comments_<?php echo $row['id']; ?>', JSON.stringify(comments));
        renderComments();
        document.getElementById('commentForm').reset();
    }
}

// Navigation
function goArticle(id){window.location.href="article.php?id="+id;}
</script>

</body>
</html>

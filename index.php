<?php
$conn = new mysqli("localhost", "uppbmi0whibtc", "bjgew6ykgu1v", "dbqm4qimlchjiv");
if ($conn->connect_error) { die("Connection failed: ".$conn->connect_error); }
$featured_sql = "SELECT * FROM articles ORDER BY created_at DESC LIMIT 3";
$featured_result = $conn->query($featured_sql);
$categories = ['World','Sports','Technology','Entertainment'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>News Today</title>
<style>
/* Modern Professional News Design - DHL Clone */
:root {
    --primary-color: #d40511;
    --secondary-color: #ffcc00;
    --dark-bg: #1a1a2e;
    --light-bg: #f8f9fa;
    --card-shadow: 0 8px 24px rgba(0,0,0,0.12);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
    color: #2c3e50;
    line-height: 1.6;
    overflow-x: hidden;
}

header {
    background: linear-gradient(135deg, var(--primary-color) 0%, #a00408 100%);
    color: white;
    padding: 40px 20px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(212, 5, 17, 0.3);
    position: relative;
    overflow: hidden;
}

header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: pulse 15s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 0.3; }
    50% { transform: scale(1.1); opacity: 0.5; }
}

header h1 {
    font-size: 3rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-shadow: 2px 4px 8px rgba(0,0,0,0.3);
    position: relative;
    z-index: 1;
    animation: slideDown 0.8s ease-out;
}

@keyframes slideDown {
    from { transform: translateY(-50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

nav {
    background: linear-gradient(to right, #2c3e50 0%, #34495e 100%);
    color: white;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    padding: 15px 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    position: sticky;
    top: 0;
    z-index: 100;
    backdrop-filter: blur(10px);
}

nav button {
    margin: 5px;
    padding: 12px 24px;
    border: none;
    border-radius: 25px;
    background: linear-gradient(135deg, #555 0%, #666 100%);
    color: white;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.95rem;
    transition: var(--transition);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    position: relative;
    overflow: hidden;
}

nav button::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255,204,0,0.4);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

nav button:hover::before {
    width: 300px;
    height: 300px;
}

nav button:hover {
    background: linear-gradient(135deg, var(--secondary-color) 0%, #ffd700 100%);
    color: #1a1a2e;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(255,204,0,0.4);
}

nav form {
    display: flex;
    margin-left: 15px;
    animation: fadeIn 1s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

nav input {
    padding: 10px 18px;
    border-radius: 25px 0 0 25px;
    border: 2px solid var(--secondary-color);
    outline: none;
    font-size: 0.95rem;
    transition: var(--transition);
    background: white;
}

nav input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 15px rgba(212, 5, 17, 0.2);
}

nav form button {
    padding: 10px 24px;
    border: none;
    border-radius: 0 25px 25px 0;
    background: linear-gradient(135deg, var(--secondary-color) 0%, #ffd700 100%);
    color: #1a1a2e;
    cursor: pointer;
    margin-left: 0;
    font-weight: 700;
    transition: var(--transition);
}

nav form button:hover {
    background: linear-gradient(135deg, #ffd700 0%, var(--secondary-color) 100%);
    transform: scale(1.05);
}

.featured {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    margin: 40px auto;
    max-width: 1400px;
    padding: 0 20px;
}

.featured h2 {
    width: 100%;
    text-align: center;
    font-size: 2.5rem;
    color: var(--primary-color);
    margin-bottom: 30px;
    position: relative;
    padding-bottom: 15px;
}

.featured h2::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 4px;
    background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
    border-radius: 2px;
}

.featured .card {
    background: white;
    width: 30%;
    min-width: 280px;
    margin: 15px;
    border-radius: 20px;
    box-shadow: var(--card-shadow);
    cursor: pointer;
    transition: var(--transition);
    overflow: hidden;
    position: relative;
}

.featured .card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    transition: left 0.5s;
}

.featured .card:hover::before {
    left: 100%;
}

.featured .card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 16px 40px rgba(212, 5, 17, 0.25);
}

.featured .card img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    transition: var(--transition);
}

.featured .card:hover img {
    transform: scale(1.1);
}

.featured .card h3 {
    padding: 20px;
    font-size: 1.3rem;
    color: #2c3e50;
    font-weight: 700;
    line-height: 1.4;
}

.featured .card p {
    padding: 0 20px 20px;
    color: #7f8c8d;
    font-size: 0.95rem;
}

.category {
    margin: 40px auto;
    max-width: 1400px;
    padding: 0 20px;
}

.category h2 {
    margin-bottom: 20px;
    font-size: 2rem;
    color: var(--primary-color);
    padding-left: 15px;
    border-left: 5px solid var(--secondary-color);
    display: inline-block;
}

.category > div {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.category .card {
    background: white;
    flex: 1;
    min-width: 280px;
    margin: 0;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    cursor: pointer;
    transition: var(--transition);
    border-left: 4px solid transparent;
    position: relative;
    overflow: hidden;
}

.category .card::after {
    content: '→';
    position: absolute;
    right: 20px;
    bottom: 20px;
    font-size: 1.5rem;
    color: var(--primary-color);
    opacity: 0;
    transition: var(--transition);
}

.category .card:hover {
    transform: translateX(10px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    border-left-color: var(--primary-color);
}

.category .card:hover::after {
    opacity: 1;
    right: 15px;
}

.category .card h3 {
    font-size: 1.2rem;
    color: #2c3e50;
    margin-bottom: 10px;
    font-weight: 700;
}

.category .card p {
    color: #7f8c8d;
    font-size: 0.9rem;
    line-height: 1.6;
}

footer {
    background: linear-gradient(135deg, var(--dark-bg) 0%, #0f0f1e 100%);
    color: white;
    text-align: center;
    padding: 30px;
    margin-top: 60px;
    box-shadow: 0 -4px 20px rgba(0,0,0,0.2);
    font-size: 1rem;
}

footer p {
    opacity: 0.9;
    letter-spacing: 1px;
}

/* Responsive Design */
@media(max-width: 1024px) {
    .featured .card {
        width: 45%;
    }
}

@media(max-width: 800px) {
    header h1 {
        font-size: 2rem;
    }
    
    .featured .card {
        width: 100%;
    }
    
    nav {
        padding: 10px;
    }
    
    nav button {
        padding: 10px 18px;
        font-size: 0.85rem;
    }
    
    .featured h2 {
        font-size: 2rem;
    }
    
    .category h2 {
        font-size: 1.5rem;
    }
}

@media(max-width: 500px) {
    header h1 {
        font-size: 1.5rem;
        letter-spacing: 1px;
    }
    
    nav form {
        width: 100%;
        margin: 10px 0 0 0;
    }
    
    nav input {
        flex: 1;
    }
}

/* Loading Animation */
@keyframes shimmer {
    0% { background-position: -1000px 0; }
    100% { background-position: 1000px 0; }
}

/* Smooth Scrolling */
html {
    scroll-behavior: smooth;
}

/* Selection Color */
::selection {
    background: var(--secondary-color);
    color: var(--dark-bg);
}
</style>
</head>
<body>
<header><h1>News Today</h1></header>
<nav>
<?php foreach($categories as $cat){ ?>
<button onclick="goCategory('<?php echo $cat; ?>')"><?php echo $cat; ?></button>
<?php } ?>
<form onsubmit="searchArticles(event)">
<input type="text" id="searchInput" placeholder="Search articles...">
<button type="submit">Search</button>
</form>
</nav>
<section class="featured">
<h2 style="width:100%;text-align:center;">Featured News</h2>
<?php while($row=$featured_result->fetch_assoc()){ ?>
<div class="card" onclick="goArticle(<?php echo $row['id']; ?>)">
<img src="<?php echo $row['image']; ?>" alt="">
<h3><?php echo $row['title']; ?></h3>
<p><?php echo substr($row['content'],0,100).'...'; ?></p>
</div>
<?php } ?>
</section>
<?php foreach($categories as $cat){
$cat_sql = "SELECT * FROM articles WHERE category='$cat' ORDER BY created_at DESC LIMIT 3";
$cat_result = $conn->query($cat_sql);
?>
<section class="category">
<h2><?php echo $cat; ?></h2>
<div style="display:flex;flex-wrap:wrap;">
<?php while($row=$cat_result->fetch_assoc()){ ?>
<div class="card" onclick="goArticle(<?php echo $row['id']; ?>)">
<h3><?php echo $row['title']; ?></h3>
<p><?php echo substr($row['content'],0,80).'...'; ?></p>
</div>
<?php } ?>
</div>
</section>
<?php } ?>
<footer><p>© 2025 News Today</p></footer>
<script>
function goCategory(name){window.location.href="category.php?name="+name;}
function goArticle(id){window.location.href="article.php?id="+id;}
function searchArticles(e){
    e.preventDefault();
    const query = document.getElementById('searchInput').value.trim();
    if(query) window.location.href="category.php?search="+encodeURIComponent(query);
}
</script>
</body>
</html>

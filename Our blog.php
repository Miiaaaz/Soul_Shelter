<?php include('includes/header.php'); ?>
<?php include('includes/db.php'); ?>

<?php

// Function to get blog posts from database
function getBlogPosts($conn, $category = null) {
    $posts = [];
    $sql = "SELECT * FROM blog_posts";
    
    if ($category && $category != 'All') {
        $sql .= " WHERE category = ?";
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    $stmt = $conn->prepare($sql);
    
    if ($category && $category != 'All') {
        $stmt->bind_param("s", $category);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    }
    
    return $posts;
}

// Get categories for filter
function getCategories($conn) {
    $categories = [];
    $sql = "SELECT DISTINCT category FROM blog_posts ORDER BY category";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $categories[] = $row['category'];
        }
    }
    
    return $categories;
}

// Get current category filter
$current_category = isset($_GET['category']) ? $_GET['category'] : 'All';

// Get posts and categories
$posts = getBlogPosts($conn, $current_category != 'All' ? $current_category : null);
$categories = getCategories($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Our Blog | Soul Shelter</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #4CAF50;
      --secondary: #FF6B6B;
      --accent: #FFD166;
      --light: #F7FFF7;
      --dark: #292F36;
      --text: #333333;
    }
    
    body {
      font-family: 'Open Sans', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
      color: var(--text);
      line-height: 1.6;
    }
    
    .blog-header {
      background: linear-gradient(rgba(255, 87, 64, 0.7), rgba(255, 111, 44, 0.7)), url('images/blog-header.jpg') center/cover no-repeat;
      color: white;
      text-align: center;
      padding: 80px 20px;
      margin-bottom: 40px;
    }
    
    .blog-header h1 {
      font-family: 'Poppins', sans-serif;
      font-size: 3rem;
      margin-bottom: 20px;
    }
    
    .blog-header p {
      max-width: 800px;
      margin: 0 auto;
      font-size: 1.2rem;
    }
    
    .blog-controls {
      max-width: 1200px;
      margin: 0 auto 30px;
      padding: 0 20px;
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    .blog-controls label {
      font-weight: 600;
      color: var(--dark);
    }
    
    .blog-controls select {
      padding: 8px 15px;
      border: 2px solid #e0e0e0;
      border-radius: 6px;
      font-size: 16px;
      min-width: 200px;
    }
    
    .blog-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 30px;
      margin-bottom: 50px;
    }
    
    .blog-post {
      background-color: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .blog-post:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    
    .post-image {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
    
    .post-content {
      padding: 20px;
    }
    
    .post-category {
      display: inline-block;
      background-color: var(--primary);
      color: white;
      padding: 4px 10px;
      border-radius: 4px;
      font-size: 0.8rem;
      font-weight: 600;
      margin-bottom: 10px;
    }
    
    .post-title {
      font-family: 'Poppins', sans-serif;
      color: var(--dark);
      margin: 0 0 10px;
      font-size: 1.4rem;
    }
    
    .post-excerpt {
      color: var(--text);
      margin-bottom: 15px;
    }
    
    .post-meta {
      display: flex;
      justify-content: space-between;
      color: #777;
      font-size: 0.9rem;
    }
    
    .read-more {
      display: inline-block;
      background-color: var(--primary);
      color: white;
      padding: 8px 15px;
      border-radius: 4px;
      text-decoration: none;
      font-weight: 600;
      margin-top: 15px;
      transition: background-color 0.3s;
    }
    
    .read-more:hover {
      background-color: #3e8e41;
    }
    
    .no-posts {
      grid-column: 1/-1;
      text-align: center;
      padding: 40px;
      color: var(--dark);
    }
    
    @media (max-width: 768px) {
      .blog-header h1 {
        font-size: 2.2rem;
      }
      
      .blog-header p {
        font-size: 1rem;
      }
      
      .blog-container {
        grid-template-columns: 1fr;
      }
      
      .blog-controls {
        flex-direction: column;
        align-items: flex-start;
      }
    }
  </style>
</head>
<body>
  
  <header class="blog-header">
    <h1>Our Blog</h1>
    <p>Welcome to our blog—a space where we share heartwarming rescue stories, pet care tips, behind-the-scenes moments, and updates from our shelter. Whether you're an animal lover, potential adopter, or curious supporter, there's something here for you. Stay connected, stay inspired!</p>
  </header>

  <section class="blog-controls">
    <form method="GET" action="blog.php">
      <label for="categoryFilter">Filter by Category:</label>
      <select id="categoryFilter" name="category" onchange="this.form.submit()">
        <option value="All" <?php echo $current_category == 'All' ? 'selected' : ''; ?>>All Categories</option>
        <?php foreach ($categories as $category): ?>
          <option value="<?php echo htmlspecialchars($category); ?>" <?php echo $current_category == $category ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($category); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </form>
  </section>

  <main id="blogContainer" class="blog-container">
    <?php if (empty($posts)): ?>
      <div class="no-posts">
        <h2>No blog posts found</h2>
        <p>Check back later for new posts!</p>
      </div>
    <?php else: ?>
      <?php foreach ($posts as $post): ?>
        <article class="blog-post">
          <div class="post-content">
            <span class="post-category"><?php echo htmlspecialchars($post['category']); ?></span>
            <h2 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h2>
            <p class="post-excerpt"><?php echo htmlspecialchars(substr($post['content'], 0, 150) . '...'); ?></p>
            <div class="post-meta">
              <span><?php echo date('F j, Y', strtotime($post['created_at'])); ?></span>
              <span>By <?php echo htmlspecialchars($post['author']); ?></span>
            </div>
            <a href="post.php?id=<?php echo $post['id']; ?>" class="read-more">Read More</a>
          </div>
        </article>
      <?php endforeach; ?>
    <?php endif; ?>
  </main>

  <?php include('includes/footer.php'); ?>
</body>
</html>
<?php include('includes/header.php'); ?>
<?php include('includes/db.php'); ?>

<?php
// Function to fetch FAQs from database
function getFAQs($conn) {
    $faqs = [];
    $sql = "SELECT * FROM faqs ORDER BY display_order ASC";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $faqs[] = $row;
        }
    }
    return $faqs;
}

$faqs = getFAQs($conn);

// Handle FAQ search
$search_results = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $search_term = mysqli_real_escape_string($conn, $_GET['search']);
    $sql = "SELECT * FROM faqs 
            WHERE question LIKE '%$search_term%' OR answer LIKE '%$search_term%' 
            ORDER BY display_order ASC";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $search_results[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Soul Shelter</title>
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
        
        .header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .logo {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary);
            margin-left: 20px;
        }
        
        .nav {
            display: flex;
            align-items: center;
        }
        
        .nav a {
            color: var(--dark);
            text-decoration: none;
            margin: 0 15px;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav a:hover {
            color: var(--primary);
        }
        
        .auth button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            margin: 0 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .auth button:hover {
            background-color: #3e8e41;
        }
        
        .search-bar {
            background-color: var(--primary);
            padding: 15px 0;
            text-align: center;
        }
        
        .search-bar input {
            padding: 8px 15px;
            border: none;
            border-radius: 4px 0 0 4px;
            width: 300px;
        }
        
        .search-bar button {
            padding: 8px 15px;
            border: none;
            background-color: var(--dark);
            color: white;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }
        
        .faq-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .faq-container h1 {
            font-family: 'Poppins', sans-serif;
            color: var(--primary);
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .intro {
            text-align: center;
            font-size: 1.2rem;
            color: var(--dark);
            margin-bottom: 40px;
        }
        
        .faq-list {
            margin-bottom: 50px;
        }
        
        .faq-item {
            margin-bottom: 15px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .faq-question {
            width: 100%;
            text-align: left;
            padding: 20px;
            background-color: white;
            border: none;
            font-family: 'Poppins', sans-serif;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .faq-question:hover {
            background-color: #f5f5f5;
        }
        
        .faq-question::after {
            content: '+';
            font-size: 1.5rem;
            color: var(--primary);
        }
        
        .faq-question.active::after {
            content: '-';
        }
        
        .faq-answer {
            padding: 0;
            background-color: white;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .faq-answer p {
            padding: 0 20px 20px;
            margin: 0;
        }
        
        .faq-answer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }
        
        .faq-answer a:hover {
            text-decoration: underline;
        }
        
        .search-results {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .search-results h2 {
            color: var(--primary);
            margin-top: 0;
        }
        
        .no-results {
            text-align: center;
            padding: 20px;
            color: var(--dark);
        }
        
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                padding: 10px 0;
            }
            
            .logo {
                margin: 10px 0;
            }
            
            .nav {
                flex-direction: column;
                margin: 10px 0;
            }
            
            .nav a {
                margin: 5px 0;
            }
            
            .auth {
                margin: 10px 0;
            }
            
            .search-bar input {
                width: 70%;
            }
            
            .faq-container h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    
    <main class="faq-container">
        <h1>🐾 Frequently Asked Questions</h1>
        <p class="intro">Got questions? We've got tails and tales with answers!</p>
        
        <?php if (!empty($search_results)): ?>
            <div class="search-results">
                <h2>Search Results for "<?php echo htmlspecialchars($_GET['search']); ?>"</h2>
                <?php foreach ($search_results as $faq): ?>
                    <div class="faq-item">
                        <button class="faq-question"><?php echo htmlspecialchars($faq['question']); ?></button>
                        <div class="faq-answer">
                            <p><?php echo nl2br(htmlspecialchars($faq['answer'])); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
                <p><a href="faq.php">← Back to all FAQs</a></p>
            </div>
        <?php elseif (empty($faqs)): ?>
            <div class="no-results">
                <p>No FAQs found. Please check back later.</p>
            </div>
        <?php else: ?>
            <div class="faq-list">
                <?php foreach ($faqs as $faq): ?>
                    <div class="faq-item">
                        <button class="faq-question"><?php echo htmlspecialchars($faq['question']); ?></button>
                        <div class="faq-answer">
                            <p><?php echo nl2br(htmlspecialchars($faq['answer'])); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <script>
        // Toggle FAQ answers
        const faqQuestions = document.querySelectorAll('.faq-question');
        faqQuestions.forEach(question => {
            question.addEventListener('click', () => {
                question.classList.toggle('active');
                const answer = question.nextElementSibling;
                if (question.classList.contains('active')) {
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                } else {
                    answer.style.maxHeight = 0;
                }
            });
        });
        
        // Open FAQ if it's in search results
        if (window.location.search.includes('search=')) {
            document.querySelectorAll('.faq-question').forEach(question => {
                question.classList.add('active');
                question.nextElementSibling.style.maxHeight = question.nextElementSibling.scrollHeight + 'px';
            });
        }
        
        // Toggle dropdown menu
        function toggleDropdown() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close dropdown if clicked outside
        window.onclick = function(event) {
            if (!event.target.matches('.dropdown-button')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>
</html>
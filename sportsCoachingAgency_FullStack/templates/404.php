<style>
  /* 404 Page Styles */
.error-page {
    text-align: center;
    padding: 50px 20px;
    background-color: #f8f9fa;
    border: 1px solid #ddd;
    border-radius: 8px;
    max-width: 600px;
    margin: 100px auto;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.error-page h1 {
    font-size: 3rem;
    color: #333;
    margin-bottom: 20px;
}

.error-page p {
    font-size: 1.2rem;
    color: #555;
    margin-bottom: 30px;
}

.error-page .btn-back {
    display: inline-block;
    padding: 10px 20px;
    font-size: 1rem;
    color: #fff;
    background-color: #007bff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.error-page .btn-back:hover {
    cursor: pointer;
    background-color: #0056b3;
}
</style>
<div class="error-page">
    <h1>404 - Page Not Found</h1>
    <p>Oops! The page you're looking for doesn't exist.</p>
    <p><button onclick="goBack()" class="btn-back">Go Back</button></p>
    <p>If you think this is a mistake, please contact support.</p>
</div>

<!-- add javascript go back button -->
<script>
    function goBack() {
        window.history.back();
    }
</script>
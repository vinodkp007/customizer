<!-- <footer class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>About Us</h3>
            <p>Your company description here. Providing quality services since [year].</p>
        </div>
        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Contact Info</h3>
            <p>Email: info@example.com</p>
            <p>Phone: (123) 456-7890</p>
            <p>Address: Your Address Here</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 Your Company Name. All rights reserved.</p>
    </div>
</footer>


<script src="<?= base_url(); ?>/assets/js/home_script.js"></script>
</body>
</html> -->

<!-- Dynamic Footer -->

<style>
/* Your footer CSS here */
.main-footer {
    background-color: #2c3e50;
    color: #fff;
    padding: 3rem 0 0;
    margin-top: auto;
}


</style>
<link rel="stylesheet" href="<?= base_url('assets/css/footer.css') ?>">
<?= generate_footer() ?>
</main>
<footer>
    <footer class="bg-dark text-light pt-5 pb-4">
        <div class="container-fluid px-5 text-md-start">
            <div class="row">

                <!-- Company Info -->
                <div class="col-md-3 col-lg-4 col-xl-3 mb-4">
                    <a class="navbar-brand d-flex align-items-center" href="<?= BASE_URL ?>/">
                        <img src="https://cdn.vectorstock.com/i/1000v/43/22/shopping-cart-logo-design-vector-21804322.jpg" alt="Your Logo" width="40" height="40" class="d-inline-block align-text-top me-2">
                        <span class="italic fw-4">E-seller</span>
                    </a>
                    <p class="pt-2">
                        We bring you high-quality products curated with care. Shop confidently and enjoy our unbeatable offers.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">Home</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Shop</a></li>
                        <li><a href="#" class="text-light text-decoration-none">About</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Contact</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-3">Support</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">FAQs</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Shipping</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Returns</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Contact & Newsletter -->
                <div class="col-md-4 col-lg-3 col-xl-3 mb-md-0 mb-4">
                    <h6 class="text-uppercase fw-bold mb-3">Contact</h6>
                    <p><i class="bi bi-geo-alt-fill me-2"></i> 1234 Market St, Lagos, NG</p>
                    <p><i class="bi bi-envelope-fill me-2"></i> support@yourcompany.com</p>
                    <p><i class="bi bi-phone-fill me-2"></i> +234 812 345 6789</p>

                    <form class="mt-3">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Subscribe to newsletter" />
                            <button class="btn btn-primary" type="submit">Go</button>
                        </div>
                    </form>
                </div>

            </div>

            <hr class="mt-4" />

            <!-- Bottom Footer -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3">
                <p class="mb-2 mb-md-0">&copy; <?= date("Y") ?> YourCompany. All Rights Reserved.</p>
                <div class="d-flex align-items-center gap-4 pt-md-0 pt-3">
                    <i style="cursor:pointer" class="fa-brands fa-facebook text-white"></i>
                    <i style="cursor:pointer" class="fa-brands fa-instagram text-white"></i>
                    <i style="cursor:pointer" class="fa-brands fa-x-twitter text-white"></i>
                    <i style="cursor:pointer" class="fa-brands fa-whatsapp text-white"></i>
                </div>
            </div>
        </div>
    </footer>

</footer>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    setTimeout(() => {
        const flash = document.getElementById("flash-message");
        if (flash) {
            flash.style.transition = "opacity 0.5s ease";
            flash.style.opacity = "0";
            setTimeout(() => flash.remove(), 500);
        }
    }, 8000);
</script>
</body>

</html>
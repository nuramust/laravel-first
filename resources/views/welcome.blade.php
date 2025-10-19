<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="NuraDental – Premium dental care with online appointment booking.">
    <title>NuraDental – Modern Dental Clinic</title>

    <!-- Google Fonts: Gilroy -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #5D0C99;
            --primary-dark: #4a0a7a;
            --primary-light: #7a3db8;
            --secondary: #f8f9fa;
            --dark: #212529;
            --light: #ffffff;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            background-color: #fafafa;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

        .navbar-brand {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary) !important;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            color: var(--dark) !important;
            transition: color 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary) !important;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            font-weight: 600;
            padding: 0.6rem 1.5rem;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, rgba(93, 12, 153, 0.92), rgba(74, 10, 122, 0.95)), url('https://images.unsplash.com/photo-1617791160536-5778c2c67a57?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
        }

        .hero h1 {
            font-size: 3.5rem;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            color: white;
        }

        .hero p {
            font-size: 1.25rem;
            max-width: 600px;
            opacity: 0.95;
        }

        /* Features */
        .feature-icon {
            width: 60px;
            height: 60px;
            background-color: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1.5rem;
        }

        /* Testimonials */
        .testimonial-card {
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
        }

        /* Footer */
        footer {
            background-color: var(--dark);
            color: white;
            padding: 50px 0 20px;
        }

        footer a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s;
        }

        footer a:hover {
            color: var(--primary-light);
        }

        .footer-heading {
            color: white;
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            .hero p {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 576px) {
            .hero h1 {
                font-size: 2rem;
            }
            .btn-primary {
                width: 100%;
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <span style="color: var(--primary);">Nura</span><span style="color: var(--primary-dark);">Dental</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
                <li class="nav-item ms-2">
                    <a class="btn btn-primary btn-sm" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item ms-2">
                    <a class="btn btn-outline-primary btn-sm" href="{{ route('register') }}">Register</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section id="home" class="hero">
    <div class="container text-center text-md-start">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h1>Modern Dental Care, <br> Made Simple</h1>
                <p>Book appointments online, get expert care, and enjoy a pain-free smile with NuraDental.</p>
                <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">Book Appointment</a>
                    <a href="#services" class="btn btn-outline-light btn-lg">Our Services</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services -->
<section id="services" class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="mb-3">Our Dental Services</h2>
            <p class="text-muted">Comprehensive care for your entire family</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <div class="feature-icon mx-auto">
                        <i class="bi bi-tooth"></i>
                    </div>
                    <h4>Teeth Cleaning</h4>
                    <p>Professional cleaning to remove plaque and keep your gums healthy.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="feature-icon mx-auto">
                        <i class="bi bi-droplet-half"></i>
                    </div>
                    <h4>Fillings & Restorations</h4>
                    <p>Durable, natural-looking fillings to restore damaged teeth.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="feature-icon mx-auto">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                    <h4>Root Canal Therapy</h4>
                    <p>Pain-free treatment to save infected or damaged teeth.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About -->
<section id="about" class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="https://images.unsplash.com/photo-1588776813677-8a52f8a9e4f5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="Dentist with patient" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-6">
                <h2>Why Choose NuraDental?</h2>
                <p class="lead">We combine advanced technology with compassionate care.</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Online appointment booking</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Experienced dentists</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Pain-free procedures</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Modern, clean clinic</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Emergency care available</li>
                </ul>
                <a href="{{ route('register') }}" class="btn btn-primary">Get Started Today</a>
            </div>
        </div>
</section>

<!-- Testimonials -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2>What Our Patients Say</h2>
            <p class="text-muted">Real experiences from real people</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <div class="bg-secondary rounded-circle" style="width: 50px; height: 50px;"></div>
                        </div>
                        <div>
                            <h5>Aisha Musa</h5>
                            <small class="text-muted">Patient since 2022</small>
                        </div>
                    </div>
                    <p>“Booking was so easy! The dentist was gentle and explained everything. My fear of dentists is gone!”</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <div class="bg-secondary rounded-circle" style="width: 50px; height: 50px;"></div>
                        </div>
                        <div>
                            <h5>Usman Auwalu</h5>
                            <small class="text-muted">Father of two</small>
                        </div>
                    </div>
                    <p>“My kids actually look forward to their check-ups now. The staff is amazing with children.”</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <div class="bg-secondary rounded-circle" style="width: 50px; height: 50px;"></div>
                        </div>
                        <div>
                            <h5>Lionel Pessi</h5>
                            <small class="text-muted">Regular patient</small>
                        </div>
                    </div>
                    <p>“The online system saves me so much time. I can book, reschedule, and even see my records!”</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact CTA -->
<section id="contact" class="py-5" style="background: linear-gradient(to right, var(--primary), var(--primary-dark)); color: white;">
    <div class="container text-center">
        <h2 class="mb-3">Ready for a Healthier Smile?</h2>
        <p class="mb-4">Join thousands of satisfied patients. Book your first appointment today!</p>
        <a href="{{ route('register') }}" class="btn btn-light btn-lg">Create Free Account</a>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="footer-heading">NuraDental</h5>
                <p>Premium dental care with modern technology and compassionate service.</p>
                <div class="mt-3">
                    <a href="#" class="me-2"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="me-2"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="me-2"><i class="bi bi-twitter"></i></a>
                </div>
            </div>
            <div class="col-md-2 mb-4">
                <h6 class="footer-heading">Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="footer-heading">Contact Info</h6>
                <ul class="list-unstyled">
                    <li><i class="bi bi-geo-alt me-2"></i> Kano - Nigeria</li>
                    <li><i class="bi bi-telephone me-2"></i> (234) 9164601810</li>
                    <li><i class="bi bi-envelope me-2"></i> info@nuradental.com</li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="footer-heading">Hours</h6>
                <ul class="list-unstyled">
                    <li>Mon-Fri: 8:00 AM - 6:00 PM</li>
                    <li>Sat: 9:00 AM - 2:00 PM</li>
                    <li>Sun: Closed</li>
                </ul>
            </div>
        </div>
        <hr class="mt-4" style="background: #444;">
        <div class="text-center mt-3">
            <small>&copy; {{ date('Y') }} NuraDental. All rights reserved.</small>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Smooth scrolling for anchor links -->
<script>
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
</script>

</body>
</html>
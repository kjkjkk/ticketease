@extends('layouts.master')
@section('title', 'TicketEase | Home')
@section('content')
<style>
    .steps-section {
        min-height: 100vh;
    }

    section {
        padding: 50px;
    }

    .box {
        background: #fff;
        padding: 10px;
        width: 300px;
        height: 300px;
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: transform 0.3s ease;
        /* Smooth transition for the hover effect */
    }

    .box .icon {
        width: 200px;
        height: 200px;
        object-fit: contain;
    }

    .box:hover {
        transform: scale(1.15);
        /* Slightly grow the box on hover */
    }

    .section-two .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    @media (max-width: 768px) {
        .box {
            width: 100%;
            height: auto;
        }

        .section-two .container {
            flex-direction: column;
            gap: 30px;
        }
    }

    .btn-custom {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        background-color: var(--bs-indi);
        color: white;
        text-decoration: none;
        border-radius: 20px;
        font-size: 1.1rem;
        transition: background-color 0.3s ease;
        font-weight: bold;
    }

    .btn-custom:hover {
        background-color: #434190;
        color: var(--bs-indi-subtle);
    }

    .btn-icon {
        width: 30px;
        /* Adjust the size of the GIF */
        height: 30px;
        margin-right: 7px;
        object-fit: contain;
        /* Ensures it fits inside without distortion */
        background-color: transparent;
        /* Removes the white background */
        border-radius: 50%;
        /* Optional: Make the gif circular */
    }

    .step {
        display: flex;
        border-radius: 25px 5px 5px 5px;
        font-weight: 600;
        padding: 10px;
        align-items: flex-start;
        /* Adjust the alignment of items */
    }

    .step-icon {
        width: 40px;
        height: 40px;
        font-weight: 800;
        border-radius: 50%;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .steps p {
        margin-left: 1rem;
        flex: 1;
    }

    #backToTop {
        position: fixed;
        bottom: 70px;
        right: 30px;
        background-color: var(--bs-indi);
        color: white;
        padding: 10px 15px;
        border-radius: 50px;
        font-size: 16px;
        border: none;
        cursor: pointer;
        z-index: 1000;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s, visibility 0.3s;

    }

    #backToTop.show {
        opacity: 1;
        visibility: visible;
    }

    #backToTop:hover {
        background-color: #0056b3;
    }
</style>
@include('reminders.requestor-welcome')
<button id="backToTop"><i class="fi fi-ss-up"></i> </button>
<section class="section-one mb-5 bg-white vh-100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="fw-bold text-indi">WELCOME</h1>
                <h5 class="lead text-logo-dark fw-semibold">
                    {{ auth()->user()->firstname . ' ' . auth()->user()->lastname }}
                </h5>
                <p>We’re here to assist you with your IT needs. With TicketEase, you can effortlessly create ticket
                    requests, monitor updates, and review your ongoing requests. Your satisfaction is our priority at
                    the City Health Office ICT Department.
                </p>
                <a href="{{ route('requestor.create-ticket') }}" class="btn btn-custom">
                    <img src="{{ asset('img/recommendation.gif') }}" alt="Online Ticket" class="btn-icon">
                    Create ticket
                </a>
            </div>
            <div class="col-12 col-sm-9 col-md-7 col-lg-6 mx-auto">
                <img src="{{ asset('img/sapiens.png') }}" alt="Illustration" class="img-fluid">
            </div>
        </div>
    </div>
</section>
<section class="section-two mb-5">
    <div class="container d-flex justify-content-center align-items-center gap-5">
        <div class="box shadow-sm">
            <img src="{{ asset('img/rocket.gif') }}" alt="" class="icon">
            <h6 class="fw-semibold mb-3">Getting Started</h6>
            <p class="text-center" style="font-size: .795rem">
                Follow our step-by-step guides to use our website
            </p>
        </div>
        <div class="box shadow-sm">
            <img src="{{ asset('img/task-management.gif') }}" alt="" class="icon">
            <h6 class="fw-semibold mb-3">Account Management</h6>
            <p class="text-center" style="font-size: .795rem">
                Learn about how to manage and update your account
            </p>
        </div>
        <div class="box shadow-sm">
            <img src="{{ asset('img/moodboard.gif') }}" alt="" class="icon">
            <h6 class="fw-semibold mb-3">Monitor Tickets</h6>
            <p class="text-center" style="font-size: .795rem">
                Learn how to check the status of your ticket requests in easy steps
            </p>
        </div>
    </div>
</section>
<section class="steps-section section-three mb-5 bg-white">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <!-- Left Side with Steps -->
            <div class="col-12 col-lg-6 mb-lg-0">
                <h2 class="fw-bold text-dark mb-2">Getting Started</h2>
                <h6 class="text-dark">TicketEase is designed for City Health Office employees to easily submit
                    IT-related issues or concerns. Here's how to get started:</6>
                    <div class="steps mt-4">
                        <div class="step bg-success-subtle mb-3">
                            <div class="step-icon bg-indi">1</div>
                            <p class="mb-0 ms-3">
                                Create a Ticket
                                <small class="fw-light d-block mt-2 mb-2">Go to "Create Ticket" to open the form for
                                    submitting a ticket request, whether it’s a technical issue or any ICT
                                    concern.</small>
                            </p>
                        </div>
                        <div class="step bg-success-subtle mb-3">
                            <div class="step-icon bg-indi">2</div>
                            <p class="mb-0 ms-3">
                                Fill out the Form
                                <small class="fw-light d-block mt-2 mb-2">Provide all the necessary details about your
                                    ticket request. Once completed, click Submit. </small>
                            </p>
                        </div>
                        <div class="step bg-success-subtle mb-3">
                            <div class="step-icon bg-indi">3</div>
                            <p class="mb-0 ms-3">
                                Stay Updated!

                                <small class="fw-light d-block mt-2 mb-2">Stay connected with TicketEase to receive
                                    real-time notification of your ticket status</small>
                            </p>
                        </div>
                    </div>
            </div>
            <!-- Right Side with Image and Button -->
            <div class="col-12 col-sm-9 col-md-7 col-lg-5 mx-auto text-center">
                <img src="{{ asset('img/getting-started.png') }}" alt="Account Management" class="img-fluid mb-4">
                <a href="{{ route('requestor.create-ticket') }}" class="btn btn-logo">Create Ticket</a>
            </div>
        </div>
    </div>
</section>
<section class="steps-section section-four mb-5">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <!-- Left Side with Steps -->
            <div class="col-lg-6 mb-lg-0">
                <h2 class="fw-bold text-dark mb-2">Account Management</h2>
                <h6 class=" text-dark">Keep your account information up-to-date for a secure and personalized
                    experience:</h6>
                <div class="steps mt-4">
                    <div class="step bg-indi-subtle mb-3">
                        <div class="step-icon bg-logo-dark">1</div>
                        <p class="mb-0 ms-3">
                            Profile Settings

                            <small class="fw-light d-block mt-2 mb-2">Navigate to the upper right corner, click your
                                name, and you can change personal details in under your profile.</small>
                        </p>
                    </div>
                    <div class="step bg-indi-subtle mb-3">
                        <div class="step-icon bg-logo-dark">2</div>
                        <p class="mb-0 ms-3">
                            Security Tips

                            <small class="fw-light d-block mt-2 mb-2"> Update your password or contact details anytime
                                through your account settings.</small>
                        </p>
                    </div>
                    <div class="step bg-indi-subtle mb-3">
                        <div class="step-icon bg-logo-dark">3</div>
                        <p class="mb-0 ms-3">
                            Editable Field

                            <small class="fw-light d-block mt-2 mb-2">Only active fields are editable. Replace your
                                default password for stronger security</small>
                        </p>
                    </div>
                    <div class="step bg-indi-subtle mb-3">
                        <div class="step-icon bg-logo-dark">4</div>
                        <p class="mb-0 ms-3">
                            Save Changes

                            <small class="fw-light d-block mt-2 mb-2">Always click Save Changes before leaving to ensure
                                your updates are applied. </small>
                        </p>
                    </div>
                </div>
            </div>
            <!-- Right Side with Image and Button -->
            <div class="col-12 col-sm-9 col-md-7 col-lg-5 mx-auto text-center">
                <img src="{{ asset('img/account-management.png') }}" alt="Account Management" class="img-fluid mb-4">
                <a href="{{ route('user.profile') }}" class="btn btn-logo">My Account</a>
            </div>
        </div>
    </div>
</section>
<section class="steps-section section-five bg-white">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <!-- Left Side with Steps -->
            <div class="col-lg-6 mb-lg-0">
                <h2 class="fw-bold text-dark mb-2">Monitor Tickets</h2>
                <h6 class="text-dark">You can easily check the progress of your submitted requests:</h6>
                <div class="steps mt-4">
                    <div class="step bg-success-subtle mb-3">
                        <div class="step-icon bg-indi">1</div>
                        <p class="mb-0 ms-3">
                            My Requests

                            <small class="fw-light d-block mt-2 mb-2">Go to My Requests to see the list of tickets
                                you’ve submitted.</small>
                        </p>
                    </div>
                    <div class="step bg-success-subtle mb-3">
                        <div class="step-icon bg-indi">2</div>
                        <p class="mb-0 ms-3">
                            Check Ticket Status

                            <small class="fw-light d-block mt-2 mb-2">View the status of each ticket, including whether
                                it’s unassigned, assigned, in progress, waiting for a response, invalid, forwarded to
                                CITC, completed, or closed.</small>
                        </p>
                    </div>
                </div>
            </div>
            <!-- Right Side with Image and Button -->
            <div class="col-12 col-sm-9 col-md-7 col-lg-5 mx-auto text-center">
                <img src="{{ asset('img/monitor-tickets.png') }}" alt="Account Management" class="img-fluid mb-4">
                <a href="{{ route('requestor.my-requests') }}" class="btn btn-logo">My Requests</a>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the boxes and corresponding sections
        const gettingStartedBox = document.querySelector('.section-two .box:nth-child(1)');
        const accountManagementBox = document.querySelector('.section-two .box:nth-child(2)');
        const monitorTicketsBox = document.querySelector('.section-two .box:nth-child(3)');

        const gettingStartedSection = document.querySelector('.section-three');
        const accountManagementSection = document.querySelector('.section-four');
        const monitorTicketsSection = document.querySelector('.section-five');

        // Add click event listeners
        gettingStartedBox.addEventListener('click', function() {
            gettingStartedSection.scrollIntoView({
                behavior: 'smooth'
            });
        });

        accountManagementBox.addEventListener('click', function() {
            accountManagementSection.scrollIntoView({
                behavior: 'smooth'
            });
        });

        monitorTicketsBox.addEventListener('click', function() {
            monitorTicketsSection.scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const backToTopButton = document.getElementById('backToTop');

        // Show button when scrolled down 200px
        window.addEventListener('scroll', function() {
            if (window.scrollY > 200) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });

        // Scroll to top when the button is clicked
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>

<!-- //----------------changesssss------------- -->
<script>
    function openModal() {
        document.getElementById('welcomeModal').style.display = 'block';
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById('welcomeModal').style.display = 'none';
    }

    // Get the modal element and close button
    var modal = document.getElementById('welcomeModal');
    var closeButton = document.querySelector('.close-button');

    closeButton.onclick = function() {
        closeModal();
    }
</script>
@endsection
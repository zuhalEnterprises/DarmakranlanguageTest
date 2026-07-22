<style>
    .footer-background {

        flex-shrink: 0;
        background: url('/img/site4/footer1.jpg');
        background-color: #000;
        background-repeat: repeat;
        background-size: 28px 28px;

    }
</style>
<footer class="footer pt-5 footer-background">
    <div class="container">
        <!-- Links-->
        <div class="row pb-md-2 pb-lg-3 g-lg-5">
            <div class="col-lg-3 mb-4">
                <a class="d-inline-block mb-4 fs-2 text-decoration-none text-white" href="/">
                    <!-- <img src="/img/site4/logo.jpg" alt="logo" width="116"> -->
                    {{ss('SITE_NAME')}}
                </a>

                <div class="pt-2">
                    <a class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle me-2 mb-2" href="#">
                        <i class="fi-facebook"></i>
                    </a>
                    <a class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle me-2 mb-2" href="#">
                        <i class="fi-twitter"></i>
                    </a>
                    <a class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle me-2 mb-2" href="https://www.instagram.com/{{ env('APP_URL') }}">
                        <i class="fi-instagram"></i>
                    </a>
                    <a class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle me-2 mb-2" href="#">
                        <i class="fi-telegram"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-6 mb-4 text-lg-center">
                <h4 class="h5 text-white">Quick Links</h4>
                <ul class="nav flex-column ">
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white p-0 fw-normal" href="/add">Add Property</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white p-0 fw-normal" href="/c/dubai?type=1">Sell a property</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white p-0 fw-normal" href="/c/dubai?type=1">Rent a
                            property</a></li>


                </ul>
            </div>

            <div class="col-lg-3 mb-4 text-left">
                <h4 class="h5 text-white">About</h4>
                <p class="mb-0  text-justify text-white">
                    We have strived to make our clients' real estate needs easy, enjoyable, and quick to fulfill by employing cutting-edge methods, including specialized training for our consultants, utilizing experienced legal professionals, and providing up-to-date amenities on our website.
                </p>
            </div>
         </div>


    </div>
    <div class="text-center fs-sm pt-4 pb-2 text-white-50">© All rights of this site are reserved.
    </div>
</footer>

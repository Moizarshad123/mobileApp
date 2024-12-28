<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{env('APP_NAME')}} Admin</title>
    <meta name="csrf-token" content="{{csrf_token()}}">


    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/core.css') }}" class="template-customizer-core-css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('admin/assets/vendor/js/helpers.js')}}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('admin/assets/js/config.js')}}"></script>


    <!-- summernote -->
    <link rel="shortcut icon" type="image/jpg" href="{{ asset('admin/assets/img/logo.png')}}" />
    <link href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{asset('admin/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @yield('css')

</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo" style="margin-bottom: 24px">
                    <a href="{{ url('admin/dashboard') }}" class="app-brand-link" style="margin-bottom: 10px;"  >
                        {{-- <img src="{{ asset('admin/assets/img/logo.png') }}" alt=""  width="200px" height="70px"> --}}
                    </a>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>
                @include('admin.partials.sidebar')
            </aside>
            <!-- / Menu -->

            <div class="layout-page">
            <!-- Navbar -->
            <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                id="layout-navbar">
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="bx bx-menu bx-sm"></i>
                    </a>
                </div>

                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <!-- Search -->
                    {{-- <div class="navbar-nav align-items-center">
                        <div class="nav-item d-flex align-items-center">
                            <i class="bx bx-search fs-4 lh-0"></i>
                            <input type="text" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search..." />
                        </div>
                    </div> --}}
                    <!-- /Search -->

                    <ul class="navbar-nav flex-row align-items-center ms-auto">
                        <!-- Place this tag where you want the button to render. -->
                        <li class="nav-item lh-1 me-3">
                            <a class="github-button" href="{{ url('admin/dashboard') }}"
                                data-icon="octicon-star" data-size="large" data-show-count="true"
                                aria-label="Star themeselection/sneat-html-admin-template-free on GitHub">{{ Auth::user()->name}}</a>
                        </li>

                        <!-- User -->
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <img src="{{ asset('admin/assets/img/avatars/1.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar avatar-online">
                                                    <img src="{{ asset('admin/assets/img/avatars/1.png')}}" alt
                                                        class="w-px-40 h-auto rounded-circle" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="fw-semibold d-block">EI APP</span>
                                                <small class="text-muted">Admin</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                {{-- <li>
                                    <div class="dropdown-divider"></div>
                                </li> --}}
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.changePassword') }}">
                                        <i class="bx bx-user me-2"></i>
                                        <span class="align-middle">Change Password</span>
                                    </a>
                                </li>
                                 {{--<li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bx bx-cog me-2"></i>
                                        <span class="align-middle">Settings</span>
                                    </a>
                                </li> --}}
                                {{-- <li>
                                    <div class="dropdown-divider"></div>
                                </li> --}}
                                <li>
                                    <a class="dropdown-item" href="{{route('admin.logout')}}">
                                        <i class="bx bx-power-off me-2"></i>
                                        <span class="align-middle">Log Out</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--/ User -->
                    </ul>
                </div>
            </nav>
            <!-- / Navbar -->
            <div class="content-wrapper">
                @yield('content')
                <!-- Footer -->
                
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('admin/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('admin/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('admin/assets/js/dashboards-analytics.js') }}"></script>

    <!-- jQuery -->
    <script src="{{asset('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin/plugins/toastr/toastr.min.js')}}"></script>

    @if(Session::has('success'))
        <script type="text/javascript">
            toastr.success('{{ Session::get("success")}}');

        </script>
    @endif
    @if(Session::has('error'))
        <script type="text/javascript">
            toastr.error("{{ Session::get('error')}}");

        </script>
    @endif

    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        
        // Your web app's Firebase configuration
        //const firebaseConfig = {
            //apiKey: "AIzaSyCHBOmN-DUkrXstnZG1WNXp6EGuzMuAbMg",
            //authDomain: "side-hustle-763af.firebaseapp.com",
            //projectId: "side-hustle-763af",
            //storageBucket: "side-hustle-763af.appspot.com",
            //messagingSenderId: "35016346526",
            //appId: "1:35016346526:web:4a1a6090809a4e5cb1a48f"
        //};

        const firebaseConfig = {
            apiKey: "AIzaSyBpf6y0tF-8AI-EA33lKyfbgzISTwBA90g",
            authDomain: "side-hustle-app-f1cb7.firebaseapp.com",
            projectId: "side-hustle-app-f1cb7",
            storageBucket: "side-hustle-app-f1cb7.appspot.com",
            messagingSenderId: "158889797902",
            appId: "1:158889797902:web:ca7c30393cd7cb70970f5f",
            measurementId: "G-08PV8SJDM5"
        };

        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);

        const messaging = firebase.messaging();

        function initFirebaseMessagingRegistration() {
            messaging.requestPermission().then(function () {
                return messaging.getToken()
            }).then(function(token) {

                axios.post("{{ route('fcmToken') }}",{
                    _method:"PATCH",
                    token
                }).then(({data})=>{
                    console.log(data)
                }).catch(({response:{data}})=>{
                    console.error(data)
                })

            }).catch(function (err) {
                console.log(`Token Error :: ${err}`);
            });
        }

        initFirebaseMessagingRegistration();
        let body = "Test Body";
        let title = "Test Title";
        messaging.onMessage(function({data:{body,title}}){
            new Notification(title, {body});
        });

    </script>
    @yield('js')
</body>
</html>

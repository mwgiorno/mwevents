<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="hold-transition sidebar-mini" x-data="init()">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" x-data={}>
                            @csrf

                            <a class="nav-link" @click.prevent="logout()" href="{{ route('logout') }}">
                                {{ Auth::user()->username }}
                                (Log out <i class="fa-solid fa-right-from-bracket"></i>)
                            </a>
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="#" class="brand-link">
                <img src="/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">WEvents</span>
                </a>
            
                <!-- Sidebar -->
                <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                    <img src="/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->getFullname() }}</a>
                    </div>
                </div>
            
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-calendar"></i>
                        <p>
                            All Events
                            <i class="right fas fa-angle-left"></i>
                        </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <template x-for="event in events">
                                <li class="nav-item">
                                    <a href="#" class="nav-link" @click.prevent="loadEvent(event.id)">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p x-text="event.title"></p>
                                    </a>
                                </li>
                            </template>
                        </ul>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa-solid fa-address-book"></i>
                        <p>
                            My Events
                            <i class="right fas fa-angle-left"></i>
                        </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <template x-for="event in myEvents">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p x-text="event.title"></p>
                                    </a>
                                </li>
                            </template>
                        </ul>
                    </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>
            
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Event Details</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Event Details</li>
                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
            
                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <template x-if="activeEvent">
                                <div class="col-lg-6">                        
                                    <div class="card card-primary card-outline">
                                        <div class="card-body">
                                            <h5 class="card-title text-lg text-bold mb-2" x-text="activeEvent.title"></h5>
                            
                                            <p class="card-text mb-0">
                                                Description:
                                                <span x-text="activeEvent.description"></span>
                                            </p>
                                            <p class="card-text">
                                                Date:
                                                <span x-text="activeEvent.created_at"></span>
                                            </p>

                                            <p class="card-text text-lg text-bold mb-1">Participants</p>
                                            
                                            <template x-for="participant in activeEvent.participants">
                                                <p class="m-0">
                                                    <a href="#" @click.prevent="activeParticipant=participant">
                                                        <span x-text="participant.firstname"></span>
                                                        <span x-text="participant.lastname"></span>
                                                    </a>
                                                </p>
                                            </template>

                                            <template x-if="canJoin(activeEvent)">
                                                <p class="mt-4">
                                                    <button @click="join(activeEvent.id)" type="button" class="btn btn-outline-primary">Join The Event</button>
                                                </p>
                                            </template>

                                            <template x-if="!canJoin(activeEvent)">
                                                <p class="mt-4">
                                                    <button @click="withdraw(activeEvent.id)" type="button" class="btn btn-outline-danger">Withdraw From The Event</button>
                                                </p>
                                            </template>
                                        </div>
                                    </div><!-- /.card -->
                                </div>
                            </template>

                            <template x-if="activeParticipant">
                                <div class="col-lg-6">                        
                                    <div class="card card-primary card-outline">
                                        <div class="card-body">
                                            <h5 class="card-title text-lg text-bold mb-2">Participant Info</h5>
                                            <p class="card-text mb-0">
                                                Fullname: 
                                                <span x-text="activeParticipant.firstname"></span>
                                                <span x-text="activeParticipant.lastname"></span>
                                            </p>
                            
                                            <p class="card-text">
                                                Username: 
                                                <span x-text="activeParticipant.username"></span>
                                            </p>
                                        </div>
                                    </div><!-- /.card -->
                                </div>
                            </template>
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
                <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
                </div>
            </aside>
            <!-- /.control-sidebar -->
            
            <!-- Main Footer -->
            <footer class="main-footer">
                <!-- To the right -->
                <div class="float-right d-none d-sm-inline">
                Anything I want
                </div>
                <!-- Default to the left -->
                <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
            </footer>
        </div>
        <!-- ./wrapper -->

        <script>
            function init() {
                return {
                    user: {{ Auth::user()->id }},
                    activeEvent: null,
                    activeParticipant: null,
                    events: [],
                    myEvents: [],
                    eventRefreshInterval : null,
                    init() {
                        this.loadAllEvents();
                        this.loadMyEvents();
                        this.startEventsReload();
                    },
                    loadAllEvents() {
                        axios.get('/api/events')
                            .then((response) => {
                                this.events = response.data.result;
                            }) .catch((error) => {
                                console.log(error);
                            });
                    },
                    loadMyEvents() {
                        axios.get('/api/user/events')
                            .then((response) => {
                                this.myEvents = response.data.result;
                            }) .catch((error) => {
                                console.log(error);
                            });
                    },
                    loadEvent(event) {
                        this.stopEventRefresh()
                        this.loadEventDetails(event);
                        this.activeParticipant = null;
                        this.startEventRefresh(event);
                        
                    },
                    loadEventDetails(event) {
                        axios.get(`/api/events/${event}`)
                            .then((response) => {
                                this.activeEvent = response.data.result;
                            }) .catch((error) => {
                                console.log(error);
                            });                        
                    },
                    async join(event) {
                        await axios.put(`/api/events/${event}/join`)
                            .then((response) => {
                                console.log(response.data);
                            }).catch((error) => {
                                console.log(error);
                            })
                        this.loadEvent(event);
                    },
                    async withdraw(event) {
                        await axios.put(`/api/events/${event}/withdraw`)
                            .then((response) => {
                                console.log(response.data);
                            }).catch((error) => {
                                console.log(error);
                            })
                        this.loadEvent(event);
                    },
                    hasAlreadyJoined(event) {
                        return event.participants.some((participant) => participant.id == this.user);
                    },
                    canJoin(event) {
                        return !this.hasAlreadyJoined(event); 
                    },
                    startEventRefresh(event) {
                        this.eventRefreshInterval = setInterval(() => {
                            this.loadEventDetails(event)
                        }, 8000);
                    },
                    stopEventRefresh() {
                        if (this.eventRefreshInterval) clearInterval(this.eventRefreshInterval);
                    },
                    startEventsReload() {
                        this.eventRefreshInterval = setInterval(() => {
                            this.loadAllEvents()
                        }, 8000);
                    },
                    
                }
            };
            function logout() {
                axios.post('/logout').then((response) => {
                    window.location.href = '/login';
                }).catch((error) => {
                    console.log(error);
                });
            }
        </script>
        
    </body>

</html>
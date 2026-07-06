<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="adminHMD professional admin dashboard template">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title')</title>

  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <style>
    .btn.btn-follow-up {
        background-color: #00ff2454;
    }
    .btn.btn-not-interested {
        background-color: #ff0808db;
    }
    .btn.btn-busy {
        background-color: #00b6ff54;
    }
    .pm-whatsapp-btn {
        width: 40px;
        height: 40px;
        border: 1px solid #7ED957;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        color: #25D366;
        font-size: 24px;
        text-decoration: none;
        transition: all .3s ease;
    }
    .pm-view-btn {
        width: 40px;
        height: 40px;
        border: 1px solid #008fff70;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        color: #008fff;
        font-size: 24px;
        text-decoration: none;
        transition: all .3s ease;
    }
    .pm-delete-btn {
        width: 40px;
        height: 40px;
        border: 1px solid #ff5f5f70;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        color: #ff5f5f;
        font-size: 24px;
        text-decoration: none;
        transition: all .3s ease;
    }
  </style>

</head>

<body>
  <div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>
    @include('layouts.partials.left_nav')

    <div class="admin-main">

      @include('layouts.partials.header')

      <main class="dashboard-content">

        @yield('content')

      </main> 

      @include('layouts.partials.footer')
    </div>
  </div>
 <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>

<!-- Notyf -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<!-- iziToast -->
<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>

<!-- Your custom JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@yield('scripts')

</body>
</html>

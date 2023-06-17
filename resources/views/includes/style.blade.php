
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/lineicons.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/materialdesignicons.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .sidebar-nav-wrapper {
        overflow-y: auto;
    }
    /* select 2 */
    .selection {
        width: 100%;
    }
    .datepicker {
    z-index: 9999 !important; /* Atur z-index lebih tinggi dari modal Bootstrap */
}
     /* toast */
    @media (max-width: 576px) {
        .toast-not-found {
            padding: 0 !important;
            width: 100% !important;
        }
        .toast {
        width: 100% !important;
        }
    }
</style>
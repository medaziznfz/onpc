<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="ONPC app">
  <meta name="author" content="onpc">


  <title>الوقاية - إدارة السلامة</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="{{ asset('assets/css/custom/custom.css') }}">
  



  <!-- End fonts -->
  
  

  <!-- core:css -->
  <link rel="stylesheet" href="{{ asset('assets/vendors/core/core.css') }}">
  <!-- endinject -->

  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
  <!-- End plugin css for this page -->

  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
  <!-- endinject -->

  <!-- Layout styles -->  
  <link rel="stylesheet" href="{{ asset('assets/css/demo3/style-rtl.css') }}">
  <!-- End layout styles -->

  <!-- Custom CSS Section -->
  @stack('styles')

  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
</head>
<body>
  <div class="main-wrapper">
    
    {{-- Include the Navbar Partial --}}
    @include('partials.navbar')

    <div class="page-wrapper">
      <div class="page-content">
        @stack('content')
      </div>

      {{-- Include the Footer Partial --}}
      @include('partials.footer')
    </div>
  </div>

  <!-- core:js -->
  <script src="{{ asset('assets/vendors/core/core.js') }}"></script>
  <!-- endinject -->

  <!-- inject:js -->
  <script src="{{ asset('assets/vendors/feather-icons/feather.min.js') }}"></script>
  <script src="{{ asset('assets/js/template.js') }}"></script>
  <!-- endinject -->

  <!-- Custom js for this page -->
  <script src="{{ asset('assets/js/dashboard-light.js') }}"></script>
  <!-- End custom js for this page -->

  <script>
    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => {
            if (response.ok) {
                // Remove the unread background using data attribute
                const notificationElement = document.querySelector(`a[data-notification-id="${notificationId}"]`);
                if (notificationElement) {
                    notificationElement.classList.remove('bg-light');
                }

                // Update the notification count text
                const countElement = document.querySelector('.px-3.py-2 p');
                if (countElement) {
                    const currentCount = parseInt(countElement.textContent.match(/\d+/)[0]);
                    const newCount = currentCount - 1;
                    countElement.textContent = `${newCount} New Notifications`;
                }
            }
        });
    }

    function markAllAsRead() {
        fetch('/notifications/mark-all-as-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => {
            if (response.ok) {
                // Remove all unread backgrounds
                document.querySelectorAll('.dropdown-item.bg-light').forEach(element => {
                    element.classList.remove('bg-light');
                });

                // Update the notification count text to zero
                const countElement = document.querySelector('.px-3.py-2 p');
                if (countElement) {
                    countElement.textContent = '0 New Notifications';
                }

                // Reload the page
                window.location.reload();
            }
        });
    }
</script>

<!-- Custom JS Section -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@stack('scripts')

</body>
</html>

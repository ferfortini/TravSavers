 <!-- Bootstrap JS -->
 <script src="../assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
 
 <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
 <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
 <!-- Vendor -->
 <script src="../assets/vendor/apexcharts/js/apexcharts.min.js"></script>
 <script src="../assets/vendor/choices/js/choices.min.js"></script>
 <script src="../assets/vendor/flatpickr/js/flatpickr.min.js"></script>
 <script src="../assets/js/functions.js"></script>
 <script>
     $(document).ready(function() {
         function toggleHotelFields() {
             const selected = $('#use_hotel_api').val();

             if (selected === 'No') {
                 $('#hotel-selector-wrapper').collapse('show');
                 $('#hotel-display-rule').addClass('d-none');
                 $('#location-selector-wrapper').addClass('d-none');
             } else {
                 $('#hotel-selector-wrapper').collapse('hide');
                 $('#hotel-display-rule').removeClass('d-none');
                 $('#location-selector-wrapper').removeClass('d-none');
             }
         }

         // Run on dropdown change
         $('#use_hotel_api').on('change', toggleHotelFields);

         // Also run on page load in case "No" is preselected
         toggleHotelFields();
     });
 </script>
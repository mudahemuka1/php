</div>
<footer class="bg-light border-top py-4 mt-5">
  <div class="container text-center small">
    <div>Contact: rpkarongi@example.com | +250 000 000</div>
    <div>&copy; <?php echo date('Y'); ?> RP Karongi Library</div>
  </div>
</footer>
<script src="/catphp/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
<script>
// Enable Bootstrap validation styles on forms with .needs-validation
(function () {
  'use strict';
  var forms = document.querySelectorAll('.needs-validation');
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>
</body>
</html>

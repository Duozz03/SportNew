</div> <!-- .content -->
</div> <!-- .container -->
</main>

<footer class="border-top bg-white py-3 mt-4">
    <div class="container text-center text-muted small">
        © <?= date('Y') ?> - Tin tức thể thao
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  (function() {
    const header = document.querySelector('.header');
    if (!header) return;

    function onScroll() {
      if (window.scrollY > 6) header.classList.add('is-scrolled');
      else header.classList.remove('is-scrolled');
    }

    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  })();
</script>

</body>
</html>

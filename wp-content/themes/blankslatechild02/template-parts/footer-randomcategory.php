<div class="roundedrectangle">
  <footer>
    <p><a href="https://andresanz.com/countdown/" style="color: black;">&copy;</a> <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>





  </footer>



  <?php wp_footer(); ?>
</div>
</div> <!-- end .container -->

<a id="back-to-top" href="#">
  <span class="arrow">↑</span>
</a>

<script>
document.addEventListener("scroll", () => {
  const btn = document.getElementById("back-to-top");
  if (window.scrollY > 300) btn.classList.add("visible");
  else btn.classList.remove("visible");
});
</script>

</body>

</html>
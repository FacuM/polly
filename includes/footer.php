   <div class="ajax_indicator valign-wrapper center-align z-depth-1">
     <!-- A oneline version of the preloader from the docs: https://materializecss.com/preloader.html -->
     <div class="preloader-wrapper small active"><div class="spinner-layer"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>
   </div>
  </main>
  <footer>
  </footer>
  <!-- MaterializeCSS script -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <!-- Common scripts -->
  <script src="assets/scripts/common.js"></script>
  <!-- Bringup definitions for mAtime_short and mAtime_long -->
  <script>
   var mAtime_short = <?php echo $atime['short']; ?>;
   var mAtime_long  = <?php echo $atime['long']; ?>;
   var mChatUrate = <?php echo $chat_urate; ?>
  </script>
 </body>
</html>

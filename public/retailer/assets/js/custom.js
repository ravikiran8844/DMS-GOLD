// $(function() {
//     $('#main-menu').smartmenus({
//       subMenusSubOffsetX: 1,
//       subMenusSubOffsetY: -8
//     });
//   });

//   $(function() {
//     $('#mobile-main-menu').smartmenus({
//       subMenusSubOffsetX: 1,
//       subMenusSubOffsetY: -8
//     });
//   });

  const preloader = document.getElementById('preloader');

  window.addEventListener('load', function () {
    if (preloader) {
      // Show the preloader
      preloader.style.display = 'flex';
  
      // Set a minimum display time (1 second in this example)
      const minimumDisplayTime = 100;
  
      // Get the start time
      const startTime = new Date().getTime();
  
      // Calculate the time to wait before hiding the preloader
      const delayTime = Math.max(0, minimumDisplayTime - (new Date().getTime() - startTime));
  
      // Hide the preloader after the minimum display time
      setTimeout(function () {
        preloader.style.display = 'none';
      }, delayTime);
    }
  });

  

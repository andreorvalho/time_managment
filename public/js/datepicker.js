if (typeof jQuery === 'undefined') {
  throw new Error('JQuery needs to be defined')
}

+function ($) {
  $(document).ready(function() {
      $('#datetimepicker1').datetimepicker();
      console.log("sdasdas");
  });
}(jQuery);


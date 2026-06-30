(function ($) {
  var DayJobsNightlife = {
    common: {
      init: function () {
        $('.btn-search').on('click', function () {
          var $button = $(this);
          var $search = $('#site-search');
          var isOpen = !$search.prop('hidden');

          $search.prop('hidden', isOpen);
          $button.attr('aria-expanded', !isOpen);

          if (!isOpen) {
            $search.find('input[type="text"], input[type="search"]').first().trigger('focus');
          }
        });
      },
    },
  };

  var UTIL = {
    fire: function (func, funcname, args) {
      var namespace = DayJobsNightlife;
      funcname = funcname === undefined ? 'init' : funcname;

      if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function () {
      UTIL.fire('common');

      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function (i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      UTIL.fire('common', 'finalize');
    },
  };

  $(document).ready(UTIL.loadEvents);
})(jQuery);

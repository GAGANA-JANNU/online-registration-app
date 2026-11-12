$(function () {
  const $form = $('#registrationForm');
  if (!$form.length) return;

  // Client-side validation using jQuery; PHP validates again on the server.
  $form.on('submit', function (event) {
    let valid = true;
    $('.field input, .field select, .field textarea').removeClass('invalid');

    $form.find('[required]').each(function () {
      const value = $(this).val();
      if ($(this).attr('type') === 'checkbox' ? !this.checked : !String(value || '').trim()) {
        $(this).addClass('invalid');
        valid = false;
      }
    });

    const email = $('#email').val();
    if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      $('#email').addClass('invalid');
      valid = false;
    }

    if (!valid) {
      event.preventDefault();
      const $first = $('.invalid').first();
      if ($first.length) $first.trigger('focus');
      alert('Please complete all required fields with valid information.');
    }
  });
});

$(document).ready(function () {
  $('.modal').modal();
});

$('.modal-btn').click(function () {
  var target = '.' + $(this).attr('target');
  if ($(target).css("display") != 'block') {
    $(target).show();
    $('.modal').css('z-index', '100');
    $('.black').css('display', 'block');
  }
});

$('.copy-btn').click(function (event) {
  var thisTarget = $(this).attr('target');
  var value = $('#' + thisTarget).val();
  copyText(value);
  $(event.target).popover('show');
  setTimeout(function () {
    $(event.target).popover('hide');
  }, 700);
});

function copyText(text) {
  // Create the textarea input to hold our text.
  const element = document.createElement('textarea');
  element.value = text;
  // Add it to the document so that it can be focused.
  document.body.appendChild(element);
  // Focus on the element so that it can be copied.
  element.focus();
  element.setSelectionRange(0, element.value.length);
  // Execute the copy command.
  document.execCommand('copy');
  // Remove the element to keep the document clear.
  document.body.removeChild(element);
}

$(document).mouseup(function (e) {
  var container = $('.modal');
  if (!container.is(e.target) && container.has(e.target).length === 0) {
    container.hide();
    $('.black').css('display', 'none');
  }
});

$(document).on('keydown', function (e) {
  if (e.keyCode === 27) {
    $('.modal').hide();
    $('.black').css('display', 'none');
  }
});

$('.modal-close').click(function () {
  $('.modal').hide();
  $('.black').css('display', 'none');
});
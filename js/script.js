$(document).ready(function(){
  $('.modal').modal();
});

$('.team-btn').click(function (){
  var target = '.' + $(this).attr('target');
  if($(target).css("display") != 'block') {
    $(target).fadeIn();
  }
  else {
    $(target).fadeOut();
  }
});

$('.copy-btn').click(function(e) {
  var target = $(this).attr('target');
  var value = $('#'+target).val();
  copyText(value);
  alert('Team saved in clipboard !')
});

function copyText (text) {
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


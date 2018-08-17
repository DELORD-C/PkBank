$.fn.modal = function () {
  $('.tab-element').click(function () {
    $('.tab-element').each(function () {
      this.classList.remove('active')
      var hidden = '.' + this.getAttribute('data-target')
      $(hidden).fadeOut()
    })
    this.classList.add('active')
    var target = '.' + this.getAttribute('data-target')
    setTimeout(function() {
      $(target).fadeIn();
      $(target).css('display', 'flex');
    }, 500);
  })

  $('.tab-element').each(function () {
    this.classList.forEach(classes => {
      if (classes === 'active') {
        var targetshow = '.' + this.getAttribute('data-target')
        // $(targetshow).show();
        $(targetshow).css('display', 'grid');
      }
    })
  })

  function TabListColumns () {
    var nbr = ($('.tab-list')[0].getElementsByTagName('li')).length;
    var cssinput = ''
    for (var i = 0; i < nbr; i++) {
      cssinput += '1fr '
    }
    $('.tab-list')[0].style.gridTemplateColumns = cssinput
  }

  // function ContainerColumns (objet) {
  //   var nbr = ((objet.childNodes[1].childNodes.length - 1) / 2)
  //   var cssinput = ''
  //   for (var i = 0; i < nbr; i++) {
  //     cssinput += '1fr '
  //   }
  //   objet.childNodes[1].style.gridTemplateColumns = cssinput;
  // }

  TabListColumns ();
}

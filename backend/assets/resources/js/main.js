jQuery(document).ready(function ($) {
  let $body = $('body');
  
  $body.on('click', '.js-create-apple', function (e) {
    e.preventDefault();
    
    $.ajax({
      url: '/admin/site/create/',
      type: 'GET',
      data: {
        color: $('.js-color-plant-choise').val(),
      },
      success: function (res) {
        $('.js-plant-card-wrap').append(res);
      },
      error: function (jqXHR, exception) {
      
      },
    });
  });
  
  $body.on('click', '.js-plant-eat-btn', function (e) {
    e.preventDefault();
    
    let $this = $(this);
    
    $.ajax({
      url: '/admin/site/eat/',
      type: 'GET',
      data: {
        id: $(this).data('id'),
        percent: $this.parents('.card').find('.js-eat-percent').val(),
      },
      success: function (res) {
        if (res.status === 'error') {
          alert(res.message);
        } else {
          $this.parents('.card').html(res);
        }
      },
      error: function (jqXHR, exception) {
      },
    });
  });
  
  $body.on('click', '.js-plant-fall-btn', function (e) {
    e.preventDefault();
    
    let $this = $(this);
    
    $.ajax({
      url: '/admin/site/fall/',
      type: 'GET',
      data: {
        id: $this.data('id'),
      },
      success: function (res) {
        $this.parents('.card').html(res);
      },
      error: function (jqXHR, exception) {
      
      },
    });
  });
});

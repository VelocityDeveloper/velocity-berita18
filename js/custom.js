jQuery(function($) {
    $('.post-carousel-4').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      arrows: true,
      focusOnSelect: true,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3
          }
        },
        {
          breakpoint: 700,
          settings: {
            slidesToShow: 2
          }
        },
        {
          breakpoint: 580,
          settings: {
            slidesToShow: 1
          }
        }
        ]
    });
    $('.post-carousel-3').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      arrows: true,
      focusOnSelect: true,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3
          }
        },
        {
          breakpoint: 700,
          settings: {
            slidesToShow: 2
          }
        },
        {
          breakpoint: 580,
          settings: {
            slidesToShow: 1
          }
        }
        ]
    });
});
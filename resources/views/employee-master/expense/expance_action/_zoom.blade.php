 
<!-- Bootstrap -->
<link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="/dist/jquery.magnify.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
    .magnify-modal {
        box-shadow: 0 0 6px 2px rgba(0, 0, 0, .3);
    }

    .magnify-header .magnify-toolbar {
        background-color: rgba(0, 0, 0, .5);
    }

    .magnify-stage {
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        border-width: 0;
    }

    .magnify-footer .magnify-toolbar {
        background-color: rgba(0, 0, 0, .5);
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    .magnify-header,
    .magnify-footer {
        pointer-events: none;
    }

    .magnify-button {
        pointer-events: auto;
    }
</style>
</head>

<body dir="ltr">
    <div class="container">
        <div class="image-set">
            <a data-magnify="gallery" data-caption="Rémi Bizouard triple champion du monde by malainxx24"
               href="https://farm5.staticflickr.com/4267/34162425794_1430f38362_z.jpg">
                <img src="https://farm5.staticflickr.com/4267/34162425794_1430f38362_s.jpg" alt="">
            </a>
            <a data-magnify="gallery" data-caption="Audi RS 5 DTM by Lyudmila Izmaylova"
               href="https://farm1.staticflickr.com/4160/34418397675_18de1f7b9f_z.jpg">
                <img src="https://farm1.staticflickr.com/4160/34418397675_18de1f7b9f_s.jpg" alt="">
            </a>
            <a data-magnify="gallery"
               data-caption="Paraglider flying over Aurlandfjord, Norway by framedbythomas"
               href="https://farm1.staticflickr.com/512/32967783396_a6b4babd92_z.jpg">
                <img src="https://farm1.staticflickr.com/512/32967783396_a6b4babd92_s.jpg" alt="">
            </a>
        </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/dist/jquery.magnify.js"></script>
    <script>
        $('[data-magnify]').magnify({
            headerToolbar: [
                'close'
            ],
            footerToolbar: [
                'zoomIn',
                'zoomOut',
                'prev',
                'fullscreen',
                'next',
                'actualSize',
                'rotateRight'
            ],
            title: false
        });

    </script>

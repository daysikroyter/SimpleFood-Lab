<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Food | @yield('title')</title>
    <link rel="icon" href="{{ asset('assets/images/icons/favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}">
</head>

<body>

    @include('partials.header')

    <main class="main">
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="{{ asset('assets/js/main.min.js') }}"></script>

    <script>
        $(function() {
            $('.product__form-star').each(function() {
                const $star = $(this);
                const $form = $star.closest('form');
                const $inputRating = $form.find('input[name="rating"]');

                const initialRating = parseFloat($star.data('current-rating')) || 5;

                $star
                    .rateYo({
                        rating: initialRating,
                        fullStar: false, 
                        halfStar: true, 
                        precision: 1, 
                        starWidth: "20px",
                        normalFill: "#C4C4C4",
                        ratedFill: "#FFB800",
                        spacing: "3px"
                    })
                    .on("rateyo.set", function(e, data) {
                        $inputRating.val(data.rating);
                    });
            });

            $('.product__star').each(function() {
                const rating = parseFloat($(this).data('rateyo-rating')) || 0;

                $(this).rateYo({
                    rating: rating,
                    readOnly: true,
                    starWidth: "20px",
                    normalFill: "#C4C4C4",
                    ratedFill: "#FFB800",
                    spacing: "3px"
                });
            });

            $('.star').each(function() {
                const rating = parseFloat($(this).data('rateyo-rating')) || 0;

                $(this).rateYo({
                    rating: rating,
                    readOnly: true,
                    starWidth: "20px",
                    normalFill: "#C4C4C4",
                    ratedFill: "#FFB800",
                    spacing: "3px"
                });
            });
        });
    </script>
</body>

</html>

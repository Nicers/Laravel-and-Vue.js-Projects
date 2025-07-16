<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product PDF</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <style>
        @font-face {
            font-family: 'AEDRegular';
            src: url("fonts/aed-Regular.ttf") format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        .font-aed {
            font-family: "AEDRegular";
        }

        body {
            width: 100%;
            padding-bottom: 5rem;
            margin: 0;
        }


        .main-container {
            width: 100%;
            margin: auto;
            max-width: 100%;
        }

        .product-box {
            width: 100%;
            height: auto;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.24);
            border-radius: 5px;
            margin: auto;
            margin-top: 3rem;
            padding: 0 2rem 2rem 0;
            overflow: hidden;
        }

        
        .float-left {
            float: left;
        }

        .float-right {
            float: right;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        .col-33 {
            width: 33.33333333%;
        }

        .col-66 {
            width: 66.66666667%;
        }

        .image-thumb-wrapper {
            margin: 1rem 0;
            text-align: center;
        }

        .image-thumb {
            display: inline-block;
            margin: 0 2px;
            vertical-align: top;
        }


        .related-products-container {
            margin-top: 1rem;
        }

        .related-card {
            box-shadow: 0 2px 8px rgba(99, 99, 99, 0.2);
            padding: .8rem 2rem .8rem 1rem;
            border-radius: 5px;
            width: 100%;
            height: 7rem;
            box-sizing: border-box;
        }

        .related-card-image {
            width: 30%;
            float: left;
            margin-right: 5%;
        }

        .related-card-content {
            width: 65%;
            float: left;
        }

        h3 {
            letter-spacing: 0.2rem;
            font-weight: bold;
            color: #32393f;
            margin: 0 0 .5rem 0;
        }

        p {
            font-size: 1rem;
            margin-bottom: 1rem;
            color: #4c5258;
        }

        hr {
            margin: 1rem 0;
            border: 0;
            border-top: 1px solid #eee;
        }

        .rating {
            color: #ffc107;
            font-size: 14px;
            display: inline-block;
        }

        .info-row {
            display: block;
            margin-bottom: 0.5rem;
        }

        .info-row b {
            display: inline-block;
            width: 60px;
        }

        .info-row p {
            display: inline-block;
            margin: 0;
        }
    </style>
</head>

<body style='width:100%; padding-bottom:5rem; margin:0;'>
    <div class="main-container">
        <div class="product-box clearfix">
            <div class="image float-left col-33" style="border-right:1px solid #dee2e6;">
                <img src="{{ public_path('frontAssets/images/products/' . $product->image) }}"
                    style="background-color:#f0f1f2; width:100%; height:auto; vertical-align:middle;" alt="">
                <div class="image-thumb-wrapper">
                    @for($i = 0; $i < 4; $i++)
                        <div class="image-thumb"><img
                                src="{{ public_path('frontAssets/images/products/' . $product->image) }}" width="70"
                                height="70" style="border-radius:5px; border:1px solid black; object-fit: cover;" alt="">
                        </div>
                    @endfor
                </div>
            </div>

            <div class="content float-left col-66" style="padding-top:1.3rem; padding-left: 1.5rem;">
                <h3 style="letter-spacing:0.2rem; font-weight:bold; color:#32393f; margin:0 0 .5rem 0;">
                    {{ $product->name }}</h3>
                <div style="margin-bottom:0.5rem;">
                    <span class="rating">&#9733;
                        <i class="fa-solid fa-star"></i> ★★★★☆</span>
                    <span style="margin-left: 10px;">142 reviews</span>
                    <span style="color:#15ca20; margin-left: 10px;">🛒 134 orders</span>
                </div>
                <div style="margin-bottom:1rem;">
                    <span style="color:#32393f; font-size:1.5rem; font-weight:bold;"><span
                            class="font-aed">AED</span>{{ $product->price }}</span>
                    <span style="color:#6c757d;">/per kg</span>
                </div>
                <p style="font-size:1rem; margin-bottom:1rem; color:#4c5258;">{{ $product->description }}</p>
                <div style="margin-bottom:1rem;">
                    <div class="info-row">
                        <b>Model#</b>
                        <p>{{ $product->model }}</p>
                    </div>
                    <div class="info-row">
                        <b>Color</b>
                        <p>{{ $product->color }}</p>
                    </div>
                    <div class="info-row">
                        <b>Delivery</b>
                        <p>Russia, USA, and Europe</p>
                    </div>
                </div>
                <hr>
            </div>

        </div>
        <div style="margin-top:2rem;">
            <h3 style="margin:0 0 .5rem 0;">Product Description</h3>
            <div>
                <p>{{ $product->description }}</p>
            </div>
        </div>

        <br><br>

        <h2 style="margin:0 0 .5rem 0;">Related Products</h2>
        <hr>

        <div class="related-products-container clearfix"> @for($i = 0; $i < 3; $i++)
            <div class="related-card">
                <div class="related-card-image">
                    <img src="{{ public_path('frontAssets/images/products/16.png') }}"
                        style="width:100%; height:100%; object-fit: cover;" alt="">
                </div>
                <div class="related-card-content">
                    <b style="display:block; margin-bottom: 0.3rem;">Light Grey Headphone</b>
                    <div class="rating" style="margin-bottom: 0.3rem;">★★★★☆</div>
                    <div>
                        <span style="color:#32393f; font-size:1.5rem; font-weight:bold;"><span
                                class="font-aed">AED</span>{{ $product->price }}</span>
                        <span style="color:#6c757d;">/per kg</span>
                    </div>
                </div>
            </div>
        @endfor
        </div>

    </div>

</body>

</html>
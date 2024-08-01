<x-main>
    <x-header />
    <section class="bg-light">
        <div class="container pb-5">
            <div class="row">
                <div class="col-lg-5 mt-5">
                    <div class="card mb-3 img-prod-bg">
                        <img class="card-img img-fluid " id="main-image" src="{{ $images[0] }}"
                            alt="{{ $product->name }}">
                    </div>
                    <div class="row">
                        <!--Start Controls-->
                        <div class="col-1 align-self-center">
                            <a href="#multi-item-example" role="button" data-bs-slide="prev">
                                <i class="text-dark fas fa-chevron-left"></i>
                                <span class="sr-only">Previous</span>
                            </a>
                        </div>
                        <!--End Controls-->
                        <!--Start Carousel Wrapper-->
                        <div id="multi-item-example" class="col-10 carousel slide carousel-multi-item card "
                            data-bs-ride="carousel">
                            <!--Start Slides-->
                            <div class="carousel-inner product-links-wap" role="listbox">
                                @foreach(array_chunk($images, 3) as $chunk)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }} ">
                                    <div class="row  img-product">
                                        @foreach($chunk as $image)
                                        <div class="col-4">
                                            <a href="#" class="thumbnail" data-image="{{ $image }}">
                                                <img class="card-img img-fluid" src="{{ $image }}" alt="Product Image">
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!--End Carousel Wrapper-->
                        <!--Start Controls-->
                        <div class="col-1 align-self-center">
                            <a href="#multi-item-example" role="button" data-bs-slide="next">
                                <i class="text-dark fas fa-chevron-right"></i>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <!--End Controls-->
                    </div>
                </div>
                <!-- col end -->
                <div class="col-lg-7 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="h2">{{ $product->name }}</h1>
                            <p class="h3 py-2">L. {{ $product->price }}</p>
                            <p class="py-2">
                                @php
                                $fullStars = floor($averageRating);
                                $halfStar = $averageRating - $fullStars > 0;
                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                @endphp
                                <!-- Show full stars -->
                                @for($i = 0; $i < $fullStars; $i++) <i class="fa fa-star text-warning"></i>
                                    @endfor

                                    <!-- Show half star if needed -->
                                    @if($halfStar)
                                    <i class="fa fa-star-half-alt text-warning"></i>
                                    @endif

                                    <!-- Show empty stars -->
                                    @for($i = 0; $i < $emptyStars; $i++) <i class="fa fa-star text-secondary"></i>
                                        @endfor

                                        <span class="list-inline-item text-dark">Calificacion {{
                                            number_format($averageRating) }} | {{ $commentCount }}
                                            Comentarios</span>
                            </p>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6>Categoria:</h6>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-muted"><strong>{{ $product->category->name ?? 'N/A' }}</strong>
                                    </p>
                                </li>
                            </ul>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6>Vendedor:</h6>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-muted"><strong>{{ $product->user->name ?? 'N/A' }}</strong></p>
                                </li>
                            </ul>
                            <h6>Descripcion:</h6>
                            <p>{{ $product->description}}</p>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                <div class="col d-grid">
                                    @csrf
                                    <button type="submit" class="btn btn-success text-white mt-2">
                                        Añadir al carrito
                                    </button>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
                <!-- Comentarios -->
                <div class="container mt-5">
                    <h2>Comentarios</h2>
                    @foreach($product->comments as $comment)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $comment->user->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $comment->created_at->format('d M Y') }}</h6>
                            <p class="card-text">{{ $comment->comment }}</p>
                            <div class="rating">
                                @for($i = 0; $i < $comment->rating; $i++) <i class="fa fa-star text-warning"></i>
                                    @endfor
                                    @for($i = $comment->rating; $i < 5; $i++) <i class="fa fa-star text-secondary"></i>
                                        @endfor
                            </div>
                        </div>
                    </div>
                    @endforeach
        
                    <!-- Formulario para agregar un nuevo comentario -->
                    <div class="card mt-3">
                        <div class="card-body">
                            <h3>Añadir un comentario</h3>
                            @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <form action="{{ route('comments.store', $product->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="rating" class="form-label">Calificación</label>
                                    <select name="rating" id="rating" class="form-control">
                                        <option value="">Seleccione una calificación</option>
                                        @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="comment" class="form-label">Comentario</label>
                                    <textarea name="comment" id="comment" class="form-control" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </form>
                        </div>
                    </div>
                </div>


    <!-- Close Content -->
    <!-- Productos Relacionados -->
    <section class="py-5">
        <div class="container">
            <div class="row text-left p-2 pb-3">
                <h4>Productos relacionados</h4>
            </div>

            <div id="carousel-related-product" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($relatedProducts->chunk(3) as $chunk)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="row">
                                @foreach($chunk as $relatedProduct)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="product-wap card rounded-0">
                                            <div class="card rounded-0">
                                                <img class="card-img rounded-0 img-fluid" src="{{ json_decode($relatedProduct->images, true)[0] }}" alt="{{ $relatedProduct->name }}">
                                                <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                                    <ul class="list-unstyled">
                                                        <li><a class="btn btn-success text-white mt-2" href="{{ route('shop.show', $relatedProduct->id) }}"><i class="far fa-eye"></i></a></li>
                                                        <li><a class="btn btn-success text-white mt-2" href="{{ route('cart.add', $relatedProduct->id) }}"><i class="fas fa-cart-plus"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <a href="{{ route('shop.show', $relatedProduct->id) }}" class="h3 text-decoration-none">{{ $relatedProduct->name }}</a>
                                                <ul class="list-unstyled d-flex justify-content-center mb-1">
                                                    <li>
                                                        <!-- Muestra estrellas basadas en la calificación -->
                                                        @php
                                                            $relatedProductRating = $relatedProduct->comments->avg('rating') ?? 0;
                                                            $fullStars = floor($relatedProductRating);
                                                            $halfStar = $relatedProductRating - $fullStars > 0;
                                                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                                        @endphp
                                                        @for($i = 0; $i < $fullStars; $i++) <i class="text-warning fa fa-star"></i> @endfor
                                                        @if($halfStar) <i class="text-warning fa fa-star-half-alt"></i> @endif
                                                        @for($i = 0; $i < $emptyStars; $i++) <i class="text-secondary fa fa-star"></i> @endfor
                                                    </li>
                                                </ul>
                                                <p class="text-center mb-0">L. {{ number_format($relatedProduct->price, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carousel-related-product" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel-related-product" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>
        </div>
    </section>
</section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        // Obtener todas las miniaturas
        var thumbnails = document.querySelectorAll('.thumbnail');

        // Manejar el evento de clic en las miniaturas
        thumbnails.forEach(function (thumbnail) {
            thumbnail.addEventListener('click', function (event) {
                event.preventDefault();
                var newImage = this.querySelector('img').getAttribute('src');
                var mainImage = document.getElementById('main-image');
                mainImage.src = newImage;
            });
        });
    });
    </script>
    <x-footer />
</x-main>
<x-main>
    <x-header />
    <main>
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-3">
                    <h1 class="h2 pb-4">Categorias</h1>
                    <ul class="list-unstyled accordion">
                        <li class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseOne">
                                    Genero
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <ul class="list-unstyled pl-3">
                                        <li><a class="text-decoration-none" href="#">Hombre</a></li>
                                        <li><a class="text-decoration-none" href="#">Mujer</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" href="#" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo"
                                    aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                    Sale
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <ul class="list-unstyled pl-3">
                                        <li><a class="text-decoration-none" href="#">Sport</a></li>
                                        <li><a class="text-decoration-none" href="#">Luxury</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseThree">
                                    Categoria
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <ul class="list-unstyled pl-3">
                                        <li><a class="text-decoration-none" href="#">Zapatos</a></li>
                                        <li><a class="text-decoration-none" href="#">Tecnologia</a></li>
                                        <li><a class="text-decoration-none" href="#">Moda</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-inline shop-top-menu pb-3 pt-1">
                                <li class="list-inline-item">
                                    <a class="h3 text-dark text-decoration-none mr-3" href="#">Todos</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 pb-4">
                            <div class="d-flex">
                                <select class="form-control">
                                    <option>Destacados</option>
                                    <option>Alfabetico</option>
                                    <option>Menor precio</option>
                                    <option>Mayor precio</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($products as $product)
                        <div class="col-md-4">
                            <div class="card mb-4 product-wap rounded-0">
                                <div class="card rounded-0 img-shop">
                                    @if($product->images)
                                    @php
                                    $images = json_decode($product->images, true); // Decodifica el JSON
                                    @endphp
                                    @if(!empty($images) && is_array($images))
                                    <img class="card-img rounded-0 img-fluid" src="{{ $images[0] }}"
                                        alt="{{ $product->name }}" width="100">
                                    <div @endif @endif
                                        class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                        <ul class="list-unstyled">
                                            <li><a class="btn btn-success text-white mt-2"
                                                    href="{{ route('shop.show', $product->id) }}"><i
                                                        class="far fa-eye"></i></a></li>
                                            <li><a class="btn btn-success text-white mt-2" href="/cart"><i
                                                        class="fas fa-cart-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('shop.show', $product->id) }}" class="h3 text-decoration-none">{{
                                        $product->name }}</a>
                                    <ul class="list-unstyled d-flex justify-content-center mb-1">
                                        <li>
                                            @php
                                            $averageRating = $product->averageRating;
                                            $fullStars = floor($averageRating);
                                            $halfStar = $averageRating - $fullStars >= 0.5 ? 1 : 0;
                                            $emptyStars = 5 - $fullStars - $halfStar;
                                            @endphp
                                            <!-- Show full stars -->
                                            @for($i = 0; $i < $fullStars; $i++) <i class="fa fa-star text-warning"></i>
                                                @endfor
                                                @if($halfStar)
                                                <i class="fa fa-star-half-alt text-warning"></i>
                                                @endif
                                                @for($i = 0; $i < $emptyStars; $i++) <i
                                                    class="fa fa-star text-secondary"></i>
                                                    @endfor
                                        </li>
                                    </ul>
                                    <p class="text-center mb-0">L. {{ $product->price }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <div div="row">
                        <ul class="pagination pagination-lg justify-content-end">
                            <li class="page-item disabled">
                                <a class="page-link active rounded-0 mr-3 shadow-sm border-top-0 border-left-0" href="#"
                                    tabindex="-1">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark"
                                    href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link rounded-0 shadow-sm border-top-0 border-left-0 text-dark"
                                    href="#">3</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        <!-- End Content -->
    </main>
    <x-footer />
</x-main>
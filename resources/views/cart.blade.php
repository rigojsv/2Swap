<x-main>
  <x-header />
  <main>
    <section class="h-100">
      <div class="container h-100 py-5">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h3 class="fw-normal mb-0">Carrito de compras</h3>
              <div>
                <p class="mb-0">
                  <span class="text-muted justify-content-center d-flex">Ordenar por:</span>
                  <select class="form-select" id="floatingSelectGrid">
                    <option selected>Precio</option>
                    <option value="1">A-Z</option>
                    <option value="2">Más antiguo</option>
                    <option value="3">Más reciente</option>
                  </select>
                </p>
              </div>
            </div>

            <div class="card rounded-3 mb-4">
              <div class="card-body p-4">
                <div class="row d-flex justify-content-between align-items-center">
                  <div class="col-md-2 col-lg-2 col-xl-2 border-end border-black">
                    <p class="texto">Imagen</p>
                  </div>
                  <div class="col-md-3 col-lg-3 col-xl-3 border-end border-black">
                    <p class="texto">Nombre</p>
                  </div>
                  <div class="col-md-3 col-lg-3 col-xl-2 d-flex border-end border-black">
                    <p class="texto">Descripcion</p>
                  </div>
                  <div class="col-md-3 col-lg-2 col-xl-2 border-end border-black">
                    <p class="texto">Precio</p>
                  </div>
                  <div class="col-md-1 col-lg-2 col-xl-2 text-end">
                    <p class="texto">Acciones</p>
                  </div>
                </div>
              </div>
            </div>
            <?php
            $total = 0;
            ?>
            @if($cart && $cart->items->count() > 0)
            @foreach($cart->items as $item)
            <div class="card rounded-3 mb-4">
              <div class="card-body p-4">
                <div class="row d-flex justify-content-between align-items-center">
                  <div class="col-md-2 col-lg-2 col-xl-2">
                    @if($item->product->images)
                    @php
                    $images = json_decode($item->product->images, true); // Decodifica el JSON
                    @endphp
                    @if(!empty($images) && is_array($images))
                    <img src="{{ $images[0] }}" class="img-fluid rounded-3" alt="{{ $item->product->name }}">
                  </div>
                  @endif @endif
                  <div class="col-md-3 col-lg-3 col-xl-3">
                    <p class="lead fw-normal mb-2">{{ $item->product->name }}</p>
                    <p>

                    </p>
                  </div>
                  <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                    <p>{{$item->product->description}} </p>
                  </div>
                  <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                    <h5 class="mb-0">L. {{ number_format($item->product->price * $item->quantity, 2) }}</h5>
                    <?php
                    $total += $item->product->price * $item->quantity;
                    ?>
                  </div>
                  <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-danger bg-transparent border-0">
                        <i class="fas fa-trash fa-lg"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            @endforeach

            <div class="card mb-4">
              <div class="card-body p-4 d-flex flex-row">
                <div data-mdb-input-init class="form-outline flex-fill align-items-center d-flex">
                  <input type="text" id="form1" class="form-control form-control-lg"
                    placeholder="Código de descuento" />
                  <label class="form-label" for="form1"></label>
                </div>
                <button type="button" data-mdb-button-init data-mdb-ripple-init
                  class="btn btn-outline-warning btn-lg ms-3">Aplicar</button>
              </div>
            </div>

            <div class="card">
              <div class="card-body d-flex justify-content-between">
                <button type="button" data-mdb-button-init data-mdb-ripple-init
                  class="btn btn-success btn-block btn-lg">Proceder al pago</button>
                <div>
                  <p class="fw-bold texto">Total: </p>
                  <span>L. {{ number_format($total, 2) }}</span>
                </div>
              </div>
            </div>
          </div>
          @else
          <p>Tu carrito está vacío.</p>
          @endif
        </div>
      </div>
      </div>
    </section>
  </main>
  <x-footer />
</x-main>
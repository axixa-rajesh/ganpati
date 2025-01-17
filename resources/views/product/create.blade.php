@extends('layouts.app')

@section('content')
    <form action="/product" method="post" enctype="multipart/form-data">
        @csrf
        <div class="container border">
            <div class="alert text-primary h3 text-center text-decoration-underline">
                Product Form
            </div>
            @if ($errs = $errors->all())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errs as $er)
                            <li> {{ $er }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="mb-3">
                <label for="name">Product Name : </label>
                <input type="text" name="name" id="name" placeholder="Enter Name"
                    value="{{ old('name') ?? 'Soan Papdi' }}" class="form-control">
            </div>

            <div class="mb-3">
                <label for="flavour" class="form-label">Product Flavour : </label>
                <input type="text" autofocus name="flavour" id="flavour" placeholder="Enter flavour" class="form-control"
                    value="{{ old('flavour')??"Regular" }}"  list="sug">
                <datalist id="sug">
                    <option value="Almond & Pistachio">
                    <option value="Chocolate">
                    <option value="Coconut">
                    <option value="Elaichi">
                    <option value="Orange">
                    <option value="Regular">
                    <option value="Rose">
                </datalist>
            </div>
            <div id="main">
                <div class="row mb-3" id="child_1">
                    <div class="col-3">

                        <label for="madewith">Made With: </label>
                        <select class="form-select" name="price[madewith][]" id="madewith">
                            <option>Vegetable Oil</option>
                            <option>Desi Ghee</option>
                        </select>
                    </div>
                    <div class="col-3">

                        <label for="weight">Weight</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" name="price[weight][]" placeholder="Weight"
                                placeholder="Recipient's username" aria-label="Recipient's username"
                                aria-describedby="button-addon2">
                            <select class="btn btn-outline-secondary" name="price[weight_type][]" id="button-addon2">
                                <option>gm</option>
                                <option>kg</option>
                            </select>
                        </div>

                    </div>
                    <div class="col-3">
                        <label for="price">Price</label>
                        <div class="input-group mb-3">
                            <input type="number" name="price[price][]" placeholder="Price" class="form-control"
                                 
                                aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">₹</span>
                        </div>
                    </div>
                     <div class="col-3">
                        <label for="price">Final Price</label>
                        <div class="input-group mb-3">
                            <input type="number" name="price[finalprice][]" placeholder="Final Price" class="form-control"
                               
                                aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">₹</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <input type="hidden" value="1" id="tot">
                <button class="btn btn-success" onclick="cClone()" type="button"> PUSH</button>
                <button class="btn btn-danger" onclick="rClone()" type="button"> POP</button>
            </div>
            <div class="mb-3">
                <label for="main_image" class="form-label">Image : </label>
                <input class="form-control" type="file" id="main_image" accept="image/*" name="main_image">
            </div>
            <div class="mb-3">
            <label for="other_image" class="form-label"> Other Image/Video : </label>
            <input class="form-control" multiple type="file" id="other_image" accept="image/*,video/*"
                name="other_image[]">
        </div> 
            <div class="mb-3">
                <label for="description" class="form-label"> Product Description: </label>
                <textarea name="description" placeholder="Product Description" id="description" class="form-control" cols="30"
                    rows="6">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3 text-center">
                <button class="btn btn-success">Save</button>
            </div>
        </div>
    </form>
    <script>
        function cClone() {
            tot.value = parseInt(tot.value) + 1;
            let obj = child_1.cloneNode(true);
            obj.id = "child_" + tot.value;
            main.appendChild(obj);
        }

        function rClone() {
            if (Number(tot.value) > 1) {
                let obj = document.getElementById('child_' + tot.value);
                main.removeChild(obj);
                tot.value = parseInt(tot.value) - 1;

            } else {
                alert("You can't Delete it");
            }
        }
    </script>
@endsection

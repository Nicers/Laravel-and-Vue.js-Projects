@extends("admin/layout")
@section("content")

    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Shop Product</div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary">Settings</button>
                        <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item"
                                href="javascript:;">Action</a>
                            <a class="dropdown-item" href="javascript:;">Another action</a>
                            <a class="dropdown-item" href="javascript:;">Something else here</a>
                            <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated
                                link</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->

            <h6 class="mb-0 text-uppercase">Import new Product</h6><br>
            <!-- Button trigger modal -->
            <div class="col">
                <button type="button" onclick="newProduct()" class="btn btn-info px-5 radius-30" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    Add new Product
                </button>
            </div>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Text</th>
                                    <th>Image</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $list)
                                    <tr>
                                        <td>{{$list->id}}</td>
                                        <td>{{$list->name}}</td>
                                        <td><img src="{{ asset('frontAssets/images/products/' . $list->image) }}"
                                                class="rounded-square" id="homeBannerImage" width="80"></td>
                                        <td>{{$list['updated_at']}}</td>
                                        <td class="d-flex flex-wrap gap-3">
                                            <a href="{{ url('products/' . $list['id']) }}" class="btn btn-info px-2"><i
                                                    class="fa-solid fa-eye mx-auto"></i></a>
                                            <button type="button" class="btn btn-success px-2" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal" onclick="setModelData({{ $list }});"><i
                                                    class="fa-solid fa-pen mx-auto"></i></button>
                                            <form action="{{ url('products/' . $list->id) }}" method="post" class="p-0 m-0"
                                                id='deleteProduct{{$list->id}}'>
                                                @csrf
                                                @method('delete')
                                                <button type="submit" onclick="return confirm('Are you want to Delete Data?')"
                                                    class="btn btn-danger px-2"><i
                                                        class="fa-solid fa-trash mx-auto"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Text</th>
                                    <th>Image</th>
                                    <th>Updated_at</th>
                                    <th onclick="readURL(this)">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Manage Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" id="productForm" method="post" enctype="multipart/form-data">
                            @csrf
                            <!-- @method('put')
                                @method('post') -->
                            <div class="modal-body">
                                <div class="card border-top border-primary">
                                    <div class="card-body p-5">
                                        <div class="col-12">
                                            <label for="inputText" class="form-label">Name</label>
                                            <input type="text" value="" name="name" class="form-control" id="inputText">
                                        </div>
                                        <div class="col-12">
                                            <label for="inputPrice" class="form-label">Price</label>
                                            <input type="text" value="" name="price" class="form-control" id="inputPrice">
                                        </div>
                                        <div class="col-12">
                                            <label for="inputDes" class="form-label">Description</label>
                                            <input type="text" value="" name="description" class="form-control"
                                                id="inputDes">
                                        </div>
                                        <div class="col-12">
                                            <label for="inputColor" class="form-label">Color</label>
                                            <input type="text" value="" name="color" class="form-control" id="inputColor">
                                        </div>
                                        <div class="col-12">
                                            <label for="inputModel" class="form-label">Model</label>
                                            <input type="text" value="" name="model" class="form-control" id="inputModel">
                                        </div>
                                        <div class="col-12">
                                            <label for="inputFile" class="form-label">Image</label>
                                            <input type="file"
                                                onchange="document.getElementById('productImage').src = window.URL.createObjectURL(this.files[0])"
                                                required name="image" class="form-control" id="productFile" />
                                            <img src="" class="rounded-square mt-3" id="productImage" width="150">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-primary" value="Save product" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>


    <script>
        function newProduct() {
            const form = document.querySelector('#productForm');
            form.action = `{{url('products') }}?_method=POST`;
        }

        function setModelData(data) {
            const form = document.querySelector('#productForm');
            document.getElementById('inputText').value = data.name;
            document.getElementById('inputPrice').value = data.price;
            document.getElementById('inputDes').value = data.description;
            document.getElementById('inputColor').value = data.color;
            document.getElementById('inputModel').value = data.model;
            document.getElementById('productImage').src = `frontAssets/images/products/${data['image']}`;
            form.action = `{{ url('products') }}/${data['id']}?_method=PUT`;
        }
    </script>
@endsection
@extends("admin/layout")
@section("content")
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Add Zone</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Add Zone</li>
                        </ol>
                    </nav>
                </div>
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

            <h6 class="mb-0 text-uppercase">Import new Zone</h6><br>
            <!-- Button trigger modal -->
            <div class="col">
                <a href="{{url('admin/product_manage/0')}}" class="btn btn-info px-5 radius-30">
                    Add new Zone
                </a>
            </div>
            <hr />
            <div class="card">
                <div class="card-body">
                    <form action="{{ url('admin/zone') }}" method="post" class="form w-50" accept-charset="utf-8"
                        id="map_form">
                        @csrf
                        @method('POST')
                        <div class="col-12 mb-4">
                            <label for="inputZone" class="form-label">Name</label>
                            <input type="text" value="" name="zone" placeholder="Enter zone name" class="form-control"
                                id="inputZone">
                        </div>
                        <div id="map-canvas" style="height: 22rem;margin: 0px;padding: 0px;"></div>
                        <input type="text" hidden name="coordinate" class="form-control" value="" id="coordinate" />
                        <input type="submit" class="btn btn-primary mt-4" name="save" value="Save!" id="save" />
                    </form>
                    <br><br><br><br><br>


                    @php
                        use App\Models\Zone;
                        $zones = Zone::all();
                      @endphp
                    @if ($zones)
                        <div class="table-responsive">
                            <table id="example2" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Update_at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($zones as $zone)
                                        <tr>
                                            <td>{{$zone->id}}</td>
                                            <td>{{$zone->name}}</td>
                                            <td>{{ $zone->updated_at }}</td>
                                            <td class="d-flex flex-wrap gap-3">
                                                <a href="{{ url('admin/zone/' . $zone['id']) }}" class="btn btn-info px-2"><i
                                                        class="fa-solid fa-eye mx-auto"></i></a>
                                                <button type="button" class="btn btn-success px-2" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal" onclick="setModelData({{ $zone }});"><i
                                                        class="fa-solid fa-pen mx-auto"></i></button>
                                                <form action="{{ url('admin/zone/' . $zone->id) }}" method="post" class="p-0 m-0"
                                                    id='deleteProduct{{$zone->id}}'>
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
                                        <th>Name</th>
                                        <th>Updated_at</th>
                                        <th onclick="readURL(this)">Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>


    <!-- Google Maps API with Drawing Library and callback -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnApnmGz7l-ch3xFvLW2BLRe1Lsq4fE4A&libraries=drawing&callback=initialize"
        async defer></script>

    <script>
        let map;
        let drawingManager;

        function initialize() {
            const myLatlng = new google.maps.LatLng(40.9403762, -74.1318096);
            const mapOptions = {
                zoom: 13,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [google.maps.drawing.OverlayType.POLYGON]
                },
                polygonOptions: {
                    editable: true
                }
            });

            drawingManager.setMap(map);

            google.maps.event.addListener(drawingManager, "overlaycomplete", function (event) {
                const polygon = event.overlay;
                const path = polygon.getPath();
                const coordinates = [];

                for (let i = 0; i < path.getLength(); i++) {
                    const latLng = path.getAt(i);
                    coordinates.push({ lat: latLng.lat(), lng: latLng.lng() });
                }

                document.getElementById('coordinate').value = JSON.stringify(coordinates);
            });
        }
    </script>
@endsection
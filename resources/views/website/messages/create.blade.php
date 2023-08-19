<x-guest-layout>



    <div class="container mt-5">
        <div class="row">
            <div class="col-md-7 mx-auto">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                <div class="card">
                    <div class="card-header" style="text-align: center;">
                        <h3 class="card-title">Hello, {{ $user->name }}</h3>
                    </div>
                    <div class="card-body">

                        <div class="text-center d-flex align-items-center justify-content-center mb-3">
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" style="height: 400px;" class="rounded-circle">
                        </div>

                        <form id="messageForm" style="text-align: center;" enctype="multipart/form-data">
                            @csrf
                            {{--  <div class="mb-3">
                                <label for="ip" class="form-label">Ip</label>
                                <input type="text" name="ip" id="ip" placeholder="ip" class="form-control">
                            </div>  --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" id="email" placeholder="Email is optional if you want the user send you replay without knowing your email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="text" class="form-label">Message</label>
                                <input type="text" name="text" id="text" placeholder="message" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" id="image" placeholder="image" class="form-control">
                            </div>
                            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                            <button type="button" id="submitBtn" class="btn btn-outline-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        var ipAddress; // Declare ipAddress variable
        var myLocation;
        window.onload = function() {
            // Fetch the IP address using ipify API
            fetch('https://api.ipify.org?format=json')
              .then(response => response.json())
              .then(data => {
                // Access the IP address from the response
                 ipAddress = data.ip;
                console.log('IP Address:', ipAddress);

                // Fetch the location information using IP Geolocation API
                fetch(`https://ipapi.co/${ipAddress}/json/`)
                  .then(response => response.json())
                  .then(locationData => {
                    // Access the location information from the response
                    const { city, region, country, latitude, longitude } = locationData;
                    myLocation= city +' '+ region + " " + country ;
                    console.log('Location:', city, region, country);
                  })
                  .catch(error => {
                    console.log('Error:', error);
                  });
              })
              .catch(error => {
                console.log('Error:', error);
              });
        };

        $(document).ready(function() {
            $('#submitBtn').click(function() {
                var formData = new FormData($('#messageForm')[0]);
                formData.append('ip', ipAddress);
                formData.append('location', myLocation);

                $.ajax({
                    type: 'POST',
                    enctype: "multipart/form-data",
                    url: "{{ route('message.store') }}",
                    data:formData ,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Your work has been saved',
                            showConfirmButton: false,
                            timer: 1500
                        })

                        $('#tr' + messageId).remove();

                        console.log(response);
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessages = '';

                            for (var key in errors) {
                                errorMessages += errors[key][0] + '<br>';
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                html: errorMessages
                            });
                        } else {
                            console.error('An error occurred:', xhr.responseJSON.errors);
                        }
                    }
                });
            });
        });
    </script>

</x-guest-layout>








<x-app-layout>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-7 mx-auto">
                @if (session('success'))
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
                        <h1 class="card-title" style="font-size: xx-large;"
                        authUser="{{ auth()->user()->name }}"
                        id="authUser"
                        >Hello, {{ auth()->user()->name }}</h1>


                        <h6 class="card-title">This is your url you can share</h6>
                        <div id="sarhne-input" class="input-group input-group-icon">
                            <input type="text" id="slink" class="form-control w-100 text-center"
                                value="{{ url('message/create') . '/' . auth()->user()->id }}" readonly>
                        </div>


                    </div>
                    <div class="card-body">

                        <div class="text-center d-flex align-items-center justify-content-center mb-3">
                            <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}"
                                style="height: 400px;" class="rounded-circle">
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Message</th>
                                    <th>Image</th>
                                    <th>created_at</th>
                                    <th>Adress</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($messages as $message)
                                    <tr id="tr{{ $message->id }}">
                                        <td>{{ $message->text }}</td>
                                        <td>
                                            <img src="{{ $message->image }}">
                                        </td>
                                        <td>{{ $message->created_at->diffForHumans() }}</td>
                                        <td>{{ $message->location }}</td>




                                        <td style="display:flex; ">
                                            <div>
                                                <form class="deleteForm" messageId="{{ $message->id }}"
                                                    action="{{ route('message.destroy', ['message' => $message->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="deleteBtn btn btn-outline-danger">Delete</button>
                                                </form>
                                            </div>

                                            @if ($message->email)
                                                <div>
                                                    <button type="button" class="btn btn-outline-success"
                                                        data-toggle="modal" data-target="#myModal">
                                                        Open Modal
                                                    </button>
                                                    <div class="container mt-5">
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="myModal">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Modal Title</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal">&times;</button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p
                                                                            style="
                                                    padding: 20px;
                                                    border: 1px solid #ccc;
                                                    border-radius: 5px;
                                                    background-color: #f9f9f9;
                                                    ">
                                                                            Please pay attention: the sender of the
                                                                            message has left their email as an option
                                                                            for receiving a reply.
                                                                            If you wish to send a response, enter it
                                                                            here, and we will forward it to their email
                                                                            address.
                                                                        </p>

                                                                            <div class="form-group">
                                                                                <label for="message">Message</label>
                                                                                 <input class="replyForm form-control" type="text" replyEmail="{{ $message->email }}" name="userInput" rows="4">
                                                                            </div>


                                                                    </div>
                                                                    <div class="modal-footer">

                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            data-dismiss="modal">Close</button>


                                                                        <button type="button"
                                                                            class="replyBtn btn-outline-primary">Submit</button>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endif


                                        </td>





                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>


        $(document).ready(function() {
            $('.replyBtn').click(function() {

                var reply = $(".replyForm").val();
                var email = $(".replyForm").attr('replyEmail');
                var authUserNmae = $('#authUser').attr('authUser');

                    console.log(reply);
                    console.log(email);
                    console.log(authUserNmae);


                const data = JSON.stringify({
                    personalizations: [
                      {
                        to: [
                          {
                            email:String(email),
                          },
                        ],
                        subject: "sara7a",
                      },
                    ],
                    from: {
                        email:"islamm1995@gmail.com",
                    },
                    content: [
                      {
                        type: "text/plain",
                        value: `${authUserNmae} reply you ${reply}`,
                      },
                    ],
                  });

                  const xhr = new XMLHttpRequest();
                  xhr.withCredentials = true;

                  xhr.addEventListener("readystatechange", function () {
                    if (this.readyState === this.DONE) {
                      console.log(this.responseText);
                    }
                  });

                  xhr.open(
                    "POST",
                    "https://rapidprod-sendgrid-v1.p.rapidapi.com/mail/send"
                  );
                  xhr.setRequestHeader("content-type", "application/json");
                  xhr.setRequestHeader(
                    "X-RapidAPI-Key",
                    "2135a8002fmsh8b8a665f7121ea8p1f7fecjsne548afc779cb"
                  );
                  xhr.setRequestHeader(
                    "X-RapidAPI-Host",
                    "rapidprod-sendgrid-v1.p.rapidapi.com"
                  );

                  xhr.send(data);

                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                });

                $("#myModal").remove();
            });
        });




        $(document).ready(function() {
            $('.deleteBtn').click(function() {
                var form = $(this).closest('.deleteForm');
                var messageId = form.attr('messageId');

                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: form.serialize(),
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


</x-app-layout>

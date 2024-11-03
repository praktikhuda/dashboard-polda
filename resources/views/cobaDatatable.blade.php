@extends('app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <h5 class="card-title">Buttons example</h5>
                <p class="card-title-desc">The Buttons extension for DataTables
                    provides a common set of options, API methods and styling to display
                    buttons on a page that will interact with a DataTable. The core library
                    provides the based framework upon which plug-ins can be built.
                </p>
                <div class="table-responsive">
                    <table id="datatable-buttons" class="table table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011/04/25</td>
                                <td>$320,800</td>
                            </tr>
                            <tr>
                                <td>Garrett Winters</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>63</td>
                                <td>2011/07/25</td>
                                <td>$170,750</td>
                            </tr>
                            <tr>
                                <td>Ashton Cox</td>
                                <td>Junior Technical Author</td>
                                <td>San Francisco</td>
                                <td>66</td>
                                <td>2009/01/12</td>
                                <td>$86,000</td>
                            </tr>
                            <tr>
                                <td>Cedric Kelly</td>
                                <td>Senior Javascript Developer</td>
                                <td>Edinburgh</td>
                                <td>22</td>
                                <td>2012/03/29</td>
                                <td>$433,060</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection
@section('js')
<!-- JAVASCRIPT -->
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

<!-- Required datatable js -->
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- Buttons examples -->
<script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>



<script>
    $(document).ready(function() {
        let data = [{
                "name": "Tiger Nixon",
                "position": "System Architect",
                "office": "Edinburgh",
                "age": 61,
                "start_date": "2011/04/25",
                "salary": "$320,800"
            },
            {
                "name": "Garrett Winters",
                "position": "Accountant",
                "office": "Tokyo",
                "age": 63,
                "start_date": "2011/07/25",
                "salary": "$170,750"
            },
            {
                "name": "Ashton Cox",
                "position": "Junior Technical Author",
                "office": "San Francisco",
                "age": 66,
                "start_date": "2009/01/12",
                "salary": "$86,000"
            },
            {
                "name": "Cedric Kelly",
                "position": "Senior Javascript Developer",
                "office": "Edinburgh",
                "age": 22,
                "start_date": "2012/03/29",
                "salary": "$433,060"
            }
        ]

        $("#datatable-buttons").DataTable({
            // info: false,
            // lengthChange: false,
            columns: [{
                    title: "Name",
                    data: "name"
                },
                {
                    title: "Position",
                    data: "position"
                },
                {
                    title: "Office",
                    data: "office"
                },
                {
                    title: "Age",
                    data: "age"
                },
                {
                    title: "Start date",
                    data: "start_date"
                },
                {
                    title: "Salary",
                    data: "salary"
                }
            ],
            buttons: ["pdf", "print"]
        }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
    });
</script>
@endsection
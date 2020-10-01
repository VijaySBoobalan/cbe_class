@extends('layouts.master')

@section('view_assign_fee')
active
@endsection

@section('fees_master_open_menu')
open
@endsection

@section('fees_master_open_menu_display')
block
@endsection

@section('assign_fee_open_menu')
open
@endsection

@section('assign_fee_open_menu_display')
block
@endsection

@section('content')

<section id="content">
    <div class="page page-forms-validate">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <section class="tile">
                    <div class="tile-header dvd dvd-btm">
                        <h1 class="custom-font"><strong>Student List</h1>
                    </div>
                    <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table datatable-basic">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Student</th>
                                        <th>Department</th>
                                        <th>Year</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($StudentAssignFeesDetails))
                                        @foreach ($StudentAssignFeesDetails as $key=>$StudentAssignFeesDetail)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $StudentAssignFeesDetail->getStudentDetail->student_name }}</td>
                                                <td>{{ $StudentAssignFees->class_id }}</td>
                                                <td>{{ $StudentAssignFees->ClassSection->section }}</td>
                                                <td>{{ getStudentFeeAmount($StudentAssignFees->fee_group_id) }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>


    <script>
        var DatatableBasic = function () {
            //
            // Setup module components
            //
            var _componentNoty = function () {
                if (typeof Noty == 'undefined') {
                    console.warn('Warning - noty.min.js is not loaded.');
                    return;
                }

                // Override Noty defaults
                Noty.overrideDefaults({
                    theme: 'limitless',
                    layout: 'topRight',
                    type: 'alert',
                    timeout: 2500
                });
            };
            // Sweet Alerts
            var _componentSweetAlert = function () {
                if (typeof swal == 'undefined') {
                    console.warn('Warning - sweet_alert.min.js is not loaded.');
                    return;
                }

                // Defaults
                var setCustomDefaults = function () {
                    swal.setDefaults({
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-primary',
                        cancelButtonClass: 'btn btn-light'
                    });
                }
                setCustomDefaults();
            };
            // Basic Datatable examples
            var _componentDatatableBasic = function () {
                if (!$().DataTable) {
                    console.warn('Warning - datatables.min.js is not loaded.');
                    return;
                }

                // Setting datatable defaults
                $.extend($.fn.dataTable.defaults, {
                    autoWidth: false,
                    columnDefs: [{
                        orderable: false,
                        width: 100,
                        targets: [3]
                    }],
                    dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                    language: {
                        search: '<span>Filter:</span> _INPUT_',
                        searchPlaceholder: 'Type to filter...',
                        lengthMenu: '<span>Show:</span> _MENU_',
                        paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
                    }
                });

                // Basic datatable
                $('.datatable-basic').DataTable({
                    columnDefs: [
                        {
                            targets: -1,
                            className: 'noVis'
                        }
                    ],
                    buttons: [
                        {
                            extend: 'colvis',
                            text: '<i class="icon-grid7"></i>',
                            className: 'btn bg-teal-400 btn-icon dropdown-toggle',
                            postfixButtons: ['colvisRestore'],
                            columns: ':not(.noVis)'
                        },
                        {
                            extend: 'copy',
                            exportOptions: {
                                columns: ':not(.no-print)'
                            },
                            className: 'btn btn-light'
                        },
                        {
                            extend: 'csv',
                            exportOptions: {
                                columns: ':not(.no-print)'
                            },
                            className: 'btn btn-light'
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: ':not(.no-print)'
                            },
                            className: 'btn btn-light'
                        },
                        {
                            extend: 'pdf',
                            exportOptions: {
                                columns: ':not(.no-print)'
                            },
                            className: 'btn btn-light'
                        },
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: ':not(.no-print)'
                            },
                            className: 'btn btn-light'
                        }
                    ],
                });
            };

            // Select2 for length menu styling
            var _componentSelect2 = function () {
                if (!$().select2) {
                    console.warn('Warning - select2.min.js is not loaded.');
                    return;
                }

                // Initialize
                $('.dataTables_length select').select2({
                    minimumResultsForSearch: Infinity,
                    dropdownAutoWidth: true,
                    width: 'auto'
                });

                 // Default initialization
                 $('.select').select2({
                    minimumResultsForSearch: Infinity
                });

                // Select with search
                $('.select-search').select2();
            };

            // Validation config
            var _componentValidation = function () {
                if (!$().validate) {
                    console.warn('Warning - validate.min.js is not loaded.');
                    return;
                }
                // Initialize
                var validator = $('.form-validate-jquery').validate({
                    ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
                    errorClass: 'validation-invalid-label',
                    successClass: 'validation-valid-label',
                    validClass: 'validation-valid-label',
                    highlight: function (element, errorClass) {
                        $(element).removeClass(errorClass);
                    },
                    unhighlight: function (element, errorClass) {
                        $(element).removeClass(errorClass);
                    },
                    // success: function(label) {
                    //     label.addClass('validation-valid-label').text('Success.'); // remove to hide Success message
                    // },
                });

                // Reset form
                $('#reset').on('click', function () {
                    validator.resetForm();
                });
            };

            // Anytime picker
            var _componentAnytime = function() {
                if (!$().AnyTime_picker) {
                    console.warn('Warning - anytime.min.js is not loaded.');
                    return;
                }
                $('.anytime-time').AnyTime_picker({
                    format: '%H:%i'
                });
                // Time picker
                // var $anytime = $('.anytime-time').AnyTime_picker();

            };

            //Picka date
            var _componentPickADate = function () {
                $('.pickadate').pickadate({
                    selectMonths: true,
                    selectYears: 75,
                    format: 'dd/mm/yyyy',
                    formatSubmit: 'yyyy/mm/dd',
                    hiddenName: true,
                });
            };

            // Uniform
            var _componentUniform = function() {
                if (!$().uniform) {
                    console.warn('Warning - uniform.min.js is not loaded.');
                    return;
                }

                // Initialize
                $('.form-input-styled').uniform({
                    fileButtonClass: 'action btn bg-pink-400'
                });

                // // Initialize
                // $('.form-input-styled').uniform({
                //     fileButtonClass: 'action btn bg-blue'
                // });

            };

            return {
                init: function () {
                    _componentNoty();
                    _componentUniform();
                    _componentDatatableBasic();
                    _componentSelect2();
                    // _componentPickADate();
                    _componentValidation();
                    _componentSweetAlert();
                    _componentAnytime();
                }
            }
        }();
        // Initialize module
        // ------------------------------
        var dataTable = "";
        var TotalValue = 0;

        document.addEventListener('DOMContentLoaded', function () {
            $(window).keydown(function (event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            DatatableBasic.init();

        });

    </script>


@endsection

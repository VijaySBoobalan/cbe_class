@extends('layouts.master')

@section('add_fee_collection')
active
@endsection

@section('fees_master_open_menu')
open
@endsection

@section('fees_master_open_menu_display')
block
@endsection

@section('fee_collection_open_menu')
open
@endsection

@section('fee_collection_display')
block
@endsection

@section('content')

    <section id="content">

        <div class="page page-tables-datatables">

            <!-- row -->
            <div class="row">
                <!-- col -->
                <div class="col-md-12">


                    <!-- tile -->
                    <section class="tile tile-simple">


                        <!-- tile body -->
                        <div class="tile-body">


                            <!-- row -->
                            <div class="row">

                                {{-- <!-- col -->
                                <div class="col-md-9">
                                    <a href="http://www.logoinstant.com" target="_blank" title="Free Logo"><img src="assets/images/logo-placeholder.jpg" alt="" class="thumb thumb-xl m-10 mb-20"></a>
                                </div>
                                <!-- /col --> --}}

                                <!-- col -->
                                <div class="col-md-12">
                                    <h3 class="mb-0 text-custom text-strong text-center">TTSVLE</h3>
                                    <p class="text-default lt text-center">Coinmbatore</p>
                                </div>
                                <!-- /col -->

                            </div>
                            <!-- /row -->

                            <!-- row -->
                            <div class="row b-t pt-20">

                                <!-- col -->
                                <div class="col-md-8 b-r">
                                    <ul class="list-unstyled text-default lt mb-20">
                                        <li>{{ $Students->student_name }}</li>
                                        <li>{{ $Students->student_class }} - {{ $Students->ClassSection->section }}</li>
                                    </ul>

                                </div>

                                <div class="col-md-4 b-r">
                                    <ul class="list-unstyled text-default lt mb-20">
                                        <li>Place : Coimbatore</li>
                                        <li>Date : <?php echo date('d/m/Y'); ?></li>
                                    </ul>

                                </div>
                                <!-- /col -->

                            </div>
                            <!-- /row -->

                        </div>
                        <!-- /tile body -->

                    </section>
                    <!-- /tile -->


                    <!-- tile -->
                    <section class="tile tile-simple">

                        <!-- tile body -->
                        <div class="tile-body p-0">

                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $Total = 0;
                                            $DiscountAmount = 0;
                                        ?>
                                        @foreach ($FeesCollections as $key=>$FeesCollection)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $FeesCollection->date }}</td>
                                                <td>{{ $FeesCollection->amount }}</td>
                                            </tr>
                                            <?php
                                                $Total += $FeesCollection->amount;
                                                $DiscountAmount += $FeesCollection->discount_amount;
                                            ?>
                                        @endforeach
                                    </tbody>
                                    {{-- <tfoot>
                                        <tr>
                                            <th colspan="2"></th>
                                            <th colspan="2">{{ $Total }}</th>
                                        </tr>
                                    </tfoot> --}}
                                </table>
                            </div>

                        </div>
                        <!-- /tile body -->

                    </section>
                    <!-- /tile -->


                </div>
                <!-- /col -->
            </div>
            <!-- /row -->

            <!-- row -->
            <div class="row">
                <!-- col -->
                <div class="col-md-3 col-md-offset-6 price-total">

                    <!-- tile -->
                    <section class="tile tile-simple bg-tr-black lter">

                        <!-- tile body -->
                        <div class="tile-body">

                            <ul class="list-unstyled">
                                <li class="ng-binding"><strong class="inline-block w-sm mb-5">Total Paid:</strong>{{ $Total }}</li>
                                <li class="ng-binding"><strong class="inline-block w-sm mb-5">Discount:</strong> {{ $DiscountAmount }}</li>
                                <li><strong class="inline-block w-sm">Total Amount:</strong> <h3 class="inline-block text-success ng-binding">{{ $Total + $DiscountAmount }}</h3></li>
                            </ul>

                        </div>
                        <!-- /tile body -->

                    </section>
                    <!-- /tile -->

                </div>
                <!-- /col -->
            </div>
            <!-- /row -->
        </div>
    </section>

@endsection


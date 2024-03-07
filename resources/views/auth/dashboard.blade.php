@extends('../layouts.admin')

@section('content')
<div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
   <!-- BEGIN: General Report -->
   <div class="col-span-12 mt-8">
      <div class="intro-y flex items-center h-10">
         <h2 class="text-lg font-medium truncate mr-5">
            General Current Month Report
         </h2>
         <span style="padding-right: 10px;" id="user_units">Units: 0</span>
         <div id="timeNow" class="sm:ml-auto mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300"></div>
      </div>
      <div class="grid grid-cols-12 gap-6 mt-5">
         <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
            <div class="report-box zoom-in">
               <div class="box p-5">
                  <div class="flex">
                     <i data-feather="bar-chart" class="report-box__icon text-theme-12"></i>
                     <div class="ml-auto">
                        <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="12% Higher than last month"> 12% <i data-feather="chevron-up" class="w-4 h-4"></i> </div>
                     </div>
                  </div>
                  <div id="bulkSmsMtn" class="text-3xl font-bold leading-8 mt-6">0</div>
                  <div class="text-base text-gray-600 mt-1">Bulk MTN</div>
               </div>
            </div>
         </div>
         <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
            <div class="report-box zoom-in">
               <div class="box p-5">
                  <div class="flex">
                     <i data-feather="bar-chart" class="report-box__icon text-theme-9"></i>
                     <div class="ml-auto">
                        <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="22% Higher than last month"> 22% <i data-feather="chevron-up" class="w-4 h-4"></i> </div>
                     </div>
                  </div>
                  <div id="bulkSmsAirtel" class="text-3xl font-bold leading-8 mt-6">0</div>
                  <div class="text-base text-gray-600 mt-1">Bulk Airtel</div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- END: General Report -->
   <!-- BEGIN: Sales Report -->
   <div class="col-span-12 lg:col-span-8 mt-8">
    <div class="intro-y block sm:flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5">Bulk SMS</h2>
    </div>
    <div class="intro-y box p-5 mt-12 sm:mt-5">
        <div class="report-chart">
            <canvas id="userChart" height="160" class="mt-6"></canvas>
        </div>
    </div>
   </div>
</div>
</div>
@endsection
@section('styles')
<!-- plugins:css -->
<link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<!-- First check if a target element exists
Get the data from the back end us ajax
pass data to the view  -->

<script>

(function(userChart) {
    "use strict";

    // Chart
    if (cash('#userChart').length) {
        fetch('/usercharts').then(function (data) {
            data.json().then(function (response) {
                var ctx = cash('#userChart')[0].getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels:  response.chardt.labels ,
                        datasets: [
                            {
                                label: 'Airtel Bulk Messages',
                                backgroundColor: response.chardt.colours ,
                                data:  response.chardt.dataset ,
                            },
                            {
                                label: 'MTN Bulk Messages',
                                backgroundColor: response.chardt.colours ,
                                data:  response.charmt.dataset ,
                            },
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {if (value % 1 === 0) {return value;}}
                                },
                                scaleLabel: {
                                    display: false
                                }
                            }]
                        },
                        legend: {
                            labels: {
                                // This more specific font property overrides the global property
                                fontColor: '#122C4B',
                                fontFamily: "'Muli', sans-serif",
                                padding: 25,
                                boxWidth: 25,
                                fontSize: 14,
                            }
                        },
                        layout: {
                            padding: {
                                left: 10,
                                right: 10,
                                top: 0,
                                bottom: 10
                            }
                        }
                    }
                });
            });
        });
    }

})(userChart)

</script>

<script>

(function($) {
    "use strict";
    $(function() {

        if ($("#bulkSmsMtn").length) {
            console.log('The bulksmsmtn target div has been found ...');
            console.log(document.getElementById("bulkSmsMtn"));

            fetch('/bulksmsmtn').then(function (data) {
                data.json().then(function (response) {
                    console.log(response);
                });
            });
        }
    });
})(jQuery);


(function($) {
    "use strict";
    $(function() {
        if (document.getElementById("bulkSmsAirtel").length) {
            console.log('The bulksmsairtel target div has been found ...');
            console.log(document.getElementById("bulkSmsAirtel"));

            fetch('/bulksmsairtel').then(function (data) {
                data.json().then(function (response) {
                    console.log(response);
                });
            });
        }
    });
})(jQuery);

</script>

<script>

(function foo(){
    var tday=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
    var tmonth=new Array("January","February","March","April","May","June","July","August","September","October","November","December");

        var d = new Date();
        var nday=d.getDay()
        var nmonth=d.getMonth()
        var ndate = d.getDate();
        var hours = d.getHours();
        var clientTime =" "+ tday[nday] + " " +tmonth[nmonth] + " " + ndate + ", " + hours + ":"  + d.getMinutes() + ":" + d.getSeconds() + " " + (hours >= 12 ? 'pm' : 'am');
        //alert(clientTime);
        document.getElementById("timeNow").innerHTML = clientTime;
        setTimeout(foo, 1000); // refresh time every 1 second

    })();

    (function userUnits () {

    fetch('/users/units').then(function (data) {

      data.json().then(function (units) {
        console.log(units);
        document.getElementById("user_units").innerHTML = `Units: ${units.units}`;
      });
    });

  })();
</script>
<!-- inject:js -->
<script src="{{ asset('assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('assets/js/misc.js') }}"></script>
<!-- Plugin js for this page -->
<script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/vendors/jquery-circle-progress/js/circle-progress.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{ asset('assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('assets/js/misc.js') }}"></script>
<!-- endinject -->
<script src="{{ asset('assets/js/gritter.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pulstate.js') }}" type="text/javascript"></script>
@endsection

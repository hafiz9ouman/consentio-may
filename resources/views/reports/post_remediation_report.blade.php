@extends('admin.client.client_app')
@section('page_title')
{{ __('Remediation Report') }}
@endsection
@section('content')
<style>
    body{
        color:black;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <h4 style="color:black;"><b>Remediation Reports</b></h4>
    </div>
    <div class="row">
        <div class="col-md-2 p-4">
            <h5><b>Business Unit</b></h5>
            
        </div>
        <div class="col-md-2 p-4" id="tier-section">
            <h5><b>Tier</b></h5>
            <input type="checkbox" name="tier[]" id="tier1" value="tier 1"> Tier 1<br>
            <input type="checkbox" name="tier[]" id="tier2" value="tier 2"> Tier 2<br>
            <input type="checkbox" name="tier[]" id="tier3" value="tier 3"> Tier 3
        </div>
        <div class="col-md-3">
            <div id="chart"></div>
        </div>
        <div class="col-md-2 p-4">
            <h5><b>Data Classification</b></h5>
            
        </div>
        <div class="col-md-3">
            <div id="chart-container"></div>
        </div>
    </div>
    <div class="row mt-3">
        <table class="table table-bordered table-sm" cellspacing="0"
  width="100%">
            <thead>
                    <th>Name</th>
                    <th>Control ID</th>
                    <th>Control Title</th>
                    <th>Proposed Remediation </th>
                    <th>Completed Actions </th>
                    <th>ETA</th>
                    <th>Person In Charge </th>
                    <th>Remediation status</th>
                    <th>Initial Rating</th>
                    <th>POST Rating</th>
                </thead>
            <tbody>
                @foreach($remediation_plans as $plan)
                    <tr>
                    <td>
                        @if($plan->asset_name)
                            {{$plan->asset_name}}
                        @else
                            {{$plan->other_id}}
                        @endif
                    </td>
                    <td>{{$plan->control_id}}</td>
                    <td>{{$plan->question_short}}</td>
                    <td>
                        @if($plan->proposed_remediation)
                            {{$plan->proposed_remediation}}
                        @else
                            <span style="margin-left:47%;">--</span>
                        @endif
                    </td>
                    <td>
                        @if($plan->completed_actions)
                            {{$plan->completed_actions}}
                        @else
                            <span style="margin-left:47%;">--</span>
                        @endif
                    </td>
                    <td>
                        @if($plan->eta)
                            {{$plan->eta}}
                        @else
                            <span style="margin-left:47%;">--</span>
                        @endif
                    </td>
                    <td>{{$plan->user_name}}</td>
                    <td>
                        @if($plan->status == "0")
                            <span style="margin-left:47%;">--</span>
                        @else
                            {{$plan->status}}
                        @endif
                    </td>
                    @php
                        $check=DB::table('evaluation_rating')->where('id', $plan->rating)->first();
                    @endphp
                    <td style="background:{{$check->color}};color:{{$check->text_color}}">
                        {{$check->rating}}
                    </td>
                    <?php
                        $var = DB::table('evaluation_rating')->where('id', $plan->post_remediation_rating)->first();
                    ?>
                    <td style="background:<?php
                        if ($var) {
                            echo $var->color;
                        }
                        ?>; color:<?php
                        if ($var) {
                            echo $var->text_color;
                        }
                        ?>">
                    <?php
                        if ($var) {
                            echo $var->rating;
                        }
                        ?>
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- counts -->
<?php
// Assuming you have an array of data in your Laravel controller
$chartData = [
    ['Tier', 'Tier Value'],
];
$impData = [
    ['impact', 'Value'],
];
?>




<!-- jQuery -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    
    // First Chart 
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var chartData = @json($chartData);

        // Create an empty array to hold the dynamic data
        var dynamicData = [];

        // Add each row of data to the dynamicData array using a foreach loop
        chartData.forEach(function(row) {
            dynamicData.push(row);
        });

        // Create the data table using the dynamicData array
        var data = google.visualization.arrayToDataTable(dynamicData);

        var options = {
          title: 'Assets by Data Classification',
          titleTextStyle: { fontSize: 16 },
          pieHole: 0.5,
          backgroundColor: 'transparent',
          legend: 'none',
          chartArea: { left: 0, top: 40, width: '100%', height: '100%' }, // Add this line to remove margin and padding
          margin: 0, // Add this line to remove margin
          padding: 0 
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart'));
        chart.draw(data, options);
      }

    //   Second Charts
    google.charts.setOnLoadCallback(drawCharts);
      function drawCharts() {
        var chartData = @json($impData);

        // Create an empty array to hold the dynamic data
        var dynamicData = [];

        // Add each row of data to the dynamicData array using a foreach loop
        chartData.forEach(function(row) {
            dynamicData.push(row);
        });

        // Create the data table using the dynamicData array
        var data = google.visualization.arrayToDataTable(dynamicData);

        var options = {
          title: 'Assets by Impact',
          titleTextStyle: { fontSize: 16 },
          pieHole: 0.5,
          backgroundColor: 'transparent',
          legend: 'none',
          chartArea: { left: 0, top: 40, width: '100%', height: '100%' }, // Add this line to remove margin and padding
          margin: 0, // Add this line to remove margin
          padding: 0 
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart-container'));
        chart.draw(data, options);
      }


</script>
@endsection
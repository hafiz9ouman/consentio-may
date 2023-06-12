@extends('admin.client.client_app')
@section('page_title')
{{ __('Audit Report') }}
@endsection
@section('content')
<style>
    body{
        color:black;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <h4 style="color:black;"><b>{{$company->name}} {{$group[0]->group_name}} - Security Assessment</b></h4>
    </div>
    <input type="hidden" class="group_id"value="{{$group_id}}">
    <div class="row">
        <div class="col-md-3">
            <div id="chart"></div>
        </div>
        <div class="col-md-2 pt-4">
            <h5><b>Data Classification</b></h5>
            @php
                $existingUnits = [];
            @endphp
            @foreach ($remediation_plans as $subform => $plans)
                @if (count($plans) > 0)
                    @if (!in_array($plans[0]->classification_name_en, $existingUnits) && $plans[0]->classification_name_en!=null)
                        <input type="checkbox" id="checkbox-group" class="class-group change" value="{{$plans[0]->classification_name_en}}"> {{$plans[0]->classification_name_en}}<br>
                        @php
                            $existingUnits[] = $plans[0]->classification_name_en;
                        @endphp
                    @endif
                @endif
                
            @endforeach
        </div>
        <div class="col-md-1 pt-4">
            <h5><b>Impact</b></h5>
            @php
                $existingUnits = [];
                $counter = 1;
            @endphp
            @foreach ($remediation_plans as $subform => $plans)
                @if (count($plans) > 0)
                    @if($plans[0]->impact_name_en)
                        @if (!in_array($plans[0]->impact_name_en, $existingUnits) && $plans[0]->impact_name_en!=null)
                            <input type="checkbox" id="checkbox-group" class="impact-group change" value="{{$plans[0]->impact_name_en}}"> {{$counter}} - {{$plans[0]->impact_name_en}}<br>
                            @php
                                $existingUnits[] = $plans[0]->impact_name_en;
                                $counter++;
                            @endphp
                        @endif
                    @endif
                @endif
                
            @endforeach
        </div>
        <div class="col-md-3">
            <div id="chart-container"></div>
        </div>
        <div class="col-md-1 p-4">
            <h5><b>Hosting Location</b></h5>
            @php
                $existingUnits = [];
            @endphp
            @foreach ($remediation_plans as $subform => $plans)
                @if (count($plans) > 0)
                    @if (!in_array($plans[0]->country, $existingUnits) && $plans[0]->country!=null)
                        <input type="checkbox" id="checkbox-group" class="country-group change" value="{{$plans[0]->country}}"> {{$plans[0]->country}}<br>
                        @php
                            $existingUnits[] = $plans[0]->country;
                        @endphp
                    @endif
                @endif
                
            @endforeach
        </div>
        <div class="col-md-1 p-4">
            <h5><b>Business Owner</b></h5>
            @php
                $existingUnits = [];
            @endphp
            @foreach ($remediation_plans as $subform => $plans)
                @if (count($plans) > 0)
                    @if (!in_array($plans[0]->business_owner, $existingUnits) && $plans[0]->business_owner!=null)
                        <input type="checkbox" id="checkbox-group" class="business-group change" value="{{$plans[0]->business_owner}}"> {{$plans[0]->business_owner}}<br>
                        @php
                            $existingUnits[] = $plans[0]->business_owner;
                        @endphp
                    @endif
                @endif
                
            @endforeach
        </div>
        
    </div>
    <div class="row mt-3">
        <table class="table table-bordered table-sm" cellspacing="0"
        width="100%">
            <thead>
                <tr>
                    <th>Asset Name</th>
                    <th>Asset Tier</th>
                    @foreach($data as $question)
                        <th>C{{$loop->iteration}} - {{$question->question_short}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($remediation_plans as $subform => $plans)
                <tr>
                    @if (count($plans) > 0)
                            <td>{{$plans[0]->name}}</td>
                            <td>{{$plans[0]->tier}}</td>
                    @endif
                    
                    @foreach ($plans as $plan)
                        <td style="color:{{$plan->text_color}}; background-color:{{$plan->color}};">{{$plan->rating}}</td>
                    @endforeach
                </tr>
                @endforeach
                <!-- @foreach($remediation_plans as $plan)
                        {{-- <th style="color:{{$plan->text_color}}; background-color:{{$plan->color}};">{{$plan->rating}}</th> --}}
                @endforeach -->
            </tbody>
        </table>
    </div>
</div>

<!-- counts -->
<?php
// Assuming you have an array of data in your Laravel controller
$chartData = [
    ['Tier', 'Value'],
];
$impData = [
    ['hosting', 'Value'],
];
?>
@foreach ($remediation_plans as $subform => $plans)
    @if (count($plans) > 0 && isset($plans[0]->tier))
        @php
            $name = $plans[0]->tier;
            $datacount = 0;
        @endphp

        @foreach ($chartData as $entry)
            @if ($entry[0] == $name)
                @php
                    $datacount = $entry[1];
                    break;
                @endphp
            @endif
        @endforeach

        @if ($datacount == 0)
            @foreach ($remediation_plans as $count)
                @if (isset($count[0]->tier) && $name == $count[0]->tier)
                    @php
                        $datacount++;
                    @endphp
                @endif
            @endforeach
            @php
                $chartData[] = [$name, $datacount];
            @endphp
        @endif
    @endif
@endforeach

@foreach ($remediation_plans as $subform => $plans)
    @if (count($plans) > 0 && isset($plans[0]->hosting_type))
        @php
            $name = $plans[0]->hosting_type;
            $datacount = 0;
        @endphp

        @foreach ($chartData as $entry)
            @if ($entry[0] == $name)
                @php
                    $datacount = $entry[1];
                    break;
                @endphp
            @endif
        @endforeach

        @if ($datacount == 0)
            @foreach ($remediation_plans as $count)
                @if (isset($count[0]->hosting_type) && $name == $count[0]->hosting_type)
                    @php
                        $datacount++;
                    @endphp
                @endif
            @endforeach
            @php
                $impData[] = [$name, $datacount];
            @endphp
        @endif
    @endif
@endforeach



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
          title: 'Assets Tier',
          titleTextStyle: { fontSize: 16 },
          pieHole: 0.5,
          backgroundColor: 'transparent',
          is3D: true,
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
          title: 'Hosting Type',
          titleTextStyle: { fontSize: 16 },
          pieHole: 0.5,
          backgroundColor: 'transparent',
          is3D: true,
          chartArea: { left: 0, top: 40, width: '100%', height: '100%' }, // Add this line to remove margin and padding
          margin: 0, // Add this line to remove margin
          padding: 0 
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart-container'));
        chart.draw(data, options);
      }

    //   Other JS Code
$(document).ready(function() {
    // Listen for change event on checkboxes with class "checkbox-group"
    $(".change").change(function() {
        var classUnits = [];
        var impactUnits = [];
        var countryUnits = [];
        var businessUnits = [];
        var id= $(".group_id").val();
        // Iterate over each checkbox with class "checkbox-group" that is checked
        $(".class-group:checked").each(function() {
            // Add the value (business unit) to the selectedUnits array
            classUnits.push($(this).val());
        });
        $(".impact-group:checked").each(function() {
            // Add the value (business unit) to the selectedUnits array
            impactUnits.push($(this).val());
        });
        $(".country-group:checked").each(function() {
            // Add the value (business unit) to the selectedUnits array
            countryUnits.push($(this).val());
        });
        $(".business-group:checked").each(function() {
            // Add the value (business unit) to the selectedUnits array
            businessUnits.push($(this).val());
        });

        // Retrieve CSRF token from meta tag
        var token = $('meta[name="csrf-token"]').attr('content');

        // Make the AJAX call
        $.ajax({
            url: "/your-ajax-endpoints/" + id,
            method: "POST",
            data: {
                class: classUnits,
                impact: impactUnits,
                country: countryUnits,
                business: businessUnits,
                _token: token // Include the CSRF token in the data
            },
            dataType: "json",
            success: function(response) {
                // Handle the response from the server
                console.log(response);


                // Clear existing table rows except the first one (header row)
                $("tbody tr:not(:first)").remove();
                
                // Iterate over the response and append data to the table
                $.each(response, function(index, plan) {

                    if (plan.length === 0) {
                        return true; // Skip to the next iteration
                    }
                    // Create a new table row
                    var newRow = $("<tr>");

                    // Append table cells with data
                    newRow.append("<td>" + plan[0].name + "</td>");
                    newRow.append("<td>" + plan[0].tier + "</td>");

                    $.each(plan, function(key, plans) {
                        newRow.append("<td style='background:" + plans.color + "; color:" + plans.text_color + "'>" + plans.rating + "</td>");
                    });


                    // Append the new row to the tbody
                    $("tbody").append(newRow);
                });
            },

            error: function(xhr, status, error) {
                // Handle the error
                console.error(error);
            }
        });
    });
});


</script>
@endsection
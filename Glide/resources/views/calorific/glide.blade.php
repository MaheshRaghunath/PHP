<!DOCTYPE html>
<html>
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="{{url('/css/main.css')}}" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Data'],
          <?php echo $chart; ?>
        ]);

        var options = {
          title: 'Data Analysis'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
    </head>
    <body>
    <header class="py-3 mb-3 border-bottom">
        <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
        <div class="title"><a href="/">Glide</a></div>

            <div class="d-flex align-items-center">
                <form method="GET" action="/search" class="w-100 me-3 rightalign">
                    @csrf
                    <div class="searchBox"> 
                        <input style="width:75%" name="param" type="search" class="form-control" placeholder="Search..." aria-label="Search">
                        <button type="submit" class="btn btn-success">Search</button>
                    </div>
                </form>

                <div class="flex-shrink-0">
                    <a class="d-block link-dark text-decoration-none">
                        <img src="{{url('/image/profile.webp')}}" alt="mdo" width="32" height="32" class="rounded-circle">
                    </a>
                </div>
            </div>
        </div>
    </header>
        <div class="container-fluid pb-3">
            <div class="d-grid gap-3" style="grid-template-columns: 1fr 2fr;">
                <div class="bg-light border rounded-3">
                    <div>
                    <form method="POST" action="/storeData">
                    @csrf
                    <button type="submit" class="btn btn-primary">Get All Data to Store DB</button>
                    </form>
                    </div>
                    <div id="piechart" style="width: 500px; height: 500px;margin-top:40px;"></div>
                </div>
                <div class="bg-light border rounded-3">
                    <span class="message">{{ session('message') }}</span>
                    <form method="POST">
                    @csrf
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Applicable For</th>
                            <th scope="col">Area</th>
                            <th scope="col" >Value</th>
                            <th scope="col" colspan="2" style="text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $info)
                            <tr>
                                <th scope="row">{{ $info->id }}</th>
                                <td>{{ $info->applicable_for }}</td>
                                <td>{{ $info->Item }}</td>
                                <td>{{ $info->value }}</td>
                                <td><a class="btn btn-primary" href="/edit/{{ $info->id }}">Edit</a></td>
                                <td><a class="btn btn-danger" href="/distroy/{{ $info->id }}">Delete</a></td>
                            </tr>
                            @endforeach
                            @if (count($data) <= 0)
                            <tr><th style="text-align:center;color:#0c6dfd;" colspan="6" scope="row">No data found!</th></tr>
                            @endif
                        </tbody>
                    </table>
                    </form>
                </div>
            </div>
        </div>
        
    </body>
</html>
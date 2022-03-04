
<!DOCTYPE html>
<html>
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="{{url('/css/main.css')}}" rel="stylesheet">
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
                        <button type="button" class="btn btn-success">Search</button>
                    </div>
                </form>

                <div class="flex-shrink-0 dropdown">
                    <a class="d-block link-dark text-decoration-none">
                        <img src="{{url('/image/profile.webp')}}" alt="mdo" width="32" height="32" class="rounded-circle">
                    </a>
                </div>
            </div>
        </div>
    </header>
    
    <form method="POST" action="/saveData/{{ $editData->id }}">
        @csrf
        <div class="container col-lg-5 row justify-content-center" style="margin-left: 30%;margin-right: 30%;margin-top:100px;">
            <div class="mb-3">
                <label for="applicable" class="form-label">Applicable For</label>
                <input type="text" required class="form-control" name="applicable" id="applicable" value="{{ $editData->applicable_for }}" aria-describedby="applicable">
            </div>
            <div class="mb-3">
                <label for="values" class="form-label">Value</label>
                <input type="text" required class="form-control" name="values" id="values" aria-describedby="values" value="{{ $editData->value }}">
            </div>
            <div class="mb-3">
                <label for="area" class="form-label">Area</label>
                <input type="text" required name="area" class="form-control" id="area" aria-describedby="area" value="{{ $editData->Item }}">
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        
    </form>


    </body>
</html>
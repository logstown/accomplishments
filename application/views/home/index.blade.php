@layout('layouts.default')

@section('content')

  <div class="row-fluid">
    <div class="span7 margins">
      <h1 class="form-center">Welcome to Accomplishments!</h1>
      @if(Auth::check())
        <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sit amet lacus vitae tortor feugiat elementum sit amet quis urna. Nulla facilisi. Sed quis scelerisque nibh. Nunc neque diam, ornare vel ultrices eu, dictum sit amet enim. Sed aliquam, nibh ac laoreet dapibus, ipsum magna vehicula lacus, vel rhoncus ante tortor a nisi. Quisque dolor nisl, tincidunt varius pellentesque eget, dictum vel dui. Integer eu ante libero, eget interdum neque. Ut molestie tellus non nibh varius porta. Praesent posuere massa a risus consectetur nec posuere orci eleifend. Ut semper, nisi id aliquam viverra, ligula orci ultricies nunc, a suscipit arcu est et diam. In ut venenatis massa. Nullam ligula quam, porttitor et egestas congue, tincidunt sed metus. Etiam vehicula feugiat metus, sit amet luctus lorem pellentesque eu.</p>
        <p> Suspendisse vitae tortor tortor, eu faucibus mauris. Donec interdum, mauris at pretium feugiat, mauris est fringilla quam, nec luctus augue lacus et augue. Aliquam mauris sapien, aliquam id sagittis vel, scelerisque porttitor nisl. Morbi pretium, urna vitae condimentum lacinia, magna augue volutpat augue, ornare aliquet dolor nibh sit amet tortor. Pellentesque vestibulum eros quis sapien aliquet scelerisque. Duis facilisis leo in nulla mattis tempor. Sed malesuada turpis ut ante iaculis bibendum adipiscing purus vestibulum. Donec ut justo nunc, mattis tristique urna. Aliquam arcu lorem, gravida quis fermentum interdum, rhoncus vitae odio. Cras pretium porttitor lectus, ac consectetur arcu gravida in. Curabitur a semper elit. Praesent imperdiet lectus consequat metus mattis elementum. Quisque laoreet dictum gravida. Maecenas et ipsum libero, a viverra est. Pellentesque fringilla semper neque eget ultrices.</p>
        <p> Etiam lobortis, odio vitae auctor ultricies, mi eros suscipit libero, scelerisque porta neque lorem et mauris. Praesent id ligula sit amet elit semper vulputate sed vitae ipsum. Phasellus eget leo justo. Aliquam elementum malesuada facilisis. Nam eget purus ipsum, tristique vestibulum risus. Nam pulvinar turpis eget lectus fringilla ut cursus mi laoreet. Curabitur rhoncus faucibus ante vel elementum. Fusce nec lacus erat, a viverra dolor. Nullam justo turpis, volutpat vitae interdum fringilla, varius at turpis. Proin porttitor, felis vitae molestie sodales, ligula odio varius lorem, facilisis vehicula velit massa varius orci. Proin quis quam ac nulla fringilla bibendum sit amet et arcu. Ut commodo nisi sed purus porttitor quis accumsan massa ultricies. Praesent porta hendrerit massa, id convallis ligula laoreet a. Fusce commodo lorem cursus arcu tempor vitae adipiscing ligula pharetra. Suspendisse potenti. Vivamus tortor quam, lacinia sed dapibus a, fermentum vel neque.</p>
        Integer dui tortor, tincidunt eu varius ac, euismod quis ipsum. Sed pharetra quam turpis, nec aliquam nunc. Cras diam felis, volutpat ut volutpat ac, mollis et magna. In hac habitasse platea dictumst. Nunc pharetra est at nisi ullamcorper at luctus massa scelerisque. Suspendisse vel orci et tellus commodo congue. Nullam eleifend nisl a justo condimentum tristique. Donec scelerisque turpis urna, nec commodo sapien. Nullam nec iaculis eros. Vestibulum risus ante, varius vel egestas eget, interdum eget nibh. Sed ultrices cursus ipsum, at dignissim purus auctor vel. Sed convallis bibendum ante, sit amet aliquam augue venenatis et. Mauris adipiscing mauris at mauris ornare a pulvinar ipsum dapibus. Sed aliquam convallis erat, quis rhoncus orci sollicitudin et. Aliquam erat volutpat. In euismod, diam ut viverra semper, libero mi placerat dui, in eleifend mauris ante vel dui.
        <p> Curabitur sed varius est. Nulla ac bibendum dui. Integer luctus nibh sit amet est molestie eget euismod diam auctor. Mauris in placerat purus. Mauris at quam turpis, eu tempus est. Pellentesque nec ipsum augue, eu eleifend dolor. In sodales, odio vitae tincidunt vulputate, purus dolor dapibus massa, sed tincidunt ligula ante a nibh. In gravida iaculis orci, ac mollis ante rhoncus a. Suspendisse quam risus, suscipit a tincidunt nec, sollicitudin at purus. Nullam dictum, diam sit amet adipiscing facilisis, enim arcu egestas nibh, at volutpat felis diam eget purus. Praesent risus augue, placerat vel scelerisque at, placerat vitae risus. Praesent arcu mauris, malesuada vel dapibus nec, aliquam</p>
      @else
        <div id="buttons">
          <span class="butt">
            <input class="btn btn-large btn-success" type="button" value="Login" onclick="location.href='login'"></input>
          </span>
          <strong><em>or</em></strong>
          <span class="butt">
            <input class="btn btn-large btn-primary" type="button" value="Sign Up" onclick="location.href='register'"></input>
          </span>
        </div>
      @endif
    </div>

    <div class="span5">
      <table class="table table-striped">
        <caption>Recent Sentences added...</caption>
        <tbody>
          @foreach($sentences as $sentence)
            <tr>
              <td>
                <span class="text-info">{{ ucfirst($sentence['noun']) }}</span>
                is a
                <span class="text-warning">{{ $sentence['category'] }}</span>
                that
                <strong>{{ $sentence['user'] }}</strong>
                has
                <span class="text-error">{{ $sentence['verb'] }}</span>.
              </td>
              <td>
                <em>{{$sentence['time']}}</em>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <script type="text/javascript" src="http://www.google.com/jsapi"></script>

      <script type="text/javascript">

        google.load('visualization', '1', {packages: ['corechart']});

        <?php
          echo "var categories = ". json_encode($categories) . ";\n";
          echo "var verbs = ". json_encode($verbs) . ";\n";
          echo "var nouns = ". json_encode($nouns) . ";\n";
        ?>

        function drawVisualization() {
          // Create and populate the data table.
          var cat_chart = google.visualization.arrayToDataTable(categories);
          var verb_chart = google.visualization.arrayToDataTable(verbs);
          var noun_chart = google.visualization.arrayToDataTable(nouns);
        
          // Create and draw the visualization.
          new google.visualization.BarChart(document.getElementById('categories')).
              draw(cat_chart,
                   {title:"Most popular categories",
                    width:500, height:200,
                	  legend: 'none',
                	  colors: ['yellow'],
                	  hAxis: { textPosition: 'none', gridlines: {count: 2} }}
              );
          new google.visualization.BarChart(document.getElementById('verbs')).
              draw(verb_chart,
                   {title:"Most popular verbs",
                    width:500, height:200,
                	  legend: 'none',
                	  colors: ['red'],
                	  hAxis: { textPosition: 'none', gridlines: {count: 2} }}
              );
  		    new google.visualization.BarChart(document.getElementById('nouns')).
              draw(noun_chart,
                   {title:"Most popular nouns",
                    width:500, height:200,
                	  legend: 'none',
                	  colors: ['blue'],
                	  hAxis: { textPosition: 'none', gridlines: {count: 2} }}
              );
        }
        google.setOnLoadCallback(drawVisualization);
      </script>

      <div id="categories" class="center" style="width: 500px; height: 200px;"></div>
      <div id="verbs" class="center"style="width: 500px; height: 200px;"></div>
      <div id="nouns" class="center" style="width: 500px; height: 200px;"></div>
    </div>
  </div>

@endsection
@layout('layouts.default')

@section('content')
	<script type="text/javascript">

		//Variable declaration for future scripts
		var graph = <?php echo json_encode($graph) ?>;
		var user = "<?php echo htmlspecialchars($username) ?>";
		
		// Global data to hold collapsed Nodes' subnodes
		var globalData = [];
	    globalData['nodes'] = [];
	    globalData['edges'] = [];		

	</script>

	{{ HTML::script('/js/inflection.js') }}
	{{ HTML::script('/js/arbor.js') }}
	{{ HTML::script('/js/arbor-tween.js') }}
	{{ HTML::script('/js/graphics.js') }}
	{{ HTML::script('/js/renderer.js') }}

	<div id="graph" class="container-fluid">
		<canvas id="viewport"></canvas>
	</div>
	
	{{ HTML::script('/js/nodes.js') }}

@endsection

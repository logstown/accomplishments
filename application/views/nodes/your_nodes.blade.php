@layout('layouts.default')

@section('content')
	<script type="text/javascript">

		$('#noun').data('nholder',$('#noun').attr('placeholder'));
		$('#category').data('cholder',$('#category').attr('placeholder'));
		$('#verb').data('vholder',$('#verb').attr('placeholder'));

		$('#noun').focusin(function(){
		    $(this).attr('placeholder','');
		});
		$('#noun').focusout(function(){
		    $(this).attr('placeholder',$(this).data('nholder'));
		});

		$('#category').focusin(function(){
		    $(this).attr('placeholder','');
		});
		$('#category').focusout(function(){
		    $(this).attr('placeholder',$(this).data('cholder'));
		});

		$('#verb').focusin(function(){
		    $(this).attr('placeholder','');
		});
		$('#verb').focusout(function(){
		    $(this).attr('placeholder',$(this).data('vholder'));
		});

		var graph = <?php echo json_encode($graph) ?>;
		var user = "<?php echo htmlspecialchars($username) ?>";
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
	
	{{ HTML::script('/js/main.js') }}

@endsection

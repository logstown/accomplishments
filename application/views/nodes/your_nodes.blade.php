@layout('layouts.default')

@section('content')
	<div class="row-fluid">
		<div class="span4">
			<h2>{{ ucfirst($username) }} Accomplishments</h2>
		</div>
		<div class="span8">
			{{ Form::open('', 'POST', array('class' => 'form-inline'))}}

				{{ Form:: token() }}

				<span id="noun-control">
				{{ Form::label('noun','') }}
				<span id="controls">
				{{ Form::text('noun','',array('placeholder' => 'noun')) }}
		        </span>
		        </span>

				<span id="cat-control">
				{{ Form::label('category', 'is a') }}
				<span id="controls">
				{{ Form::text('category', '', array('placeholder' => 'category')) }}
				</span>
		        </span>

				<span id="verb-control">
				{{ Form::label('verb', 'that I have') }}
				<span id="controls">
				{{ Form::text('verb', '', array('placeholder' => 'verbed')) }}
		 		</span>
		        </span>

				{{ Form::submit('add') }}

			{{ Form::close() }}
		</div>
	</div>

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

		$(':text').keydown(function(){
			if ( $('#noun').val()) $('#noun-control').addClass('control-group success');
			else $('#noun-control').removeClass('control-group success');
		})


	var graph = <?php echo json_encode($graph) ?>;
	var user = "<?php echo htmlspecialchars($username) ?>";
	var globalData = [];

	</script>
	{{ HTML::script('/js/inflection.js') }}
	{{ HTML::script('/js/arbor.js') }}
	{{ HTML::script('/js/arbor-tween.js') }}
	{{ HTML::script('/js/graphics.js') }}
	{{ HTML::script('/js/renderer.js') }}
	<div class="container-fluid">
	<canvas id="viewport" width="1200" height="900"></canvas>
	</div>
	{{ HTML::script('/js/main.js') }}

@endsection
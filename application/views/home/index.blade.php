@layout('layouts.default')

@section('content')

<ul>
	@foreach($sentences as $sentence)
		<li>
			
			{{ ucfirst($sentence) }} 
			
		</li>
	@endforeach
</ul>	

<table>
	@foreach($categories as $category)
		<tr>
			
			<td>{{ ucfirst($category->word) }}</td> 
			<td>{{ ucfirst($category->word_count) }}</td> 
			
		</tr>
	@endforeach
</table>

<table>
	@foreach($verbs as $verb)
		<tr>
			
			<td>{{ ucfirst($verb->word) }}</td> 
			<td>{{ ucfirst($verb->word_count) }}</td> 
			
		</tr>
	@endforeach
</table>

<table>
	@foreach($nouns as $noun)
		<tr>
			
			<td>{{ ucfirst($noun->word) }}</td> 
			<td>{{ ucfirst($noun->word_count) }}</td> 
			
		</tr>
	@endforeach
</table>

@endsection
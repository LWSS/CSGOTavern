@if (Alert::whereArea('form')->get())
<div class="alert alert-danger">

	<div class="container-fluid">

		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

		{{ trans('message.check_form') }}

	</div>

</div>
@endif

@foreach (Alert::whereNotArea('form')->get() as $alert)
<div class="alert alert-{{ $alert->class }}">

	<div class="container-fluid">

		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

		{{ $alert->message }}

	</div>

</div>
@endforeach

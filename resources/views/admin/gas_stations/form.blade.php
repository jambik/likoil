<div class="form-group">
    {!! Form::label('name', 'Название') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('city', 'Местоположение') !!}
    {!! Form::text('city', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('address', 'Адрес') !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('phone', 'Телефон') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('lat', 'Широта (lat)') !!}
    {!! Form::text('lat', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('lng', 'Долгота (lng)') !!}
    {!! Form::text('lng', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('tags_service', 'Услуги') !!}
    {!! Form::text('tags_service', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('tags_fuel', 'Виды топлива') !!}
    {!! Form::text('tags_fuel', null, ['class' => 'form-control']) !!}
</div>

{{--<div class="form-group input-tags">
    {!! Form::label('tags_service', 'Услуги') !!}
    {!! Form::text('tags_service', isset($item) ? $item->tags_service_string : null, ['class' => '']) !!}
</div>

<div class="form-group input-tags">
    {!! Form::label('tags_fuel', 'Виды топлива') !!}
    {!! Form::text('tags_fuel', isset($item) ? $item->tags_fuel_string : null, ['class' => '']) !!}
</div>--}}

<div class="form-group text-center">
    <button type="submit" class="btn btn-lg btn-primary"><i class="material-icons">check_circle</i> {{ $submitButtonText }}</button>
</div>

<div class="text-center">
	<a href="{{ route('admin.gas_stations.index') }}" class="btn btn-default">Отмена</a>
</div>

@section('footer_scripts')
    {{--<script>
        var tags_service = [@foreach ($tags_service as $tag) {tag: "{{$tag}}" }, @endforeach];
        $(document).ready(function() {
            $('#tags_service').selectize({
                delimiter: ',',
                persist: false,
                valueField: 'tag',
                labelField: 'tag',
                searchField: 'tag',
                options: tags_service,
                create: function(input) {
                    return {
                        tag: input
                    }
                }
            });
        });

        var tags_fuel = [@foreach ($tags_fuel as $tag) {tag: "{{$tag}}" }, @endforeach];
        $(document).ready(function() {
            $('#tags_fuel').selectize({
                delimiter: ',',
                persist: false,
                valueField: 'tag',
                labelField: 'tag',
                searchField: 'tag',
                options: tags_fuel,
                create: function(input) {
                    return {
                        tag: input
                    }
                }
            });
        });
    </script>--}}
@endsection
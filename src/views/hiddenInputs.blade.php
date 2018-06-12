@isset($modelColumns)
    @foreach ($modelColumns as $modelColumn)
        <input name="current_{{$modelColumn->getName()}}" type="hidden" value="{{$modelColumn->currentValue}}">
    @endforeach
@endisset
@isset($hiddenInputs)
    @foreach ($hiddenInputs as $name => $value)
        <input name="{{$name}}" type="hidden" value="{{$value}}">
    @endforeach
@endisset

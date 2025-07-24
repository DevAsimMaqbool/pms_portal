<h5>{{ $form->title }}</h5>
<form method="POST" action="{{ route('forms.submit', $form->id) }}" enctype="multipart/form-data" class="row">
    @csrf
    <div class="row g-6">
        @foreach($form->fields as $field)
            @php
                $required = $field->required ? 'required' : '';
                $name = $field->name;
                $options = [];

                if (in_array($field->type, ['select', 'radio', 'checkbox'])) {
                    $decoded = json_decode($field->options, true);
                    $options = is_array($decoded) ? $decoded : explode(',', $field->options);
                    $options = array_map(fn($opt) => trim(trim($opt, '"')), $options);
                }
            @endphp
            <div class="col-md-6">
                <label class="d-block form-label">
                    {{ $field->label }}
                    @if($field->required)
                        <span class="text-red-500">*</span>
                    @endif
                </label>

                {{-- Dynamic field types --}}
                @switch($field->type)
                    @case('textarea')
                        <textarea name="{{ $name }}" class="form-control" rows="3" {{ $required }}></textarea>
                        @break

                    @case('select')
                        <select name="{{ $name }}" class="form-select" {{ $required }}>
                            <option value="">-- Select --</option>
                            @foreach($options as $opt)
                                <option value="{{ $opt }}">{{ $opt }}</option>
                            @endforeach
                        </select>
                        @break

                    @case('radio')
                        @foreach($options as $opt)
                            <div class="form-check mb-2">
                                <input type="radio" name="{{ $name }}" value="{{ $opt }}" class="form-check-input" {{ $required }} />
                                <label class="form-check-label">{{ $opt }}</label>
                            </div>
                        @endforeach
                        @break

                    @case('checkbox')
                        @foreach($options as $opt)
                            <div class="form-check">
                                <input type="checkbox" name="{{ $name }}[]" value="{{ $opt }}" class="form-check-input" {{ $required }} />
                                <label class="form-check-label">{{ $opt }}</label>
                            </div>
                        @endforeach
                        @break

                    @case('file')
                        <input type="file" name="{{ $name }}" class="form-control" {{ $required }}>
                        @break

                    @case('date')
                        <input type="date" name="{{ $name }}" class="form-control" {{ $required }}>
                        @break

                    @case('number')
                        <input type="number" name="{{ $name }}" class="form-control" {{ $required }}>
                        @break

                    @case('email')
                        <input type="email" name="{{ $name }}" class="form-control" {{ $required }}>
                        @break

                    @default
                        <input type="text" name="{{ $name }}" class="form-control" {{ $required }}>
                @endswitch
            </div>
        @endforeach
    </div>
    <!-- <div class="col-4 text-center demo-vertical-spacing mt-4">
        <button class="btn btn-primary w-100 waves-effect waves-light">Submit</button>
    </div> -->
</form>

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Form</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('forms.update', $form->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Form Title</label>
                <input type="text" name="title" class="form-control" value="{{ $form->title }}" required>
            </div>

            <div id="fields-wrapper">
                <h4>Fields</h4>

                @foreach ($form->fields as $i => $field)
                    @php
                        $options = '';
                        if (in_array($field->type, ['select', 'checkbox', 'radio']) && $field->options) {
                            $decodedOptions = json_decode($field->options, true);
                            $options = is_array($decodedOptions) ? implode(',', $decodedOptions) : '';
                        }
                    @endphp

                    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
                        <label>Label:</label>
                        <input name="fields[{{ $i }}][label]" value="{{ $field->label }}" required>

                        <label>Name:</label>
                        <input name="fields[{{ $i }}][name]" value="{{ $field->name }}" required>

                        <label>Type:</label>
                        <select name="fields[{{ $i }}][type]" onchange="handleTypeChange(event, {{ $i }})" required>
                            @foreach(['text', 'textarea', 'number', 'email', 'date', 'select', 'checkbox', 'radio', 'file'] as $type)
                                <option value="{{ $type }}" {{ $field->type == $type ? 'selected' : '' }}>{{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>

                        <div id="options-{{ $i }}"
                            style="{{ in_array($field->type, ['select', 'checkbox', 'radio']) ? '' : 'display:none;' }}">
                            <label>Options (comma separated):</label>
                            <input name="fields[{{ $i }}][options]" value="{{ $options }}">
                        </div>

                        <label>
                            <input type="checkbox" name="fields[{{ $i }}][required]" {{ $field->required ? 'checked' : '' }}>
                            Required
                        </label>
                    </div>
                @endforeach
            </div>

            <button type="button" onclick="addField()">+ Add Field</button>
            <br><br>
            <button type="submit" class="btn btn-primary">Update Form</button>
        </form>
    </div>

    <script>
        let fieldCount = {{ count($form->fields) }};

        function addField() {
            const wrapper = document.getElementById('fields-wrapper');
            const index = fieldCount++;

            const html = `
                    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
                        <label>Label:</label>
                        <input name="fields[${index}][label]" required>

                        <label>Name:</label>
                        <input name="fields[${index}][name]" required>

                        <label>Type:</label>
                        <select name="fields[${index}][type]" onchange="handleTypeChange(event, ${index})" required>
                            <option value="">Select</option>
                            <option value="text">Text</option>
                            <option value="textarea">Textarea</option>
                            <option value="number">Number</option>
                            <option value="email">Email</option>
                            <option value="date">Date</option>
                            <option value="select">Select</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="radio">Radio</option>
                            <option value="file">File</option>
                        </select>

                        <div id="options-${index}" style="display:none;">
                            <label>Options (comma separated):</label>
                            <input name="fields[${index}][options]">
                        </div>

                        <label>
                            <input type="checkbox" name="fields[${index}][required]"> Required
                        </label>
                    </div>
                `;

            wrapper.insertAdjacentHTML('beforeend', html);
        }

        function handleTypeChange(e, index) {
            const type = e.target.value;
            const optionsDiv = document.getElementById(`options-${index}`);
            if (['select', 'checkbox', 'radio'].includes(type)) {
                optionsDiv.style.display = 'block';
            } else {
                optionsDiv.style.display = 'none';
            }
        }
    </script>
@endsection
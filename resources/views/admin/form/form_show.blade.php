@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/tagify/tagify.css') }}" />
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Multi Column with Form Separator -->
        <div class="card">
            <div class="card-datatable table-responsive card-body">
                <h5>{{ $form->title }} </h5>
                <form method="POST" action="{{ route('forms.submit', $form->id) }}" enctype="multipart/form-data"
                    class="row">
                    @csrf
                    <div class="row g-6">
                    <input type="hidden" name="student_id" value="{{ $id }}">
                        @foreach($form->fields as $field)
                            @php
                                $required = $field->required ? 'required' : '';
                                $name = $field->name;
                                $options = [];

                                if (in_array($field->type, ['select', 'radio', 'checkbox'])) {
                                    $decoded = json_decode($field->options, true);
                                    $options = is_array($decoded)
                                        ? $decoded
                                        : explode(',', $field->options);

                                    // Trim whitespace and remove surrounding quotes from options
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
                                @if($field->type === 'textarea')
                                    <textarea name="{{ $name }}" class="form-control" rows="3" {{ $required }}></textarea>
                                @elseif($field->type === 'select')
                                    <select name="{{ $name }}" class="form-select" {{ $required }}>
                                        <option value="">-- Select --</option>
                                        @foreach($options as $opt)
                                            <option value="{{ $opt }}">{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                @elseif($field->type === 'radio')
                                    @foreach($options as $opt)
                                        <div class="form-check mb-2">
                                            <input type="radio" name="{{ $name }}" value="{{ $opt }}" class="form-check-input" {{ $required }} />
                                            <label class="form-check-label">{{ $opt }}</label>
                                        </div>
                                    @endforeach
                                @elseif($field->type === 'checkbox')
                                    @foreach($options as $opt)


                                        <div class="form-check">
                                            <input type="checkbox" name="{{ $name }}" class="form-check-input"
                                                id="bs-validation-checkbox" {{ $required }} />
                                            <label class="form-check-label" for="bs-validation-checkbox">{{ $opt }}</label>
                                            <div class="invalid-feedback">You must agree before submitting.</div>
                                        </div>
                                    @endforeach
                                @elseif($field->type === 'file')
                                    <input type="file" name="{{ $name }}" class="form-control" id="bs-validation-upload-file"
                                        class="w-full" {{ $required }}>
                                @elseif($field->type === 'date')
                                    <input type="date" name="{{ $name }}" class="form-control" name="{{ $required }}" />
                                @elseif($field->type === 'number')
                                    <input type="number" name="{{ $name }}" class="form-control" placeholder="Enter size" {{ $required }} />
                                @elseif($field->type === 'email')
                                    <input type="email" name="{{ $name }}" class="form-control w-100" placeholder="Email address" {{ $required }} />
                                @else($field->type === 'text')
                                    <input type="text" name="{{ $name }}" class="form-control w-100" {{ $required }} />
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <!-- <div class="col-4 text-center demo-vertical-spacing">
                        <button class="btn btn-primary w-100 waves-effect waves-light">Submit</button>
                    </div> -->
                </form>
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection
@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/popular.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/auto-focus.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/extended-ui-sweetalert2.js') }}"></script>

    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/tagify/tagify.js') }}"></script>
@endpush
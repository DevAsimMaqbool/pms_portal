@extends('layouts.app')
@push('style')
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/jstree/jstree.css') }}" />
@endpush
@section('content')
   <!-- Content -->
          <div class="container-xxl flex-grow-1 container-p-y">
  <div class="row gy-6">
 <!-- Basic -->
    <div class="col-md-12 col-12">
      <div class="card">
        <h5 class="card-header">{{ $area->performance_area }}</h5>
        <div class="card-body">
          <div id="jstree-basic">
            <ul>
            
                @foreach ($area->indicatorCategories as $category)
                    <li data-jstree='{"icon" : "icon-base ti tabler-graph"}'>
                        {{ $category->indicator_category }}
                        <ul>
                            @foreach ($category->indicators as $indicator)
                                <li data-jstree='{"icon" : "icon-base ti tabler-player-record"}'>{{ $indicator->indicator }}</li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
            <ul>
              
             
             
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- /Basic -->
  </div>
</div>
          <!-- / Content -->
@endsection
@push('script')
<script src="{{ asset('admin/assets/vendor/libs/jstree/jstree.js') }}"></script>
<script src="{{ asset('admin/assets/js/extended-ui-treeview.js') }}"></script>
@endpush
@push('scripts')
<script>
$(function() {
    let theme = $("html").attr("data-bs-theme") === "dark" ? "default-dark" : "default";
    let contextTree = $("#jstree-context-menu");

    if (contextTree.length) {
        contextTree.jstree({
            core: {
                themes: {
                    name: theme
                },
                check_callback: true,
                data: [
                    {
                        text: "css",
                        children: [
                            { text: "app.css", type: "css" },
                            { text: "style.css", type: "css" }
                        ]
                    },
                    {
                        text: "img",
                        state: { opened: true },
                        children: [
                            { text: "bg.jpg", type: "img" },
                            { text: "logo.png", type: "img" },
                            { text: "avatar.png", type: "img" }
                        ]
                    },
                    {
                        text: "js",
                        state: { opened: true },
                        children: [
                            { text: "jquery.js", type: "js" },
                            { text: "app.js", type: "js" }
                        ]
                    },
                    { text: "index.html", type: "html" },
                    { text: "page-one.html", type: "html" },
                    { text: "page-two.html", type: "html" }
                ]
            },
            plugins: ["types", "contextmenu"],
            types: {
                default: { icon: "icon-base ti tabler-folder" },
                html: { icon: "icon-base ti tabler-brand-html5 bg-danger" },
                css: { icon: "icon-base ti tabler-brand-css3 bg-info" },
                img: { icon: "icon-base ti tabler-photo bg-success" },
                js: { icon: "icon-base ti tabler-brand-javascript bg-warning" }
            }
        });
    }
});
</script>
@endpush

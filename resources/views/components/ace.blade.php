
<div {{ $attributes }}>
  
    <div id="{{ $id }}">{{ $slot }}</div>
    <input id="{{ $id }}value" type="hidden" value="{{ $slot }}" name="{{ $name }}">
</div>
@push('script')
    <script>
      
        function {{ $id }}_config() {
          
            var editor = ace.edit("{{ $id }}");
            editor.setTheme("ace/theme/monokai");
            editor.session.setMode("ace/mode/php");
            editor.session.on('change', function(delta) {
                $("#{{ $id }}value").val(editor.getValue());
            });
        }
        {{ $id }}_config();
    </script>
@endpush

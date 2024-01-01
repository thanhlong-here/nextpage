<div id="{{ $id }}" x-data="{{ $id }}()">

    <div {{ $attributes }} data-bs-toggle="modal" data-bs-target="#{{ $id }}edit">
        <pre class="preview">
            <code x-text="content"></code>
        </pre>
    </div>
    <div id="{{ $id }}edit" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog mt-0 modal-fullscreen">
            <div class="modal-content w-100 h-100">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fe fe-code"></i> Embed editor
                    </h5>

                    <div class="pull-right">


                        <button @click="save()" class="btn btn-sm btn-primary actsave">
                            <i class="fe fe-save"></i>
                            Save
                        </button>
                        <button @click="firm()" type="button" data-bs-dismiss="modal" class="btn-close">
                            <span aria-hidden="true">×</span>
                        </button>

                    </div>

                </div>
                <div class="modal-body">
                    <x-embed_edit :id="$id" :update="$update" :debug="$debug" :edit="$edit" :show="$show" :detect="$detect" ></x-embed_edit>
                </div>
            </div>
        </div>
    </div>
</div>


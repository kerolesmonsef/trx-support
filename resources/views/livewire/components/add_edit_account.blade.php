<div class="card">
    <div class="card-header">
        @if($group_id)
            تعديل المجموعة رقم {{ $group_id }}
        @else
            طلب جديد
        @endif
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group">
                <label>اسم المجموعة</label>
                <input type="text" class="form-control" wire:model.live="name" placeholder="اختياري">
            </div>

            <div class="form-group">
                <label>
                    اسم المستخدم / البريد الإلكتروني
                </label>
                <input type="text" class="form-control" wire:model.live="username">
            </div>
            <div class="form-group">
                <label>
                    كلمة المرور
                </label>
                <input type="text" class="form-control" wire:model.live="password">
            </div>
            <div class="form-group">
                <label>
                    الوصف
                </label>
                <div wire:ignore>
                    <textarea class="editor">{{ $description }}</textarea>
                </div>
                {{--                @livewire('trix', ['value' => $description])--}}
            </div>
            <div class="col-md-12">
                <h2 class="text-center">البروفايلات</h2>
                <div>
                    <button class="btn btn-sm btn-info" wire:click="addAccount()">
                        اضافة بروفايل
                    </button>
                </div>
                <div class="row">
                    @foreach($accounts_array as $key => $account)
                        <div class="col-md-4 mt-3">
                            <div class="card shadow-lg">
                                <div class="card-header">
                                    حساب {{ $key + 1 }}
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>
                                            رقم الطلب
                                            <input type="text" class="form-control"
                                                   wire:model.live="accounts_array.{{ $key }}.order_id">
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <label>
                                            رقم البروفايل
                                            <input type="text" class="form-control"
                                                   wire:model.live="accounts_array.{{ $key }}.profile">
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <label>
                                            أضافة حماية رقم هاتف
                                            <input type="text" class="form-control"
                                                   wire:model.live="accounts_array.{{ $key }}.secure_phone">
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            ملاحظة
                                            <input type="text" class="form-control"
                                                   wire:model.live="accounts_array.{{ $key }}.note">
                                        </label>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-sm btn-danger"
                                            wire:confirm="هل انت متأكد من المسح"
                                            wire:click="removeAccount({{ $key }})">حذف
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

            <div class="col-md-12 mt-1">
                <div>
                    <button class="btn btn-primary" wire:click="save">حفظ</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push("scripts")
{{--    <script>--}}
{{--           ClassicEditor--}}
{{--               .create(document.querySelector('.editor'))--}}
{{--               .then(editor => {--}}
{{--                   editor.model.document.on('change:data', () => {--}}
{{--                       const content = editor.getData();--}}

{{--                   @this.set('description', content);--}}
{{--                   });--}}
{{--               })--}}
{{--               .catch(error => {--}}
{{--                   console.error(error);--}}
{{--               });--}}


{{--        Livewire.on('reloadClassicEditor', () => {--}}
{{--           // here i want to reload the ckeditor please help me--}}
{{--        })--}}
{{--    </script>--}}

<script>
    let editorInstance; // Variable to store CKEditor instance

    // Function to create CKEditor instance
    function createEditor() {
        return ClassicEditor
            .create(document.querySelector('.editor'))
            .then(editor => {
                // Assign the editor instance to the variable
                editorInstance = editor;

                // Listen for changes in the editor content
                editor.model.document.on('change:data', handleEditorChange);
            })
            .catch(error => {
                console.error(error);
            });
    }

    // Function to handle editor content changes
    function handleEditorChange() {
        const content = editorInstance.getData();
        @this.set('description', content);
    }

    // Function to reload CKEditor instance
    function reloadEditor(content = '') {
        // Check if the CKEditor instance exists
        if (editorInstance) {
            // Destroy the CKEditor instance
            editorInstance.destroy().then(() => {
                // Recreate CKEditor instance
                createEditor().then(()=>{
                    editorInstance.setData(content);
                });
            });
        }
    }

    // Create CKEditor instance when the page loads
    createEditor();

    // Listen for the 'reloadClassicEditor' event
    Livewire.on('reloadClassicEditor', (content)=>{
        reloadEditor(content?.[0])
    });
</script>

@endpush
